<?php
/**
 * WP-CLI command to remove the supporter posts other forms created.
 *
 * @see https://linear.app/a8c/issue/T51ENG-2307
 * @package osi
 */

if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
	return;
}

/**
 * Class OSI_Supporter_Cleanup_Command
 */
class OSI_Supporter_Cleanup_Command extends WP_CLI_Command {

	/**
	 * Trashes, or deletes, anonymous, never-edited supporter posts with no endorsement type, link or logo, in batches.
	 *
	 * ## OPTIONS
	 *
	 * [--dry-run=<bool>]
	 * : Report what would be removed without removing it. Pass --dry-run=false to remove.
	 * ---
	 * default: 'true'
	 * ---
	 *
	 * [--force]
	 * : Delete permanently instead of moving to the trash.
	 *
	 * [--trashed]
	 * : Target matching supporter posts already in the trash. Use with --force to purge them.
	 *
	 * [--newest-first]
	 * : Work from the highest ID down, e.g. to remove a test submission with --limit=1.
	 *
	 * [--batch-size=<number>]
	 * : Posts per batch.
	 * ---
	 * default: 100
	 * ---
	 *
	 * [--limit=<number>]
	 * : Stop after this many posts (0 = no limit).
	 * ---
	 * default: 0
	 * ---
	 *
	 * [--sleep=<seconds>]
	 * : Pause between batches.
	 * ---
	 * default: 2
	 * ---
	 *
	 * [--yes]
	 * : Skip the confirmation prompt on a real run.
	 *
	 * ## EXAMPLES
	 *
	 *     wp osi-supporter-cleanup
	 *     wp osi-supporter-cleanup --limit=10 --dry-run=false
	 *     wp osi-supporter-cleanup --dry-run=false --yes | tee supporter-cleanup.log
	 *     wp osi-supporter-cleanup --trashed --force --dry-run=false
	 *     wp osi-supporter-cleanup --newest-first --limit=1 --dry-run=false
	 *
	 * @param array $args       Positional arguments.
	 * @param array $assoc_args Associative arguments.
	 *
	 * @return void
	 */
	public function __invoke( array $args, array $assoc_args ): void {
		$dry_run    = ! in_array( strtolower( (string) $assoc_args['dry-run'] ), array( 'false', '0', 'no', '' ), true );
		$force      = ! empty( $assoc_args['force'] );
		$status     = empty( $assoc_args['trashed'] ) ? 'pending' : 'trash';
		$desc       = ! empty( $assoc_args['newest-first'] );
		$batch_size = max( 1, absint( $assoc_args['batch-size'] ) );
		$limit      = absint( $assoc_args['limit'] );
		$sleep      = absint( $assoc_args['sleep'] );
		$verb       = ( $dry_run ? 'would be ' : '' ) . ( $force ? 'deleted' : 'trashed' );

		$this->log( sprintf( '%s %s posts.', $dry_run ? 'DRY RUN on' : ( $force ? 'DELETING' : 'TRASHING' ), $status ) );

		if ( ! $dry_run ) {
			WP_CLI::confirm( sprintf( '%s supporter posts from other forms%s?', $force ? 'Permanently delete' : 'Trash', $limit ? " (limit {$limit})" : '' ), $assoc_args );
			wp_defer_term_counting( true );
		}

		$limit     = $limit ? $limit : PHP_INT_MAX;
		$processed = 0;
		$failed    = 0;
		$last_id   = $desc ? PHP_INT_MAX : 0;

		while ( $processed + $failed < $limit ) {
			$ids = $this->get_candidates( $status, $last_id, min( $batch_size, $limit - $processed - $failed ), $desc );
			if ( empty( $ids ) ) {
				break;
			}
			$last_id = end( $ids );

			foreach ( $ids as $id ) {
				if ( ! $dry_run && ! ( $force ? wp_delete_post( $id, true ) : wp_trash_post( $id ) ) ) {
					++$failed;
					WP_CLI::warning( sprintf( 'Failed on %d.', $id ) );
					continue;
				}
				++$processed;
			}

			$this->log( sprintf( '%d %s so far, %s MB in use. IDs: %s', $processed, $verb, number_format( memory_get_usage() / MB_IN_BYTES, 1 ), implode( ',', $ids ) ) );

			if ( wp_cache_supports( 'flush_runtime' ) ) {
				wp_cache_flush_runtime();
			}
			if ( $sleep ) {
				sleep( $sleep );
			}
		}

		if ( ! $dry_run ) {
			wp_defer_term_counting( false );
		}

		if ( $failed ) {
			$this->log( sprintf( 'Failed: %d', $failed ) );
		}
		WP_CLI::success( sprintf( '%d supporter posts from other forms %s.', $processed, $verb ) );
	}

	/**
	 * Fetch the next batch of anonymous, never-edited supporter IDs with no endorsement type, link or logo.
	 * The endorsement form always sends a type, so a submission without one came from another form.
	 *
	 * @param string  $status  Post status to search.
	 * @param integer $last_id Fetch IDs past this one.
	 * @param integer $size    Batch size.
	 * @param boolean $desc    Highest IDs first.
	 *
	 * @return int[]
	 */
	private function get_candidates( string $status, int $last_id, int $size, bool $desc ): array {
		global $wpdb;

		// Two literal queries, because ORDER BY can't take a placeholder.
		if ( $desc ) {
			$ids = $wpdb->get_col(
				$wpdb->prepare(
					"SELECT p.ID FROM {$wpdb->posts} p
					WHERE p.post_type = 'supporter' AND p.post_status = %s AND p.post_author = 0 AND p.ID < %d
					AND NOT EXISTS (
						SELECT 1 FROM {$wpdb->postmeta} m WHERE m.post_id = p.ID
						AND m.meta_key IN ( 'endorsement_type', 'link', '_thumbnail_id', '_edit_last' ) AND TRIM( m.meta_value ) NOT IN ( '', '0' )
					)
					ORDER BY p.ID DESC LIMIT %d",
					$status,
					$last_id,
					$size
				)
			);
		} else {
			$ids = $wpdb->get_col(
				$wpdb->prepare(
					"SELECT p.ID FROM {$wpdb->posts} p
					WHERE p.post_type = 'supporter' AND p.post_status = %s AND p.post_author = 0 AND p.ID > %d
					AND NOT EXISTS (
						SELECT 1 FROM {$wpdb->postmeta} m WHERE m.post_id = p.ID
						AND m.meta_key IN ( 'endorsement_type', 'link', '_thumbnail_id', '_edit_last' ) AND TRIM( m.meta_value ) NOT IN ( '', '0' )
					)
					ORDER BY p.ID ASC LIMIT %d",
					$status,
					$last_id,
					$size
				)
			);
		}

		if ( $wpdb->last_error ) {
			WP_CLI::error( $wpdb->last_error );
		}

		return array_map( 'intval', $ids );
	}

	/**
	 * Log a line with a UTC timestamp, so a teed run doubles as a record.
	 *
	 * @param string $message Message.
	 *
	 * @return void
	 */
	private function log( string $message ): void {
		WP_CLI::log( sprintf( '[%s UTC] %s', gmdate( 'Y-m-d H:i:s' ), $message ) );
	}
}

WP_CLI::add_command( 'osi-supporter-cleanup', 'OSI_Supporter_Cleanup_Command' );

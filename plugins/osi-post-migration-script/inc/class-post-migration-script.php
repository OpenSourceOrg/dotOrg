<?php

use Osi\Features\Inc\Post_Types\Post_Type_Board_Member;
use Osi\Features\Inc\Post_Types\Post_Type_License;
use Osi\Features\Inc\Post_Types\Post_Type_Meeting_Minutes;
use Osi\Features\Inc\Taxonomies\Taxonomy_Seat_Type;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Post_Migration_Script {

	private $taxonomies = [
		'status' => [
			'Board Member',
			'Alumni',
			'Running Candidate',
			'Past Candidate'
		],
		'seat-type' => [
			'Appointed',
			'Affiliate',
			'Individual'
		],
		'license-category' => [
			'Uncategorized',
			'International',
			'Popular / Strong Community',
			'Redundant with more popular',
			'Special purpose',
			'Superseded',
			'Non-reusable',
			'Voluntarily retired',
			'Other/Miscellaneous'
		]
	];

	private $slug = 'post-migration-script';

	public function __construct()
	{
		$this->setup_hooks();
		
	}
	
	public function setup_hooks() {
		add_action( 'admin_menu', [ $this, 'add_submenu' ] );
	}

	/**
	 * Adds a submenu page under a custom post type parent.
	 */
	public function add_submenu() {
		add_submenu_page(
			'tools.php',
			__( 'Post Migration Script', 'textdomain' ),
			__( 'Post Migration Script', 'textdomain' ),
			'manage_options',
			$this->slug,
			[ $this, 'submenu_callback' ]
		);
	}
	 
	/**
	 * Display callback for the submenu page.
	 */
	public function submenu_callback() { 
		// Check whether the button has been pressed AND also check the nonce
		if ( isset($_POST['submit']) ) {
			if ( check_admin_referer('migration_start')) {
				// the button has been pressed AND we've passed the security check
				$this->form_action();
			}
		}
		?>
		<div class="wrap">
			<h1><?php _e( 'Post Migration Script', 'textdomain' ); ?></h1>
			<p><?php _e( 'Once the migration is done, click the below button to make sure the data is migrated to the relevant CPTs.', 'textdomain' ); ?></p>
			<form action="tools.php?page=<?php echo $this->slug; ?>" method="post">
				<?php wp_nonce_field('migration_start'); ?>
				<input type="hidden" value="true" name="submit" />
				<?php submit_button('Call Function'); ?>
			</form>
	
	
		</div>
		<?php
	}
	
	public function form_action() {
		$this->invoke();
		?>
		<div class="notice notice-success is-dismissible">
			<p><?php _e('Post Migration complete', 'textdomain') ?></p>
		</div>
		<?php
	}

	public function invoke() {

		$this->log( 'Creating terms...' );
		$this->create_terms();

		$this->log( 'Copying old fields to new ones...' );
		$this->convert_radio_to_taxonomy();

		$this->log( 'Copying License from ACF to Post Body...' );
		$this->copy_license_contents_to_body();
		
		$this->log( 'Migrating Meeting Minutes...' );
		$this->migrate_meeting_minutes();
		
		$this->log( 'Migrating Licenses...' );
		$this->migrate_licenses();

		$this->log( 'Migrating Board Directors...' );		
		$this->migarte_board_directors();
    }

	protected function migrate_meeting_minutes() {
		$post_args = [
			'post_type'   => 'page',
			'numberposts' => -1,
			'post_status' => 'all',
			's' => 'Minutes'
		];
		
		$pages = get_posts( $post_args );
		foreach ($pages as $page ) {
			$page_title = strtolower( $page->post_title );
			if ( 
				! str_contains( $page_title, 'list' ) // The post is not a list of meeting minutes.
				&& str_contains( $page_title, 'minutes' )
				|| str_contains( $page_title, 'face-to-face' ) 
				|| str_contains( $page_title, 'feburary' ) // This one post is an outlier that didn't follow the naming patterns.
			) {
				$page->post_type = Post_Type_Meeting_Minutes::get_instance()->get_slug();
				$status = wp_update_post( $page, true );

				if ( is_wp_error( $status ) ) {
					$this->error( "Post '$page_title' cannot be updated." );
				} else {
					$this->success( "Post '$page_title' updated." );
				}
			}
		}
	}

	protected function migrate_licenses() {
		// The only License collection without the word 'licenses' in the title. 
		$post_title       = 'GNU General Public License';
		$page             = get_page_by_title( $post_title );

		if ( ! empty( $page ) ) {
			$page->post_title = str_replace( 'License', 'Licenses', $post_title );
			$status           = wp_update_post( $page, true );

			if ( is_wp_error( $status ) ) {
				$this->error( "Post '$post_title' cannot be updated." );
			} else {
				$this->success( "Post '$post_title' updated." );
			}
		}

		$parent_post = get_page_by_title( 'Licenses & Standards' );
		$posts = get_children( $parent_post->ID );

		foreach ( $posts as $post ) {
			if ( 'page' != $post->post_type || str_contains( $post->post_title, 'Licenses' ) ) {
				$this->error( $post->post_title . ' Skipped' );
				continue;
			}
			set_post_type( $post->ID, Post_Type_License::get_instance()->get_slug() );
			$this->success( $post->post_title . ' - Post type updated' );
		}
	}

	protected function migarte_board_directors() {
		$post_args = [
			'post_type'   => Post_Type_Board_Member::get_instance()->get_slug(),
			'numberposts' => -1,
			'post_status' => 'all'
		];
		
		$directors = get_posts( $post_args );
		
		foreach ( $directors as $director ) {
			$result = set_post_type( $director->ID, Post_Type_Board_Member::get_instance()->get_slug() );
			if ( $result ) {
				$this->success( $director->post_title . ' Post type changed.' );
			} else {
				$this->error( $director->post_title . ' - failed to change.' );
			}
		}
	}

	public function convert_radio_to_taxonomy() {
		$post_types = [
			Post_Type_Board_Member::get_instance()->get_slug()
		];
		
		$args = array( 
			'numberposts' => -1,
			'post_type'   => $post_types,
			'orderby'     => 'title',
			'order'       => 'ASC',
			'post_status' => 'all'
		);

		$posts = get_posts( $args );

		foreach ( $posts as $post ) {
			$type = intval( get_field( 'type_of_seat', $post->ID ) );
			if ( ! in_array( $type, [ 1, 2 ], true ) ) {
				$this->error( $post->post_title . 'Doesn\'t have a seat type.' );
				continue;
			}
			
			$slug = sanitize_title( $this->taxonomies[ 'seat-type' ][ $type ] );
			$term = get_term_by( 'slug', $slug, Taxonomy_Seat_Type::SLUG );
			update_field( 'type_of_seat_tax', $term->term_id, $post->ID );
			$this->success( 'Set seat type - ' . $slug . ' for ' . $post->post_title );
		}
	}

	public function copy_license_contents_to_body() {
		$args = array( 
			'numberposts' => -1,
			'post_type'   => Post_Type_License::get_instance()->get_slug(),
			'orderby'     => 'title',
			'order'       => 'ASC',
			'post_status' => 'all'
		);

		$posts = get_posts( $args );

		foreach ( $posts as $post ) {
			$html = get_field( 'license_text_html_', $post->ID );
			if ( empty( $html ) ) {
				continue;
			}

			$post->post_content = $html;
			$status = wp_update_post( $post, true );
			if( is_wp_error( $status ) ) {
				$this->error( 'Failed - ' . $post->post_title );
			} else {
				$this->success( 'Updated - ' . $post->post_title );
			}
		}
	}

	public function create_terms() {
		foreach ( $this->taxonomies as $taxonomy => $terms ) {
			$taxonomy = 'taxonomy-' . $taxonomy;
			if ( taxonomy_exists( $taxonomy ) ) {
				foreach ($terms as $term ) {
					$created = wp_insert_term( $term, $taxonomy );
					if ( is_wp_error( $created ) ) {
						$this->error( $term . ' - ' . $created->get_error_message() );
					} else {
						$this->success( $term . ' added.' );
					}
				}
			}
		}
	}

	/**
	 * Helper methods.
	 */
	public function log( $text ) {
		echo '<p><b>Notice: </b>' . esc_html( $text ) . '</p>';
	}

	public function success( $text ) {
		echo '<p><b>Success: </b>' . esc_html( $text ) . '</p>';
	}
		
	public function error( $text ) {
		echo '<p><b>Error: </b>' . esc_html( $text ) . '</p>';
	}
}

new Post_Migration_Script();

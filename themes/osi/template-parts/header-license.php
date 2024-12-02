<header class="entry-header cover--header no-thumbnail">
	<div class="wp-block-cover alignfull has-neutral-dark-background-color has-background-dim-100 has-background-dim">
		<div class="wp-block-cover__inner-container">
			<div class="wp-block-columns">
				<div class="wp-block-column" style="flex-basis: 70%">
					<span class="pill-taxonomy">
						<?php
						/**
						 * The licenses/ represents the base page url for the license
						 */
						echo wp_kses_post( osi_get_single_taxonomy_terms_query( $post, 'taxonomy-license-category', 'licenses/', '?categories=' ) );
						?>
					</span>
					<?php the_title( '<h1 class="entry-title page--title">', '</h1>' ); ?>
					<p class="license-meta">
						<?php
						if ( osi_field_check( 'version' ) ) :
							echo wp_kses_post( '<span class="license-version">' . __( 'Version', 'osi' ) . ' ' );
							osi_the_valid_field( 'version' );
							echo wp_kses_post( '</span>' );
						endif;
						if ( osi_field_check( 'release_date' ) ) :
							echo wp_kses_post( '<span class="license-release">' . __( 'Submitted', 'osi' ) . ': ' );
							if ( osi_field_check( 'submission_url' ) ) {
								echo wp_kses_post( '<a href="' . esc_url( osi_get_valid_field( 'submission_url' ) ) . '" target="_blank">' );
							}
							osi_the_valid_date_field( 'release_date' );
							if ( osi_field_check( 'submission_url' ) ) {
								echo wp_kses_post( '</a>' );
							}
							echo wp_kses_post( '</span>' );
						endif;
						if ( osi_field_check( 'submitter' ) ) :
							echo wp_kses_post( '<span class="license-submitter">' . __( 'Submitter', 'osi' ) . ': ' );
							osi_the_valid_field( 'submitter' );
							echo wp_kses_post( '</span>' );
						endif;
						if ( osi_field_check( 'approval_date' ) ) :
							echo wp_kses_post( '<span class="license-approved">' . __( 'Approved', 'osi' ) . ': ' );
							osi_the_valid_date_field( 'approval_date' );
							echo wp_kses_post( '</span>' );
						endif;

						$board_minutes = osi_get_valid_field( 'link_to_board_minutes' );
						if ( ! empty( $board_minutes['url'] ) ) :
							?>
							<span class="license-board-minutes">
								<a href="<?php echo esc_url( $board_minutes['url'] ); ?>">
									<?php esc_html_e( 'Board minutes', 'osi' ); ?>
								</a>
							</span>
							<?php
						endif;

						$spdx_identifier = osi_get_valid_field( 'spdx_identifier' );
						if ( ! empty( $spdx_identifier['display_text'] ) ) :
							?>
							<span class="license-spdx">
								<?php esc_html_e( 'SPDX short identifier', 'osi' ); ?>:
								<?php echo esc_html( $spdx_identifier['display_text'] ); ?>
							</span>
						<?php endif; ?>
					</p>
					<?php $license_steward_meta = osi_get_valid_field( 'license_steward_version' ); ?>
					<?php if ( has_term( '', 'taxonomy-steward' ) || ! empty( $license_steward_meta['url'] ) ) : ?>
						<div class="license-steward-meta">
							<?php if ( has_term( '', 'taxonomy-steward' ) ) : ?>
								<span class="license-steward"><?php echo esc_html__( 'Steward:', 'osi' ) . wp_kses_post( osi_get_single_taxonomy_terms_links( $post, 'taxonomy-steward' ) ); ?></span>
							<?php endif; ?>
							<?php if ( ! empty( $license_steward_meta['url'] ) ) : ?>
								<span class="license-steward-url">
									<a href="<?php echo esc_url( $license_steward_meta['url'] ); ?>" target="_blank">
										<?php esc_html_e( 'Link to license steward\'s version', 'osi' ); ?>
									</a>
								</span>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
				<div class="wp-block-column" style="flex-basis: 30%; text-align: center;">
					<img width="200" src="/wp-content/themes/osi/assets/img/osi-badge-light.svg" alt="<?php esc_html_e( 'Open Source Initiative Approved License', 'osi' ); ?>">
				</div>
			</div>
		</div>
	</div>
</header>

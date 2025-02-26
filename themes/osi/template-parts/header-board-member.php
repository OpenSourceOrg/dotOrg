<header class="entry-header cover--header no-thumbnail">
	<div class="wp-block-cover alignfull has-neutral-dark-background-color has-background-dim-100 has-background-dim">
		<div class="wp-block-cover__inner-container">
			<div class="wp-block-columns">
				<div class="wp-block-column three-column">
					<?php get_template_part( 'template-parts/featured-image', 'cropped' ); ?>
					<h1 class="h2"><?php get_the_title(); ?></h1>
					<?php if( osi_field_check( 'pronouns' ) ) : ?>
						<span class="member-pronouns"><?php osi_the_valid_field( 'pronouns' ); ?></span>
					<?php endif; ?>
					<?php if( osi_field_check( 'board_position' ) ) : ?>
						<span class="member-position">
							<?php osi_the_valid_field( 'board_position' ); ?>
						</span>
					<?php endif; ?>
				</div>
				<div class="wp-block-column">
					<span class="pill-taxonomy">
						<?php echo wp_kses_post( osi_get_single_taxonomy_terms_links( $post, 'taxonomy-status' ) ); ?>
					</span>
					<?php if( osi_field_check( 'proposed_by' ) ) : ?>
						<p><?php echo __( 'Proposed by', 'osi' ); ?>: <span class="member-pronouns"><?php osi_the_valid_field( 'proposed_by' ); ?></span></p>
					<?php endif; ?>
					<?php if( osi_field_check( 'current_term_start_date' ) ) : ?>
						<span class="member-dates">
							<?php 
							echo __( 'Candidacy Period', 'osi' ) . ': ';
							osi_the_valid_date_field( 'current_term_start_date' );
							if( osi_field_check( 'current_term_end_date' ) ) :
								echo ' – ';
								osi_the_valid_date_field( 'current_term_end_date' );
							endif;
							?>
						</span>
					<?php endif; ?>
					<span class="member-seat inline-list">
						<?php echo __( 'Type of Seat', 'osi' ) . ': ' . wp_kses_post( osi_get_single_taxonomy_terms_links( $post, 'taxonomy-seat-type' ) ); ?>
					</span>
				</div>
			</div>
		</div>
	</div>
</header>

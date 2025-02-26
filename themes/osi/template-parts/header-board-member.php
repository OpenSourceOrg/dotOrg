<header class="entry-header cover--header no-thumbnail">
	<div class="wp-block-cover alignfull has-neutral-dark-background-color has-background-dim-100 has-background-dim">
		<div class="wp-block-cover__inner-container">
			<div class="wp-block-columns">
				<!-- Left Column -->
				<div class="wp-block-column" style="text-align: center;">
					<?php if (has_post_thumbnail()) : ?>
						<div class="member-image">
							<?php the_post_thumbnail('full', array('class' => 'circular-image')); ?>
						</div>
					<?php endif; ?>
					
					<h1><?php echo get_the_title(); ?></h1>
					
					<?php if(osi_field_check('pronouns')) : ?>
						<span class="member-pronouns"><?php osi_the_valid_field('pronouns'); ?></span>
					<?php endif; ?>
				</div>

				<!-- Right Column -->
				<div class="wp-block-column">
					<span class="pill-taxonomy">
						<?php echo wp_kses_post( osi_get_single_taxonomy_terms_links( $post, 'taxonomy-status' ) ); ?>
					</span>
					<?php if( osi_field_check( 'proposed_by' ) ) : ?>
						<p><?php echo __( 'Proposed by', 'osi' ); ?>: <span class="member-pronouns"><?php osi_the_valid_field( 'proposed_by' ); ?></span></p>
					<?php endif; ?>
					<?php if(osi_field_check('board_position')) : ?>
						<span class="member-position">
							<?php osi_the_valid_field('board_position'); ?>
						</span>
					<?php endif; ?>

					<?php if(osi_field_check('current_term_start_date')) : ?>
						<span class="member-dates">
							<?php 
							echo __('Candidacy Period', 'osi') . ': ';
							osi_the_valid_date_field('current_term_start_date');
							if(osi_field_check('current_term_end_date')) :
								echo ' – ';
								osi_the_valid_date_field('current_term_end_date');
							endif;
							?>
						</span>
					<?php endif; ?>

					<span class="member-seat">
						<?php echo __('Type of Seat', 'osi') . ': ' . wp_kses_post(osi_get_single_taxonomy_terms_links($post, 'taxonomy-seat-type')); ?>
					</span>

					<!-- Add back the term item -->
					<?php if(osi_field_check('term_item')) : ?>
						<span class="member-term-item">
							<?php osi_the_valid_field('term_item'); ?>
						</span>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</header>

<style>
.member-image {
	margin-bottom: 1.5rem;
}
.member-image img.circular-image {
	border-radius: 50%;
	border: 4px solid #FFF;
	width: 300px; /* adjust as needed */
	height: 300px;
	object-fit: cover;
}
.member-position,
.member-dates,
.member-seat,
.member-term-item {
	display: block;
	margin-bottom: 1rem;
}
.member-pronouns {
	font-family: 'Space Mono', monospace;
	display: inline-block;
}
</style>

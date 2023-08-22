<?php
if ( has_post_thumbnail() ) : ?>
	<section class="osi-list--image">
		<a aria-hidden="true" tabindex="-1" href="<?php the_permalink(); ?>">
			<figure class="post--thumbnail" >
				<?php the_post_thumbnail( 'medium_large' ); ?>
			</figure>
		</a>
	</section>
<?php endif; ?>

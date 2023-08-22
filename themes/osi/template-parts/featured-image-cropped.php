<?php
global $archive_type;

if ( has_post_thumbnail() ) : ?>
	<section class="osi-list--image">
		<a aria-hidden="true" tabindex="-1" href="<?php the_permalink(); ?>">
			<figure class="post--thumbnail cropped has-background-image" style="background-image:url(<?php the_post_thumbnail_url( 'medium_large' ); ?>)"></figure>
			<p class="screen-reader-text"><?php the_title(); ?></p>
		</a>
	</section>
<?php endif; ?>

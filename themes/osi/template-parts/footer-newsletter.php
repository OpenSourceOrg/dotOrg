<?php
/**
 * Newsletter section in the footer, edited at Appearance > Block Patterns.
 *
 * @package osi
 */

$newsletter_pattern = get_page_by_path( 'newsletter-subscribe', OBJECT, 'coblocks_pattern' );

if ( $newsletter_pattern && 'publish' === $newsletter_pattern->post_status ) : ?>
	<section class="footer-newsletter">
		<div class="footer--inner">
			<?php echo do_shortcode( do_blocks( $newsletter_pattern->post_content ) ); ?>
		</div>
	</section>
<?php endif; ?>

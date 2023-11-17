<?php
/**
 * The template for displaying the footer
 *
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package osi
 */

$footerclass = is_active_sidebar( 'sidebar-footer' ) ? 'widgetized-footer footer--widgets' : 'standard-footer';
?>

		<footer id="colophon" class="footer site-footer" role="contentinfo">
			<?php if ( is_active_sidebar( 'sidebar-footer-cta' ) ) : ?>	
				<div class="footer--inner">
					<section class="footer-cta">
						<div class="wp-block-columns">
							<?php dynamic_sidebar( 'sidebar-footer-cta' ); ?>
						</div>
					</section>
				</div>
			<?php endif; ?>
			<section class="footer-main">
				<div class="footer--inner">
					<div class="<?php echo esc_attr( $footerclass ); ?> wp-block-columns alignwide">
						<?php dynamic_sidebar( 'sidebar-footer' ); ?>
					</div>
				</div>
			</section>
			<section class="footer-credits">
				<div class="footer--inner">
					<div class="widgetized-footer footer--widgets wp-block-columns alignwide">
					<?php dynamic_sidebar( 'sidebar-footer-secondary' ); ?>
						<div class="wp-block-column">
							<p class="footer--extra-text">
							<?php
							if ( is_active_sidebar( 'footer-above-credits' ) ) {
								dynamic_sidebar( 'footer-above-credits' );
							}
							?>
								<?php do_action( 'osi_credits' ); ?>
							</p><!-- .powered-by-wordpress -->
						</div>
					</div>
				</div>
			</section>
		</footer><!-- #colophon -->

	</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
<?php
/**
 * The template for displaying the footer
 * Custom version for the AI template
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package osi
 */

$footer_block_id = create_or_find_ai_footer_block_content();
?>

	<footer id="colophon" class="footer site-footer ai-footer" role="contentinfo">
		<?php echo do_shortcode( do_blocks( '<!-- wp:block {"ref":' . absint( $footer_block_id ) . '} /-->' ) ); ?>
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
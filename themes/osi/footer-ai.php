<?php
/**
 * The template for displaying the footer
 * Custom version for the AI template
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package osi
 */

use WpOrg\Requests\Exception\Http;

$footer_block = <<<HTML
<!-- wp:group {"className":"os-awesome-feedbacak ai-pre-footer","style":{"elements":{"link":{"color":{"text":"var:preset|color|brand-color-1"}}}},"backgroundColor":"neutral-dark","textColor":"neutral-white","layout":{"type":"constrained","contentSize":"100%"},"noBottomMargin":true,"padding":"no"} -->
<div class="wp-block-group os-awesome-feedbacak ai-pre-footer has-neutral-white-color has-text-color has-background has-link-color mb-0"><!-- wp:group {"layout":{"type":"flex","orientation":"vertical","justifyContent":"center"},"padding":"no"} -->
<div class="wp-block-group"><!-- wp:columns {"className":"ai-footer-top wide","style":{"layout":{"selfStretch":"fill","flexSize":null},"spacing":{"margin":{"top":"32px","bottom":"32px"}}}} -->
<div class="wp-block-columns ai-footer-top wide" style="margin-top:32px;margin-bottom:32px"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:image {"id":25020,"width":"270px","sizeSlug":"large","linkDestination":"none","align":"center"} -->
<figure class="wp-block-image aligncenter size-large is-resized"><img src="https://opensource.gq/wp-content/uploads/2025/04/osi-horizontal-white.svg" alt="" class="wp-image-25020" style="width:270px"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button {"textColor":"neutral-white","className":"is-style-spin-green","style":{"elements":{"link":{"color":{"text":"var:preset|color|neutral-white"}}}}} -->
<div class="wp-block-button is-style-spin-green"><a class="wp-block-button__link has-neutral-white-color has-text-color has-link-color wp-element-button">Join us</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:shortcode -->
[jetpack-social]
<!-- /wp:shortcode --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:columns {"className":"ai-footer-bottom wide"} -->
<div class="wp-block-columns ai-footer-bottom wide"><!-- wp:column {"width":"30%"} -->
<div class="wp-block-column" style="flex-basis:30%"><!-- wp:heading {"level":5} -->
<h5 class="wp-block-heading">The Open Source Initiative</h5>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>The OSI is the authority that defines Open Source, recognized globally by individuals, companies, and by public institutions.</p>
<!-- /wp:paragraph -->

<!-- wp:shortcode -->
[jetpack-social]
<!-- /wp:shortcode --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"20%"} -->
<div class="wp-block-column" style="flex-basis:20%"><!-- wp:heading {"level":5} -->
<h5 class="wp-block-heading">About</h5>
<!-- /wp:heading -->

<!-- wp:list -->
<ul class="wp-block-list"><!-- wp:list-item -->
<li><a href="https://opensource.org/about">About Us</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="https://opensource.org/about/team">Our team</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="https://opensource.org/associations">Associations</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="https://opensource.org/sponsors">Sponsors</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="https://opensource.org/articles-of-incorporation">Articles of Incorporation</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="https://opensource.org/bylaws">Bylaws</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="https://opensource.org/history">History</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="https://opensource.org/trademark-guidelines">Trademark Guidelines</a></li>
<!-- /wp:list-item --></ul>
<!-- /wp:list --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"20%"} -->
<div class="wp-block-column" style="flex-basis:20%"><!-- wp:heading {"level":5} -->
<h5 class="wp-block-heading">Licenses</h5>
<!-- /wp:heading -->

<!-- wp:list -->
<ul class="wp-block-list"><!-- wp:list-item -->
<li><a href="https://opensource.org/osd">Open Source Definition</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="https://opensource.org/licenses">Licenses</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="https://opensource.org/licenses/review-process">License Review Process</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="https://opensource.org/osr">Open Standards Requirement for Software</a></li>
<!-- /wp:list-item --></ul>
<!-- /wp:list --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"20%"} -->
<div class="wp-block-column" style="flex-basis:20%"><!-- wp:heading {"level":5} -->
<h5 class="wp-block-heading">Board</h5>
<!-- /wp:heading -->

<!-- wp:list -->
<ul class="wp-block-list"><!-- wp:list-item -->
<li><a href="https://opensource.org/about/board-of-directors">Board of Directors</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="https://opensource.org/minutes">Minutes</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="https://opensource.org/about/board-of-directors/elections">Elections</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="https://opensource.org/organization">Organization &amp; Operations</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="https://opensource.org/conflict_of_interest_policy">Conflict of Interest Policy</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="https://opensource.org/board/board-member-agreement">Board member agreement</a></li>
<!-- /wp:list-item --></ul>
<!-- /wp:list --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
HTML;
?>

		<footer id="colophon" class="footer site-footer ai-footer" role="contentinfo">
			<?php echo do_shortcode( do_blocks( $footer_block ) ); ?>
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

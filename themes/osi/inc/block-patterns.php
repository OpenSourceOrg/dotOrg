<?php

/**
 * Block Patterns for the OSI theme.
 *
 * @package OSI
 */

/**
 * Create the base AI footer reusable block programmatically.
 *
 * @return integer
 */
function osi_create_or_find_ai_footer_block_content(): int {
	$title = 'OSI AI Footer';
	$slug  = sanitize_title( $title );

	// Check if block already exists
	$existing = get_page_by_path( $slug, OBJECT, 'wp_block' );
	if ( $existing ) {
		return $existing->ID;
	}

	$image_url = get_template_directory_uri() . '/assets/img/osi-horizontal-white.svg';

	// Compile the block markup for the footer
	$block_content = <<<HTML
<!-- wp:group {"className":"os-awesome-feedbacak ai-pre-footer","style":{"elements":{"link":{"color":{"text":"var:preset|color|brand-color-1"}}}},"backgroundColor":"neutral-dark","textColor":"neutral-white","layout":{"type":"constrained","contentSize":"100%"},"noBottomMargin":true,"padding":"no"} -->
<div class="wp-block-group os-awesome-feedbacak ai-pre-footer has-neutral-white-color has-text-color has-background has-link-color mb-0"><!-- wp:group {"layout":{"type":"flex","orientation":"vertical","justifyContent":"center"},"padding":"no"} -->
<div class="wp-block-group"><!-- wp:columns {"className":"ai-footer-top wide","style":{"layout":{"selfStretch":"fill","flexSize":null},"spacing":{"margin":{"top":"32px","bottom":"32px"}}}} -->
<div class="wp-block-columns ai-footer-top wide" style="margin-top:32px;margin-bottom:32px"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:image {"id":25020,"width":"270px","sizeSlug":"large","linkDestination":"none","align":"center"} -->
<figure class="wp-block-image aligncenter size-large is-resized"><img src="$image_url" alt="" class="wp-image-25020" style="width:270px"/></figure>
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
<li><a href="https://opensource.org/about"><span class="dashicons dashicons-arrow-right-alt2"></span>About Us</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="https://opensource.org/about/team"><span class="dashicons dashicons-arrow-right-alt2"></span>Our team</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="https://opensource.org/associations"><span class="dashicons dashicons-arrow-right-alt2"></span>Associations</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="https://opensource.org/sponsors"><span class="dashicons dashicons-arrow-right-alt2"></span>Sponsors</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="https://opensource.org/articles-of-incorporation"><span class="dashicons dashicons-arrow-right-alt2"></span>Articles of Incorporation</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="https://opensource.org/bylaws"><span class="dashicons dashicons-arrow-right-alt2"></span>Bylaws</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="https://opensource.org/history"><span class="dashicons dashicons-arrow-right-alt2"></span>History</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="https://opensource.org/trademark-guidelines"><span class="dashicons dashicons-arrow-right-alt2"></span>Trademark Guidelines</a></li>
<!-- /wp:list-item --></ul>
<!-- /wp:list --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"20%"} -->
<div class="wp-block-column" style="flex-basis:20%"><!-- wp:heading {"level":5} -->
<h5 class="wp-block-heading">Licenses</h5>
<!-- /wp:heading -->

<!-- wp:list -->
<ul class="wp-block-list"><!-- wp:list-item -->
<li><a href="https://opensource.org/osd"><span class="dashicons dashicons-arrow-right-alt2"></span>Open Source Definition</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="https://opensource.org/licenses"><span class="dashicons dashicons-arrow-right-alt2"></span>Licenses</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="https://opensource.org/licenses/review-process"><span class="dashicons dashicons-arrow-right-alt2"></span>License Review Process</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="https://opensource.org/osr"><span class="dashicons dashicons-arrow-right-alt2"></span>Open Standards Requirement for Software</a></li>
<!-- /wp:list-item --></ul>
<!-- /wp:list --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"20%"} -->
<div class="wp-block-column" style="flex-basis:20%"><!-- wp:heading {"level":5} -->
<h5 class="wp-block-heading">Board</h5>
<!-- /wp:heading -->

<!-- wp:list -->
<ul class="wp-block-list"><!-- wp:list-item -->
<li><a href="https://opensource.org/about/board-of-directors"><span class="dashicons dashicons-arrow-right-alt2"></span>Board of Directors</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="https://opensource.org/minutes"><span class="dashicons dashicons-arrow-right-alt2"></span>Minutes</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="https://opensource.org/about/board-of-directors/elections"><span class="dashicons dashicons-arrow-right-alt2"></span>Elections</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="https://opensource.org/organization"><span class="dashicons dashicons-arrow-right-alt2"></span>Organization &amp; Operations</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="https://opensource.org/conflict_of_interest_policy"><span class="dashicons dashicons-arrow-right-alt2"></span>Conflict of Interest Policy</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="https://opensource.org/board/board-member-agreement"><span class="dashicons dashicons-arrow-right-alt2"></span>Board member agreement</a></li>
<!-- /wp:list-item --></ul>
<!-- /wp:list --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
HTML;

	$post_id = wp_insert_post(
		array(
			'post_title'   => $title,
			'post_name'    => $slug,
			'post_type'    => 'wp_block',
			'post_status'  => 'publish',
			'post_content' => $block_content,
		)
	);

	return $post_id;
}

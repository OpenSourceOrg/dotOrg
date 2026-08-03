<?php
/**
 * Class OSI_Megamenu_Walker
 *
 * @package osi
 */

/**
 * Nav walker for the primary menu: prepends a section header (eyebrow + tagline)
 * inside the panel of top-level items carrying the `megamenu` class, and appends
 * a featured-content card when one is selected on the item (see megamenu-featured.php).
 * Tagline and featured fields are editable in Appearance > Menus.
 */
class OSI_Megamenu_Walker extends Walker_Nav_Menu {

	/**
	 * The top-level megamenu item whose panel is being rendered, or null outside one.
	 *
	 * @var WP_Post|null
	 */
	private $current_parent = null;

	/**
	 * Resolved featured content (post + heading) for the current panel, if any.
	 *
	 * @var array|null
	 */
	private $current_featured = null;

	/**
	 * Start element output; remembers the current top-level item.
	 *
	 * @param string        $output Used to append additional content (passed by reference).
	 * @param WP_Post       $item   Menu item data object.
	 * @param integer       $depth  Depth of menu item.
	 * @param stdClass|null $args   An object of wp_nav_menu() arguments.
	 * @param integer       $id     Optional. ID of the current menu item. Default 0.
	 *
	 * @return void
	 */
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) { // phpcs:ignore Squiz.Commenting.FunctionComment.ScalarTypeHintMissing,Squiz.Commenting.FunctionComment.TypeHintMissing -- typing params on a Walker_Nav_Menu override is a fatal signature mismatch; parent is untyped.
		if ( 0 === $depth ) {
			$is_panel               = $this->has_children && in_array( 'megamenu', (array) $item->classes, true );
			$this->current_parent   = $is_panel ? $item : null;
			$this->current_featured = $is_panel ? osi_megamenu_featured( $item ) : null;

			if ( null !== $this->current_featured ) {
				$item->classes[] = 'has-featured';
			}
		}
		parent::start_el( $output, $item, $depth, $args, $id );
	}

	/**
	 * Start sub-menu output; adds the section header row for mega menu panels.
	 *
	 * @param string        $output Used to append additional content (passed by reference).
	 * @param integer       $depth  Depth of menu item.
	 * @param stdClass|null $args   An object of wp_nav_menu() arguments.
	 *
	 * @return void
	 */
	public function start_lvl( &$output, $depth = 0, $args = null ) { // phpcs:ignore Squiz.Commenting.FunctionComment.ScalarTypeHintMissing -- typing params on a Walker_Nav_Menu override is a fatal signature mismatch; parent is untyped.
		parent::start_lvl( $output, $depth, $args );

		if ( 0 !== $depth || null === $this->current_parent ) {
			return;
		}

		$title = apply_filters( 'the_title', $this->current_parent->title, $this->current_parent->ID );

		$output .= '<li class="megamenu-header">';
		$output .= '<span class="megamenu-eyebrow">' . esc_html( $title ) . '</span>';

		if ( ! empty( $this->current_parent->description ) ) {
			$output .= '<p class="megamenu-tagline">' . esc_html( $this->current_parent->description ) . '</p>';
		}

		$output .= '</li>';
	}

	/**
	 * End sub-menu output; appends the featured card column for mega menu panels.
	 *
	 * @param string        $output Used to append additional content (passed by reference).
	 * @param integer       $depth  Depth of menu item.
	 * @param stdClass|null $args   An object of wp_nav_menu() arguments.
	 *
	 * @return void
	 */
	public function end_lvl( &$output, $depth = 0, $args = null ) { // phpcs:ignore Squiz.Commenting.FunctionComment.ScalarTypeHintMissing -- typing params on a Walker_Nav_Menu override is a fatal signature mismatch; parent is untyped.
		if ( 0 === $depth && null !== $this->current_featured ) {
			$output .= $this->get_featured_card();
		}
		parent::end_lvl( $output, $depth, $args );
	}

	/**
	 * Build the featured card markup.
	 *
	 * The image is lazy (else core hands it the page's fetchpriority=high slot),
	 * built with wp_get_attachment_image because the theme's thumbnail filter
	 * strips the width/height a lazy image needs, and the excerpt is read raw
	 * because get_the_excerpt runs the_content filters in the header.
	 *
	 * @return string
	 */
	private function get_featured_card() {
		$featured = $this->current_featured['post'];
		$excerpt  = '' !== $featured->post_excerpt ? $featured->post_excerpt : strip_shortcodes( mb_substr( $featured->post_content, 0, 2000 ) );
		$excerpt  = wp_trim_words( $excerpt, 18, '...' );

		$card  = '<li class="megamenu-featured">';
		$card .= '<span class="megamenu-featured--heading">' . esc_html( $this->current_featured['heading'] ) . '</span>';
		$card .= '<a class="megamenu-featured--card" href="' . esc_url( get_permalink( $featured ) ) . '">';
		$card .= wp_get_attachment_image(
			(int) get_post_thumbnail_id( $featured ),
			'medium',
			false,
			array(
				'class'   => 'megamenu-featured--image',
				'loading' => 'lazy',
			)
		);
		$card .= '<span class="megamenu-featured--title">' . esc_html( get_the_title( $featured ) ) . '</span>';

		if ( '' !== $excerpt ) {
			$card .= '<span class="megamenu-featured--excerpt">' . esc_html( $excerpt ) . '</span>';
		}

		$card .= '</a></li>';

		return $card;
	}
}

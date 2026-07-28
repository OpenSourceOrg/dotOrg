<?php
/**
 * Class OSI_Megamenu_Walker
 *
 * @package osi
 */

/**
 * Nav walker for the primary menu: prepends a section header (eyebrow + tagline)
 * inside the panel of top-level items carrying the `megamenu` class. The tagline
 * comes from the menu item's Description field, editable in Appearance > Menus.
 */
class OSI_Megamenu_Walker extends Walker_Nav_Menu {

	/**
	 * The top-level item whose sub-menu is currently being rendered.
	 *
	 * @var WP_Post|null
	 */
	private $current_parent = null;

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
			$this->current_parent = $item;
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

		if ( 0 !== $depth || null === $this->current_parent || ! in_array( 'megamenu', (array) $this->current_parent->classes, true ) ) {
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
}

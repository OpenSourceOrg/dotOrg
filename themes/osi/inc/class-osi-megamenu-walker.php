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
	 * Direct-child counts keyed by menu item ID.
	 *
	 * @var array
	 */
	private $child_counts = array();

	/**
	 * Zero-based position of the next item within the panel being rendered.
	 *
	 * @var integer
	 */
	private $panel_index = 0;

	/**
	 * Walk the tree, counting each item's children first.
	 *
	 * @param array   $elements  Menu items to walk.
	 * @param integer $max_depth Depth limit.
	 * @param mixed   ...$args   Arguments passed through to the element handlers.
	 *
	 * @return string
	 */
	public function walk( $elements, $max_depth, ...$args ) { // phpcs:ignore Squiz.Commenting.FunctionComment.ScalarTypeHintMissing,Squiz.Commenting.FunctionComment.TypeHintMissing -- typing params on a Walker override is a fatal signature mismatch; parent is untyped.
		$this->child_counts = array_count_values( array_column( $elements, 'menu_item_parent' ) );

		add_filter( 'nav_menu_item_attributes', array( $this, 'add_panel_placement' ), 10, 4 );

		try {
			return parent::walk( $elements, $max_depth, ...$args );
		} finally {
			remove_filter( 'nav_menu_item_attributes', array( $this, 'add_panel_placement' ), 10 );
		}
	}

	/**
	 * Place a panel item in its column, filling column one before column two.
	 *
	 * Auto-placement cannot do this: the featured card has to span past the explicit rows
	 * to stay out of their sizing, and column flow would then fill that whole span before
	 * wrapping (@see T51ENG-2081).
	 *
	 * @param array    $atts      HTML attributes for the menu item's li.
	 * @param WP_Post  $menu_item Menu item data object.
	 * @param stdClass $args      An object of wp_nav_menu() arguments.
	 * @param integer  $depth     Depth of menu item.
	 *
	 * @return array
	 */
	public function add_panel_placement( array $atts, WP_Post $menu_item, stdClass $args, int $depth ): array {
		if ( 1 !== $depth || null === $this->current_parent || 'primary_navigation' !== ( $args->theme_location ?? '' ) ) {
			return $atts;
		}

		// two columns, matching grid-template-columns in _6_components.navigation--subnav.scss.
		$rows   = (int) ceil( $this->child_counts[ $this->current_parent->ID ] / 2 );
		$column = intdiv( $this->panel_index, $rows ) + 1;
		$row    = ( $this->panel_index % $rows ) + 2;
		++$this->panel_index;

		$atts['style'] = ltrim( rtrim( $atts['style'] ?? '', '; ' ) . ';grid-column:' . $column . ';grid-row:' . $row, ';' );

		return $atts;
	}

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
			$this->panel_index      = 0;

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
			$output .= $this->get_featured_card( isset( $args->theme_location ) && 'primary_navigation' === $args->theme_location );
		}
		parent::end_lvl( $output, $depth, $args );
	}

	/**
	 * Build the featured card markup.
	 *
	 * The image is skipped in the mobile menu (its card design has no image), lazy
	 * elsewhere (else core hands it the page's fetchpriority=high slot), and built
	 * with wp_get_attachment_image because the theme's thumbnail filter strips the
	 * width/height a lazy image needs. The excerpt fallback is read raw because
	 * get_the_excerpt runs the_content filters in the header.
	 *
	 * @param boolean $with_image Whether to render the thumbnail.
	 *
	 * @return string
	 */
	private function get_featured_card( bool $with_image ) {
		$featured = $this->current_featured['post'];
		$link     = $this->current_featured['link'];
		$text     = $this->current_featured['text'];
		$title    = get_the_title( $featured );

		if ( '' === $text ) {
			$text = '' !== $featured->post_excerpt ? $featured->post_excerpt : strip_shortcodes( mb_substr( $featured->post_content, 0, 2000 ) );
			$text = wp_trim_words( $text, 18, '...' );
		}

		$more_attrs = '';

		if ( $link['url'] === $this->current_featured['permalink'] ) {
			/* translators: 1: link label, 2: featured item title. */
			$more_attrs = ' aria-label="' . esc_attr( sprintf( __( '%1$s: %2$s', 'osi' ), $link['label'], $title ) ) . '"';
		}

		$card  = '<li class="megamenu-featured">';
		$card .= '<a class="megamenu-featured--card" href="' . esc_url( $this->current_featured['permalink'] ) . '">';

		if ( $with_image ) {
			$card .= wp_get_attachment_image(
				(int) get_post_thumbnail_id( $featured ),
				'large',
				false,
				array(
					'class'   => 'megamenu-featured--image',
					'loading' => 'lazy',
				)
			);
		}

		$card .= '<span class="megamenu-featured--heading">' . esc_html( $this->current_featured['heading'] ) . '</span>';
		$card .= '<span class="megamenu-featured--title">' . esc_html( $title ) . '</span>';

		if ( '' !== $text ) {
			$card .= '<span class="megamenu-featured--excerpt">' . esc_html( $text ) . '</span>';
		}

		$card .= '</a>';
		$card .= '<a class="megamenu-featured--more" href="' . esc_url( $link['url'] ) . '"' . ( $link['target'] ? ' target="_blank" rel="noopener noreferrer"' : '' ) . $more_attrs . '>' . esc_html( $link['label'] ) . '</a>';
		$card .= '</li>';

		return $card;
	}
}

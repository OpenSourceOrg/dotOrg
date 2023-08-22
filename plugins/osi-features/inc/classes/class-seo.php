<?php
/**
 * Class for SEO related stuff.
 *
 * @package osi-features
 */

namespace Osi\Features\Inc;

use Osi\Features\Inc\Traits\Singleton;

/**
 * Class SEO
 */
class SEO {

	use Singleton;

	/**
	 * Construct method.
	 */
	protected function __construct() {

		$this->setup_hooks();

	}

	/**
	 * To setup action/filter.
	 *
	 * @return void
	 */
	protected function setup_hooks() {}

	/**
	 * To meta tag by given property
	 *
	 * @param array $attrs List attribute that needed in meta tag.
	 *
	 * @return bool True on success otherwise False.
	 */
	public function render_meta_tag( $attrs ) {

		if ( empty( $attrs ) || ! is_array( $attrs ) || empty( $attrs['content'] ) ) {
			return false;
		}

		echo '<meta ';
		foreach ( $attrs as $key => $value ) {
			printf( '%s="%s" ', esc_attr( $key ), esc_attr( $value ) );
		}
		echo ' />' . "\n";

		return true;
	}

}

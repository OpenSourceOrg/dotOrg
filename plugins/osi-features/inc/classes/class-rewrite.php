<?php
/**
 * Rewrite class.
 *
 * @package osi-features
 */

namespace Osi\Features\Inc;

use Osi\Features\Inc\Traits\Singleton;

/**
 * Class Rewrite
 */
class Rewrite {

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
	protected function setup_hooks() {
		add_filter( 'query_vars', array( $this, 'add_query_vars' ), 10 );
	}

	public function add_query_vars( $vars ) {
		$vars[] = 'categories';

		return $vars;
	}

}

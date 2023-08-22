<?php
/**
 * Determines whether or not to display the sidebar based on an array of conditional tags or page templates.
 *
 * If any of the is_* conditional tags or is_page_template(template_file) checks return true, the sidebar will NOT be displayed.
 *
 * @param array list of conditional tags (http://codex.wordpress.org/Conditional_Tags)
 * @param array list of page templates. These will be checked via is_page_template()
 *
 * @return boolean True will display the sidebar, False will not
 */
class Osi_Sidebar {
	private $conditionals;
	private $templates;

	public $display = false; // set to false to hide sidebar and apply full width class

	public function __construct( $conditionals = array(), $templates = array() ) {
		$this->conditionals = $conditionals;
		$this->templates    = $templates;

		$conditionals = array_map( array( $this, 'check_conditional_tag' ), $this->conditionals );
		$templates    = array_map( array( $this, 'check_page_template' ), $this->templates );

		if ( in_array( true, $conditionals, true ) || in_array( true, $templates, true ) ) {
			$this->display = true;
		}

		if ( is_page_template() && ! in_array( true, $templates, true ) ) {
			$this->display = false;
		}

	}

	private function check_conditional_tag( $conditional_tag ) {
		if ( is_array( $conditional_tag ) ) {
			$conditions = $conditional_tag[1];
			return call_user_func( $conditional_tag[0], $conditions );
		} else {
			return call_user_func( $conditional_tag, '' );
		}
	}

	private function check_page_template( $page_template ) {
		return is_page_template( $page_template );
	}
}

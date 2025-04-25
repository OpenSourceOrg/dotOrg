<?php
/**
 * Register Articles post type.
 *
 * @package osi-features
 */

namespace Osi\Features\Inc\Post_Types;

/**
 * Class Post_Type_Meeting_Minutes
 */
class Post_Type_Press_Mentions extends Base {

	/**
	 * Slug of post type.
	 *
	 * @var string
	 */
	const SLUG = 'press-mentions';

	/**
	 * Post type label for internal uses.
	 *
	 * @var string
	 */
	const LABEL = 'Press mentions';

	/**
	 * Initialize the class and set up hooks
	 */
	public function init() {
		\add_action( 'add_meta_boxes', array( $this, 'register_custom_fields' ) );
		\add_action( 'save_post_' . self::SLUG, array( $this, 'save_custom_fields' ), 10, 2 );
		\add_action( 'rest_api_init', array( $this, 'register_rest_fields' ) );
	}

	/**
	 * To get list of labels for post type.
	 *
	 * @return array
	 */
	public function get_labels() {

		return array(
			'name'               => __( 'Press mentions', 'osi-features' ),
			'singular_name'      => __( 'Press mentions', 'osi-features' ),
			'all_items'          => __( 'Press mentions', 'osi-features' ),
			'add_new'            => __( 'Add New', 'osi-features' ),
			'add_new_item'       => __( 'Add New Press mention', 'osi-features' ),
			'edit_item'          => __( 'Edit Press mention', 'osi-features' ),
			'new_item'           => __( 'New Press mention', 'osi-features' ),
			'view_item'          => __( 'View Press mention', 'osi-features' ),
			'search_items'       => __( 'Search Press mentions', 'osi-features' ),
			'not_found'          => __( 'No Press mentions found', 'osi-features' ),
			'not_found_in_trash' => __( 'No Press mentions found in Trash', 'osi-features' ),
		);
	}

	/**
	 * To get argument to register custom post type.
	 *
	 * @return array
	 */
	public function get_args() {

		return array(
			'show_in_rest'  => true,
			'public'        => true,
			'has_archive'   => true,
			'menu_position' => 6,
			'supports'      => array( 'title', 'author', 'excerpt' ),
			'rewrite'       => array(
				'slug'       => 'press-mentions',
				'with_front' => false,
			),
		);
	}

	/**
	 * Register custom fields for press mentions
	 */
	public function register_custom_fields() {
		\add_meta_box(
			'press_mentions_meta_box',
			\__( 'Press Mention Details', 'osi-features' ),
			array( $this, 'render_meta_box' ),
			self::SLUG,
			'normal',
			'high'
		);
	}

	/**
	 * Render the meta box
	 *
	 * @param \WP_Post $post The post object
	 */
	public function render_meta_box( $post ) {
		\wp_nonce_field( 'press_mentions_meta_box', 'press_mentions_meta_box_nonce' );

		$date_of_publication = \get_post_meta( $post->ID, 'date_of_publication', true );
		// Convert Ymd format to Y-m-d for the input field
		if ( ! empty( $date_of_publication ) ) {
			$date_of_publication = \DateTime::createFromFormat( 'Ymd', $date_of_publication )->format( 'Y-m-d' );
		}
		$article_url = \get_post_meta( $post->ID, 'article_url', true );

		?>
		<div class="press-mentions-fields">
			<p>
				<label for="date_of_publication"><?php \esc_html_e( 'Date of Publication', 'osi-features' ); ?> *</label><br>
				<input 
					type="date" 
					id="date_of_publication" 
					name="date_of_publication" 
					value="<?php echo \esc_attr( $date_of_publication ); ?>"
					required
					data-first-day="1"
				>
			</p>
			<p>
				<label for="article_url"><?php \esc_html_e( 'Article URL', 'osi-features' ); ?> *</label><br>
				<input 
					type="url" 
					id="article_url" 
					name="article_url" 
					value="<?php echo \esc_url( $article_url ); ?>"
					required
					style="width: 100%;"
				>
			</p>
		</div>
		<?php
	}

	/**
	 * Save custom fields
	 *
	 * @param int     $post_id The post ID
	 * @param \WP_Post $post    The post object
	 */
	public function save_custom_fields( $post_id, $post ) {
		if ( ! isset( $_POST['press_mentions_meta_box_nonce'] ) ) {
			return;
		}

		if ( ! \wp_verify_nonce( $_POST['press_mentions_meta_box_nonce'], 'press_mentions_meta_box' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! \current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// Save date of publication
		if ( isset( $_POST['date_of_publication'] ) ) {
			$date = \sanitize_text_field( $_POST['date_of_publication'] );
			// Convert to Ymd format
			$formatted_date = gmdate( 'Ymd', strtotime( $date ) );
			\update_post_meta( $post_id, 'date_of_publication', $formatted_date );
		}

		// Save article URL
		if ( isset( $_POST['article_url'] ) ) {
			$url = \esc_url_raw( $_POST['article_url'] );
			\update_post_meta( $post_id, 'article_url', $url );
		}
	}

	/**
	 * Register REST API fields
	 */
	public function register_rest_fields() {
		\register_rest_field(
			self::SLUG,
			'date_of_publication',
			array(
				'get_callback'    => function ( $post ) {
					return \get_post_meta( $post['id'], 'date_of_publication', true );
				},
				'update_callback' => function ( $value, $post ) {
					// Handle array input from Make.com
					$date_value = is_array( $value ) && ! empty( $value ) ? $value[0] : $value;
					if ( ! empty( $date_value ) ) {
						// Convert the date to Ymd format
						$formatted_date = gmdate( 'Ymd', strtotime( $date_value ) );
						\update_post_meta( $post->ID, 'date_of_publication', $formatted_date );
					}
				},
				'schema'          => array(
					'type'        => array( 'string', 'array' ),
					'items'       => array( 'type' => 'string' ),
					'description' => 'Date of Publication in Ymd format',
					'required'    => true,
				),
			),
		);

		\register_rest_field(
			self::SLUG,
			'article_url',
			array(
				'get_callback'    => function ( $post ) {
					return \get_post_meta( $post['id'], 'article_url', true );
				},
				'update_callback' => function ( $value, $post ) {
					// Handle array input from Make.com
					$url_value = is_array( $value ) && ! empty( $value ) ? $value[0] : $value;
					if ( ! empty( $url_value ) ) {
						\update_post_meta( $post->ID, 'article_url', \esc_url_raw( $url_value ) );
					}
				},
				'schema'          => array(
					'type'        => array( 'string', 'array' ),
					'items'       => array( 'type' => 'string' ),
					'description' => 'Article URL',
					'required'    => true,
				),
			),
		);

		\register_rest_field(
			self::SLUG,
			'publication_name',
			array(
				'get_callback'    => function ( $post ) {
					$terms = \get_the_terms( $post['id'], 'taxonomy-publication' );
					if ( ! empty( $terms ) && ! \is_wp_error( $terms ) ) {
						return $terms[0]->name;
					}
					return '';
				},
				'update_callback' => function ( $value, $post ) {
					// Handle array input from Make.com
					$pub_value = is_array( $value ) && ! empty( $value ) ? $value[0] : $value;
					if ( ! empty( $pub_value ) ) {
						$term = \get_term_by( 'name', $pub_value, 'taxonomy-publication' );

						if ( ! $term ) {
							$new_term = \wp_insert_term( $pub_value, 'taxonomy-publication' );
							if ( ! \is_wp_error( $new_term ) ) {
								$term_id = $new_term['term_id'];
							}
						} else {
							$term_id = $term->term_id;
						}

						if ( isset( $term_id ) ) {
							// Set the taxonomy term for the post
							\wp_set_object_terms( $post->ID, array( $term_id ), 'taxonomy-publication' );
						}
					}
				},
				'schema'          => array(
					'type'        => array( 'string', 'array' ),
					'items'       => array( 'type' => 'string' ),
					'description' => 'Publication Name',
					'required'    => true,
				),
			),
		);
	}
}

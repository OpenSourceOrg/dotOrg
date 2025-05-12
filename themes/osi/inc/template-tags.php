<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package osi
 */

if ( ! function_exists( 'osi_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 *
	 * @param string $format Date format.
	 */
	function osi_posted_on( $format = '' ) {

		$time_string = '<time class="byline--date entry-date published" datetime="%1$s">%2$s</time>';

		// Don't display the updated date for blog posts and meeting-minutes.
		if ( 'post' !== get_post_type() && 'meeting-minutes' !== get_post_type() ) {
			if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
				$time_string .= '<time class="byline--date entry-date published updated" datetime="%3$s">%4$s</time>';
			}
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date( $format ) ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date( $format ) )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore
	}
endif;

if ( ! function_exists( 'osi_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function osi_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'Written by %s', 'post author', 'tsf' ),
			'<span class="byline--author author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" rel="author" aria-label="Posts by author: ' . get_the_author() . '" >' . esc_html( get_the_author() ) . '</a></span>'
		);

	echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore
	}
endif;

if ( ! function_exists( 'osi_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function osi_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'osi' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'osi' ) . '</span>', $categories_list ); // phpcs:ignore
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'osi' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'osi' ) . '</span>', $tags_list ); // phpcs:ignore
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'osi' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'osi' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

/**
* Search bar with toggle button for header
*/
function osi_search_bar() {
		echo '<button aria-label="Toggle Search Bar" class="fa fa-search search-toggle run-toggle"></button>';
		get_template_part( 'template-parts/searchform' );
}

/**
* Output logo with fallback to blogname
*/
function osi_linked_logo( $class = 'header-logo', $size = 'large', $path = '' ) {
	if ( has_custom_logo() ) { // make sure field value exists

		$alt            = get_bloginfo( 'name' );
		$custom_logo_id = get_theme_mod( 'custom_logo' );
		$thumb          = wp_get_attachment_image_src( $custom_logo_id, $size );

		echo '<a href="' . esc_url( home_url( $path ) ) . '">';
		echo '<img class="' . esc_attr( $class ) . '" src="' . esc_url( $thumb[0] ) . '" alt="' . esc_attr( $alt ) . '" />';
		echo '</a>';
	} else { // If nothing else is entered, show the blog name as usual

		echo '<div class="site-title"><a href="' . esc_url( home_url( $path ) ) . '">' . esc_html( get_bloginfo( 'name' ) ) . '</a></div>';
	}
}

/**
 * Gets the full string of a linked logo.
 *
 * @param string $class The class name for the logo.
 * @param string $size  The size of the logo.
 *
 * @return string The HTML string for the linked logo.
 */
function osi_get_linked_logo( $class = 'header-logo', $size = 'large', $path = '' ) {
	ob_start();
	osi_linked_logo( $class, $size, $path );
	$output = ob_get_clean();
	return $output;
}

/**
* Check Block Registry if a block exists
*/
function osi_check_block_registry( $name ) {
	// return 1 or nothing
	return WP_Block_Type_Registry::get_instance()->is_registered( $name );
}

/**
 * Page titles
 */
function osi_title() {
	if ( is_home() ) {
		// Settings > Reading > Front Page Displays > Static Page > Posts Page
		if ( get_option( 'page_for_posts', true ) ) {
			return get_the_title( get_option( 'page_for_posts', true ) );
		} else {
			// Settings > Reading > Front Page Displays > Your Latest Posts
			return __( 'Latest Posts', 'osi' );
		}
	} elseif ( is_archive() ) {
		$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
		if ( $term ) {
			return apply_filters( 'single_term_title', get_taxonomy_labels( get_taxonomy( $term->taxonomy ) )->name . ': ' . $term->name );
		} elseif ( is_post_type_archive() ) {
			return apply_filters( 'the_title', get_queried_object()->labels->name, get_queried_object_id() );
		} elseif ( is_day() ) {
			// translators: %s is archive term name
			return sprintf( __( 'Daily Archives: %s', 'osi' ), get_the_date() );
		} elseif ( is_month() ) {
			// translators: %s is archive month
			return sprintf( __( 'Monthly Archives: %s', 'osi' ), get_the_date( 'F Y' ) );
		} elseif ( is_year() ) {
			// translators: %s is archive year
			return sprintf( __( 'Yearly Archives: %s', 'osi' ), get_the_date( 'Y' ) );
		} elseif ( is_author() ) {
			$author = get_queried_object();
			// translators: %s is author name
			return sprintf( __( 'Author Archives: %s', 'osi' ), $author->display_name );
		} else {
			return single_cat_title( '', false );
		}
	} elseif ( is_search() ) {
		// translators: %s is search result name
		return sprintf( __( 'Search Results for %s', 'osi' ), get_search_query() );
	} elseif ( is_404() ) {
		return __( 'Page Not Found', 'osi' );
	} elseif ( get_the_title() ) {
		return esc_html( get_the_title() );
	} else {
		$obj = get_post_type_object( get_post_type( get_the_ID() ) );
		// translators: %s is post type
		return sprintf( __( '%s Title', 'osi' ), $obj->labels->singular_name );
	}
}

/**
* Custom Taxonomy Term Links
* From http://codex.wordpress.org/Function_Reference/get_the_terms
* echo osi_custom_taxonomies_terms_links(); in your template file
*/
if ( ! function_exists( 'osi_get_custom_taxonomies_terms_links' ) ) {
	// get taxonomies terms links
	function osi_get_custom_taxonomies_terms_links( $post ) {
		// get post by post id
		$post = get_post( $post->ID );

		// get post type by post
		$post_type = $post->post_type;

		// get post type taxonomies
		$taxonomies = get_object_taxonomies( $post_type, 'objects' );

		$open  = '';
		$close = '';
		$out   = array();
		foreach ( $taxonomies as $taxonomy_slug => $taxonomy ) {
			if ( true === $taxonomy->public ) {

				// get the terms related to post
				$terms = get_the_terms( $post->ID, $taxonomy_slug );

				if ( ! empty( $terms ) ) {
					$num_items = count( $terms ); // how many terms are there
					$i         = 0;

					$open  = '<div class="post--metadata-group">';
					$out[] = '<span class="post--metadata--title">' . $taxonomy->label . ': </span><ul>';
					foreach ( $terms as $term ) {
						if ( ++$i === $num_items ) { // if this is the last one
							$out[] = sprintf(
								'<li><a class="term-item" aria-label="View all filed under %2$s" href="%1$s" data-id="%3$s">%2$s</a></li></ul>',
								esc_url( get_term_link( $term->slug, $taxonomy_slug ) ),
								esc_html( $term->name ),
								esc_html( $term->term_id )
							);
						} else {
							$out[] = sprintf(
								'<li><a class="term-item" aria-label="View all filed under %2$s" href="%1$s" data-id="%3$s">%2$s</a>,</li> ',
								esc_url( get_term_link( $term->slug, $taxonomy_slug ) ),
								esc_html( $term->name ),
								esc_html( $term->term_id )
							);
						}
					}
					$close = "</div>\n";
				}
			}
		}
		return $open . implode( '', $out ) . $close;
	}
}

/**
* Single Taxonomy List
* From http://codex.wordpress.org/Function_Reference/get_the_terms
* echo osi_custom_taxonomies_terms_links(); in your template file
*/
if ( ! function_exists( 'osi_get_single_taxonomy_terms_links' ) ) {
	// get taxonomies terms links
	function osi_get_single_taxonomy_terms_links( $post, $taxonomy_slug = '' ) {
		// get post by post id
		$post = get_post( $post->ID );

		$open  = '';
		$close = '';
		$out   = array();

		if ( $taxonomy_slug ) {
			// get the terms related to post
			$terms = get_the_terms( $post->ID, $taxonomy_slug );

			if ( ! empty( $terms ) ) {
				$num_items = count( $terms ); // how many terms are there
				$i         = 0;

				$open  = '<div class="post--metadata-group">';
				$out[] = '<ul>';
				foreach ( $terms as $term ) {
					if ( ++$i === $num_items ) { // if this is the last one
						$out[] = sprintf(
							'<li><a class="term-item" aria-label="View all filed under %2$s" href="%1$s" data-id="%3$s" data-term="%4$s">%2$s</a></li></ul>',
							esc_url( get_term_link( $term->slug, $taxonomy_slug ) ),
							esc_html( $term->name ),
							esc_html( $term->term_id ),
							esc_html( $term->slug ),
						);
					} else {
						$out[] = sprintf(
							'<li><a class="term-item" aria-label="View all filed under %2$s" href="%1$s" data-id="%3$s" data-term="%4$s">%2$s</a></li>',
							esc_url( get_term_link( $term->slug, $taxonomy_slug ) ),
							esc_html( $term->name ),
							esc_html( $term->term_id ),
							esc_html( $term->slug ),
						);
					}
				}
				$close = "</div>\n";
			}
		}

		return $open . implode( '', $out ) . $close;
	}
}

/**
* Single Taxonomy List with Query String
* From http://codex.wordpress.org/Function_Reference/get_the_terms
* echo osi_custom_taxonomies_terms_query(); in your template file
*/
if ( ! function_exists( 'osi_get_single_taxonomy_terms_query' ) ) {
	// get taxonomies terms links
	function osi_get_single_taxonomy_terms_query( $post, $taxonomy_slug = '', $base = '', $query_string = '?=' ) {
		// get post by post id
		$post = get_post( $post->ID );

		$open  = '';
		$close = '';
		$out   = array();

		if ( $taxonomy_slug ) {
			// get the terms related to post
			$terms = get_the_terms( $post->ID, $taxonomy_slug );

			if ( ! empty( $terms ) ) {
				$num_items = count( $terms ); // how many terms are there
				$i         = 0;

				$open  = '<div class="post--metadata-group">';
				$out[] = '<ul>';
				foreach ( $terms as $term ) {
					if ( ++$i === $num_items ) { // if this is the last one
						$out[] = sprintf(
							'<li><a class="term-item" aria-label="View all filed under %2$s" href="%1$s" data-id="%3$s" data-term="%4$s">%2$s</a></li></ul>',
							esc_url( site_url( $base . $query_string . $term->slug ) ),
							esc_html( $term->name ),
							esc_html( $term->term_id ),
							esc_html( $term->slug ),
						);
					} else {
						$out[] = sprintf(
							'<li><a class="term-item" aria-label="View all filed under %2$s" href="%1$s" data-id="%3$s" data-term="%4$s">%2$s</a></li>',
							esc_url( site_url( $base . $query_string . $term->slug ) ),
							esc_html( $term->name ),
							esc_html( $term->term_id ),
							esc_html( $term->slug ),
						);
					}
				}
				$close = "</div>\n";
			}
		}
		return $open . implode( '', $out ) . $close;
	}
}

/**
* Term Links From Defined Taxonomy
*/
if ( ! function_exists( 'osi_terms_from_taxonomy_links_all' ) ) {
	function osi_get_terms_from_taxonomy_links_all( $tax = '' ) {

		$terms = get_terms( $tax );

		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
			$count     = count( $terms );
			$i         = 0;
			$term_list = '<ul class="osi-component--term-list">';
			foreach ( $terms as $term ) {
				++$i;
				// translators: %s is term name
				$term_list .= '<li><a class="term-item" aria-label="' . sprintf( __( 'View all filed under %s', 'osi' ), $term->name ) . '" href="' . get_term_link( $term ) . '" title="' . sprintf( __( 'View all filed under %s', 'osi' ), $term->name ) . '" data-id="' . $term->term_id . '" data-term="term-' . $term->slug . '">' . $term->name . '</a></li>';
				if ( $count !== $i ) {
					$term_list .= ' ';
				} else {
					$term_list .= '</ul>';
				}
			}
			return $term_list;
		}
	}
}


/**
* Term Links Checkboxes From Defined Taxonomy
*/
if ( ! function_exists( 'osi_terms_from_taxonomy_checkboxes' ) ) {
	function osi_get_terms_from_taxonomy_checkboxes( $tax = '' ) {

		$terms = get_terms( $tax );

		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
			$count     = count( $terms );
			$i         = 0;
			$term_list = '<fieldset><ul class="osi-component--term-list">';
			foreach ( $terms as $term ) {
				++$i;
				$term_list .= '<li><label class="term-item" for="osi-filter-cb-' . $term->slug . '"><span>' . $term->name . '</span><input type="checkbox" id="osi-filter-cb-' . $term->slug . '"  class="category-filter-cb" value="' . $term->slug . '"/></label></li>';
				//
				if ( $count !== $i ) {
					$term_list .= ' ';
				} else {
					$term_list .= '</ul></fieldset>';
				}
			}
			return $term_list;
		}
	}
}

/**
* First Term of Taxonomy
*/

function osi_first_term_of_taxonomy( $post_id, $tax = '' ) {
	$terms        = wp_get_post_terms( $post_id, $tax );
	$term_display = '';
	$term_link    = '';

	if ( $terms ) {
		if ( class_exists( 'WPSEO_Primary_Term' ) ) {
			// Show the post's 'Primary' category, if this Yoast feature is available, & one is set
			$wpseo_primary_term = new WPSEO_Primary_Term( $tax, get_the_id() );
			$wpseo_primary_term = $wpseo_primary_term->get_primary_term();
			$wpseo_term         = get_term( $wpseo_primary_term );
			if ( is_wp_error( $wpseo_term ) ) {
				// Default to first category (not Yoast) if an error is returned
				$term_obj     = $terms[0];
				$term_display = $terms[0]->name;
				$term_link    = get_term_link( $terms[0]->term_id );
			} else {
				// Yoast Primary category
				$term_obj     = $wpseo_term;
				$term_display = $wpseo_term->name;
				$term_link    = get_term_link( $wpseo_term->term_id, $tax );
			}
		} else {
			// Default, display the first term in WP's list of assigned terms
			$term_obj     = $terms[0];
			$term_display = $terms ? $terms[0]->name : 'Uncategorized';
			$term_link    = $terms ? get_term_link( $terms[0]->term_id, $tax ) : '';
		}

		$termclass = 'primary-term-link';

		return '<a class="' . esc_html( $termclass ) . '" href="' . esc_url( $term_link ) . '">' . esc_html( $term_display ) . '</a>';
	}
}

/**
* Reusable post type query
*/
if ( ! function_exists( 'osi_post_type_query' ) ) {
	function osi_post_type_query( $posttype = 'post', $perpage = 6, $offset = 0 ) {
		return new WP_Query(
			array(
				'post_type'      => $posttype,
				'posts_per_page' => $perpage,
				'offset'         => $offset,
				'post_status'    => 'publish',
			)
		);
	}
}
/**
* Reusable taxonomy archive query
*/
if ( ! function_exists( 'osi_taxonomy_query' ) ) {
	function osi_taxonomy_query( $posttype = 'post', $perpage = 6, $taxonomy = 'category', $terms = array() ) {
		return new WP_Query(
			array(
				'post_type'      => $posttype,
				'posts_per_page' => $perpage,
				'tax_query'      => array(
					array(
						'taxonomy' => $taxonomy,
						'field'    => 'slug',
						'terms'    => $terms,
					),
				),
				'post_status'    => 'publish',
			)
		);
	}
}

/**
* kses ruleset for SVG escaping
*/
function kses_svg_ruelset() {
	$kses_defaults = wp_kses_allowed_html( 'post' );

	$svg_args = array(
		'svg'   => array(
			'class'           => true,
			'aria-hidden'     => true,
			'aria-labelledby' => true,
			'role'            => true,
			'xmlns'           => true,
			'width'           => true,
			'height'          => true,
			'viewbox'         => true,
		),
		'g'     => array( 'fill' => true ),
		'title' => array( 'title' => true ),
		'path'  => array(
			'd'    => true,
			'fill' => true,
		),
	);
	return array_merge( $kses_defaults, $svg_args );
}

/**
 * A WordPress helper function that takes the ID of the current post
 * and returns the top three related posts ranked by highest number of taxonomy
 * terms in common with the current post. Alternately, you can modify lines 26-33
 * to exclude certain taxonomies so that we only check for terms in specific taxonomies
 * to determine the related posts. To include up to the top X related posts instead of
 * up to three, you can modify lines 148-149.
 *
 * In your template to make use of this function you would do something like...
 *
 * $current_post_id = get_the_id();
 * $related_post_ids = osi_get_related_posts( $current_post_id );
 *
 * @see https://gist.github.com/abgregs/2d440edb0c56845b3e3e1a9f4ef26f44
 */

function osi_get_related_posts( $current_post_id, $number = 3 ) {
	// Get the post type we're dealing with based on the current post ID.
	$post_type = get_post_type( $current_post_id );

	// Get all taxonomies of the specified post type of the current post.
	$taxonomies       = array();
	$taxonomy_objects = get_object_taxonomies( $post_type, 'objects' );
	foreach ( $taxonomy_objects as $taxonomy ) {
		// If you want to only check against certain taxonomies, modify this section as needed
		// to set conditions for which taxonomies should be excluded or included. Below is just an example.
		// if ( 'post_format' !== $taxonomy->name && 'post_tag' !== $taxonomy->name ) {
		//  array_push( $taxonomies, $taxonomy );
		// }
		// By default, we will check against all taxonomies.
		array_push( $taxonomies, $taxonomy );
	}

	// Get all the posts of the specified post type,
	// excluding the current post, so that we can compare these
	// against the current post.
	$other_posts_args = array(
		'post_type'    => $post_type,
		'post__not_in' => array( $current_post_id ),
	);
	$other_posts      = new WP_Query( $other_posts_args );

	wp_reset_postdata();

	// We will create an object for each matching post that will include
	// the ID and count of the number of times it matches any taxonomy term with the current post.
	// Later, when we create those, they will get pushed to this $matching_posts array.
	$matching_posts = array();

	// If we have other posts, loop through them and
	// count matches for any taxonomy terms in common.
	if ( $other_posts->have_posts() ) {
		foreach ( $taxonomies as $taxonomy ) {

			// Get the term IDs of terms for the current post
			// (the post presumably displaying as a single post
			// back in our template, for which were finding related posts).
			$current_post_terms = get_the_terms( $current_post_id, $taxonomy->name );

			// Only continue if the current post actually has some terms for this taxonomy.
			if ( false !== $current_post_terms ) {
				foreach ( $other_posts->posts as $post ) {

					// Get the term IDs of terms for this taxonomy
					// for the other post we are currently looping over.
					$other_post_terms = get_the_terms( $post->ID, $taxonomy->name );

					// Check that other post has terms and only continue if there
					// are terms to compare.
					if ( false !== $other_post_terms ) {
						$other_post_term_ids   = array();
						$current_post_term_ids = array();

						// Get term IDs from each term in the current post.
						foreach ( $current_post_terms as $term ) {
								array_push( $current_post_term_ids, $term->term_id );
						}

						// Get term IDs from each term in the other post.
						foreach ( $other_post_terms as $term ) {
							array_push( $other_post_term_ids, $term->term_id );
						}

						if ( ! empty( $other_post_term_ids ) && ! empty( $current_post_term_ids ) ) {

							// Collect the matching term IDs for the terms the posts have in common.
							$match_count = count( array_intersect( $other_post_term_ids, $current_post_term_ids ) );

							// Get the ID of the other post to use to identify and store this post
							// in our results.
							$post_ID = $post->ID;

							if ( $match_count > 0 ) {

								// Assume post not added previously.
								$post_already_added = false;

								// If posts have already been added to our matches
								// then check to see if we already added this post.
								if ( ! empty( $matching_posts ) ) {
									foreach ( $matching_posts as $post ) {
										// If this post was added previously then let's increment the count
										// for our new matching terms.
										if ( isset( $post->ID ) && $post->ID === $post_ID ) {
											$post->count += $match_count;
											// Switch this to true for the check we perform below.
											$post_already_added = true;
										}
									}

									// If never found a post with same ID in our $matching_posts
									// list then create a new entry associated with this post and add it.
									if ( false === $post_already_added ) {
										$new_matching_post        = new stdClass();
										$new_matching_post->ID    = $post_ID;
										$new_matching_post->count = $match_count;
										array_push( $matching_posts, $new_matching_post );
									}
								} else {
									// If no posts have been added yet to $matching_posts then this will be the first.
									$new_matching_post         = new stdClass();
									$new_matching_post->ID     = $post_ID;
									$new_matching_post->count += $match_count;
									array_push( $matching_posts, $new_matching_post );
								}
							}
						}
					}
				}
			}
		}

		if ( ! empty( $matching_posts ) ) {
				// Sort the array in order of highest count for total terms in common
				// (most related to least).
				usort(
					$matching_posts,
					function ( $a, $b ) {
						return strcmp( $b->count, $a->count );
					}
				);

				// Return number of most related
				$most_related = array_slice( $matching_posts, 0, $number );

				$related_posts = array_map(
					function ( $obj ) {
						return $obj->ID;
					},
					$most_related
				);

				// Return an array of post IDs for the related posts
				return $related_posts;
		}
	}

	// Else we never found any related posts.
	return false;
}

/**
 * A colophon-generating method for WordPress Special Projects Sites.
 *
 *     osi_credits( 'separator= | ' );
 *
 * @param array $args {
 *     Optional. An array of arguments.
 *
 *     @type string $separator The separator to inject between links.
 *                             Default ' '
 *     @type string $wpcom     The link text to use for WordPress.com.
 *                             Default 'Proudly powered by WordPress.'
 *     @type string $pressable The link text to use for Pressable.
 *                             Default 'Hosted by Pressable.'
 * }
 */
function osi_credits( $args = array() ) {
	$args = wp_parse_args(
		$args,
		array(
			'separator' => ' ',
			/* translators: %s: WordPress. */
			'wpcom'     => sprintf( __( 'Proudly powered by %s.', 'osi' ), 'WordPress' ),
			/* translators: %s: Pressable. */
			'pressable' => sprintf( __( 'Hosted by %s.', 'osi' ), 'Pressable' ),
		)
	);

	$credit_links = array();

	if ( $args['wpcom'] ) {
		$partner_domain        = wp_parse_url( get_site_url(), PHP_URL_HOST );
		$wpcom_link            = apply_filters(
			'osi_credits_link_wpcom',
			add_query_arg(
				array(
					'partner_domain' => $partner_domain,
					'utm_source'     => 'Automattic',
					'utm_medium'     => 'colophon',
					'utm_campaign'   => 'Concierge Referral',
					'utm_term'       => $partner_domain,
				),
				'https://wordpress.com/wp/'
			)
		);
		$credit_links['wpcom'] = sprintf(
			'<a href="%1$s" class="imprint" target="_blank">%2$s</a>',
			esc_url( $wpcom_link ),
			esc_html( $args['wpcom'] )
		);
	}

	if ( $args['pressable'] ) {
		$pressable_link            = apply_filters(
			'osi_credits_link_pressable',
			add_query_arg(
				array(
					'utm_source'   => 'Automattic',
					'utm_medium'   => 'rpc',
					'utm_campaign' => 'Concierge Referral',
					'utm_term'     => 'concierge',
				),
				'https://pressable.com/'
			)
		);
		$credit_links['pressable'] = sprintf(
			'<a href="%1$s" class="imprint" target="_blank">%2$s</a>',
			esc_url( $pressable_link ),
			esc_html( $args['pressable'] )
		);
	}

	/**
	 * Filter the output links.
	 *
	 * This will enable folks to add additional links, remove links, or
	 * reroute links to internationalized versions if needed.
	 *
	 * @param array $credit_links The associative array of credit links.
	 * @param array $args         The parsed arguments used by `osi_credits()`.
	 */
	$credit_links = apply_filters( 'osi_credit_links', $credit_links, $args );

	echo implode(
		esc_html( $args['separator'] ),
		$credit_links
	);
}
add_action( 'osi_credits', 'osi_credits', 10, 1 );

/**
 * The Shortcode for `[osi-credits /]` or `[osi-credits separator=" | " /]` or the like.
 *
 * Can also be used in the Shortcode block.
 */
function osi_credits_shortcode( $atts ) {
	$pairs = array(
		'separator' => ' ',
		/* translators: %s: WordPress. */
		'wpcom'     => sprintf( __( 'Proudly powered by %s.', 'osi' ), 'WordPress' ),
		/* translators: %s: Pressable. */
		'pressable' => sprintf( __( 'Hosted by %s.', 'osi' ), 'Pressable' ),
	);
	$atts  = shortcode_atts( $pairs, $atts, 'osi-credits' );
	ob_start();
	osi_credits( $atts );
	return ob_get_clean();
}
add_action(
	'init',
	function () {
		add_shortcode( 'osi-credits', 'osi_credits_shortcode' );
	}
);

/**
 * Custom ACF function that checks if ACF exists and if field has value
 * Then returns true or false
 */

function osi_field_check( $fieldname ) {
	if ( class_exists( 'ACF' ) ) {
		if ( get_field( $fieldname ) ) {
			return true;
		}
	}
	return false;
}

/**
 * Custom ACF function that checks if ACF exists and if field has value
 * Then returns or echoes the field
 */

function osi_get_valid_field( $fieldname ) {
	if ( class_exists( 'ACF' ) ) {
		if ( get_field( $fieldname ) ) {
			return get_field( $fieldname );
		}
	}
}

function osi_the_valid_field( $fieldname ) {
	echo osi_get_valid_field( $fieldname );
}

/**
 * Custom ACF function that checks if ACF exists and if field has value
 * Then echoes a reformatted date
 */

function osi_the_valid_date_field( $fieldname, $format = 'F j, Y' ) {
	if ( osi_get_valid_field( $fieldname ) ) {
		$date = DateTime::createFromFormat( 'Ymd', osi_get_valid_field( $fieldname ) );
		echo $date->format( $format );
	}
}

/**
 * Custom ACF function that checks if ACF exists and if sub field has value
 * Then returns or echoes the field
 */

function osi_get_valid_sub_field( $fieldname, $subfieldname ) {
	if ( class_exists( 'ACF' ) ) {
		if ( have_rows( $fieldname ) ) {
			while ( have_rows( $fieldname ) ) {
				the_row();
				return get_sub_field( $subfieldname );
			}
		}
	}
}

function osi_the_valid_sub_field( $fieldname, $subfieldname ) {
	echo osi_get_valid_sub_field( $fieldname, $subfieldname );
}

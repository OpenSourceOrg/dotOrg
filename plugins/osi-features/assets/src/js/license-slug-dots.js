/**
 * Preserve dots in license post slugs within the Gutenberg editor.
 *
 * Gutenberg's cleanForSlug (in wp.url) replaces dots with dashes,
 * which breaks SPDX identifiers like "Apache-2.0". This script:
 *
 * 1. Watches title changes via wp.data.subscribe and corrects the
 *    slug when the title contains dots.
 * 2. Listens for focusout on the slug input (capture phase) to
 *    preserve dots when a user manually edits the slug.
 *
 * This only runs on the license post-type editor screen (enqueue
 * is gated in PHP), so other post types are unaffected.
 */
( function() {
	var data = window.wp && window.wp.data;
	if ( ! data ) {
		return;
	}

	var lastTitle = '';
	var lastSlug = '';
	var isUpdating = false;
	var pendingDottedSlug = '';

	/**
	 * Sanitize a string into a slug while preserving dots.
	 *
	 * @param {string} raw The raw string to slugify.
	 * @return {string} The slugified string with dots intact.
	 */
	function slugifyWithDots( raw ) {
		return raw
			.toLowerCase()
			.replace( /&nbsp;|&ndash;|&mdash;/g, '-' )
			.replace( /[^\w.\s-]/g, '' )
			.replace( /[\s]+/g, '-' )
			.replace( /-+/g, '-' )
			.replace( /(^-+)|(-+$)/g, '' );
	}

	/*
	 * Capture-phase focusout on the document.
	 *
	 * Fires before React's synthetic onBlur, so we can read the raw
	 * input value (with dots) before cleanForSlug strips them.
	 * After a short delay (to let Gutenberg commit its sanitized slug),
	 * we overwrite the store with the dotted version.
	 */
	document.addEventListener( 'focusout', function( e ) {
		var target = e.target;
		if ( ! target || 'INPUT' !== target.tagName ) {
			return;
		}

		var urlWrapper = target.closest( '.editor-post-url__input' );
		if ( ! urlWrapper ) {
			return;
		}

		var val = target.value || '';
		if ( val.indexOf( '.' ) === -1 ) {
			return;
		}

		pendingDottedSlug = slugifyWithDots( val );

		// Let Gutenberg commit its sanitized version, then overwrite.
		setTimeout( function() {
			if ( ! pendingDottedSlug ) {
				return;
			}
			isUpdating = true;
			data.dispatch( 'core/editor' ).editPost( { slug: pendingDottedSlug } );
			isUpdating = false;
			lastSlug = pendingDottedSlug;
			pendingDottedSlug = '';
		}, 100 );
	}, true );

	/*
	 * Store subscriber: fix title-driven slug generation.
	 *
	 * When the title changes and contains a dot, Gutenberg generates
	 * a slug via cleanForSlug which strips the dot. We detect this
	 * and dispatch the corrected dotted slug.
	 */
	data.subscribe( function() {
		if ( isUpdating ) {
			return;
		}

		var editor = data.select( 'core/editor' );
		if ( ! editor ) {
			return;
		}

		var title = editor.getEditedPostAttribute( 'title' ) || '';
		var slug = editor.getEditedPostAttribute( 'slug' ) || '';

		// Title changed and contains a dot — fix the slug.
		if ( title !== lastTitle && title.indexOf( '.' ) !== -1 ) {
			lastTitle = title;

			var dottedSlug = slugifyWithDots( title );

			if ( slug !== dottedSlug && dottedSlug.indexOf( '.' ) !== -1 ) {
				isUpdating = true;
				data.dispatch( 'core/editor' ).editPost( { slug: dottedSlug } );
				isUpdating = false;
				lastSlug = dottedSlug;
				return;
			}
		}

		lastTitle = title;
		lastSlug = slug;
	} );
}() );

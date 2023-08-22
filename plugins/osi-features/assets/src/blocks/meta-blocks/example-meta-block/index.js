/**
 * WordPress dependencies
 */
/**
 * Registers a new block provided a unique name and an object defining its behavior.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
import { registerBlockType } from '@wordpress/blocks';

/**
 * Internal dependencies
 */
import Edit from './edit';

/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
registerBlockType( 'osi-features/example-meta-block', {
	/**
	 * @see ./edit.js
	 */
	edit: Edit,

	/*
	 * No data is saved to the block when working with a meta block.
	 * Data is saved to post meta via the hook.
	 */
	save: () => null,
} );

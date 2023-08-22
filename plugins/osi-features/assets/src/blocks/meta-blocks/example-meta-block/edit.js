/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { TextControl } from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import { useEntityProp } from '@wordpress/core-data';
import { useBlockProps } from '@wordpress/block-editor';

export default function Edit() {
	const postType = useSelect(
		( select ) => select( 'core/editor' ).getCurrentPostType(),
		[],
	);
	const [ meta, setMeta ] = useEntityProp( 'postType', postType, 'meta' );
	const metaFieldValue = meta.example_meta_block_field;
	const updateMetaFieldValue = ( value ) => {
		setMeta( {
			...meta,
			example_meta_block_field: value,
		} );
	};

	return (
		<div { ...useBlockProps() }>
			<TextControl
				label={ __( 'Example Meta Block Field', 'osi-features' ) }
				value={ metaFieldValue }
				onChange={ updateMetaFieldValue }
			/>
		</div>
	);
}

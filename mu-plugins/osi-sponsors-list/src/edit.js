
import { useBlockProps, MediaUpload, MediaUploadCheck, InspectorControls } from "@wordpress/block-editor";
import { TextControl, Button, RadioControl, PanelBody } from "@wordpress/components";

const Edit = ( props ) => {
	const { attributes, setAttributes, isSelected } = props;

	const ALLOWED_MEDIA_TYPES = [ 'image' ];

	function MyMediaUploader( { mediaIDs, onSelect } ) {
		return (
			<MediaUploadCheck>
				<MediaUpload
					onSelect={ onSelect }
					allowedTypes={ ALLOWED_MEDIA_TYPES }
					value={ mediaIDs }
					render={ ( { open } ) => (
						<Button
							onClick={ open }
							className="button button-large"
						>{ mediaIDs.length < 1 ? 'Select Images' : 'Edit' }</Button>
					) }
					gallery
					multiple
				/>
			</MediaUploadCheck>
		);
	}

	const onSelect = ( items ) => {
		setAttributes( {
			images: items.map( item => {
				return {
					mediaID: parseInt( item.id, 10 ),
					mediaURL: item.url,
					mediaAlt: item.alt,
					linkTo: item.caption,
					large: (item.sizes && item.sizes.large) ? item.sizes.large.url : null,
					thumbnail: (item.sizes && item.sizes.medium) ? item.sizes.medium.url : null
				};
			} ),
		} );
	};


	return(
		( isSelected ) ? (
			<div { ...useBlockProps() }>
				<TextControl
					type="text"
					placeholder="eg: Supporter, Maintainer, Premier"
					label="Sponsor gallery title:"
					value={ attributes.title }
					onChange={ ( newTitle ) => setAttributes( { title: newTitle } ) }
				/>
				{ attributes.images.length >= 1 ? (
					<div className={`osi-sponsors-list ${attributes.columns}`}>
					{ attributes.images
						.sort( ( a, b ) => a.mediaAlt.localeCompare( b.mediaAlt ) )
						.map( item => (
						<div className="osi-sponsor-logo" key={ 'image-' + item.mediaID }>
							<img src={ item.large || item.mediaURL } alt={ item.mediaAlt } />
						</div>
					) ) }
					</div>
				) : <p>Select one or more images.</p> }
				<p>The images will be ordered by their <code>Alt Text</code> and will link to the URL posted in their <code>Caption</code></p>

				<MyMediaUploader
					mediaIDs={ attributes.images.map( item => item.mediaID ) }
					onSelect={ onSelect }
				/>
				<InspectorControls key="setting">
					<PanelBody>
						<RadioControl
							label="Columns"
							help="Choose the number of columns."
							selected={ attributes.columns }
							options={ [
								{ label: 'Five', value: 'five-columns' },
								{ label: 'Four', value: 'four-columns' },
								{ label: 'Three', value: 'three-columns' },
								{ label: 'Two', value: 'two-columns' },
								{ label: 'One', value: 'one-column' },
							] }
							onChange={ ( value ) => setAttributes( { columns: value } ) }
						/>
					</PanelBody>
				</InspectorControls>
			</div>
		) : (
			<div { ...useBlockProps() }>
				<h2>{ attributes.title }</h2>
				<div className={`osi-sponsors-list ${attributes.columns}`}>
					{ attributes.images
						.sort( ( a, b ) => a.mediaAlt.localeCompare( b.mediaAlt ) )
						.map( item => (
                        <div className={`osi-sponsor-logo img-${item.mediaID}`} key={ 'image-' + item.mediaID }>
							<img src={ item.large || item.mediaURL } alt={ item.mediaAlt } />
						</div>
					) ) }
				</div>
			</div>
		)
	);

};
export default Edit;

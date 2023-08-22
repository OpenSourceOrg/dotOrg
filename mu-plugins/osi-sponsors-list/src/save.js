
import { useBlockProps } from "@wordpress/block-editor";

const Save = ( props ) => {
	const { attributes } = props;

	if ( attributes.images.length < 1 ) {
		return null;
	}

	const blockProps = useBlockProps.save( { className: '' } );

	return (
		<div { ...blockProps }>
			<h2>{ attributes.title }</h2>

			<div className={`osi-sponsors-list ${attributes.columns}`}>
				{ attributes.images
					.sort( ( a, b ) => a.mediaAlt.localeCompare( b.mediaAlt ) )
					.map( item => (
					<div className={`osi-sponsor-logo img-${item.mediaID}`} key={ 'image-' + item.mediaID }>
						{ item.linkTo && item.linkTo.match( /^https?:\/\// ) ? (
							<a href={item.linkTo} target="_blank" rel="noopener noreferrer">
								<img 
                                    decoding="async" 
                                    loading="lazy" 
                                    class="sponsor-logo"
                                    src={ item.large || item.mediaURL } 
                                    alt={ item.mediaAlt } 
                                    data-id={ item.mediaID } />
							</a>
						) : (
							<img 
                                decoding="async" 
                                loading="lazy" 
                                class="sponsor-logo"
                                src={ item.large || item.mediaURL }
                                alt={ item.mediaAlt } 
                                data-id={ item.mediaID } />
						) }

					</div>
				) ) }
			</div>
		</div>
	);
};
export default Save;

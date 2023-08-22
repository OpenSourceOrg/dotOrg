( function( $ ) {
	const $licenseMetaItems = $( '.single-license .license-meta > span' );

	let currentItem, previousItem;
	for ( let i = 0; i < $licenseMetaItems.length; i++ ) {
		currentItem = $licenseMetaItems.get( i ).getBoundingClientRect();
		if ( previousItem && previousItem.top < currentItem.top ) {
			$licenseMetaItems.eq( i ).addClass( 'wrapped' );
		}
		previousItem = currentItem;
	}
} )( jQuery );

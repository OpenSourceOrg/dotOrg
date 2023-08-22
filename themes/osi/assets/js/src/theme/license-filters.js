/*
Name: License Filters
Author: Team 51
Version: 0.1
License: GPLv2

 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License version 2,
 as published by the Free Software Foundation.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.See the
 GNU General Public License for more details.

 The license for this software can likely be found here:
 http://www.gnu.org/licenses/gpl-2.0.html
*/


(function( $ ){

    // building the filter and search query
    const templateLicensesINIT = () => {

        const filtersContainer = $('.license-categories');
        const queryParams = [ 'ls', 'categories' ];
        const searchElem = $( '.license-search input' );
        const cbElem = $('.category-filter-cb');
        const clearSearch = $('#clear-search');
        const clearCategories = $('#clear-categories');
        const searchPrompt = $('#search-prompt');
        const toggleSearch = $('#toggle-license-search');
        const toggleCategories = $('#toggle-license-categories');

        let currentURL = window.location.href;
        let query = {};

        const buildQueryFromSearchParams = () => {
            const url = new URL( currentURL );

            queryParams.forEach( queryParam => {
                if ( url.searchParams.has( queryParam ) ) {
                    query[ queryParam ] = url.searchParams.get( queryParam );
                }
            } );
        };

        const updateFilterElements = () => {

            if ( query.s ) {
                searchElem.val( query.s );
            }

            if ( query.categories ) {

                let categories = query.categories.trim().split( ',' );
                categories.forEach( category => {
                    category = category.trim();
                    const cb = filtersContainer.find( `#osi-filter-cb-${ category }` );
                    if ( cb.length ) {
                        cb.prop( 'checked', true );
                    }
                } );
            }
        };

        const updateQuery = () => {
            const newQuery = {};

            if ( searchElem.length ) {
                if ( '' !== searchElem.val() ) {
                    newQuery.ls = searchElem.val();
                    searchPrompt.removeClass('hide');
                    searchPrompt.find('span').html( searchElem.val() );
                    toggleSearch.removeClass('open').siblings().removeClass('open');
                } else {
                    delete newQuery.ls;
                    searchPrompt.addClass('hide');
                    toggleSearch.addClass('open').siblings().addClass('open');
                }
            }

            const categories = filtersContainer.find( 'input:checked' );
            if ( categories.length ) {
                categories.each( ( i, elem ) => {
                    if ( ! newQuery.categories ) {
                        newQuery.categories = [];
                    }
                    newQuery.categories.push( $( elem ).val() );
                } );
                newQuery.categories = newQuery.categories.join( ',' );
                clearCategories.removeClass('hide');
                toggleCategories.find('span').html('('+categories.length+')');
            } else {
                delete newQuery.categories;
                clearCategories.addClass('hide');
                toggleCategories.find('span').html('');
            }

            const newURL = new URL( currentURL );

            const searchParamsURL = new URL( currentURL );
            for ( const pair of searchParamsURL.searchParams.entries() ) {
                newURL.searchParams.delete( pair[0] );
            }

            for ( const key in newQuery ) {
                newURL.searchParams.set( key, newQuery[ key ] );
            }

            window.history.pushState( { path: newURL.toString() }, '', newURL.toString() );
            currentURL = newURL.toString();

            let fetch = false;
            queryParams.forEach( queryParam => {
                if ( query[ queryParam ] !== newQuery[ queryParam ] || typeof query[ queryParam ] !== typeof newQuery[ queryParam ] ) {
                    fetch = true;
                }
            } );

            query = newQuery;

            // run ajax
            if ( fetch ) {
                fetchLicenses();
            }

        };

        const eventHandlers = () => {

            // check on page load for checked boxes
            cbElem.each(function(){
                if($(this).is(':checked')) {
                    $(this).parent('label').addClass('active');
                }
            });

            if( cbElem.is(':checked') ) {
                clearCategories.removeClass('hide');
            }

            // add active state to label when checkbox is checked
            cbElem.on('change', function(){
                $(this).parent('label').toggleClass('active');
                updateQuery();
            });

            // disable search button and run search on page
            $('.license-search form').on('submit', function(e){
                e.preventDefault();
                updateQuery();
            });

            // clear search link
            clearSearch.on('click', function(){
                searchElem.val('');
                updateQuery();
            });

            // clear categories link
            clearCategories.on('click', function(){
                cbElem.prop('checked', false).parent('label').removeClass('active');
                updateQuery();
            });

        };

        // needs to be rerun after each ajax call
        const rebindEvents = () => {
            // category link in table also powers the category chips
            $('.license-table .term-item').on('click', function(e){
                e.preventDefault();
                const term = $(this).attr('data-term');
                const cbMatch = filtersContainer.find('[value="'+term+'"]');
                cbMatch.prop('checked', true).parent('label').addClass('active');
                updateQuery();
            });
        };

        // power the ajax response
        const fetchLicenses = () => {
            const licenseContents = $( '.license-table tbody' );
            licenseContents.html( '<tr><td>Loading...</td><td></td><td></td></tr>' );

            $.post( OSI_LICENSE_DB.ajaxURL, {
                action: OSI_LICENSE_DB.action,
                ...query
            }, response => {
                if ( response.success && response.data?.html ) {
                    if ( response.data.licenses.length ) {
                        licenseContents.html( response.data.html );
                        rebindEvents();
                    } else {
                        licenseContents.html( '<tr><td>No licenses found! Please try widening your search.</td><td></td><td></td></tr>' );
                    }
                } else {
                    licenseContents.html( '<tr><td>No licenses found! Please try widening your search.</td><td></td><td></td></tr>' );
                }
            } ).fail( () => {
                licenseContents.html( '<tr><td>Something went wrong! Please refresh and try again.</td><td></td><td></td></tr>' );
            } );
        };

        // do the things
        buildQueryFromSearchParams();
        updateFilterElements();
        eventHandlers();
        // fetchLicenses();
        rebindEvents();
    };

    templateLicensesINIT();

})( jQuery );

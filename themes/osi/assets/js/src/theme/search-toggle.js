/*
Name: Toggle Searchbar
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

(function($){

/* Expanding Search Bar */

// 	function switchToggle() {
// 		var bodyWrap = $('.wrapper .content'); // body
// 		//var headerWrap = $('.header-main'); // only because header is outside of site wrap
// 		var searchToggle = $('.search-toggle'); // button
// 		var searchBar = $('.header-main .search-form'); // search
// 		var search = $('.header-main .search--form .textbox'); // search input
//     var searchSubmit = $('.header-main .search--form .search--button')

// 	    $(document).on('click', '.run-toggle', function(){ // if toggle is closed, click button or to open
// 	    	bodyWrap.addClass('search-open');
// 	    	//headerWrap.addClass('search-open-header');
// 	    	searchToggle.removeClass('run-toggle').addClass('search-open');
// 	    	searchBar.addClass('search-expanded');
// 	    	search.focus().attr('tabindex', 1);
//         searchSubmit.attr('tabindex', 1);
// 	    });

// 	    $(document).on('click', '.search-open', function(){ // if toggle is open, close by clicking anywhere on the body
// 	    	bodyWrap.removeClass('search-open');
// 	    	//headerWrap.removeClass('search-open-header');
// 	    	searchToggle.addClass('run-toggle').removeClass('search-open');
// 	    	searchBar.removeClass('search-expanded');
//         search.attr('tabindex', -1);
//         searchSubmit.attr('tabindex', -1);
// 	    });
//    }

// 	switchToggle();

	$("#openSearch" ).click(function() {
		$(".header-search-wrapper").slideDown();
		$(this).addClass("active");

		$( ".header-search-wrapper .search-field" ).focus();
	} );

	$("#closeSearch" ).click(function() {
		$( ".header-search-wrapper" ).slideUp();
		$("#openSearch").removeClass("active");
	});

})(jQuery);

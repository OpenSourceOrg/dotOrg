/*
Name: Mobile Menu Toggle
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

(function($) {

	$('.sub-menu').addClass('menu-collapse');
	$('.menu-item-has-children > a').append('<button aria-label="Toggle Submenu" class="menu-toggle"></button>');

	$('.menu-toggle').on('click', function(e) {

		e.preventDefault();

	    if ($(this).parent().next('.sub-menu').hasClass('menu-collapse')) {
	        $(this).parent().next('.sub-menu').removeClass('menu-collapse');
					$(this).parent().parent('.menu-item-has-children').addClass('tab-active');
					$(this).parent().parent().parent('.sub-menu').addClass('can-overflow');
	        $(this).addClass('menu-toggle-active');
	        e.stopPropagation();
	    } else {
	        $(this).parent().next('.sub-menu').addClass('menu-collapse');
					$(this).parent().parent('.menu-item-has-children').removeClass('tab-active');
					$(this).parent().parent().parent('.sub-menu').removeClass('can-overflow');
					$(this).parent().parent().find('.sub-menu').removeClass('can-overflow');
					$(this).removeClass('menu-toggle-active');
	        e.stopPropagation();
	    }
	});

})( jQuery );

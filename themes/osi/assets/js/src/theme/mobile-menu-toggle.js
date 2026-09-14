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

// toggle buttons are inserted as siblings of the links: a <button> inside an <a> is invalid markup
(function($) {

	function toggleSubmenu($button) {
		var $item    = $button.closest('.menu-item-has-children');
		var $submenu = $button.siblings('.sub-menu').first();
		var opening  = $submenu.hasClass('menu-collapse');

		// accordion: opening an item closes its open siblings at the same level
		if (opening) {
			$item.siblings('.tab-active').each(function() {
				toggleSubmenu($(this).children('.menu-toggle').first());
			});
		}

		$submenu.toggleClass('menu-collapse', !opening);
		$item.toggleClass('tab-active', opening);
		$item.parent().closest('.sub-menu').toggleClass('can-overflow', opening);
		if (!opening) {
			$item.find('.sub-menu').addClass('menu-collapse').removeClass('can-overflow');
			$item.find('.tab-active').removeClass('tab-active');
			$item.find('.menu-toggle').removeClass('menu-toggle-active').attr('aria-expanded', 'false');
			$item.find('a[aria-expanded]').attr('aria-expanded', 'false');
		}
		$button.toggleClass('menu-toggle-active', opening).attr('aria-expanded', String(opening));
		$button.siblings('a[aria-expanded]').first().attr('aria-expanded', String(opening));
	}

	$('.sub-menu').addClass('menu-collapse');
	$('.menu-item-has-children > a').each(function( index ) {
		var $link    = $(this);
		var $submenu = $link.siblings('.sub-menu').first();

		if (!$submenu.length) {
			return;
		}

		var id = $submenu.attr('id') || 'osi-submenu-' + index;
		$submenu.attr('id', id);
		var $button = $('<button class="menu-toggle"></button>')
			.attr({
				'aria-label': 'Toggle submenu for ' + $link.text().trim(),
				'aria-expanded': 'false',
				'aria-controls': id
			})
			.insertAfter($link);

		// the mobile menu's whole row is the disclosure: the link toggles instead of
		// navigating, and the caret stays a visual/tap affordance outside the tab order
		if ($link.closest('.nav-mobile--menu').length) {
			$link.attr('aria-expanded', 'false');
			$button.attr({ 'aria-hidden': 'true', tabindex: '-1' });
			$link.on('click', function(e) {
				e.preventDefault();
				toggleSubmenu($button);
			});
		}
	});

	$('.menu-toggle').on('click', function(e) {
		e.preventDefault();
		e.stopPropagation();
		toggleSubmenu($(this));
	});

})( jQuery );

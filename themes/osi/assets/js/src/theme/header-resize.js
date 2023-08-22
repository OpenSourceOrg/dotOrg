/*
Name: Header Resize
Author: Marktime Media
Author URI: http://marktimemedia.com
Version: 0.2
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

	/* Scroll Header */

	var $lastScrollTop = $(window).scrollTop(); // reset variable any time it reloads
	var $siteHeader = $('.header-main'); // your header element
	var $content = $('#content'); // content container
	var $contentWithHeader = $('body #content:not(.has_no_sidebar)'); // content container
	var changeDirection = -1; // base comparitive variable
	var shrinkClass = 'header-main-small'; // your small header class
	var paddingTop = $siteHeader.innerHeight();
	var paddingTopPlus = ( $siteHeader.innerHeight() + 50 );

	// $content.css('padding-top', paddingTop);
	// $contentWithHeader.css('padding-top', paddingTopPlus);

	$(window).on('scroll', (function(event) {
		var $scrollPosition = $(this).scrollTop();

		if($(window).width() > 784 ) { // we're mobile first so this is anything larger than our mobile breakpoint

			if ($scrollPosition > 100) { // once you get far enough down, shrink the header

		        $siteHeader.addClass(shrinkClass);

		    } else { // bring it back up again when we get back to the top

		    	$siteHeader.removeClass(shrinkClass);
		    }

		} else { // this is mobile breakpoint or smaller

			if ($scrollPosition > 120 && $scrollPosition > $lastScrollTop) { // once you get far enough down, hide the header

		    	changeDirection = -1; // reset changeDirection
		        $siteHeader.addClass(shrinkClass);

		    } else { // bring it back up again if we scroll up at all

		    	if ( -1 == changeDirection) {
		    		changeDirection = $scrollPosition; // only set changeDirection once
		    	}

		    	// console.log(changeDirection + ' ' + scrollPosition);

		    	if ( $scrollPosition < (changeDirection - 100) ) { // only add after you've scrolled up a bit

			    	$siteHeader.removeClass(shrinkClass);
			    	changeDirection = -1; // reset changeDirection
			    }

		    }

		    $lastScrollTop = $scrollPosition;
		}

	}));


})( jQuery );

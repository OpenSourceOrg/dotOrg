/*
Name: Header Resize
Author: Marktime Media
Author URI: http://marktimemedia.com
Version: 0.4
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

const header = document.querySelector( '.header-main' );

const SHRINK_AT = 40; // px scrolled before the header shrinks
const MOBILE_SHRINK_AT = 120; // px scrolled before it shrinks on the direction-aware path
const MOBILE_RESTORE_BY = 100; // px scrolled back up before it returns to full height
const MOBILE_MAX_WIDTH = 784; // the width production switches paths at

if ( header ) {
	const narrow = window.matchMedia( `(max-width: ${ MOBILE_MAX_WIDTH }px)` );

	let ticking = false;
	let lastY = Math.max( 0, window.scrollY );
	let turningPoint = -1; // top of the current upward scroll, -1 while scrolling down

	const setSmall = ( small ) => header.classList.toggle( 'header-main-small', small );

	const update = () => {
		ticking = false;
		const y = Math.max( 0, window.scrollY ); // rubber-band overscroll reports negative

		if ( narrow.matches ) {
			// narrow screens follow the scroll direction, so the full header comes back part-way
			// down the page rather than only at the top (@see T51ENG-2081)
			if ( y > MOBILE_SHRINK_AT && y > lastY ) {
				turningPoint = -1;
				setSmall( true );
			} else {
				if ( -1 === turningPoint ) {
					// the peak, not where this frame landed: one frame can swallow a whole flick
					turningPoint = Math.max( lastY, y );
				}

				if ( y <= MOBILE_SHRINK_AT || y < turningPoint - MOBILE_RESTORE_BY ) {
					turningPoint = -1;
					setSmall( false );
				}
			}
		} else {
			turningPoint = -1; // or a peak latched while narrow outlives a rotation
			setSmall( y > SHRINK_AT );
		}

		lastY = y;
	};

	window.addEventListener( 'scroll', () => {
		if ( ! ticking ) {
			ticking = true;
			window.requestAnimationFrame( update );
		}
	}, { passive: true } );

	// the two paths disagree, so crossing the width mid-page has to re-decide
	narrow.addEventListener( 'change', update );

	update(); // reloads restore scroll position before this runs
}

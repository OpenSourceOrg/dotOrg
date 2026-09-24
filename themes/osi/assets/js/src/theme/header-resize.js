/*
Name: Header Resize
Author: Marktime Media
Author URI: http://marktimemedia.com
Version: 0.3
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

// The header is sticky but still in flow, so shrinking it lifts the page by 25px
// ($headerInnerHeight 125px down to the 100px cap) and scroll anchoring corrects scrollY
// to match. One threshold would be re-crossed by that correction and the class would
// toggle in a loop, so the bound to beat depends on which state we are in. Growing back
// only at 0 is the safe end: browsers suppress anchoring while the scroller sits at 0.
const SHRINK_AT = 40;
const GROW_AT = 0;

if ( header ) {
	let ticking = false;

	const update = () => {
		ticking = false;
		const isSmall = header.classList.contains( 'header-main-small' );
		const next = window.scrollY > ( isSmall ? GROW_AT : SHRINK_AT );

		if ( next !== isSmall ) {
			header.classList.toggle( 'header-main-small', next );
		}
	};

	window.addEventListener( 'scroll', () => {
		if ( ! ticking ) {
			ticking = true;
			window.requestAnimationFrame( update );
		}
	}, { passive: true } );

	update(); // reloads restore scroll position before this runs
}

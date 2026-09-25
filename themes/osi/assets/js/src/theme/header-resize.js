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

const SHRINK_AT = 40; // px scrolled before the logo shrinks

if ( header ) {
	let ticking = false;

	const update = () => {
		ticking = false;
		const small = window.scrollY > SHRINK_AT;

		if ( small !== header.classList.contains( 'header-main-small' ) ) {
			header.classList.toggle( 'header-main-small', small );
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

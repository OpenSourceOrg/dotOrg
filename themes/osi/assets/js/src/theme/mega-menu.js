/*
Name: Mega Menu
Author: Team 51
Version: 0.1
License: GPLv2

 Desktop behavior for .menu-item.megamenu items: keeps aria-expanded in sync,
 enforces one open panel at a time, closes on Escape or press outside, and
 mirrors the open state onto the header (`is-nav-open`) so it turns opaque —
 the CSS :has() rule covers that too, this is the no-:has() fallback and the
 source of the close-delay grace period.
*/

// keep in sync with $break-nav (assets/scss/_1_settings.breakpoints.scss)
const desktopNav = window.matchMedia( '(min-width: 1200px)' );
const CLOSE_DELAY = 120;

const header = document.querySelector( '.header-main' );
const megaItems = document.querySelectorAll( '.nav-main--menu > .menu-item.megamenu' );

if ( header && megaItems.length ) {
	const triggerOf = ( item ) => item.querySelector( ':scope > a' );

	const syncHeader = () => {
		header.classList.toggle(
			'is-nav-open',
			Boolean( document.querySelector( '.nav-main--menu > .menu-item.megamenu.is-open' ) )
		);
	};

	const closeItem = ( item ) => {
		item.classList.remove( 'is-open' );
		const trigger = triggerOf( item );
		if ( trigger ) {
			trigger.setAttribute( 'aria-expanded', 'false' );
		}
	};

	const closeAll = () => {
		megaItems.forEach( closeItem );
		syncHeader();
	};

	megaItems.forEach( ( item ) => {
		const trigger = triggerOf( item );
		let closeTimer = null;

		if ( trigger ) {
			trigger.setAttribute( 'aria-haspopup', 'true' );
			trigger.setAttribute( 'aria-expanded', 'false' );
		}

		const open = () => {
			if ( ! desktopNav.matches ) {
				return;
			}
			window.clearTimeout( closeTimer );
			// one panel at a time — the click/tap path could otherwise stack panels
			megaItems.forEach( ( other ) => {
				if ( other !== item ) {
					closeItem( other );
				}
			} );
			item.classList.add( 'is-open' );
			if ( trigger ) {
				trigger.setAttribute( 'aria-expanded', 'true' );
			}
			syncHeader();
		};

		const close = ( immediately ) => {
			window.clearTimeout( closeTimer );
			const doClose = () => {
				closeItem( item );
				syncHeader();
			};
			if ( immediately ) {
				doClose();
			} else {
				closeTimer = window.setTimeout( doClose, CLOSE_DELAY );
			}
		};

		// touch/click support: taps don't reliably fire mouseenter/focusin (iPadOS
		// at desktop widths); placeholder triggers toggle instead of jumping to #
		if ( trigger && '#' === trigger.getAttribute( 'href' ) ) {
			trigger.addEventListener( 'click', ( event ) => {
				if ( ! desktopNav.matches ) {
					return;
				}
				event.preventDefault();
				if ( item.classList.contains( 'is-open' ) ) {
					close( true );
				} else {
					open();
				}
			} );
		}

		item.addEventListener( 'mouseenter', open );
		item.addEventListener( 'mouseleave', () => close( false ) );
		item.addEventListener( 'focusin', open );
		item.addEventListener( 'focusout', ( event ) => {
			if ( ! item.contains( event.relatedTarget ) ) {
				close( false );
			}
		} );
		item.addEventListener( 'keydown', ( event ) => {
			if ( 'Escape' === event.key && item.classList.contains( 'is-open' ) ) {
				close( true );
				if ( trigger ) {
					trigger.focus();
				}
			}
		} );
	} );

	// tap-opened panels get no mouseleave; close on any press outside the mega items
	document.addEventListener( 'pointerdown', ( event ) => {
		if (
			! event.target.closest( '.nav-main--menu > .menu-item.megamenu' ) &&
			document.querySelector( '.nav-main--menu > .menu-item.megamenu.is-open' )
		) {
			closeAll();
		}
	} );

	// leaving desktop widths: drop any open state
	desktopNav.addEventListener( 'change', ( event ) => {
		if ( ! event.matches ) {
			closeAll();
		}
	} );
}

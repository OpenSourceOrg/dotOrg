/*
Name: Mega Menu
Author: Team 51
Version: 0.1
License: GPLv2

 Desktop behavior for .menu-item.megamenu items: keeps aria-expanded in sync,
 enforces one open panel at a time, closes on Escape or press outside, and
 mirrors the open state onto the header (`is-nav-open`) as the no-:has()
 fallback for the CSS opaque-header rule, with close and switch grace periods.
 Placeholder (href="#") triggers also toggle on click because taps don't
 reliably fire mouseenter/focusin at desktop widths (iPadOS).
*/

// keep in sync with $break-nav (assets/scss/_1_settings.breakpoints.scss)
const desktopNav = window.matchMedia( '(min-width: 1200px)' );
const CLOSE_DELAY = 120;
const SWITCH_DELAY = 150;
const HOLD_LIMIT = 600;

const header = document.querySelector( '.header-main' );
const MEGA_ITEM = '.nav-main--menu > .menu-item.megamenu';
const megaItems = document.querySelectorAll( MEGA_ITEM );

if ( header && megaItems.length ) {
	const triggerOf = ( item ) => item.querySelector( ':scope > a' );
	const findOpen = () => document.querySelector( `${ MEGA_ITEM }.is-open` );

	const syncHeader = () => {
		header.classList.toggle( 'is-nav-open', Boolean( findOpen() ) );
	};

	const dismiss = ( item ) => {
		release();
		closeItem( item );
		item.classList.add( 'is-dismissed' );
		// a pending switch dies with the dismiss, so the hovered item would show its panel by :hover alone
		document.querySelector( `${ MEGA_ITEM }:hover` )?.classList.add( 'is-dismissed' );
		syncHeader();
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

	let holdTimer = null;
	let held = null;
	let lastY = 0;
	let pointerType = 'mouse';

	const hold = ( action, delay ) => {
		const start = Date.now();
		const arm = () => {
			window.clearTimeout( holdTimer );
			holdTimer = window.setTimeout( () => {
				held = null;
				action();
			}, delay );
		};
		held = () => {
			if ( Date.now() - start < HOLD_LIMIT ) {
				arm();
			}
		};
		arm();
	};

	const release = () => {
		window.clearTimeout( holdTimer );
		held = null;
	};

	// a wrapped second row sits between a first-row trigger and its panel, so a pointer still
	// heading down is on its way to the panel and must not switch or close it
	// a tap that changes nothing visible follows the link on iOS, so only a mouse waits to switch
	header.addEventListener( 'pointerover', ( event ) => {
		pointerType = event.pointerType;
	} );

	header.addEventListener( 'mousemove', ( event ) => {
		if ( held && event.clientY > lastY ) {
			held();
		}
		lastY = event.clientY;
	} );

	megaItems.forEach( ( item ) => {
		const trigger = triggerOf( item );
		let suppressOpen = false;

		if ( trigger ) {
			trigger.setAttribute( 'aria-expanded', 'false' );
		}

		const open = () => {
			if ( suppressOpen || ! desktopNav.matches ) {
				return;
			}
			item.classList.remove( 'is-dismissed' );
			release();
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

		const openOnHover = () => {
			const panelOpen = findOpen();
			if ( 'mouse' === pointerType && panelOpen && panelOpen !== item && item.offsetTop > panelOpen.offsetTop ) {
				hold( open, SWITCH_DELAY );
			} else {
				open();
			}
		};

		if ( trigger && '#' === trigger.getAttribute( 'href' ) ) {
			trigger.addEventListener( 'click', ( event ) => {
				if ( ! desktopNav.matches ) {
					return;
				}
				event.preventDefault();
				if ( item.classList.contains( 'is-open' ) ) {
					release();
					closeAll();
				} else {
					open();
				}
			} );
		}

		item.addEventListener( 'mouseenter', openOnHover );
		item.addEventListener( 'mouseleave', () => {
			item.classList.remove( 'is-dismissed' );
			hold( closeAll, CLOSE_DELAY );
		} );
		item.addEventListener( 'focusin', open );
		// one hold slot serves close and switch, so a blur must not overwrite a pending hover switch
		item.addEventListener( 'focusout', ( event ) => {
			if ( ! item.contains( event.relatedTarget ) && item.classList.contains( 'is-open' ) && ! held ) {
				hold( closeAll, CLOSE_DELAY );
			}
		} );
		// returning focus to the trigger fires focusin, which would reopen the panel
		item.addEventListener( 'keydown', ( event ) => {
			if ( 'Escape' === event.key && item.classList.contains( 'is-open' ) ) {
				suppressOpen = true;
				dismiss( item );
				if ( trigger ) {
					trigger.focus();
				}
				suppressOpen = false;
			}
		} );
	} );

	document.addEventListener( 'pointerdown', ( event ) => {
		if (
			! event.target.closest( MEGA_ITEM ) &&
			findOpen()
		) {
			closeAll();
		}
	} );

	// a panel opened by hover holds focus nowhere, so Escape has to be caught globally
	document.addEventListener( 'keydown', ( event ) => {
		if ( 'Escape' !== event.key ) {
			return;
		}
		const openItem = findOpen();
		if ( openItem ) {
			dismiss( openItem );
		}
	} );

	desktopNav.addEventListener( 'change', ( event ) => {
		if ( ! event.matches ) {
			closeAll();
		}
	} );
}

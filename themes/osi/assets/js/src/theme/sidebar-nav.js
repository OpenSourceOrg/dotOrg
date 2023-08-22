// VARIABLES //

// Buttons
  var menuBtn = document.getElementById('openMainMenu');
  var closeBtn = document.getElementById('closeSidebar');
  var sidebarBtn = document.getElementById('openSidebar');

// Media Queries
  var mediaQuerySmall = '48.9em';
  var mediaQueryLarge = '62em';

// Selectors
  var navMain = '.nav-main';
  var sidebarContent = '.content--sidebar';
  var sidebarWidget = '.content--sidebar .widget';

// For debounce
  var timer;

// General Menu Button Actions
  function openCloseMenu() {
      var htmlEl = document.querySelectorAll('html')[0];
      var htmlElClasses = htmlEl.className;

      // Add or remove the open-menu class
      if (htmlElClasses.indexOf('open-the-menu') === -1) {
          htmlEl.className = htmlElClasses + ' open-the-menu';
      } else {
          htmlEl.className = htmlElClasses.replace(' open-the-menu', '');
      }
  }

// Sidebar Button Actions
  function openSidebar() {

      var htmlEl = document.querySelectorAll('html')[0];
      var htmlElClasses = htmlEl.className;

      // Add or remove the open-menu class
      if (htmlElClasses.indexOf('open-the-sidebar') === -1) {
          htmlEl.className = htmlElClasses + ' open-the-sidebar';
      } else {
          htmlEl.className = htmlElClasses.replace(' open-the-sidebar', '');
      }
  }

// EVENT LISTENER FUNCTIONS //
if(menuBtn != null)
  if (menuBtn.attachEvent) {
      menuBtn.attachEvent('onclick', openCloseMenu);

      if(sidebarBtn !== null) {
          sidebarBtn.attachEvent('onclick', openSidebar);
      }
  } else {
      menuBtn.addEventListener('click', openCloseMenu);

      if(sidebarBtn !== null) {
          sidebarBtn.addEventListener('click', openSidebar);
      }
  }
if(closeBtn != null) {
  if (closeBtn.attachEvent) {
    closeBtn.attachEvent('onclick', openCloseMenu);
} else {
    closeBtn.addEventListener('click', openCloseMenu);
}

}
  

// PAGE STATE CHANGE FUNCTIONS //

// Change Nav Height on Mobile
  function navHeight() {
      var heights = window.innerHeight;
      var mq = window.matchMedia( '(max-width: ' + mediaQuerySmall + ')' );

      document.addEventListener('DOMContentLoaded', function() {
          if (mq.matches) {
            document.querySelectorAll(navMain)[0].style.height = heights -50 + "px";
          }
      }, false);

      mq.addListener(function(changed) {
          if(changed.matches) {
              document.querySelectorAll(navMain)[0].style.height = heights -50 + "px";
          } else {
              document.querySelectorAll(navMain)[0].style.height = null;
          }
      });
  }



// RUN ON PAGE LOAD //

navHeight(); // set nav height

document.addEventListener('DOMContentLoaded', function() {
  navHeight();
}, false);



// RUN ON PAGE RESIZE //

// debounce for nav
function onResizeNav() {
  clearTimeout(timer);
  timer = setTimeout(function() {
      navHeight();
  }, 100);
}
window.onresize = onResizeNav;

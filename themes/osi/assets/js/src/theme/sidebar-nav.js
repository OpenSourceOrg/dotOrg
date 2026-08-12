// VARIABLES //

// Buttons
  var menuBtn = document.getElementById('openMainMenu');
  var closeBtn = document.getElementById('closeSidebar');
  var sidebarBtn = document.getElementById('openSidebar');

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
  


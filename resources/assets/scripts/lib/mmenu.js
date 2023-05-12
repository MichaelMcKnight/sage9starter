import Mmenu from 'mmenu-js';

/**
 * Initialize Mmenu
 * https://mmenujs.com/
 */
/* We are replacing document.addEventListener("DOMContentLoaded") with our function here to export. */
const initializedMenu = () => {
  const menu = new Mmenu(
    '#nav-primary',
    {
      // options
      extensions: ['position-right'],
      offCanvas: {
        position: 'right',
      },
      theme: 'white',
    },
    {
      // configuration
      offCanvas: {
        clone: true,
        page: {
          selector: '#app',
        },
      },
    },
  );

  const api = menu.API;
  const siteNavTrigger = document.getElementById('menu-btn');
  siteNavTrigger.addEventListener('click', () => {
    api.open();
  });

  api.bind('open:after', function () {
    siteNavTrigger.classList.add('is-active');
  });

  api.bind('close:after', function () {
    siteNavTrigger.classList.remove('is-active');
  });

  // Example of how to add more items after the default nav
  // const cloneMenuPrimary = document.getElementById('mm-clone-menu-primary');
  // const navHeaderTopNav = document.getElementById('nav-header-top-nav');
  // const navHeaderTopNavPhone = document.getElementById('nav-header-top-nav-phone');
  // const navHeaderButtons = document.getElementById('menu-header-buttons');

  // if (navHeaderButtons) {
  //   const listview = document.createElement('div');
  //   listview.innerHTML = navHeaderButtons.outerHTML;

  //   cloneMenuPrimary.append(listview);
  // }

  // if (navHeaderTopNav) {
  //   const listview2 = document.createElement('div');
  //   listview2.innerHTML = navHeaderTopNav.innerHTML;

  //   cloneMenuPrimary.append(listview2);
  // }

  // if (navHeaderTopNavPhone) {
  //   const listview3 = document.createElement('div');
  //   listview3.innerHTML = navHeaderTopNavPhone.outerHTML;

  //   cloneMenuPrimary.append(listview3);
  // }
};

export default initializedMenu;

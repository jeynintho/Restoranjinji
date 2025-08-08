// ==== SAAT DOM SELESAI DIMUAT ====
document.addEventListener("DOMContentLoaded", function () {

  // Sidebar aktif class
  const allSideMenu = document.querySelectorAll('#sidebar .side-menu.top li a');
  allSideMenu.forEach(item => {
    const li = item.parentElement;
    item.addEventListener('click', function () {
      allSideMenu.forEach(i => i.parentElement.classList.remove('active'));
      li.classList.add('active');
    });
  });

  // Toggle Sidebar
  const menuBar = document.querySelector('#content nav .bx.bx-menu');
  const sidebar = document.getElementById('sidebar');
  if (menuBar && sidebar) {
    menuBar.addEventListener('click', function () {
      sidebar.classList.toggle('hide');
    });
  }

  // Search Button Responsive
  const searchButton = document.querySelector('#content nav form .form-input button');
  const searchButtonIcon = document.querySelector('#content nav form .form-input button .bx');
  const searchForm = document.querySelector('#content nav form');

  if (searchButton && searchButtonIcon && searchForm) {
    searchButton.addEventListener('click', function (e) {
      if (window.innerWidth < 576) {
        e.preventDefault();
        searchForm.classList.toggle('show');
        if (searchForm.classList.contains('show')) {
          searchButtonIcon.classList.replace('bx-search', 'bx-x');
        } else {
          searchButtonIcon.classList.replace('bx-x', 'bx-search');
        }
      }
    });
  }

  // Responsive behavior
  if (window.innerWidth < 768 && sidebar) {
    sidebar.classList.add('hide');
  } else if (window.innerWidth > 576 && searchForm && searchButtonIcon) {
    searchButtonIcon.classList.replace('bx-x', 'bx-search');
    searchForm.classList.remove('show');
  }

  window.addEventListener('resize', function () {
    if (this.innerWidth > 576 && searchForm && searchButtonIcon) {
      searchButtonIcon.classList.replace('bx-x', 'bx-search');
      searchForm.classList.remove('show');
    }
  });

  // Mode switch
  const switchMode = document.getElementById('switch-mode');
  if (switchMode) {
    switchMode.addEventListener('change', function () {
      if (this.checked) {
        document.body.classList.add('dark');
      } else {
        document.body.classList.remove('dark');
      }
    });
  }

  // Dropdown filter
  const dropdownContent = document.getElementById("dropdown-content");
  const filterContainer = document.querySelector('.filter-dropdown');
  window.addEventListener('click', function (event) {
    if (dropdownContent && !event.target.closest('.filter-dropdown')) {
      if (dropdownContent.classList.contains("show")) {
        dropdownContent.classList.remove("show");
      }
    }
  });

});

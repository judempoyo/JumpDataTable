document.addEventListener('DOMContentLoaded', function() {
  // Fermer les dropdowns quand on clique ailleurs
  document.addEventListener('click', function(e) {
      if (!e.target.closest('.dropdown-container')) {
          document.querySelectorAll('.dropdown-menu').forEach(menu => {
              menu.classList.add('hidden');
          });
      }
  });
  
  const filterForm = document.getElementById('filterForm');
  if (filterForm) {
      filterForm.addEventListener('keypress', function(e) {
          if (e.key === 'Enter' && e.target.tagName === 'INPUT') {
              e.preventDefault();
              this.submit();
          }
      });
  }
});

function toggleFilters() {
  const container = document.getElementById('filtersContainer');
  if (container) {
      container.classList.toggle('hidden');
      localStorage.setItem('filtersVisible', container.classList.contains('hidden') ? 'false' : 'true');
  }
}

window.addEventListener('load', function() {
  const filtersVisible = localStorage.getItem('filtersVisible');
  const container = document.getElementById('filtersContainer');
  
  if (container && filtersVisible === 'true') {
      container.classList.remove('hidden');
  }
});
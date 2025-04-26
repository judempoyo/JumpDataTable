  <script>
  // Gestion de la sélection multiple
  document.addEventListener('DOMContentLoaded', function () {
      <?php if ($enableRowSelection): ?>
          const selectAll = document.getElementById('selectAll');
          const checkboxes = document.querySelectorAll('.row-checkbox');
          const bulkActionsBar = document.getElementById('bulkActionsBar');
          const selectedCount = document.getElementById('selectedCount');
          const clearSelection = document.getElementById('clearSelection');

          if (selectAll && checkboxes.length > 0) {
              // Sélection/désélection globale
              selectAll.addEventListener('change', function () {
                  checkboxes.forEach(checkbox => {
                      checkbox.checked = selectAll.checked;
                  });
                  updateBulkActionsBar();
              });

              // Mise à jour de la case "Tout sélectionner"
              checkboxes.forEach(checkbox => {
                  checkbox.addEventListener('change', function () {
                      selectAll.checked = [...checkboxes].every(cb => cb.checked);
                      updateBulkActionsBar();
                  });
              });

              // Mise à jour de la barre d'actions groupées
              function updateBulkActionsBar() {
                  const selected = [...checkboxes].filter(cb => cb.checked).length;
                  if (selected > 0) {
                      bulkActionsBar?.classList.remove('hidden');
                      selectedCount.textContent = `${selected} élément${selected > 1 ? 's' : ''} sélectionné${selected > 1 ? 's' : ''}`;
                  } else {
                      bulkActionsBar?.classList.add('hidden');
                  }
              }

              // Annulation de la sélection
              clearSelection?.addEventListener('click', function () {
                  checkboxes.forEach(checkbox => {
                      checkbox.checked = false;
                  });
                  selectAll.checked = false;
                  updateBulkActionsBar();
              });

              // Gestion des actions groupées
              document.querySelectorAll('.bulk-action-btn').forEach(button => {
                  button.addEventListener('click', function () {
                      const selectedIds = [...checkboxes]
                          .filter(cb => cb.checked)
                          .map(cb => cb.closest('tr').dataset.id);

                      if (selectedIds.length === 0) {
                          alert('Veuillez sélectionner au moins un élément');
                          return;
                      }

                      const actionUrl = button.dataset.action;
                      // Exemple avec une confirmation avant suppression
                      if (button.textContent.includes('Supprimer')) {
                          if (confirm(`Êtes-vous sûr de vouloir supprimer ${selectedIds.length} élément${selectedIds.length > 1 ? 's' : ''} ?`)) {
                              // Implémentez ici la logique de suppression
                              console.log('Suppression des IDs:', selectedIds);
                              // window.location.href = `${actionUrl}?ids=${selectedIds.join(',')}`;
                          }
                      } else {
                          // Autres actions
                          console.log('Action:', actionUrl, 'IDs:', selectedIds);
                          // window.location.href = `${actionUrl}?ids=${selectedIds.join(',')}`;
                      }
                  });
              });
          }
      <?php endif; ?>

     
  });


</script>
<script>
   function toggleFilters() {
          const container = document.getElementById('filtersContainer');
          if (container) {
              container.classList.toggle('hidden');
              localStorage.setItem('filtersVisible', container.classList.contains('hidden') ? 'false' : 'true');
          }
      }

      const filtersVisible = localStorage.getItem('filtersVisible');
      const container = document.getElementById('filtersContainer');

      if (container && filtersVisible === 'true') {
          container.classList.remove('hidden');
      }
</script>

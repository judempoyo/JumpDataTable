<?php
// scripts.php - Fichier commun pour les scripts JavaScript

/**
 * Gère la sélection multiple des lignes et les actions groupées
 */
function renderDataTableScripts(): string {
    return <<<JS
    <script>
    // Gestion de la sélection multiple
    function setupRowSelection() {
        const selectAll = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('.row-checkbox');
        const bulkActionsBar = document.getElementById('bulkActionsBar');
        const selectedCount = document.getElementById('selectedCount');
        const clearSelection = document.getElementById('clearSelection');
        
        if (selectAll && checkboxes.length > 0) {
            // Sélection/désélection globale
            selectAll.addEventListener('change', function() {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = selectAll.checked;
                    checkbox.dispatchEvent(new Event('change'));
                });
                updateBulkActionsBar();
            });
            
            // Mise à jour de la case "Tout sélectionner"
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    selectAll.checked = [...checkboxes].every(cb => cb.checked);
                    updateBulkActionsBar();
                });
            });
            
            // Mise à jour de la barre d'actions groupées
            function updateBulkActionsBar() {
                const selected = [...checkboxes].filter(cb => cb.checked).length;
                if (selected > 0) {
                    bulkActionsBar?.classList.remove('hidden');
                    bulkActionsBar?.style.display = 'flex';
                    selectedCount.textContent = \`\${selected} élément\${selected > 1 ? 's' : ''} sélectionné\${selected > 1 ? 's' : ''}\`;
                } else {
                    bulkActionsBar?.classList.add('hidden');
                    bulkActionsBar?.style.display = 'none';
                }
            }
            
            // Annulation de la sélection
            clearSelection?.addEventListener('click', function() {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = false;
                });
                selectAll.checked = false;
                updateBulkActionsBar();
            });
            
            // Gestion des actions groupées
            document.querySelectorAll('.bulk-action-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const selectedIds = [...checkboxes]
                        .filter(cb => cb.checked)
                        .map(cb => cb.closest('tr').dataset.id);
                    
                    if (selectedIds.length === 0) {
                        alert('Veuillez sélectionner au moins un élément');
                        return;
                    }
                    
                    const actionUrl = button.dataset.action;
                    const actionLabel = button.textContent.trim() || button.title.trim();
                    
                    // Exemple avec une confirmation avant suppression
                    if (actionLabel.includes('Supprimer')) {
                        if (!confirm(\`Êtes-vous sûr de vouloir supprimer \${selectedIds.length} élément\${selectedIds.length > 1 ? 's' : ''} ?\`)) {
                            return;
                        }
                    }
                    
                    // Implémentez ici la logique de l'action
                    console.log('Action:', actionLabel, 'IDs:', selectedIds);
                    
                    // Exemple de requête fetch
                    /*
                    fetch(actionUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ ids: selectedIds })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.reload();
                        } else {
                            alert('Erreur: ' + (data.message || 'Action non effectuée'));
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Une erreur est survenue');
                    });
                    */
                });
            });
        }
    }
    
    // Gestion des filtres
    function toggleFilters() {
        const container = document.getElementById('filtersContainer');
        if (container) {
            if (container.classList) {
                container.classList.toggle('hidden');
                localStorage.setItem('filtersVisible', container.classList.contains('hidden') ? 'false' : 'true');
            } else {
                // Fallback pour Bootstrap
                container.style.display = container.style.display === 'none' ? 'block' : 'none';
                localStorage.setItem('filtersVisible', container.style.display === 'none' ? 'false' : 'true');
            }
        }
    }
    
    // Initialisation
    document.addEventListener('DOMContentLoaded', function() {
        // Activer les tooltips Bootstrap si présents
        if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }
        
        // Restaurer l'état des filtres
        const filtersVisible = localStorage.getItem('filtersVisible');
        const container = document.getElementById('filtersContainer');
        
        if (container) {
            if (filtersVisible === 'true') {
                if (container.classList) {
                    container.classList.remove('hidden');
                } else {
                    container.style.display = 'block';
                }
            }
        }
        
        // Configurer la sélection multiple
        setupRowSelection();
    });
    </script>
    JS;
}
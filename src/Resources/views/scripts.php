
<script>
    // Gestion améliorée des bulk actions
    document.addEventListener('DOMContentLoaded', function() {
        const bulkActionsManager = {
            init() {
                this.selectAll = document.getElementById('selectAll');
                this.checkboxes = document.querySelectorAll('.row-checkbox');
                this.bulkActionsBar = document.getElementById('bulkActionsBar');
                this.selectedCount = document.getElementById('selectedCount');
                this.clearSelection = document.getElementById('clearSelection');
                
                if (this.selectAll && this.checkboxes.length > 0) {
                    this.setupEventListeners();
                }
            },
            
            setupEventListeners() {
                this.selectAll.addEventListener('change', () => this.toggleAllCheckboxes());
                
                this.checkboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', () => this.updateSelectAll());
                });
                
                this.clearSelection?.addEventListener('click', () => this.clearAll());
                
                document.querySelectorAll('.bulk-action-btn').forEach(button => {
                    button.addEventListener('click', (e) => this.handleBulkAction(e));
                });
            },
            
            toggleAllCheckboxes() {
                this.checkboxes.forEach(checkbox => {
                    checkbox.checked = this.selectAll.checked;
                });
                this.updateBulkActionsBar();
            },
            
            updateSelectAll() {
                this.selectAll.checked = [...this.checkboxes].every(cb => cb.checked);
                this.updateBulkActionsBar();
            },
            
            updateBulkActionsBar() {
                const selected = [...this.checkboxes].filter(cb => cb.checked).length;
                if (selected > 0) {
                    this.bulkActionsBar?.classList.remove('hidden');
                    this.selectedCount.textContent = `${selected} élément${selected > 1 ? 's' : ''} sélectionné${selected > 1 ? 's' : ''}`;
                } else {
                    this.bulkActionsBar?.classList.add('hidden');
                }
            },
            
            clearAll() {
                this.checkboxes.forEach(checkbox => {
                    checkbox.checked = false;
                });
                this.selectAll.checked = false;
                this.updateBulkActionsBar();
            },
            
            handleBulkAction(e) {
                const selectedIds = [...this.checkboxes]
                    .filter(cb => cb.checked)
                    .map(cb => cb.closest('tr').dataset.id);

                if (selectedIds.length === 0) {
                    alert('Veuillez sélectionner au moins un élément');
                    return;
                }

                const actionUrl = e.currentTarget.dataset.action;
                
                // Implémentez la logique spécifique à l'action ici
                console.log('Action:', actionUrl, 'IDs:', selectedIds);
                
                // Exemple pour une suppression
                if (e.currentTarget.textContent.includes('Supprimer')) {
                    if (confirm(`Êtes-vous sûr de vouloir supprimer ${selectedIds.length} élément${selectedIds.length > 1 ? 's' : ''} ?`)) {
                        // window.location.href = `${actionUrl}?ids=${selectedIds.join(',')}`;
                    }
                }
            }
        };
        
        bulkActionsManager.init();
        
        // Gestion des filtres
        function toggleFilters() {
            const container = document.getElementById('filtersContainer');
            if (container) {
                container.classList.toggle('hidden');
                localStorage.setItem('filtersVisible', container.classList.contains('hidden') ? 'false' : 'true');
            }
        }

        // Restaurer l'état des filtres
        const filtersVisible = localStorage.getItem('filtersVisible');
        const container = document.getElementById('filtersContainer');
        
        if (container && filtersVisible === 'true' && container.classList.contains('hidden')) {
            container.classList.remove('hidden');
        }
    });
    </script>
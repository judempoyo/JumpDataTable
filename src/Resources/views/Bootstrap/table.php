<div class="<?= $themeClasses['container'] ?> <?= $themeClasses['animation'] ?>">
    <!-- Bulk Actions Bar -->
    <?php if ($enableRowSelection && !empty($bulkActions)): ?>
    <div id="bulkActionsBar" class="d-none d-flex align-items-center justify-content-between p-3 mb-3 rounded <?= $darkMode ? 'bg-secondary' : 'bg-light' ?> border">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-check2-circle <?= $darkMode ? 'text-info' : 'text-primary' ?>"></i>
            <span id="selectedCount" class="<?= $darkMode ? 'text-white' : '' ?>">0 éléments sélectionnés</span>
        </div>
        <div class="d-flex gap-2">
            <?php foreach ($bulkActions as $action): ?>
                <button type="button" 
                        class="bulk-action-btn btn btn-sm d-flex align-items-center gap-2 <?= $darkMode ? 'btn-dark' : 'btn-light' ?>"
                        data-action="<?= htmlspecialchars($action['url']) ?>"
                        title="<?= htmlspecialchars($action['label']) ?>">
                    <?= $action['icon'] ?? '' ?>
                    <span><?= htmlspecialchars($action['label']) ?></span>
                </button>
            <?php endforeach; ?>
            <button type="button" id="clearSelection" class="btn btn-sm <?= $darkMode ? 'btn-outline-light' : 'btn-outline-secondary' ?> d-flex align-items-center gap-2">
                <i class="bi bi-x-lg"></i>
                <span>Annuler</span>
            </button>
        </div>
    </div>
    <?php endif; ?>

    <!-- Header Section -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 mb-4 p-3 rounded <?= $themeClasses['filtersContainer'] ?>">
        <div class="d-flex align-items-center gap-3">
            <h1 class="<?= $themeClasses['title'] ?>">
                <?= htmlspecialchars($title) ?>
                <?php if (!empty($data) && count($data) > 0): ?>
                    <span class="badge ms-2 <?= $themeClasses['countBadge'] ?>">
                        <?= count($data) ?> élément<?= count($data) > 1 ? 's' : '' ?>
                    </span>
                <?php endif; ?>
            </h1>
        </div>
        
        <div class="d-flex flex-wrap align-items-center gap-2">
            <?php if (!empty($filters)): ?>
                <button type="button" onclick="toggleFilters()" class="<?= $themeClasses['filterButton'] ?>">
                    <i class="<?= $themeClasses['filterIcon'] ?>"></i>
                    Filtres
                </button>
            <?php endif; ?>
            
            <?php if ($showExport): ?>
                <a href="<?= $publicUrl . $modelName ?>/export" class="<?= $themeClasses['exportButton'] ?>">
                    <i class="<?= $themeClasses['exportIcon'] ?>"></i>
                    Exporter
                </a>
            <?php endif; ?>
            
            <a href="<?= $createUrl ?>" class="<?= $themeClasses['addButton'] ?>">
                <i class="<?= $themeClasses['addIcon'] ?>"></i>
                Ajouter
            </a>
        </div>
    </div>

    <!-- Filters Section -->
    <?php if (!empty($filters)): ?>
        <div class="mb-4 <?= $themeClasses['animation'] ?>">
            <form method="GET" action="" id="filterForm">
                <div id="filtersContainer" class="<?= empty($_GET['search']) ? 'd-none' : '' ?> <?= $themeClasses['filtersContainer'] ?>">
                    <div class="row g-3">
                        <?php foreach ($filters as $filter): ?>
                            <div class="col-md-4">
                                <label class="<?= $themeClasses['filterLabel'] ?>">
                                    <?= htmlspecialchars($filter['label'] ?? 'Filtrer') ?>
                                </label>
                                <input type="<?= htmlspecialchars($filter['type'] ?? 'text') ?>" 
                                       name="<?= htmlspecialchars($filter['name'] ?? 'search') ?>" 
                                       placeholder="<?= htmlspecialchars($filter['placeholder'] ?? 'Rechercher...') ?>"
                                       value="<?= htmlspecialchars($_GET[$filter['name'] ?? 'search'] ?? '') ?>"
                                       class="<?= $themeClasses['filterInput'] ?>" />
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="d-flex flex-wrap justify-content-end gap-2 mt-3">
                        <?php if (!empty($_GET)): ?>
                            <a href="<?= $publicUrl . $modelName ?>" class="<?= $themeClasses['resetButton'] ?>">
                                Réinitialiser
                            </a>
                        <?php endif; ?>
                        <button type="submit" class="<?= $themeClasses['applyButton'] ?>">
                            Appliquer les filtres
                        </button>
                    </div>
                </div>
                
                <input type="hidden" name="sort" value="<?= htmlspecialchars($_GET['sort'] ?? '') ?>">
                <input type="hidden" name="direction" value="<?= htmlspecialchars($_GET['direction'] ?? '') ?>">
            </form>
        </div>
    <?php endif; ?>

    <!-- Table Section -->
    <div class="table-responsive rounded <?= $themeClasses['animation'] ?>">
        <table class="<?= $themeClasses['table'] ?>">
            <thead class="<?= $themeClasses['tableHeader'] ?>">
                <tr>
                    <?php if ($enableRowSelection): ?>
                    <th scope="col" class="text-center" style="width: 50px;">
                        <input type="checkbox" id="selectAll" class="form-check-input">
                    </th>
                    <?php endif; ?>
                    <?php foreach ($columns as $column): ?>
                        <th scope="col" class="<?= $themeClasses['tableHeaderCell'] ?>">
                            <div class="d-flex align-items-center">
                                <span><?= htmlspecialchars($column['label']) ?></span>
                                <?php if (isset($column['sortable']) && $column['sortable']): ?>
                                    <a href="?sort=<?= $column['key'] ?>&direction=<?= $sort === $column['key'] && $direction === 'asc' ? 'desc' : 'asc' ?><?= !empty($_GET['search']) ? '&search=' . urlencode($_GET['search']) : '' ?>"
                                       class="ms-2 text-decoration-none">
                                        <?php if ($sort === $column['key']): ?>
                                            <span class="<?= $darkMode ? 'text-info' : 'text-primary' ?>">
                                                <?= $direction === 'asc' ? '↑' : '↓' ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="<?= $darkMode ? 'text-white-50' : 'text-muted' ?>">↕</span>
                                        <?php endif; ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </th>
                    <?php endforeach; ?>
                    
                    <?php if (!empty($actions)): ?>
                        <th scope="col" class="<?= $themeClasses['tableHeaderCell'] ?> text-end">Actions</th>
                    <?php endif; ?>
                </tr>
            </thead>
            
            <tbody class="<?= $themeClasses['tableBody'] ?>">
                <?php if (!empty($data) && count($data) > 0): ?>
                    <?php foreach ($data as $item): ?>
                        <tr class="<?= $themeClasses['tableRow'] ?>" data-id="<?= htmlspecialchars($item['id'] ?? '') ?>">
                            <?php if ($enableRowSelection): ?>
                            <td class="text-center">
                                <input type="checkbox" class="row-checkbox form-check-input">
                            </td>
                            <?php endif; ?>
                            <?php foreach ($columns as $column): ?>
                                <td class="<?= $themeClasses['tableCell'] ?>">
                                    <div class="<?= $darkMode ? 'text-white' : '' ?>">
                                        <?php if (isset($column['render']) && is_callable($column['render'])): ?>
                                            <?= $column['render']($item) ?>
                                        <?php else: ?>
                                            <?= htmlspecialchars($item[$column['key']] ?? '') ?>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            <?php endforeach; ?>
                            
                            <?php if (!empty($actions)): ?>
                                <td class="<?= $themeClasses['tableCell'] ?> text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <?php foreach ($actions as $action): ?>
                                            <a href="<?= $action['url']($item) ?>"
                                               class="<?= $themeClasses['actionButton'] ?>"
                                               title="<?= htmlspecialchars($action['label']) ?>">
                                               <?= $action['icon'] ?? '<i class="bi bi-three-dots"></i>' ?>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="<?= count($columns) + (!empty($actions) ? 1 : 0) + ($enableRowSelection ? 1 : 0) ?>" class="text-center py-5">
                            <div class="<?= $themeClasses['emptyState'] ?>">
                                <i class="bi bi-exclamation-circle fs-1 opacity-50 mb-3"></i>
                                <p class="h5">Aucun résultat trouvé</p>
                                <p class="small">Essayez de modifier vos critères de recherche</p>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <?php if(!empty($pagination) && $pagination['total'] > $pagination['per_page']): ?>
    <div class="mt-4">
        <div class="text-center <?= $darkMode ? 'text-white-50' : 'text-muted' ?> mb-2">
            Affichage de <?= ($pagination['current_page'] - 1) * $pagination['per_page'] + 1 ?> 
            à <?= min($pagination['current_page'] * $pagination['per_page'], $pagination['total']) ?> 
            sur <?= $pagination['total'] ?> résultats
        </div>
        
        <nav aria-label="Page navigation">
            <ul class="<?= $themeClasses['pagination'] ?> justify-content-center">
                <!-- Premier -->
                <li class="<?= $themeClasses['pageItem'] ?> <?= $pagination['current_page'] == 1 ? 'disabled' : '' ?>">
                    <a class="<?= $themeClasses['pageLink'] ?>" 
                       href="<?= $pagination['links'][0]['url'] ?? '#' ?>">
                        &laquo;
                    </a>
                </li>
                
                <!-- Pages -->
                <?php foreach($pagination['links'] as $link): ?>
                    <li class="<?= $themeClasses['pageItem'] ?> <?= $link['active'] ? 'active' : '' ?>">
                        <a class="<?= $themeClasses['pageLink'] ?>" 
                           href="<?= $link['url'] ?>">
                            <?= $link['label'] ?>
                        </a>
                    </li>
                <?php endforeach; ?>
                
                <!-- Dernier -->
                <li class="<?= $themeClasses['pageItem'] ?> <?= $pagination['current_page'] == $pagination['last_page'] ? 'disabled' : '' ?>">
                    <a class="<?= $themeClasses['pageLink'] ?>" 
                       href="<?= end($pagination['links'])['url'] ?? '#' ?>">
                        &raquo;
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <?php endif; ?>
   
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
                            bulkActionsBar?.classList.remove('d-none');
                            selectedCount.textContent = `${selected} élément${selected > 1 ? 's' : ''} sélectionné${selected > 1 ? 's' : ''}`;
                        } else {
                            bulkActionsBar?.classList.add('d-none');
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
</div>
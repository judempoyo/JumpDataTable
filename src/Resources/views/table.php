<div class="<?= $themeClasses['container'] ?> <?= $themeClasses['animation'] ?>">
    <!-- Bulk Actions Bar -->
    <?php if ($enableRowSelection && !empty($bulkActions)): ?>
        <div id="bulkActionsBar" class="<?= $themeClasses['bulkActionsContainer'] ?> <?= $isBootstrap ? 'd-none' : 'hidden' ?>"
            aria-live="polite" aria-atomic="true">
            <div class="<?= $isBootstrap ? 'd-flex align-items-center' : 'flex items-center gap-3' ?>">
                <?php if ($isBootstrap): ?>
                    <i class="bi bi-check-circle-fill me-2 text-primary fs-5"></i>
                <?php else: ?>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 dark:text-teal-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                <?php endif; ?>
                <span id="selectedCount" class="<?= $isBootstrap ? 'fw-medium' : 'text-sm font-medium text-gray-700 dark:text-gray-200' ?>">
                    <span class="<?= $isBootstrap ? '' : 'sr-only' ?>">Nombre d'éléments sélectionnés : </span>
                    <span aria-live="polite">0 éléments sélectionnés</span>
                </span>
            </div>
            
            <div class="<?= $isBootstrap ? 'd-flex gap-2' : 'flex flex-wrap gap-2' ?>">
                <?php foreach ($bulkActions as $action): ?>
                    <button type="button" class="<?= $themeClasses['bulkActionButton'] ?> bulk-action-btn"
                        aria-label="<?= htmlspecialchars($action['label'] ?? '') ?>">
                        <?= $action['icon'] ?? '' ?>
                        <span><?= htmlspecialchars($action['label'] ?? '') ?></span>
                    </button>
                <?php endforeach; ?>

                <button type="button" id="clearSelection" class="<?= $themeClasses['clearSelectionButton'] ?>"
                    aria-label="Annuler la sélection">
                    <?php if ($isBootstrap): ?>
                        <i class="bi bi-x-lg"></i>
                    <?php else: ?>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    <?php endif; ?>
                    <span>Annuler</span>
                </button>
            </div>
        </div>
    <?php endif; ?>

    <!-- Header Section -->
    <div class="<?= $isBootstrap ? 'd-flex flex-column flex-md-row justify-content-between align-items-center mb-4 p-3' : 'flex flex-col justify-between gap-6 mb-8 md:flex-row md:items-center' ?> <?= $themeClasses['filtersContainer'] ?>">
        <div class="<?= $isBootstrap ? 'd-flex align-items-center mb-2 mb-md-0' : 'flex items-center gap-4' ?>">
            <h1 class="<?= $themeClasses['title'] ?> <?= $isBootstrap ? 'me-3' : '' ?>">
                <?= htmlspecialchars($title) ?>
            </h1>
            <?php if (!empty($data) && count($data) > 0): ?>
                <span class="<?= $themeClasses['countBadge'] ?>">
                    <?= count($data) ?> élément<?= count($data) > 1 ? 's' : '' ?>
                </span>
            <?php endif; ?>
        </div>

        <div class="<?= $isBootstrap ? 'd-flex flex-wrap gap-2' : 'flex flex-wrap items-center gap-3' ?> <?= $themeClasses['animation'] ?>">
            <?php if (!empty($filters)): ?>
                <button type="button" onclick="toggleFilters()" class="<?= $themeClasses['filterButton'] ?>"
                    aria-expanded="false" aria-controls="filtersContainer">
                    <?php if ($isBootstrap): ?>
                        <i class="<?= $themeClasses['filterIcon'] ?>"></i>
                    <?php else: ?>
                        <svg xmlns="http://www.w3.org/2000/svg" class="<?= $themeClasses['filterIcon'] ?>" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                        </svg>
                    <?php endif; ?>
                    Filtres
                </button>
            <?php endif; ?>

            <?php if ($showExport): ?>
                <a href="<?= $publicUrl ."/". $modelName ?>/export" class="<?= $themeClasses['exportButton'] ?>"
                    aria-label="Exporter les données">
                    <?php if ($isBootstrap): ?>
                        <i class="<?= $themeClasses['exportIcon'] ?>"></i>
                    <?php else: ?>
                        <svg xmlns="http://www.w3.org/2000/svg" class="<?= $themeClasses['exportIcon'] ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                        </svg>
                    <?php endif; ?>
                    Exporter
                </a>
            <?php endif; ?>

            <a href="<?= $createUrl ?>" class="<?= $themeClasses['addButton'] ?>"
                aria-label="Ajouter un nouvel élément">
                <?php if ($isBootstrap): ?>
                    <i class="<?= $themeClasses['addIcon'] ?>"></i>
                <?php else: ?>
                    <svg xmlns="http://www.w3.org/2000/svg" class="<?= $themeClasses['addIcon'] ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                <?php endif; ?>
                Ajouter
            </a>
        </div>
    </div>

    <!-- Filters Section -->
    <?php if (!empty($filters)): ?>
        <div class="<?= $isBootstrap ? 'mb-4' : 'mb-6' ?> <?= $themeClasses['animation'] ?>">
            <form method="GET" action="" id="filterForm">
                <div id="filtersContainer" class="<?= empty($_GET['search']) ? ($isBootstrap ? 'd-none' : 'hidden') : '' ?> <?= $themeClasses['filtersContainer'] ?>"
                    aria-hidden="<?= empty($_GET['search']) ? 'true' : 'false' ?>">
                    <div class="<?= $isBootstrap ? 'row g-3' : 'grid grid-cols-1 gap-6 md:grid-cols-3' ?>">
                        <?php foreach ($filters as $filter): ?>
                            <div class="<?= $isBootstrap ? 'col-md-4' : '' ?>">
                                <label for="filter-<?= htmlspecialchars($filter['name'] ?? 'search') ?>"
                                    class="<?= $themeClasses['filterLabel'] ?>">
                                    <?= htmlspecialchars($filter['label'] ?? 'Filtrer') ?>
                                </label>
                                <input type="<?= htmlspecialchars($filter['type'] ?? 'text') ?>"
                                    id="filter-<?= htmlspecialchars($filter['name'] ?? 'search') ?>"
                                    name="<?= htmlspecialchars($filter['name'] ?? 'search') ?>"
                                    placeholder="<?= htmlspecialchars($filter['placeholder'] ?? 'Rechercher...') ?>"
                                    value="<?= htmlspecialchars($_GET[$filter['name'] ?? 'search'] ?? '') ?>"
                                    class="<?= $themeClasses['filterInput'] ?>"
                                    aria-label="<?= htmlspecialchars($filter['label'] ?? 'Filtre') ?>">
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="<?= $isBootstrap ? 'd-flex flex-wrap justify-content-end gap-2 mt-3' : 'flex flex-wrap items-center justify-end gap-3 mt-6' ?>">
                        <?php if (!empty($_GET)): ?>
                            <a href="<?= $publicUrl ."/". $modelName ?>"
                                class="<?= $themeClasses['resetButton'] ?>"
                                aria-label="Réinitialiser les filtres">
                                Réinitialiser
                            </a>
                        <?php endif; ?>
                        <button type="submit" class="<?= $themeClasses['applyButton'] ?>"
                            aria-label="Appliquer les filtres">
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
    <div class="<?= $isBootstrap ? 'table-responsive rounded' : 'overflow-hidden rounded-xl shadow-xl' ?> <?= $themeClasses['animation'] ?>">
        <?php if (!$isBootstrap): ?>
            <div class="overflow-x-auto">
        <?php endif; ?>
        
        <table class="<?= $themeClasses['table'] ?>" aria-label="<?= htmlspecialchars($title) ?>">
            <thead class="<?= $themeClasses['tableHeader'] ?>">
                <tr>
                    <?php if ($enableRowSelection): ?>
                        <th scope="col" class="<?= $isBootstrap ? 'text-center' : 'w-12 px-4 py-3 text-center' ?>" style="<?= $isBootstrap ? 'width: 40px;' : '' ?>">
                            <label for="selectAll" class="<?= $isBootstrap ? '' : 'sr-only' ?>">Sélectionner tous les éléments</label>
                            <input type="checkbox" id="selectAll" class="<?= $isBootstrap ? 'form-check-input' : 'h-4 w-4 rounded border-2 border-gray-300 dark:border-gray-500 bg-white dark:bg-gray-700 text-teal-500 dark:text-teal-400 focus:ring-teal-500 transition-colors' ?>">
                        </th>
                    <?php endif; ?>
                    
                    <?php foreach ($columns as $column): ?>
                        <th scope="col" class="<?= $themeClasses['tableHeaderCell'] ?>">
                            <div class="<?= $isBootstrap ? 'd-flex align-items-center' : 'flex items-center group' ?>">
                                <span><?= htmlspecialchars($column['label']) ?></span>
                                <?php if (isset($column['sortable']) && $column['sortable']): ?>
                                    <a href="?sort=<?= $column['key'] ?>&direction=<?= $sort === $column['key'] && $direction === 'asc' ? 'desc' : 'asc' ?><?= !empty($_GET['search']) ? '&search=' . urlencode($_GET['search']) : '' ?>"
                                        class="<?= $isBootstrap ? 'ms-2 text-decoration-none' : 'ml-2 transition-opacity duration-200 opacity-0 group-hover:opacity-100 focus:opacity-100 focus:outline-none' ?>"
                                        aria-label="Trier par <?= htmlspecialchars($column['label']) ?>">
                                        <?php if ($sort === $column['key']): ?>
                                            <span class="<?= $isBootstrap ? 'text-primary' : 'text-teal-500 dark:text-teal-400' ?>">
                                                <?= $direction === 'asc' ? '↑' : '↓' ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="<?= $isBootstrap ? 'text-body-secondary' : 'text-gray-400 hover:text-teal-500 dark:hover:text-teal-400' ?>">↕</span>
                                        <?php endif; ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </th>
                    <?php endforeach; ?>

                    <?php if (!empty($actions)): ?>
                        <th scope="col" class="<?= $themeClasses['tableHeaderCell'] ?> <?= $isBootstrap ? 'text-end' : 'text-right' ?>">
                            <span class="<?= $isBootstrap ? '' : 'sr-only' ?>">Actions</span>
                        </th>
                    <?php endif; ?>
                </tr>
            </thead>

            <tbody class="<?= $themeClasses['tableBody'] ?>">
                <?php if (!empty($data) && count($data) > 0): ?>
                    <?php foreach ($data as $item): ?>
                        <tr class="<?= $themeClasses['tableRow'] ?>" data-id="<?= htmlspecialchars($item['id'] ?? '') ?>">
                            <?php if ($enableRowSelection): ?>
                                <td class="<?= $isBootstrap ? 'text-center' : 'px-4 py-3 whitespace-nowrap text-center' ?>">
                                    <label for="row-<?= htmlspecialchars($item['id'] ?? '') ?>" class="<?= $isBootstrap ? '' : 'sr-only' ?>">Sélectionner cet élément</label>
                                    <input type="checkbox" id="row-<?= htmlspecialchars($item['id'] ?? '') ?>"
                                        class="row-checkbox <?= $isBootstrap ? 'form-check-input' : 'h-4 w-4 rounded border-2 border-gray-300 dark:border-gray-500 bg-white dark:bg-gray-700 text-teal-500 dark:text-teal-400 focus:ring-teal-500 transition-colors' ?>">
                                </td>
                            <?php endif; ?>
                            
                            <?php foreach ($columns as $column): ?>
                                <td class="<?= $themeClasses['tableCell'] ?>">
                                    <div class="<?= $isBootstrap ? '' : 'text-sm' ?>">
                                        <?php if (isset($column['render']) && is_callable($column['render'])): ?>
                                            <?= $column['render']($item) ?>
                                        <?php else: ?>
                                            <?= htmlspecialchars($item[$column['key']] ?? '') ?>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            <?php endforeach; ?>

                            <?php if (!empty($actions)): ?>
                                <td class="<?= $themeClasses['tableCell'] ?> <?= $isBootstrap ? 'text-end' : 'text-right' ?>">
                                    <div class="<?= $isBootstrap ? 'd-flex justify-content-end gap-2' : 'flex justify-end space-x-3' ?>">
                                        <?php foreach ($actions as $action): ?>
                                            <a href="<?= $action['url']($item) ?>"
                                                class="<?= $themeClasses['actionButton'] ?>"
                                                title="<?= htmlspecialchars($action['label']) ?>"
                                                aria-label="<?= htmlspecialchars($action['label']) ?>">
                                                <?= $action['icon'] ?? ($isBootstrap ? '<i class="bi bi-three-dots"></i>' : '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" /></svg>') ?>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="<?= count($columns) + (!empty($actions) ? 1 : 0) + ($enableRowSelection ? 1 : 0) ?>"
                            class="<?= $isBootstrap ? 'text-center py-5' : 'px-6 py-16 text-center' ?>">
                            <div class="<?= $themeClasses['emptyState'] ?>">
                                <?php if ($isBootstrap): ?>
                                    <i class="bi bi-exclamation-circle fs-1 opacity-50 mb-3"></i>
                                <?php else: ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mb-4 opacity-40" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                <?php endif; ?>
                                <p class="<?= $isBootstrap ? 'h5' : 'text-lg font-medium' ?>">
                                    <?= $emptyStateMessage ?? 'Aucun résultat trouvé' ?>
                                </p>
                                <?php if (empty($emptyStateMessage)): ?>
                                    <p class="<?= $isBootstrap ? 'small' : 'text-sm mt-1' ?>">Essayez de modifier vos critères de recherche</p>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        
        <?php if (!$isBootstrap): ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <?php if (!empty($pagination) && $pagination['total'] > $pagination['per_page']): ?>
        <div class="<?= $isBootstrap ? 'mt-4' : 'flex flex-col items-center justify-between mt-6 space-y-4 sm:flex-row sm:space-y-0' ?> <?= $themeClasses['animation'] ?>">
            <div class="<?= $isBootstrap ? 'text-center mb-3 text-body-secondary' : 'text-sm text-gray-700 dark:text-gray-300' ?>">
                Affichage de <span class="<?= $isBootstrap ? '' : 'font-medium' ?>"><?= ($pagination['current_page'] - 1) * $pagination['per_page'] + 1 ?></span>
                à <span class="<?= $isBootstrap ? '' : 'font-medium' ?>"><?= min($pagination['current_page'] * $pagination['per_page'], $pagination['total']) ?></span>
                sur <span class="<?= $isBootstrap ? '' : 'font-medium' ?>"><?= $pagination['total'] ?></span> résultats
            </div>

            <nav aria-label="Pagination" class="<?= $themeClasses['pagination'] ?>">
                <?php if ($isBootstrap): ?>
                    <!-- Bootstrap Pagination -->
                    <li class="<?= $themeClasses['pageItem'] ?> <?= $pagination['current_page'] == 1 ? 'disabled' : '' ?>">
                        <a class="<?= $themeClasses['pageLink'] ?>" href="<?= $pagination['links'][0]['url'] ?? '#' ?>">
                            &laquo;
                        </a>
                    </li>

                    <?php foreach ($pagination['links'] as $link): ?>
                        <?php if (is_numeric($link['label'])): ?>
                            <li class="<?= $themeClasses['pageItem'] ?> <?= $link['active'] ? 'active' : '' ?>">
                                <a class="<?= $themeClasses['pageLink'] ?>" href="<?= $link['url'] ?>">
                                    <?= $link['label'] ?>
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>

                    <li class="<?= $themeClasses['pageItem'] ?> <?= $pagination['current_page'] == $pagination['last_page'] ? 'disabled' : '' ?>">
                        <a class="<?= $themeClasses['pageLink'] ?>" href="<?= end($pagination['links'])['url'] ?? '#' ?>">
                            &raquo;
                        </a>
                    </li>
                <?php else: ?>
                    <!-- Tailwind Pagination -->
                    <a href="<?= $pagination['links'][0]['url'] ?? '#' ?>"
                        class="px-3 py-1 text-sm border rounded-lg <?= $pagination['current_page'] == 1 ? 'text-gray-400 bg-gray-100 dark:bg-gray-700 border-gray-200 dark:border-gray-600 cursor-not-allowed' : $themeClasses['pageLink'] ?>"
                        aria-label="Première page" <?= $pagination['current_page'] == 1 ? 'aria-disabled="true"' : '' ?>>
                        &laquo;
                    </a>

                    <a href="<?= $pagination['links'][1]['url'] ?? '#' ?>"
                        class="px-3 py-1 text-sm border rounded-lg <?= $pagination['current_page'] == 1 ? 'text-gray-400 bg-gray-100 dark:bg-gray-700 border-gray-200 dark:border-gray-600 cursor-not-allowed' : $themeClasses['pageLink'] ?>"
                        aria-label="Page précédente" <?= $pagination['current_page'] == 1 ? 'aria-disabled="true"' : '' ?>>
                        &lsaquo;
                    </a>

                    <?php foreach ($pagination['links'] as $link): ?>
                        <?php if (is_numeric($link['label'])): ?>
                            <a href="<?= $link['url'] ?>"
                                class="px-3 py-1 text-sm border rounded-lg <?= $link['active'] ? 'text-white bg-teal-500 border-teal-500' : $themeClasses['pageLink'] ?>"
                                aria-label="Page <?= $link['label'] ?>" <?= $link['active'] ? 'aria-current="page"' : '' ?>>
                                <?= $link['label'] ?>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; ?>

                    <a href="<?= $pagination['links'][count($pagination['links']) - 2]['url'] ?? '#' ?>"
                        class="px-3 py-1 text-sm border rounded-lg <?= $pagination['current_page'] == $pagination['last_page'] ? 'text-gray-400 bg-gray-100 dark:bg-gray-700 border-gray-200 dark:border-gray-600 cursor-not-allowed' : $themeClasses['pageLink'] ?>"
                        aria-label="Page suivante" <?= $pagination['current_page'] == $pagination['last_page'] ? 'aria-disabled="true"' : '' ?>>
                        &rsaquo;
                    </a>

                    <a href="<?= end($pagination['links'])['url'] ?? '#' ?>"
                        class="px-3 py-1 text-sm border rounded-lg <?= $pagination['current_page'] == $pagination['last_page'] ? 'text-gray-400 bg-gray-100 dark:bg-gray-700 border-gray-200 dark:border-gray-600 cursor-not-allowed' : $themeClasses['pageLink'] ?>"
                        aria-label="Dernière page" <?= $pagination['current_page'] == $pagination['last_page'] ? 'aria-disabled="true"' : '' ?>>
                        &raquo;
                    </a>
                <?php endif; ?>
            </nav>
        </div>
    <?php endif; ?>
</div>

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
                    const isChecked = selectAll.checked;
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = isChecked;
                        checkbox.dispatchEvent(new Event('change'));
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
                        bulkActionsBar?.classList.remove('<?= $isBootstrap ? 'd-none' : 'hidden' ?>');
                        bulkActionsBar?.setAttribute('aria-hidden', 'false');
                        selectedCount.querySelector('span:last-child').textContent = `${selected} élément${selected > 1 ? 's' : ''} sélectionné${selected > 1 ? 's' : ''}`;
                    } else {
                        bulkActionsBar?.classList.add('<?= $isBootstrap ? 'd-none' : 'hidden' ?>');
                        bulkActionsBar?.setAttribute('aria-hidden', 'true');
                    }
                }

                // Annulation de la sélection
                clearSelection?.addEventListener('click', function () {
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = false;
                        checkbox.dispatchEvent(new Event('change'));
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

        function toggleFilters() {
            const container = document.getElementById('filtersContainer');
            if (container) {
                const isHidden = container.classList.toggle('<?= $isBootstrap ? 'd-none' : 'hidden' ?>');
                container.setAttribute('aria-hidden', isHidden ? 'true' : 'false');

                const filterButton = document.querySelector('[aria-controls="filtersContainer"]');
                if (filterButton) {
                    filterButton.setAttribute('aria-expanded', isHidden ? 'false' : 'true');
                }

                localStorage.setItem('filtersVisible', isHidden ? 'false' : 'true');
            }
        }

        // Restaurer l'état des filtres
        const filtersVisible = localStorage.getItem('filtersVisible');
        const container = document.getElementById('filtersContainer');
        const filterButton = document.querySelector('[aria-controls="filtersContainer"]');

        if (container && filtersVisible === 'true') {
            container.classList.remove('<?= $isBootstrap ? 'd-none' : 'hidden' ?>');
            container.setAttribute('aria-hidden', 'false');
            if (filterButton) {
                filterButton.setAttribute('aria-expanded', 'true');
            }
        }
    });
</script>
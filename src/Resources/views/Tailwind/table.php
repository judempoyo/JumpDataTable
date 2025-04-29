<div class="<?= $themeClasses['container'] ?>">
    <!-- Bulk Actions Bar -->
    <?php if ($enableRowSelection && !empty($bulkActions)): ?>
        <div id="bulkActionsBar"
            class="hidden flex items-center justify-between p-4 mb-4 rounded-lg border bg-gray-50 dark:bg-gray-800 border-gray-200 dark:border-gray-700 shadow-sm transition-all duration-200"
            aria-live="polite" aria-atomic="true">
            <div class="flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 dark:text-teal-400" viewBox="0 0 20 20"
                    fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd"
                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                        clip-rule="evenodd" />
                </svg>
                <span id="selectedCount" class="text-sm font-medium text-gray-700 dark:text-gray-200">
                    <span class="sr-only">Nombre d'éléments sélectionnés : </span>
                    <span aria-live="polite">0 éléments sélectionnés</span>
                </span>
            </div>
            <div class="flex flex-wrap gap-2">
                <?php if (!empty($bulkActions) && is_array($bulkActions)): ?>
                    <?php foreach ($bulkActions as $action): ?>
                        <button type="button"
                            class="bulk-action-btn inline-flex items-center gap-2 px-3 py-1.5 text-sm font-medium rounded-md transition-colors bg-white dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 border border-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2"
                            aria-label="<?= htmlspecialchars($action['label'] ?? '') ?>">
                            <?= $action['icon'] ?? '' ?>
                            <span><?= htmlspecialchars($action['label'] ?? '') ?></span>
                        </button>
                    <?php endforeach; ?>
                <?php endif; ?>
                <button type="button" id="clearSelection"
                    class="flex items-center gap-2 px-3 py-1.5 text-sm rounded-md text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
                    aria-label="Annuler la sélection">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span>Annuler</span>
                </button>
            </div>
        </div>
    <?php endif; ?>

    <!-- Header Section -->
    <div
        class="flex flex-col justify-between gap-6 mb-8 md:flex-row md:items-center <?= $themeClasses['filtersContainer'].' '. $themeClasses['animations']['header'] ?>">
        <div class="flex items-center gap-4">
            <h1 class="<?= $themeClasses['title'] ?>">
                <?= htmlspecialchars($title) ?>
                <?php if (!empty($data) && count($data) > 0): ?>
                    <span class="<?= $themeClasses['countBadge'] ?>">
                        <?= count($data) ?> élément<?= count($data) > 1 ? 's' : '' ?>
                    </span>
                <?php endif; ?>
            </h1>
        </div>

        <div class="flex flex-wrap items-center gap-3 <?= $themeClasses['animation'] ?>">
            <?php if (!empty($filters)): ?>
                <button type="button" onclick="toggleFilters()"
                    class="<?= $themeClasses['filterButton'] ?> focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2"
                    aria-expanded="false" aria-controls="filtersContainer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="<?= $themeClasses['filterIcon'] ?>" viewBox="0 0 20 20"
                        fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                            clip-rule="evenodd" />
                    </svg>
                    Filtres
                </button>
            <?php endif; ?>

            <?php if ($showExport): ?>
                <a href="<?= $publicUrl . "/" . $modelName ?>/export"
                    class="<?= $themeClasses['exportButton'] ?> focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2"
                    aria-label="Exporter les données">
                    <svg xmlns="http://www.w3.org/2000/svg" class="<?= $themeClasses['exportIcon'] ?>" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                    </svg>
                    Exporter
                </a>
            <?php endif; ?>

            <a href="<?= $createUrl ?>"
                class="<?= $themeClasses['addButton'] ?> focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2"
                aria-label="Ajouter un nouvel élément">
                <svg xmlns="http://www.w3.org/2000/svg" class="<?= $themeClasses['addIcon'] ?>" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Ajouter
            </a>
        </div>
    </div>

    <!-- Filters Section -->
    <?php if (!empty($filters)): ?>
        <div class="mb-6 <?= $themeClasses['animation'] ?>">
            <form method="GET" action="" id="filterForm">
                <div id="filtersContainer"
                    class="<?= empty($_GET['search']) ? 'hidden' : '' ?> <?= $themeClasses['filtersContainer'] ?>"
                    aria-hidden="<?= empty($_GET['search']) ? 'true' : 'false' ?>">
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                        <?php foreach ($filters as $filter): ?>
                            <div>
                                <label for="filter-<?= htmlspecialchars($filter['name'] ?? 'search') ?>"
                                    class="<?= $themeClasses['filterLabel'] ?>">
                                    <?= htmlspecialchars($filter['label'] ?? 'Filtrer') ?>
                                </label>
                                <input type="<?= htmlspecialchars($filter['type'] ?? 'text') ?>"
                                    id="filter-<?= htmlspecialchars($filter['name'] ?? 'search') ?>"
                                    name="<?= htmlspecialchars($filter['name'] ?? 'search') ?>"
                                    placeholder="<?= htmlspecialchars($filter['placeholder'] ?? 'Rechercher...') ?>"
                                    value="<?= htmlspecialchars($_GET[$filter['name'] ?? 'search'] ?? '') ?>"
                                    class="<?= $themeClasses['filterInput'] ?> focus:ring-2 focus:ring-teal-500"
                                    aria-label="<?= htmlspecialchars($filter['label'] ?? 'Filtre') ?>">
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="flex flex-wrap items-center justify-end gap-3 mt-6">
                        <?php if (!empty($_GET)): ?>
                            <a href="<?= $publicUrl . "/" . $modelName ?>"
                                class="<?= $themeClasses['resetButton'] ?> focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
                                aria-label="Réinitialiser les filtres">
                                Réinitialiser
                            </a>
                        <?php endif; ?>
                        <button type="submit"
                            class="<?= $themeClasses['applyButton'] ?> focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2"
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
    <div class="overflow-hidden rounded-xl shadow-xl <?= $themeClasses['animation'] ?>">
        <div class="overflow-x-auto">
            <table class="<?= $themeClasses['table'] ?>" aria-label="<?= htmlspecialchars($title) ?>">
                <thead class="<?= $themeClasses['tableHeader'] ?>">
                    <tr>
                        <?php if ($enableRowSelection): ?>
                            <th scope="col" class="w-12 px-4 py-3 text-center">
                            <label class="flex items-center cursor-pointer relative"
                            for="selectAll">
                                            <input type="checkbox" id="selectAll"
                                                class="row-checkbox peer h-5 w-5 cursor-pointer transition-all appearance-none rounded shadow hover:shadow-md border border-teal-300 checked:bg-teal-800 checked:border-teal-800" />
                                            <span
                                                class="absolute text-white opacity-0 peer-checked:opacity-100 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 pointer-events-none">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20"
                                                    fill="currentColor" stroke="currentColor" stroke-width="1">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </span>
                                        </label>
                               
                            </th>
                        <?php endif; ?>
                        <?php foreach ($columns as $column): ?>
                            <th scope="col" class="<?= $themeClasses['tableHeaderCell'] ?>">
                                <div class="flex items-center group">
                                    <span><?= htmlspecialchars($column['label']) ?></span>
                                    <?php if (isset($column['sortable']) && $column['sortable']): ?>
                                        <a href="?sort=<?= $column['key'] ?>&direction=<?= $sort === $column['key'] && $direction === 'asc' ? 'desc' : 'asc' ?><?= !empty($_GET['search']) ? '&search=' . urlencode($_GET['search']) : '' ?>"
                                            class="ml-2 transition-opacity duration-200 opacity-0 group-hover:opacity-100 focus:opacity-100 focus:outline-none"
                                            aria-label="Trier par <?= htmlspecialchars($column['label']) ?>">
                                            <?php if ($sort === $column['key']): ?>
                                                <span class="text-teal-500 dark:text-teal-400">
                                                    <?= $direction === 'asc' ? '↑' : '↓' ?>
                                                </span>
                                            <?php else: ?>
                                                <span class="text-gray-400 hover:text-teal-500 dark:hover:text-teal-400">↕</span>
                                            <?php endif; ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </th>
                        <?php endforeach; ?>

                        <?php if (!empty($actions)): ?>
                            <th scope="col" class="<?= $themeClasses['tableHeaderCell'] ?> text-right">
                                <span class="sr-only">Actions</span>
                            </th>
                        <?php endif; ?>
                    </tr>
                </thead>

                <tbody class="<?= $themeClasses['tableBody'] ?> ">
                    <?php if (!empty($data) && count($data) > 0): ?>
                        <?php foreach ($data as $item): ?>
                            <tr class="<?= $themeClasses['tableRow'] ?>" data-id="<?= htmlspecialchars($item['id'] ?? '') ?>">
                                <?php if ($enableRowSelection): ?>
                                    <td class="px-4 py-3 whitespace-nowrap text-center">
                                       
                                        <label class="flex items-center cursor-pointer relative"
                                            for="row-<?= htmlspecialchars($item['id'] ?? '') ?>">
                                            <input type="checkbox" id="row-<?= htmlspecialchars($item['id'] ?? '') ?>"
                                                class="row-checkbox peer h-5 w-5 cursor-pointer transition-all appearance-none rounded shadow hover:shadow-md border border-teal-300 checked:bg-teal-800 checked:border-teal-800" />
                                            <span
                                                class="absolute text-white opacity-0 peer-checked:opacity-100 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 pointer-events-none">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20"
                                                    fill="currentColor" stroke="currentColor" stroke-width="1">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </span>
                                        </label>
                                    </td>


                                <?php endif; ?>
                                <?php foreach ($columns as $column): ?>
                                    <td class="<?= $themeClasses['tableCell'] ?>">
                                        <div class="text-sm">
                                            <?php if (isset($column['render']) && is_callable($column['render'])): ?>
                                                <?= $column['render']($item) ?>
                                            <?php else: ?>
                                                <?= htmlspecialchars($item[$column['key']] ?? '') ?>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                <?php endforeach; ?>

                                <?php if (!empty($actions)): ?>
                                    <td class="<?= $themeClasses['tableCell'] ?> text-right">
                                        <div class="flex justify-end space-x-3">
                                            <?php foreach ($actions as $action): ?>
                                                <a href="<?= $action['url']($item) ?>"
                                                    class="<?= $themeClasses['actionButton'] ?> focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2"
                                                    aria-label="<?= htmlspecialchars($action['label']) ?>">
                                                    <?= $action['icon'] ?? '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" /></svg>' ?>
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
                                class="px-6 py-16 text-center">
                                <div class="<?= $themeClasses['emptyState'] ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mb-4 opacity-40" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="text-lg font-medium">
                                        <?= $emptyStateMessage ?? 'Aucun résultat trouvé' ?>
                                    </p>
                                    <?php if (empty($emptyStateMessage)): ?>
                                        <p class="text-sm mt-1">Essayez de modifier vos critères de recherche</p>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <?php if (!empty($pagination) && $pagination['total'] > $pagination['per_page']): ?>
        <div
            class="flex flex-col items-center justify-between mt-6 space-y-4 sm:flex-row sm:space-y-0 <?= $themeClasses['animation'] ?>">
            <div class="text-sm text-gray-700 dark:text-gray-300">
                Affichage de <span
                    class="font-medium"><?= ($pagination['current_page'] - 1) * $pagination['per_page'] + 1 ?></span>
                à <span
                    class="font-medium"><?= min($pagination['current_page'] * $pagination['per_page'], $pagination['total']) ?></span>
                sur <span class="font-medium"><?= $pagination['total'] ?></span> résultats
            </div>

            <nav aria-label="Pagination" class="<?= $themeClasses['pagination'] ?>">
                <!-- Premier -->
                <a href="<?= $pagination['links'][0]['url'] ?? '#' ?>"
                    class="px-3 py-1 text-sm border rounded-lg <?= $pagination['current_page'] == 1 ? 'text-gray-400 bg-gray-100 dark:bg-gray-700 border-gray-200 dark:border-gray-600 cursor-not-allowed' : $themeClasses['pageLink'] ?> focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2"
                    aria-label="Première page" <?= $pagination['current_page'] == 1 ? 'aria-disabled="true"' : '' ?>>
                    &laquo;
                </a>

                <!-- Précédent -->
                <a href="<?= $pagination['links'][1]['url'] ?? '#' ?>"
                    class="px-3 py-1 text-sm border rounded-lg <?= $pagination['current_page'] == 1 ? 'text-gray-400 bg-gray-100 dark:bg-gray-700 border-gray-200 dark:border-gray-600 cursor-not-allowed' : $themeClasses['pageLink'] ?> focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2"
                    aria-label="Page précédente" <?= $pagination['current_page'] == 1 ? 'aria-disabled="true"' : '' ?>>
                    &lsaquo;
                </a>

                <!-- Pages -->
                <?php foreach ($pagination['links'] as $link): ?>
                    <?php if (is_numeric($link['label'])): ?>
                        <a href="<?= $link['url'] ?>"
                            class="px-3 py-1 text-sm border rounded-lg <?= $link['active'] ? 'text-white bg-teal-500 border-teal-500' : $themeClasses['pageLink'] ?> focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2"
                            aria-label="Page <?= $link['label'] ?>" <?= $link['active'] ? 'aria-current="page"' : '' ?>>
                            <?= $link['label'] ?>
                        </a>
                    <?php endif; ?>
                <?php endforeach; ?>

                <!-- Suivant -->
                <a href="<?= $pagination['links'][count($pagination['links']) - 2]['url'] ?? '#' ?>"
                    class="px-3 py-1 text-sm border rounded-lg <?= $pagination['current_page'] == $pagination['last_page'] ? 'text-gray-400 bg-gray-100 dark:bg-gray-700 border-gray-200 dark:border-gray-600 cursor-not-allowed' : $themeClasses['pageLink'] ?> focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2"
                    aria-label="Page suivante" <?= $pagination['current_page'] == $pagination['last_page'] ? 'aria-disabled="true"' : '' ?>>
                    &rsaquo;
                </a>

                <!-- Dernier -->
                <a href="<?= end($pagination['links'])['url'] ?? '#' ?>"
                    class="px-3 py-1 text-sm border rounded-lg <?= $pagination['current_page'] == $pagination['last_page'] ? 'text-gray-400 bg-gray-100 dark:bg-gray-700 border-gray-200 dark:border-gray-600 cursor-not-allowed' : $themeClasses['pageLink'] ?> focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2"
                    aria-label="Dernière page" <?= $pagination['current_page'] == $pagination['last_page'] ? 'aria-disabled="true"' : '' ?>>
                    &raquo;
                </a>
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
                        bulkActionsBar?.classList.remove('hidden');
                        bulkActionsBar?.setAttribute('aria-hidden', 'false');
                        selectedCount.querySelector('span:last-child').textContent = `${selected} élément${selected > 1 ? 's' : ''} sélectionné${selected > 1 ? 's' : ''}`;
                    } else {
                        bulkActionsBar?.classList.add('hidden');
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


    });
</script>
<script>

    function toggleFilters() {
        const container = document.getElementById('filtersContainer');
        if (container) {
            const isHidden = container.classList.toggle('hidden');
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
        container.classList.remove('hidden');
        container.setAttribute('aria-hidden', 'false');
        if (filterButton) {
            filterButton.setAttribute('aria-expanded', 'true');
        }
    }
</script>
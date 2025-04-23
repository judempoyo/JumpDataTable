<div
    class="max-w-full mx-auto p-6 mt-8 rounded-xl <?= $theme === 'dark' ? 'dark:bg-gray-900 bg-gray-900' : 'bg-white shadow-sm' ?> animate__animated animate__fadeIn">
    <!-- Bulk Actions Bar - Style amélioré -->
    <?php if ($enableRowSelection && !empty($bulkActions)): ?>
        <div id="bulkActionsBar"
            class="hidden flex items-center justify-between p-4 mb-4 rounded-lg border <?= $theme === 'dark' ? 'bg-gray-800 border-gray-700' : 'bg-gray-50 border-gray-200' ?> shadow-sm transition-all duration-200">
            <div class="flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 <?= $theme === 'dark' ? 'text-primary-400' : 'text-primary-500' ?>" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                        clip-rule="evenodd" />
                </svg>
                <span id="selectedCount"
                    class="text-sm font-medium <?= $theme === 'dark' ? 'text-gray-200' : 'text-gray-700' ?>">0 éléments
                    sélectionnés</span>
            </div>
            <div class="flex gap-2">
                <?php foreach ($bulkActions as $action): ?>
                    <button type="button"
                        class="bulk-action-btn flex items-center gap-2 px-3 py-1.5 text-sm font-medium rounded-md transition-colors <?= $theme === 'dark' ? 'bg-gray-700 hover:bg-gray-600 text-gray-200' : 'bg-white hover:bg-gray-100 text-gray-700 border border-gray-200' ?>"
                        data-action="<?= htmlspecialchars($action['url']) ?>" title="<?= htmlspecialchars($action['label']) ?>">
                        <?= $action['icon'] ?? '' ?>
                        <span><?= htmlspecialchars($action['label']) ?></span>
                    </button>
                <?php endforeach; ?>
                <button type="button" id="clearSelection"
                    class="flex items-center gap-2 px-3 py-1.5 text-sm rounded-md <?= $theme === 'dark' ? 'text-gray-300 hover:text-white hover:bg-gray-700' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span>Annuler</span>
                </button>
            </div>
        </div>
    <?php endif; ?>

    <!-- Header Section - Modern Card Style -->
    <div
        class="flex flex-col justify-between gap-6 mb-8 md:flex-row md:items-center p-6 rounded-xl <?= $theme === 'dark' ? 'bg-gray-800' : 'bg-gray-50' ?>">
        <div class="flex items-center gap-4">
            <h1
                class="text-xl font-bold md:text-2xl animate__animated animate__fadeInLeft <?= $theme === 'dark' ? 'text-white' : 'text-gray-900' ?>">
                <?= htmlspecialchars($title) ?>
                <?php if (!empty($data) && count($data) > 0): ?>
                    <span
                        class="ml-3 px-3 py-1 text-xs font-semibold rounded-full <?= $theme === 'dark' ? 'bg-primary-600/20 text-primary-300' : 'bg-primary-100 text-primary-800' ?>">
                        <?= count($data) ?> élément<?= count($data) > 1 ? 's' : '' ?>
                    </span>
                <?php endif; ?>
            </h1>
        </div>

        <div class="flex flex-wrap items-center gap-3 animate__animated animate__fadeInRight">
            <?php if (!empty($filters)): ?>
                <button type="button" onclick="toggleFilters()"
                    class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 <?= $theme === 'dark' ? 'bg-gray-700 text-gray-200 hover:bg-gray-600' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                            clip-rule="evenodd" />
                    </svg>
                    Filtres
                </button>
            <?php endif; ?>

            <?php if ($showExport): ?>
                <a href="<?= $publicUrl . $modelName ?>/export"
                    class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 <?= $theme === 'dark' ? 'bg-gray-700 text-gray-200 hover:bg-gray-600' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                    </svg>
                    Exporter
                </a>
            <?php endif; ?>

            <a href="<?= $createUrl ?>"
                class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white rounded-lg transition-all duration-200 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Ajouter
            </a>
        </div>
    </div>

    <!-- Filters Section - Modern Card Style -->
    <?php if (!empty($filters)): ?>
        <div class="mb-6 animate__animated animate__fadeInUp">
            <form method="GET" action="" id="filterForm">
                <div id="filtersContainer"
                    class="<?= empty($_GET['search']) ? 'hidden' : '' ?> p-6 <?= $theme === 'dark' ? 'bg-gray-800' : 'bg-gray-50' ?> rounded-xl shadow-sm">
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                        <?php foreach ($filters as $filter): ?>
                            <div>
                                <label
                                    class="block mb-2 text-sm font-medium <?= $theme === 'dark' ? 'text-gray-300' : 'text-gray-700' ?>">
                                    <?= htmlspecialchars($filter['label'] ?? 'Filtrer') ?>
                                </label>
                                <input type="<?= htmlspecialchars($filter['type'] ?? 'text') ?>"
                                    name="<?= htmlspecialchars($filter['name'] ?? 'search') ?>"
                                    placeholder="<?= htmlspecialchars($filter['placeholder'] ?? 'Rechercher...') ?>"
                                    value="<?= htmlspecialchars($_GET[$filter['name'] ?? 'search'] ?? '') ?>"
                                    class="w-full px-4 py-2 text-sm transition duration-200 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500/50 focus:border-primary-500 <?= $theme === 'dark' ? 'bg-gray-700 border-gray-600 text-white placeholder-gray-400' : 'bg-white border-gray-300 text-gray-900 placeholder-gray-400' ?>" />
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="flex flex-wrap items-center justify-end gap-3 mt-6">
                        <?php if (!empty($_GET)): ?>
                            <a href="<?= $publicUrl . $modelName ?>"
                                class="px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 <?= $theme === 'dark' ? 'bg-gray-700 text-gray-200 hover:bg-gray-600' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200' ?>">
                                Réinitialiser
                            </a>
                        <?php endif; ?>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white rounded-lg transition-all duration-200 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 shadow-sm">
                            Appliquer les filtres
                        </button>
                    </div>
                </div>

                <input type="hidden" name="sort" value="<?= htmlspecialchars($_GET['sort'] ?? '') ?>">
                <input type="hidden" name="direction" value="<?= htmlspecialchars($_GET['direction'] ?? '') ?>">
            </form>
        </div>
    <?php endif; ?>

    <!-- Table Section - Modern Style -->
    <div class="overflow-hidden rounded-xl shadow-2xl animate__animated animate__fadeInUp">
        <table class="min-w-full divide-y <?= $theme === 'dark' ? 'divide-gray-700' : 'divide-gray-200' ?>">
            <thead class="<?= $theme === 'dark' ? 'bg-gray-800' : 'bg-gray-50' ?>">
                <tr>
                    <?php if ($enableRowSelection): ?>
                        <th scope="col" class="w-12 px-4 py-3 text-center">
                            <input type="checkbox" id="selectAll"
                                class="h-4 w-4 rounded border-2 <?= $theme === 'dark' ? 'border-gray-500 bg-gray-700 text-primary-400 focus:ring-primary-400' : 'border-gray-300 bg-white text-primary-500 focus:ring-primary-500' ?> transition-colors">
                        </th>
                    <?php endif; ?>
                    <?php foreach ($columns as $column): ?>
                        <th scope="col"
                            class="px-6 py-4 text-xs font-semibold tracking-wider text-left <?= $theme === 'dark' ? 'text-gray-300' : 'text-gray-500' ?> uppercase">
                            <div class="flex items-center group">
                                <span><?= htmlspecialchars($column['label']) ?></span>
                                <?php if (isset($column['sortable']) && $column['sortable']): ?>
                                    <a href="?sort=<?= $column['key'] ?>&direction=<?= $sort === $column['key'] && $direction === 'asc' ? 'desc' : 'asc' ?><?= !empty($_GET['search']) ? '&search=' . urlencode($_GET['search']) : '' ?>"
                                        class="ml-2 transition-opacity duration-200 opacity-0 group-hover:opacity-100">
                                        <?php if ($sort === $column['key']): ?>
                                            <span class="<?= $theme === 'dark' ? 'text-primary-400' : 'text-primary-500' ?>">
                                                <?= $direction === 'asc' ? '↑' : '↓' ?>
                                            </span>
                                        <?php else: ?>
                                            <span
                                                class="<?= $theme === 'dark' ? 'text-gray-400 hover:text-primary-400' : 'text-gray-400 hover:text-primary-500' ?>">↕</span>
                                        <?php endif; ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </th>
                    <?php endforeach; ?>

                    <?php if (!empty($actions)): ?>
                        <th scope="col"
                            class="px-6 py-4 text-xs font-semibold tracking-wider text-right <?= $theme === 'dark' ? 'text-gray-300' : 'text-gray-500' ?> uppercase">
                            Actions
                        </th>
                    <?php endif; ?>
                </tr>
            </thead>

            <tbody class="<?= $theme === 'dark' ? 'bg-gray-900 divide-gray-700' : 'bg-white divide-gray-200' ?>">
                <?php if (!empty($data) && count($data) > 0): ?>
                    <?php foreach ($data as $item): ?>
                        <tr class="transition-colors duration-150 <?= $theme === 'dark' ? 'hover:bg-gray-800/50' : 'hover:bg-gray-50' ?>"
                            data-id="<?= htmlspecialchars($item['id'] ?? '') ?>">
                            <?php if ($enableRowSelection): ?>
                                <td class="px-4 py-3 whitespace-nowrap text-center">
                                    <input type="checkbox"
                                        class="row-checkbox h-4 w-4 rounded border-2 <?= $theme === 'dark' ? 'border-gray-500 bg-gray-700 text-primary-400 focus:ring-primary-400' : 'border-gray-300 bg-white text-primary-500 focus:ring-primary-500' ?> transition-colors">
                                </td>
                            <?php endif; ?>
                            <?php foreach ($columns as $column): ?>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm <?= $theme === 'dark' ? 'text-gray-200' : 'text-gray-800' ?>">
                                        <?php if (isset($column['render']) && is_callable($column['render'])): ?>
                                            <?= $column['render']($item) ?>
                                        <?php else: ?>
                                            <?= htmlspecialchars($item[$column['key']] ?? '') ?>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            <?php endforeach; ?>

                            <?php if (!empty($actions)): ?>
                                <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                    <div class="flex justify-end space-x-3">
                                        <?php foreach ($actions as $action): ?>
                                            <a href="<?= $action['url']($item) ?>"
                                                class="p-2 transition-colors duration-200 rounded-full <?= $theme === 'dark' ? 'text-gray-400 hover:text-white hover:bg-gray-700' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-100' ?>"
                                                title="<?= htmlspecialchars($action['label']) ?>">
                                                <?= $action['icon'] ?? '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" /></svg>' ?>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="<?= count($columns ?? []) + (!empty($actions) ? 1 : 0) ?>"
                            class="px-6 py-16 text-center">
                            <div
                                class="flex flex-col items-center justify-center <?= $theme === 'dark' ? 'text-gray-400' : 'text-gray-500' ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mb-4 opacity-40" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-lg font-medium">Aucun résultat trouvé</p>
                                <p class="text-sm mt-1">Essayez de modifier vos critères de recherche</p>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php extract($params); ?>
<?php if(!empty($pagination) && $pagination['total'] > $pagination['per_page']): ?>
<div class="flex flex-col items-center justify-between mt-6 space-y-4 sm:flex-row sm:space-y-0 animate__animated animate__fadeInUp">
    <div class="text-sm text-gray-700 dark:text-gray-300">
        Affichage de <span class="font-medium"><?= ($pagination['current_page'] - 1) * $pagination['per_page'] + 1 ?></span> 
        à <span class="font-medium"><?= min($pagination['current_page'] * $pagination['per_page'], $pagination['total']) ?></span> 
        sur <span class="font-medium"><?= $pagination['total'] ?></span> résultats
    </div>
    
    <div class="flex items-center space-x-1">
        <!-- Premier -->
        <a href="<?= $pagination['links'][0]['url'] ?? '#' ?>" 
           class="px-3 py-1 text-sm border rounded-lg <?= $pagination['current_page'] == 1 ? 'text-gray-400 bg-gray-100 border-gray-200 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-500' : 'text-gray-700 bg-white border-gray-300 hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700' ?>">
            &laquo;
        </a>
        
        <!-- Précédent -->
        <a href="<?= $pagination['links'][1]['url'] ?? '#' ?>" 
           class="px-3 py-1 text-sm border rounded-lg <?= $pagination['current_page'] == 1 ? 'text-gray-400 bg-gray-100 border-gray-200 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-500' : 'text-gray-700 bg-white border-gray-300 hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700' ?>">
            &lsaquo;
        </a>
        
        <!-- Pages -->
        <?php 
        $startPage = max(1, $pagination['current_page'] - 2);
        $endPage = min($pagination['last_page'], $pagination['current_page'] + 2);
        
        foreach ($pagination['links'] as $link): 
            if (is_numeric($link['label'])): ?>
                <a href="<?= $link['url'] ?>" 
                   class="px-3 py-1 text-sm border rounded-lg <?= $link['active'] ? 'text-white bg-teal-500 border-teal-500 dark:bg-teal-600 dark:border-teal-600' : 'text-gray-700 bg-white border-gray-300 hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700' ?>">
                    <?= $link['label'] ?>
                </a>
            <?php endif;
        endforeach; ?>
        
        <!-- Suivant -->
        <a href="<?= $pagination['links'][count($pagination['links']) - 2]['url'] ?? '#' ?>" 
           class="px-3 py-1 text-sm border rounded-lg <?= $pagination['current_page'] == $pagination['last_page'] ? 'text-gray-700 bg-white border-gray-300 hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700' : 'text-gray-400 bg-gray-100 border-gray-200 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-500' ?>">
            &rsaquo;
        </a>
        
        <!-- Dernier -->
        <a href="<?= end($pagination['links'])['url'] ?? '#' ?>" 
           class="px-3 py-1 text-sm border rounded-lg <?= $pagination['current_page'] == $pagination['last_page'] ?  'text-gray-700 bg-white border-gray-300 hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700' : 'text-gray-400 bg-gray-100 border-gray-200 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-500'  ?>">
            &raquo;
        </a>
    </div>
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
            });
    </script>
</div>
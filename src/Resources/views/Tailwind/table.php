<div class="max-w-full mx-auto p-6 mt-8 rounded-xl <?= $theme === 'dark' ? 'dark:bg-gray-900 bg-gray-900' : 'bg-white' ?> animate__animated animate__fadeIn">
    <!-- Header Section - Modern Card Style -->
    <div class="flex flex-col justify-between gap-6 mb-8 md:flex-row md:items-center p-6 rounded-xl <?= $theme === 'dark' ? 'bg-gray-800' : 'bg-gray-50' ?>">
        <div class="flex items-center gap-4">
            <h1 class="text-xl font-bold md:text-2xl animate__animated animate__fadeInLeft <?= $theme === 'dark' ? 'text-white' : 'text-gray-900' ?>">
                <?= htmlspecialchars($title) ?>
                <?php if (!empty($data) && count($data) > 0): ?>
                    <span class="ml-3 px-3 py-1 text-xs font-semibold rounded-full <?= $theme === 'dark' ? 'bg-primary-600/20 text-primary-300' : 'bg-primary-100 text-primary-800' ?>">
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
                        <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                    </svg>
                    Filtres
                </button>
            <?php endif; ?>
            
            <?php if ($showExport): ?>
                <a href="<?= $publicUrl . $modelName ?>/export"
                    class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 <?= $theme === 'dark' ? 'bg-gray-700 text-gray-200 hover:bg-gray-600' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                    </svg>
                    Exporter
                </a>
            <?php endif; ?>
            
            <a href="<?= $createUrl ?>"
                class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white rounded-lg transition-all duration-200 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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
                <div id="filtersContainer" class="<?= empty($_GET['search']) ? 'hidden' : '' ?> p-6 <?= $theme === 'dark' ? 'bg-gray-800' : 'bg-gray-50' ?> rounded-xl shadow-sm">
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                        <?php foreach ($filters as $filter): ?>
                            <div>
                                <label class="block mb-2 text-sm font-medium <?= $theme === 'dark' ? 'text-gray-300' : 'text-gray-700' ?>">
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
                                            <span class="<?= $theme === 'dark' ? 'text-gray-400 hover:text-primary-400' : 'text-gray-400 hover:text-primary-500' ?>">↕</span>
                                        <?php endif; ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </th>
                    <?php endforeach; ?>
                    
                    <?php if (!empty($actions)): ?>
                        <th scope="col" class="px-6 py-4 text-xs font-semibold tracking-wider text-right <?= $theme === 'dark' ? 'text-gray-300' : 'text-gray-500' ?> uppercase">
                            Actions
                        </th>
                    <?php endif; ?>
                </tr>
            </thead>
            
            <tbody class="<?= $theme === 'dark' ? 'bg-gray-900 divide-gray-700' : 'bg-white divide-gray-200' ?>">
                <?php if (!empty($data) && count($data) > 0): ?>
                    <?php foreach ($data as $item): ?>
                        <tr class="transition-colors duration-150 <?= $theme === 'dark' ? 'hover:bg-gray-800/50' : 'hover:bg-gray-50' ?>">
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
                        <td colspan="<?= count($columns ?? []) + (!empty($actions) ? 1 : 0) ?>" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center justify-center <?= $theme === 'dark' ? 'text-gray-400' : 'text-gray-500' ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mb-4 opacity-40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
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

    <script>
    function toggleFilters() {
        const container = document.getElementById('filtersContainer');
        if (container) {
            container.classList.toggle('hidden');
            localStorage.setItem('filtersVisible', container.classList.contains('hidden') ? 'false' : 'true');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const filtersVisible = localStorage.getItem('filtersVisible');
        const container = document.getElementById('filtersContainer');
        
        if (container && filtersVisible === 'true') {
            container.classList.remove('hidden');
        }
    });
    </script>
</div>
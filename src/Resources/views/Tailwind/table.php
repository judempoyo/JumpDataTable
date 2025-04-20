<!DOCTYPE html>
<html lang="fr" class="<?= $theme === 'dark' ? 'dark' : '' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Liste des éléments') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        },
                        dark: {
                            800: '#1e293b',
                            900: '#0f172a',
                        }
                    },
                    boxShadow: {
                        'xl': '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)',
                    }
                }
            }
        }
    </script>
    <style>
        .dt-action-btn {
            transition: all 0.2s ease;
            opacity: 0.8;
        }
        .dt-action-btn:hover {
            opacity: 1;
            transform: scale(1.1);
        }
        .dt-table-row {
            transition: background-color 0.2s ease;
        }
    </style>
</head>
<body class="<?= $theme === 'dark' ? 'bg-dark-900 text-gray-100' : 'bg-gray-50 text-gray-900' ?>">
    <div class="max-w-full mx-auto p-6 mt-8 bg-white rounded-xl shadow-xl <?= $theme === 'dark' ? 'dark:bg-dark-800' : '' ?> animate__animated animate__fadeIn">
        <!-- Header Section -->
        <div class="flex flex-col justify-between gap-6 mb-8 md:flex-row md:items-center">
            <div class="flex items-center gap-4">
                <h1 class="text-2xl font-bold <?= $theme === 'dark' ? 'text-white' : 'text-gray-800' ?> md:text-3xl animate__animated animate__fadeInLeft">
                    <?= htmlspecialchars($title) ?>
                </h1>
                <?php if (!empty($data) && count($data) > 0): ?>
                    <span class="px-3 py-1 text-sm font-medium rounded-full <?= $theme === 'dark' ? 'bg-primary-800 text-primary-100' : 'bg-primary-100 text-primary-800' ?>">
                        <?= count($data) ?> élément<?= count($data) > 1 ? 's' : '' ?>
                    </span>
                <?php endif; ?>
            </div>
            
            <div class="flex flex-wrap items-center gap-3 animate__animated animate__fadeInRight">
                <?php if (!empty($filters)): ?>
                    <button type="button" onclick="toggleFilters()"
                        class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg transition-all <?= $theme === 'dark' ? 'bg-dark-700 text-gray-200 hover:bg-dark-600 border border-dark-600' : 'bg-white text-gray-700 hover:bg-gray-50 border border-gray-200' ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 <?= $theme === 'dark' ? 'text-gray-300 group-hover:text-primary-400' : 'text-gray-500 group-hover:text-primary-500' ?>" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                        </svg>
                        Filtres
                    </button>
                <?php endif; ?>
                
                <?php if ($showExport): ?>
                    <a href="<?= $publicUrl . $modelName ?>/export"
                        class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg transition-all <?= $theme === 'dark' ? 'bg-dark-700 text-gray-200 hover:bg-dark-600 border border-dark-600' : 'bg-white text-gray-700 hover:bg-gray-50 border border-gray-200' ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 <?= $theme === 'dark' ? 'text-gray-300 group-hover:text-primary-400' : 'text-gray-500 group-hover:text-primary-500' ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Exporter
                    </a>
                <?php endif; ?>
                
                <a href="<?= $createUrl ?>"
                    class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white rounded-lg transition-all <?= $theme === 'dark' ? 'bg-primary-600 hover:bg-primary-700' : 'bg-primary-500 hover:bg-primary-600' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Ajouter
                </a>
            </div>
        </div>

        <!-- Filters Section -->
        <?php if (!empty($filters)): ?>
            <div class="mb-6 animate__animated animate__fadeInUp">
                <form method="GET" action="" id="filterForm">
                    <div id="filtersContainer" class="<?= empty($_GET['search']) ? 'hidden' : '' ?> p-4 mt-2 <?= $theme === 'dark' ? 'bg-dark-700' : 'bg-gray-50' ?> rounded-lg">
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                            <?php foreach ($filters as $filter): ?>
                                <div>
                                    <label class="block mb-1 text-sm font-medium <?= $theme === 'dark' ? 'text-gray-300' : 'text-gray-700' ?>">
                                        <?= htmlspecialchars($filter['label'] ?? 'Filtrer') ?>
                                    </label>
                                    <input type="<?= htmlspecialchars($filter['type'] ?? 'text') ?>" 
                                           name="<?= htmlspecialchars($filter['name'] ?? 'search') ?>" 
                                           placeholder="<?= htmlspecialchars($filter['placeholder'] ?? 'Rechercher...') ?>"
                                           value="<?= htmlspecialchars($_GET[$filter['name'] ?? 'search'] ?? '') ?>"
                                           class="w-full px-3 py-2 text-sm transition duration-300 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 <?= $theme === 'dark' ? 'bg-dark-800 border-dark-600 text-white placeholder-gray-400' : 'bg-white border-gray-300 text-gray-900 placeholder-gray-400' ?>" />
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <div class="flex flex-wrap items-center justify-end gap-3 mt-4">
                            <?php if (!empty($_GET)): ?>
                                <a href="<?= $publicUrl . $modelName ?>"
                                    class="px-4 py-2 text-sm font-medium rounded-lg <?= $theme === 'dark' ? 'bg-dark-700 text-gray-200 hover:bg-dark-600 border border-dark-600' : 'bg-white text-gray-700 hover:bg-gray-50 border border-gray-200' ?>">
                                    Réinitialiser
                                </a>
                            <?php endif; ?>
                            <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white rounded-lg <?= $theme === 'dark' ? 'bg-primary-600 hover:bg-primary-700' : 'bg-primary-500 hover:bg-primary-600' ?>">
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
        <div class="overflow-x-auto rounded-lg shadow-md animate__animated animate__fadeInUp">
            <table class="min-w-full divide-y <?= $theme === 'dark' ? 'divide-dark-600' : 'divide-gray-200' ?>">
                <thead class="<?= $theme === 'dark' ? 'bg-dark-700' : 'bg-gray-50' ?>">
                    <tr>
                        <?php foreach ($columns as $column): ?>
                            <th scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-left <?= $theme === 'dark' ? 'text-gray-300' : 'text-gray-500' ?> uppercase">
                                <div class="flex items-center group">
                                    <span><?= htmlspecialchars($column['label']) ?></span>
                                    <?php if (isset($column['sortable']) && $column['sortable']): ?>
                                        <a href="?sort=<?= $column['key'] ?>&direction=<?= $sort === $column['key'] && $direction === 'asc' ? 'desc' : 'asc' ?><?= !empty($_GET['search']) ? '&search=' . urlencode($_GET['search']) : '' ?>"
                                           class="ml-1 transition-opacity duration-200 opacity-0 group-hover:opacity-100">
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
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-right <?= $theme === 'dark' ? 'text-gray-300' : 'text-gray-500' ?> uppercase">
                                Actions
                            </th>
                        <?php endif; ?>
                    </tr>
                </thead>
                
                <tbody class="<?= $theme === 'dark' ? 'bg-dark-800 divide-dark-600' : 'bg-white divide-gray-200' ?>">
                    <?php if (!empty($data) && count($data) > 0): ?>
                        <?php foreach ($data as $item): ?>
                            <tr class="dt-table-row <?= $theme === 'dark' ? 'hover:bg-dark-700/50' : 'hover:bg-gray-50' ?>">
                                <?php foreach ($columns as $column): ?>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm <?= $theme === 'dark' ? 'text-gray-100' : 'text-gray-900' ?>">
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
                                        <div class="flex justify-end space-x-2">
                                            <?php foreach ($actions as $action): ?>
                                                <a href="<?= $action['url']($item) ?>"
                                                   class="dt-action-btn p-1.5 <?= $theme === 'dark' ? 'text-gray-300 hover:bg-dark-700' : 'text-gray-500 hover:bg-gray-100' ?> rounded-full"
                                                   title="<?= htmlspecialchars($action['label']) ?>">
                                                   <?= $action['icon'] ?? '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" /></svg>' ?>
                                                </a>
                                            <?php endforeach; ?>
                                        </div>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="<?= count($columns) + (!empty($actions) ? 1 : 0) ?>" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center <?= $theme === 'dark' ? 'text-gray-400' : 'text-gray-500' ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mb-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="text-lg font-medium">Aucun résultat trouvé</p>
                                    <p class="text-sm">Essayez de modifier vos critères de recherche</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
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
</body>
</html>
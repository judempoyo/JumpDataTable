<!DOCTYPE html>
<html lang="en" class="<?= $theme === 'dark' ? 'dark' : 'light' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Liste des éléments') ?></title>
    <link rel="stylesheet" href="path/to/your/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="<?= $theme === 'dark' ? 'bg-gray-900 text-white' : 'bg-white text-gray-900' ?>">
    <div class="max-w-full p-6 mx-auto mt-8 bg-white rounded-lg shadow-lg <?= $theme === 'dark' ? 'dark:bg-gray-800' : '' ?> animate__animated animate__fadeIn">
        <!-- Header Section -->
        <div class="flex flex-col justify-between gap-6 mb-6 md:flex-row md:items-center">
            <div class="flex items-center gap-4">
                <h1 class="text-2xl font-bold <?= $theme === 'dark' ? 'text-white' : 'text-gray-900' ?> md:text-3xl animate__animated animate__fadeInLeft">
                    <?= htmlspecialchars($title) ?>
                </h1>
                <?php if (!empty($data) && (is_array($data) || $data instanceof Countable) && count($data) > 0): ?>
                    <span class="px-3 py-1 text-sm font-medium <?= $theme === 'dark' ? 'text-teal-200 bg-teal-900' : 'text-teal-800 bg-teal-100' ?> rounded-full">
                        <?= count($data) ?> élément<?= count($data) > 1 ? 's' : '' ?>
                    </span>
                <?php endif; ?>
            </div>
            <div class="flex flex-wrap items-center gap-3 animate__animated animate__fadeInRight">
                <?php if (!empty($filters)): ?>
                    <button type="button" onclick="toggleFilters()"
                        class="flex items-center gap-2 px-4 py-2 text-sm font-medium <?= $theme === 'dark' ? 'text-gray-300 bg-gray-700 border-gray-600 hover:bg-gray-600' : 'text-gray-700 bg-white border-gray-300 hover:bg-gray-50' ?> rounded-lg group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 <?= $theme === 'dark' ? 'text-gray-300 group-hover:text-teal-500' : 'text-gray-500 group-hover:text-teal-500' ?>" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                        </svg>
                        Filtres
                    </button>
                <?php endif; ?>
                <?php if ($showExport): ?>
                    <a href="<?= $publicUrl . $modelName ?>/export"
                        class="flex items-center gap-2 px-4 py-2 text-sm font-medium <?= $theme === 'dark' ? 'text-gray-300 bg-gray-700 border-gray-600 hover:bg-gray-600' : 'text-gray-700 bg-white border-gray-300 hover:bg-gray-50' ?> rounded-lg group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 <?= $theme === 'dark' ? 'text-gray-300 group-hover:text-teal-500' : 'text-gray-500 group-hover:text-teal-500' ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Exporter
                    </a>
                <?php endif; ?>
                <a href="<?= $createUrl ?>"
                    class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white transition-all duration-300 <?= $theme === 'dark' ? 'bg-teal-600 hover:bg-teal-700' : 'bg-teal-500 hover:bg-teal-600' ?> rounded-lg group">
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
                    <div id="filtersContainer" class="<?= empty($_GET['search']) ? 'hidden' : '' ?> p-4 mt-2 <?= $theme === 'dark' ? 'bg-gray-700' : 'bg-gray-50' ?> rounded-lg">
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
                                           class="w-full px-3 py-2 text-sm transition duration-300 border <?= $theme === 'dark' ? 'bg-gray-800 border-gray-600 text-white placeholder-gray-400 focus:ring-teal-500 focus:border-teal-500' : 'bg-white border-gray-300 text-gray-900 placeholder-gray-400 focus:ring-teal-500 focus:border-teal-500' ?> rounded-lg shadow-sm focus:outline-none" />
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="flex flex-wrap items-center justify-end gap-3 mt-4">
                            <?php if (!empty($_GET)): ?>
                                <a href="<?= $publicUrl  . $modelName ?>"
                                    class="px-4 py-2 text-sm font-medium <?= $theme === 'dark' ? 'text-gray-300 bg-gray-600 border-gray-500 hover:bg-gray-500' : 'text-gray-700 bg-white border-gray-300 hover:bg-gray-50' ?> rounded-lg">
                                    Réinitialiser
                                </a>
                            <?php endif; ?>
                            <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white <?= $theme === 'dark' ? 'bg-teal-600 hover:bg-teal-700' : 'bg-teal-500 hover:bg-teal-600' ?> rounded-lg">
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
        <div class="overflow-x-auto rounded-lg shadow animate__animated animate__fadeInUp">
            <table class="min-w-full divide-y <?= $theme === 'dark' ? 'divide-gray-700' : 'divide-gray-200' ?>">
                <thead class="<?= $theme === 'dark' ? 'bg-gray-800' : 'bg-gray-50' ?>">
                    <tr>
                        <?php foreach ($columns as $column): ?>
                            <th scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-left <?= $theme === 'dark' ? 'text-gray-300' : 'text-gray-500' ?> uppercase">
                                <?= htmlspecialchars($column['label']) ?>
                            </th>
                        <?php endforeach; ?>
                        <?php if (!empty($actions)): ?>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-right <?= $theme === 'dark' ? 'text-gray-300' : 'text-gray-500' ?> uppercase">
                                Actions
                            </th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody class="<?= $theme === 'dark' ? 'bg-gray-800 divide-gray-700' : 'bg-white divide-gray-200' ?>">
                    <?php if (!empty($data) && (is_array($data) || $data instanceof Countable) && count($data) > 0): ?>
                        <?php foreach ($data as $item): ?>
                            <tr class="transition duration-150 <?= $theme === 'dark' ? 'hover:bg-gray-700/50' : 'hover:bg-gray-50' ?>">
                                <?php foreach ($columns as $column): ?>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?= htmlspecialchars($item[$column['key']] ?? '') ?>
                                    </td>
                                <?php endforeach; ?>
                                <?php if (!empty($actions)): ?>
                                    <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                        <div class="flex justify-end space-x-2">
                                            <?php foreach ($actions as $action): ?>
                                                <a href="<?= $action['url']($item) ?>"
                                                   class="p-1.5 <?= $theme === 'dark' ? 'text-gray-300 hover:bg-gray-700' : 'text-gray-500 hover:bg-gray-100' ?> transition duration-200 rounded-full"
                                                   title="<?= htmlspecialchars($action['label']) ?>">
                                                    <?= $action['icon'] ?? '' ?>
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
    document.addEventListener('DOMContentLoaded', function() {
        function toggleFilters() {
            const container = document.getElementById('filtersContainer');
            if (container) {
                container.classList.toggle('hidden');
            }
        }
        
        window.toggleFilters = toggleFilters;
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
    </script>
</body>
</html>
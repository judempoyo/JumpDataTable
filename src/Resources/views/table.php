<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Liste des éléments') ?></title>
    <link rel="stylesheet" href="path/to/your/styles.css"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="max-w-full p-6 mx-auto mt-8 bg-white rounded-lg shadow-lg dark:bg-gray-800 animate__animated animate__fadeIn">
        <!-- Header Section -->
        <div class="flex flex-col justify-between gap-6 mb-6 md:flex-row md:items-center">
            <div class="flex items-center gap-4">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white md:text-3xl animate__animated animate__fadeInLeft">
                    <?= htmlspecialchars($title) ?>
                </h1>
                <?php if ($data && $data->total() > 0): ?>
                    <span class="px-3 py-1 text-sm font-medium text-teal-800 bg-teal-100 rounded-full dark:bg-teal-900 dark:text-teal-200">
                        <?= $data->total() ?> élément<?= $data->total() > 1 ? 's' : '' ?>
                    </span>
                <?php endif; ?>
            </div>
            <div class="flex flex-wrap items-center gap-3 animate__animated animate__fadeInRight">
                <?php if (!empty($filters)): ?>
                    <button type="button" onclick="toggleFilters()"
                        class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 transition-all duration-300 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600 group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500 group-hover:text-teal-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                        </svg>
                        Filtres
                    </button>
                <?php endif; ?>
                <?php if ($showExport): ?>
                    <a href="<?= PUBLIC_URL . $modelName ?>/export"
                        class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 transition-all duration-300 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600 group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500 group-hover:text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Exporter
                    </a>
                <?php endif; ?>
                <a href="<?= $createUrl ?>"
                    class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white transition-all duration-300 bg-teal-500 rounded-lg hover:bg-teal-600 dark:bg-teal-600 dark:hover:bg-teal-700 group">
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
                    <div id="filtersContainer" class="<?= empty($_GET['search']) ? 'hidden' : '' ?> p-4 mt-2 bg-gray-50 rounded-lg dark:bg-gray-700">
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                            <?php foreach ($filters as $filter): ?>
                                <div>
                                    <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">
                                        <?= htmlspecialchars($filter['label'] ?? 'Filtrer') ?>
                                    </label>
                                    <input type="<?= htmlspecialchars($filter['type'] ?? 'text') ?>" 
                                           name="<?= htmlspecialchars($filter['name'] ?? 'search') ?>" 
                                           placeholder="<?= htmlspecialchars($filter['placeholder'] ?? 'Rechercher...') ?>"
                                           value="<?= htmlspecialchars($_GET[$filter['name'] ?? 'search'] ?? '') ?>"
                                           class="w-full px-3 py-2 text-sm transition duration-300 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white dark:placeholder-gray-400" />
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="flex flex-wrap items-center justify-end gap-3 mt-4">
                            <?php if (!empty($_GET)): ?>
                                <a href="<?= PUBLIC_URL . $modelName ?>"
                                    class="px-4 py-2 text-sm font-medium text-gray-700 transition duration-300 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-600 dark:border-gray-500 dark:text-gray-300 dark:hover:bg-gray-500">
                                    Réinitialiser
                                </a>
                            <?php endif; ?>
                            <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white transition duration-300 bg-teal-500 rounded-lg hover:bg-teal-600 dark:bg-teal-600 dark:hover:bg-teal-700">
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
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <?php foreach ($columns as $column): ?>
                            <th scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                <?= htmlspecialchars($column['label']) ?>
                            </th>
                        <?php endforeach; ?>
                        <?php if (!empty($actions)): ?>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase dark:text-gray-300">
                                Actions
                            </th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                    <?php if ($data && $data->count() > 0): ?>
                        <?php foreach ($data as $item): ?>
                            <tr class="transition duration-150 hover:bg-gray-50 dark:hover:bg-gray-700/50">
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
                                                   class="p-1.5 text-gray-500 transition duration-200 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700"
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
                                <div class="flex flex-col items-center justify-center text-gray-500 dark:text-gray-400">
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
    <script src="./assets/js/man.js"></script> <!-- Link to your JS file -->
</body>
</html>
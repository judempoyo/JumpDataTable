<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Liste des éléments') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .animate__animated { animation-duration: 0.5s; }
        .animate__fadeIn { animation-name: fadeIn; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    </style>
</head>
<body class="<?= $theme === 'dark' ? 'bg-dark' : 'bg-light' ?>">
    <div class="<?= $themeClasses['container'] ?>">
        <!-- Header Section -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center gap-3 mb-3 mb-md-0">
                <h1 class="<?= $themeClasses['title'] ?> mb-0">
                    <?= htmlspecialchars($title) ?>
                </h1>
                <?php if (!empty($data) && count($data) > 0): ?>
                    <span class="<?= $themeClasses['countBadge'] ?>">
                        <?= count($data) ?> élément<?= count($data) > 1 ? 's' : '' ?>
                    </span>
                <?php endif; ?>
            </div>
            
            <div class="d-flex flex-wrap gap-2">
                <?php if (!empty($filters)): ?>
                    <button type="button" onclick="toggleFilters()" 
                        class="<?= $themeClasses['filterButton'] ?> d-flex align-items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"/>
                        </svg>
                        Filtres
                    </button>
                <?php endif; ?>
                
                <?php if ($showExport): ?>
                    <a href="<?= $publicUrl . $modelName ?>/export" 
                       class="<?= $themeClasses['exportButton'] ?> d-flex align-items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8.5 6.5a.5.5 0 0 0-1 0v3.793L6.354 9.146a.5.5 0 1 0-.708.708l2 2a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0-.708-.708L8.5 10.293V6.5z"/>
                            <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/>
                        </svg>
                        Exporter
                    </a>
                <?php endif; ?>
                
                <a href="<?= $createUrl ?>" class="<?= $themeClasses['addButton'] ?> d-flex align-items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                    </svg>
                    Ajouter
                </a>
            </div>
        </div>

        <!-- Filters Section -->
        <?php if (!empty($filters)): ?>
            <div class="mb-4 animate__animated animate__fadeIn">
                <form method="GET" action="" id="filterForm">
                    <div id="filtersContainer" class="<?= empty($_GET['search']) ? 'd-none' : '' ?> p-3 mb-3 <?= $theme === 'dark' ? 'bg-secondary' : 'bg-light' ?> rounded">
                        <div class="row g-3">
                            <?php foreach ($filters as $filter): ?>
                                <div class="col-md-4">
                                    <label class="form-label <?= $theme === 'dark' ? 'text-white' : '' ?>">
                                        <?= htmlspecialchars($filter['label'] ?? 'Filtrer') ?>
                                    </label>
                                    <input type="<?= htmlspecialchars($filter['type'] ?? 'text') ?>" 
                                           name="<?= htmlspecialchars($filter['name'] ?? 'search') ?>" 
                                           placeholder="<?= htmlspecialchars($filter['placeholder'] ?? 'Rechercher...') ?>"
                                           value="<?= htmlspecialchars($_GET[$filter['name'] ?? 'search'] ?? '') ?>"
                                           class="form-control <?= $theme === 'dark' ? 'bg-dark text-white' : '' ?>" />
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <div class="d-flex flex-wrap justify-content-end gap-2 mt-3">
                            <?php if (!empty($_GET)): ?>
                                <a href="<?= $publicUrl . $modelName ?>" 
                                   class="<?= $themeClasses['resetButton'] ?>">
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
        <div class="table-responsive animate__animated animate__fadeIn">
            <table class="table <?= $theme === 'dark' ? 'table-dark' : '' ?>">
                <thead class="<?= $theme === 'dark' ? 'table-dark' : 'table-light' ?>">
                    <tr>
                        <?php foreach ($columns as $column): ?>
                            <th scope="col" class="align-middle">
                                <div class="d-flex align-items-center">
                                    <span><?= htmlspecialchars($column['label']) ?></span>
                                    <?php if (isset($column['sortable']) && $column['sortable']): ?>
                                        <a href="?sort=<?= $column['key'] ?>&direction=<?= $sort === $column['key'] && $direction === 'asc' ? 'desc' : 'asc' ?>" 
                                           class="ms-1 text-decoration-none">
                                            <?php if ($sort === $column['key']): ?>
                                                <span class="<?= $theme === 'dark' ? 'text-info' : 'text-primary' ?>">
                                                    <?= $direction === 'asc' ? '↑' : '↓' ?>
                                                </span>
                                            <?php else: ?>
                                                <span class="<?= $theme === 'dark' ? 'text-secondary' : 'text-muted' ?>">↕</span>
                                            <?php endif; ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </th>
                        <?php endforeach; ?>
                        
                        <?php if (!empty($actions)): ?>
                            <th scope="col" class="text-end">Actions</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data) && count($data) > 0): ?>
                        <?php foreach ($data as $item): ?>
                            <tr>
                                <?php foreach ($columns as $column): ?>
                                    <td>
                                        <?= $column['render'] ? $column['render']($item) : htmlspecialchars($item[$column['key']] ?? '') ?>
                                    </td>
                                <?php endforeach; ?>
                                
                                <?php if (!empty($actions)): ?>
                                    <td class="text-end">
                                        <div class="d-flex gap-2 justify-content-end">
                                            <?php foreach ($actions as $action): ?>
                                                <a href="<?= $action['url']($item) ?>" 
                                                   class="<?= $themeClasses['actionButton'] ?>"
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
                            <td colspan="<?= count($columns) + (!empty($actions) ? 1 : 0) ?>" class="text-center py-5">
                                <div class="<?= $themeClasses['emptyState'] ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-emoji-frown mb-3" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                        <path d="M4.285 12.433a.5.5 0 0 0 .683-.183A3.498 3.498 0 0 1 8 10.5c1.295 0 2.426.703 3.032 1.75a.5.5 0 0 0 .866-.5A4.498 4.498 0 0 0 8 9.5a4.5 4.5 0 0 0-3.898 2.25.5.5 0 0 0 .183.683zM7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5zm4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5z"/>
                                    </svg>
                                    <h4 class="mb-2">Aucun résultat trouvé</h4>
                                    <p class="text-muted mb-0">Essayez de modifier vos critères de recherche</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function toggleFilters() {
        const container = document.getElementById('filtersContainer');
        if (container) {
            container.classList.toggle('d-none');
            localStorage.setItem('filtersVisible', container.classList.contains('d-none') ? 'false' : 'true');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const filtersVisible = localStorage.getItem('filtersVisible');
        const container = document.getElementById('filtersContainer');
        
        if (container && filtersVisible === 'true') {
            container.classList.remove('d-none');
        }
    });
    </script>
</body>
</html>
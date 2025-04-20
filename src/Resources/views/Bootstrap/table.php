<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Liste des éléments') ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .dt-container {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            border-radius: 0.5rem;
        }
        .dt-table {
            margin-bottom: 0;
        }
        .dt-table th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
        }
        .dt-actions a {
            transition: all 0.2s ease;
            opacity: 0.7;
        }
        .dt-actions a:hover {
            opacity: 1;
            transform: scale(1.1);
        }
        .dark-mode {
            background-color: #212529;
            color: #f8f9fa;
        }
    </style>
</head>
<body class="<?= $theme === 'dark' ? 'dark-mode' : '' ?>">
    <div class="container dt-container mt-4 p-4 <?= $theme === 'dark' ? 'bg-dark text-white' : 'bg-white' ?>">
        <!-- Header Section -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center mb-3 mb-md-0">
                <h1 class="h3 mb-0 me-3"><?= htmlspecialchars($title) ?></h1>
                <?php if (!empty($data) && count($data) > 0): ?>
                    <span class="badge <?= $theme === 'dark' ? 'bg-info text-dark' : 'bg-primary text-white' ?>">
                        <?= count($data) ?> élément<?= count($data) > 1 ? 's' : '' ?>
                    </span>
                <?php endif; ?>
            </div>
            
            <div class="btn-group">
                <?php if (!empty($filters)): ?>
                    <button type="button" onclick="toggleFilters()" 
                        class="btn <?= $theme === 'dark' ? 'btn-outline-light' : 'btn-outline-secondary' ?>">
                        <i class="bi bi-funnel"></i> Filtres
                    </button>
                <?php endif; ?>
                
                <?php if ($showExport): ?>
                    <a href="<?= $publicUrl . $modelName ?>/export" 
                       class="btn <?= $theme === 'dark' ? 'btn-outline-light' : 'btn-outline-secondary' ?>">
                        <i class="bi bi-download"></i> Exporter
                    </a>
                <?php endif; ?>
                
                <a href="<?= $createUrl ?>" class="btn <?= $theme === 'dark' ? 'btn-info' : 'btn-primary' ?>">
                    <i class="bi bi-plus-lg"></i> Ajouter
                </a>
            </div>
        </div>

        <!-- Filters Section -->
        <?php if (!empty($filters)): ?>
            <div class="mb-4" id="filtersContainer" style="<?= empty($_GET['search']) ? 'display:none' : '' ?>">
                <form method="GET" action="" id="filterForm">
                    <div class="p-3 mb-3 <?= $theme === 'dark' ? 'bg-secondary' : 'bg-light' ?> rounded">
                        <div class="row g-3">
                            <?php foreach ($filters as $filter): ?>
                                <div class="col-md-4">
                                    <label class="form-label">
                                        <?= htmlspecialchars($filter['label'] ?? 'Filtrer') ?>
                                    </label>
                                    <input type="<?= htmlspecialchars($filter['type'] ?? 'text') ?>" 
                                           name="<?= htmlspecialchars($filter['name'] ?? 'search') ?>" 
                                           placeholder="<?= htmlspecialchars($filter['placeholder'] ?? 'Rechercher...') ?>"
                                           value="<?= htmlspecialchars($_GET[$filter['name'] ?? 'search'] ?? '') ?>"
                                           class="form-control <?= $theme === 'dark' ? 'bg-dark text-white' : '' ?>">
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <?php if (!empty($_GET)): ?>
                                <a href="<?= $publicUrl . $modelName ?>" 
                                   class="btn <?= $theme === 'dark' ? 'btn-outline-light' : 'btn-outline-secondary' ?>">
                                    Réinitialiser
                                </a>
                            <?php endif; ?>
                            <button type="submit" class="btn <?= $theme === 'dark' ? 'btn-info' : 'btn-primary' ?>">
                                Appliquer
                            </button>
                        </div>
                    </div>
                    <input type="hidden" name="sort" value="<?= htmlspecialchars($_GET['sort'] ?? '') ?>">
                    <input type="hidden" name="direction" value="<?= htmlspecialchars($_GET['direction'] ?? '') ?>">
                </form>
            </div>
        <?php endif; ?>

        <!-- Table Section -->
        <div class="table-responsive">
            <table class="table dt-table <?= $theme === 'dark' ? 'table-dark' : '' ?>">
                <thead>
                    <tr>
                        <?php foreach ($columns as $column): ?>
                            <th scope="col">
                                <div class="d-flex align-items-center">
                                    <span><?= htmlspecialchars($column['label']) ?></span>
                                    <?php if (isset($column['sortable']) && $column['sortable']): ?>
                                        <a href="?sort=<?= $column['key'] ?>&direction=<?= $sort === $column['key'] && $direction === 'asc' ? 'desc' : 'asc' ?>" 
                                           class="ms-1 text-decoration-none">
                                            <?php if ($sort === $column['key']): ?>
                                                <i class="bi bi-arrow-<?= $direction === 'asc' ? 'up' : 'down' ?> <?= $theme === 'dark' ? 'text-info' : 'text-primary' ?>"></i>
                                            <?php else: ?>
                                                <i class="bi bi-arrow-down-up text-muted"></i>
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
                                        <?php if (isset($column['render']) && is_callable($column['render'])): ?>
                                            <?= $column['render']($item) ?>
                                        <?php else: ?>
                                            <?= htmlspecialchars($item[$column['key']] ?? '') ?>
                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; ?>
                                
                                <?php if (!empty($actions)): ?>
                                    <td class="text-end dt-actions">
                                        <div class="d-flex gap-2 justify-content-end">
                                            <?php foreach ($actions as $action): ?>
                                                <a href="<?= $action['url']($item) ?>" 
                                                   class="btn btn-sm <?= $theme === 'dark' ? 'btn-outline-light' : 'btn-outline-secondary' ?>"
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
                            <td colspan="<?= count($columns) + (!empty($actions) ? 1 : 0) ?>" class="text-center py-5">
                                <div class="<?= $theme === 'dark' ? 'text-white-50' : 'text-muted' ?>">
                                    <i class="bi bi-exclamation-circle display-6"></i>
                                    <h4 class="mt-3">Aucun résultat trouvé</h4>
                                    <p class="mb-0">Essayez de modifier vos critères de recherche</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function toggleFilters() {
        const container = document.getElementById('filtersContainer');
        if (container) {
            container.style.display = container.style.display === 'none' ? 'block' : 'none';
            localStorage.setItem('filtersVisible', container.style.display === 'none' ? 'false' : 'true');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const filtersVisible = localStorage.getItem('filtersVisible');
        const container = document.getElementById('filtersContainer');
        
        if (container && filtersVisible === 'true') {
            container.style.display = 'block';
        }
    });
    </script>
</body>
</html>
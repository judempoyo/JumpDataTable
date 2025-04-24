<div class="container-fluid">
    <!-- Bulk Actions Bar -->
    <?php if ($enableRowSelection && !empty($bulkActions)): ?>
    <div id="bulkActionsBar" class="d-none d-flex align-items-center justify-content-between p-3 mb-3 rounded bg-light border">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-check2-circle text-primary"></i>
            <span id="selectedCount">0 éléments sélectionnés</span>
        </div>
        <div class="d-flex gap-2">
            <?php foreach ($bulkActions as $action): ?>
                <button type="button" 
                        class="bulk-action-btn btn btn-sm btn-light d-flex align-items-center gap-2"
                        data-action="<?= htmlspecialchars($action['url']) ?>"
                        title="<?= htmlspecialchars($action['label']) ?>">
                    <?= $action['icon'] ?? '' ?>
                    <span><?= htmlspecialchars($action['label']) ?></span>
                </button>
            <?php endforeach; ?>
            <button type="button" id="clearSelection" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-2">
                <i class="bi bi-x-lg"></i>
                <span>Annuler</span>
            </button>
        </div>
    </div>
    <?php endif; ?>

    <!-- Header Section -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 mb-4 p-3 rounded bg-light">
        <div class="d-flex align-items-center gap-3">
            <h1 class="h4">
                <?= htmlspecialchars($title) ?>
                <?php if (!empty($data) && count($data) > 0): ?>
                    <span class="badge bg-primary ms-2">
                        <?= count($data) ?> élément<?= count($data) > 1 ? 's' : '' ?>
                    </span>
                <?php endif; ?>
            </h1>
        </div>
        
        <div class="d-flex flex-wrap align-items-center gap-2">
            <?php if (!empty($filters)): ?>
                <button type="button" onclick="toggleFilters()" class="btn btn-outline-secondary">
                    <i class="bi bi-funnel"></i>
                    Filtres
                </button>
            <?php endif; ?>
            
            <?php if ($showExport): ?>
                <a href="<?= $publicUrl . $modelName ?>/export" class="btn btn-outline-success">
                    <i class="bi bi-download"></i>
                    Exporter
                </a>
            <?php endif; ?>
            
            <a href="<?= $createUrl ?>" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i>
                Ajouter
            </a>
        </div>
    </div>

    <!-- Filters Section -->
    <?php if (!empty($filters)): ?>
        <div class="mb-4">
            <form method="GET" action="" id="filterForm">
                <div id="filtersContainer" class="<?= empty($_GET['search']) ? 'd-none' : '' ?> bg-light p-3 rounded border">
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
                                       class="form-control" />
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="d-flex flex-wrap justify-content-end gap-2 mt-3">
                        <?php if (!empty($_GET)): ?>
                            <a href="<?= $publicUrl . $modelName ?>" class="btn btn-outline-secondary">
                                Réinitialiser
                            </a>
                        <?php endif; ?>
                        <button type="submit" class="btn btn-primary">
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
    <div class="table-responsive rounded">
        <table class="table table-striped table-hover">
            <thead class="table-light">
                <tr>
                    <?php if ($enableRowSelection): ?>
                    <th scope="col" class="text-center" style="width: 50px;">
                        <input type="checkbox" id="selectAll" class="form-check-input">
                    </th>
                    <?php endif; ?>
                    <?php foreach ($columns as $column): ?>
                        <th scope="col">
                            <div class="d-flex align-items-center">
                                <span><?= htmlspecialchars($column['label']) ?></span>
                                <?php if (isset($column['sortable']) && $column['sortable']): ?>
                                    <a href="?sort=<?= $column['key'] ?>&direction=<?= $sort === $column['key'] && $direction === 'asc' ? 'desc' : 'asc' ?><?= !empty($_GET['search']) ? '&search=' . urlencode($_GET['search']) : '' ?>"
                                       class="ms-2 text-decoration-none">
                                        <?php if ($sort === $column['key']): ?>
                                            <span class="text-primary">
                                                <?= $direction === 'asc' ? '↑' : '↓' ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="text-muted">↕</span>
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
                        <tr data-id="<?= htmlspecialchars($item['id'] ?? '') ?>">
                            <?php if ($enableRowSelection): ?>
                            <td class="text-center">
                                <input type="checkbox" class="row-checkbox form-check-input">
                            </td>
                            <?php endif; ?>
                            <?php foreach ($columns as $column): ?>
                                <td>
                                    <div>
                                        <?php if (isset($column['render']) && is_callable($column['render'])): ?>
                                            <?= $column['render']($item) ?>
                                        <?php else: ?>
                                            <?= htmlspecialchars($item[$column['key']] ?? '') ?>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            <?php endforeach; ?>
                            
                            <?php if (!empty($actions)): ?>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <?php foreach ($actions as $action): ?>
                                            <a href="<?= $action['url']($item) ?>"
                                               class="btn btn-sm btn-outline-secondary"
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
                            <div>
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
</div>
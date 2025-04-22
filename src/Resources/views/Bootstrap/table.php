<div class="container-fluid p-4 mt-3 rounded-3 <?= $theme === 'dark' ? 'bg-dark bg-gradient' : 'bg-white shadow-sm' ?> animate__animated animate__fadeIn">
    <!-- Header Section - Modern Card Style -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 p-3 rounded-3 <?= $theme === 'dark' ? 'bg-dark' : 'bg-light' ?>">
        <div class="d-flex align-items-center mb-3 mb-md-0">
            <h1 class="h4 mb-0 me-3 fw-semibold <?= $theme === 'dark' ? 'text-white' : 'text-dark' ?>">
                <?= htmlspecialchars($title) ?>
                <?php if (!empty($data) && count($data) > 0): ?>
                    <span class="ms-2 badge rounded-pill <?= $theme === 'dark' ? 'bg-primary bg-opacity-25 text-primary' : 'bg-primary bg-opacity-10 text-primary' ?>">
                        <?= count($data) ?> élément<?= count($data) > 1 ? 's' : '' ?>
                    </span>
                <?php endif; ?>
            </h1>
        </div>
        
        <div class="btn-group shadow-sm">
            <?php if (!empty($filters)): ?>
                <button type="button" onclick="toggleFilters()" 
                    class="btn btn-sm <?= $theme === 'dark' ? 'btn-outline-light' : 'btn-outline-secondary' ?>">
                    <i class="bi bi-funnel me-1"></i> Filtres
                </button>
            <?php endif; ?>
            
            <?php if ($showExport): ?>
                <a href="<?= $publicUrl . $modelName ?>/export" 
                   class="btn btn-sm <?= $theme === 'dark' ? 'btn-outline-light' : 'btn-outline-secondary' ?>">
                    <i class="bi bi-download me-1"></i> Exporter
                </a>
            <?php endif; ?>
            
            <a href="<?= $createUrl ?>" class="btn btn-sm <?= $theme === 'dark' ? 'btn-primary' : 'btn-primary' ?>">
                <i class="bi bi-plus-lg me-1"></i> Ajouter
            </a>
        </div>
    </div>

    <!-- Filters Section - Modern Card Style -->
    <?php if (!empty($filters)): ?>
        <div class="mb-4 animate__animated animate__fadeIn" id="filtersContainer" style="<?= empty($_GET['search']) ? 'display:none' : '' ?>">
            <form method="GET" action="" id="filterForm">
                <div class="p-3 mb-3 <?= $theme === 'dark' ? 'bg-gray-800' : 'bg-light' ?> rounded-3 border <?= $theme === 'dark' ? 'border-gray-700' : 'border-light' ?>">
                    <div class="row g-3">
                        <?php foreach ($filters as $filter): ?>
                            <div class="col-md-4">
                                <label class="form-label small mb-1 <?= $theme === 'dark' ? 'text-white-50' : 'text-muted' ?>">
                                    <?= htmlspecialchars($filter['label'] ?? 'Filtrer') ?>
                                </label>
                                <input type="<?= htmlspecialchars($filter['type'] ?? 'text') ?>" 
                                       name="<?= htmlspecialchars($filter['name'] ?? 'search') ?>" 
                                       placeholder="<?= htmlspecialchars($filter['placeholder'] ?? 'Rechercher...') ?>"
                                       value="<?= htmlspecialchars($_GET[$filter['name'] ?? 'search'] ?? '') ?>"
                                       class="form-control form-control-sm <?= $theme === 'dark' ? 'bg-gray-700 text-white border-gray-600' : 'bg-white' ?>">
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="d-flex justify-content-end gap-2 mt-3">
                        <?php if (!empty($_GET)): ?>
                            <a href="<?= $publicUrl . $modelName ?>" 
                               class="btn btn-sm <?= $theme === 'dark' ? 'btn-outline-light' : 'btn-outline-secondary' ?>">
                                Réinitialiser
                            </a>
                        <?php endif; ?>
                        <button type="submit" class="btn btn-sm <?= $theme === 'dark' ? 'btn-primary' : 'btn-primary' ?>">
                            <i class="bi bi-check-lg me-1"></i> Appliquer
                        </button>
                    </div>
                </div>
                <input type="hidden" name="sort" value="<?= htmlspecialchars($_GET['sort'] ?? '') ?>">
                <input type="hidden" name="direction" value="<?= htmlspecialchars($_GET['direction'] ?? '') ?>">
            </form>
        </div>
    <?php endif; ?>

    <!-- Table Section - Modern Style -->
    <div class="table-responsive rounded-3 overflow-hidden border <?= $theme === 'dark' ? 'border-gray-700' : 'border-light' ?>">
        <table class="table table-hover mb-0 <?= $theme === 'dark' ? 'table-dark' : '' ?>">
            <thead class="<?= $theme === 'dark' ? 'bg-gray-800' : 'bg-light' ?>">
                <tr>
                    <?php foreach ($columns as $column): ?>
                        <th scope="col" class="align-middle py-3 px-4 <?= $theme === 'dark' ? 'text-white-50' : 'text-muted' ?>">
                            <div class="d-flex align-items-center">
                                <span class="small fw-semibold"><?= htmlspecialchars($column['label']) ?></span>
                                <?php if (isset($column['sortable']) && $column['sortable']): ?>
                                    <a href="?sort=<?= $column['key'] ?>&direction=<?= $sort === $column['key'] && $direction === 'asc' ? 'desc' : 'asc' ?>" 
                                       class="ms-1 text-decoration-none">
                                        <?php if ($sort === $column['key']): ?>
                                            <i class="bi bi-arrow-<?= $direction === 'asc' ? 'up' : 'down' ?> small <?= $theme === 'dark' ? 'text-primary' : 'text-primary' ?>"></i>
                                        <?php else: ?>
                                            <i class="bi bi-arrow-down-up small text-muted"></i>
                                        <?php endif; ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </th>
                    <?php endforeach; ?>
                    
                    <?php if (!empty($actions)): ?>
                        <th scope="col" class="align-middle py-3 px-4 text-end <?= $theme === 'dark' ? 'text-white-50' : 'text-muted' ?>">
                            <span class="small fw-semibold">Actions</span>
                        </th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody class="<?= $theme === 'dark' ? 'bg-gray-900' : 'bg-white' ?>">
                <?php if (!empty($data) && count($data) > 0): ?>
                    <?php foreach ($data as $item): ?>
                        <tr class="<?= $theme === 'dark' ? 'hover-bg-gray-800' : 'hover-bg-light' ?>">
                            <?php foreach ($columns as $column): ?>
                                <td class="py-3 px-4 <?= $theme === 'dark' ? 'text-white' : 'text-dark' ?>">
                                    <div class="small">
                                        <?php if (isset($column['render']) && is_callable($column['render'])): ?>
                                            <?= $column['render']($item) ?>
                                        <?php else: ?>
                                            <?= htmlspecialchars($item[$column['key']] ?? '') ?>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            <?php endforeach; ?>
                            
                            <?php if (!empty($actions)): ?>
                                <td class="py-3 px-4 text-end">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <?php foreach ($actions as $action): ?>
                                            <a href="<?= $action['url']($item) ?>" 
                                               class="btn btn-sm p-1 px-2 <?= $theme === 'dark' ? 'btn-outline-light' : 'btn-outline-secondary' ?>"
                                               title="<?= htmlspecialchars($action['label']) ?>"
                                               data-bs-toggle="tooltip">
                                               <?= $action['icon'] ?? '<i class="bi bi-three-dots-vertical"></i>' ?>
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
                                <i class="bi bi-exclamation-circle fs-1 opacity-50"></i>
                                <h5 class="mt-3 fw-semibold">Aucun résultat trouvé</h5>
                                <p class="mb-0 small">Essayez de modifier vos critères de recherche</p>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Enable tooltips
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
})

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
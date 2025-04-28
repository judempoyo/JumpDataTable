<div class="<?= $themeClasses['container'] ?> <?= $themeClasses['animation'] ?>">
    <!-- Bulk Actions Bar -->
    <?php if ($enableRowSelection && !empty($bulkActions)): ?>
        <div id="bulkActionsBar" class="<?= $themeClasses['bulkActionsContainer'] ?> d-none">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-2 text-primary fs-5"></i>
                <span id="selectedCount" class="fw-medium">0 éléments sélectionnés</span>
            </div>
            <div class="d-flex gap-2">
                <?php if (!empty($bulkActions) && is_array($bulkActions)): ?>
                    <?php foreach ($bulkActions as $action): ?>
                        <button type="button" class="<?= $themeClasses['bulkActionButton'] ?> bulk-action-btn">
                            <?= $action['icon'] ?? '' ?>
                            <span><?= htmlspecialchars($action['label'] ?? '') ?></span>
                        </button>
                    <?php endforeach; ?>
                <?php endif; ?>

                <button type="button" id="clearSelection" class="<?= $themeClasses['clearSelectionButton'] ?>">
                    <i class="bi bi-x-lg"></i>
                    <span>Annuler</span>
                </button>
            </div>
        </div>
    <?php endif; ?>

    <!-- Header Section -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 p-3 <?= $themeClasses['filtersContainer'] ?>">
        <div class="d-flex align-items-center mb-2 mb-md-0">
            <h1 class="<?= $themeClasses['title'] ?> me-3">
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
                <button type="button" onclick="toggleFilters()" class="<?= $themeClasses['filterButton'] ?>">
                    <i class="<?= $themeClasses['filterIcon'] ?>"></i> Filtres
                </button>
            <?php endif; ?>

            <?php if ($showExport): ?>
                <a href="<?= $publicUrl ."/". $modelName ?>/export" class="<?= $themeClasses['exportButton'] ?>">
                    <i class="<?= $themeClasses['exportIcon'] ?>"></i> Exporter
                </a>
            <?php endif; ?>

            <a href="<?= $createUrl ?>" class="<?= $themeClasses['addButton'] ?>">
                <i class="<?= $themeClasses['addIcon'] ?>"></i> Ajouter
            </a>
        </div>
    </div>

    <!-- Filters Section -->
    <?php if (!empty($filters)): ?>
        <div class="mb-4 <?= $themeClasses['animation'] ?>">
            <form method="GET" action="" id="filterForm">
                <div id="filtersContainer" class="<?= empty($_GET['search']) ? 'd-none' : '' ?> <?= $themeClasses['filtersContainer'] ?>">
                    <div class="row g-3">
                        <?php foreach ($filters as $filter): ?>
                            <div class="col-md-4">
                                <label class="<?= $themeClasses['filterLabel'] ?>">
                                    <?= htmlspecialchars($filter['label'] ?? 'Filtrer') ?>
                                </label>
                                <input type="<?= htmlspecialchars($filter['type'] ?? 'text') ?>"
                                    name="<?= htmlspecialchars($filter['name'] ?? 'search') ?>"
                                    placeholder="<?= htmlspecialchars($filter['placeholder'] ?? 'Rechercher...') ?>"
                                    value="<?= htmlspecialchars($_GET[$filter['name'] ?? 'search'] ?? '') ?>"
                                    class="<?= $themeClasses['filterInput'] ?>" />
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="d-flex flex-wrap justify-content-end gap-2 mt-3">
                        <?php if (!empty($_GET)): ?>
                            <a href="<?= $publicUrl ."/". $modelName ?>" class="<?= $themeClasses['resetButton'] ?>">
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
    <div class="table-responsive rounded <?= $themeClasses['animation'] ?>">
        <table class="<?= $themeClasses['table'] ?>">
            <thead class="<?= $themeClasses['tableHeader'] ?>">
                <tr>
                    <?php if ($enableRowSelection): ?>
                        <th scope="col" class="text-center" style="width: 40px;">
                            <input type="checkbox" id="selectAll" class="form-check-input">
                        </th>
                    <?php endif; ?>
                    <?php foreach ($columns as $column): ?>
                        <th scope="col" class="<?= $themeClasses['tableHeaderCell'] ?>">
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
                                            <span class="text-body-secondary">↕</span>
                                        <?php endif; ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </th>
                    <?php endforeach; ?>

                    <?php if (!empty($actions)): ?>
                        <th scope="col" class="<?= $themeClasses['tableHeaderCell'] ?> text-end">Actions</th>
                    <?php endif; ?>
                </tr>
            </thead>

            <tbody class="<?= $themeClasses['tableBody'] ?>">
                <?php if (!empty($data) && count($data) > 0): ?>
                    <?php foreach ($data as $item): ?>
                        <tr class="<?= $themeClasses['tableRow'] ?>" data-id="<?= htmlspecialchars($item['id'] ?? '') ?>">
                            <?php if ($enableRowSelection): ?>
                                <td class="text-center">
                                    <input type="checkbox" class="row-checkbox form-check-input">
                                </td>
                            <?php endif; ?>
                            <?php foreach ($columns as $column): ?>
                                <td class="<?= $themeClasses['tableCell'] ?>">
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
                                <td class="<?= $themeClasses['tableCell'] ?> text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <?php foreach ($actions as $action): ?>
                                            <a href="<?= $action['url']($item) ?>" class="<?= $themeClasses['actionButton'] ?>"
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
                        <td colspan="<?= count($columns) + (!empty($actions) ? 1 : 0) + ($enableRowSelection ? 1 : 0) ?>"
                            class="text-center py-5">
                            <div class="<?= $themeClasses['emptyState'] ?>">
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

    <!-- Pagination -->
    <?php if (!empty($pagination) && $pagination['total'] > $pagination['per_page']): ?>
        <div class="mt-4">
            <div class="text-center mb-3 text-body-secondary">
                Affichage de <?= ($pagination['current_page'] - 1) * $pagination['per_page'] + 1 ?>
                à <?= min($pagination['current_page'] * $pagination['per_page'], $pagination['total']) ?>
                sur <?= $pagination['total'] ?> résultats
            </div>

            <nav aria-label="Page navigation">
                <ul class="<?= $themeClasses['pagination'] ?>">
                    <li class="<?= $themeClasses['pageItem'] ?> <?= $pagination['current_page'] == 1 ? 'disabled' : '' ?>">
                        <a class="<?= $themeClasses['pageLink'] ?>" href="<?= $pagination['links'][0]['url'] ?? '#' ?>">
                            &laquo;
                        </a>
                    </li>

                    <?php foreach ($pagination['links'] as $link): ?>
                        <?php if (is_numeric($link['label'])): ?>
                            <li class="<?= $themeClasses['pageItem'] ?> <?= $link['active'] ? 'active' : '' ?>">
                                <a class="<?= $themeClasses['pageLink'] ?>" href="<?= $link['url'] ?>">
                                    <?= $link['label'] ?>
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>

                    <li class="<?= $themeClasses['pageItem'] ?> <?= $pagination['current_page'] == $pagination['last_page'] ? 'disabled' : '' ?>">
                        <a class="<?= $themeClasses['pageLink'] ?>" href="<?= end($pagination['links'])['url'] ?? '#' ?>">
                            &raquo;
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    <?php endif; ?>
</div>
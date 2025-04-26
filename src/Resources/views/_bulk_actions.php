<?php if ($enableRowSelection && !empty($bulkActions)): ?>
<div id="bulkActionsBar" class="<?= $themeClasses['bulkActionsContainer'] ?>">
    <div class="<?= $themeClasses['bulkActionsInfo'] ?>">
        <i class="<?= $themeClasses['bulkActionsIcon'] ?>"></i>
        <span id="selectedCount">0 éléments sélectionnés</span>
    </div>
    <div class="<?= $themeClasses['bulkActionsButtons'] ?>">
        <?php foreach ($bulkActions as $action): ?>
            <button type="button" 
                    class="<?= $themeClasses['bulkActionButton'] ?>"
                    data-action="<?= htmlspecialchars($action['url']) ?>"
                    title="<?= htmlspecialchars($action['label']) ?>">
                <?= $action['icon'] ?? '' ?>
                <span><?= htmlspecialchars($action['label']) ?></span>
            </button>
        <?php endforeach; ?>
        
        <button type="button" id="clearSelection" class="<?= $themeClasses['bulkActionCancel'] ?>">
            <i class="<?= $themeClasses['bulkActionCancelIcon'] ?>"></i>
            <span>Annuler</span>
        </button>
    </div>
</div>
<?php endif; ?>
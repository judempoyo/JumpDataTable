<?php

namespace Jump\JumpDataTable\Themes;

class BootstrapTheme implements ThemeInterface
{
    protected static array $presets = [
        'classic' => Presets\Bootstrap\ClassicTheme::class,
    ];
    
    protected static array $currentPreset = [];
    protected static array $customConfig = [];
    public static function getDefaultConfig(): array
    {
        return [
            'containerClass' => 'container-fluid p-4 mt-4 bg-body rounded shadow',
            'titleClass' => 'h3 mb-0 text-body',
            'countBadgeClass' => 'badge bg-primary',
            'filterButtonClass' => 'btn btn-outline-secondary',
            'exportButtonClass' => 'btn btn-outline-success',
            'addButtonClass' => 'btn btn-primary',
            'resetButtonClass' => 'btn btn-outline-secondary',
            'applyButtonClass' => 'btn btn-primary',
            'actionButtonClass' => 'btn btn-sm btn-outline-secondary',
            'filtersContainerClass' => 'p-3 mb-3 bg-body-secondary rounded',
            'filterInputClass' => 'form-control',
            'filterLabelClass' => 'form-label mb-2',
            'tableClass' => 'table table-striped table-hover',
            'tableHeaderClass' => '',
            'tableHeaderCellClass' => 'align-middle',
            'tableBodyClass' => '',
            'tableRowClass' => '',
            'tableCellClass' => '',
            'emptyStateClass' => 'text-center py-5 text-body-secondary',
            'paginationClass' => 'pagination justify-content-center',
            'pageItemClass' => 'page-item',
            'pageLinkClass' => 'page-link',
            'animationClass' => 'animate__animated',
            'bulkActionsContainer' => 'p-3 mb-3 bg-body-secondary rounded d-flex justify-content-between align-items-center',
            'bulkActionButton' => 'btn btn-sm btn-outline-secondary',
            'clearSelectionButton' => 'btn btn-sm btn-outline-danger',
            'filterIcon' => 'bi bi-funnel',
            'exportIcon' => 'bi bi-download',
            'addIcon' => 'bi bi-plus-lg'
        ];
    }

    public static function usePreset(string $presetName): void
    {
        if (!isset(self::$presets[$presetName])) {
            throw new \InvalidArgumentException("Preset $presetName not found. Available: " . implode(', ', array_keys(self::$presets)));
        }
        
        self::$currentPreset = call_user_func([self::$presets[$presetName], 'getConfig']);
    }

    public static function overridePreset(array $overrides): void
    {
        self::$customConfig = array_replace_recursive(self::$currentPreset, $overrides);
    }
    public static function getAvailablePresets(): array
    {
        return array_keys(self::$presets);
    }
    protected static function getConfigValue(string $key, $default = "")
    {
        if (isset(self::$customConfig[$key])) {
            return self::$customConfig[$key];
        }
        
        if (isset(self::$currentPreset[$key])) {
            return self::$currentPreset[$key];
        }
        
        return $default;
    }

    public static function getContainerClasses(): string
    {
        return self::getConfigValue('containerClass');
    }

    public static function getTitleClasses(): string
    {
        return self::getConfigValue('titleClass');
    }

    public static function getCountBadgeClasses(): string
    {
        return self::getConfigValue('countBadgeClass');
    }

    public static function getFilterButtonClasses(): string
    {
        return self::getConfigValue('filterButtonClass');
    }

    public static function getExportButtonClasses(): string
    {
        return self::getConfigValue('exportButtonClass');
    }

    public static function getAddButtonClasses(): string
    {
        return self::getConfigValue('addButtonClass');
    }

    public static function getResetButtonClasses(): string
    {
        return self::getConfigValue('resetButtonClass');
    }

    public static function getApplyButtonClasses(): string
    {
        return self::getConfigValue('applyButtonClass');
    }

    public static function getActionButtonClasses(): string
    {
        return self::getConfigValue('actionButtonClass');
    }

    public static function getFiltersContainerClasses(): string
    {
        return self::getConfigValue('filtersContainerClass');
    }

    public static function getFilterInputClasses(): string
    {
        return self::getConfigValue('filterInputClass');
    }

    public static function getFilterLabelClasses(): string
    {
        return self::getConfigValue('filterLabelClass');
    }

    public static function getTableClasses(): string
    {
        return self::getConfigValue('tableClass');
    }

    public static function getTableHeaderClasses(): string
    {
        return self::getConfigValue('tableHeaderClass');
    }

    public static function getTableHeaderCellClasses(): string
    {
        return self::getConfigValue('tableHeaderCellClass');
    }

    public static function getTableBodyClasses(): string
    {
        return self::getConfigValue('tableBodyClass');
    }

    public static function getTableRowClasses(): string
    {
        return self::getConfigValue('tableRowClass');
    }

    public static function getTableCellClasses(): string
    {
        return self::getConfigValue('tableCellClass');
    }

    public static function getEmptyStateClasses(): string
    {
        return self::getConfigValue('emptyStateClass');
    }

    public static function getFilterIconClasses(): string
    {
        return self::getConfigValue('filterIcon');
    }

    public static function getExportIconClasses(): string
    {
        return self::getConfigValue('exportIcon');
    }

    public static function getAddIconClasses(): string
    {
        return self::getConfigValue('addIcon');
    }

    public static function getPaginationClasses(): string
    {
        return self::getConfigValue('paginationClass');
    }

    public static function getPageItemClasses(bool $active = false): string
    {
        return self::getConfigValue('pageItemClass') . ($active ? ' active' : '');
    }

    public static function getPageLinkClasses(bool $active = false): string
    {
        return self::getConfigValue('pageLinkClass');
    }

    public static function getAnimationClasses(string $animation): string
    {
        return 'animate__animated animate__' . $animation;
    }

    public static function getBulkActionsContainerClasses(): string
    {
        return self::getConfigValue('bulkActionsContainer');
    }

    public static function getBulkActionButtonClasses(): string
    {
        return self::getConfigValue('bulkActionButton');
    }

    public static function getClearSelectionButtonClasses(): string
    {
        return self::getConfigValue('clearSelectionButton');
    }

    public static function getCssLinks(): array
    {
        return [
            'cdn' => [
                'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css',
                'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css',
                'https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css'
            ],
            'local' => []
        ];
    }

    public static function getJsLinks(): array
    {
        return [
            'cdn' => [
                'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'
            ],
            'local' => []
        ];
    }
}
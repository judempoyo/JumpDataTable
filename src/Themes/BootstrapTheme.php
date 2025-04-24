<?php

namespace Jump\JumpDataTable\Themes;

class BootstrapTheme implements ThemeInterface
{
    /**
     * Get the default configuration for the Bootstrap theme.
     *
     * @return array The default configuration array.
     */
    public static function getDefaultConfig(): array
    {
        return [
            'containerClass' => 'container-fluid p-4 mt-4 bg-white rounded shadow',
            'titleClass' => 'h3 mb-0',
            'countBadgeClass' => 'badge bg-primary',
            'filterButtonClass' => 'btn btn-outline-secondary d-flex align-items-center gap-2',
            'addButtonClass' => 'btn btn-primary d-flex align-items-center gap-2',
            'resetButtonClass' => 'btn btn-outline-secondary',
            'applyButtonClass' => 'btn btn-primary',
            'actionButtonClass' => 'btn btn-sm btn-outline-secondary',
            'filtersContainerClass' => 'p-3 mb-3 bg-light rounded',
            'filterInputClass' => 'form-control',
            'filterLabelClass' => 'form-label',
            'tableClass' => 'table table-striped',
            'tableHeaderClass' => 'table-light',
            'tableHeaderCellClass' => 'align-middle',
            'tableBodyClass' => '',
            'tableRowClass' => '',
            'tableCellClass' => '',
            'emptyStateClass' => 'text-center py-5 text-muted',
            'paginationClass' => 'pagination',
            'pageItemClass' => 'page-item',
            'pageLinkClass' => 'page-link',
            'animationClass' => 'animate__animated',
        ];
    }

    public static function getContainerClasses(bool $darkMode): string
    {
        return 'container-fluid p-4 mt-4 rounded shadow ' . ($darkMode ? 'bg-dark text-white' : 'bg-white');
    }

    public static function getTitleClasses(bool $darkMode): string
    {
        return 'h3 mb-0 ' . ($darkMode ? 'text-white' : '');
    }

    public static function getCountBadgeClasses(bool $darkMode): string
    {
        return 'badge ' . ($darkMode ? 'bg-info text-dark' : 'bg-primary');
    }

    public static function getFilterButtonClasses(bool $darkMode): string
    {
        return 'btn d-flex align-items-center gap-2 ' . ($darkMode ? 'btn-outline-light' : 'btn-outline-secondary');
    }

    public static function getExportButtonClasses(bool $darkMode): string
    {
        return 'btn d-flex align-items-center gap-2 ' . ($darkMode ? 'btn-outline-light' : 'btn-outline-success');
    }

    public static function getAddButtonClasses(bool $darkMode): string
    {
        return 'btn d-flex align-items-center gap-2 ' . ($darkMode ? 'btn-info' : 'btn-primary');
    }

    public static function getResetButtonClasses(bool $darkMode): string
    {
        return 'btn ' . ($darkMode ? 'btn-outline-light' : 'btn-outline-secondary');
    }

    public static function getApplyButtonClasses(bool $darkMode): string
    {
        return 'btn ' . ($darkMode ? 'btn-info' : 'btn-primary');
    }

    public static function getActionButtonClasses(bool $darkMode): string
    {
        return 'btn btn-sm ' . ($darkMode ? 'btn-outline-light' : 'btn-outline-secondary');
    }

    public static function getFiltersContainerClasses(bool $darkMode): string
    {
        return 'p-3 mb-3 rounded ' . ($darkMode ? 'bg-secondary' : 'bg-light');
    }

    public static function getFilterInputClasses(bool $darkMode): string
    {
        return 'form-control ' . ($darkMode ? 'bg-dark text-white border-dark' : '');
    }

    public static function getFilterLabelClasses(bool $darkMode): string
    {
        return 'form-label ' . ($darkMode ? 'text-white' : '');
    }

    public static function getTableClasses(bool $darkMode): string
    {
        return 'table table-striped ' . ($darkMode ? 'table-dark' : '');
    }

    public static function getTableHeaderClasses(bool $darkMode): string
    {
        return 'table-light ' . ($darkMode ? 'table-dark' : '');
    }

    public static function getTableHeaderCellClasses(bool $darkMode): string
    {
        return 'align-middle ' . ($darkMode ? 'text-white' : '');
    }

    public static function getTableBodyClasses(bool $darkMode): string
    {
        return '';
    }

    public static function getTableRowClasses(bool $darkMode): string
    {
        return '';
    }

    public static function getTableCellClasses(bool $darkMode): string
    {
        return '';
    }

    public static function getEmptyStateClasses(bool $darkMode): string
    {
        return 'text-center py-5 ' . ($darkMode ? 'text-white-50' : 'text-muted');
    }

    public static function getFilterIconClasses(bool $darkMode): string
    {
        return 'bi bi-funnel';
    }

    public static function getExportIconClasses(bool $darkMode): string
    {
        return 'bi bi-download';
    }

    public static function getAddIconClasses(bool $darkMode): string
    {
        return 'bi bi-plus-lg';
    }

    public static function getPaginationClasses(bool $darkMode): string
    {
        return 'pagination';
    }

    public static function getPageItemClasses(bool $darkMode, bool $active = false): string
    {
        return 'page-item ' . ($active ? 'active' : '');
    }

    public static function getPageLinkClasses(bool $darkMode, bool $active = false): string
    {
        return 'page-link ' . ($darkMode ? 'bg-dark text-white border-dark' : '');
    }

    public static function getAnimationClasses(string $animation): string
    {
        return 'animate__animated animate__' . $animation;
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
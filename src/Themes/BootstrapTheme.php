<?php

namespace Jump\JumpDataTable\Themes;

class BootstrapTheme implements ThemeInterface
{
    public static function getContainerClasses(bool $darkMode): string
    {
        return 'container p-4 mt-4 rounded shadow ' . ($darkMode ? 'bg-dark text-white' : 'bg-white');
    }

    public static function getTitleClasses(bool $darkMode): string
    {
        return 'h2 mb-0 ' . ($darkMode ? 'text-white' : '');
    }

    public static function getCountBadgeClasses(bool $darkMode): string
    {
        return 'badge ' . ($darkMode ? 'bg-info text-dark' : 'bg-primary text-white');
    }

    public static function getFilterButtonClasses(bool $darkMode): string
    {
        return 'btn d-flex align-items-center gap-2 ' . ($darkMode ? 'btn-outline-light' : 'btn-outline-secondary');
    }

    public static function getExportButtonClasses(bool $darkMode): string
    {
        return 'btn d-flex align-items-center gap-2 ' . ($darkMode ? 'btn-outline-light' : 'btn-outline-secondary');
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
        return 'form-control ' . ($darkMode ? 'bg-dark text-white' : '');
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
        return $darkMode ? 'table-dark' : '';
    }

    public static function getTableHeaderCellClasses(bool $darkMode): string
    {
        return 'align-middle';
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
        return 'text-center py-5 ' . ($darkMode ? 'text-white-50' : '');
    }

    public static function getFilterIconClasses(bool $darkMode): string
    {
        return '';
    }

    public static function getExportIconClasses(bool $darkMode): string
    {
        return '';
    }

    public static function getAddIconClasses(bool $darkMode): string
    {
        return '';
    }

    public static function getPaginationClasses(bool $darkMode): string
    {
        return 'pagination';
    }

    public static function getPageItemClasses(bool $darkMode, bool $active = false): string
    {
        return $active ? 'active' : '';
    }

    public static function getPageLinkClasses(bool $darkMode, bool $active = false): string
    {
        return 'page-link';
    }

    public static function getAnimationClasses(string $animation): string
    {
        return 'animate__animated animate__' . $animation;
    }
}
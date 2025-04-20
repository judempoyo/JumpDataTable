<?php

namespace Jump\JumpDataTable\Themes;

interface ThemeInterface
{
    // Structure principale
    public static function getContainerClasses(bool $darkMode): string;
    public static function getTitleClasses(bool $darkMode): string;
    public static function getCountBadgeClasses(bool $darkMode): string;
    
    // Boutons
    public static function getFilterButtonClasses(bool $darkMode): string;
    public static function getExportButtonClasses(bool $darkMode): string;
    public static function getAddButtonClasses(bool $darkMode): string;
    public static function getResetButtonClasses(bool $darkMode): string;
    public static function getApplyButtonClasses(bool $darkMode): string;
    public static function getActionButtonClasses(bool $darkMode): string;
    
    // Filtres
    public static function getFiltersContainerClasses(bool $darkMode): string;
    public static function getFilterInputClasses(bool $darkMode): string;
    public static function getFilterLabelClasses(bool $darkMode): string;
    
    // Tableau
    public static function getTableClasses(bool $darkMode): string;
    public static function getTableHeaderClasses(bool $darkMode): string;
    public static function getTableHeaderCellClasses(bool $darkMode): string;
    public static function getTableBodyClasses(bool $darkMode): string;
    public static function getTableRowClasses(bool $darkMode): string;
    public static function getTableCellClasses(bool $darkMode): string;
    
    // États vides
    public static function getEmptyStateClasses(bool $darkMode): string;
    
    // Icônes
    public static function getFilterIconClasses(bool $darkMode): string;
    public static function getExportIconClasses(bool $darkMode): string;
    public static function getAddIconClasses(bool $darkMode): string;
    
    // Pagination
    public static function getPaginationClasses(bool $darkMode): string;
    public static function getPageItemClasses(bool $darkMode, bool $active = false): string;
    public static function getPageLinkClasses(bool $darkMode, bool $active = false): string;
    
    // Animations
    public static function getAnimationClasses(string $animation): string;

    public static function getCssLinks(): array;
public static function getJsLinks(): array;
}
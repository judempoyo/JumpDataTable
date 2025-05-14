<?php

namespace Jump\JumpDataTable\Themes;

interface ThemeInterface
{
    // Structure principale
    public static function getContainerClasses(): string;
    public static function getTitleClasses(): string;
    public static function getCountBadgeClasses(): string;
    
    // Boutons
    public static function getFilterButtonClasses(): string;
    public static function getExportButtonClasses(): string;
    public static function getAddButtonClasses(): string;
    public static function getResetButtonClasses(): string;
    public static function getApplyButtonClasses(): string;
    public static function getActionButtonClasses(): string;
    
    // Filtres
    public static function getFiltersContainerClasses(): string;
    public static function getFilterInputClasses(): string;
    public static function getFilterLabelClasses(): string;
    
    // Tableau
    public static function getTableClasses(): string;
    public static function getTableHeaderClasses(): string;
    public static function getTableHeaderCellClasses(): string;
    public static function getTableBodyClasses(): string;
    public static function getTableRowClasses(): string;
    public static function getTableCellClasses(): string;
    
    // États vides
    public static function getEmptyStateClasses(): string;
    
    // Icônes
    public static function getFilterIconClasses(): string;
    public static function getExportIconClasses(): string;
    public static function getAddIconClasses(): string;
    
    // Pagination
    public static function getPaginationClasses(): string;
    public static function getPageItemClasses(bool $active = false): string;
    public static function getPageLinkClasses(bool $active = false): string;
    
    // Animations
    public static function getAnimationClasses(string $animation): string;

    // Gestion des thèmes
    public static function usePreset(string $presetName): void;
    public static function overridePreset(array $overrides): void;
    public static function getAvailablePresets(): array;

}
<?php

namespace Jump\JumpDataTable\Themes;

use Jump\JumpDataTable\Themes\Presets\PresetInterface;

class TailwindTheme implements ThemeInterface
{
    protected static array $presets = [
        'modern' => Presets\Tailwind\ModernTheme::class,
        'classic' => Presets\Tailwind\ClassicTheme::class,
        'dark' => Presets\Tailwind\DarkTheme::class,
    ];
    
    protected static array $currentPreset = [];
    protected static array $customConfig = [];

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

    protected static function getConfigValue(string $key, $default = null)
    {
        if (isset(self::$customConfig[$key])) {
            return self::$customConfig[$key];
        }
        
        if (isset(self::$currentPreset[$key])) {
            return self::$currentPreset[$key];
        }
        
        return $default;
    }

    public static function getContainerClasses(bool $darkMode): string
    {
        $rounded = self::getConfigValue('rounded', 'lg');
        $shadow = self::getConfigValue('shadow', 'xl');
        $bgColor = $darkMode 
            ? self::getConfigValue('dark_mode.background', 'gray-800') 
            : 'white';
        
        return "max-w-full p-6 mx-auto mt-8 bg-$bgColor rounded-$rounded shadow-$shadow animate__animated animate__fadeIn";
    }

    public static function getTitleClasses(bool $darkMode): string
    {
        $textColor = $darkMode 
            ? self::getConfigValue('dark_mode.text', 'white') 
            : self::getConfigValue('colors.text', 'gray-900');
        
        return "text-2xl font-bold md:text-3xl animate__animated animate__fadeInLeft text-$textColor";
    }

    public static function getCountBadgeClasses(bool $darkMode): string
    {
        $primary = self::getConfigValue('colors.primary', 'teal-500');
        $textColor = $darkMode ? 'teal-200' : 'teal-800';
        $bgColor = $darkMode ? 'teal-900' : 'teal-100';
        
        return "px-3 py-1 text-sm font-medium rounded-full text-$textColor bg-$bgColor";
    }

    public static function getFilterButtonClasses(bool $darkMode): string
    {
        $borderColor = $darkMode 
            ? self::getConfigValue('dark_mode.border', 'gray-600') 
            : 'gray-300';
        $bgColor = $darkMode 
            ? self::getConfigValue('dark_mode.card', 'gray-700') 
            : 'white';
        $textColor = $darkMode ? 'gray-300' : 'gray-700';
        $hoverBg = $darkMode ? 'gray-600' : 'gray-50';
        
        return "flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg border border-$borderColor bg-$bgColor text-$textColor hover:bg-$hoverBg";
    }

    public static function getExportButtonClasses(bool $darkMode): string
    {
        return self::getFilterButtonClasses($darkMode);
    }

    public static function getAddButtonClasses(bool $darkMode): string
    {
        $primary = self::getConfigValue('colors.primary', 'teal-500');
        $hover = self::getConfigValue('colors.primary_hover', 'teal-600');
        
        return "flex items-center gap-2 px-4 py-2 text-sm font-medium text-white rounded-lg transition-all duration-300 bg-$primary hover:bg-$hover";
    }

    public static function getResetButtonClasses(bool $darkMode): string
    {
        $borderColor = $darkMode 
            ? self::getConfigValue('dark_mode.border', 'gray-500') 
            : 'gray-300';
        $bgColor = $darkMode 
            ? self::getConfigValue('dark_mode.card', 'gray-600') 
            : 'white';
        $textColor = $darkMode ? 'gray-300' : 'gray-700';
        $hoverBg = $darkMode ? 'gray-500' : 'gray-50';
        
        return "px-4 py-2 text-sm font-medium rounded-lg border border-$borderColor bg-$bgColor text-$textColor hover:bg-$hoverBg";
    }

    public static function getApplyButtonClasses(bool $darkMode): string
    {
        $primary = self::getConfigValue('colors.primary', 'teal-500');
        $hover = self::getConfigValue('colors.primary_hover', 'teal-600');
        
        return "px-4 py-2 text-sm font-medium text-white rounded-lg bg-$primary hover:bg-$hover";
    }

    public static function getActionButtonClasses(bool $darkMode): string
    {
        $textColor = $darkMode ? 'gray-300' : 'gray-500';
        $hoverBg = $darkMode ? 'gray-700' : 'gray-100';
        
        return "p-1.5 rounded-full transition duration-200 text-$textColor hover:bg-$hoverBg";
    }

    public static function getFiltersContainerClasses(bool $darkMode): string
    {
        $bgColor = $darkMode 
            ? self::getConfigValue('dark_mode.card', 'gray-700') 
            : 'gray-50';
        
        return "p-4 mt-2 rounded-lg bg-$bgColor";
    }

    public static function getFilterInputClasses(bool $darkMode): string
    {
        $borderColor = $darkMode 
            ? self::getConfigValue('dark_mode.border', 'gray-600') 
            : 'gray-300';
        $bgColor = $darkMode 
            ? self::getConfigValue('dark_mode.background', 'gray-800') 
            : 'white';
        $textColor = $darkMode ? 'white' : 'gray-900';
        $placeholderColor = $darkMode ? 'gray-400' : 'gray-400';
        
        return "w-full px-3 py-2 text-sm border rounded-lg shadow-sm transition duration-300 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 border-$borderColor bg-$bgColor text-$textColor placeholder-$placeholderColor";
    }

    public static function getFilterLabelClasses(bool $darkMode): string
    {
        $textColor = $darkMode ? 'gray-300' : 'gray-700';
        
        return "block mb-1 text-sm font-medium text-$textColor";
    }

    public static function getTableClasses(bool $darkMode): string
    {
        $divideColor = $darkMode 
            ? self::getConfigValue('dark_mode.divide', 'gray-700') 
            : 'gray-200';
        
        return "min-w-full divide-y divide-$divideColor";
    }

    public static function getTableHeaderClasses(bool $darkMode): string
    {
        $bgColor = $darkMode 
            ? self::getConfigValue('dark_mode.header', 'gray-800') 
            : 'gray-50';
        
        return "bg-$bgColor";
    }

    public static function getTableHeaderCellClasses(bool $darkMode): string
    {
        $textColor = $darkMode ? 'gray-300' : 'gray-500';
        
        return "px-6 py-3 text-xs font-medium tracking-wider text-left uppercase text-$textColor";
    }

    public static function getTableBodyClasses(bool $darkMode): string
    {
        $bgColor = $darkMode 
            ? self::getConfigValue('dark_mode.background', 'gray-800') 
            : 'white';
        $divideColor = $darkMode 
            ? self::getConfigValue('dark_mode.divide', 'gray-700') 
            : 'gray-200';
        
        return "bg-$bgColor divide-$divideColor";
    }

    public static function getTableRowClasses(bool $darkMode): string
    {
        $hoverBg = $darkMode 
            ? self::getConfigValue('dark_mode.row_hover', 'gray-700/50') 
            : 'gray-50';
        
        return "transition duration-150 hover:bg-$hoverBg";
    }

    public static function getTableCellClasses(bool $darkMode): string
    {
        $textColor = $darkMode ? 'gray-100' : 'gray-900';
        
        return "px-6 py-4 whitespace-nowrap text-sm text-$textColor";
    }

    public static function getEmptyStateClasses(bool $darkMode): string
    {
        $textColor = $darkMode ? 'gray-400' : 'gray-500';
        
        return "flex flex-col items-center justify-center text-$textColor";
    }

    public static function getFilterIconClasses(bool $darkMode): string
    {
        $textColor = $darkMode ? 'gray-300' : 'gray-500';
        $hoverColor = 'teal-500';
        
        return "w-5 h-5 text-$textColor group-hover:text-$hoverColor";
    }

    public static function getExportIconClasses(bool $darkMode): string
    {
        return self::getFilterIconClasses($darkMode);
    }

    public static function getAddIconClasses(bool $darkMode): string
    {
        return "w-5 h-5 text-white";
    }

    public static function getPaginationClasses(bool $darkMode): string
    {
        return "flex items-center space-x-1";
    }

    public static function getPageItemClasses(bool $darkMode, bool $active = false): string
    {
        if ($active) {
            return '';
        }
        $bgColor = $darkMode ? 'gray-700' : 'white';
        $borderColor = $darkMode ? 'gray-600' : 'gray-300';
        
        return "bg-$bgColor border-$borderColor";
    }

    public static function getPageLinkClasses(bool $darkMode, bool $active = false): string
    {
        if ($active) {
            $primary = self::getConfigValue('colors.primary', 'teal-500');
            $darkPrimary = self::getConfigValue('dark_mode.primary', 'teal-600');
            return "text-white bg-$primary border-$primary " . ($darkMode ? "dark:bg-$darkPrimary dark:border-$darkPrimary" : '');
        }
        
        $textColor = $darkMode ? 'gray-400' : 'gray-700';
        $bgColor = $darkMode ? 'gray-700' : 'white';
        $borderColor = $darkMode ? 'gray-600' : 'gray-300';
        $hoverBg = $darkMode ? 'gray-600' : 'gray-50';
        
        return "text-$textColor bg-$bgColor border-$borderColor hover:bg-$hoverBg";
    }

    public static function getAnimationClasses(string $animation): string
    {
        return "animate__animated animate__$animation";
    }

    public static function getCssLinks(): array
    {
        return [
            'cdn' => [
                'https://cdn.tailwindcss.com',
                'https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css'
            ],
            'local' => []
        ];
    }

    public static function getJsLinks(): array
    {
        return [
            'cdn' => [],
            'local' => []
        ];
    }

    public static function getAvailablePresets(): array
    {
        return array_keys(self::$presets);
    }
}
<?php

namespace Jump\JumpDataTable\Themes;

class TailwindTheme implements ThemeInterface
{
    public static function getContainerClasses(bool $darkMode): string
    {
        return 'max-w-full p-6 mx-auto mt-8 bg-white rounded-lg shadow-lg animate__animated animate__fadeIn ' . 
               ($darkMode ? 'dark:bg-gray-800' : '');
    }

    public static function getTitleClasses(bool $darkMode): string
    {
        return 'text-2xl font-bold md:text-3xl animate__animated animate__fadeInLeft ' .
               ($darkMode ? 'text-white' : 'text-gray-900');
    }

    public static function getCountBadgeClasses(bool $darkMode): string
    {
        return 'px-3 py-1 text-sm font-medium rounded-full ' .
               ($darkMode ? 'text-teal-200 bg-teal-900' : 'text-teal-800 bg-teal-100');
    }

    public static function getFilterButtonClasses(bool $darkMode): string
    {
        return 'flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg group ' .
               ($darkMode ? 'text-gray-300 bg-gray-700 border-gray-600 hover:bg-gray-600' : 
                           'text-gray-700 bg-white border border-gray-300 hover:bg-gray-50');
    }

    public static function getExportButtonClasses(bool $darkMode): string
    {
        return 'flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg group ' .
               ($darkMode ? 'text-gray-300 bg-gray-700 border-gray-600 hover:bg-gray-600' : 
                           'text-gray-700 bg-white border border-gray-300 hover:bg-gray-50');
    }

    public static function getAddButtonClasses(bool $darkMode): string
    {
        return 'flex items-center gap-2 px-4 py-2 text-sm font-medium text-white rounded-lg transition-all duration-300 ' .
               ($darkMode ? 'bg-teal-600 hover:bg-teal-700' : 'bg-teal-500 hover:bg-teal-600');
    }

    public static function getResetButtonClasses(bool $darkMode): string
    {
        return 'px-4 py-2 text-sm font-medium rounded-lg ' .
               ($darkMode ? 'text-gray-300 bg-gray-600 border-gray-500 hover:bg-gray-500' : 
                           'text-gray-700 bg-white border border-gray-300 hover:bg-gray-50');
    }

    public static function getApplyButtonClasses(bool $darkMode): string
    {
        return 'px-4 py-2 text-sm font-medium text-white rounded-lg ' .
               ($darkMode ? 'bg-teal-600 hover:bg-teal-700' : 'bg-teal-500 hover:bg-teal-600');
    }

    public static function getActionButtonClasses(bool $darkMode): string
    {
        return 'p-1.5 rounded-full transition duration-200 ' .
               ($darkMode ? 'text-gray-300 hover:bg-gray-700' : 'text-gray-500 hover:bg-gray-100');
    }

    public static function getFiltersContainerClasses(bool $darkMode): string
    {
        return 'p-4 mt-2 rounded-lg ' . ($darkMode ? 'bg-gray-700' : 'bg-gray-50');
    }

    public static function getFilterInputClasses(bool $darkMode): string
    {
        return 'w-full px-3 py-2 text-sm border rounded-lg shadow-sm transition duration-300 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 ' .
               ($darkMode ? 'bg-gray-800 border-gray-600 text-white placeholder-gray-400' : 
                           'bg-white border-gray-300 text-gray-900 placeholder-gray-400');
    }

    public static function getFilterLabelClasses(bool $darkMode): string
    {
        return 'block mb-1 text-sm font-medium ' . ($darkMode ? 'text-gray-300' : 'text-gray-700');
    }

    public static function getTableClasses(bool $darkMode): string
    {
        return 'min-w-full divide-y ' . ($darkMode ? 'divide-gray-700' : 'divide-gray-200');
    }

    public static function getTableHeaderClasses(bool $darkMode): string
    {
        return ($darkMode ? 'bg-gray-800' : 'bg-gray-50');
    }

    public static function getTableHeaderCellClasses(bool $darkMode): string
    {
        return 'px-6 py-3 text-xs font-medium tracking-wider text-left uppercase ' .
               ($darkMode ? 'text-gray-300' : 'text-gray-500');
    }

    public static function getTableBodyClasses(bool $darkMode): string
    {
        return ($darkMode ? 'bg-gray-800 divide-gray-700' : 'bg-white divide-gray-200');
    }

    public static function getTableRowClasses(bool $darkMode): string
    {
        return 'transition duration-150 ' . ($darkMode ? 'hover:bg-gray-700/50' : 'hover:bg-gray-50');
    }

    public static function getTableCellClasses(bool $darkMode): string
    {
        return 'px-6 py-4 whitespace-nowrap text-sm ' . ($darkMode ? 'text-gray-100' : 'text-gray-900');
    }

    public static function getEmptyStateClasses(bool $darkMode): string
    {
        return 'flex flex-col items-center justify-center ' . ($darkMode ? 'text-gray-400' : 'text-gray-500');
    }

    public static function getFilterIconClasses(bool $darkMode): string
    {
        return 'w-5 h-5 ' . ($darkMode ? 'text-gray-300 group-hover:text-teal-500' : 'text-gray-500 group-hover:text-teal-500');
    }

    public static function getExportIconClasses(bool $darkMode): string
    {
        return 'w-5 h-5 ' . ($darkMode ? 'text-gray-300 group-hover:text-teal-500' : 'text-gray-500 group-hover:text-teal-500');
    }

    public static function getAddIconClasses(bool $darkMode): string
    {
        return 'w-5 h-5 text-white';
    }

    public static function getPaginationClasses(bool $darkMode): string
    {
        return 'flex items-center space-x-1';
    }

    public static function getPageItemClasses(bool $darkMode, bool $active = false): string
    {
        if ($active) {
            return '';
        }
        return $darkMode ? 'bg-gray-700 border-gray-600' : 'bg-white border-gray-300';
    }

    public static function getPageLinkClasses(bool $darkMode, bool $active = false): string
    {
        if ($active) {
            return 'text-white bg-teal-500 border-teal-500 ' . ($darkMode ? 'dark:bg-teal-600 dark:border-teal-600' : '');
        }
        return ($darkMode ? 'text-gray-400 bg-gray-700 border-gray-600 hover:bg-gray-600' : 
                           'text-gray-700 bg-white border-gray-300 hover:bg-gray-50');
    }

    public static function getAnimationClasses(string $animation): string
    {
        return 'animate__animated animate__' . $animation;
    }

}
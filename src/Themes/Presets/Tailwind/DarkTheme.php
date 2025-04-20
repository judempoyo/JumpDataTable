<?php

namespace Jump\JumpDataTable\Themes\Presets\Tailwind;

use Jump\JumpDataTable\Themes\Presets\PresetInterface;

class DarkTheme implements PresetInterface
{
    public static function getConfig(): array
    {
        return [
            'colors' => [
                'primary' => '#8b5cf6', // violet-500
                'primary_hover' => '#7c3aed', // violet-600
                'text' => '#e5e7eb' // gray-200
            ],
            'rounded' => 'lg',
            'shadow' => '2xl',
            'dark_mode' => [
                'background' => '#0f172a', // slate-900
                'card' => '#1e293b', // slate-800
                'text' => '#f8fafc', // slate-50
                'divide' => '#334155', // slate-700
                'border' => '#334155', // slate-700
                'header' => '#1e293b', // slate-800
                'row_hover' => '#1e293b/70' // slate-800 with opacity
            ]
        ];
    }
}
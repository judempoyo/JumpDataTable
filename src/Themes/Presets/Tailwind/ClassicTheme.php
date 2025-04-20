<?php

namespace Jump\JumpDataTable\Themes\Presets\Tailwind;

use Jump\JumpDataTable\Themes\Presets\PresetInterface;

class ClassicTheme implements PresetInterface
{
    public static function getConfig(): array
    {
        return [
            'colors' => [
                'primary' => '#3b82f6', // blue-500
                'primary_hover' => '#2563eb', // blue-600
                'text' => '#111827' // gray-900
            ],
            'rounded' => 'md',
            'shadow' => 'md',
            'dark_mode' => [
                'background' => '#111827', // gray-900
                'card' => '#1f2937', // gray-800
                'text' => '#f3f4f6', // gray-100
                'divide' => '#374151', // gray-700
                'border' => '#374151', // gray-700
                'header' => '#1f2937', // gray-800
                'row_hover' => '#1f2937/50' // gray-800 with opacity
            ]
        ];
    }
}
<?php

namespace Jump\JumpDataTable\Themes\Presets\Tailwind;

use Jump\JumpDataTable\Themes\Presets\PresetInterface;

class ModernTheme implements PresetInterface
{
    public static function getConfig(): array
    {
        return [
            'colors' => [
                'primary' => '#6366f1', // indigo
                'secondary' => '#8b5cf6', // violet
                'success' => '#10b981', // emerald
                'danger' => '#ef4444', // red
            ],
            'rounded' => 'lg',
            'shadow' => 'xl',
            'animation' => 'all 0.3s ease-in-out',
            'dark_mode' => [
                'background' => '#1e293b', // slate-800
                'text' => '#f8fafc', // slate-50
                'card' => '#334155' // slate-700
            ]
        ];
    }
}
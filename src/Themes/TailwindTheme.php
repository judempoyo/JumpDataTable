<?php
namespace Jump\JumpDataTable\Themes;

class TailwindTheme implements ThemeInterface
{
    public static function getDefaultConfig(): array
    {
        return [
            'container' => 'max-w-full p-6 mx-auto mt-8 bg-white rounded-lg shadow-lg',
            'table' => 'min-w-full divide-y divide-gray-200',
            'dark' => [
                'container' => 'dark:bg-gray-800',
                'table' => 'dark:divide-gray-700'
            ]
            // ... autres configurations
        ];
    }

    public static function getTemplatePath(): string
    {
        return __DIR__.'/../../resources/views/tailwind/table.php';
    }
}
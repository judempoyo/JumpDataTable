<?php
namespace Jump\JumpDataTable\Themes;

class BootstrapTheme implements ThemeInterface
{
    public static function getDefaultConfig(): array
    {
        return [
            'container' => 'container mt-4 p-4 bg-white rounded shadow',
            'table' => 'table table-striped table-bordered',
            // ... autres configurations
        ];
    }

    public static function getTemplatePath(): string
    {
        return __DIR__.'/../../resources/views/bootstrap/table.php';
    }
}
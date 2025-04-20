<?php
namespace Jump\JumpDataTable\Themes;

interface ThemeInterface
{
    public static function getDefaultConfig(): array;
    public static function getTemplatePath(): string;
}
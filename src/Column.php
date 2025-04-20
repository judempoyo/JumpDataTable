<?php

namespace Jump\JumpDataTable;

class Column
{
    public static function make(string $key, string $label): array
    {
        return [
            'key' => $key,
            'label' => $label,
        ];
    }

    public static function date(string $key, string $label): array
    {
        return [
            'key' => $key,
            'label' => $label,
            'format' => 'date'
        ];
    }

    public static function boolean(string $key, string $label): array
    {
        return [
            'key' => $key,
            'label' => $label,
            'format' => 'boolean'
        ];
    }

    public static function custom(string $key, string $label, callable $render): array
    {
        return [
            'key' => $key,
            'label' => $label,
            'render' => $render
        ];
    }
}
<?php

namespace Jump\JumpDataTable;

class Column
{
    public static function make(string $key, string $label, array $options = []): array
    {
        return array_merge([
            'key' => $key,
            'label' => $label,
        ], $options);
    }

    public static function date(string $key, string $label, string $format = 'd/m/Y H:i'): array
    {
        return [
            'key' => $key,
            'label' => $label,
            'format' => 'date',
            'dateFormat' => $format,
        ];
    }

    public static function boolean(string $key, string $label, array $icons = []): array
    {
        return [
            'key' => $key,
            'label' => $label,
            'format' => 'boolean',
            'icons' => array_merge([
                'true' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>',
                'false' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>',
            ], $icons),
        ];
    }

    public static function custom(string $key, string $label, callable $render, array $options = []): array
    {
        return array_merge([
            'key' => $key,
            'label' => $label,
            'render' => $render,
        ], $options);
    }

    public static function status(string $key, string $label, array $statuses): array
    {
        return [
            'key' => $key,
            'label' => $label,
            'format' => 'status',
            'statuses' => $statuses,
        ];
    }
}
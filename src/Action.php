<?php

namespace Jump\JumpDataTable;

class Action
{
    /**
     * Create a "view" action configuration.
     *
     * @param string $label The label for the action.
     * @param callable $urlGenerator A callable that generates the URL for the action.
     * @param string|null $icon Optional icon for the action. Defaults to the view icon.
     * @return array The configuration array for the "view" action.
     */
    public static function view(string $label, callable $urlGenerator, ?string $icon = null): array
    {
        return [
            'type' => 'view',
            'label' => $label,
            'url' => $urlGenerator,
            'icon' => $icon ?? self::defaultViewIcon()
        ];
    }

    /**
     * Create an "edit" action configuration.
     *
     * @param string $label The label for the action.
     * @param callable $urlGenerator A callable that generates the URL for the action.
     * @param string|null $icon Optional icon for the action. Defaults to the edit icon.
     * @return array The configuration array for the "edit" action.
     */
    public static function edit(string $label, callable $urlGenerator, ?string $icon = null): array
    {
        return [
            'type' => 'edit',
            'label' => $label,
            'url' => $urlGenerator,
            'icon' => $icon ?? self::defaultEditIcon()
        ];
    }

    /**
     * Create a "delete" action configuration.
     *
     * @param string $label The label for the action.
     * @param callable $urlGenerator A callable that generates the URL for the action.
     * @param string|null $icon Optional icon for the action. Defaults to the delete icon.
     * @return array The configuration array for the "delete" action.
     */
    public static function delete(string $label, callable $urlGenerator, ?string $icon = null): array
    {
        return [
            'type' => 'delete',
            'label' => $label,
            'url' => $urlGenerator,
            'icon' => $icon ?? self::defaultDeleteIcon()
        ];
    }

    /**
     * Create a custom action configuration.
     *
     * @param string $label The label for the action.
     * @param callable $urlGenerator A callable that generates the URL for the action.
     * @param callable $iconGenerator A callable that generates the icon for the action.
     * @param array $options Additional options for the action.
     * @return array The configuration array for the custom action.
     */
    public static function custom(string $label, callable $urlGenerator, callable $iconGenerator, array $options = []): array
    {
        return [
            'type' => $options['type'] ?? 'custom',
            'label' => $label,
            'url' => $urlGenerator,
            'icon' => $iconGenerator(),
            'options' => $options
        ];
    }

    /**
     * Get the default icon for the "view" action.
     *
     * @return string The SVG string for the "view" icon.
     */
    private static function defaultViewIcon(): string
    {
        return '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>';
    }

    /**
     * Get the default icon for the "edit" action.
     *
     * @return string The SVG string for the "edit" icon.
     */
    private static function defaultEditIcon(): string
    {
        return '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>';
    }

    /**
     * Get the default icon for the "delete" action.
     *
     * @return string The SVG string for the "delete" icon.
     */
    private static function defaultDeleteIcon(): string
    {
        return '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>';
    }
}
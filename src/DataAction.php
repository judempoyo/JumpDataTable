<?php

namespace Jump\JumpDataTable;

/**
 * Represents an action that can be performed on a data table item
 * 
 * Actions are typically rendered as buttons in the table and can be things like
 * "view", "edit", "delete" or custom actions.
 */
class DataAction
{
    /** @var string The type of action (e.g., 'view', 'edit', 'delete', 'custom') */
    private string $type;
    
    /** @var string The label to display for the action */
    private string $label;
    
    /** @var \Closure A closure that generates the URL for the action */
    private \Closure $urlGenerator;
    
    /** @var string|null An optional icon to display with the action */
    private ?string $icon = null;
    
    /** @var array Additional options for the action */
    private array $options = [];
    
    /** @var array CSS classes to apply to the action */
    private array $classes = [];
    
    /** @var bool Whether the action is enabled */
    private bool $isEnabled = true;
    /** @var string http method */
    private string $method = 'GET'; 
    /**
     * Constructor
     * 
     * @param string $type The action type
     * @param string $label The action label
     * @param callable $urlGenerator A callable that generates the URL for the action
     */
    public function __construct(string $type, string $label, callable $urlGenerator)
    {
        $this->type = $type;
        $this->label = $label;
        $this->urlGenerator = \Closure::fromCallable($urlGenerator);
    }

    /**
     * Creates a DataAction from an array configuration
     * 
     * @param array $config The action configuration array
     * @return self
     */
    public static function fromArray(array $config): self
    {
        $action = new self(
            $config['type'] ?? 'custom',
            $config['label'] ?? '',
            $config['url'] ?? fn() => '#'
        );

        $action->icon = $config['icon'] ?? null;
        $action->options = $config['options'] ?? [];
        $action->classes = isset($config['class']) ? explode(' ', $config['class']) : [];
        $action->isEnabled = $config['enabled'] ?? true;
        $action->method = strtoupper($config['method'] ?? 'GET');

        return $action;
    }

    /**
     * Gets the action type
     * 
     * @return string
     */
    public function getType(): string 
    {
        return $this->type;
    }

    /**
     * Gets the action label
     * 
     * @return string
     */
    public function getLabel(): string 
    {
        return $this->label;
    }

    /**
     * Gets the action icon
     * 
     * @return string|null
     */
    public function getIcon(): ?string 
    {
        return $this->icon;
    }

    /**
     * Sets the action icon
     * 
     * @param string|null $icon The icon to set
     * @return self
     */
    public function setIcon(?string $icon): self
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * Gets the action options
     * 
     * @return array
     */
    public function getOptions(): array 
    {
        return $this->options;
    }

    /**
     * Sets the action options
     * 
     * @param array $options The options to set
     * @return self
     */
    public function setOptions(array $options): self
    {
        $this->options = $options;
        return $this;
    }

    /**
     * Gets the CSS classes for the action
     * 
     * @return array
     */
    public function getClasses(): array 
    {
        return $this->classes;
    }

    /**
     * Adds a CSS class to the action
     * 
     * @param string $class The class to add
     * @return self
     */
    public function addClass(string $class): self
    {
        if (!in_array($class, $this->classes)) {
            $this->classes[] = $class;
        }
        return $this;
    }

    /**
     * Checks if the action is enabled
     * 
     * @return bool
     */
    public function isEnabled(): bool 
    {
        return $this->isEnabled;
    }

    /**
     * Sets whether the action is enabled
     * 
     * @param bool $enabled Whether to enable the action
     * @return self
     */
    public function setEnabled(bool $enabled): self
    {
        $this->isEnabled = $enabled;
        return $this;
    }

    /**
     * Generates the URL for the action
     * 
     * @param array $item The data item the action applies to
     * @return string
     */
    public function getUrl(array $item): string
    {
        return ($this->urlGenerator)($item);
    }

    /**
     * Creates a view action
     * 
     * @param string $label The action label
     * @param callable $urlGenerator A callable that generates the URL
     * @param string|null $icon An optional icon
     * @return self
     */
    public static function view(string $label, callable $urlGenerator, ?string $icon = null): self
    {
        return (new self('view', $label, $urlGenerator))
            ->setIcon($icon ?? self::defaultViewIcon());
    }

    /**
     * Creates an edit action
     * 
     * @param string $label The action label
     * @param callable $urlGenerator A callable that generates the URL
     * @param string|null $icon An optional icon
     * @return self
     */
    public static function edit(string $label, callable $urlGenerator, ?string $icon = null): self
    {
        return (new self('edit', $label, $urlGenerator))
            ->setIcon($icon ?? self::defaultEditIcon());
    }

     /**
     * Gets the HTTP method for the action
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Sets the HTTP method for the action
     */
    public function setMethod(string $method): self
    {
        $this->method = strtoupper($method);
        return $this;
    }

    /**
      * Creates a delete action  with POST method by default
     * 
     * @param string $label The action label
     * @param callable $urlGenerator A callable that generates the URL
     * @param string|null $icon An optional icon
     * @return self
     */
    public static function delete(string $label, callable $urlGenerator, ?string $icon = null): self
    {
        return (new self('delete', $label, $urlGenerator))
            ->setIcon($icon ?? self::defaultDeleteIcon())
            ->setMethod('POST')
            ->addClass('delete-action');
    }

    /**
     * Converts the action to an array
     * 
     * @return array
     */
    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'label' => $this->label,
            'url' => $this->urlGenerator,
            'icon' => $this->icon,
            'options' => $this->options,
            'class' => implode(' ', $this->classes),
            'enabled' => $this->isEnabled,
            'method' => $this->method,
        ];
    }

    /**
     * Gets the default view icon SVG
     * 
     * @return string
     */
    private static function defaultViewIcon(): string
    {
        return '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>';
    }

    /**
     * Gets the default edit icon SVG
     * 
     * @return string
     */
    private static function defaultEditIcon(): string
    {
        return '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>';
    }

    /**
     * Gets the default delete icon SVG
     * 
     * @return string
     */
    private static function defaultDeleteIcon(): string
    {
        return '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>';
    }
}
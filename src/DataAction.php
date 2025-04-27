<?php

namespace Jump\JumpDataTable;

/**
 * [Description DataAction]
 */
class DataAction
{
    private string $type;
    private string $label;
    private \Closure $urlGenerator;
    private ?string $icon = null;
    private array $options = [];
    private array $classes = [];
    private bool $isEnabled = true;

    /**
     * @param string $type
     * @param string $label
     * @param callable $urlGenerator
     */
    public function __construct(string $type, string $label, callable $urlGenerator)
    {
        $this->type = $type;
        $this->label = $label;
        $this->urlGenerator = \Closure::fromCallable($urlGenerator);
    }

    /**
     * @param array $config
     * 
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

        return $action;
    }

    /**
     * @return string
     */
    public function getType(): string 
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getLabel(): string 
    {
        return $this->label;
    }

    /**
     * @return string|null
     */
    public function getIcon(): ?string 
    {
        return $this->icon;
    }

    /**
     * @param string|null $icon
     * 
     * @return self
     */
    public function setIcon(?string $icon): self
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * @return array
     */
    public function getOptions(): array 
    {
        return $this->options;
    }

    /**
     * @param array $options
     * 
     * @return self
     */
    public function setOptions(array $options): self
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @return array
     */
    public function getClasses(): array 
    {
        return $this->classes;
    }

    public function addClass(string $class): self
    {
        if (!in_array($class, $this->classes)) {
            $this->classes[] = $class;
        }
        return $this;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool 
    {
        return $this->isEnabled;
    }

    /**
     * @param bool $enabled
     * 
     * @return self
     */
    public function setEnabled(bool $enabled): self
    {
        $this->isEnabled = $enabled;
        return $this;
    }

    /**
     * @param array $item
     * 
     * @return string
     */
    public function getUrl(array $item): string
    {
        return ($this->urlGenerator)($item);
    }

    /**
     * @param string $label
     * @param callable $urlGenerator
     * @param string|null $icon
     * 
     * @return self
     */
    public static function view(string $label, callable $urlGenerator, ?string $icon = null): self
    {
        return (new self('view', $label, $urlGenerator))
            ->setIcon($icon ?? self::defaultViewIcon());
    }

    /**
     * @param string $label
     * @param callable $urlGenerator
     * @param string|null $icon
     * 
     * @return self
     */
    public static function edit(string $label, callable $urlGenerator, ?string $icon = null): self
    {
        return (new self('edit', $label, $urlGenerator))
            ->setIcon($icon ?? self::defaultEditIcon());
    }

    /**
     * @param string $label
     * @param callable $urlGenerator
     * @param string|null $icon
     * 
     * @return self
     */
    public static function delete(string $label, callable $urlGenerator, ?string $icon = null): self
    {
        return (new self('delete', $label, $urlGenerator))
            ->setIcon($icon ?? self::defaultDeleteIcon());
    }

    /**
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
        ];
    }

    /**
     * @return string
     */
    private static function defaultViewIcon(): string
    {
        return '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>';
    }

    /**
     * @return string
     */
    private static function defaultEditIcon(): string
    {
        return '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>';
    }

    /**
     * @return string
     */
    private static function defaultDeleteIcon(): string
    {
        return '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>';
    }
}
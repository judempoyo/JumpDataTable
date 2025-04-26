<?php

namespace Jump\JumpDataTable;

class DataColumn
{
    private string $key;
    private string $label;
    private ?string $format = null;
    private ?string $dateFormat = null;
    private array $statuses = [];
    private ?\Closure $renderer = null;
    private bool $sortable = false;
    private bool $searchable = false;
    private array $icons = [];
    private array $classes = [];
    private bool $visible = true;
    private ?string $width = null;

    public function __construct(string $key, string $label)
    {
        $this->key = $key;
        $this->label = $label;
    }

    public function getKey(): string 
    {
        return $this->key;
    }

    public function getLabel(): string 
    {
        return $this->label;
    }

    public function getFormat(): ?string 
    {
        return $this->format;
    }

    public function isSortable(): bool 
    {
        return $this->sortable;
    }

    public function isSearchable(): bool 
    {
        return $this->searchable;
    }

    public function isVisible(): bool 
    {
        return $this->visible;
    }

    public function sortable(bool $sortable = true): self
    {
        $this->sortable = $sortable;
        return $this;
    }

    public function searchable(bool $searchable = true): self
    {
        $this->searchable = $searchable;
        return $this;
    }

    public function visible(bool $visible): self
    {
        $this->visible = $visible;
        return $this;
    }

    public function width(?string $width): self
    {
        $this->width = $width;
        return $this;
    }

    public function asDate(string $format = 'd/m/Y H:i'): self
    {
        $this->format = 'date';
        $this->dateFormat = $format;
        return $this;
    }

    public function asBoolean(array $icons = []): self
    {
        $this->format = 'boolean';
        $this->icons = array_merge([
            'true' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>',
            'false' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>',
        ], $icons);
        return $this;
    }

    public function withStatuses(array $statuses): self
    {
        $this->format = 'status';
        $this->statuses = $statuses;
        return $this;
    }

    public function withRenderer(callable $renderer): self
    {
        $this->renderer = \Closure::fromCallable($renderer);
        return $this;
    }

    public function addClass(string $class): self
    {
        if (!in_array($class, $this->classes)) {
            $this->classes[] = $class;
        }
        return $this;
    }

    public function renderValue(array $item): string
    {
        if ($this->renderer) {
            return ($this->renderer)($item);
        }
        return $item[$this->key] ?? '';
    }

    public function toArray(): array
    {
        $config = [
            'key' => $this->key,
            'label' => $this->label,
            'sortable' => $this->sortable,
            'searchable' => $this->searchable,
            'visible' => $this->visible,
            'width' => $this->width,
        ];

        if ($this->format) {
            $config['format'] = $this->format;
            
            match ($this->format) {
                'date' => $config['dateFormat'] = $this->dateFormat,
                'boolean' => $config['icons'] = $this->icons,
                'status' => $config['statuses'] = $this->statuses,
                default => null
            };
        }

        if ($this->renderer) {
            $config['render'] = $this->renderer;
        }

        if (!empty($this->classes)) {
            $config['class'] = implode(' ', $this->classes);
        }

        return $config;
    }
}
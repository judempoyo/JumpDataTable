<?php

namespace Jump\JumpDataTable;

/**
 * Represents a column in a data table
 * 
 * Columns define how data is displayed and can be formatted in various ways
 * (dates, booleans, statuses, etc.) and can be made sortable or searchable.
 */
class DataColumn
{
    /** @var string The key in the data array this column represents */
    private string $key;
    
    /** @var string The label to display for the column */
    private string $label;
    
    /** @var string|null The format type (date, boolean, status, etc.) */
    private ?string $format = null;
    
    /** @var string|null The date format string if this is a date column */
    private ?string $dateFormat = null;
    
    /** @var array Status configurations if this is a status column */
    private array $statuses = [];
    
    /** @var \Closure|null A custom renderer function for the column */
    private ?\Closure $renderer = null;
    
    /** @var bool Whether the column is sortable */
    private bool $sortable = false;
    
    /** @var bool Whether the column is searchable */
    private bool $searchable = false;
    
    /** @var array Icons for boolean values */
    private array $icons = [];
    
    /** @var array CSS classes for the column */
    private array $classes = [];
    
    /** @var bool Whether the column is visible */
    private bool $visible = true;
    
    /** @var string|null The width of the column */
    private ?string $width = null;

    /**
     * Constructor
     * 
     * @param string $key The data key
     * @param string $label The column label
     */
    public function __construct(string $key, string $label)
    {
        $this->key = $key;
        $this->label = $label;
    }

    /**
     * Creates a DataColumn from an array configuration
     * 
     * @param array $config The column configuration
     * @return self
     */
    public static function fromArray(array $config): self
    {
        $column = new self(
            $config['key'] ?? '',
            $config['label'] ?? ''
        );

        $column->format = $config['format'] ?? null;
        $column->dateFormat = $config['dateFormat'] ?? null;
        $column->statuses = $config['statuses'] ?? [];
        $column->sortable = $config['sortable'] ?? false;
        $column->searchable = $config['searchable'] ?? false;
        $column->visible = $config['visible'] ?? true;
        $column->width = $config['width'] ?? null;
        $column->icons = $config['icons'] ?? [];
        $column->classes = isset($config['class']) ? explode(' ', $config['class']) : [];

        if (isset($config['render']) && is_callable($config['render'])) {
            $column->renderer = \Closure::fromCallable($config['render']);
        }

        return $column;
    }

    /**
     * Gets the column key
     * 
     * @return string
     */
    public function getKey(): string 
    {
        return $this->key;
    }

    /**
     * Gets the column label
     * 
     * @return string
     */
    public function getLabel(): string 
    {
        return $this->label;
    }

    /**
     * Gets the column format
     * 
     * @return string|null
     */
    public function getFormat(): ?string 
    {
        return $this->format;
    }

    /**
     * Checks if the column is sortable
     * 
     * @return bool
     */
    public function isSortable(): bool 
    {
        return $this->sortable;
    }

    /**
     * Checks if the column is searchable
     * 
     * @return bool
     */
    public function isSearchable(): bool 
    {
        return $this->searchable;
    }

    /**
     * Checks if the column is visible
     * 
     * @return bool
     */
    public function isVisible(): bool 
    {
        return $this->visible;
    }

    /**
     * Sets whether the column is sortable
     * 
     * @param bool $sortable Whether the column should be sortable
     * @return self
     */
    public function sortable(bool $sortable = true): self
    {
        $this->sortable = $sortable;
        return $this;
    }

    /**
     * Sets whether the column is searchable
     * 
     * @param bool $searchable Whether the column should be searchable
     * @return self
     */
    public function searchable(bool $searchable = true): self
    {
        $this->searchable = $searchable;
        return $this;
    }

    /**
     * Sets whether the column is visible
     * 
     * @param bool $visible Whether the column should be visible
     * @return self
     */
    public function visible(bool $visible): self
    {
        $this->visible = $visible;
        return $this;
    }

    /**
     * Sets the column width
     * 
     * @param string|null $width The width (e.g., '100px', '20%')
     * @return self
     */
    public function width(?string $width): self
    {
        $this->width = $width;
        return $this;
    }

    /**
     * Formats the column as a date
     * 
     * @param string $format The date format string
     * @return self
     */
    public function asDate(string $format = 'd/m/Y H:i'): self
    {
        $this->format = 'date';
        $this->dateFormat = $format;
        return $this;
    }

    /**
     * Formats the column as a boolean with icons
     * 
     * @param array $icons Custom icons for true/false values
     * @return self
     */
    public function asBoolean(array $icons = []): self
    {
        $this->format = 'boolean';
        $this->icons = array_merge([
            'true' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>',
            'false' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>',
        ], $icons);
        return $this;
    }

    /**
     * Formats the column as a status with custom status configurations
     * 
     * @param array $statuses The status configurations
     * @return self
     */
    public function withStatuses(array $statuses): self
    {
        $this->format = 'status';
        $this->statuses = $statuses;
        return $this;
    }

    /**
     * Sets a custom renderer for the column
     * 
     * @param callable $renderer The renderer function
     * @return self
     */
    public function withRenderer(callable $renderer): self
    {
        $this->renderer = \Closure::fromCallable($renderer);
        return $this;
    }

    /**
     * Adds a CSS class to the column
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
     * Renders the value for a given item
     * 
     * @param array $item The data item
     * @return string
     */
    public function renderValue(array $item): string
    {
        if ($this->renderer) {
            return ($this->renderer)($item);
        }
        return $item[$this->key] ?? '';
    }

    /**
     * Converts the column to an array
     * 
     * @return array
     */
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
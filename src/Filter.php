<?php

namespace Jump\JumpDataTable;

class Filter
{
    private string $name;
    private string $label;
    private string $type = 'text';
    private array $options = [];
    private $value = null;
    private array $attributes = [];
    private ?\Closure $applyCallback = null;

    public function __construct(string $name, string $label, array $config = [])
    {
        $this->name = $name;
        $this->label = $label;
        
        if (isset($config['type'])) {
            $this->type = $config['type'];
        }
        
        if (isset($config['options'])) {
            $this->options = $config['options'];
        }
        
        if (isset($config['value'])) {
            $this->value = $config['value'];
        }
        
        if (isset($config['attributes'])) {
            $this->attributes = $config['attributes'];
        }
        
        if (isset($config['apply'])) {
            $this->applyCallback = \Closure::fromCallable($config['apply']);
        }
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value): self
    {
        $this->value = $value;
        return $this;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function addAttribute(string $name, $value): self
    {
        $this->attributes[$name] = $value;
        return $this;
    }

    public function apply(array $data): array
    {
        if ($this->applyCallback) {
            return ($this->applyCallback)($data, $this->value);
        }

        if (empty($this->value)) {
            return $data;
        }

        return array_filter($data, function($item) {
            return isset($item[$this->name]) && $this->matches($item[$this->name], $this->value);
        });
    }

    protected function matches($itemValue, $filterValue): bool
    {
        switch ($this->type) {
            case 'text':
                return stripos($itemValue, $filterValue) !== false;
            case 'select':
            case 'checkbox':
                return $itemValue == $filterValue;
            case 'date':
                return $itemValue == date('Y-m-d', strtotime($filterValue));
            default:
                return $itemValue == $filterValue;
        }
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'label' => $this->label,
            'type' => $this->type,
            'options' => $this->options,
            'value' => $this->value,
            'attributes' => $this->attributes
        ];
    }

    public static function text(string $name, string $label): self
    {
        return new self($name, $label, ['type' => 'text']);
    }

    public static function select(string $name, string $label, array $options): self
    {
        return new self($name, $label, ['type' => 'select', 'options' => $options]);
    }

    public static function date(string $name, string $label): self
    {
        return new self($name, $label, ['type' => 'date']);
    }

    public static function custom(string $name, string $label, callable $applyCallback): self
    {
        return new self($name, $label, ['apply' => $applyCallback]);
    }
}
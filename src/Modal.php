<?php

namespace Jump\JumpDataTable;


class Modal
{
  $modalId = $modalId ?? 'customModal';
$modalTtitle = $modalTtitle ?? 'Confirmer l\'action';
$message = $message ?? 'Êtes-vous sûr de vouloir effectuer cette action ?';
$formAction = $formAction ?? '#';
$submitText = $submitText ?? 'Confirmer';
$cancelText = $cancelText ?? 'Annuler';
$includePasswordField = $includePasswordField ?? false;
?>
    /** @var string The filter modalId (matches the data key) */
    private string $modalId;
    
    
    /** @var string The modalTtitle to display for the Modal */
    private string $modalTtitle;
    
    /** @var string The filter type (text, select, date, etc.) */
    private string $type = 'text';
    
    /** @var array Options for select filters */
    private array $options = [];
    
    /** @var mixed The current filter value */
    private $value = null;
    
    /** @var array HTML attributes for the filter input */
    private array $attributes = [];
    
    /** @var \Closure|null Custom filter application logic */
    private ?\Closure $applyCallback = null;

    /**
     * Constructor
     * 
     * @param string $name The filter name
     * @param string $label The filter label
     * @param array $config Additional filter configuration
     */
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

    /**
     * Gets the filter name
     * 
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Gets the filter label
     * 
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * Gets the filter type
     * 
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Gets the filter options (for select filters)
     * 
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * Gets the current filter value
     * 
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Sets the filter value
     * 
     * @param mixed $value The value to set
     * @return self
     */
    public function setValue($value): self
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Gets the HTML attributes for the filter input
     * 
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * Adds an HTML attribute to the filter input
     * 
     * @param string $name The attribute name
     * @param mixed $value The attribute value
     * @return self
     */
    public function addAttribute(string $name, $value): self
    {
        $this->attributes[$name] = $value;
        return $this;
    }

    /**
     * Applies the filter to the given data
     * 
     * @param array $data The data to filter
     * @return array The filtered data
     */
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

    /**
     * Checks if an item value matches the filter value
     * 
     * @param mixed $itemValue The item value to check
     * @param mixed $filterValue The filter value
     * @return bool
     */
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

    /**
     * Converts the filter to an array
     * 
     * @return array
     */
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

    /**
     * Creates a text filter
     * 
     * @param string $name The filter name
     * @param string $label The filter label
     * @return self
     */
    public static function text(string $name, string $label): self
    {
        return new self($name, $label, ['type' => 'text']);
    }

    /**
     * Creates a select filter
     * 
     * @param string $name The filter name
     * @param string $label The filter label
     * @param array $options The select options
     * @return self
     */
    public static function select(string $name, string $label, array $options): self
    {
        return new self($name, $label, ['type' => 'select', 'options' => $options]);
    }

    /**
     * Creates a date filter
     * 
     * @param string $name The filter name
     * @param string $label The filter label
     * @return self
     */
    public static function date(string $name, string $label): self
    {
        return new self($name, $label, ['type' => 'date']);
    }

    /**
     * Creates a custom filter with custom apply logic
     * 
     * @param string $name The filter name
     * @param string $label The filter label
     * @param callable $applyCallback The custom apply logic
     * @return self
     */
    public static function custom(string $name, string $label, callable $applyCallback): self
    {
        return new self($name, $label, ['apply' => $applyCallback]);
    }
}
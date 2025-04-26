<?php

namespace Jump\JumpDataTable;

class Filter
{
    private array $filters = [];
    private array $options = [];

    public function addFilter(string $column, $value, array $options = []): self
    {
        $this->filters[$column] = $value;
        $this->options[$column] = $options;
        return $this;
    }

    public function getFilters(): array
    {
        return $this->filters;
    }

    public function getOptions(string $column): array
    {
        return $this->options[$column] ?? [];
    }

    public function clearFilters(): self
    {
        $this->filters = [];
        $this->options = [];
        return $this;
    }

    public function applyFilters(array $data): array
    {
        foreach ($this->filters as $column => $value) {
            $data = array_filter($data, function ($row) use ($column, $value) {
                return isset($row[$column]) && $this->matchesFilter($row[$column], $value);
            });
        }
        return array_values($data);
    }

    private function matchesFilter($actualValue, $filterValue): bool
    {
        // Implement custom filter logic here
        return $actualValue == $filterValue;
    }

    public function hasFilters(): bool
    {
        return !empty($this->filters);
    }
}
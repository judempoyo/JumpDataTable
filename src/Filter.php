<?php

namespace Jump\JumpDataTable;

class Filter
{
    private array $filters = [];

    /**
     * Add a filter for a specific column.
     *
     * @param string $column The column to filter.
     * @param mixed $value The value to filter by.
     * @return self
     */
    public function addFilter(string $column, $value): self
    {
        $this->filters[$column] = $value;
        return $this;
    }

    /**
     * Get all applied filters.
     *
     * @return array
     */
    public function getFilters(): array
    {
        return $this->filters;
    }

    /**
     * Clear all filters.
     *
     * @return self
     */
    public function clearFilters(): self
    {
        $this->filters = [];
        return $this;
    }

    /**
     * Apply filters to the given data.
     *
     * @param array $data The data to filter.
     * @return array The filtered data.
     */
    public function applyFilters(array $data): array
    {
        foreach ($this->filters as $column => $value) {
            $data = array_filter($data, function ($row) use ($column, $value) {
                return isset($row[$column]) && $row[$column] == $value;
            });
        }
        return array_values($data); // Reindex the array after filtering
    }

    /**
     * Check if any filters are applied.
     *
     * @return bool
     */
    public function hasFilters(): bool
    {
        return !empty($this->filters);
    }
}
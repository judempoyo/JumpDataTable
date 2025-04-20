<?php

class Filter
{
    private $filters = [];

    public function addFilter($column, $value)
    {
        $this->filters[$column] = $value;
    }

    public function getFilters()
    {
        return $this->filters;
    }

    public function clearFilters()
    {
        $this->filters = [];
    }

    public function applyFilters(array $data)
    {
        foreach ($this->filters as $column => $value) {
            $data = array_filter($data, function ($row) use ($column, $value) {
                return isset($row[$column]) && $row[$column] == $value;
            });
        }
        return $data;
    }
}
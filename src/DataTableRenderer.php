<?php

namespace Jump\JumpDataTable;

class DataTableRenderer
{
    public function render(array $params): string
    {
        extract($params);
        ob_start();
        include __DIR__.'/Resources/views/table.php';
        return ob_get_clean();
    }
}
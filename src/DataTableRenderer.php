<?php

namespace Jump\JumpDataTable;

class DataTableRenderer
{
    protected string $viewPath;

    public function __construct(string $viewPath = __DIR__ . '/Resources/views/table.php')
    {
        $this->viewPath = $viewPath;
    }

    public function render(array $params): string
    {
        if (!file_exists($this->viewPath)) {
            throw new \RuntimeException("View file not found: {$this->viewPath}");
        }

        extract($params, EXTR_SKIP); 
        ob_start();

        try {
            include $this->viewPath;
        } catch (\Throwable $e) {
            ob_end_clean(); 
            throw new \RuntimeException("An error occurred while rendering the view: " . $e->getMessage(), 0, $e);
        }

        return ob_get_clean();
    }

    public function setViewPath(string $viewPath): self
    {
        $this->viewPath = $viewPath;
        return $this;
    }
}
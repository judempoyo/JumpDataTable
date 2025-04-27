<?php

namespace Jump\JumpDataTable;

class Pagination
{
    private int $totalItems;
    private int $perPage;
    private int $currentPage;
    private string $path;
    private array $queryParams;
    private int $lastPage;
    private array $links = [];

    public function __construct(
        int $totalItems = 0,
        int $perPage = 10,
        int $currentPage = 1,
        string $path = '/',
        array $queryParams = []
    ) {
        $this->totalItems = max(0, $totalItems);
        $this->perPage = max(1, $perPage);
        $this->currentPage = max(1, $currentPage);
        $this->path = $path;
        $this->queryParams = $queryParams;
        
        $this->calculateLastPage();
        $this->generateLinks();
    }

    public function getTotalItems(): int
    {
        return $this->totalItems;
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function getLastPage(): int
    {
        return $this->lastPage;
    }

    public function getOffset(): int
    {
        return ($this->currentPage - 1) * $this->perPage;
    }

    public function getLinks(): array
    {
        return $this->links;
    }

    public function toArray(): array
    {
        return [
            'total' => $this->totalItems,
            'per_page' => $this->perPage,
            'current_page' => $this->currentPage,
            'last_page' => $this->lastPage,
            'path' => $this->path,
            'links' => $this->links
        ];
    }

    private function calculateLastPage(): void
    {
        $this->lastPage = max(1, (int) ceil($this->totalItems / $this->perPage));
        $this->currentPage = min($this->currentPage, $this->lastPage);
    }

    private function generateLinks(): void
    {
        $this->links = [];
        $queryParams = $this->queryParams;
        unset($queryParams['page']);

        // Previous link
        if ($this->currentPage > 1) {
            $this->addLink($this->currentPage - 1, '&lsaquo;', false);
        }

        // Page links
        $start = max(1, $this->currentPage - 2);
        $end = min($this->lastPage, $this->currentPage + 2);

        for ($i = $start; $i <= $end; $i++) {
            $this->addLink($i, (string)$i, $i === $this->currentPage);
        }

        // Next link
        if ($this->currentPage < $this->lastPage) {
            $this->addLink($this->currentPage + 1, '&rsaquo;', false);
        }
    }

    private function addLink(int $page, string $label, bool $active): void
    {
        $queryParams = array_merge($this->queryParams, ['page' => $page]);
        
        $this->links[] = [
            'url' => $this->path . '?' . http_build_query($queryParams),
            'label' => $label,
            'active' => $active
        ];
    }
}
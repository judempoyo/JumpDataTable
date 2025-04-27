<?php

namespace Jump\JumpDataTable;

/**
 * Handles pagination for DataTables
 * 
 * This class manages pagination logic including calculating page counts,
 * generating pagination links, and tracking the current page.
 */
class Pagination
{
    /** @var int Total number of items */
    private int $totalItems;
    
    /** @var int Number of items per page */
    private int $perPage;
    
    /** @var int Current page number */
    private int $currentPage;
    
    /** @var string Base path for pagination links */
    private string $path;
    
    /** @var array Query parameters for pagination links */
    private array $queryParams;
    
    /** @var int Last page number */
    private int $lastPage;
    
    /** @var array Generated pagination links */
    private array $links = [];

    /**
     * Constructor
     * 
     * @param int $totalItems Total number of items
     * @param int $perPage Items per page
     * @param int $currentPage Current page number
     * @param string $path Base path for links
     * @param array $queryParams Additional query parameters
     */
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

    /**
     * Gets the total number of items
     * 
     * @return int
     */
    public function getTotalItems(): int
    {
        return $this->totalItems;
    }

    /**
     * Gets the number of items per page
     * 
     * @return int
     */
    public function getPerPage(): int
    {
        return $this->perPage;
    }

    /**
     * Gets the current page number
     * 
     * @return int
     */
    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    /**
     * Gets the last page number
     * 
     * @return int
     */
    public function getLastPage(): int
    {
        return $this->lastPage;
    }

    /**
     * Gets the offset for the current page
     * 
     * @return int
     */
    public function getOffset(): int
    {
        return ($this->currentPage - 1) * $this->perPage;
    }

    /**
     * Gets the generated pagination links
     * 
     * @return array
     */
    public function getLinks(): array
    {
        return $this->links;
    }

    /**
     * Converts the pagination to an array
     * 
     * @return array
     */
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

    /**
     * Calculates the last page number
     */
    private function calculateLastPage(): void
    {
        $this->lastPage = max(1, (int) ceil($this->totalItems / $this->perPage));
        $this->currentPage = min($this->currentPage, $this->lastPage);
    }

    /**
     * Generates the pagination links
     */
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

    /**
     * Adds a pagination link
     * 
     * @param int $page The page number
     * @param string $label The link label
     * @param bool $active Whether this is the current page
     */
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
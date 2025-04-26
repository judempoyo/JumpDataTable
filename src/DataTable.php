<?php

namespace Jump\JumpDataTable;

class DataTable
{
    private string $title = 'Liste des éléments';
    private string $createUrl = '#';
    /** @var DataColumn[] */
    private array $columns = [];
    private ?iterable $data = null;
    /** @var DataAction[] */
    private array $actions = [];
    /** @var Filter[] */
    private array $filters = [];
    private string $modelName = 'default';
    private bool $showExport = true;
    private string $sort = '';
    private string $direction = 'asc';
    private string $publicUrl = '/';
    private array $pagination = [];
    private string $theme = 'tailwind';
    private array $config = [];
    private array $themes = [
        'tailwind' => Themes\TailwindTheme::class,
        'bootstrap' => Themes\BootstrapTheme::class,
    ];
    private DataTableRenderer $renderer;
    private bool $enableRowSelection = false;
    /** @var DataAction[] */
    private array $bulkActions = [];
    private string $themeMode = 'light';
    private ?string $emptyStateMessage = null;

    public function __construct(?DataTableRenderer $renderer = null)
    {
        $this->renderer = $renderer ?? new DataTableRenderer($this->theme);
        $this->config = $this->getDefaultConfig();
    }

    public static function make(): self
    {
        return new self();
    }

    // Configuration methods
    public function title(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function createUrl(string $url): self
    {
        $this->createUrl = $url;
        return $this;
    }

    public function modelName(string $name): self
    {
        $this->modelName = $name;
        return $this;
    }

    public function showExport(bool $show): self
    {
        $this->showExport = $show;
        return $this;
    }

    public function publicUrl(string $url): self
    {
        $this->publicUrl = $url;
        return $this;
    }

    public function emptyStateMessage(?string $message): self
    {
        $this->emptyStateMessage = $message;
        return $this;
    }

    // Data methods
    public function data(?iterable $data): self
    {
        if ($data !== null && !is_iterable($data)) {
            throw new \InvalidArgumentException("Data must be iterable");
        }
        $this->data = $data;
        return $this;
    }

    // Column methods
    public function addColumn(DataColumn $column): self
    {
        $this->columns[] = $column;
        return $this;
    }

    public function setColumns(array $columns): self
    {
        $this->columns = [];
        foreach ($columns as $column) {
            $this->addColumn($column instanceof DataColumn ? $column : DataColumn::fromArray($column));
        }
        return $this;
    }

    // Action methods
    public function addAction(DataAction $action): self
    {
        $this->actions[] = $action;
        return $this;
    }

    public function setActions(array $actions): self
    {
        $this->actions = [];
        foreach ($actions as $action) {
            $this->addAction($action instanceof DataAction ? $action : DataAction::fromArray($action));
        }
        return $this;
    }

    // Filter methods
    public function addFilter(Filter $filter): self
    {
        $this->filters[] = $filter;
        return $this;
    }

    public function setFilters(array $filters): self
    {
        $this->filters = [];
        foreach ($filters as $filter) {
            $this->addFilter($filter instanceof Filter ? $filter : new Filter($filter));
        }
        return $this;
    }

    // Bulk actions
    public function enableRowSelection(bool $enable = true): self
    {
        $this->enableRowSelection = $enable;
        return $this;
    }

    public function addBulkAction(DataAction $action): self
    {
        $this->bulkActions[] = $action;
        return $this;
    }

    public function setBulkActions(array $actions): self
    {
        $this->bulkActions = [];
        foreach ($actions as $action) {
            $this->addBulkAction($action instanceof DataAction ? $action : DataAction::fromArray($action));
        }
        return $this;
    }

    // Sorting
    public function sortBy(string $column, string $direction = 'asc'): self
    {
        if (!in_array(strtolower($direction), ['asc', 'desc'])) {
            throw new \InvalidArgumentException("Sort direction must be 'asc' or 'desc'");
        }
        
        $this->sort = $column;
        $this->direction = $direction;
        return $this;
    }

    // Theme methods
    public function useTheme(string $theme, array $customConfig = []): self
    {
        if (!isset($this->themes[$theme])) {
            throw new \InvalidArgumentException("Theme $theme is not supported. Available: " . implode(', ', array_keys($this->themes)));
        }

        $this->theme = $theme;
        $this->renderer = new DataTableRenderer($theme);
        $this->config = array_merge($this->getDefaultConfig(), $customConfig);
        
        return $this;
    }

    public function setThemeMode(string $mode): self
    {
        if (!in_array($mode, ['light', 'dark'])) {
            throw new \InvalidArgumentException("Theme mode must be 'light' or 'dark'");
        }
        $this->themeMode = $mode;
        return $this;
    }

    // Pagination
    public function paginate(array $config): self
    {
        $required = ['total', 'per_page', 'current_page', 'last_page', 'path'];
        foreach ($required as $key) {
            if (!isset($config[$key])) {
                throw new \InvalidArgumentException("Pagination config must contain '$key'");
            }
        }

        $this->pagination = array_merge([
            'total' => 0,
            'per_page' => 10,
            'current_page' => 1,
            'last_page' => 1,
            'path' => '/',
            'links' => []
        ], $config);

        if (empty($this->pagination['links'])) {
            $this->pagination['links'] = $this->generatePaginationLinks(
                $this->pagination['current_page'],
                $this->pagination['last_page'],
                $this->pagination['path']
            );
        }

        return $this;
    }

    // Rendering
    public function render(): string
    {
        return $this->renderer->render($this->toArray());
    }

    public function toArray(): array
    {
        if (empty($this->columns)) {
            throw new \RuntimeException("No columns defined for DataTable");
        }

        return [
            'title' => $this->title,
            'createUrl' => $this->createUrl,
            'columns' => array_map(fn($c) => $c->toArray(), $this->columns),
            'data' => $this->data,
            'actions' => array_map(fn($a) => $a->toArray(), $this->actions),
            'filters' => array_map(fn($f) => $f->toArray(), $this->filters),
            'modelName' => $this->modelName,
            'showExport' => $this->showExport,
            'sort' => $this->sort,
            'direction' => $this->direction,
            'publicUrl' => $this->publicUrl,
            'pagination' => $this->pagination,
            'enableRowSelection' => $this->enableRowSelection,
            'bulkActions' => array_map(fn($a) => $a->toArray(), $this->bulkActions),
            'theme' => $this->themeMode,
            'emptyStateMessage' => $this->emptyStateMessage,
            'config' => $this->config
        ];
    }

    // Helper methods
    protected function getDefaultConfig(): array
    {
        $themeClass = $this->themes[$this->theme];
        $config = $themeClass::getDefaultConfig();
        
        $requiredKeys = [
            'containerClass', 'titleClass', 'countBadgeClass', 'filterButtonClass',
            'addButtonClass', 'resetButtonClass', 'applyButtonClass', 'actionButtonClass',
            'filtersContainerClass', 'filterInputClass', 'filterLabelClass', 'tableClass',
            'tableHeaderClass', 'tableHeaderCellClass', 'tableBodyClass', 'tableRowClass',
            'tableCellClass', 'emptyStateClass', 'paginationClass', 'pageItemClass',
            'pageLinkClass', 'animationClass'
        ];
        
        foreach ($requiredKeys as $key) {
            if (!array_key_exists($key, $config)) {
                throw new \RuntimeException("Missing required config key '$key' for theme {$this->theme}");
            }
        }
        
        return $config;
    }

    protected function generatePaginationLinks(int $currentPage, int $lastPage, string $baseUrl): array
    {
        $links = [];
        $queryParams = $_GET;
        unset($queryParams['page']);

        // Previous link
        if ($currentPage > 1) {
            $queryParams['page'] = $currentPage - 1;
            $links[] = [
                'url' => $baseUrl . '?' . http_build_query($queryParams),
                'label' => '&lsaquo;',
                'active' => false
            ];
        }

        // Page links
        $start = max(1, $currentPage - 2);
        $end = min($lastPage, $currentPage + 2);

        for ($i = $start; $i <= $end; $i++) {
            $queryParams['page'] = $i;
            $links[] = [
                'url' => $baseUrl . '?' . http_build_query($queryParams),
                'label' => $i,
                'active' => $i == $currentPage
            ];
        }

        // Next link
        if ($currentPage < $lastPage) {
            $queryParams['page'] = $currentPage + 1;
            $links[] = [
                'url' => $baseUrl . '?' . http_build_query($queryParams),
                'label' => '&rsaquo;',
                'active' => false
            ];
        }

        return $links;
    }
}
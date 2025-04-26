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
    private array $bulkActions = [];
    private string $themeMode = 'light';

    public function __construct()
    {
        $this->config = $this->getDefaultConfig();
        $this->renderer = new DataTableRenderer($this->theme);
    }

    // Column management
   
    public function enableRowSelection(bool $enable = true): self
    {
        $this->enableRowSelection = $enable;
        return $this;
    }

    public function bulkActions(array $actions): self
    {
        $this->bulkActions = $actions;
        return $this;
    }
 

     /**
     * Set the theme for the DataTable.
     *
     * @param string $theme The theme name (e.g., 'tailwind', 'bootstrap').
     * @param array $customConfig Custom configuration for the theme.
     * @return self
     * @throws \InvalidArgumentException If the theme is not supported.
     */
    public function useTheme(string $theme, array $customConfig = []): self
    {
        if (!array_key_exists($theme, $this->themes)) {
            throw new \InvalidArgumentException("Thème $theme non supporté. Disponibles: " . implode(', ', array_keys($this->themes)));
        }

        $this->theme = $theme;
        $this->renderer = new DataTableRenderer($theme);
        $this->config = array_merge($this->getDefaultConfig(), $customConfig);
        
        return $this;
    }

     /**
     * Get the default configuration for the current theme.
     *
     * @return array The default configuration array.
     */
    protected function getDefaultConfig(): array
    {
        $themeClass = $this->themes[$this->theme];
        $config = $themeClass::getDefaultConfig();
        
        // Ensure required keys exist
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
                throw new \RuntimeException("Configuration key '$key' is missing in theme {$this->theme}");
            }
        }
        
        return $config;
    }

    /**
     * Set the theme mode (light/dark)
     * 
     * @param string $mode 'light' or 'dark'
     * @return self
     */
    public function setThemeMode(string $mode): self
    {
        if (!in_array($mode, ['light', 'dark'])) {
            throw new \InvalidArgumentException("Le mode de thème doit être 'light' ou 'dark'");
        }
        $this->themeMode = $mode;
        return $this;
    }

     /**
     * Set the pagination configuration.
     *
     * @param array $paginationConfig Must content:
     * - total:  total items
     * - per_page: per page items
     * - current_page: current page 
     * - path: basis URL
     * - links: table of pagination links 
     * @return self
     */

    public function pagination(array $paginationConfig): self
    {
        $requiredKeys = ['total', 'per_page', 'current_page', 'last_page', 'path'];
        foreach ($requiredKeys as $key) {
            if (!array_key_exists($key, $paginationConfig)) {
                throw new \InvalidArgumentException("La configuration de pagination doit contenir la clé '$key'");
            }
        }

        $this->pagination = array_merge([
            'total' => 0,
            'per_page' => 10,
            'current_page' => 1,
            'last_page' => 1,
            'path' => '/',
            'links' => []
        ], $paginationConfig);

        // Generate links if not provided
        if (empty($this->pagination['links'])) {
            $this->pagination['links'] = $this->generatePaginationLinks(
                $this->pagination['current_page'],
                $this->pagination['last_page'],
                $this->pagination['path']
            );
        }

        return $this;
    }

    /**
     * Set the columns for the DataTable.
     *
     * @param array $columns An array of column configurations.
     * @return self
     */
    public function columns(array $columns): self
    {
        foreach ($columns as $column) {
            if (!isset($column['key'])) {
                throw new \InvalidArgumentException("Chaque colonne doit avoir une clé 'key'");
            }
        }
        $this->columns = $columns;
        return $this;
    }

    /**
     * Set the actions for the DataTable.
     *
     * @param array $actions An array of action configurations.
     * @return self
     */
    public function actions(array $actions): self
    {
        foreach ($actions as $action) {
            if (!isset($action['url']) || !is_callable($action['url'])) {
                throw new \InvalidArgumentException("Chaque action doit avoir une URL callable");
            }
        }
        $this->actions = $actions;
        return $this;
    }

    /**
     * Set the data for the DataTable.
     *
     * @param iterable|null $data The data to display in the table.
     * @return self
     */
    public function data(?iterable $data): self
    {
        if ($data !== null && !is_iterable($data)) {
            throw new \InvalidArgumentException("Les données doivent être iterables");
        }
        $this->data = $data;
        return $this;
    }

   

    /**
     * Create a new instance of the DataTable.
     *
     * @return self
     */
    public static function make(): self
    {
        return new self();
    }

    /**
     * Set the title of the DataTable.
     *
     * @param string $title The title to display.
     * @return self
     */
    public function title(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Set the URL for the "create" action.
     *
     * @param string $url The URL for creating a new item.
     * @return self
     */
    public function createUrl(string $url): self
    {
        $this->createUrl = $url;
        return $this;
    }

    /**
     * Set the filters for the DataTable.
     *
     * @param array $filters An array of filter configurations.
     * @return self
     */
    public function filters(array $filters): self
    {
        $this->filters = $filters;
        return $this;
    }

    /**
     * Set the model name for the DataTable.
     *
     * @param string $modelName The name of the model.
     * @return self
     */
    public function modelName(string $modelName): self
    {
        $this->modelName = $modelName;
        return $this;
    }

    /**
     * Enable or disable the export functionality.
     *
     * @param bool $showExport Whether to show the export button.
     * @return self
     */
    public function showExport(bool $showExport): self
    {
        $this->showExport = $showExport;
        return $this;
    }

    /**
     * Set the column to sort by.
     *
     * @param string $sort The column name to sort by.
     * @return self
     */
    public function sort(string $sort): self
    {
        $this->sort = $sort;
        return $this;
    }

    /**
     * Set the sort direction.
     *
     * @param string $direction The sort direction ('asc' or 'desc').
     * @return self
     */
    public function direction(string $direction): self
    {
        $this->direction = $direction;
        return $this;
    }

    /**
     * Set the public URL for the DataTable.
     *
     * @param string $publicUrl The public URL.
     * @return self
     */
    public function publicUrl(string $publicUrl): self
    {
        $this->publicUrl = $publicUrl;
        return $this;
    }

  
    /**
     * Generate pagination links (helper)
     */
    public function generatePaginationLinks(int $currentPage, int $lastPage, string $baseUrl): array
    {
        $links = [];
        $queryParams = $_GET;
        unset($queryParams['page']);

        // Lien précédent
        if ($currentPage > 1) {
            $queryParams['page'] = $currentPage - 1;
            $links[] = [
                'url' => $baseUrl . '?' . http_build_query($queryParams),
                'label' => '&lsaquo;',
                'active' => false
            ];
        }

        // Liens des pages
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

        // Lien suivant
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
    /* public function pagination(array $pagination): self
    {
        $this->pagination = $pagination;
        return $this;
    }
 */


    /**
     * Get the current theme name
     */
    public function getCurrentTheme(): string
    {
        return $this->theme;
    }

    /**
     * Get the current theme mode
     */
    public function getThemeMode(): string
    {
        return $this->themeMode;
    }

    /**
     * Check if a theme is available
     */
    public function hasTheme(string $theme): bool
    {
        return array_key_exists($theme, $this->themes);
    }
    /**
     * Add a column to the DataTable.
     *
     * @param array $column The column configuration.
     * @return self
     */
    public function addColumn(DataColumn $column): self
    {
        $this->columns[] = $column;
        return $this;
    }

    public function setColumns(array $columns): self
    {
        $this->columns = [];
        foreach ($columns as $column) {
            if ($column instanceof DataColumn) {
                $this->columns[] = $column;
            } else {
                // Backward compatibility with array columns
                $this->columns[] = (new DataColumn($column['key'], $column['label']))->toArray();
            }
        }
        return $this;
    }
    /**
     * Add an action to the DataTable.
     *
     * @param array $action The action configuration.
     * @return self
     */
    public function addAction(DataAction $action): self
    {
        $this->actions[] = $action;
        return $this;
    }

    public function setActions(array $actions): self
    {
        $this->actions = [];
        foreach ($actions as $action) {
            if ($action instanceof DataAction) {
                $this->actions[] = $action;
            } else {
                // Backward compatibility with array actions
                $this->actions[] = DataAction::fromArray($action);
            }
        }
        return $this;
    }
    /**
     * Add a filter to the DataTable.
     *
     * @param array $filter The filter configuration.
     * @return self
     */
    public function addFilter(array $filter): self
    {
        $this->filters[] = $filter;
        return $this;
    }

    /**
     * Render the DataTable.
     *
     * @return string The rendered HTML for the DataTable.
     */
    /* public function render(): string
    {
        $renderer = new DataTableRenderer($this->theme);
        return $renderer->render($this->toArray());
    } */
    public function render(): string
    {
        return $this->renderer->render($this->toArray());
    }
 
    /**
     * Convert the DataTable configuration to an array.
     *
     * @return array The DataTable configuration as an array.
     */
    

    public function toArray(): array
    {
        if (empty($this->columns)) {
            throw new \RuntimeException("Aucune colonne définie pour le DataTable");
        }

        // Convert objects to arrays for rendering
        $columns = array_map(fn($col) => $col instanceof DataColumn ? $col->toArray() : $col, $this->columns);
        $actions = array_map(fn($act) => $act instanceof DataAction ? $act->toArray() : $act, $this->actions);

        return [
            'title' => $this->title,
            'createUrl' => $this->createUrl,
            'columns' => $columns,
            'data' => $this->data,
            'actions' => $actions,
            'filters' => $this->filters,
            'modelName' => $this->modelName,
            'showExport' => $this->showExport,
            'sort' => $this->sort,
            'direction' => $this->direction,
            'publicUrl' => $this->publicUrl,
            'pagination' => $this->pagination,
            'enableRowSelection' => $this->enableRowSelection,
            'bulkActions' => $this->bulkActions,
            'theme' => $this->themeMode
        ];
    }
}

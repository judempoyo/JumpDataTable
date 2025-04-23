<?php

namespace Jump\JumpDataTable;

class DataTable
{
    protected string $title = 'Liste des éléments';
    protected string $createUrl = '#';
    protected array $columns = [];
    protected ?iterable $data = null;
    protected array $actions = [];
    protected array $filters = [];
    protected string $modelName = 'default';
    protected bool $showExport = true;
    protected string $sort = '';
    protected string $direction = 'asc';
    protected string $publicUrl = '/';
    protected array $pagination = [];

    protected string $theme = 'tailwind';
    protected array $config = [];
    protected array $themes = [
        'tailwind' => Themes\TailwindTheme::class,
        'bootstrap' => Themes\BootstrapTheme::class,
    ];
    protected DataTableRenderer $renderer;
    
    protected bool $enableRowSelection = false;
    protected array $bulkActions = [];

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


    public function __construct()
    {
        $this->config = $this->getDefaultConfig();
        $this->renderer = new DataTableRenderer($this->theme);
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
            throw new \InvalidArgumentException("Thème $theme non supporté");
        }

        $this->theme = $theme;
        $this->config = array_merge($this->getDefaultConfig(), $customConfig);

        return $this;
    }

    public function hasTheme(string $theme): bool
    {
        return array_key_exists($theme, $this->themes);
    }

    /**
     * Get the default configuration for the current theme.
     *
     * @return array The default configuration array.
     */
    protected function getDefaultConfig(): array
    {
        $themeClass = $this->themes[$this->theme];
        return $themeClass::getDefaultConfig();
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
     * Set the columns for the DataTable.
     *
     * @param array $columns An array of column configurations.
     * @return self
     */
    public function columns(array $columns): self
    {
        $this->columns = $columns;
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
        $this->data = $data;
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
        $this->actions = $actions;
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
        $this->pagination = array_merge([
            'total' => 0,
            'per_page' => 10,
            'current_page' => 1,
            'last_page' => 1,
            'path' => '/',
            'links' => []
        ], $paginationConfig);

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
     * Add a column to the DataTable.
     *
     * @param array $column The column configuration.
     * @return self
     */
    public function addColumn(array $column): self
    {
        $this->columns[] = $column;
        return $this;
    }

    /**
     * Add an action to the DataTable.
     *
     * @param array $action The action configuration.
     * @return self
     */
    public function addAction(array $action): self
    {
        $this->actions[] = $action;
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
     * Set the theme mode (light/dark)
     * 
     * @param string $mode 'light' or 'dark'
     * @return self
     */
    public function setThemeMode(string $mode): self
    {
        if (!in_array($mode, ['light', 'dark'])) {
            throw new \InvalidArgumentException("Theme mode must be either 'light' or 'dark'");
        }

        $this->config['theme_mode'] = $mode;
        return $this;
    }
    /**
     * Convert the DataTable configuration to an array.
     *
     * @return array The DataTable configuration as an array.
     */
    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'createUrl' => $this->createUrl,
            'columns' => $this->columns,
            'data' => $this->data,
            'actions' => $this->actions,
            'filters' => $this->filters,
            'modelName' => $this->modelName,
            'showExport' => $this->showExport,
            'sort' => $this->sort,
            'direction' => $this->direction,
            'publicUrl' => $this->publicUrl,
            'pagination' => $this->pagination,
            'enableRowSelection' => $this->enableRowSelection,
            'bulkActions' => $this->bulkActions,
            'theme' => $this->config['theme_mode'] ?? 'light'
        ];
    }
}

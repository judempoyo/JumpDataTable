<?php

namespace Jump\JumpDataTable;

/**
 * Main DataTable class that represents a complete data table with columns, data, actions, etc.
 * 
 * This is the primary class used to configure and render data tables with sorting,
 * filtering, pagination, and various display options.
 */
class DataTable
{
    /** @var string The table title */
    private string $title = 'Liste des éléments';
    
    /** @var string URL for the create action */
    private string $createUrl = '#';
    
    /** @var DataColumn[] Array of columns in the table */
    private array $columns = [];
    
    /** @var iterable|null The data to display in the table */
    private ?iterable $data = null;
    
    /** @var DataAction[] Array of actions for each row */
    private array $actions = [];
    
    /** @var Filter[] Array of filters for the table */
    private array $filters = [];
    
    /** @var string The model name used for translations and identifiers */
    private string $modelName = 'default';
    
    /** @var bool Whether to show export buttons */
    private bool $showExport = true;
    
    /** @var string The column to sort by */
    private string $sort = '';
    
    /** @var string The sort direction ('asc' or 'desc') */
    private string $direction = 'asc';
    
    /** @var string The public URL base for links */
    private string $publicUrl = '/';
    
    /** @var Pagination The pagination configuration */
    private Pagination $pagination;
    
    /** @var string The theme to use ('tailwind' or 'bootstrap') */
    private string $theme = 'tailwind';
    
    /** @var array Configuration options for the theme */
    private array $config = [];
    
    /** @var array Map of available themes to their classes */
    private array $themes = [
        'tailwind' => Themes\TailwindTheme::class,
        'bootstrap' => Themes\BootstrapTheme::class,
    ];
    
    /** @var DataTableRenderer The renderer instance */
    private DataTableRenderer $renderer;
    
    /** @var bool Whether row selection is enabled */
    private bool $enableRowSelection = false;
    
    /** @var DataAction[] Array of bulk actions */
    private array $bulkActions = [];
    
    /** @var string The theme mode ('light' or 'dark') */
    private string $themeMode = 'light';
    
    /** @var string|null Custom message to show when table is empty */
    private ?string $emptyStateMessage = null;

    /** @var Modal|null Le modal de confirmation */
private ?Modal $confirmationModal = null;

    /**
     * Constructor
     * 
     * @param DataTableRenderer|null $renderer Optional custom renderer
     */
    public function __construct(?DataTableRenderer $renderer = null)
    {
        $this->renderer = $renderer ?? new DataTableRenderer($this->theme);
        $this->config = $this->getDefaultConfig();
        $this->pagination = new Pagination(); // Initialisation avec une pagination vide
    }

    /**
     * Factory method to create a new DataTable instance
     * 
     * @return self
     */
    public static function make(): self
    {
        return new self();
    }

    // Configuration methods

    /**
     * Sets the table title
     * 
     * @param string $title The title
     * @return self
     */
    public function title(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Sets the URL for the create action
     * 
     * @param string $url The URL
     * @return self
     */
    public function createUrl(string $url): self
    {
        $this->createUrl = $url;
        return $this;
    }

    /**
     * Sets the model name used for translations and identifiers
     * 
     * @param string $name The model name
     * @return self
     */
    public function modelName(string $name): self
    {
        $this->modelName = $name;
        return $this;
    }

    /**
     * Sets whether to show export buttons
     * 
     * @param bool $show Whether to show export
     * @return self
     */
    public function showExport(bool $show): self
    {
        $this->showExport = $show;
        return $this;
    }

    /**
     * Sets the public URL base for links
     * 
     * @param string $url The base URL
     * @return self
     */
    public function publicUrl(string $url): self
    {
        $this->publicUrl = $url;
        return $this;
    }

    /**
     * Sets a custom empty state message
     * 
     * @param string|null $message The message to show when table is empty
     * @return self
     */
    public function emptyStateMessage(?string $message): self
    {
        $this->emptyStateMessage = $message;
        return $this;
    }

    // Data methods

    /**
     * Sets the data for the table
     * 
     * @param iterable|null $data The data to display
     * @return self
     * @throws \InvalidArgumentException If data is not iterable
     */
    public function data(?iterable $data): self
    {
        if ($data !== null && !is_iterable($data)) {
            throw new \InvalidArgumentException("Data must be iterable");
        }
        $this->data = $data;
        return $this;
    }

    // Column methods

    /**
     * Adds a column to the table
     * 
     * @param DataColumn $column The column to add
     * @return self
     */
    public function addColumn(DataColumn $column): self
    {
        $this->columns[] = $column;
        return $this;
    }

    /**
     * Sets all columns from an array of configurations or DataColumn objects
     * 
     * @param array $columns Array of column configurations
     * @return self
     */
    public function setColumns(array $columns): self
    {
        $this->columns = [];
        foreach ($columns as $column) {
            $this->addColumn($column instanceof DataColumn ? $column : DataColumn::fromArray($column));
        }
        return $this;
    }

    // Action methods

    /**
     * Adds an action to each row
     * 
     * @param DataAction $action The action to add
     * @return self
     */
    public function addAction(DataAction $action): self
    {
        $this->actions[] = $action;
        return $this;
    }

    /**
     * Sets all actions from an array of configurations or DataAction objects
     * 
     * @param array $actions Array of action configurations
     * @return self
     */
    public function setActions(array $actions): self
    {
        $this->actions = [];
        foreach ($actions as $action) {
            $this->addAction($action instanceof DataAction ? $action : DataAction::fromArray($action));
        }
        return $this;
    }

    // Filter methods

    /**
     * Adds a filter to the table
     * 
     * @param Filter $filter The filter to add
     * @return self
     */
    public function addFilter(Filter $filter): self
    {
        $this->filters[] = $filter;
        return $this;
    }

    /**
     * Sets all filters from an array of configurations or Filter objects
     * 
     * @param array $filters Array of filter configurations
     * @return self
     */
    public function setFilters(array $filters): self
    {
        $this->filters = [];
        foreach ($filters as $filter) {
            $this->addFilter($filter instanceof Filter ? $filter : new Filter($filter['name'] ?? '', $filter['label'] ?? '', $filter));
        }
        return $this;
    }

    // Bulk actions

    /**
     * Enables or disables row selection for bulk actions
     * 
     * @param bool $enable Whether to enable row selection
     * @return self
     */
    public function enableRowSelection(bool $enable = true): self
    {
        $this->enableRowSelection = $enable;
        return $this;
    }

    /**
     * Adds a bulk action
     * 
     * @param DataAction $action The bulk action to add
     * @return self
     */
    public function addBulkAction(DataAction $action): self
    {
        $this->bulkActions[] = $action;
        return $this;
    }

    /**
     * Sets all bulk actions from an array of configurations or DataAction objects
     * 
     * @param array $actions Array of bulk action configurations
     * @return self
     */
    public function setBulkActions(array $actions): self
    {
        $this->bulkActions = [];
        foreach ($actions as $action) {
            $this->addBulkAction($action instanceof DataAction ? $action : DataAction::fromArray($action));
        }
        return $this;
    }

    // Sorting

    /**
     * Sets the sorting column and direction
     * 
     * @param string $column The column to sort by
     * @param string $direction The sort direction ('asc' or 'desc')
     * @return self
     * @throws \InvalidArgumentException If direction is invalid
     */
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

    /**
     * Sets the theme to use
     * 
     * @param string $theme The theme name ('tailwind' or 'bootstrap')
     * @param array $customConfig Custom theme configuration
     * @return self
     * @throws \InvalidArgumentException If theme is not supported
     */
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

    /**
     * Sets the theme mode (light or dark)
     * 
     * @param string $mode The mode ('light' or 'dark')
     * @return self
     * @throws \InvalidArgumentException If mode is invalid
     */
    public function setThemeMode(string $mode): self
    {
        if (!in_array($mode, ['light', 'dark'])) {
            throw new \InvalidArgumentException("Theme mode must be 'light' or 'dark'");
        }
        $this->themeMode = $mode;
        return $this;
    }

    // Pagination methods

    /**
     * Sets the pagination configuration
     * 
     * @param Pagination $pagination The pagination configuration
     * @return self
     */
    public function setPagination(Pagination $pagination): self
    {
        $this->pagination = $pagination;
        return $this;
    }

    /**
     * Configures pagination with parameters
     * 
     * @param int $totalItems Total number of items
     * @param int $perPage Items per page
     * @param int $currentPage Current page number
     * @param string $path Base path for pagination links
     * @param array|null $queryParams Additional query parameters
     * @return self
     */
    public function paginate(
        int $totalItems,
        int $perPage = 10,
        int $currentPage = 1,
        string $path = '/',
        ?array $queryParams = null
    ): self {
        $this->pagination = new Pagination(
            $totalItems,
            $perPage,
            $currentPage,
            $path,
            $queryParams ?? $_GET
        );
        return $this;
    }

    /**
     * Gets the pagination configuration
     * 
     * @return Pagination
     */
    public function getPagination(): Pagination
    {
        return $this->pagination;
    }

    // Rendering

    /**
     * Renders the table to HTML
     * 
     * @return string
     */
    public function render(): string
    {
        return $this->renderer->render($this->toArray());
    }

    /**
 * Sets the confirmation modal configuration
 * 
 * @param Modal|array $modal Modal instance or configuration array
 * @return self
 */
public function setConfirmationModal($modal): self
{
    if (is_array($modal)) {
        $this->confirmationModal = new Modal(
            $modal['id'] ?? 'customModal',
            $modal['title'] ?? 'Confirmer l\'action',
            $modal['message'] ?? 'Êtes-vous sûr de vouloir effectuer cette action ?',
            $modal['formAction'] ?? '#',
            $modal['submitText'] ?? 'Confirmer',
            $modal['cancelText'] ?? 'Annuler',
            $modal['includePasswordField'] ?? false
        );
    } elseif ($modal instanceof Modal) {
        $this->confirmationModal = $modal;
    }
    
    return $this;
}

    /**
     * Converts the table configuration to an array
     * 
     * @return array
     * @throws \RuntimeException If no columns are defined
     */
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
            'pagination' => $this->pagination->toArray(),
            'enableRowSelection' => $this->enableRowSelection,
            'bulkActions' => array_map(fn($a) => $a->toArray(), $this->bulkActions),
            'darkMode' => $this->themeMode === 'dark',
            'theme' => $this->themeMode,
            'emptyStateMessage' => $this->emptyStateMessage,
            'config' => $this->config,
            'confirmationModal' => $this->confirmationModal?->toArray()
        ];
    }

    /**
     * Gets the default configuration for the current theme
     * 
     * @return array
     * @throws \RuntimeException If required config keys are missing
     */
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
}
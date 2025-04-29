<?php

namespace Jump\JumpDataTable;

/**
 * Handles rendering of the DataTable using the specified theme
 * 
 * This class is responsible for taking the DataTable configuration and
 * generating the HTML output using the appropriate theme templates.
 */
class DataTableRenderer
{
    /** @var string The current theme name */
    private string $theme;
    
    /** @var string The fully qualified theme class name */
    private string $themeClass;
    
    /** @var string Path to the views directory */
    private string $viewsPath;

    /**
     * Constructor
     * 
     * @param string $theme The theme to use
     * @param string|null $viewsPath Optional custom path to views directory
     * @throws \InvalidArgumentException If theme is not supported
     */
    public function __construct(string $theme, ?string $viewsPath = null)
    {
        $this->theme = $theme;
        $this->themeClass = "Jump\\JumpDataTable\\Themes\\" . ucfirst($theme) . "Theme";
        $this->viewsPath = $viewsPath ?? __DIR__ . '/Resources/views';
        
        if (!class_exists($this->themeClass)) {
            throw new \InvalidArgumentException("Theme {$theme} is not supported");
        }
    }

    /**
     * Renders the DataTable with the given parameters
     * 
     * @param array $params The DataTable configuration parameters
     * @return string The rendered HTML
     */
    public function render(array $params): string
    {
        $darkMode = ($params['theme'] ?? 'light') === 'dark';
        
        $params['themeClasses'] = $this->generateThemeClasses();
        $params['columns'] = $this->normalizeColumns($params['columns'] ?? []);
        $params['actions'] = $this->normalizeActions($params['actions'] ?? []);

        return $this->renderView($this->getViewPath(), $params);
    }

    /**
     * Normalizes columns to ensure they are in array format
     * 
     * @param array $columns Array of columns (either arrays or DataColumn objects)
     * @return array Array of column arrays
     */
    protected function normalizeColumns(array $columns): array
    {
        return array_map(function($col) {
            return $col instanceof DataColumn ? $col->toArray() : $col;
        }, $columns);
    }

    /**
     * Normalizes actions to ensure they are in array format
     * 
     * @param array $actions Array of actions (either arrays or DataAction objects)
     * @return array Array of action arrays
     */
    protected function normalizeActions(array $actions): array
    {
        return array_map(function($act) {
            return $act instanceof DataAction ? $act->toArray() : $act;
        }, $actions);
    }

    /**
     * Renders a view file with the given data
     * 
     * @param string $path Path to the view file
     * @param array $data Data to pass to the view
     * @return string The rendered output
     */
    protected function renderView(string $path, array $data): string
    {
        extract($data);
        ob_start();
        include $path;
        return ob_get_clean();
    }

    /**
     * Generates all theme CSS classes for the current theme
     * 
     * @param bool $darkMode Whether dark mode is enabled
     * @return array Array of CSS classes for different table elements
     */
    protected function generateThemeClasses(): array
    {
        return [
            'container' => $this->themeClass::getContainerClasses(),
            'title' => $this->themeClass::getTitleClasses(),
            'countBadge' => $this->themeClass::getCountBadgeClasses(),
            'filterButton' => $this->themeClass::getFilterButtonClasses(),
            'exportButton' => $this->themeClass::getExportButtonClasses(),
            'addButton' => $this->themeClass::getAddButtonClasses(),
            'resetButton' => $this->themeClass::getResetButtonClasses(),
            'applyButton' => $this->themeClass::getApplyButtonClasses(),
            'actionButton' => $this->themeClass::getActionButtonClasses(),
            'filtersContainer' => $this->themeClass::getFiltersContainerClasses(),
            'filterInput' => $this->themeClass::getFilterInputClasses(),
            'filterLabel' => $this->themeClass::getFilterLabelClasses(),
            'table' => $this->themeClass::getTableClasses(),
            'tableHeader' => $this->themeClass::getTableHeaderClasses(),
            'tableHeaderCell' => $this->themeClass::getTableHeaderCellClasses(),
            'tableBody' => $this->themeClass::getTableBodyClasses(),
            'tableRow' => $this->themeClass::getTableRowClasses(),
            'tableCell' => $this->themeClass::getTableCellClasses(),
            'emptyState' => $this->themeClass::getEmptyStateClasses(),
            'filterIcon' => $this->themeClass::getFilterIconClasses(),
            'exportIcon' => $this->themeClass::getExportIconClasses(),
            'addIcon' => $this->themeClass::getAddIconClasses(),
            'pagination' => $this->themeClass::getPaginationClasses(),
            'pageItem' => $this->themeClass::getPageItemClasses(),
            'pageLink' => $this->themeClass::getPageLinkClasses(),
            'animations' => [
                'header' => $this->themeClass::getHeaderAnimation(),
                'table' => $this->themeClass::getTableAnimation(),
                'rows' => $this->themeClass::getRowAnimation(),
                'pagination' => $this->themeClass::getPaginationAnimation(),
                'filters' => $this->themeClass::getFiltersAnimation()
            ]
            
        ];
    }

    /**
     * Gets the path to the view file for the current theme
     * 
     * @return string The view file path
     */
    protected function getViewPath(): string
    {
        return $this->viewsPath . '/' . ucfirst($this->theme) . '/table.php';
    }
}
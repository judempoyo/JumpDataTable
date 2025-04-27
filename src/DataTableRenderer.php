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
        
        $params['themeClasses'] = $this->generateThemeClasses($darkMode);
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
    protected function generateThemeClasses(bool $darkMode): array
    {
        return [
            'container' => $this->themeClass::getContainerClasses($darkMode),
            'title' => $this->themeClass::getTitleClasses($darkMode),
            'countBadge' => $this->themeClass::getCountBadgeClasses($darkMode),
            'filterButton' => $this->themeClass::getFilterButtonClasses($darkMode),
            'exportButton' => $this->themeClass::getExportButtonClasses($darkMode),
            'addButton' => $this->themeClass::getAddButtonClasses($darkMode),
            'resetButton' => $this->themeClass::getResetButtonClasses($darkMode),
            'applyButton' => $this->themeClass::getApplyButtonClasses($darkMode),
            'actionButton' => $this->themeClass::getActionButtonClasses($darkMode),
            'filtersContainer' => $this->themeClass::getFiltersContainerClasses($darkMode),
            'filterInput' => $this->themeClass::getFilterInputClasses($darkMode),
            'filterLabel' => $this->themeClass::getFilterLabelClasses($darkMode),
            'table' => $this->themeClass::getTableClasses($darkMode),
            'tableHeader' => $this->themeClass::getTableHeaderClasses($darkMode),
            'tableHeaderCell' => $this->themeClass::getTableHeaderCellClasses($darkMode),
            'tableBody' => $this->themeClass::getTableBodyClasses($darkMode),
            'tableRow' => $this->themeClass::getTableRowClasses($darkMode),
            'tableCell' => $this->themeClass::getTableCellClasses($darkMode),
            'emptyState' => $this->themeClass::getEmptyStateClasses($darkMode),
            'filterIcon' => $this->themeClass::getFilterIconClasses($darkMode),
            'exportIcon' => $this->themeClass::getExportIconClasses($darkMode),
            'addIcon' => $this->themeClass::getAddIconClasses($darkMode),
            'pagination' => $this->themeClass::getPaginationClasses($darkMode),
            'pageItem' => $this->themeClass::getPageItemClasses($darkMode),
            'pageLink' => $this->themeClass::getPageLinkClasses($darkMode),
            'animation' => $this->themeClass::getAnimationClasses('fadeIn')
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
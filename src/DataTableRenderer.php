<?php

namespace Jump\JumpDataTable;

class DataTableRenderer
{
    protected string $theme;
    protected string $themeClass;

    /**
     * Constructor for the DataTableRenderer.
     *
     * @param string $theme The theme name (e.g., 'tailwind', 'bootstrap').
     * @throws \InvalidArgumentException If the theme class does not exist.
     */
    public function __construct(string $theme = 'tailwind')
    {
        $this->theme = $theme;
        $this->themeClass = "Jump\\JumpDataTable\\Themes\\" . ucfirst($theme) . "Theme";
        
        if (!class_exists($this->themeClass)) {
            throw new \InvalidArgumentException("Theme {$theme} is not supported");
        }
    }

    /**
     * Render the DataTable with the given parameters.
     *
     * @param array $params The parameters for rendering the DataTable.
     * @return string The rendered HTML for the DataTable.
     */
    public function render(array $params): string
    {
        $darkMode = ($params['theme'] ?? 'light') === 'dark';
        $themeClasses = $this->generateThemeClasses($darkMode);

        $params['themeClasses'] = $themeClasses;
        $viewPath = $this->getViewPath();

        extract($params);
        ob_start();
        include $viewPath;
        return ob_get_clean();
    }

    /**
     * Generate the CSS classes for the current theme.
     *
     * @param bool $darkMode Whether dark mode is enabled.
     * @return array An array of CSS classes for the theme.
     */
    protected function generateThemeClasses(bool $darkMode): array
    {
        return [
            // Structure
            'container' => $this->themeClass::getContainerClasses($darkMode),
            'title' => $this->themeClass::getTitleClasses($darkMode),
            'countBadge' => $this->themeClass::getCountBadgeClasses($darkMode),
            
            // Buttons
            'filterButton' => $this->themeClass::getFilterButtonClasses($darkMode),
            'exportButton' => $this->themeClass::getExportButtonClasses($darkMode),
            'addButton' => $this->themeClass::getAddButtonClasses($darkMode),
            'resetButton' => $this->themeClass::getResetButtonClasses($darkMode),
            'applyButton' => $this->themeClass::getApplyButtonClasses($darkMode),
            'actionButton' => $this->themeClass::getActionButtonClasses($darkMode),
            
            // Filters
            'filtersContainer' => $this->themeClass::getFiltersContainerClasses($darkMode),
            'filterInput' => $this->themeClass::getFilterInputClasses($darkMode),
            'filterLabel' => $this->themeClass::getFilterLabelClasses($darkMode),
            
            // Table
            'table' => $this->themeClass::getTableClasses($darkMode),
            'tableHeader' => $this->themeClass::getTableHeaderClasses($darkMode),
            'tableHeaderCell' => $this->themeClass::getTableHeaderCellClasses($darkMode),
            'tableBody' => $this->themeClass::getTableBodyClasses($darkMode),
            'tableRow' => $this->themeClass::getTableRowClasses($darkMode),
            'tableCell' => $this->themeClass::getTableCellClasses($darkMode),
            
            // Empty state
            'emptyState' => $this->themeClass::getEmptyStateClasses($darkMode),
            
            // Icons
            'filterIcon' => $this->themeClass::getFilterIconClasses($darkMode),
            'exportIcon' => $this->themeClass::getExportIconClasses($darkMode),
            'addIcon' => $this->themeClass::getAddIconClasses($darkMode),
            
            // Pagination
            'pagination' => $this->themeClass::getPaginationClasses($darkMode),
            'pageItem' => $this->themeClass::getPageItemClasses($darkMode),
            'pageLink' => $this->themeClass::getPageLinkClasses($darkMode),
            
            // Animations
            'animation' => $this->themeClass::getAnimationClasses('fadeIn')
        ];
    }

    /**
     * Get the path to the view file for the current theme.
     *
     * @return string The path to the view file.
     */
    protected function getViewPath(): string
    {
        return __DIR__ . '/Resources/views/' . ucfirst($this->theme) . '/table.php';
    }
}
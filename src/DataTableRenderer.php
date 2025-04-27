<?php

namespace Jump\JumpDataTable;

class DataTableRenderer
{
    private string $theme;
    private string $themeClass;
    private string $viewsPath;

    public function __construct(string $theme, ?string $viewsPath = null)
    {
        $this->theme = $theme;
        $this->themeClass = "Jump\\JumpDataTable\\Themes\\" . ucfirst($theme) . "Theme";
        $this->viewsPath = $viewsPath ?? __DIR__ . '/Resources/views';
        
        if (!class_exists($this->themeClass)) {
            throw new \InvalidArgumentException("Theme {$theme} is not supported");
        }
    }

    public function render(array $params): string
    {
        $darkMode = ($params['theme'] ?? 'light') === 'dark';
        
        $params['themeClasses'] = $this->generateThemeClasses($darkMode);
        $params['columns'] = $this->normalizeColumns($params['columns'] ?? []);
        $params['actions'] = $this->normalizeActions($params['actions'] ?? []);

        return $this->renderView($this->getViewPath(), $params);
    }

    protected function normalizeColumns(array $columns): array
    {
        return array_map(function($col) {
            return $col instanceof DataColumn ? $col->toArray() : $col;
        }, $columns);
    }

    protected function normalizeActions(array $actions): array
    {
        return array_map(function($act) {
            return $act instanceof DataAction ? $act->toArray() : $act;
        }, $actions);
    }

    protected function renderView(string $path, array $data): string
    {
        extract($data);
        ob_start();
        include $path;
        return ob_get_clean();
    }

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

    protected function getViewPath(): string
    {
        return $this->viewsPath . '/' . ucfirst($this->theme) . '/table.php';
    }
}
<?php

namespace Jump\JumpDataTable;

class DataTableRenderer
{
    protected string $theme;
    protected string $themeClass;

    public function __construct(string $theme = 'tailwind')
    {
        $this->theme = $theme;
        $this->themeClass = "Jump\\JumpDataTable\\Themes\\" . ucfirst($theme) . "Theme";
        
        if (!class_exists($this->themeClass)) {
            throw new \InvalidArgumentException("Theme {$theme} is not supported");
        }
    }

    public function render(array $params): string
    {
        $theme = $params['theme'] ?? 'light';
        $darkMode = $theme === 'dark';
        
        // Génère toutes les classes CSS nécessaires
        $themeClasses = [
            'container' => $this->themeClass::getContainerClasses($darkMode),
            'title' => $this->themeClass::getTitleClasses($darkMode),
            'countBadge' => $this->themeClass::getCountBadgeClasses($darkMode),
            // ... toutes les autres classes
        ];

        $params['themeClasses'] = $themeClasses;
        $viewPath = $this->themeClass::getViewPath();

        if (!file_exists($viewPath)) {
            throw new \RuntimeException("View file not found: {$viewPath}");
        }

        extract($params);
        ob_start();
        include $viewPath;
        return ob_get_clean();
    }
}
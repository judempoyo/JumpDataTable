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

    public function useTheme(string $theme, array $customConfig = []): self
    {
        if (!array_key_exists($theme, $this->themes)) {
            throw new \InvalidArgumentException("Thème $theme non supporté");
        }

        $this->theme = $theme;
        $this->config = array_merge($this->getDefaultConfig(), $customConfig);

        return $this;
    }

    protected function getDefaultConfig(): array
    {
        $themeClass = $this->themes[$this->theme];
        return $themeClass::getDefaultConfig();
    }



    public static function make(): self
    {
        return new self();
    }

    // Setters with fluent interface
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

    public function columns(array $columns): self
    {
        $this->columns = $columns;
        return $this;
    }

    public function data(?iterable $data): self
    {
        $this->data = $data;
        return $this;
    }

    public function actions(array $actions): self
    {
        $this->actions = $actions;
        return $this;
    }

    public function filters(array $filters): self
    {
        $this->filters = $filters;
        return $this;
    }

    public function modelName(string $modelName): self
    {
        $this->modelName = $modelName;
        return $this;
    }

    public function showExport(bool $showExport): self
    {
        $this->showExport = $showExport;
        return $this;
    }

    public function sort(string $sort): self
    {
        $this->sort = $sort;
        return $this;
    }

    public function direction(string $direction): self
    {
        $this->direction = $direction;
        return $this;
    }

    public function publicUrl(string $publicUrl): self
    {
        $this->publicUrl = $publicUrl;
        return $this;
    }

    public function pagination(array $pagination): self
    {
        $this->pagination = $pagination;
        return $this;
    }

    public function addColumn(array $column): self
    {
        $this->columns[] = $column;
        return $this;
    }

    public function addAction(array $action): self
    {
        $this->actions[] = $action;
        return $this;
    }

    public function addFilter(array $filter): self
    {
        $this->filters[] = $filter;
        return $this;
    }

    /*  public function render(): string
     {
         $renderer = new DataTableRenderer();
         return $renderer->render($this->toArray());
     }
  */
    public function render(): string
    {
        $renderer = new DataTableRenderer($this->theme);
        return $renderer->render($this->toArray());
    }


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
        ];
    }
}
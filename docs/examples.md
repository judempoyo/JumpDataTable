# Exemples pratiques / Practical Examples

---

## 🌐 Table of Contents / Table des matières

- [Exemples pratiques / Practical Examples](#exemples-pratiques--practical-examples)
  - [🌐 Table of Contents / Table des matières](#-table-of-contents--table-des-matières)
  - [🇫🇷 Français](#-français)
    - [Tableau basique](#tableau-basique)
    - [Avec actions](#avec-actions)
    - [Avec pagination](#avec-pagination)
    - [Avec filtres](#avec-filtres)
    - [Actions groupées](#actions-groupées)
    - [Personnalisation avancée](#personnalisation-avancée)
  - [🇬🇧 English](#-english)
    - [Basic Table](#basic-table)
    - [With Actions](#with-actions)
    - [With Pagination](#with-pagination)
    - [With Filters](#with-filters)
    - [Bulk Actions](#bulk-actions)
    - [Advanced Customization](#advanced-customization)
    - [Notes](#notes)

---

## 🇫🇷 Français

### Tableau basique

```php
$table = DataTable::make()
    ->title('Produits')
    ->data($products)
    ->setColumns([
        ['key' => 'id', 'label' => 'ID', 'sortable' => true],
        ['key' => 'name', 'label' => 'Nom du produit'],
        ['key' => 'price', 'label' => 'Prix']
    ]);
```

### Avec actions

```php
$table->setActions([
    [
        'type' => 'edit',
        'label' => 'Modifier',
        'url' => fn($item) => "/products/{$item['id']}/edit"
    ],
    [
        'type' => 'delete',
        'label' => 'Supprimer',
        'url' => fn($item) => "/products/{$item['id']}"
    ]
]);
```

### Avec pagination

```php
$table->paginate(
    totalItems: Product::count(),
    perPage: 15,
    currentPage: request('page', 1)
);
```

### Avec filtres

```php
$table->setFilters([
    Filter::text('search', 'Recherche'),
    Filter::select('status', 'Statut', [
        'active' => 'Actif',
        'inactive' => 'Inactif'
    ])
]);
```

### Actions groupées

```php
$table->enableRowSelection()
    ->setBulkActions([
        [
            'label' => 'Exporter la sélection',
            'url' => '/export'
        ],
        [
            'label' => 'Supprimer la sélection',
            'url' => '/delete',
            'confirm' => 'Êtes-vous sûr de vouloir supprimer ces éléments ?'
        ]
    ]);
```

### Personnalisation avancée

```php
$table->setColumns([
    [
        'key' => 'avatar',
        'label' => 'Photo',
        'render' => fn($item) => "<img src='{$item['avatar']}' class='w-10 h-10 rounded-full'>"
    ]
]);
```

---

## 🇬🇧 English

### Basic Table

```php
$table = DataTable::make()
    ->title('Products')
    ->data($products)
    ->setColumns([
        ['key' => 'id', 'label' => 'ID', 'sortable' => true],
        ['key' => 'name', 'label' => 'Product Name'],
        ['key' => 'price', 'label' => 'Price']
    ]);
```

### With Actions

```php
$table->setActions([
    [
        'type' => 'edit',
        'label' => 'Edit',
        'url' => fn($item) => "/products/{$item['id']}/edit"
    ],
    [
        'type' => 'delete',
        'label' => 'Delete',
        'url' => fn($item) => "/products/{$item['id']}"
    ]
]);
```

### With Pagination

```php
$table->paginate(
    totalItems: Product::count(),
    perPage: 15,
    currentPage: request('page', 1)
);
```

### With Filters

```php
$table->setFilters([
    Filter::text('search', 'Search'),
    Filter::select('status', 'Status', [
        'active' => 'Active',
        'inactive' => 'Inactive'
    ])
]);
```

### Bulk Actions

```php
$table->enableRowSelection()
    ->setBulkActions([
        [
            'label' => 'Export Selection',
            'url' => '/export'
        ],
        [
            'label' => 'Delete Selection',
            'url' => '/delete',
            'confirm' => 'Are you sure you want to delete these items?'
        ]
    ]);
```

### Advanced Customization

```php
$table->setColumns([
    [
        'key' => 'avatar',
        'label' => 'Photo',
        'render' => fn($item) => "<img src='{$item['avatar']}' class='w-10 h-10 rounded-full'>"
    ]
]);
```

---

### Notes

- Les exemples sont identiques dans les deux langues pour garantir une expérience utilisateur cohérente.
- Examples are identical in both languages to ensure a consistent user experience.
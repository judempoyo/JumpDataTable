# Configuration / Configuration

---

## 🌐 Table of Contents / Table des matières

- [Configuration / Configuration](#configuration--configuration)
  - [🌐 Table of Contents / Table des matières](#-table-of-contents--table-des-matières)
  - [🇫🇷 Français](#-français)
    - [Options principales](#options-principales)
    - [Colonnes](#colonnes)
    - [Exemple complet](#exemple-complet)
  - [🇬🇧 English](#-english)
    - [Main Options](#main-options)
    - [Columns](#columns)
    - [Full Example](#full-example)

---

## 🇫🇷 Français

### Options principales

```php
DataTable::make()
    ->title('Titre du tableau')        // Titre affiché
    ->modelName('users')               // Nom du modèle (pour les IDs)
    ->showExport(true)                 // Afficher le bouton d'export
    ->publicUrl('/admin/users')        // URL de base pour les liens
    ->themeMode('dark')                // 'light' ou 'dark'
    ->emptyStateMessage("Aucune donnée");
```

### Colonnes

Options disponibles pour chaque colonne :

```php
[
    'key' => 'email',                  // Clé dans le tableau de données
    'label' => 'Adresse email',        // Libellé affiché
    'sortable' => true,                // Autoriser le tri
    'searchable' => true,              // Inclure dans la recherche
    'visible' => true,                 // Visibilité
    'width' => '200px',                // Largeur fixe
    'format' => 'date',                // 'date', 'boolean', 'status'
    'dateFormat' => 'd/m/Y H:i',       // Si format=date
    'class' => 'text-center'           // Classes CSS
]
```

### Exemple complet

```php
$table->setColumns([
    [
        'key' => 'created_at',
        'label' => 'Date création',
        'format' => 'date',
        'dateFormat' => 'd/m/Y'
    ],
    [
        'key' => 'is_active',
        'label' => 'Actif',
        'format' => 'boolean',
        'icons' => [
            'true' => '<i class="fas fa-check"></i>',
            'false' => '<i class="fas fa-times"></i>'
        ]
    ]
]);
```

---

## 🇬🇧 English

### Main Options

```php
DataTable::make()
    ->title('Table Title')             // Displayed title
    ->modelName('users')               // Model name (for IDs)
    ->showExport(true)                 // Show export button
    ->publicUrl('/admin/users')        // Base URL for links
    ->themeMode('dark')                // 'light' or 'dark'
    ->emptyStateMessage("No data available");
```

### Columns

Available options for each column:

```php
[
    'key' => 'email',                  // Key in the data array
    'label' => 'Email Address',        // Displayed label
    'sortable' => true,                // Allow sorting
    'searchable' => true,              // Include in search
    'visible' => true,                 // Visibility
    'width' => '200px',                // Fixed width
    'format' => 'date',                // 'date', 'boolean', 'status'
    'dateFormat' => 'Y-m-d H:i',       // If format=date
    'class' => 'text-center'           // CSS classes
]
```

### Full Example

```php
$table->setColumns([
    [
        'key' => 'created_at',
        'label' => 'Creation Date',
        'format' => 'date',
        'dateFormat' => 'Y-m-d'
    ],
    [
        'key' => 'is_active',
        'label' => 'Active',
        'format' => 'boolean',
        'icons' => [
            'true' => '<i class="fas fa-check"></i>',
            'false' => '<i class="fas fa-times"></i>'
        ]
    ]
]);
```

---


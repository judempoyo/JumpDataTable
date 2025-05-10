# Installation / Installation

---

## 🌐 Table of Contents / Table des matières

- [Installation / Installation](#installation--installation)
  - [🌐 Table of Contents / Table des matières](#-table-of-contents--table-des-matières)
  - [🇫🇷 Français](#-français)
    - [Prérequis](#prérequis)
    - [Installation via Composer](#installation-via-composer)
    - [Intégration dans votre projet](#intégration-dans-votre-projet)
      - [Avec un framework MVC](#avec-un-framework-mvc)
      - [En standalone](#en-standalone)
    - [Assets nécessaires](#assets-nécessaires)
  - [🇬🇧 English](#-english)
    - [Requirements](#requirements)
    - [Installation via Composer](#installation-via-composer-1)
    - [Integration in Your Project](#integration-in-your-project)
      - [With an MVC Framework](#with-an-mvc-framework)
      - [Standalone](#standalone)
    - [Required Assets](#required-assets)

---

## 🇫🇷 Français

### Prérequis

- PHP 8.0 ou supérieur
- Composer

### Installation via Composer

```bash
composer require jump/jump-datatable
```

### Intégration dans votre projet

#### Avec un framework MVC

```php
// Dans votre contrôleur
public function index()
{
    $table = DataTable::make()
        ->data(User::all())
        ->setColumns([
            ['key' => 'id', 'label' => 'ID'],
            ['key' => 'name', 'label' => 'Nom']
        ]);
    
    return view('users.index', ['table' => $table]);
}

// Dans votre vue
<?php echo $table->render(); ?>
```

#### En standalone

```php
require 'vendor/autoload.php';

$data = [
    ['id' => 1, 'name' => 'Alice'],
    ['id' => 2, 'name' => 'Bob']
];

$table = new Jump\JumpDataTable\DataTable();
echo $table->data($data)->render();
```

### Assets nécessaires

Selon le thème choisi, incluez les CSS correspondantes :

```html
<!-- Pour Tailwind -->
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@4/dist/tailwind.min.css" rel="stylesheet">

<!-- Pour Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
```

---

## 🇬🇧 English

### Requirements

- PHP 8.0 or higher
- Composer

### Installation via Composer

```bash
composer require jump/jump-datatable
```

### Integration in Your Project

#### With an MVC Framework

```php
// In your controller
public function index()
{
    $table = DataTable::make()
        ->data(User::all())
        ->setColumns([
            ['key' => 'id', 'label' => 'ID'],
            ['key' => 'name', 'label' => 'Name']
        ]);
    
    return view('users.index', ['table' => $table]);
}

// In your view
<?php echo $table->render(); ?>
```

#### Standalone

```php
require 'vendor/autoload.php';

$data = [
    ['id' => 1, 'name' => 'Alice'],
    ['id' => 2, 'name' => 'Bob']
];

$table = new Jump\JumpDataTable\DataTable();
echo $table->data($data)->render();
```

### Required Assets

Depending on the chosen theme, include the corresponding CSS:

```html
<!-- For Tailwind -->
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@4/dist/tailwind.min.css" rel="stylesheet">

<!-- For Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
```
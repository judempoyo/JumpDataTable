# JumpDataTable

[![Latest Version](https://img.shields.io/packagist/v/jump/jump-datatable.svg?style=flat-square)](https://packagist.org/packages/jump/jump-datatable)
[![License](https://img.shields.io/packagist/l/jump/jump-datatable.svg?style=flat-square)](LICENSE.md)

Un package PHP moderne pour générer des tableaux de données interactifs avec filtres, tris, pagination et actions personnalisables.

A modern PHP package to generate interactive data tables with filters, sorting, pagination, and customizable actions.

---

## 🌐 Table of Contents / Table des matières

- [JumpDataTable](#jumpdatatable)
  - [🌐 Table of Contents / Table des matières](#-table-of-contents--table-des-matières)
  - [🇫🇷 Français](#-français)
    - [Fonctionnalités clés](#fonctionnalités-clés)
    - [Installation](#installation)
    - [Utilisation rapide](#utilisation-rapide)
    - [Documentation complète](#documentation-complète)
    - [Contribuer](#contribuer)
    - [À venir](#à-venir)
  - [🇬🇧 English](#-english)
    - [Key Features](#key-features)
    - [Installation](#installation-1)
    - [Quick Usage](#quick-usage)
    - [Full Documentation](#full-documentation)
    - [Contributing](#contributing)
    - [Coming Soon](#coming-soon)
  - [🤝 Contributeurs / Contributors](#-contributeurs--contributors)
  - [📜 License](#-license)

---

## 🇫🇷 Français

### Fonctionnalités clés

- 🎨 Multi-thèmes (Tailwind, Bootstrap)
- 🔍 Filtrage intégré
- ↕️ Tri des colonnes
- 📊 Pagination automatique
- 🛠 Actions personnalisables
- 🌙 Mode sombre
- 📤 Export des données
- ⚡ Actions groupées

### Installation

```bash
composer require jump/jump-datatable
```

### Utilisation rapide

```php
use Jump\JumpDataTable\DataTable;

$table = DataTable::make()
        ->title('Liste des utilisateurs')
        ->data($users)
        ->setColumns([
                ['key' => 'id', 'label' => 'ID', 'sortable' => true],
                ['key' => 'name', 'label' => 'Nom'],
                ['key' => 'email', 'label' => 'Email']
        ]);

echo $table->render();
```

### Documentation complète

Consultez la documentation complète pour des instructions détaillées :

1. [Installation détaillée](docs/installation.md)  
   Instructions détaillées pour installer et configurer JumpDataTable dans votre projet.

2. [Configuration avancée](docs/configuration.md)  
   Découvrez toutes les options de configuration disponibles pour personnaliser vos tableaux.

3. [Exemples pratiques](docs/examples.md)  
   Des exemples concrets pour intégrer JumpDataTable dans différents scénarios.

4. [Personnalisation avancée](docs/advanced.md)  
   Apprenez à créer des thèmes personnalisés, des hooks, et à optimiser vos tableaux.

### Contribuer

Les contributions sont les bienvenues ! Consultez le fichier `CONTRIBUTING.md` pour les instructions.

### À venir

- Pagination AJAX
- Support Livewire / Vue.js
- Extension Laravel Facade
- Intégration des directives Blade

---

## 🇬🇧 English

### Key Features

- 🎨 Multi-themes (Tailwind, Bootstrap)
- 🔍 Built-in filtering
- ↕️ Column sorting
- 📊 Automatic pagination
- 🛠 Customizable actions
- 🌙 Dark mode
- 📤 Data export
- ⚡ Bulk actions

### Installation

```bash
composer require jump/jump-datatable
```

### Quick Usage

```php
use Jump\JumpDataTable\DataTable;

$table = DataTable::make()
        ->title('User List')
        ->data($users)
        ->setColumns([
                ['key' => 'id', 'label' => 'ID', 'sortable' => true],
                ['key' => 'name', 'label' => 'Name'],
                ['key' => 'email', 'label' => 'Email'],
                ['key' => 'created_at', 'label' => 'Created At', 'sortable' => true],
                ['key' => 'updated_at', 'label' => 'Updated At', 'sortable' => true]
        ]);

echo $table->render();
```

### Full Documentation

Check the full documentation for detailed instructions:

1. [Detailed Installation](docs/installation.md)  
   Step-by-step instructions to install and configure JumpDataTable in your project.

2. [Advanced Configuration](docs/configuration.md)  
   Explore all configuration options to customize your tables.

3. [Practical Examples](docs/examples.md)  
   Real-world examples to integrate JumpDataTable in various scenarios.

4. [Advanced Customization](docs/advanced.md)  
   Learn how to create custom themes, hooks, and optimize your tables.

### Contributing

Contributions are welcome! See the `CONTRIBUTING.md` file for guidelines.

### Coming Soon

- AJAX Pagination
- Livewire / Vue.js support
- Laravel Facade extension
- Blade directives integration

---

## 🤝 Contributeurs / Contributors

Créé avec ❤️ par Jude Mpoyo  
Created with ❤️ by Jude Mpoyo

---

## 📜 License

MIT - See `LICENSE.md`

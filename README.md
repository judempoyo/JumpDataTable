# JumpDataTable

---

## English

# JumpDataTable

JumpDataTable is a clean and powerful PHP package for generating interactive data tables with theming support (Tailwind & Bootstrap), advanced filters, bulk and row actions, sorting, custom rendering, and more.

---

### 📦 Installation

Install the package via Composer:

```bash
composer require jump/jumpdatatable
```

---

### 🚀 Key Features

- 🎨 **Multi-theme support**: Tailwind & Bootstrap
- 🔎 **Advanced filters**: text, dropdowns, date ranges
- 🔁 **Row actions**: view, edit, delete with confirmation
- 🧩 **Custom cell rendering**
- ✅ **Row selection** & bulk actions (export, delete, etc.)
- 📤 **Built-in export** (CSV, Excel, etc.)
- 🌓 **Light / Dark mode support**

---

### 📄 Full Usage Example

```php
use Jump\JumpDataTable\DataTable;

$table = DataTable::make()
    ->title('Users')
    ->columns($columns)
    ->data($data)
    ->actions($actions)
    ->filters($filters)
    ->bulkActions($bulkActions)
    ->enableRowSelection(true)
    ->createUrl('/users/create')
    ->publicUrl('/users')
    ->modelName('users')
    ->showExport(true)
    ->setThemeMode('dark')
    ->useTheme('tailwind');

echo $table->render();
```

---

### 📜 License

This project is licensed under the MIT License.

---

### 🤝 Contributors

Made with ❤️ by [Jude Mpoyo](mailto:mpoyojude@gmail.com)

---

### ✨ Coming Soon

- AJAX Pagination
- Livewire / Vue.js support
- Laravel Facade Extension
- Blade Directive Integration

---

## Français

---

# JumpDataTable 

JumpDataTable est un package PHP élégant et puissant pour générer des tables de données interactives avec support de thèmes (Tailwind & Bootstrap), filtres avancés, actions individuelles et groupées, tri, rendus personnalisés, et plus encore.

---

### 📦 Installation

Installez le package via Composer :

```bash
composer require jump/jumpdatatable
```

---

### 🚀 Fonctionnalités clés

- 🎨 **Support de plusieurs thèmes** : Tailwind & Bootstrap
- 🔎 **Filtres avancés** : texte, listes déroulantes, plages de dates
- 🔁 **Actions par ligne** : voir, modifier, supprimer avec confirmation
- 🧩 **Rendu personnalisé pour chaque cellule**
- ✅ **Sélection de lignes** & actions groupées (export, suppression, etc.)
- 📤 **Export intégré** (CSV, Excel, etc.)
- 🌓 **Support du mode clair / sombre**

---

### 📄 Exemple complet d'utilisation

```php
use Jump\JumpDataTable\DataTable;

$table = DataTable::make()
    ->title('Utilisateurs')
    ->columns($columns)
    ->data($data)
    ->actions($actions)
    ->filters($filters)
    ->bulkActions($bulkActions)
    ->enableRowSelection(true)
    ->createUrl('/users/create')
    ->publicUrl('/users')
    ->modelName('users')
    ->showExport(true)
    ->setThemeMode('dark')
    ->useTheme('tailwind');

echo $table->render();
```

---

### 📜 Licence

Ce projet est sous licence MIT.

---

### 🤝 Contributeurs

Créé avec ❤️ par [Jude Mpoyo](mailto:mpoyojude@gmail.com)

---

### ✨ À venir

- Pagination AJAX
- Support Livewire / Vue.js
- Extension Laravel Facade
- Intégration des directives Blade
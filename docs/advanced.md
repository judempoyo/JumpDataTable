# Personnalisation avancée / Advanced Customization

---

## 🌐 Table of Contents / Table des matières

- [Personnalisation avancée / Advanced Customization](#personnalisation-avancée--advanced-customization)
  - [🌐 Table of Contents / Table des matières](#-table-of-contents--table-des-matières)
  - [🇫🇷 Français](#-français)
    - [Créer un thème personnalisé](#créer-un-thème-personnalisé)
    - [Personnaliser le rendu des cellules](#personnaliser-le-rendu-des-cellules)
    - [Hooks personnalisés](#hooks-personnalisés)
    - [Intégration avec Livewire](#intégration-avec-livewire)
    - [Optimisation des performances](#optimisation-des-performances)
  - [🇬🇧 English](#-english)
    - [Create a Custom Theme](#create-a-custom-theme)
    - [Customize Cell Rendering](#customize-cell-rendering)
    - [Custom Hooks](#custom-hooks)
    - [Integration with Livewire](#integration-with-livewire)
    - [Performance Optimization](#performance-optimization)
    - [Notes](#notes)

---

## 🇫🇷 Français

### Créer un thème personnalisé

1. Créez une classe dans `App\DataTable\Themes\CustomTheme` :

```php
namespace App\DataTable\Themes;

class CustomTheme implements ThemeInterface
{
    public static function getContainerClasses(bool $darkMode): string
    {
        return $darkMode ? 'bg-gray-900' : 'bg-white';
    }
    
    // Implémentez toutes les méthodes nécessaires...
}
```

2. Enregistrez le thème :

```php
$table->useTheme('custom', [
    'containerClass' => 'my-custom-class'
]);
```

### Personnaliser le rendu des cellules

```php
$table->setColumns([
    [
        'key' => 'avatar',
        'label' => 'Photo',
        'render' => fn($item) => "<img src='{$item['avatar']}' class='w-10 h-10 rounded-full'>"
    ]
]);
```

### Hooks personnalisés

```php
// Avant le rendu
$table->beforeRender(function($config) {
    $config['customData'] = auth()->user()->preferences;
    return $config;
});

// Après le rendu
$table->afterRender(function($html) {
    return str_replace('{year}', date('Y'), $html);
});
```

### Intégration avec Livewire

```php
class UsersTable extends Component
{
    public function render()
    {
        return view('livewire.users-table', [
            'table' => DataTable::make()
                ->data(User::all())
                ->setColumns([...])
        ]);
    }
}
```

### Optimisation des performances

Pour les grandes datasets :

```php
$table->setConfig([
    'deferLoading' => true,
    'serverSide' => true,
    'ajaxUrl' => '/api/users/datatable'
]);
```

---

## 🇬🇧 English

### Create a Custom Theme

1. Create a class in `App\DataTable\Themes\CustomTheme`:

```php
namespace App\DataTable\Themes;

class CustomTheme implements ThemeInterface
{
    public static function getContainerClasses(bool $darkMode): string
    {
        return $darkMode ? 'bg-gray-900' : 'bg-white';
    }
    
    // Implement all required methods...
}
```

2. Register the theme:

```php
$table->useTheme('custom', [
    'containerClass' => 'my-custom-class'
]);
```

### Customize Cell Rendering

```php
$table->setColumns([
    [
        'key' => 'avatar',
        'label' => 'Photo',
        'render' => fn($item) => "<img src='{$item['avatar']}' class='w-10 h-10 rounded-full'>"
    ]
]);
```

### Custom Hooks

```php
// Before rendering
$table->beforeRender(function($config) {
    $config['customData'] = auth()->user()->preferences;
    return $config;
});

// After rendering
$table->afterRender(function($html) {
    return str_replace('{year}', date('Y'), $html);
});
```

### Integration with Livewire

```php
class UsersTable extends Component
{
    public function render()
    {
        return view('livewire.users-table', [
            'table' => DataTable::make()
                ->data(User::all())
                ->setColumns([...])
        ]);
    }
}
```

### Performance Optimization

For large datasets:

```php
$table->setConfig([
    'deferLoading' => true,
    'serverSide' => true,
    'ajaxUrl' => '/api/users/datatable'
]);
```

---

### Notes

- Les sections sont identiques dans les deux langues pour garantir une expérience utilisateur cohérente.
- Sections are identical in both languages to ensure a consistent user experience.
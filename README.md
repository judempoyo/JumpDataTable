# Jump DataTable

Jump DataTable is a lightweight and flexible PHP library for creating dynamic and customizable data tables in web applications. It provides an easy way to manage, render, and manipulate tabular data with features such as sorting, filtering, pagination, and theming.

## Features

- **Dynamic Columns**: Easily define and configure table columns.
- **Customizable Themes**: Support for Tailwind and Bootstrap themes with light and dark modes.
- **Sorting and Filtering**: Built-in support for sorting and filtering data.
- **Pagination**: Manage large datasets with pagination.
- **Custom Actions**: Add custom actions like view, edit, and delete.
- **Flexible Rendering**: Render tables using customizable templates.
- **Lightweight**: Minimal dependencies and easy to integrate into any PHP project.

---

## Project Structure

The project is organized as follows:

```
jump-datatable
├── src
│   ├── DataTable.php          # Main class for managing data table functionality
│   ├── DataTableRenderer.php  # Class responsible for rendering the data table in HTML
│   ├── Column.php             # Class defining the structure of a column in the data table
│   ├── Action.php             # Class representing actions like sorting and filtering
│   ├── Filter.php             # Class managing filtering options for the data table
│   └── Resources
│       ├── views
│       │   └── table.php      # HTML template for displaying the data table
│       └── assets             # Directory for JavaScript and CSS files
├── tests                      # Directory for unit tests
├── composer.json              # Composer configuration file
└── README.md                  # Project documentation
```

## Installation

To install the library, use Composer:

```bash
composer require jump/jump-data-table
```

## Usage

Here’s an example of how to use Jump DataTable in your PHP application:

1. Initialize the DataTable


```php
require 'vendor/autoload.php';

use Jump\JumpDataTable;

// Initialize the DataTable
$dataTable = new DataTable();

```
2. Configure Columns
Define the columns for your table:
```php
$columns = [
    ['key' => 'id', 'label' => 'ID', 'sortable' => true],
    ['key' => 'name', 'label' => 'Name', 'sortable' => true],
    ['key' => 'email', 'label' => 'Email'],
    [
        'key' => 'status',
        'label' => 'Status',
        'render' => function ($item) {
            $color = [
                'active' => 'bg-green-100 text-green-800',
                'inactive' => 'bg-yellow-100 text-yellow-800',
                'pending' => 'bg-blue-100 text-blue-800',
            ][$item['status']] ?? 'bg-gray-100 text-gray-800';

            return '<span class="px-2 py-1 text-xs font-medium rounded-full ' . $color . '">' 
                 . ucfirst($item['status']) . '</span>';
        }
    ]
];
```
3. Add Data
Provide the data to display in the table:
```php
$data = [
    ['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com', 'status' => 'active'],
    ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane@example.com', 'status' => 'inactive'],
    ['id' => 3, 'name' => 'Alice Johnson', 'email' => 'alice@example.com', 'status' => 'pending'],
];
```
4. Configure Actions
Define actions like view, edit, and delete:
```php
$actions = [
    [
        'label' => 'Edit',
        'url' => fn($item) => "/edit/{$item['id']}",
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>'
    ],
    [
        'label' => 'Delete',
        'url' => fn($item) => "/delete/{$item['id']}",
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>'
    ]
];
```
5. Render the Table
Render the table using a renderer:
```php
use Jump\JumpDataTable\DataTableRenderer;

$renderer = new DataTableRenderer('tailwind'); // Use 'bootstrap' for Bootstrap theme
echo $renderer->render([
    'title' => 'User List',
    'columns' => $columns,
    'data' => $data,
    'actions' => $actions,
    'createUrl' => '/create',
    'publicUrl' => '/',
    'modelName' => 'users',
    'showExport' => true,
    'filters' => [
        ['name' => 'search', 'label' => 'Search', 'placeholder' => 'Search...']
    ],
    'theme' => 'light' // 'light' or 'dark'
]);
```
Here is a detailed README.md file for your project based on the provided context:

```

## Installation

To install the library, use Composer:

```bash
composer require jump/jump-data-table
```

---

## Usage

Here’s an example of how to use Jump DataTable in your PHP application:

### 1. Initialize the DataTable

```php
require 'vendor/autoload.php';

use Jump\JumpDataTable\DataTable;

// Initialize the DataTable
$dataTable = new DataTable();
```

### 2. Configure Columns

Define the columns for your table:

```php
$columns = [
    ['key' => 'id', 'label' => 'ID', 'sortable' => true],
    ['key' => 'name', 'label' => 'Name', 'sortable' => true],
    ['key' => 'email', 'label' => 'Email'],
    [
        'key' => 'status',
        'label' => 'Status',
        'render' => function ($item) {
            $color = [
                'active' => 'bg-green-100 text-green-800',
                'inactive' => 'bg-yellow-100 text-yellow-800',
                'pending' => 'bg-blue-100 text-blue-800',
            ][$item['status']] ?? 'bg-gray-100 text-gray-800';

            return '<span class="px-2 py-1 text-xs font-medium rounded-full ' . $color . '">' 
                 . ucfirst($item['status']) . '</span>';
        }
    ]
];
```

### 3. Add Data

Provide the data to display in the table:

```php
$data = [
    ['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com', 'status' => 'active'],
    ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane@example.com', 'status' => 'inactive'],
    ['id' => 3, 'name' => 'Alice Johnson', 'email' => 'alice@example.com', 'status' => 'pending'],
];
```

### 4. Configure Actions

Define actions like view, edit, and delete:

```php
$actions = [
    [
        'label' => 'Edit',
        'url' => fn($item) => "/edit/{$item['id']}",
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>'
    ],
    [
        'label' => 'Delete',
        'url' => fn($item) => "/delete/{$item['id']}",
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>'
    ]
];
```

### 5. Render the Table

Render the table using a renderer:

```php
use Jump\JumpDataTable\DataTableRenderer;

$renderer = new DataTableRenderer('tailwind'); // Use 'bootstrap' for Bootstrap theme
echo $renderer->render([
    'title' => 'User List',
    'columns' => $columns,
    'data' => $data,
    'actions' => $actions,
    'createUrl' => '/create',
    'publicUrl' => '/',
    'modelName' => 'users',
    'showExport' => true,
    'filters' => [
        ['name' => 'search', 'label' => 'Search', 'placeholder' => 'Search...']
    ],
    'theme' => 'light' // 'light' or 'dark'
]);
```

---

## Theming

Jump DataTable supports multiple themes. You can switch between themes and customize their configurations.

### Available Themes

- **Tailwind**: A modern CSS framework.
- **Bootstrap**: A popular CSS framework.

### Customizing Themes

You can override theme configurations using the `useTheme` method:

```php
$dataTable->useTheme('tailwind', [
    'rounded' => 'md',
    'shadow' => 'lg',
    'colors' => [
        'primary' => '#4caf50',
        'secondary' => '#ff9800',
    ]
]);
```

---

## Testing

Run the unit tests using PHPUnit:

```bash
vendor/bin/phpunit
```

---

## Contributing

Contributions are welcome! If you have suggestions for improvements or new features, please open an issue or submit a pull request.

---

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for more details.
```

# PHP DataTable

PHP DataTable is a lightweight and flexible library for creating dynamic data tables in PHP applications. It provides an easy way to manage, render, and manipulate tabular data with features such as sorting, filtering, and pagination.

## Project Structure

The project is organized as follows:

```
php-datatable
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

To install the project, you can use Composer. Run the following command in your terminal:

```
composer install
```

## Usage

To use the PHP DataTable library, include the necessary classes in your PHP script. Here’s a simple example:

```php
require 'vendor/autoload.php';

use Jump\JumpDataTable;

// Initialize the DataTable
$dataTable = new DataTable();

// Add columns, actions, and filters as needed
```

## Contributing

Contributions are welcome! If you have suggestions for improvements or new features, please open an issue or submit a pull request.

## License

This project is licensed under the MIT License. See the LICENSE file for more details.
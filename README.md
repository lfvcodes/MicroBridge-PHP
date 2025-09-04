<h1 align="center">
  <a href="https://skillicons.dev"><img src="https://skillicons.dev/icons?i=php&perline=15" /></a>
  MicroBridge-PHP <br> PHP's lightweight microservices/API communicator
</h1>

<div align="center">
  MicroBridge-PHP is a lightweight (less than 500 lines of code) PHP 7.1+ tool for issuing internal API requests without network overhead.
</div>

<div align="center">
  <a href="https://packagist.org/packages/lfvcodes/microbridge-php">
    <img src="https://img.shields.io/packagist/v/lfvcodes/microbridge-php?style=flat-square" alt="Packagist Version" />
  </a>
  <a href="https://packagist.org/packages/lfvcodes/microbridge-php">
    <img src="https://img.shields.io/packagist/dt/lfvcodes/microbridge-php?style=flat-square" alt="Total Downloads" />
  </a>
  <a href="https://github.com/lfvcodes/microbridge-php/blob/main/LICENSE">
    <img src="https://img.shields.io/github/license/lfvcodes/microbridge-php?style=flat-square" alt="License" />
  </a>
</div>

## Features

- **Lightweight**: Less than 500 lines of code
- **Zero Dependencies**: No external dependencies required
- **PHP 7.1+ Compatible**: Works with modern PHP versions
- **Multiple HTTP Methods**: Supports GET, POST, PUT, PATCH, DELETE
- **State Management**: Preserves and restores PHP superglobals
- **Error Handling**: Comprehensive error handling and validation
- **Stream Simulation**: Mock php://input stream for request body handling

## Requirements

- PHP 7.1 or higher
- Composer (recommended) or manual installation

## Installation

### Using Composer (Recommended)

Install by running:

```bash
composer require lfvcodes/microbridge-php
```

### Manual Installation

If you're not using Composer, you can manually integrate MicroBridge into your project by following these steps:

#### 1. Copy the Files

Download or clone the repository and copy the `src/` folder into your project:

```
your-project/
├── src/
│   ├── MicroBridge.php
│   ├── RequestContext.php
│   └── MockPhpStream.php
└── your-code.php
```

#### 2. Manually Include the Classes

In your main file (`index.php` or similar), include the class file and use the namespace:

```php
<?php
require_once 'src/MicroBridge.php';
require_once 'src/RequestContext.php';
require_once 'src/MockPhpStream.php';

use MicroBridge\MicroBridge;

// Your code here...
?>
```
## Usage

### Basic POST Request

```php
<?php
require 'vendor/autoload.php';
use MicroBridge\MicroBridge;

try {
    // Create client with POST method
    $client = new MicroBridge('POST');
    
    // Make request with data payload
    $response = $client->request('./api/users.php', [
        'name' => 'John Doe',
        'email' => 'john@example.com'
    ]);
    
    print_r($response);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
```

### GET Request with URL Parameters

```php
<?php
require 'vendor/autoload.php';
use MicroBridge\MicroBridge;

try {
    $client = new MicroBridge('GET');
    
    // Method 1: URL with query string
    $response = $client->request('./api/users.php?id=4');
    
    // Method 2: Separate parameters
    $response = $client->request('./api/users.php', ['id' => 4]);
    
    print_r($response);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
```

### Advanced Usage with Headers

```php
<?php
require 'vendor/autoload.php';
use MicroBridge\MicroBridge;

try {
    $client = new MicroBridge('PUT');
    
    $response = $client->request('./api/users.php', 
        ['id' => 1, 'name' => 'Updated Name'],
        ['Authorization' => 'Bearer token123']
    );
    
    print_r($response);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
```

## Running Examples

The `examples/` directory contains working demonstrations of MicroBridge functionality. These examples are fully runnable and show real-world usage patterns.

### Available Examples

- **`basic-usage.php`** - Demonstrates fundamental GET, POST, PUT requests
- **`chained-requests.php`** - Shows how to chain multiple API calls together
- **`error-handling.php`** - Illustrates comprehensive error handling scenarios

### Running Examples via Command Line

Navigate to the project root directory and run any example:

```bash
# Run basic usage examples
php examples/basic-usage.php

# Run chained requests demonstration
php examples/chained-requests.php

# Run error handling examples
php examples/error-handling.php
```

### Running Examples via Web Server

If you have a local web server (Apache, Nginx, or PHP's built-in server) configured to serve PHP files:

```bash
# Start PHP's built-in development server
php -S localhost:8000

# Then visit in your browser:
# http://localhost:8000/examples/basic-usage.php
# http://localhost:8000/examples/chained-requests.php
# http://localhost:8000/examples/error-handling.php
```

### Example Output

When running `basic-usage.php`, you should see clean HTML output demonstrating:
- Successful GET requests with chained API calls
- POST request handling with JSON payloads
- PUT requests with custom headers
- Proper error handling for invalid methods

All examples include the working API endpoints (`api/api1.php` and `api/api2.php`) that demonstrate real internal API communication without network overhead.

## API Methods

| Method | Description | Use Case |
|--------|-------------|----------|
| `GET` | Retrieve data | Fetching resources |
| `POST` | Create new resource | Creating new records |
| `PUT` | Update entire resource | Full resource updates |
| `PATCH` | Partial update | Updating specific fields |
| `DELETE` | Remove resource | Deleting records |

## Development

### Running Tests

```bash
composer test
```

### Code Style Checking

```bash
# Check code style
composer cs-check

# Fix code style issues
composer cs-fix
```

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Acknowledgments

- Built for modern PHP microservice architectures
- Inspired by the need for lightweight internal API communication
- Designed with simplicity and performance in mind

<h1 align="center">
  <a href="https://skillicons.dev"><img src="https://skillicons.dev/icons?i=php&perline=15" /></a>
  MicroBridge-PHP <br> PHP's lightweight microservices/API communicator
</h1>

<div align="center">
  MicroBridge-PHP is a lightweight (less than 1000 lines of code) PHP 7.1 tool for issuing intern-API requests.
</div>
<div align="center">
 <a href="https://packagist.org/packages/lfvcodes/microbridge-php">
 <img src="https://img.shields.io/packagist/v/lfvcodes/microbridge-php?style=flat-square" />
 </a>
</div>


## Installation

Install by running:

```bash
composer require lfvcodes/MicroBridge-PHP
```

## 📦 Using Without Composer

If you're not using Composer, you can manually integrate MicroBridge into your project by following these steps:

### 1. 📁 Copy the Files

Download or clone the repository and copy the `src/` folder into your project:

---

### 2. 📄 Manually Include the Class

In your main file (`index.php` or similar), include the class file and use the namespace:


## Usage

Using methods with params:

```php
<?php
  use MicroBridge\MicroBridge;
  $client = new MicroBridge($method = 'POST'); //Can use POST/GET/PUT/PATCH/DELETE
  $response = $client->request($urlOrPath,$arrayParams);
  print_r($response);
?>
```

Using URL Params with GET:
```php
<?php
  use MicroBridge\MicroBridge;
  $client = new MicroBridge($method = 'GET');
  $response = $client->request('../api/index.php?id=4');
  print_r($response);
?>
```


# CommonPHP Driver Management Library

The CommonPHP Driver Management Library provides a robust framework for managing driver implementations in PHP applications. By leveraging attributes and contracts, it offers a flexible system to register, enable, and utilize various drivers seamlessly within your projects.

## Features

- **Flexible Driver Configuration**: Configure drivers using PHP 8 Attributes or by specifying driver contracts.
- **Dynamic Driver Support Checking**: Determine if a class is supported as a driver based on its configuration.
- **Driver Instantiation**: On-demand driver instantiation managed by the CommonPHP Service Management framework, ensuring dependency injection and singleton management.
- **Comprehensive Exception Handling**: Detailed exception handling for configuration errors, unsupported drivers, and instantiation issues.

## Installation

Use Composer to integrate the Driver Management Library into your project:

```bash
composer require comphp/drivers
```

## Configuration

### Define Driver Contracts or Attributes

Implement `DriverContract` for interface/abstract class-based drivers or use `DriverAttributeContract` to mark drivers with attributes.

### Register and Configure DriverManager

```php
use CommonPHP\Drivers\DriverManager;
use CommonPHP\Drivers\ServiceProviders\DriverManagerServiceProvider;
use CommonPHP\ServiceManagement\ServiceManager;

// Initialize ServiceManager and register DriverManagerServiceProvider
$serviceManager = new ServiceManager();
$serviceManager->providers->registerProvider(DriverManagerServiceProvider::class);

// Retrieve an instance of DriverManager
$driverManager = $serviceManager->get(DriverManager::class);

// Configure DriverManager with an attribute or contract class
$driverManager->configure(
    attributeClass: YourDriverAttribute::class,
    contractClass: YourDriverContract::class
);
```

## Usage

### Enable a Driver

Once a driver meets the configured criteria (attribute or contract), enable it using:

```php
$driverManager->enable(YourDriverClass::class);
```

### Utilize an Enabled Driver

Retrieve and use an enabled driver:

```php
$driver = $driverManager->get(YourDriverClass::class);
$driver->performAction();
```

## Contributing

Contributions to the CommonPHP Driver Management Library are welcome. Please follow the contribution guidelines provided in the repository for submitting pull requests or issues.

## License

This library is released under the MIT license. See [LICENSE](LICENSE) for details.

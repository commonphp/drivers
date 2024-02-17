<?php

// Required namespaces for Driver Management and Service Management components.
use CommonPHP\Drivers\Contracts\DriverAttributeContract;
use CommonPHP\Drivers\Contracts\DriverContract;
use CommonPHP\Drivers\DriverManager;
use CommonPHP\ServiceManagement\ServiceManager;
use CommonPHP\Drivers\ServiceProviders\DriverManagerServiceProvider;

// Include Composer's autoloader to handle class loading.
require_once '../vendor/autoload.php';

// Define a custom attribute for drivers, implementing the DriverAttributeContract.
#[Attribute(Attribute::TARGET_CLASS)]
class GeneralExampleDriverAttribute implements DriverAttributeContract
{
    // This class is empty but serves as a marker for driver classes using attributes.
}

// Define a contract that drivers can implement, extending the base DriverContract.
interface GeneralExampleDriverContract extends DriverContract
{
    // Interface body remains empty for this example, acting as a marker.
}

// Abstract class that implements the DriverContract, can be extended by concrete driver classes.
abstract class AbstractGeneralExampleDriver implements DriverContract
{
    // Abstract class body is empty, serving as a base for specific drivers.
}

// Factory class configured to use the DriverManager with an attribute-based configuration.
class AttributeDemoFactory
{
    public function __construct(DriverManager $driverManager)
    {
        // Configures the DriverManager to recognize drivers by the specified attribute.
        $driverManager->configure(GeneralExampleDriverAttribute::class, null);
    }
}

// Factory class configured to use the DriverManager with a contract-based configuration.
class ContractDemoFactory
{
    public function __construct(DriverManager $driverManager)
    {
        // Configures the DriverManager to recognize drivers implementing the specified contract.
        $driverManager->configure(null, GeneralExampleDriverContract::class);
    }
}

// Factory class configured to use both attribute and contract-based configurations.
class AttributeContractDemoFactory
{
    public function __construct(DriverManager $driverManager)
    {
        // Configures the DriverManager to recognize drivers both by attribute and by implementing a contract.
        $driverManager->configure(GeneralExampleDriverAttribute::class, AbstractGeneralExampleDriver::class);
    }
}

// Instantiate the ServiceManager and register the DriverManagerServiceProvider for dependency management.
$serviceManager = new ServiceManager();
$serviceManager->providers->registerProvider(DriverManagerServiceProvider::class);

// Instantiate each factory class, triggering their respective configuration logic in the DriverManager.
// These demonstrate different ways to utilize the DriverManager for managing drivers.
$serviceManager->di->instantiate(AttributeDemoFactory::class, []);
$serviceManager->di->instantiate(ContractDemoFactory::class, []);
$serviceManager->di->instantiate(AttributeContractDemoFactory::class, []);

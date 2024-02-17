<?php

/**
 * DriverManager.php
 *
 * The DriverManager class is part of the CommonPHP library, offering a comprehensive solution
 * for managing driver classes within PHP applications. It facilitates dynamic driver registration,
 * configuration, and utilization based on custom attributes or contracts. This class leverages
 * the ServiceManager for dependency injection, ensuring that driver instances are properly managed
 * and instantiated as needed.
 *
 * Through the use of PHP 8 Attributes and interfaces, DriverManager allows applications to
 * flexibly define and utilize drivers for various purposes, such as connecting to different
 * types of databases, handling file storage, or integrating with third-party services.
 * It supports checking whether classes meet certain criteria to be considered as drivers,
 * enabling them for use within the system, and retrieving instances on-demand.
 *
 * This file includes the definition of the DriverManager class along with necessary exceptions
 * and contracts for implementing the driver management functionality. It is designed to work
 * seamlessly with the CommonPHP Dependency Injection and Service Management components, providing
 * a cohesive and extensible architecture for PHP applications.
 *
 * @package CommonPHP\Drivers
 * @author Timothy McClatchey <timothy@commonphp.org>
 * @copyright 2024 CommonPHP.org
 * @license http://opensource.org/licenses/MIT MIT License
 * @noinspection PhpUnused
 */


namespace CommonPHP\Drivers;

use Attribute;
use CommonPHP\DependencyInjection\Exceptions\ClassNotDefinedException;
use CommonPHP\DependencyInjection\Exceptions\ClassNotInstantiableException;
use CommonPHP\DependencyInjection\Exceptions\InstantiateCircularReferenceException;
use CommonPHP\DependencyInjection\Exceptions\InstantiationFailedException;
use CommonPHP\DependencyInjection\Exceptions\ParameterDiscoveryFailedException;
use CommonPHP\DependencyInjection\Exceptions\ParameterTypeRequiredException;
use CommonPHP\DependencyInjection\Exceptions\UnsupportedReflectionTypeException;
use CommonPHP\Drivers\Contracts\DriverAttributeContract;
use CommonPHP\Drivers\Contracts\DriverContract;
use CommonPHP\Drivers\Exceptions\AlreadyConfiguredException;
use CommonPHP\Drivers\Exceptions\AlreadyEnabledException;
use CommonPHP\Drivers\Exceptions\AttributeClassNotDeclaredException;
use CommonPHP\Drivers\Exceptions\AttributeMissingImplementationException;
use CommonPHP\Drivers\Exceptions\AttributeOrContractRequiredException;
use CommonPHP\Drivers\Exceptions\ClassNotAttributeException;
use CommonPHP\Drivers\Exceptions\ContractClassNotDeclaredException;
use CommonPHP\Drivers\Exceptions\ContractMissingImplementationException;
use CommonPHP\Drivers\Exceptions\ContractNotAbstractOrInterfaceException;
use CommonPHP\Drivers\Exceptions\NotConfiguredException;
use CommonPHP\Drivers\Exceptions\NotEnabledException;
use CommonPHP\Drivers\Exceptions\NotSupportedException;
use CommonPHP\ServiceManagement\Contracts\BootstrapperContract;
use CommonPHP\ServiceManagement\ServiceManager;
use Override;
use ReflectionClass;

/**
 * @template C
 */
final class DriverManager implements BootstrapperContract
{
    /**
     * @var ?string The class name of the attribute used to identify drivers.
     */
    private ?string $attributeClass = null;

    /**
     * @var class-string<C>|null The class name or interface name of the contract used to identify drivers.
     */
    private ?string $contractClass = null;

    /**
     * @var array The registry of enabled drivers, keyed by class name.
     */
    private array $drivers = [];

    /** @var ServiceManager The service manager instance for dependency management. */
    private ServiceManager $serviceManager;

    public function __construct() { }

    /**
     * @inheritDoc
     */
    #[Override] function bootstrap(ServiceManager $serviceManager): void
    {
        $this->serviceManager = $serviceManager;
    }

    /**
     * Checks if the DriverManager has been configured with either an attribute or a contract class.
     *
     * @return bool True if configured, false otherwise.
     */
    public function isConfigured(): bool
    {
        return $this->attributeClass !== null || $this->contractClass !== null;
    }

    /**
     * Configures the DriverManager with an attribute class, a contract class, or both to identify supported drivers.
     *
     * @param ?string $attributeClass The attribute class name to identify drivers.
     * @param ?string $contractClass The contract class name to identify drivers.
     * @throws ContractNotAbstractOrInterfaceException
     * @throws ContractMissingImplementationException
     * @throws AttributeOrContractRequiredException
     * @throws ContractClassNotDeclaredException
     * @throws AttributeMissingImplementationException
     * @throws ClassNotAttributeException
     * @throws AttributeClassNotDeclaredException
     * @throws AlreadyConfiguredException
     */
    public function configure(?string $attributeClass = null, ?string $contractClass = null): void
    {
        if ($this->isConfigured()) throw new AlreadyConfiguredException();
        if ($attributeClass === null && $contractClass === null)
        {
            throw new AttributeOrContractRequiredException();
        }
        if ($attributeClass !== null)
        {
            if (!class_exists($attributeClass))
            {
                throw new AttributeClassNotDeclaredException($attributeClass);
            }
            $attributeReflection = new ReflectionClass($attributeClass);
            if (count($attributeReflection->getAttributes(Attribute::class)) == 0)
            {
                throw new ClassNotAttributeException($attributeClass);
            }
            if (!$attributeReflection->implementsInterface(DriverAttributeContract::class))
            {
                throw new AttributeMissingImplementationException($attributeClass);
            }
        }
        if ($contractClass !== null)
        {
            if (!class_exists($contractClass) && !interface_exists($contractClass))
            {
                throw new ContractClassNotDeclaredException($contractClass);
            }
            $contractReflection = new ReflectionClass($contractClass);
            if (!$contractReflection->isInterface() && !$contractReflection->isAbstract())
            {
                throw new ContractNotAbstractOrInterfaceException($contractClass);
            }
            if (!$contractReflection->implementsInterface(DriverContract::class))
            {
                throw new ContractMissingImplementationException($contractClass);
            }
        }
        $this->attributeClass = $attributeClass;
        $this->contractClass = $contractClass;
    }

    /**
     * Checks if a class is supported as a driver based on the configured attribute or contract.
     *
     * @param string $className The class name to check.
     * @return bool True if the class is supported, false otherwise.
     * @throws NotConfiguredException
     */
    public function supports(string $className): bool
    {
        $this->ensureConfiguration();
        if (!class_exists($className)) return false;
        $reflection = new ReflectionClass($className);
        if ($this->attributeClass !== null) {
            if (count($reflection->getAttributes($this->attributeClass)) > 0) {
                return true;
            }
        }
        if ($this->contractClass !== null) {
            if ($reflection->implementsInterface($this->contractClass)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Enables a class as a driver, making it ready for instantiation.
     *
     * @param string $className The class name of the driver to enable.
     * @throws AlreadyEnabledException
     * @throws NotSupportedException
     * @throws NotConfiguredException
     */
    public function enable(string $className): void
    {
        $this->ensureConfiguration();
        if (!$this->supports($className))
        {
            throw new NotSupportedException($className);
        }
        if ($this->isEnabled($className))
        {
            throw new AlreadyEnabledException($className);
        }
        $this->drivers[$className] = null;
    }

    /**
     * Checks if a class is already enabled as a driver.
     *
     * @param string $className The class name to check.
     * @throws NotConfiguredException
     */
    public function isEnabled(string $className): bool
    {
        $this->ensureConfiguration();
        return isset($this->drivers[$className]);
    }

    /**
     * Retrieves an enabled driver instance, instantiating it if necessary.
     *
     * @template T
     * @param class-string<T> $className
     * @return T|C
     * @throws NotEnabledException
     * @throws ClassNotDefinedException
     * @throws ClassNotInstantiableException
     * @throws InstantiateCircularReferenceException
     * @throws InstantiationFailedException
     * @throws ParameterDiscoveryFailedException
     * @throws ParameterTypeRequiredException
     * @throws UnsupportedReflectionTypeException
     * @throws NotConfiguredException
     */
    public function get(string $className): object
    {
        $this->ensureConfiguration();
        if (!isset($this->drivers[$className]))
        {
            throw new NotEnabledException($className);
        }
        if ($this->drivers[$className] === null)
        {
            $this->drivers[$className] = $this->serviceManager->di->instantiate($className, []);
        }
        return $this->drivers[$className];
    }

    /**
     * Ensures the DriverManager is properly configured before performing operations
     *
     * @throws NotConfiguredException
     */
    private function ensureConfiguration(): void
    {
        if (!$this->isConfigured()) throw new NotConfiguredException();
    }
}
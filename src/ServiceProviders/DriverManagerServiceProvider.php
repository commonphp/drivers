<?php

/**
 * DriverManagerServiceProvider.php
 *
 * Provides integration of the DriverManager with the CommonPHP Service Management framework,
 * enabling the DriverManager to be used as a service. This service provider ensures that the
 * DriverManager can be automatically bootstrapped and made available for dependency injection
 * throughout the application. It implements both the ServiceProviderContract and BootstrapperContract,
 * facilitating the registration, configuration, and retrieval of the DriverManager as needed.
 *
 * The DriverManagerServiceProvider class plays a crucial role in the driver management ecosystem
 * by enabling dynamic registration and management of driver classes within the CommonPHP library.
 * It allows applications to leverage the powerful features of the DriverManager through the service
 * management framework, promoting a decoupled, modular architecture.
 *
 * @package CommonPHP\Drivers\ServiceProviders
 * @author Timothy McClatchey <timothy@commonphp.org>
 * @copyright 2024 CommonPHP.org
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace CommonPHP\Drivers\ServiceProviders;

use CommonPHP\Drivers\DriverManager;
use CommonPHP\ServiceManagement\Contracts\BootstrapperContract;
use CommonPHP\ServiceManagement\Contracts\ServiceProviderContract;
use CommonPHP\ServiceManagement\ServiceManager;
use Override;

class DriverManagerServiceProvider implements ServiceProviderContract, BootstrapperContract
{
    /** @var ServiceManager The service manager instance for dependency management. */
    private ServiceManager $serviceManager;

    /**
     * @inheritDoc
     */
    #[Override] function bootstrap(ServiceManager $serviceManager): void
    {
        $this->serviceManager = $serviceManager;
    }

    /**
     * @inheritDoc
     */
    #[Override] public function supports(string $className): bool
    {
        return $className === DriverManager::class;
    }

    /**
     * @inheritDoc
     */
    #[Override] public function handle(string $className, array $parameters = []): object
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $driverManager = $this->serviceManager->di->instantiate($className, $parameters);
        $driverManager->bootstrap($this->serviceManager);
        return $driverManager;
    }

    /**
     * @inheritDoc
     */
    #[Override] public function isSingletonExpected(string $className): bool
    {
        return false;
    }
}
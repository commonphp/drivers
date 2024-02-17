<?php

/**
 * Exception thrown when an operation requiring driver manager configuration is attempted without proper setup.
 * Ensures that the driver manager is correctly configured before use.
 *
 * @package CommonPHP\Drivers\Exceptions
 */

namespace CommonPHP\Drivers\Exceptions;

use CommonPHP\Drivers\DriverManager;
use CommonPHP\Drivers\ServiceProviders\DriverManagerServiceProvider;
use Throwable;

class NotConfiguredException extends DriverException
{
    public function __construct(?Throwable $previous = null)
    {
        parent::__construct('This driver manager has not been configured', $previous);
        $this->code = 2212;
    }
}
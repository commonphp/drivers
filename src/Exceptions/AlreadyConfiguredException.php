<?php

/**
 * Exception thrown when attempting to reconfigure the driver manager after it has already been set up.
 * Prevents conflicting configurations that could lead to unpredictable behavior.
 *
 * @package CommonPHP\Drivers\Exceptions
 */

namespace CommonPHP\Drivers\Exceptions;

use CommonPHP\Drivers\DriverManager;
use CommonPHP\Drivers\ServiceProviders\DriverManagerServiceProvider;
use Throwable;

class AlreadyConfiguredException extends DriverException
{
    public function __construct(?Throwable $previous = null)
    {
        parent::__construct('This driver manager has already been configured', $previous);
        $this->code = 2211;
    }
}
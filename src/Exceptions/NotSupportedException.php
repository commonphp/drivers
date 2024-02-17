<?php

/**
 * Exception thrown when an attempt is made to use a class as a driver that is not supported by the current configuration.
 * Ensures that only compatible drivers are enabled and used within the driver management system.
 *
 * @package CommonPHP\Drivers\Exceptions
 */

namespace CommonPHP\Drivers\Exceptions;

use CommonPHP\Drivers\Contracts\DriverContract;
use Throwable;

class NotSupportedException extends DriverException
{
    public function __construct(string $class, ?Throwable $previous = null)
    {
        parent::__construct('The specified class does not appear to be supported by this driver manager: '.$class, $previous);
        $this->code = 2209;
    }
}
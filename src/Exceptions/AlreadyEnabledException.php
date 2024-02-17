<?php

/**
 * Exception thrown when an attempt is made to enable a driver that has already been enabled.
 * Ensures driver uniqueness within the driver management system.
 *
 * @package CommonPHP\Drivers\Exceptions
 */

namespace CommonPHP\Drivers\Exceptions;

use CommonPHP\Drivers\Contracts\DriverContract;
use Throwable;

class AlreadyEnabledException extends DriverException
{
    public function __construct(string $class, ?Throwable $previous = null)
    {
        parent::__construct('The specified driver is already enabled: '.$class, $previous);
        $this->code = 2210;
    }
}
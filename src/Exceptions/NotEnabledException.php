<?php

/**
 * Exception thrown when attempting to access or use a driver that has not been enabled.
 * Ensures that only enabled drivers are utilized within the system.
 *
 * @package CommonPHP\Drivers\Exceptions
 */

namespace CommonPHP\Drivers\Exceptions;

use CommonPHP\Drivers\Contracts\DriverContract;
use Throwable;

class NotEnabledException extends DriverException
{
    public function __construct(string $class, ?Throwable $previous = null)
    {
        parent::__construct('The specified driver is not enabled: '.$class, $previous);
        $this->code = 2201;
    }
}
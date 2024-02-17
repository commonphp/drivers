<?php

/**
 * Base exception class for all exceptions related to the driver management system in CommonPHP.
 * Establishes a foundation for driver-related exceptions with a default error code.
 *
 * @package CommonPHP\Drivers\Exceptions
 */

namespace CommonPHP\Drivers\Exceptions;

use Exception;
use Throwable;

class DriverException extends Exception
{
    public function __construct(string $message = "", ?Throwable $previous = null)
    {
        parent::__construct($message, 2200, $previous);
    }
}
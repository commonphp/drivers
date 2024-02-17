<?php

/**
 * Exception thrown when a declared attribute class does not implement the required DriverAttributeContract.
 * Guarantees that driver attributes adhere to the defined contract for proper system operation.
 *
 * @package CommonPHP\Drivers\Exceptions
 */

namespace CommonPHP\Drivers\Exceptions;

use CommonPHP\Drivers\Contracts\DriverAttributeContract;
use Throwable;

class AttributeMissingImplementationException extends DriverException
{
    public function __construct(string $class, ?Throwable $previous = null)
    {
        parent::__construct('The specified attribute class exists but does not seem to implement '.DriverAttributeContract::class.': '.$class, $previous);
        $this->code = 2205;
    }
}
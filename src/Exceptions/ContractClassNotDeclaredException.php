<?php

/**
 * Exception thrown when the specified contract class for driver identification does not exist.
 * Ensures that only valid, declared contract classes are used in the driver management process.
 *
 * @package CommonPHP\Drivers\Exceptions
 */

namespace CommonPHP\Drivers\Exceptions;

use CommonPHP\Drivers\Contracts\DriverAttributeContract;
use Throwable;

class ContractClassNotDeclaredException extends DriverException
{
    public function __construct(string $class, ?Throwable $previous = null)
    {
        parent::__construct('The specified contract abstract class or interface does not seem to exist: '.$class, $previous);
        $this->code = 2206;
    }
}
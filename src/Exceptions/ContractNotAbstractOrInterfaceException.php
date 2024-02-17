<?php

/**
 * Exception thrown when a specified contract is not an abstract class or an interface.
 * Ensures that driver contracts provide a proper template for driver implementations.
 *
 * @package CommonPHP\Drivers\Exceptions
 */

namespace CommonPHP\Drivers\Exceptions;

use CommonPHP\Drivers\Contracts\DriverAttributeContract;
use Throwable;

class ContractNotAbstractOrInterfaceException extends DriverException
{
    public function __construct(string $class, ?Throwable $previous = null)
    {
        parent::__construct('The specified contract exists but is not an abstract class or interface: '.$class, $previous);
        $this->code = 2207;
    }
}
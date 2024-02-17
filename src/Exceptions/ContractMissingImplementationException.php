<?php

/**
 * Exception thrown when a declared contract class or interface does not implement the required DriverContract.
 * Guarantees that driver contracts adhere to the defined interface for proper system operation.
 *
 * @package CommonPHP\Drivers\Exceptions
 */

namespace CommonPHP\Drivers\Exceptions;

use CommonPHP\Drivers\Contracts\DriverContract;
use Throwable;

class ContractMissingImplementationException extends DriverException
{
    public function __construct(string $class, ?Throwable $previous = null)
    {
        parent::__construct('The specified contract class/interface exists but does not seem to implement '.DriverContract::class.': '.$class, $previous);
        $this->code = 2208;
    }
}
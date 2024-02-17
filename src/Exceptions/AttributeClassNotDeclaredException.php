<?php

/**
 * Exception thrown when the specified attribute class for driver identification does not exist.
 * Ensures that only valid, declared attribute classes are used in the driver management process.
 *
 * @package CommonPHP\Drivers\Exceptions
 */

namespace CommonPHP\Drivers\Exceptions;

use CommonPHP\Drivers\DriverManager;
use CommonPHP\Drivers\ServiceProviders\DriverManagerServiceProvider;
use Throwable;

class AttributeClassNotDeclaredException extends DriverException
{
    public function __construct(string $class, ?Throwable $previous = null)
    {
        parent::__construct('The specified attribute class does not seem to exist: '.$class, $previous);
        $this->code = 2203;
    }
}
<?php

/**
 * Exception thrown when a class marked as a driver attribute does not fulfill the attribute requirements.
 * Ensures that driver attributes are properly defined and recognized by PHP's attribute system.
 *
 * @package CommonPHP\Drivers\Exceptions
 */

namespace CommonPHP\Drivers\Exceptions;

use CommonPHP\Drivers\DriverManager;
use CommonPHP\Drivers\ServiceProviders\DriverManagerServiceProvider;
use Throwable;

class ClassNotAttributeException extends DriverException
{
    public function __construct(string $class, ?Throwable $previous = null)
    {
        parent::__construct('The specified attribute class exists but does not seem to be an attribute class: '.$class, $previous);
        $this->code = 2204;
    }
}
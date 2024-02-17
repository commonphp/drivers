<?php

/**
 * Exception thrown when neither an attribute class nor a contract class is provided for driver configuration.
 * Ensures that the driver manager is configured with at least one method of driver identification.
 *
 * @package CommonPHP\Drivers\Exceptions
 */

namespace CommonPHP\Drivers\Exceptions;

use CommonPHP\Drivers\DriverManager;
use CommonPHP\Drivers\ServiceProviders\DriverManagerServiceProvider;
use Throwable;

class AttributeOrContractRequiredException extends DriverException
{
    public function __construct(?Throwable $previous = null)
    {
        parent::__construct('You must provide an attribute, a contract, or both, to the driver manager', $previous);
        $this->code = 2202;
    }
}
<?php

/**
 * DriverAttributeContract.php
 *
 * Defines a contract for driver attributes within the CommonPHP Driver Management system. This interface
 * is intentionally left empty to serve as a marker for PHP 8 Attributes that can be used to identify
 * driver classes. By implementing this contract, attributes signal their capability to participate in
 * the driver management process, allowing the DriverManager to recognize and manage them accordingly.
 *
 * Although empty, the presence of this contract is crucial for the architecture of the driver management
 * system, providing a standardized way to designate attributes as part of the driver identification
 * mechanism.
 *
 * @package CommonPHP\Drivers\Contracts
 * @author Timothy McClatchey <timothy@commonphp.org>
 * @copyright 2024 CommonPHP.org
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace CommonPHP\Drivers\Contracts;

interface DriverAttributeContract
{
    // This interface is intentionally left empty as a marker for driver attributes.
}

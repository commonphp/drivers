<?php
/**
 * DriverContract.php
 *
 * Defines a contract for drivers within the CommonPHP Driver Management system. This interface
 * is intentionally left empty to serve as a marker for classes that can be considered drivers.
 * Implementing this contract allows the DriverManager to recognize and manage these classes
 * as part of the driver system.
 *
 * The absence of methods within this contract underscores its role as a flexible marker,
 * enabling a wide variety of classes to qualify as drivers without imposing specific
 * implementation requirements. It is an essential component of the driver management
 * architecture, facilitating the dynamic discovery and utilization of drivers.
 *
 * @package CommonPHP\Drivers\Contracts
 * @author Timothy McClatchey <timothy@commonphp.org>
 * @copyright 2024 CommonPHP.org
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace CommonPHP\Drivers\Contracts;

interface DriverContract
{
    // This interface is intentionally left empty as a marker
}
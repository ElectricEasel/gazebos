<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zendshl_Server
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
defined('_JEXEC') or die;

/**
 * Zendshl_Server_Reflection_Function
 */
require_once SHLIB_PATH_TO_ZEND . 'Zendshl/Server/Reflection/Function.php';

/**
 * Zendshl_Server_Reflection_Class
 */
require_once SHLIB_PATH_TO_ZEND . 'Zendshl/Server/Reflection/Class.php';

/**
 * Reflection for determining method signatures to use with server classes
 *
 * @category   Zend
 * @package    Zendshl_Server
 * @subpackage Reflection
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version $Id: Reflection.php 23775 2011-03-01 17:25:24Z ralph $
 */
class Zendshl_Server_Reflection
{
    /**
     * Perform class reflection to create dispatch signatures
     *
     * Creates a {@link Zendshl_Server_Reflection_Class} object for the class or
     * object provided.
     *
     * If extra arguments should be passed to dispatchable methods, these may
     * be provided as an array to $argv.
     *
     * @param string|object $class Class name or object
     * @param null|array $argv Optional arguments to be used during the method call
     * @param string $namespace Optional namespace with which to prefix the
     * method name (used for the signature key). Primarily to avoid collisions,
     * also for XmlRpc namespacing
     * @return Zendshl_Server_Reflection_Class
     * @throws Zendshl_Server_Reflection_Exception
     */
    public static function reflectClass($class, $argv = false, $namespace = '')
    {
        if (is_object($class)) {
            $reflection = new ReflectionObject($class);
        } elseif (class_exists($class)) {
            $reflection = new ReflectionClass($class);
        } else {
            require_once SHLIB_PATH_TO_ZEND . 'Zendshl/Server/Reflection/Exception.php';
            throw new Zendshl_Server_Reflection_Exception('Invalid class or object passed to attachClass()');
        }

        if ($argv && !is_array($argv)) {
            require_once SHLIB_PATH_TO_ZEND . 'Zendshl/Server/Reflection/Exception.php';
            throw new Zendshl_Server_Reflection_Exception('Invalid argv argument passed to reflectClass');
        }

        return new Zendshl_Server_Reflection_Class($reflection, $namespace, $argv);
    }

    /**
     * Perform function reflection to create dispatch signatures
     *
     * Creates dispatch prototypes for a function. It returns a
     * {@link Zendshl_Server_Reflection_Function} object.
     *
     * If extra arguments should be passed to the dispatchable function, these
     * may be provided as an array to $argv.
     *
     * @param string $function Function name
     * @param null|array $argv Optional arguments to be used during the method call
     * @param string $namespace Optional namespace with which to prefix the
     * function name (used for the signature key). Primarily to avoid
     * collisions, also for XmlRpc namespacing
     * @return Zendshl_Server_Reflection_Function
     * @throws Zendshl_Server_Reflection_Exception
     */
    public static function reflectFunction($function, $argv = false, $namespace = '')
    {
        if (!is_string($function) || !function_exists($function)) {
            require_once SHLIB_PATH_TO_ZEND . 'Zendshl/Server/Reflection/Exception.php';
            throw new Zendshl_Server_Reflection_Exception('Invalid function "' . $function . '" passed to reflectFunction');
        }


        if ($argv && !is_array($argv)) {
            require_once SHLIB_PATH_TO_ZEND . 'Zendshl/Server/Reflection/Exception.php';
            throw new Zendshl_Server_Reflection_Exception('Invalid argv argument passed to reflectClass');
        }

        return new Zendshl_Server_Reflection_Function(new ReflectionFunction($function), $namespace, $argv);
    }
}

<?php
/**
 *
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\base\traits;

/**
* 因为有一些模块需要继承从composer拉下来的Module
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */


trait BaseModuleTrait
{
    public function getModuleNamespace()
    {
        $class = get_class($this);
        if (($pos = strrpos($class, '\\')) !== false) {
            return   substr($class, 0, $pos) ;
        }
    }
    
    public static function getModuleDir()
    {
        $reflectionClass = new \ReflectionClass(get_called_class());
        $fn = $reflectionClass->getFileName();
        $path = dirname($fn);
        return $path;
    }
}

?>
<?php
/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */


/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *
 */
class HassClassLoaderDev extends HassClassLoader
{
    public static function registerAlias()
    {
        $psr4File = __DIR__ . DIRECTORY_SEPARATOR . "autoload_psr4.php";

        if (file_exists($psr4File) == false) {
            static::generatePsr4File();
        }
        $classmaps = require($psr4File);
        foreach($classmaps as $namespace =>$path)
        {
            \Yii::setAlias(rtrim(str_replace('\\', '/', $namespace),"/"), array_shift($path));
        }
    }
}
HassClassLoaderDev::registerAlias();
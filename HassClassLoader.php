<?php
/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

use creocoder\flysystem\LocalFilesystem;
use Eloquent\Composer\Configuration\ConfigurationReader;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 1.0
 *
 */
class HassClassLoader
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

    public static function generatePsr4File()
    {
        $filesystem = \Yii::createObject(["class" => LocalFilesystem::className(), "path" => __DIR__]);
        $classMaps = [];
        foreach ($filesystem->listContents() as $item) {
            if ($item["type"] == "dir") {
                $path = $filesystem->getAdapter()->applyPathPrefix($item["path"]);

                if (!file_exists($path . DIRECTORY_SEPARATOR . 'composer.json')) {
                    continue;
                }

                $reader = new ConfigurationReader();

                $configuration = $reader->read($path . DIRECTORY_SEPARATOR . 'composer.json');

                $classMap = $configuration->autoloadPsr4();
                foreach ($classMap as $namespace => $paths) {
                    $classMaps[$namespace] = ['/' . $item["path"]];
                }
            }
        }
        $classMapsString = "<?php\n\n return " . var_export($classMaps, true) . ";";
        $classMapsString = str_replace(['0 => '], ["__DIR__ ."], $classMapsString);
        $filesystem->write("autoload_psr4.php", $classMapsString);
    }

}

HassClassLoader::registerAlias();
<?php
/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\theme\helpers;

use hass\helpers\Package;
use hass\helpers\Util;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *
 */
class Theme extends Package
{

    private $_assetClass = "AppAsset";

    private $_screenshot = "screenshot.png";

    private $_pathMap = [];

    public function isActive()
    {
        $themeLoader = Util::getThemeLoader();

        $theme = $themeLoader->getDefaultTheme();

        return $this->getPackage() == $theme->getPackage();
    }

    public function getPathMap()
    {
        if(empty($this->_pathMap))
        {
            $paths = [];
            $parentThemes = $this->getParentThemes();

            $appViewPath = \Yii::$app->getViewPath();

            if (count($parentThemes) > 0) {
                foreach ($parentThemes as $themeId) {
                    $paths[] = Util::getThemeLoader()->findOne($themeId)->path;
                }
            }

            array_unshift($paths, $this->path);
            array_push($paths, $appViewPath);

            $this->_pathMap =  [
                $appViewPath => $paths
            ];
        }
        return $this->_pathMap;
    }

    /**
     *
     * @return $_assetClass
     */
    public function getAssetClass()
    {
        $extra = $this->configuration->extra();

        $assetClass = $this->_assetClass;
        if (property_exists($extra, "themeAssetClass")) {
            $assetClass = $extra->themeAssetClass;
        }
        return $this->getNamespace()."\\".$assetClass;
    }

    /**
     *
     * @return $_screenshot
     */
    public function getScreenshot()
    {
        $extra = $this->configuration->extra();

        $screenshot = $this->_screenshot;
        if (property_exists($extra, "themeScreenshot")) {
            $screenshot = $extra->themeScreenshot;
        }

        $screenshot = $this->path . DIRECTORY_SEPARATOR . $screenshot;

        $url = "";

        if (file_exists($screenshot)) {
            list (, $url) = \Yii::$app->getAssetManager()->publish($screenshot);
        }

        return $url;
    }

    public function getParentThemes()
    {
        $extra = $this->configuration->extra();

        if (property_exists($extra, "themeParentThemes")) {
            return $extra->themeParentThemes;
        }
        return [];
    }

    public function getName()
    {
        $extra = $this->configuration->extra();

        if (property_exists($extra, "themeName")) {
            return $extra->themeName;
        }
        return $this->configuration->name();
    }

    public function getVersion()
    {
        $extra = $this->configuration->extra();

        if (property_exists($extra, "themeVersion")) {
            return $extra->themeVersion;
        }
        return $this->configuration->version();
    }
}
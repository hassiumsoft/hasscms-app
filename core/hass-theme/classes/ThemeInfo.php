<?php
/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\theme\classes;

use hass\base\classes\PackageInfo;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *       
 */
class ThemeInfo extends PackageInfo
{
    public $parentThemes = [];
    
    protected $assetClass = "AppAsset";
    protected $screenshot = "screenshot.png";
    private $_pathMap = [];

    public function isActive()
    {
        $themeManager = \Yii::$app->get("themeManager");
        return $this->getPackage() == $themeManager->getDefaultThemeId();
    }

    public function getEntityClass()
    {
        if ($this->entityClass == null) {
            $this->entityClass = $this->getNamespace() . "Theme";
        }
        return $this->entityClass;
    }
    
    // 下面的都需要改
    public function getPathMap()
    {
        if (empty($this->_pathMap)) {
            $paths = [];
            $parentThemes = $this->getParentThemes();
            
            $appViewPath = \Yii::$app->getViewPath();
            
            if (count($parentThemes) > 0) {
                foreach ($parentThemes as $themeId) {
                    $paths[] = \Yii::$app->get("themeManager")->findOne($themeId)->path;
                }
            }
            
            array_unshift($paths, $this->path);
            array_push($paths, $appViewPath);
            
            $this->_pathMap = [
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
        return $this->getNamespace() . $this->assetClass;
    }

    public function setAssetClass($class)
    {
        $this->assetClass = $class;
    }

    /**
     *
     * @return $_screenshot
     */
    public function getScreenshot()
    {
        $screenshot = $this->path . DIRECTORY_SEPARATOR . $this->screenshot;
        $url = "";
        if (file_exists($screenshot)) {
            list (, $url) = \Yii::$app->getAssetManager()->publish($screenshot);
        }
        return $url;
    }

    public function setScreenshot($screenshot)
    {
        $this->screenshot = $screenshot;
    }

    public function getParentThemes()
    {
        return $this->parentThemes;
    }
}
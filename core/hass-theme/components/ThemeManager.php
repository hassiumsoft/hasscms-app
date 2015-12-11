<?php

/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\theme\components;

use hass\base\classes\PackageManager;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *       
 */
class ThemeManager extends PackageManager
{
    const HASS_PACKAGE_THEME = "hass-theme";
    
    public $paths = [
        "@root/themes"
    ];

    public $defaultTheme = "app/theme-basic";

    public $infoClass = "\\hass\\theme\\classes\\ThemeInfo";

    public function init()
    {
        parent::init();
    }
    
    public function getThemePath()
    {
        return  $this->paths[0];
    }

    public function getDefaultTheme()
    {
        $config = $this->getDefaultThemeId();
        return $this->findTheme($config);
    }

    public function getDefaultThemeId()
    {
        return \Yii::$app->get("config")->get("theme.defaultTheme", $this->defaultTheme);
    }
    
    /**
     *
     * @param \hass\theme\BaseTheme $theme            
     */
    public function setDefaultTheme($theme)
    {
        try {
            $defaultTheme = $this->getDefaultTheme();
            $defaultTheme->uninstall();
            $theme->install();
            \Yii::$app->get("config")->set("theme.defaultTheme", $theme->getPackageInfo()
                ->getPackage());
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function delete($theme)
    {
        try {
            $this->setCustomCss($theme->getPackageInfo()
                ->getPackage(), null);
            $this->deletePackage($theme->getPackageInfo());
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getCustomCss($id)
    {
        return \Yii::$app->get("config")->get("theme.customCss.$id", "");
    }

    public function setCustomCss($id, $css)
    {
        if ($css == null) {
            return \Yii::$app->get("config")->delete("theme.customCss.$id");
        }
        return \Yii::$app->get("config")->set("theme.customCss.$id", $css);
    }

    public function findTheme($id)
    {
        /** @var \hass\theme\classes\ThemeInfo $themeInfo */
        $themeInfo = $this->findOne($id);
        return $themeInfo->createEntity();
    }
}
<?php

/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\theme\components;

use hass\helpers\PackageLoader;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 1.0
 *
 */
class ThemeLoader extends PackageLoader
{

    public $themePath = "@app/themes";

    public $defaultTheme ="app/theme-basic";

    public function init()
    {
        $this->path = $this->getThemePath();
        parent::init();
    }

    public function getThemePath()
    {
        if (\Yii::$app->get("config", false) != null) {
            return \Yii::$app->get("config")->get("theme.themePath", $this->themePath);
        }

        return $this->themePath;
    }

    public function getDefaultTheme()
    {
        $config = \Yii::$app->get("config")->get("theme.defaultTheme");

        if ($config == null) {
            $config = $this->findOne($this->defaultTheme);
        } else {
            $config = $this->findOne($config);
        }

        return $config;
    }

    /**
     *
     * @param \hass\theme\models\Theme $theme
     */
    public  function setDefaultTheme($id)
    {

        \Yii::$app->get("config")->set("theme.defaultTheme",$id);
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
}
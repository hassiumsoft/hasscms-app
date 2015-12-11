<?php
/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\backend;

use hass\base\ApplicationModule;
use hass\module\components\ModuleManager;
use hass\base\helpers\Util;
use hass\base\classes\Hook;
use hass\system\enums\ModuleGroupEnmu;
use Yii;
/**
 *
 * @package hass\backend
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *
 */
class Module extends ApplicationModule
{

    const HASS_CMS_NAME = "HASSIUM";

    const HASS_CMS_VERSION = "0.1.0";

    const EVENT_ADMIN_NAVBAR = "event_admin_navbar";

    const EVENT_ADMIN_LEFTNAV = "event_admin_nav";

    const EVENT_ADMIN_THEME = "event_admin_theme";

    public $theme = "skin-blue";

    public $layout = "@hass/backend/views/layouts/main";

    public $defaultRoute = "/system/default/index";

    public function init()
    {
        parent::init();
        \Yii::$app->layout = $this->layout;
        \Yii::$app->defaultRoute = $this->defaultRoute;
    }

    public function beforeBootstrap()
    {
        parent::beforeBootstrap();
        Util::setComponent("appUrlManager", [
            "class" => '\yii\web\UrlManager',
            "scriptUrl" => \Yii::$app->getRequest()->getBaseUrl() . '/index.php'
        ]);
    }

    public function loadModules()
    {
        /** @var \hass\module\components\ModuleManager $moduleManager */
        $moduleManager = \Yii::$app->get("moduleManager");
        $moduleManager->loadBootstrapModules(ModuleManager::BOOTSTRAP_BACKEND);
    }


    public function getNavbar()
    {
        return Hook::trigger(static::EVENT_ADMIN_NAVBAR)->parameters->toArray();
    }

    public function getLeftNav()
    {
        return Hook::trigger(\hass\backend\Module::EVENT_ADMIN_LEFTNAV)->parameters->toArray();
    }

    public function getTheme()
    {
        /**
         *
         * @var $parameters \hass\base\classes\Parameters
         */
        $parameters = Hook::trigger(static::EVENT_ADMIN_THEME)->parameters;
        return $parameters->get(static::EVENT_ADMIN_THEME, $this->theme);
    }

    public function getUserAvator()
    {
        return Yii::$app->getUser()
        ->getIdentity()
        ->getAvatar();
    }

    public function getUserName()
    {
        return Yii::$app->getUser()->getIdentity()->username;
    }

    public function getUserRole()
    {
        return Yii::$app->getUser()->getIdentity()->role;
    }

    public function getUserProfileUrl()
    {
        return  ['/user/admin/update',"id"=>Yii::$app->getUser()->getId(),"menu-group"=>ModuleGroupEnmu::PEOPLE];
    }

    public function getUserCreatedDate()
    {
        return Yii::$app->getUser()
        ->getIdentity()
        ->getCreatedDate();
    }

    public function getWebUrl()
    {
        return Yii::$app->get("appUrlManager")->getScriptUrl();
    }
}
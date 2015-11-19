<?php
/**
 *
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2014-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\admin;

use Yii;
use hass\helpers\Hook;
use hass\system\enums\ModuleGroupEnmu;

/**
 *
 * @package hass\admin
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class Module extends \hass\backend\BaseModule
{

    const EVENT_ADMIN_NAVBAR = "event_admin_navbar";

    const EVENT_ADMIN_LEFTNAV = "event_admin_nav";

    const EVENT_ADMIN_THEME = "event_admin_theme";

    public $theme = "skin-purple";

    public function init()
    {
        parent::init();
    }

    public function getNavbar()
    {
        return Hook::trigger(static::EVENT_ADMIN_NAVBAR)->parameters->toArray();
    }

    public function getLeftNav()
    {
       return Hook::trigger(\hass\admin\Module::EVENT_ADMIN_LEFTNAV)->parameters->toArray();
    }

    public function getTheme()
    {
        /**
         *
         * @var $parameters \hass\helpers\Parameters
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

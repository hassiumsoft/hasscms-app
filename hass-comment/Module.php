<?php
/**
 *
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\comment;

use hass\backend\BaseModule;
use hass\helpers\Hook;

use hass\user\models\User;
use yii\base\BootstrapInterface;
use Yii;
use hass\user\helpers\AvatarHelper;
use hass\system\enums\ModuleGroupEnmu;
/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 1.0
 */
class Module extends BaseModule implements BootstrapInterface
{


    public function init()
    {
        parent::init();

    }
    public function behaviors()
    {
        return [
            '\hass\system\behaviors\MainNavBehavior'
        ];
    }
    public function bootstrap($backend)
    {
        Hook::on(\hass\system\Module::EVENT_SYSTEM_GROUPNAV, [
            $this,
            "onSetGroupNav"
        ]);
    }
    /**
     *
     * @param \hass\helpers\Event $event
     */
    public function onSetGroupNav($event)
    {

        $event->parameters->set(ModuleGroupEnmu::CONFIG, [
            [
                'url' => [
                    "/$this->id/default/config"
                ],
                'icon' =>  "fa-circle-o",
                'label' => '评论设置'
            ]
        ]);
    }
    
    public static function getUserInfo($model)
    {
        if($model->author_id)
        {
            $userClass = \Yii::$app->getUser()->identityClass;
            $user = $userClass::findIdentity($model->author_id);
            return [$user->getAvatar(70,70),$user->username];
        }
        return [User::getDefaultAvatar(64,64),$model->username];
    }


}

?>
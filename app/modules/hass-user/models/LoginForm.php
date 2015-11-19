<?php
/**
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\user\models;
use Yii;
/**
*
* @package hass\user
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
*/
class LoginForm extends \dektrium\user\models\LoginForm
{

    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'login'      => Yii::t('user', '账号'),
            'password'   => Yii::t('user', '密码'),
            'rememberMe' => Yii::t('user', '下次自动登录'),
        ];
    }
}
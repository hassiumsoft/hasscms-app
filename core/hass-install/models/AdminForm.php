<?php
/**
 * 
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\install\models;

use yii\base\Model;
use hass\base\traits\ModelTrait;
use Yii;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class AdminForm extends Model
{
    
    use ModelTrait;

    public $email;

    public $username;

    public $password;

    public $passwordConfirm;

    const CACHE_KEY = "install-admin-form";

    public function rules()
    {
        return [
            [
                [
                    'username',
                    'password'
                ],
                'required'
            ],
            
            [
                [
                    'password',
                    'username'
                ],
                'string',
                'max' => 128
            ],
            [
                'email',
                'email'
            ],
            
            // password_confirm
            [
                [
                    'passwordConfirm'
                ],
                'required'
            ],
            [
                [
                    'passwordConfirm'
                ],
                'compare',
                'compareAttribute' => 'password'
            ]
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'username',
            'password' => 'Password',
            'passwordConfirm' => 'Password Confirm',
            'email' => 'Email'
        ];
    }

    public function loadDefaultValues()
    {
        $data = \Yii::$app->getCache()->get(AdminForm::CACHE_KEY);
        if ($data) {
            $this->setAttributes($data);
        }
    }

    public function save()
    {
        \Yii::$app->getCache()->set(AdminForm::CACHE_KEY, $this->toArray());
        return true;
    }
}
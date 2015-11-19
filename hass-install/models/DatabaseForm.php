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
use hass\backend\traits\ModelTrait;
use hass\install\Module;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class DatabaseForm extends Model
{
    
    use ModelTrait;

    public $username;

    public $password;

    public $database;

    public $hostname = "127.0.0.1";

    public $port = "3306";

    public $prefix = "ha_";

    public function rules()
    {
        return [
            [
                [
                    'hostname',
                    'username',
                    'database',
                    "hostname",
                    "port",
                    "prefix"
                ],
                'required'
            ],
            [
                [
                    'password'
                ],
                'safe'
            ]
        ];
    }

    public function attributeLabels()
    {
        return [
            'hostname' => '数据库地址',
            'username' => '数据库账号',
            'password' => '数据库密码',
            'database' => '数据库名称',
            "port" => "端口",
            "prefix" => "前缀"
        ];
    }

    public function save()
    {
        

        Module::setCookieValidationKey();
        
        return true;
        Module::setDbConnection([
            'components' => [
                'db' => [
                    'class' => 'yii\\db\\Connection',
                    'dsn' => "mysql:host=$this->hostname;dbname=$this->database;port=$this->port",
                    'username' => $this->username,
                    'password' => $this->password,
                    'charset' => 'utf8',
                    "tablePrefix" => $this->prefix
                ]
            ]
        ]);
        
        Module::setInstalled();
    
    }
}
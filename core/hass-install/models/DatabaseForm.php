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
use hass\install\Module;
use Yii;
use yii\db\Connection;
use yii\db\Exception;
use fourteenmeister\helpers\Dsn;
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
    
    // @hass-todo 最后加入ha_
    public $prefix = "";

    public function rules()
    {
        return [
            [
                [
                    'hostname',
                    'username',
                    'database',
                    "hostname",
                    "port"
                ],
                'required'
            ],
            [
                [
                    'hostname'
                ],
                'checkDb'
            ],
            [
                [
                    'password',
                    "prefix"
                ],
                'safe'
            ]
        ];
    }
    
    
    public function checkDb($attribute, $params)
    {
        $dsn = "mysql:host=" . $this->hostname . ";dbname=" . $this->database.";port=".$this->port;
        // Create Test DB Connection
        Yii::$app->set('newDb', [
            'class' => Connection::className(),
            'dsn' => $dsn,
            'username' => $this->username,
            'password' => $this->password,
            'charset' => 'utf8'
        ]);
    
        try {
         
            Yii::$app->get("newDb")->open();
            
        } catch (Exception $e) {
            switch ($e->getCode()) {
                case 1049:
                    $this->addError("database", $e->getMessage());
                    break;
                case 1045:
                    $this->addError("password", $e->getMessage());
                    break;
                case 2002:
                    $this->addError("hostname", $e->getMessage());
                    break;
                default:
                    $this->addError("hostname", $e->getMessage());
                    break;
            }
        }
    }

    public function loadDefaultValues()
    {
        $definitions = \Yii::$app->getComponents();
        
        if(isset($definitions["db"]))
        {
            $dsn = Dsn::parse($definitions["db"]['dsn']);
            $this->hostname = $dsn->host;
            $this->database = $dsn->database;
            $this->port = $dsn->port;
            $this->username = $definitions["db"]['username'];
            $this->password = $definitions["db"]['password'];
            $this->prefix =  $definitions["db"]['tablePrefix'];
        }
    }
    
    public function attributeLabels()
    {
        return [
            'hostname' => '数据库地址',
            'username' => '数据库用户名',
            'password' => '数据库密码',
            'database' => '数据库名称',
            "port" => "端口",
            "prefix" => "前缀"
        ];
    }

    public function save()
    {
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
        return true;
    }
}
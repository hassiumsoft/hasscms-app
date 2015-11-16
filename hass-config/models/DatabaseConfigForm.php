<?php
/**
 *
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\config\models;

use yii\db\Connection;
use yii\db\Exception;
use Yii;
use fourteenmeister\helpers\Dsn;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class DatabaseConfigForm extends BaseConfig
{

    public $hostname;

    public $username;

    public $password;

    public $database;

    public function rules()
    {
        return [
            [
                [
                    'hostname',
                    'username',
                    'database'
                ],
                'required'
            ],
            [
                [
                    'hostname',
                    'username',
                    'database',
                    "password"
                ],
                'checkDb'
            ]
        ];
    }

    public function checkDb($attribute, $params)
    {
        $dsn = "mysql:host=" . $this->hostname . ";dbname=" . $this->database;
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

    public function attributeLabels()
    {
        return [
            'hostname' => 'Hostname',
            'username' => 'Username',
            'password' => 'Password',
            'database' => 'Name of Database'
        ];
    }

    public function loadDefaultValues()
    {
        $db = \Yii::$app->getDb();
        $dsn = Dsn::parse($db->dsn);
        $this->hostname = $dsn->host;
        $this->database = $dsn->database;
        $this->username = $db->username;
        $this->password = $db->password;
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        if ($runValidation && ! $this->validate($attributeNames)) {
            return false;
        }

        $config = $this->getConfig();
        $local = $config->getConfigFromLocal();
        $db = [];
        $db['class'] = Connection::className();
        $db['dsn'] = "mysql:host=" . $this->hostname . ";dbname=" . $this->database.";port=3306";
        $db['username'] = $this->username;
        $db['password'] = $this->password;
        $db['charset'] = 'utf8';

        $local["components"]["db"] = $db;

        $config->setConfigToLocal($local);

        return true;
    }
}
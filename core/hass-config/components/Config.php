<?php
/**
 *
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\config\components;
use yii\base\Component;
use yii\base\Exception;
use yii\caching\Cache;
use yii\db\Connection;
use Yii;
use yii\helpers\ArrayHelper;
use hass\config\Module;
use yii\helpers\VarDumper;

/**
*
* @package hass\config
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */
class Config extends Component
{
    /**
     * Database Connection
     * @var string
     */
    public $db = 'db';
    /**
     * Configuration Table Name
     * @var string
     */
    public $tableName = '{{%config}}';
    /**
     * Cache ID
     * @var string
     */
    public $cacheId;
    /**
     * Cache key which corresponds to its value
     * @var string
     */
    public $cacheKey = 'config.cache';
    /**
     * The number of seconds in which the caches value
     * will expire.
     * 0 means never expire
     * @var int
     */
    public $cacheDuration = 0;
    /**
     * Configuration data
     * @var array
     */
    private $_data;
    /**
     * Returns the database connection
     * @var Connection
     */
    private $_db;
    /**
     * @var Cache
     */
    private $_cache;
    /**
     * @inheritdoc
     */
    public function init()
    {
        // Get cache component
        if ($this->cacheId !== null) {
            $this->_cache = Yii::$app->get($this->cacheId);
            if (!$this->_cache instanceof Cache) {
                throw new Exception("Config.db \"{$this->db}\" is invalid.");
            }
        }
        // Get the db component
        $this->_db = Yii::$app->get($this->db);
        if (!$this->_db instanceof Connection) {
            throw new Exception("Config.cacheId \"{$this->cacheId}\" is invalid.");
        }
        parent::init();
    }
    /**
     * Get data
     * @return array
     */
    public function getData()
    {
        if ($this->_data === null) {
            if ($this->_cache !== null) {
                $cache = $this->_cache->get($this->cacheKey);
                if ($cache === false) {
                    $this->_data = $this->_getDataFromDb();
                    $this->_setCache();
                } else {
                    $this->_data = $cache;
                }
            } else {
                $this->_data = $this->_getDataFromDb();
            }
        }
        return $this->_data;
    }
    /**
     * Gets data from the database
     *
     * @return array
     */
    private function _getDataFromDb()
    {
        return ArrayHelper::map($this->_db->createCommand("SELECT name, value FROM {$this->tableName}")->queryAll(), 'name', 'value');
    }
    /**
     * Sets the cache
     */
    private function _setCache()
    {
        if ($this->_cache !== null) {
            $this->_cache->set($this->cacheKey, $this->_data, $this->cacheDuration);
        }
    }
    /**
     * Get configuration variable
     *
     * @param $name
     * @param mixed $default
     * @return mixed
     */
    public function get($name, $default = null)
    {
        if (is_array($name)) {
            $result = [];
            foreach ($name as $key => $value) {
                if (is_int($key)) {
                    $result[$value] = $this->_get($value, $default);
                } else {
                    $result[$key] = $this->_get($key, $value);
                }
            }
            return $result;
        }
        return $this->_get($name, $default);
    }
    /**
     * Find and decode configuration variable
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    private function _get($name, $default = null)
    {
        return array_key_exists($name, $this->getData()) ? $this->getData()[$name] : $default;
    }
    /**
     * Returns all parameters
     *
     * @return array
     */
    public function getAll()
    {
        return $this->getData();
    }
    /**
     * Sets configuration variable
     *
     * @param $name
     * @param mixed $value
     * @return mixed
     */
    public function set($name, $value = null)
    {
        if (is_array($name)) {
            $insert = [];
            $delete = [];
            foreach ($name as $key => $val) {
                $val = $this->_merge($key, $val);
                $insert[] = [$key, $val];
                $delete[] = $key;
                $this->_data[$key] = $val;
            }
            if (count($insert) > 0) {
                $this->_db->createCommand()->delete($this->tableName, ['IN', 'name', $delete])->execute();
                $this->_db->createCommand()->batchInsert($this->tableName, ['name', 'value'], $insert)->execute();
            }
        } else {
            $value = $this->_merge($name, $value);
            if (array_key_exists($name, $this->getData()) === false) {
                $this->_db->createCommand()->insert($this->tableName, ['name' => $name, 'value' => $value])->execute();
            } else {
                $this->_db->createCommand()->update($this->tableName, ['value' => $value], 'name = :name', [':name' => $name])->execute();
            }
            $this->_data[$name] = $value;
        }
        $this->_setCache();
    }
    /**
     * Merge parameters
     * @param string $name
     * @param mixed $value
     *
     * @return mixed
     */
    private function _merge($name, $value)
    {
        if (is_array($name)) {
            $config = $this->_get($name);
            if (is_array($config)) {
                $value = ArrayHelper::merge($config, $value);
            }
        }
        return $value;
    }
    /**
     * Delete parameter
     *
     * @param $name
     * @return mixed
     */
    public function delete($name)
    {
        if (array_key_exists($name, $this->getData())) {
            $this->_db->createCommand()->delete($this->tableName, 'name = :name', [':name' => $name]);
            unset($this->_data[$name]);
        }
        $this->_setCache();
    }
    /**
     * Deletes everything
     *
     * @return mixed
     */
    public function deleteAll()
    {
        $this->_db->createCommand()->delete($this->tableName);
        $this->_data = [];
        $this->_cache->delete($this->cacheKey);
    }


      /**
       * 注意这里可能会产生文件锁的问题.
       */
    public function getConfigFromLocal()
    {
        $config = require ( Module::getLocalConfigPath());

        if (! is_array($config))
            return [];
        return $config;
    }

    /**
     * Sets configuration into the file
     *
     * @param array $config
     */
    public function setConfigToLocal($config = [])
    {
        $content = "<" . "?php return ";
        //$content .= var_export($config, TRUE);
        $content .= VarDumper::export($config);
        $content .= "; ?" . ">";

        file_put_contents(Module::getLocalConfigPath(), $content);
    }

}
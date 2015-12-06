<?php
/**
 * 
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\rbac\components;


use yii\rbac\Item;
use hass\base\classes\Hook;
use yii\rbac\Permission;
use yii\rbac\Role;
use yii\db\Query;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class DbManager extends \yii\rbac\DbManager 
{

    private  $_hookPermissions;

    
    public function init()
    {
        parent::init();
        //@hass-todo 最好放在管理页面修复..
        $this->fixPermissions();
    }
    
    protected function getHookPermissions()
    {
        if ($this->_hookPermissions != null) {
            return $this->_hookPermissions;
        }
        
        $parameters = Hook::trigger(\hass\rbac\Module::EVENT_RBAC_PERMISSION)->parameters;
        
        foreach ($parameters as $config) {
            
            foreach ($config['permissions'] as $name => $item) {
                $class = $item['type'] == Item::TYPE_PERMISSION ? Permission::className() : Role::className();
                
                $this->_hookPermissions[$name] = new $class([
                    'name' => $name,
                    'description' => isset($item['description']) ? $item['description'] : null,
                    'ruleName' => isset($item['ruleName']) ? $item['ruleName'] : null,
                    'data' => isset($item['data']) ? $item['data'] : null,
                    'createdAt' => null,
                    'updatedAt' => null
                ]);
            }
        }
        
        return $this->_hookPermissions;
    }
    
    
    public function fixPermissions()
    {
        $hookPermissions = $this->getHookPermissions();
        $oldPermissions = $this->getPermissions();

        $newPermissions = array_diff_key($hookPermissions, $oldPermissions);
        $delPermissions = array_diff_key($oldPermissions,$hookPermissions);
        
        foreach ($delPermissions  as $item)
        {
            $this->removeItem($item);
        }
        foreach ($newPermissions  as $item)
        {
            $this->addItem($item);
        }
    }
    
    
    
    /** @inheritdoc */
    public function getItem($name)
    {
        return parent::getItem($name);
    }
    
    
    /**
     * Returns both roles and permissions assigned to user.
     *
     * @param  integer $userId
     * @return array
     */
    public function getItemsByUser($userId)
    {
        if (empty($userId)) {
            return [];
        }
    
        $query = (new Query)->select('b.*')
        ->from(['a' => $this->assignmentTable, 'b' => $this->itemTable])
        ->where('{{a}}.[[item_name]]={{b}}.[[name]]')
        ->andWhere(['a.user_id' => (string) $userId]);
    
        $roles = [];
        foreach ($query->all($this->db) as $row) {
            $roles[$row['name']] = $this->populateItem($row);
        }
        return $roles;
    }
    
    /**
     * @param  int|null $type         If null will return all auth items.
     * @param  array    $excludeItems Items that should be excluded from result array.
     * @return array
     */
    public function getItems($type = null, $excludeItems = [])
    {
        $query = (new Query())
        ->from($this->itemTable);
    
        if ($type !== null) {
            $query->where(['type' => $type]);
        } else {
            $query->orderBy('type');
        }
    
        foreach ($excludeItems as $name) {
            $query->andWhere('name != :item', ['item' => $name]);
        }
    
        $items = [];
    
        foreach ($query->all($this->db) as $row) {
            $items[$row['name']] = $this->populateItem($row);
        }
    
        return $items;
    }
    
}
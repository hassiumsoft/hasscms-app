<?php
/**
 * 
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\rbac\models;

use Yii;
use yii\rbac\Item;
use yii\helpers\Json;
use hass\base\traits\ModelTrait;
use hass\rbac\Module;
use yii\helpers\ArrayHelper;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class AuthItem extends \yii\base\Model
{

    use ModelTrait;
    
    public $name;

    public $type;

    public $description;

    public $ruleName;

    public $data;

    private $_data;

    /**
     *
     * @var Item
     */
    private $_item;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'required'],
            ['name', 'match', 'pattern' => '/^[\w-]+$/'],
            [['type'], 'integer'],
            [['name', 'description', 'ruleName'], 'trim'],
            [['description', 'data', 'ruleName'], 'default'],
            ['name', function () {
                if (Yii::$app->authManager->getItem($this->name) !== null) {
                    $this->addError('name', \Yii::t('rbac', 'Auth item with such name already exists'));
                }
            }, 'when' => function () {
                return $this->isNewRecord || $this->_item->name != $this->name;
            }],
            ['ruleName', function () {
                
                if (empty($this->ruleName))
                {
                    $this->ruleName = null;
                    return;
                }
                $authRules = $this->getAuthRules();
                $names = ArrayHelper::getColumn($authRules, "name");
                if(!in_array($this->ruleName,$names))
                {
                    $this->addError('rule', \Yii::t('rbac', 'rule "{0}" does not exist', $this->ruleName));
                    return;
                }
            }],
            [['data'], function(){
                if (is_array($this->data)) {
                    $this->addError('data', 'Invalid JSON data.');
                    return;
                }
                $decode = json_decode((string) $this->data, true);
                switch (json_last_error()) {
                    case JSON_ERROR_NONE:
                        $this->_data = $decode;
                        break;
                    case JSON_ERROR_DEPTH:
                        $this->addError('data', 'The maximum stack depth has been exceeded.');
                        break;
                    case JSON_ERROR_CTRL_CHAR:
                        $this->addError('data', 'Control character error, possibly incorrectly encoded.');
                        break;
                    case JSON_ERROR_SYNTAX:
                        $this->addError('data', 'Syntax error.');
                        break;
                    case JSON_ERROR_STATE_MISMATCH:
                        $this->addError('data', 'Invalid or malformed JSON.');
                        break;
                    case JSON_ERROR_UTF8:
                        $this->addError('data', 'Malformed UTF-8 characters, possibly incorrectly encoded.');
                        break;
                    default:
                        $this->addError('data', 'Unknown JSON decoding error.');
                        break;
                }
            }],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('hass', 'Name'),
            'type' => Yii::t('hass', 'Type'),
            'description' => Yii::t('hass', 'Description'),
            'ruleName' => Yii::t('hass', 'Rule Name'),
            'data' => Yii::t('hass', 'Data')
        ];
    }

    /**
     * Check if is new record.
     *
     * @return boolean
     */
    public function getIsNewRecord()
    {
        return $this->_item === null;
    }

    /**
     * Find role
     *
     * @param string $id            
     * @return null|\self
     */
    public static function findOne($id)
    {
        $item = Yii::$app->authManager->getRole($id);
        $item = $item ?  : Yii::$app->authManager->getPermission($id);
        if ($item !== null) {
            $model = new self();
            $model->setItem($item);
            return $model;
        }
        
        return null;
    }
    
    
    public function delete()
    {
        if ($this->getIsNewRecord() == false)
        {
            return Yii::$app->getAuthManager()->remove($this->getItem());           
        }
 
        return false;
    }

    /**
     * Save role to [[\yii\rbac\authManager]]
     *
     * @return boolean
     */
    public function save()
    {
        if ($this->validate() == false ) {
            return false;
        } 
        
        $manager = Yii::$app->authManager;
        if ($this->_item === null) {
            if ($this->type == Item::TYPE_ROLE) {
                $this->_item = $manager->createRole($this->name);
            } else {
                $this->_item = $manager->createPermission($this->name);
            }
            $isNew = true;
        } else {
            $isNew = false;
            $oldName = $this->_item->name;
        }
        $this->_item->name = $this->name;
        $this->_item->description = $this->description;
        $this->_item->ruleName = $this->ruleName;
        $this->_item->data = $this->_data;
        
        /**
         * 检查规则
         */
        if(!empty($this->_item->ruleName))
        {
            $authRule = $this->getAuthRules();
            $authRule = ArrayHelper::index($authRule, "name");
            if(isset($authRule[$this->_item->ruleName]))
            {
                $rule = \Yii::$app->authManager->getRule($this->_item->ruleName);
                if($rule == null)
                {
                    $rule = \Yii::createObject(['class'=>$authRule[$this->_item->ruleName]['class']]);
                    if(empty($rule->name))
                    {
                        $rule->name = $this->_item->ruleName;
                    }
                    \Yii::$app->authManager->add($rule);
                }
            }
        }
        
        if ($isNew) {
            $manager->add($this->_item);
        } else {
            $manager->update($oldName, $this->_item);
        }
        
        return true;
    }

    /**
     * Get item
     *
     * @return Item
     */
    public function getItem()
    {
        return $this->_item;
    }

    /**
     *
     * @param Item $item            
     */
    public function setItem($item)
    {
        $this->_item = $item;
        if ($item !== null) {
            $this->name = $item->name;
            $this->type = $item->type;
            $this->description = $item->description;
            $this->ruleName = $item->ruleName;
            $this->data = $item->data === null ? null : Json::encode($item->data);
        }
    }
    
    public function getAuthRules()
    {
        /** @var \hass\rbac\Module $module */
        $module = Module::getInstance();
        $rules = $module->authRules;
        return $rules;
    }
    
    public function getAuthRuleList()
    {
        $rules = $this->getAuthRules();
        return ArrayHelper::map($rules, "name", "description");
    }
}
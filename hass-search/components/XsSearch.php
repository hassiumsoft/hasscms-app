<?php
/**
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\search\components;

use yii\base\Component;
use hass\base\classes\Hook;
use hass\search\Module;
use hightman\xunsearch\Database;
/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
*/
class XsSearch extends Component
{
    public $indexs;
    
    public function init()
    {
        parent::init();
        /** @var \hass\base\classes\Parameters $parameters */
        $parameters = Hook::trigger(Module::EVENT_SEARCH_CONFIG)->parameters;
    
        $this->indexs = [];
        foreach ($parameters as $index => $parameter) {
            $this->indexs[$index] = \Yii::getAlias($parameter["xunsearch"]);
        }
    }
    
    public function search($q)
    {
        $result = [];
        foreach ($this->indexs as $config)
        {
            /** @var \hightman\xunsearch\Database $db */
            $db = \Yii::createObject([
                "class"=>Database::className(),
                "iniFile"=>$config,
                "charset"=>"utf-8"
            ]);
            
           $result =array_merge($result, $db->getSearch()->search($q));
        }
        
        $models = [];
        /** @var \XSDocument $item */
        foreach ($result as $item)
        {
            $models[] = $item["entity"]::findOne($item["id"]);
        }
        
  
        return $models;
    }
}
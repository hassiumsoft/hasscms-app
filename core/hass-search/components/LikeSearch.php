<?php
/**
 * 
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

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class LikeSearch extends Component
{
    public $indexs;
    
    public function init()
    {
        parent::init();
        /** @var \hass\base\classes\Parameters $parameters */
        $parameters = Hook::trigger(Module::EVENT_SEARCH_CONFIG)->parameters;

        $this->indexs = [];
        foreach ($parameters as $index =>$parameter)
        {
            $this->indexs[$index] = $parameter["like"];
        }
    }
    
    /**
     * 
     * @param string $q 关键词
     * @param array $indexs  搜索的索引项 
     */
    public function search($q)
    {
        $result = [];
        foreach ($this->indexs as $parameter)
        {
            /** @var \yii\db\ActiveQuery $query */
            $query = $parameter["class"]::find();
            
            foreach ($parameter["fields"] as $field) {
                $query->orWhere([
                    "like",
                    $field,
                    $q
                ]);
            }
            //@hass-todo 这里可以根据时间进行排序
            $result = array_merge($result, $query->all());    
        }
        
        return $result;
    }
}

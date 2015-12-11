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
use yii\sphinx\Query;
use hass\search\Module;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *       
 */
class SphinxSearch extends Component
{

    public $indexs;

    public function init()
    {
        parent::init();
        /** @var \hass\base\classes\Parameters $parameters */
        $parameters = Hook::trigger(Module::EVENT_SEARCH_CONFIG)->parameters;
        
        $this->indexs = [];
        foreach ($parameters as $index => $parameter) {
            $this->indexs[$index] = $parameter["sphinx"];
        }
    }

    public function search($q)
    {
        $query = new Query();
        $rows = $query->from(array_values($this->indexs))
            ->match($q)
            ->showMeta(true)
            ->search();

        $models = [];
        /** @var \XSDocument $item */
        foreach ($rows["hits"] as $item) {
            $models[] = $item["entity"]::findOne($item["id"]);
        }
        
        return $models;
    }
}
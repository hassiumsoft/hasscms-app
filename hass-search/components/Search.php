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
use yii\base\InvalidConfigException;
use hass\helpers\Hook;
use hass\search\Module;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class Search extends Component
{

    public function init()
    {}

    /**
     * Indexing the contents of the specified models.
     * 
     * @throws InvalidConfigException
     */
    public function index()
    {}

    /**
     * Search page for the term in the index.
     * 
     * @param string $term            
     * @param array $fields
     *            (string => string)
     */
    public function find($term, $fields = [])
    {
        /** @var \hass\helpers\Parameters $parameters */
        $parameters = Hook::trigger(Module::EVENT_SEARCH_MODELS)->parameters;
        
        $result = [];
        
        foreach ($parameters as $parameter) {
            /** @var \yii\db\ActiveQuery $query */
            $query = $parameter["class"]::find();
            
            foreach ($parameter["fields"] as $field) {
                $query->orWhere([
                    "like",
                    $field,
                    $term
                ]);
            }
            $result = array_merge($result, $query->all());
        }
        
        return $result;
    }
}

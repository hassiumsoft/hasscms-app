<?php
/**
 *
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\base\helpers;
/**
*
* @package hass\base\helpers
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
*/

class NestedSetsTree
{

    public static $childrenKey = "children";


    /**
     * @param unknown $id
     * @param unknown $item
     * @param unknown $callback
     * @param unknown $config
     */
    protected static function ensureNode($item, $callback,$childrenKey = null)
    {
        $childrenKey = $childrenKey?:static::$childrenKey;

        $item[$childrenKey] = array_key_exists($childrenKey,$item)?$item[$childrenKey]:[];
        if ($callback != null) {
            $item = call_user_func($callback, $item);
        }

        return $item;
    }

 /**
     * Convert a tree array (with depth) into a hierarchical array.
     *  多层级的父子关系..一般为menu提供.这里就是多层级的
     *  单层级的按照父子关系顺序排列的.一般为列表提供..然后根据深度显示层级关系...nestedsets.从数据库取出时使用sort即可不需要再排序
     * https://github.com/fpietka/Zend-Nested-Set
     *
     * @param $nodes|array   Array with depth value.
     *
     * @return array
     */
    public static function generateTree(array $nodes,$callback = null,$childrenKey=null)
    {
        $childrenKey = $childrenKey?:static::$childrenKey;

        $result     = array();
        $stackLevel = 0;
        // Node Stack. Used to help building the hierarchy
        $stack = array();
        foreach ($nodes as  $item) {

            $node = static::ensureNode($item, $callback,$childrenKey);

            // Number of stack items
            $stackLevel = count($stack);
            // Check if we're dealing with different levels
            while ($stackLevel > 0 && $stack[$stackLevel - 1]['depth'] >= $node['depth']) {
                array_pop($stack);
                $stackLevel--;
            }
            // Stack is empty (we are inspecting the root)
            if ($stackLevel == 0) {
                // Assigning the root node
                $i = count($result);
                $result[$i] = $node;
                $stack[] =& $result[$i];
            }
            else {
                // Add node to parent
                $i = count($stack[$stackLevel - 1][$childrenKey]);
                $stack[$stackLevel - 1][$childrenKey][$i] = $node;
                $stack[] =& $stack[$stackLevel - 1][$childrenKey][$i];
            }
        }
        return $result;
    }
}
<?php
/**
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\area\helpers;


use yii\helpers\Url;
use hass\base\classes\Hook;
/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
*/
class AreaHelp
{

    public static function getBlockNav($type)
    {
        $parameters=Hook::trigger(\hass\area\Module::EVENT_BLOCK_TYPE)->parameters;
        $items=[];
        foreach ($parameters as $key=> $parameter)
        {
            $nav = $parameter["nav"];
            $nav["url"] = Url::to(["block/create",'type'=>$key]);
            if($type == $key)
            {
                $nav["active"] = true;
            }
            $items[] = $nav;
        }

        return $items;
    }

    public static function getBlockHook($type)
    {
        $parameters=Hook::trigger(\hass\area\Module::EVENT_BLOCK_TYPE)->parameters;

        $hook = $parameters[$type];

        return [$hook["nav"]["label"],$hook["model"],$hook["view"],$hook["widget"]];
    }


}
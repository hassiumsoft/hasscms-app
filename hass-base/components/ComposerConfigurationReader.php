<?php

/**
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\base\components;
use yii\base\Component;
/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
*/
class ComposerConfigurationReader extends Component
{
    public $reader;
    
    public function init()
    {
        $this->reader = new \Eloquent\Composer\Configuration\ConfigurationReader();
    }
    
    
    /**
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return call_user_func_array([$this->reader, $method], $parameters);
    }
}
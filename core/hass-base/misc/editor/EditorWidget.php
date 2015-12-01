<?php
/**
 *
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\base\misc\editor;


use yii\widgets\InputWidget;
use yii\helpers\Html;

/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */
class EditorWidget extends InputWidget
{
    public $config;

    public function init()
    {
        parent::init();
        if ($this->hasModel())
        {
            $this->name = $this->name ?: Html::getInputName($this->model, $this->attribute);
            $this->value = Html::getAttributeValue($this->model, $this->attribute);
        }

        $this->config["model"] = $this->model;
        $this->config['attribute'] =$this->attribute;
        $this->config['view'] = $this->getView();
    }

    public function run()
    {
        $class = $this->config["class"];
        unset($this->config['class']);
        $editor = $class::widget($this->config);
        return $editor;
    }
}

?>
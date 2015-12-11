<?php
/**
 * 
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\area\widgets;

use yii\base\Widget;
use yii\base\InvalidConfigException;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class Block extends Widget
{

    public $slug;

    public $widgetOptions = [];

    public function init()
    {
        parent::init();
        if (empty($this->slug)) {
            throw new InvalidConfigException("slug不能为空");
        }
    }

    public function run()
    {
        $block = \hass\area\models\Block::findByIdOrSlug($this->slug);
        
        $widget = $block["widget"];
        
        $this->widgetOptions["model"] = $block;
        
        $result = $widget::widget($this->widgetOptions);
        
        return $result;
    }
}
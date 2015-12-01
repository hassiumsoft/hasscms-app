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
use yii\helpers\Html;


/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class Area extends Widget
{

    public $slug;

    public $headerClass ="";

    public $bodyClass ="";

    public $blockClass = "";

    public function init()
    {
        parent::init();
        if (empty($this->slug)) {
            throw new InvalidConfigException("slug不能为空");
        }
        $this->blockClass = $this->blockClass ." block";
        $this->headerClass = $this->headerClass . " block-header";
        $this->bodyClass = $this->bodyClass ." block-body";
    }

    public function run()
    {
        $model = \hass\area\models\Area::findByIdOrSlug($this->slug);
        
        $blocks = $model->getBlocks();
        $result = "";
        foreach ($blocks as $block) {
            $widget = $block["widget"];
            
            $header = Html::tag("h3", $block->title);
            
            $content = Html::tag("div", $header, [
                "class" => $this->headerClass
            ]);
            
            $body = $widget::widget([
                "model" => $block
            ]);
            
            $content .= Html::tag("div", $body, [
                "class" => $this->bodyClass
            ]);
            
            $result .= Html::tag("div", $content, [
                "class" => $this->blockClass
            ]);
        }
        
        return $result;
    }
}
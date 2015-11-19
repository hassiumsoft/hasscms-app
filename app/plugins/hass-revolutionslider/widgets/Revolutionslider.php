<?php
namespace hass\revolutionslider\widgets;

use hass\helpers\ArrayHelper;
use yii\helpers\Html;
class Revolutionslider extends \yii\base\Widget{

    public $options=[];
    
    public $itemOptions = [];
    
    public function init()
    {
        $this->itemOptions = [
            'data-transition'=>"papercut",
            'data-slotamount'=>"7"
        ];
        
        RevolutionsliderAsset::register($this->view);
    }
        
    public function run()
    {
        $options = $this->options;
        $tag = ArrayHelper::remove($options, 'tag', 'ul');
        if ($tag !== false) {
            echo Html::tag($tag, $this->renderItems(), $options);
        } else {
            echo $this->renderItems();
        }
    }
    
    public function renderItems()
    {
        $options = $this->itemOptions;
        $tag = ArrayHelper::remove($options, 'tag', 'li');
        
        $lines = [];
        
        $items = \hass\revolutionslider\models\Revolutionslider::find()->all();
  
        foreach ($items as $item)
        {
            $menu = $this->renderItem($item);
            if ($tag === false) {
                $lines[] = $menu;
            } else {
                $lines[] = Html::tag($tag, $menu, $options);
            }
        }
        
        return implode("\n", $lines);
    }
    
    
    protected function renderItem($item)
    {
        $result = "";
        
        if (($attachment = $item->thumbnail)) {
            $result .= Html::img($attachment->getUrl());
        }
                
        foreach ($item->captions as $caption)
        {
            $result .= Html::tag('div',$caption->content,[
                'class'=>"tp-caption ".$caption->align,
                'data-x'=>$caption->x,
                "data-y"=>$caption->y,
                "data-speed"=>$caption->speed,
                "data-start"=>$caption->start,
                'data-easing'=>$caption->easing
            ]);
        }
        return $result;
    }
}
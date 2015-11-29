<?php
namespace hass\revolutionslider\widgets;
use yii\web\AssetBundle;

class RevolutionsliderAsset extends AssetBundle
{
    public $sourcePath = "@hass/revolutionslider/widgets/media";

    public $css = [
        "js/revolution-slider/css/settings.css",
        "css/widget.css"
    ];

    public $js = [        
        "js/revolution-slider/js/jquery.themepunch.plugins.min.js",
        "js/revolution-slider/js/jquery.themepunch.revolution.min.js",
        'js/revolution.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}
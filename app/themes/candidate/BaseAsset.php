<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */
namespace app\themes\candidate;

use yii\web\AssetBundle;

/**
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class BaseAsset extends AssetBundle
{

    public $sourcePath = "@app/themes/candidate/media";

    public $css = [
        "css/fontello.css",
        "css/flexslider.css",
        "css/owl.carousel.css",
        "js/revolution-slider/css/settings.css",
        "css/responsive-calendar.css",
        "css/chosen.css",
        "jackbox/css/jackbox.min.css",
        "css/cloud-zoom.css",
        "css/style.css"
    ];

    public $js = [
        "js/jquery.queryloader2.min.js",
        'js/modernizr.js',
        "js/jquery.flexslider-min.js",
        "js/owl.carousel.min.js",
        
        "js/revolution-slider/js/jquery.themepunch.plugins.min.js",
        "js/revolution-slider/js/jquery.themepunch.revolution.min.js",
        
        "js/responsive-calendar.min.js",
        "js/jquery.raty.min.js",
        "js/chosen.jquery.min.js",
        
        // "js/jflickrfeed.min.js",
        // "js/instafeed.min.js",
        
        "js/jquery.mixitup.js",
        "jackbox/js/jackbox-packed.min.js",
        "js/zoomsl-3.0.min.js",
        "js/script.js"
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset'
    ];
}

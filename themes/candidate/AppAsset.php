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
class AppAsset extends AssetBundle
{

    public $sourcePath = "@app/themes/candidate/media";

    /**
     * Registers this asset bundle with a view.
     *
     * @param \yii\web\View $view
     *            the view to be registered with
     * @return static the registered asset bundle instance
     */
    public static function register($view)
    {
        $view->registerCss(".no-fouc {display:none;}");
        return parent::register($view);
    }

    public $depends = [
        'app\themes\candidate\BaseAsset',
        'app\themes\candidate\IE9Asset',
        'app\themes\candidate\LtIE9Asset',
        'app\themes\candidate\GtIE8Asset',
        'app\themes\candidate\IE7Asset'
    ];
}

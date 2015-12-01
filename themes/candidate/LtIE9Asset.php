<?php
/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace app\themes\candidate;

use yii\web\AssetBundle;

/**
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class LtIE9Asset extends AssetBundle
{

    public $sourcePath = "@app/themes/candidate/media";

    public $cssOptions = [
        'condition' => 'lt IE 9'
    ];

    public $jsOptions = [
        'condition' => 'lt IE 9'
    ];

    public $css = [
        "css/jackbox-ie8.css",
        "css/ie.css"
    ];

    public $js = [
        "https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js",
        "js/jquery.placeholder.js",
        "js/script_ie.js"
    ];

    public $depends = [
        'app\themes\candidate\BaseAsset'
    ];
}

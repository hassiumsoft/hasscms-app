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
class GtIE8Asset extends AssetBundle
{

    public $sourcePath = "@app/themes/candidate/media";

    public $cssOptions = [
        'condition' => 'gt IE 8'
    ];

    public $css = [
        "css/jackbox-ie9.css"
    ];

    public $js = [];

    public $depends = [
        'app\themes\candidate\BaseAsset'
    ];
}

<?php
/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace hass\backend\assets;
use yii\web\AssetBundle;
/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class IoniconsAsset extends AssetBundle
{
    public $sourcePath = '@vendor/driftyco/ionicons';
    public $css = [
        'css/ionicons.min.css',
    ];
    public $js = [
    ];
    public $depends = [

    ];
}
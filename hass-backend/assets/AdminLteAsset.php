<?php
/**
 *
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2014-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\backend\assets;

use yii\web\AssetBundle;

/**
 * @package hass\backend
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class AdminLteAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/dist';
    public $css = [
        //'css/AdminLTE.min.css',由于中国gfw干掉了谷歌字体.加载很慢
    ];
    public $js = [
        'js/app.min.js'
    ];
    public $depends = [
    ];


}

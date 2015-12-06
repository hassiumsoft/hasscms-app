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

/**
* @package hass\backend
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */
class AdminAsset extends \yii\web\AssetBundle
{

    public $sourcePath = '@hass/backend/misc';
    public $css = [
        "AdminLTE.min.css",
        "_all-skins.min.css",
        "skin-blue.css",
        'admin.css',
    ];
    public $js = [
        'admin.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'hass\backend\assets\FontAwesomeAsset',
        'hass\backend\assets\IoniconsAsset',
        'hass\backend\assets\AdminLteAsset',
    ];


}

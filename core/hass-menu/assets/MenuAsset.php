<?php
/**
 *
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\menu\assets;

/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */

class MenuAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@hass/menu/misc';

    public $js = [
        'menu.js'
    ];
    public $css = [
        'menu.css'
    ];
    public $depends = [
        '\hass\backend\assets\AdminAsset'
    ];

}

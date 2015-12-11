<?php
/**
 *
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2014-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\revolutionslider\assets;

/**
* @package hass\admin
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */
class RevolutionsliderAsset extends \yii\web\AssetBundle
{

    public $sourcePath = '@hass/revolutionslider/media';
    public $css = [
    ];
    public $js = [
        'revolutionslider.js'
    ];
    public $depends = [
        '\hass\backend\assets\AdminAsset'
    ];


}

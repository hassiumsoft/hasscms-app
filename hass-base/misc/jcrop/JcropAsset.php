<?php
/**
 *
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\base\misc\jcrop;

use yii\web\AssetBundle;

/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */
class JcropAsset extends AssetBundle
{
   // public $sourcePath = '@bower/jcrop';
    public $sourcePath = '@hass/base/misc/jcrop/misc';
    public $js = [
        'js/jquery.color.js',
        'js/Jcrop.js'
    ];

    public $css = [
        'css/Jcrop.css'
    ];

    public $depends = [
        'yii\web\JqueryAsset'
    ];
}

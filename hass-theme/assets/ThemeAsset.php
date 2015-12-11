<?php
/**
 *
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2014-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\theme\assets;

/**
* @package hass\backend
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */
class ThemeAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@hass/theme/misc';
    public $css = [
        'theme.css',
    ];
    public $depends = [
        '\hass\backend\assets\AdminAsset'
    ];
}

<?php
/**
 * 
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\i18n\assets;
/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */
class I18nAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@hass/i18n/misc';
    public $css = [
        'css/i18n.css',
    ];
    public $js = [
        'js/i18n.js',
    ];
    public $depends = [
        '\hass\backend\assets\AdminAsset'
    ];
}

<?php
/**
 *
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2014-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\area\assets;

/**
* @package hass\backend
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */
class AreaAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@hass/area/misc';
    public $css = [
        'area.css',
    ];
    public $js = [
        'area.js'
    ];
    public $depends = [
        'hass\backend\assets\AdminAsset',
        'hass\area\assets\HtmlSortableAsset'

    ];
    public $jsOptions = array(
        'position' => \yii\web\View::POS_END
    );
}

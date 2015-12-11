<?php
/**
 *
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2014-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace hass\base\misc\nestedsortable;
use yii\web\AssetBundle;
use yii;
/**
 * @package hass\extensions
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class NestedSortableAsset extends AssetBundle
{
    public $sourcePath = '@hass/base/misc/nestedsortable/misc';
    public $js = [
        'nested-sortable.js'
    ];
    public $css = [
        'nested-sortable.css'
    ];
    public $depends = [
        'yii\jui\JuiAsset',
    ];
}

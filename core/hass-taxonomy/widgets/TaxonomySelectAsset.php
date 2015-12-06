<?php
/**
 *
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2014-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\taxonomy\widgets;

/**
* @package hass\admin
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */
class TaxonomySelectAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@hass/taxonomy/widgets/misc';
    public $css = [
        'taxonomy-select.css',
    ];
    public $depends = [
        '\hass\backend\assets\AdminAsset',
    ];
}

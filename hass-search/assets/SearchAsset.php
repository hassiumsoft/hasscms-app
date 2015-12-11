<?php
/**
 * 
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\search\assets;

use yii\web\AssetBundle;

/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */
class SearchAsset extends AssetBundle
{
    public $sourcePath = '@hass/search/misc';

    public $depends = [
        'yii\web\JqueryAsset'
    ];

    public $css = ['css/search.css'];

    public function init()
    {
        parent::init();
        $this->js[] = YII_DEBUG ? 'js/jquery.highlight-4.js' : 'js/jquery.highlight-4.closure.js';
    }
}

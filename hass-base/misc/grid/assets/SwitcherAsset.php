<?php
/**
 *
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\base\misc\grid\assets;

/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */

class SwitcherAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@bower/switchery/dist';

    public function init()
    {
        if (YII_DEBUG) {
            $this->js[] = 'switchery.js';
            $this->css[] = 'switchery.css';
        } else {
            $this->js[] = 'switchery.min.js';
            $this->css[] = 'switchery.min.css';
        }
    }
}
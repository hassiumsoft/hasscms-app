<?php
/**
 *
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2014-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace hass\base\misc\datetimepicker;
/**
* @package hass\extensions
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */
class DateTimePickerAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@bower';
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];

    public function init()
    {
        if (YII_DEBUG) {
            $this->js[] = 'moment/min/moment-with-locales.js';
            $this->js[] = 'eonasdan-bootstrap-datetimepicker/src/js/bootstrap-datetimepicker.js';
            $this->css[] = 'eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css';
        } else {
            $this->js[] = 'moment/min/moment-with-locales.min.js';
            $this->js[] = 'eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js';
            $this->css[] = 'eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css';
        }
    }

}

?>
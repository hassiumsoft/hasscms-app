<?php
/**
 *
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2014-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\admin\assets;

use yii\base\Exception;
use yii\web\AssetBundle;

/**
 * @package hass\admin
 * @author zhepama <zhepama@gmail.com>
 * @since 1.0
 */
class AdminLteAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/dist';
    public $css = [
        'css/AdminLTE.min.css',
    ];
    public $js = [
        'js/app.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'hass\admin\assets\FontAwesomeAsset',
        'hass\admin\assets\IoniconsAsset',
    ];

    /**
     * @var string|bool Choose skin color, eg. `'skin-blue'` or set `false` to disable skin loading
     * @see https://almsaeedstudio.com/themes/AdminLTE/documentation/index.html#layout
     */
    public $skin = '_all-skins';

    /**
     * @inheritdoc
     */
    public function init()
    {
        // Append skin color file if specified
        if ($this->skin) {
            if (('_all-skins' !== $this->skin) && (strpos($this->skin, 'skin-') !== 0)) {
                throw new Exception('Invalid skin specified');
            }

            $this->css[] = sprintf('css/skins/%s.min.css', $this->skin);
        }

        parent::init();
    }
}

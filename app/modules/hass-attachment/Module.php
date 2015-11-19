<?php
/**
 *
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\attachment;

use hass\backend\BaseModule;
use yii\base\BootstrapInterface;
use hass\helpers\Util;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class Module extends BaseModule implements BootstrapInterface
{

    public function init()
    {
        parent::init();
    }

    public function behaviors()
    {
        return [
            '\hass\system\behaviors\MainNavBehavior'
        ];
    }

    public function bootstrap($backend)
    {
        Util::setComponent("fileStorage", [
            'class' => '\hass\attachment\components\FileStorage',
            'filesystem' => [
                'class' => 'creocoder\flysystem\LocalFilesystem',
                'path' => '@webroot/uploads'
            ],
            'baseUrl' => '@web/uploads'
        ]);
    }
}

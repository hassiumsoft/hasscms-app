<?php
/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\theme;

use yii\base\BootstrapInterface;
use hass\helpers\Util;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 1.0
 *       
 */
class Module extends \hass\backend\BaseModule implements BootstrapInterface
{

    function init()
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
        Util::setComponent("themeLoader", [
            "class" => 'hass\theme\components\ThemeLoader'
        ]);
    }
}
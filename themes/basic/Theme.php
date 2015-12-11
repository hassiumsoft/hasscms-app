<?php

/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace app\themes\basic;
use yii\base\BootstrapInterface;
use hass\base\helpers\Util;
use hass\theme\BaseTheme;
/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *
 */
class Theme extends BaseTheme  implements BootstrapInterface
{
    public function bootstrap($app)
    {
        Util::setComponent("view", ["defaultExtension"=>"twig"]);
    }
}

<?php

/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace app\themes\candidate;

use yii\base\BootstrapInterface;
use hass\theme\BaseTheme;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *       
 */
class Theme extends BaseTheme implements BootstrapInterface
{

    public function bootstrap($app)
    {
        $definitions = $app->getComponents();
        $definitions["assetManager"]["bundles"]['yii\web\JqueryAsset'] = [
            'sourcePath' => "@app/themes/candidate/media",
            'js' => [
                'js/jquery-1.11.0.min.js'
            ]
        ];
        
        $app->set("assetManager", $definitions["assetManager"]);
    }
}

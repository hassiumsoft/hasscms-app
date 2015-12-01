<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace hass\authclient\widgets;


use yii\web\AssetBundle;


/**
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class AuthChoiceStyleAsset extends AssetBundle
{
    public $sourcePath = '@hass/authclient/assets';
    public $css = [
        'authchoice.css',
    ];
}
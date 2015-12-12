<?php

/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\attachment\widgets;

use yii\helpers\Html;
use yii\helpers\Json;
use yii\jui\JuiAsset;
use hass\attachment\widgets\assets\AttachmentUploadAsset;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *
 */
class SingleMediaWidget extends MultipleMediaWidget
{

    public $multiple = false;

    public $url = [
        '/attachment/upload/create-temp'
    ];

    public $maxFileSize = 0;

    /**
     * Registers required script for the plugin to work as jQuery File Uploader
     */
    public function registerClientScript()
    {
        Html::addCssClass($this->wrapperOptions, " single-media upload-kit");

        AttachmentUploadAsset::register($this->getView());

        if ($this->sortable) {
            JuiAsset::register($this->getView());
        }

        $options = Json::encode($this->clientOptions);
        $this->getView()->registerCss(".single-media .upload-kit-input {
    height: 150px;
    width: 100%;
}
.single-media .upload-kit-item  {
	margin:0;
}
.single-media .upload-kit-item.image > img {
    height: 100%;
    width: 100%;
    border-radius: 7px;
}

            ");
        $this->getView()->registerJs("jQuery('#{$this->options['id']}').attachmentUpload({$options});");
    }
}
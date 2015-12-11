<?php
/**
 *
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\attachment\widgets;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\jui\JuiAsset;
use yii\widgets\InputWidget;
use hass\attachment\widgets\assets\AttachmentUploadAsset;
use yii\base\InvalidConfigException;
/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class MultipleMediaWidget extends InputWidget
{


    public $wrapperOptions;
    /**
     *
     * @var array
     */
    public $clientOptions = [];

/*
 * ----------------------------------------------
 * 客户端选项,构成$clientOptions
 * ----------------------------------------------
 */
    /**
     *
     * @var array 上传url地址
     */
    public $url = [];

    /**
     *  这里为了配合后台方便处理所有都是设为true,文件上传数目请控制好 $maxNumberOfFiles
     * @var bool
     */
    public $multiple = true;

    /**
     *
     * @var bool
     */
    public $sortable = false;

    /**
     *
     * @var int 允许上传的最大文件数目
     */
    public $maxNumberOfFiles = 1;

    /**
     *
     * @var int 允许上传文件最大限制
     */
    public $maxFileSize;

    /**
     *
     * @var string 允许上传的附件类型
     */
    public $acceptFileTypes;

    /*
     * ----------------------------------------------
     * 客户端选项,构成$clientOptions
     * ----------------------------------------------
     */

      public $deleteUrl = ["/attachment/upload/delete"];

    /**
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();

        //@hass-todo  清除临时图片
        //$this->getFileStorage()->clearUserTempPath();

        if ($this->hasModel()) {
            $this->name = $this->name ? : Html::getInputName($this->model, $this->attribute);
            $attachments = $this->multiple == true ? $this->model->{$this->attribute}:[$this->model->{$this->attribute}];
            $this->value = [];
            foreach ($attachments as $attachment) {
                $value =  $this->formartAttachment($attachment);
                if($value)
                {
                    $this->value[] = $value;
                }
            }

        }

        if (! array_key_exists('fileparam', $this->url)) {
            $this->url['fileparam'] = $this->name;//服务器需要通过这个判断是哪一个input name上传的
        }

        $this->clientOptions = ArrayHelper::merge($this->clientOptions, [
            'name'=> $this->name, //主要用于上传后返回的项目name
            'url' => Url::to($this->url),
            'multiple' => $this->multiple,
            'sortable' => $this->sortable,
            'maxNumberOfFiles' => $this->maxNumberOfFiles,
            'maxFileSize' => $this->maxFileSize,
            'acceptFileTypes' => $this->acceptFileTypes,
            'files' => $this->value?:[]
        ]);


    }

    /**
     *
     * @return \hass\attachment\components\FileStorage
     * @throws \yii\base\InvalidConfigException
     */
    protected function getFileStorage()
    {
        $fileStorage = \Yii::$app->get('fileStorage');
        if (! $fileStorage) {
            throw new InvalidConfigException(400);
        }
        return $fileStorage;
    }

    /**
     *
     * @param \hass\attachment\models\Attachment $attachment
     */
    protected function formartAttachment($attachment)
    {

        if ($attachment instanceof \hass\attachment\models\Attachment)
        {
            $result = $attachment->toArray();

            $result['id'] = $attachment->primaryKey;
            $result['path'] = $attachment->getPath();
            $result['url'] = $attachment->getUrl();
            $result['thumbnailUrl'] = $result['url'];
            $result['deleteUrl'] = Url::to(array_merge($this->deleteUrl,["path" =>  $result['path'] ,
                'id' => $result['id']
            ]));
            $result['deleteType'] = "DELETE";
            return $result;
        }
        else if(is_string($attachment)&&!empty($attachment))
        {
            return ["url"=>$attachment,"path"=>$attachment];
        }
        else if(is_array($attachment))
        {
            return $attachment;
        }

        return null;
    }



    /**
     *
     * @return string
     */
    public function run()
    {
        $this->registerClientScript();
        $content = Html::beginTag('div',$this->wrapperOptions);
        $content .= Html::fileInput($this->name, null, [
            'id' => $this->options['id'],
            'multiple' => $this->multiple
        ]);
        $content .= Html::endTag('div');
        return $content;
    }

    /**
     * Registers required script for the plugin to work as jQuery File Uploader
     */
    public function registerClientScript()
    {
        Html::addCssClass($this->wrapperOptions, " upload-kit");

        AttachmentUploadAsset::register($this->getView());

        if ($this->sortable) {
            JuiAsset::register($this->getView());
        }

        $options = Json::encode($this->clientOptions);
        $this->getView()->registerJs("jQuery('#{$this->options['id']}').attachmentUpload({$options});");
    }
}

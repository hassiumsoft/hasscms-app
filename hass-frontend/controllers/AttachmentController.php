<?php

/**
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\frontend\controllers;
use hass\frontend\BaseController;

use yii\filters\VerbFilter;
use hass\attachment\actions\UploadAction;
/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
*/
class AttachmentController extends BaseController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'delete' => ['delete']
                ]
            ]
        ];
    }


    public function actions()
    {
        return [
            'create-temp' => [
                'class' => '\hass\attachment\actions\UploadAction',
                'storageLocation'=>UploadAction::STORAGE_LOCATION_TEMPPATH
            ],
            'create-save' => [
                'class' => '\hass\attachment\actions\UploadAction',
                'storageLocation'=>UploadAction::STORAGE_LOCATION_USERPATH_DATABASE
            ],
            'create-imperavi' => [
                'class' => '\hass\attachment\actions\UploadAction',
                'storageLocation'=>UploadAction::STORAGE_LOCATION_TEMPPATH,
                'fileparam' => 'file',
                'responseUrlParam'=> 'filelink',
                'multiple' => false,
                'disableCsrf' => true
            ],
            'delete-temp' => [
                'class' => '\hass\attachment\actions\DeleteAction',
                'temp'=>true
            ],
            'delete' => [
                'class' => '\hass\attachment\actions\DeleteAction'
            ],
            'images-get' => [
                'class' => '\hass\attachment\actions\GetAction'
            ],
        ];
    }

}
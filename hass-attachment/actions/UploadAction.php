<?php
/**
 *
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\attachment\actions;


use Yii;
use yii\base\DynamicModel;
use yii\helpers\Url;
use yii\web\Response;
use yii\web\UploadedFile;
use hass\attachment\models\Attachment;

/**
* Class UploadAction
* public function actions(){
*   return [
*           'upload'=>[
*               'class'=>'hass\attachment\actions\UploadAction',
*           ]
*       ];
*   }
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */
class UploadAction extends BaseAction
{
    /**
     * @var bool
     */
    public $disableCsrf = true;

    /**
     * @var bool
     */
    public $multiple = true;

    /**
     * @var string
     */
    public $responseFormat = Response::FORMAT_JSON;

    /**
     * @var array
     * @see https://github.com/yiisoft/yii2/blob/master/docs/guide/input-validation.md#ad-hoc-validation-
     */
    public $validationRules;


    /**
     * @var string 上传的文件框name名称 使用$_FILES[$fileparam]
     */
    public $fileparam = 'file';


    /**
     * -------------------------------
     * 针对不同的编辑器和上传可能会返回不同的值
     * -------------------------------
     *
     */
    //上传的位置,只存储到临时目录.准备二次存储
    const STORAGE_LOCATION_TEMPPATH="STORAGE_LOCATION_TEMPPATH";
    //上传到用户目录,同时存储到数据库
    const STORAGE_LOCATION_USERPATH_DATABASE="STORAGE_LOCATION_USERPATH_DATABASE";

    /**
     * @var string  返回的图片url
     */
    public $responseUrlParam = 'url';
    public $deleteUrl =["/attachment/upload/delete"];
    public $updateUrl =["/attachment/default/update"];
    public $storageLocation;

    public function init()
    {
        \Yii::$app->response->format = $this->responseFormat;

        $this->fileparam = \Yii::$app->request->get('fileparam', $this->fileparam);
        $this->multiple = \Yii::$app->request->get('multiple',$this->multiple);


        if ($this->disableCsrf) {
            \Yii::$app->request->enableCsrfValidation = false;
        }
    }

    /**
     * @return array
     * @throws \HttpException
     */
    public function run()
    {
        $result = [];

        $uploadedFiles = UploadedFile::getInstancesByName($this->fileparam);
        foreach ($uploadedFiles as $uploadedFile) {
            /* @var \yii\web\UploadedFile $uploadedFile */
            $output = [];
            $output['id'] = -1;

            $output[$this->responseUrlParam] ="";
            $output['thumbnailUrl'] ="";
            $output['deleteUrl'] = "";
            $output['updateUrl'] = "";
            $output['path'] = "";


            if ($uploadedFile->error === UPLOAD_ERR_OK) {
                $validationModel = DynamicModel::validateData(['file' => $uploadedFile], $this->validationRules);
                if (!$validationModel->hasErrors()) {

                   $attachment = new Attachment();

                    if($this->storageLocation == static::STORAGE_LOCATION_TEMPPATH)
                    {
                        $attachment->setStorageDirectory($attachment->getTempDirectory());
                        $attachment->uploadFromPost($uploadedFile);
                    }
                    else if($this->storageLocation == static::STORAGE_LOCATION_USERPATH_DATABASE)
                    {
                        $attachment->uploadFromPost($uploadedFile);
                        $attachment->save();
                    }

                   $output =  array_merge($output,$attachment->toArray());

                   if($attachment->primaryKey)
                   {
                        $output["id"] = $attachment->primaryKey;
                   }

                $output["path"] = $attachment->getPath();
                $output[$this->responseUrlParam] =  $attachment->getUrl() ;
                $output["thumbnailUrl"] =   $attachment->getUrl();
                $output["deleteUrl"] = Url::to(array_merge($this->deleteUrl,['path' => $output["path"],'id'=> $output['id'] ]));
                $output["updateUrl"] = Url::to(array_merge($this->updateUrl,['path' => $output["path"],'id'=> $output['id'] ]));

                } else {
                    $output['error'] = true;
                    $output['errors'] = $validationModel->errors;
                }
            } else {
                $output['error'] = true;
                $output['errors'] = $this->resolveErrorMessage($uploadedFile->error);
            }

            $result["files"][] = $output;
        }
        $result =  $this->multiple ? $result : array_shift($result);

        return $result;
    }



    protected function resolveErrorMessage($value)
    {
        switch ($value) {
            case UPLOAD_ERR_OK:
                return false;
                break;
            case UPLOAD_ERR_INI_SIZE:
                $message = 'The uploaded file exceeds the upload_max_filesize directive in php.ini.';
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $message = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.';
                break;
            case UPLOAD_ERR_PARTIAL:
                $message = 'The uploaded file was only partially uploaded.';
                break;
            case UPLOAD_ERR_NO_FILE:
                $message = 'No file was uploaded.';
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $message = 'Missing a temporary folder.';
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $message = 'Failed to write file to disk.';
                break;
            case UPLOAD_ERR_EXTENSION:
                $message = 'A PHP extension stopped the file upload.';
                break;
            default:
                return null;
                break;
        }
        return $message;
    }
}

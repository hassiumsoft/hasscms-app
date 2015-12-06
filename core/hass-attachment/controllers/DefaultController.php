<?php
/**
 *
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\attachment\controllers;

use Yii;
use hass\attachment\models\Attachment;
use yii\web\NotFoundHttpException;
use hass\base\BaseController;
use hass\attachment\enums\CropType;
use yii\imagine\Image;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class DefaultController extends BaseController
{

    public function actions()
    {
        return [
            "delete" => [
                "class" => '\hass\base\actions\DeleteAction',
                'modelClass' => 'hass\attachment\models\Attachment'
            ],
            "update" => [
                "class" => '\hass\base\actions\UpdateAction',
                'modelClass' => 'hass\attachment\models\Attachment'
            ],
            "index" => [
                "class" => '\hass\base\actions\IndexAction',
                'modelClass' => '\hass\attachment\models\Attachment',
                "pageSize" => 36,
                "query"=>['orderBy'=>['attachment_id' => SORT_DESC]]
            ]
        ];
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if (! $model->save()) {
                $error = $model->formatErrors();
                return $this->renderJsonMessage(false, $error);
            }
        }

        $content = $this->renderPartial('view', [
            'model' => $model
        ]);

        return $this->renderJsonMessage(true, $content);
    }

    public function actionUploader()
    {
        return $this->render("uploader");
    }

    public function actionCrop($id)
    {
        $model = $this->findModel($id);
        $type = \Yii::$app->getRequest()->post("type");
        $x = \Yii::$app->getRequest()->post("x");
        $y = \Yii::$app->getRequest()->post("y");
        $w = \Yii::$app->getRequest()->post("w");
        $h = \Yii::$app->getRequest()->post("h");

        switch ($type) {
            case CropType::ALL:
                $original = $model->getAbsolutePath();
                Image::crop($original, $w, $h, [
                    $x,
                    $y
                ])->save($original);
                $model->deleteThumbs();
                break;
            case CropType::THUMBNAIL:
                $original = $model->getAbsolutePath();
                $newPath = $model->getTempDirectory() . DIRECTORY_SEPARATOR . $model->hash . "." . $model->extension;
                $newOriginal = \Yii::$app->get("fileStorage")->getPath($newPath);

                Image::crop($original, $w, $h, [
                    $x,
                    $y
                ])->save($newOriginal);

                $thumbs = $model->getThumbs();
                foreach ($thumbs as $path) {
                    $fileName = ltrim(pathinfo(" ".$path, PATHINFO_FILENAME));
                    $parts = explode("_", $fileName);
                    list ($w, $h) = explode("x", $parts[2]);
                    Image::thumbnail($newOriginal, $w, $h)->save(\Yii::$app->get("fileStorage")->getPath($path));
                }

                \Yii::$app->get("fileStorage")->delete($newPath);
                break;
            case CropType::ORIGINAL:
                $original = $model->getAbsolutePath();
                Image::crop($original, $w, $h, [
                    $x,
                    $y
                ])->save($original);
                break;
        }
        return $this->renderJsonMessage(true, "裁剪成功");
    }

    /**
     * Finds the Attachment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     * @return Attachment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Attachment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

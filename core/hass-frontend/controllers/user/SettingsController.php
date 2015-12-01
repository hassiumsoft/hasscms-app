<?php
/**
 *
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\frontend\controllers\user;


use Yii;
use hass\base\helpers\Util;
use yii\imagine\Image;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class SettingsController extends \dektrium\user\controllers\SettingsController
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        array_push($behaviors['access']['rules'][0]['actions'], "avatar");

        return $behaviors;
    }

    public function actionAvatar()
    {
        $user = $this->finder->findUserById(Yii::$app->user->identity->getId());

        if (\Yii::$app->getRequest()->isAjax) {
            $avatar = \Yii::$app->getRequest()->post("avatar");
            $x = \Yii::$app->getRequest()->post("x");
            $y = \Yii::$app->getRequest()->post("y");
            $w = \Yii::$app->getRequest()->post("w");
            $h = \Yii::$app->getRequest()->post("h");

            $original = \Yii::$app->get("fileStorage")->getPath($avatar);
            Image::crop($original, $w, $h, [
                $x,
                $y
            ])->save($original);

            $user->saveAvatar($avatar);

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $message = Yii::createObject('\hass\base\classes\JSONMessage', [
                true,
                "保存成功"
            ]);
            $result = $message->getArray();
            return $result;
        }

        return $this->render('avatar', [
            'user' => $user
        ]);
    }
}

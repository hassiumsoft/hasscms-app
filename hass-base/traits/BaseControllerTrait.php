<?php
/**
 *
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\base\traits;
use Yii;
use yii\widgets\ActiveForm;
use yii\web\Response;
/**
* 前台和后台公用的
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */


trait BaseControllerTrait
{
    /**
     * Performs AJAX validation.
     *
     * @param array|Model $model
     *
     * @throws ExitException
     */
    public function performAjaxValidation($model)
    {
        if (Yii::$app->request->isAjax && !Yii::$app->request->isPjax) {
            if ($model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                echo json_encode(ActiveForm::validate($model));
                Yii::$app->end();
            }
        }
    }


    /**
     *发送json消息
     * @param string $status
     * @param string $content
     * @param unknown $additionalAttributes
     * @param string $elementId
     */
    public function renderJsonMessage($status = true, $content = '',  $additionalAttributes = [],$elementId = '0')
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        }

        $message = Yii::createObject('\hass\base\classes\JSONMessage',[$status, $content,$additionalAttributes,$elementId]);

        $result =  $message->getArray();
        return $result;
    }



    /**
     *
     * @param unknown $type
     * @param unknown $message
     */
    public function flash($type, $message)
    {
        Yii::$app->getSession()->setFlash($type == 'error' ? 'danger' : $type, $message);
    }


    /**
     *
     * @return \yii\web\Response
     */
    public function goReferrer()
    {
        return $this->redirect(Yii::$app->getRequest()->getReferrer());
    }
}

?>
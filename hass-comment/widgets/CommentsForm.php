<?php
/**
 *
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\comment\widgets;

use hass\comment\models\Comment;
use Yii;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;
use yii\web\View;

/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */
class CommentsForm extends \yii\base\Widget
{
    public $commentUrl;

    public $model;

    public $entity;

    public $entity_id;


    public function init()
    {
        parent::init();

        if($this->commentUrl)
        {
            $this->view->registerJs('var commentUrl = "'.Url::to($this->commentUrl). '";',View::POS_HEAD);
        }

        if($this->model == null)
        {
            $this->model = new Comment();
            $this->model->entity = $this->entity;
            $this->model->entity_id = $this->entity_id;
        }

        if (Yii::$app->user->isGuest) {
            $this->model->username = HtmlPurifier::process(Yii::$app->getRequest()->getCookies()->getValue('username'));
            $this->model->email = HtmlPurifier::process(Yii::$app->getRequest()->getCookies()->getValue('email'));
        }

    }

    public function run()
    {
        return $this->render('form', ['model' => $this->model]);
    }
}
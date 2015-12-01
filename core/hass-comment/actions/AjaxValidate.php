<?php
/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\comment\actions;

use yii\base\Action;
use hass\comment\models\Comment;
use Yii;
use hass\base\helpers\ArrayHelper;
use yii\filters\VerbFilter;


/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *
 */

class AjaxValidate extends Action
{
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'get-form' => ['post'],
                    ],
                ],
            ]);
    }

    public function run()
    {
          $model = new Comment(['scenario' => (Yii::$app->user->isGuest) ? Comment::SCENARIO_GUEST
            : Comment::SCENARIO_USER]);

         $this->controller->performAjaxValidation($model);
    }
}

?>
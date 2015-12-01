<?php
/**
 *
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

use hass\comment\widgets\assets\CommentsAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use hass\comment\Module;

/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */


/* @var $this yii\web\View */
/* @var $modelhass\comment\models\Comment */

CommentsAsset::register($this);

?>

<?php
$form = ActiveForm::begin([
    "options"=>["class"=>"comment-form"]
]);
?>
<div class="media"  <?= $model->parent_id?:"id='comment-form'"; ?>>
  <div class="media-left">
    <a href="#">
    <?php if(\Yii::$app->getUser()->isGuest):?>
      <img class="media-object" style ="width: 54px; height: 54px;" src="<?php echo \hass\user\models\User::getDefaultAvatar(64,64); ?>" >
        <?php else:?>
        <img class="media-object" style ="width: 54px; height: 54px;" src="<?php echo \Yii::$app->getUser()->identity->getAvatar(70,70);?>" >
        <?php endif;?>
    </a>
  </div>
  <div class="media-body">

       <div class="media-content comment-form-content margin-bottom">
        <?php echo Html::activeTextarea($model, 'content',[
            'class' => 'form-control',
            'placeholder' => 'Share your thoughts...'
        ])?>
       </div>

    <div class="media-footer comment-form-footer clearfix ">
            <div class="auth-section pull-left form-inline">
                    <?php if (Yii::$app->user->isGuest): ?>
                            <?=
                            $form->field($model, 'username')->textInput([
                                'class' => 'form-control input-sm',
                                'placeholder' => 'Your name'
                            ])->label(null,["class"=>"sr-only"]);
                            ?>
                            <?=
                            $form->field($model, 'email')->textInput([
                                'type' => "email",
                                'class' => 'form-control input-sm',
                                'placeholder' => 'Your email'
                            ])->label(null,["class"=>"sr-only"]);
                            ?>
                    <?php else: ?>
                            <?=
                            (($model->parent_id) ? 'Reply as ' : 'Post as ') .
                            '<b>' . Yii::$app->user->identity->username . '</b>';
                            ?>

                    <?php endif; ?>
            </div>

            <div class="pull-right">
                <?php
                if($model->parent_id)
                {
                    echo   Html::button('取消',
                        ['class' => 'btn btn-default btn-sm reply-cancel']);
                }
                ?>
                <?=
                Html::submitButton(($model->parent_id) ? '回复' : '评论',
                    ['class' => 'btn btn-primary btn-sm'])
                ?>
            </div>

            <?php
            echo Html::activeHiddenInput($model, 'entity');
            echo Html::activeHiddenInput($model, 'entity_id');
            echo Html::activeHiddenInput($model, 'parent_id');
            ?>
    </div>
  </div>
</div>
 <?php ActiveForm::end(); ?>





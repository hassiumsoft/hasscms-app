<?php
/**
 *
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use hass\base\enums\EntityStatusEnum;
use hass\comment\Module;


/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */
/* @var $this yii\web\View */
/* @var $model hass\comment\models\Comment */
/* @var $form yii\widgets\ActiveForm */


?>

    <div class="row">
        <?php
    $form = ActiveForm::begin([
        'id' => 'comment-form',
        'validateOnBlur' => false,
    ])
    ?>
        <div class="col-md-9">

            <div class="box box-solid">
                <div class="box-body">
                    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>
                </div>

            </div>
        </div>
        <?php list($avatar,$username) = Module::getUserInfo($model)?>
        <div class="col-md-3">

            <div class="box box-solid ">
                <div class="box-body">
                    <div class="record-info">

                        <div class="form-group clearfix">
                            <label class="control-label" style="float: left; padding-right: 5px;">
                                <?= $model->attributeLabels()['username'] ?> :
                            </label>
                            <span><?= $username ?></span>
                        </div>

                        <div class="form-group clearfix">
                            <label class="control-label" style="float: left; padding-right: 5px;">
                                <?= $model->attributeLabels()['created_at'] ?> :
                            </label>
                            <span><?= $model->createdDateTime ?></span>
                        </div>

                        <div class="form-group clearfix">
                            <label class="control-label" style="float: left; padding-right: 5px;">
                                <?= $model->attributeLabels()['updated_at'] ?> :
                            </label>
                            <span><?= $model->updatedDateTime ?></span>
                        </div>

                        <div class="form-group clearfix">
                            <label class="control-label" style="float: left; padding-right: 5px;">
                                <?= $model->attributeLabels()['user_ip'] ?> :
                            </label>
                            <span><?= $model->user_ip ?></span>
                        </div>

                        <div class="form-group clearfix">
                            <label class="control-label" style="float: left; padding-right: 5px;">
                                <?= $model->attributeLabels()['email'] ?> :
                            </label>
                            <span><?= $model->email ?></span>
                        </div>


                        <div class="form-group">
                            <?= Html::submitButton('<span class="glyphicon glyphicon-ok"></span> Save', ['class' => 'btn btn-primary']) ?>

                            <?=
                            Html::a('<span class="glyphicon glyphicon-remove"></span> Delete',
                                ['/comment/default/delete', 'id' => $model->comment_id],
                                [
                                    'class' => 'btn btn-default',
                                    'data' => [
                                        'confirm' => 'Are you sure you want to delete this item?',
                                        'method' => 'post',
                                    ],
                                ])
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box box-solid">
                <div class="box-body">

                    <div class="record-info">

                        <?= $form->field($model, 'status')->dropDownList(EntityStatusEnum::listData(), ['class' => '']) ?>

                        <?= $form->field($model, 'entity')->textInput() ?>

                        <?= $form->field($model, 'entity_id')->textInput() ?>

                        <?= $form->field($model, 'parent_id')->textInput() ?>

                    </div>
                </div>
            </div>

        </div>

    <?php ActiveForm::end(); ?>

    </div>


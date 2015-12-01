<?php

/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
use yii\helpers\Html;

/*
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var dektrium\user\models\Profile $profile
 */

$this->title = Yii::t('user', 'Profile settings');
$this->params['breadcrumbs'][] = $this->title;
?>

<section class="section full-width-bg gray-bg">
	<?= $this->render('/_alert', ['module' => Yii::$app->getModule('user')])?>
	<div class="row">

		<div class="col-md-3">
        <?= $this->render('_menu')?>
    </div>
		<div class="col-md-9">
			<div class="panel panel-default">
				<div class="panel-heading">
                <?= Html::encode($this->title)?>
            </div>
				<div class="panel-body">
                <?php
                
$form = \yii\widgets\ActiveForm::begin([
                    'id' => 'profile-form',
                    'options' => [
                        'class' => 'form-horizontal'
                    ],
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-lg-9\">{input}</div>\n<div class=\"col-sm-offset-3 col-lg-9\">{error}\n{hint}</div>",
                        'labelOptions' => [
                            'class' => 'col-lg-3 control-label'
                        ]
                    ],
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => false,
                    'validateOnBlur' => false
                ]);
                ?>

                <?= $form->field($model, 'name')?>

                <?= $form->field($model, 'public_email')?>

                <?= $form->field($model, 'website')?>

                <?= $form->field($model, 'location')?>

                <?= $form->field($model, 'gravatar_email')->hint(\yii\helpers\Html::a(Yii::t('user', 'Change your avatar at Gravatar.com'), 'http://gravatar.com'))?>

                <?= $form->field($model, 'bio')->textarea()?>

                <div class="form-group">
						<div class="col-lg-offset-3 col-lg-9">
                        <?= \yii\helpers\Html::submitButton(Yii::t('user', 'Save'), ['class' => 'btn btn-block btn-success']) ?><br>
						</div>
					</div>

                <?php \yii\widgets\ActiveForm::end(); ?>
            </div>
			</div>
		</div>
	</div>
</section>


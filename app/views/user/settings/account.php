<?php

/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/*
 * @var $this yii\web\View
 * @var $form yii\widgets\ActiveForm
 * @var $model dektrium\user\models\SettingsForm
 */

$this->title = Yii::t('user', 'Account settings');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container user-module">
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
                
$form = ActiveForm::begin([
                    'id' => 'account-form',
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
                    'enableClientValidation' => false
                ]);
                ?>

                <?= $form->field($model, 'email')?>

                <?= $form->field($model, 'username')?>

                <?= $form->field($model, 'new_password')->passwordInput()?>

                <hr />

                <?= $form->field($model, 'current_password')->passwordInput()?>

                <div class="form-group">
						<div class="col-lg-offset-3 col-lg-9">
                        <?= Html::submitButton(Yii::t('user', 'Save'), ['class' => 'btn btn-block btn-success']) ?><br>
						</div>
					</div>

                <?php ActiveForm::end(); ?>
            </div>
			</div>
		</div>
	</div>
</div>

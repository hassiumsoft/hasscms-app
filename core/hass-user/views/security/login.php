<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Sign In';

$fieldOptions1 = [
    'options' => [
        'class' => 'form-group has-feedback'
    ],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => [
        'class' => 'form-group has-feedback'
    ],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>

<div class="login-box">
	<div class="login-logo">
		<a href="#"><b>HASS</b>CMS</a>
	</div>

	<?php if (Yii::$app->user->isGuest): ?>
	<!-- /.login-logo -->
	<div class="login-box-body">
                <?php $form = ActiveForm::begin([
                    'id'                     => 'login-form',
                    'enableAjaxValidation'   => true,
                    'enableClientValidation' => false,
                    'validateOnBlur'         => false,
                    'validateOnType'         => false,
                    'validateOnChange'       => false,
                ]) ?>

        <?=$form->field($model, 'login', $fieldOptions1)->label(false)->textInput(['placeholder' => $model->getAttributeLabel('login')])?>

        <?=$form->field($model, 'password', $fieldOptions2)->label(false)->passwordInput(['placeholder' => $model->getAttributeLabel('password')])?>

        <div class="row">
			<div class="col-xs-8">
                <?= $form->field($model, 'rememberMe')->checkbox()?>
            </div>
			<!-- /.col -->
			<div class="col-xs-4">
                <?= Html::submitButton('登录', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button'])?>
            </div>
			<!-- /.col -->
		</div>
        <?php ActiveForm::end(); ?>

	</div>
	<!-- /.login-box-body -->
	<?php else: ?>

    <?= Html::a(Yii::t('user', 'Logout'), ['/user/security/logout'], ['class' => 'btn btn-danger btn-block', 'data-method' => 'post']) ?>

    <?php endif ?>
</div>
<!-- /.login-box -->










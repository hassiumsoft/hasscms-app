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
use hass\authclient\widgets\AuthChoice;

/**
 *
 * @var yii\web\View $this
 * @var dektrium\user\models\LoginForm $model
 * @var dektrium\user\Module $module
 */

$this->title = Yii::t('user', '登录');
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="section full-width-bg gray-bg">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">

			<div class="panel panel-default panel-page">
				<div class="panel-heading">
					<h2 class="panel-title">
						<?= Html::encode($this->title)?>
					</h2>
				</div>
				<div class="panel-body">
                <?php
                
                $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => false,
                    'validateOnBlur' => false,
                    'validateOnType' => false,
                    'validateOnChange' => false
                ])?>

					<?= $form->field($model, 'login', ['options'=>["class"=>"form-group mb40"],'inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control', 'tabindex' => '1']])?>

					<?= $form->field($model, 'password', ['options'=>["class"=>"form-group mb40"],'inputOptions' => ['class' => 'form-control', 'tabindex' => '2']])->passwordInput()?>

					<div class="form-group ">
						<div class="controls pemember-password-wrap">
							<?= Html::submitButton(Yii::t('user', 'Sign in'), ['class' => 'btn btn-primary'])?>

							<span class="pemember-password text-muted">
								<?php echo Html::checkbox(Html::getInputName($model,'rememberMe'), Html::getAttributeValue($model, "rememberMe"),["id"=>Html::getInputId($model, "rememberMe")])?>
								<label for="<?php echo Html::getInputId($model, "rememberMe")?>"><?php echo Html::getAttributeName("rememberMe")?></label>
							</span>
						</div>
					</div>

					<?php ActiveForm::end(); ?>

					<div class="ptl mb40">
						<?php if ($module->enableConfirmation): ?>
						<?php echo Html::a(Yii::t('user', '忘记密码?'), ['/user/recovery/request']);?>
						<span class="text-muted mhs">|</span>
						<?php endif ?>

						<?php if ($module->enableRegistration): ?>
						<span class="text-muted">还没有注册帐号？</span>
						<?= Html::a(Yii::t('user', '立即注册'), ['/user/registration/register'])?>
						<span class="text-muted mhs">|</span>
						<?= Html::a(Yii::t('user', '激活邮件'), ['/user/registration/resend'])?>
						<?php endif ?>
					</div>

					<?=AuthChoice::widget(['baseAuthUrl' => ['/user/security/auth']])?>
				</div>
			</div>

		</div>
	</div>
</section>

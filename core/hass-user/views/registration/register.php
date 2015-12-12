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

/**
 *
 * @var yii\web\View $this
 * @var dektrium\user\models\User $user
 * @var dektrium\user\Module $module
 */

$this->title = Yii::t('user', '注册');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container user-module">
	<div class="row">
		<div class="col-md-6 col-md-offset-3 ">
			<div class="panel panel-default panel-page">
				<div class="panel-heading">
					<h2 class="panel-title"><?= Html::encode($this->title) ?></h2>
				</div>
				<div class="panel-body">
                <?php
                
                $form = ActiveForm::begin([
                    'id' => 'registration-form',
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => false
                ]);
                ?>

                <?= $form->field($model, 'email',['options'=>["class"=>"form-group mb40"]])?>

                <?= $form->field($model, 'username',['options'=>["class"=>"form-group mb40"]])?>

                <?php if ($module->enableGeneratingPassword == false): ?>
                    <?= $form->field($model, 'password',['options'=>["class"=>"form-group mb40"]])->passwordInput()?>
                <?php endif ?>

                <?= Html::submitButton(Yii::t('user', 'Sign up'), ['class' => 'btn btn-success btn-block mb40'])?>

                <?php ActiveForm::end(); ?>

                			<p class="text-center">
            <?= Html::a(Yii::t('user', 'Already registered? Sign in!'), ['/user/security/login'])?>
        </p>
				</div>
			</div>

		</div>
	</div>
</div>

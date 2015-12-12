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
 * @var yii\widgets\ActiveForm $form
 * @var dektrium\user\models\User $model
 * @var dektrium\user\models\Account $account
 */

$this->title = Yii::t('user', 'Sign in');
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
					<div class="alert alert-info">
						<p>
                        <?= Yii::t('user', 'In order to finish your registration, we need you to enter following fields') ?>:
                    </p>
					</div>
                <?php
                
                $form = ActiveForm::begin([
                    'id' => 'connect-account-form'
                ]);
                ?>

                <?= $form->field($model, 'email')?>

                <?= $form->field($model, 'username')?>

                <?= Html::submitButton(Yii::t('user', 'Continue'), ['class' => 'btn btn-success btn-block'])?>

                <?php ActiveForm::end(); ?>

                        <p class="text-center">
            <?= Html::a(Yii::t('user', 'If you already registered, sign in and connect this account on settings page'), ['/user/settings/networks']) ?>.
        </p>
				</div>
			</div>
		</div>
	</div>
</div>


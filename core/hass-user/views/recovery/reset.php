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
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var dektrium\user\models\RecoveryForm $model
 */

$this->title = Yii::t('user', 'Reset your password');
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
                        'id' => 'password-recovery-form',
                        'enableAjaxValidation' => true,
                        'enableClientValidation' => false
                    ]);
                    ?>

                    <?= $form->field($model, 'password')->passwordInput()?>

                    <?= Html::submitButton(Yii::t('user', 'Finish'), ['class' => 'btn btn-success btn-block'])?>
                    <br>

                    <?php ActiveForm::end(); ?>
                </div>
			</div>
		</div>
	</div>
</div>

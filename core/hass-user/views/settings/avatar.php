<?php

/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
use yii\helpers\Html;
use hass\user\assets\AvatarUploadAsset;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 *
 * @var yii\web\View $this
 * @var dektrium\user\models\User $user
 * @var dektrium\user\models\Profile $profile
 */
AvatarUploadAsset::register($this);

$this->registerJs("var uploadUrl='" . Url::to([
    "/frontend/attachment/create-temp",
    'fileparam' => "avatar"
]) . "'", View::POS_HEAD);

$this->title = Yii::t('user', '头像');
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
					<div class="row">
						<div class="col-md-6">
							<div id="upload-avatar-wrapper">
								<div class="avatar-item">
									<?php echo Html::img($user->getAvatar(200,200),["class"=>"avatar-uploader"])?>
								</div>
								<input type="hidden" name="cx" id="crop-x" /> <input
									type="hidden" name="cy" id="crop-y" /> <input type="hidden"
									name="cw" id="crop-w" /> <input type="hidden" name="ch"
									id="crop-h" />
							</div>
							<div class="row">
								<div class="col-md-6">
									<div id="plupload-browse-button" class="upload-kit-input">
										<input type="button" value="上传头像"
											class="btn btn-danger btn-block" /> <input type="file"
											name="avatar" id="uploadFileInput" multiple="multiple" />
									</div>
								</div>
								<div class="col-md-6">
<?php
$form = ActiveForm::begin([
    'options' => [
        'enctype' => 'multipart/form-data',
        'class' => 'avatar-form'
    ]
]);
?>
									<div class="form-group">
										<?= Html::submitButton( Yii::t('hass', '保存'), ['class' => 'btn btn-primary btn-block',"id"=>"saveAvatarButton"])?>
									</div>
									<?php ActiveForm::end(); ?>
								</div>
							</div>
						</div>
						<div class="col-md-6"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>



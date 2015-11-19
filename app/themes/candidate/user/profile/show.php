<?php
/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
use yii\helpers\Html;

/**
 *
 * @var \yii\web\View $this
 * @var \dektrium\user\models\Profile $profile
 */

$this->title = empty($profile->name) ? Html::encode($profile->user->username) : Html::encode($profile->name);
$this->params['breadcrumbs'][] = $this->title;
?>

<section class="section full-width-bg gray-bg">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="cover-photo">
				<img src="<?php echo $profile->getUser()->one()->getAvatar()?>"
					class="profile-photo img-thumbnail show-in-modal">
				<div class="cover-name"><?= Html::encode($this->title) ?></div>
			</div>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="panel-options">
				<div class="navbar navbar-default navbar-cover">
					<div class="container-fluid">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle collapsed"
								data-toggle="collapse" data-target="#profile-opts-navbar">
								<span class="sr-only">Toggle navigation</span> <span
									class="icon-bar"></span> <span class="icon-bar"></span> <span
									class="icon-bar"></span>
							</button>
						</div>
						<div class="collapse navbar-collapse" id="profile-opts-navbar">
							<ul class="nav navbar-nav navbar-right">


							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>




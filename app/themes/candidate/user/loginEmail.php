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
 * @var yii\web\View $this
 * @var dektrium\user\Module $module
 * @var string $email
 */

$this->title = $title;

?>

<section class="section full-width-bg gray-bg">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<?=$this->render('/_alert', ['module' => $module])?>
		
			<div class="panel panel-default panel-page">
				<div class="panel-heading">
					<h2 class="panel-title"><?= Html::encode($this->title) ?></h2>
				</div>
				<div class="panel-body">
					<p>
						请到 <span class="text-success"><?php echo $email;?></span>
						查阅来自我的网络的邮件,进行你的下一步操作.
					</p>
					<p>
						<a class="btn btn-primary" href="<?php echo $emailFacilitator;?>"
							target="_blank">登录邮箱查收邮件</a>
					</p>

				</div>
			</div>
		</div>
	</div>
</section>
<?php
use yii\helpers\Html;
use yii\helpers\Url;
use hass\backend\Module;
use hass\backend\widgets\Nav;

/** @var \hass\backend\Module $module */
$module = \hass\backend\Module::getInstance();
?>

<header class="main-header">
    <?= Html::a(\hass\backend\Module::HASS_CMS_NAME,\Yii::$app->getHomeUrl(), ['class' => 'logo'])?>
	<?= Html::a(substr(\hass\backend\Module::HASS_CMS_NAME, 0,1),\Yii::$app->getHomeUrl(), ['class' => 'sidebar-logo logo'])?>
    <nav class="navbar navbar-static-top" role="navigation">

		<a href="#" class="sidebar-toggle" data-toggle="offcanvas"
			role="button"> <span class="sr-only">Toggle navigation</span>
		</a>

		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">
				<li><a href="<?php echo $module->getWebUrl();?>" target="_blank"><i
						class="fa  fa-home"></i></a></li>

				<li class="dropdown user user-menu"><a href="#"
					class="dropdown-toggle" data-toggle="dropdown"> <img
						src="<?php echo $module->getUserAvator();?>" class="user-image"
						alt="User Image" /> <span class="hidden-xs"><?php echo  $module->getUserName();?></span>
				</a>
					<ul class="dropdown-menu">
						<!-- User image -->
						<li class="user-header"><img
							src="<?php echo  $module->getUserAvator();?>" class="img-circle"
							alt="User Image" />

							<p>
                               <?php echo  $module->getUserName();?> - <?php echo  $module->getUserRole();?>
                                <small>注册时间:<?php echo  $module->getUserCreatedDate();?></small>
							</p></li>

						<!-- Menu Footer-->
						<li class="user-footer">
							<div class="pull-left">
                            <?=Html::a ( '个人资料', $module->getUserProfileUrl(), [ 'data-method' => 'post','class' => 'btn btn-default btn-flat' ] )?>
                            </div>
							<div class="pull-right">
                                <?=Html::a ( '登出', [ '/user/security/logout' ], [ 'data-method' => 'post','class' => 'btn btn-default btn-flat' ] )?>
                            </div>
						</li>
					</ul></li>
				<li><a href="<?php echo Url::to( [ '/user/security/logout' ])?>"
					data-method='post'><i class="fa  fa-sign-out"></i></a></li>

			</ul>
		</div>

		<div class="navbar-header">
			<button class="btn btn-default  btn-sm navbar-toggle collapsed"
				type="button" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="caret"></span>
			</button>
		</div>

		<div class="navbar-collapse collapse" role="navigation">
		<?php
echo Nav::widget([
    'items' => $module->getNavbar(),
    'options' => [
        'class' => ' navbar-nav'
    ]
])?>
		</div>


	</nav>
</header>

<?php
/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
use yii\widgets\Menu;

/** @var dektrium\user\models\User $user */
$user = Yii::$app->user->identity;
$networksVisible = count(Yii::$app->authClientCollection->clients) > 0;

?>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">
			<img src="<?php echo $user->getAvatar(24,24)?>" class="img-rounded"
				alt="<?= $user->username ?>" />
            <?= $user->username?>
        </h3>
	</div>
	<div class="panel-body">
        <?=Menu::widget(['options' => ['class' => 'nav nav-pills nav-stacked'],'items' => [['label' => Yii::t('user', 'Profile'),'url' => ['/user/settings/profile']],['label' => Yii::t('hass', '头像'),'url' => ['/user/settings/avatar']],['label' => Yii::t('user', 'Account'),'url' => ['/user/settings/account']],['label' => Yii::t('user', 'Networks'),'url' => ['/user/settings/networks'],'visible' => $networksVisible]]])?>
    </div>
</div>

<?php

/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
use hass\authclient\widgets\AuthChoice;
use yii\helpers\Html;

/*
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 */

$this->title = Yii::t('user', 'Networks');
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

                <?php
                $auth = AuthChoice::begin([
                    'baseAuthUrl' => [
                        '/user/security/auth'
                    ],
                    'accounts' => $user->accounts,
                    'autoRender' => false,
                    'popupMode' => false
                ])?>
                <table class="table">
                    <?php foreach ($auth->getClients() as $client): ?>
                        <tr>
							<td style="width: 32px; vertical-align: middle">
                                <?= Html::tag('span', '', ['class' => 'auth-icon ' . $client->getName()])?>
                            </td>
							<td style="vertical-align: middle"><strong><?= $client->getTitle() ?></strong>
							</td>
							<td style="width: 120px">
                                <?=$auth->isConnected($client) ? Html::a(Yii::t('user', 'Disconnect'), $auth->createClientUrl($client), ['class' => 'btn btn-danger btn-block','data-method' => 'post']) : Html::a(Yii::t('user', 'Connect'), $auth->createClientUrl($client), ['class' => 'btn btn-success btn-block'])?>
                            </td>
						</tr>
                    <?php endforeach; ?>
                </table>
                <?php AuthChoice::end()?>
            </div>
			</div>
		</div>
	</div>
</div>


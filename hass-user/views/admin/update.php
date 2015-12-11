<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use dektrium\user\models\User;
use yii\bootstrap\Nav;
use yii\web\View;

/**
 * @var View 	$this
 * @var User 	$user
 * @var string 	$content
 */

$this->title = Yii::t('hass', '修改用户');
$this->params['breadcrumbs'][] = ['label' => Yii::t('hass', '用户列表'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>


<div class="row">
    <div class="col-md-3">
        <div class="box box-solid">
            <div class="box-body no-padding">
                <?= Nav::widget([
                    'options' => [
                        'class' => 'nav nav-pills nav-stacked',
                    ],
                    'items' => [
                        ['label' => '<i class="fa fa-user"></i> '.Yii::t('hass', 'Account details'), 'url' => ['/user/admin/update', 'id' => $user->id],'encode'=>false],
                        ['label' => '<i class="fa fa-file-text-o"></i> '.Yii::t('hass', 'Profile details'), 'url' => ['/user/admin/update-profile', 'id' => $user->id],'encode'=>false],
                        ['label' => '<i class="fa  fa-info-circle"></i> '.Yii::t('hass', 'Information'), 'url' => ['/user/admin/info', 'id' => $user->id],'encode'=>false],
                        [
                        'label' => Yii::t('hass', 'Assignments'),
                        'url' => ['/user/admin/assignments', 'id' => $user->id],
                        'visible' => Yii::$app->getModule("rbac"),
                        ],
                    
                    ],
                ]) ?>
            </div>
        </div>

         <div class="box box-solid">
            <div class="box-body no-padding">
                <?= Nav::widget([
                    'options' => [
                        'class' => 'nav nav-pills nav-stacked',
                    ],
                    'items' => [
                        [
                            'label' => '<i class="fa fa-hand-paper-o"></i> '.Yii::t('hass', 'Confirm'),
                            'url'   => ['/user/admin/confirm', 'id' => $user->id],
                            'visible' => !$user->isConfirmed,
                            'linkOptions' => [
                                'class' => 'text-success',
                                'data-method' => 'post',
                                'data-confirm' => Yii::t('hass', 'Are you sure you want to confirm this user?'),
                            ],
                                'encode'=>false
                        ],
                        [
                            'label' => '<i class="fa   fa-ban "></i> '.Yii::t('hass', 'Block'),
                            'url'   => ['/user/admin/block', 'id' => $user->id],
                            'visible' => !$user->isBlocked,
                            'linkOptions' => [
                                'class' => 'text-danger',
                                'data-method' => 'post',
                                'data-confirm' => Yii::t('hass', 'Are you sure you want to block this user?'),
                            ],
                            'encode'=>false
                        ],
                        [
                            'label' => '<i class="fa fa-check"></i> '.Yii::t('hass', 'Unblock'),
                            'url'   => ['/user/admin/block', 'id' => $user->id],
                            'visible' => $user->isBlocked,
                            'linkOptions' => [
                                'class' => 'text-success',
                                'data-method' => 'post',
                                'data-confirm' => Yii::t('hass', 'Are you sure you want to unblock this user?'),
                            ],
                            'encode'=>false
                        ],
                        [
                            'label' =>'<i class="fa fa-trash-o"></i> '. Yii::t('hass', 'Delete'),
                            'url'   => ['/user/admin/delete', 'id' => $user->id],
                            'linkOptions' => [
                                'class' => 'text-danger',
                                'data-method' => 'post',
                                'data-confirm' => Yii::t('hass', 'Are you sure you want to delete this user?'),
                            ],
                            'encode'=>false
                        ],
                    ],
                ]) ?>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="box box-solid">
            <div class="box-body">
                <?= $content ?>
            </div>
        </div>
    </div>
</div>

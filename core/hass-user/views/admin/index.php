<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */
use dektrium\user\models\UserSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\jui\DatePicker;

use hass\base\helpers\ArrayHelper;
/**
 *
 * @var View $this
 * @var ActiveDataProvider $dataProvider
 * @var UserSearch $searchModel
 */

$this->title = Yii::t('hass', 'Manage users');
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->beginBlock('content-header'); ?>
<h1>
	<?php echo $this->title?>
	<a class="btn bg-purple btn-flat btn-xs "
		href="<?= Url::to(['create']) ?>"> <?= Yii::t('hass', '新用户')?>
	</a>
</h1>
<?php $this->endBlock(); ?>


<div class="box box-solid">
	<div class="box-body no-padding">
        <?php
        echo GridView::widget([
            'layout' => "{items}",
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'filterPosition' => GridView::FILTER_POS_HEADER,
            "tableOptions" => [
                'class' => 'table table-hover table-striped no-margin'
            ],
            "columns" => [
                [
                   'attribute' => 'username',
                    "format"=>"html",
                    'value'=>function($model, $key, $index, $column)
                    {
                         $params = is_array($key) ? $key : ['id' => (string) $key];
                         $params[0] = "update";
                         $value =  ArrayHelper::getValue($model, $column->attribute);
                         return Html::a($value,$params);
                    }
                ],
                'email:email',
                [
                    'attribute' => 'registration_ip',
                    'value' => function ($model) {
                        return $model->registration_ip == null ? '<span class="not-set">' . Yii::t('user', '(not set)') . '</span>' : $model->registration_ip;
                    },
                    'format' => 'html'
                ],
                [
                    'attribute' => 'created_at',
                    'value' => function ($model) {
                        if (extension_loaded('intl')) {
                            return Yii::t('user', '{0, date, MMMM dd, YYYY HH:mm}', [
                                $model->created_at
                            ]);
                        } else {
                            return date('Y-m-d G:i:s', $model->created_at);
                        }
                    },
                    'filter' => DatePicker::widget([
                        'model' => $searchModel,
                        'attribute' => 'created_at',
                        'dateFormat' => 'php:Y-m-d',
                        'options' => [
                            'class' => 'form-control'
                        ]
                    ])
                ],
                [
                    'header' => Yii::t('user', 'Confirmation'),
                    'value' => function ($model) {
                        if ($model->isConfirmed) {
                            return '<div class="text-center"><span class="text-success">' . Yii::t('user', 'Confirmed') . '</span></div>';
                        } else {
                            return Html::a(Yii::t('user', 'Confirm'), [
                                'confirm',
                                'id' => $model->id
                            ], [
                                'class' => 'btn btn-xs btn-success btn-block',
                                'data-method' => 'post',
                                'data-confirm' => Yii::t('user', 'Are you sure you want to confirm this user?')
                            ]);
                        }
                    },
                    'format' => 'raw',
                    'visible' => Yii::$app->getModule('user')->enableConfirmation
                ],
                [
                    'header' => Yii::t('user', 'Block status'),
                    'value' => function ($model) {
                        if ($model->isBlocked) {
                            return Html::a(Yii::t('user', 'Unblock'), [
                                'block',
                                'id' => $model->id
                            ], [
                                'class' => 'btn btn-xs btn-success btn-block',
                                'data-method' => 'post',
                                'data-confirm' => Yii::t('user', 'Are you sure you want to unblock this user?')
                            ]);
                        } else {
                            return Html::a(Yii::t('user', 'Block'), [
                                'block',
                                'id' => $model->id
                            ], [
                                'class' => 'btn btn-xs btn-danger btn-block',
                                'data-method' => 'post',
                                'data-confirm' => Yii::t('user', 'Are you sure you want to block this user?')
                            ]);
                        }
                    },
                    'format' => 'raw'
                ],
                [
                    'class' => 'hass\base\misc\grid\ActionColumn',
                    'template' => "{update} {delete}"
                ]
            ]
        ]
        );
        ?>
	</div>
	<div class="box-footer">
		<div class="box-tools pull-right">
			<?=yii\widgets\LinkPager::widget(['pagination' => $dataProvider->pagination,'options'=>['class' => 'pagination pagination-sm inline']])?>
		</div>
	</div>
</div>















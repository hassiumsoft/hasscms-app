<?php
/**
 * @var View $this
 * @var SourceMessageSearch $searchModel
 * @var ActiveDataProvider $dataProvider
 */
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use hass\i18n\models\SourceMessageSearch;
use hass\i18n\models\SourceMessage;
use hass\i18n\Module;
use hass\base\misc\grid\ActionColumn;
use hass\i18n\assets\I18nAsset;
use yii\helpers\Url;


I18nAsset::register($this);

$this->title = Module::t('Translations');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-solid">
	<div class="box-body no-padding">
    <?php
    
    echo GridView::widget([
        'layout' => "{items}",
        'filterModel' => $searchModel,
        'dataProvider' => $dataProvider,
        "tableOptions" => [
            'class' => 'table table-hover table-striped no-margin'
        ],
        'columns' => [
            [
                'attribute' => 'message',
                'format' => 'raw',
                'contentOptions' => [
                    'class' => 'source-message',
                ],
                'value' => function ($model, $index, $widget) {
                    return Html::a($model->message, [
                        'update',
                        'id' => $model->id
                    ],["class"=>"source-message-content"]);
                }
            ],
            [
                'class' => ActionColumn::className(),
                'header' => '<i class="fa fa-copy"></i>',
                'template' => '{copy}',
                'headerOptions' => [
                    'width' => '30'
                ],
                'buttons' => [
                    'copy' => function ($url, $model, $key) {
                        return Html::a('<i class="fa fa-arrow-right "></i>', 'javascript:void(0);', [
                            'class' => 'btn btn-xs btn-default btn-translation-copy-from-source',
                            'title' => Module::t('Copy from source message')
                        ]);
                    }
                ]
            ],
            [
                'attribute' => 'messages',
                'headerOptions' => [
                    'width' => '400'
                ],
                'contentOptions' => [
                    'class' => 'tabs-mini'
                ],
                'value' => function ($model, $key, $index, $column) {
                    return $this->render('_message-tabs', [
                        'model' => $model,
                        'key' => $key,
                        'index' => $index,
                        'column' => $column
                    ]);
                },
                'format' => 'raw'
            ],
            [
                'attribute' => 'category',
                'headerOptions' => [
                    'width' => '150'
                ],
                'contentOptions' => [
                    'class' => 'text-align-center'
                ],
                'value' => function ($model, $key, $index, $dataColumn) {
                    return $model->category;
                },
                'filter' => ArrayHelper::map($searchModel::getCategories(), 'category', 'category')
            ],
            [
                'attribute' => 'status',
                'headerOptions' => [
                    'width' => '150',
                ],
                'contentOptions' => [
                    'class' => 'text-align-center',
                ],
                'value' => function ($model, $index, $widget) {
                    /** @var SourceMessage $model */
                    return $model->isTranslated() ? 'Translated' : 'Not translated';
                },
                'filter' => $searchModel->getStatus()
            ],
            [
                'class' => ActionColumn::className(),
                'template' => '{save} ',
                'buttons' => [
                    'save' => function ($url, $model, $key) {
                        return Html::a('<i class="glyphicon glyphicon-download"></i> ' . Module::t('Save'), 'javascript:void(0);' , [
                            'class' => 'btn btn-xs btn-success btn-translation-save',
                            "data-url"=>Url::to(["update","id"=>$model->primaryKey])
                        ]);
                    }
                ]
            ]
        ]
    ]);
    ?>
	</div>
	<div class="box-footer">
		<div class="box-tools pull-right">
			<?=yii\widgets\LinkPager::widget(['pagination' => $dataProvider->pagination,'options'=>['class' => 'pagination pagination-sm inline']])?>
		</div>
	</div>
</div>
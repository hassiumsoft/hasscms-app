<?php
/**
 *
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
use yii\grid\GridView;
use yii\helpers\Html;
use hass\helpers\ArrayHelper;
use hass\backend\enums\StatusEnum;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
$this->title = Yii::t('hass', '模块管理');
/**
 *
 * @var $this \yii\web\View
 */
/**
 *
 * @var $model \hass\backend\ActiveRecord
 */
/**
 *
 * @var $dataProvider \yii\data\ActiveDataProvider
 */
?>
<div class="row">
	<div class="col-md-4">
	   <?php echo $this->render("_form",["model"=>$model])?>
	</div>
	<div class="col-md-8">
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
                    'attribute' => 'name',
                    "format" => "html",
                    'value' => function ($model, $key, $index, $column) {
                        $params = is_array($key) ? $key : [
                            'id' => (string) $key
                        ];
                        $params[0] = "update";
                        $value = ArrayHelper::getValue($model, $column->attribute);
                        return Html::a($value, $params);
                    }
                ],
                'title',
                [
                    'attribute' => 'icon',
                    "format" => "html",
                    'value' => function ($model, $key, $index, $column) {

                        $value = ArrayHelper::getValue($model, $column->attribute);
                        return Html::tag('i', "", [
                            "class" => $value . " fa"
                        ]);
                    }
                ],

                [
                    'class' => 'hass\extensions\grid\SwitcherColumn',
                    'attribute' => 'status',
                    'filter' => StatusEnum::listData()
                ],
                [
                    'class' => 'hass\extensions\grid\ActionColumn',
                    'template' => "{up} {down} {update} {delete}"
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


	</div>
</div>

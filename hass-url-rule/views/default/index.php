<?php
use yii\grid\GridView;
use yii\helpers\Html;
use hass\base\helpers\ArrayHelper;

/**
 *
 * @var $this \yii\web\View
 */
/**
 *
 * @var $model \hass\base\ActiveRecord
 */
/**
 *
 * @var $dataProvider \yii\data\ActiveDataProvider
 */

$this->title = '路由规则';
$this->params['breadcrumbs'][] = $this->title;

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
            'id',
            [
                'attribute' => 'pattern',
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
            'route',
            'defaults',

            [
                'class' => 'hass\base\misc\grid\ActionColumn',
                "urlCreator" => function ($action, $model, $key, $index) {
                    if ($action != "view") {
                        return null;
                    }

                    $route = $model->route;
                    parse_str($model->defaults, $params);
                    array_unshift($params, $route);
                    return \Yii::$app->get("appUrlManager")->createUrl($params);
                }
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



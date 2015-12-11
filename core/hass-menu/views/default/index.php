<?php

use yii\grid\GridView;
use yii\helpers\Html;
use hass\base\helpers\ArrayHelper;
use hass\base\enums\StatusEnum;

/* @var $this yii\web\View */
/* @var $model hass\menu\models\Menu */
/* @var $searchModel hass\menu\models\MenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Menus';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
	<div class="col-md-4">
		<?php echo $this->render("_form",["model"=>$model,"parentId"=>null])?>
	</div>
	<div class="col-md-8">


<div class="box box-solid">
	<div class="box-body no-padding">
        <?php
        echo GridView::widget([
            'layout' => "{items}",
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'filterPosition'=>GridView::FILTER_POS_HEADER,
            "tableOptions"=>['class' => 'table table-hover table-striped no-margin'],
            "columns"=>[
                [
                   'attribute' => 'name',
                    "format"=>"html",
                    'value'=>function($model, $key, $index, $column)
                    {
                         $params = is_array($key) ? $key : ['id' => (string) $key];
                         $params[0] = "update";
                         $value =  ArrayHelper::getValue($model, $column->attribute);
                         return Html::a($value,$params);
                    }
                ],
                'slug',
                [
                    'class' => 'hass\base\misc\grid\SwitcherColumn',
                    'attribute' => 'status',
                    'filter'=>StatusEnum::listData()
                ],
                [
                    'class' => 'hass\base\misc\grid\ActionColumn'
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

	</div>
</div>
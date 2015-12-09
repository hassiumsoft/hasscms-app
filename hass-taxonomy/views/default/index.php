<?php

use yii\grid\GridView;
use yii\helpers\Html;
use hass\base\helpers\ArrayHelper;
use hass\base\enums\StatusEnum;


/* @var $this yii\web\View */
/* @var $searchModel hass\taxonomy\models\TaxonomySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Taxonomies';
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
                'taxonomy_id',
                [
                   'attribute' => 'name',
                    "format"=>"html",
                    'value'=>function($model, $key, $index, $column)
                    {
                         $params = is_array($key) ? $key : ['id' => (string) $key];
                         $params[0] = "update";
                         $value =  ArrayHelper::getValue($model, $column->attribute);

                         $options = [];

                         if($model->depth == 0)
                         {
                            $options['style']="color:#000;font-weight:bold";
                            $value .= "[根]";
                         }

                         return Html::a($value,$params,$options);
                    }
                ],
        
                'slug',
                [
                    'class' => 'hass\base\misc\grid\SwitcherColumn',
                    'attribute' => 'status',
                    'filter'=>StatusEnum::listData()
                ],
                [
                    'class' => 'hass\base\misc\grid\ActionColumn',
                    "template"=>"{add-child} {update} {delete} {up} {down} ",
                    "buttons"=>["add-child"=>function($url){
                            return Html::a('<span class="glyphicon glyphicon-plus"></span>', $url,['class'=>"btn btn-default btn-xs","title"=>\Yii::t("hass", "增加子类")]);
                    }]
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
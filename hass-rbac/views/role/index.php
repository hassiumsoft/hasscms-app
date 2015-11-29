<?php
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel hass\taxonomy\models\TaxonomySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户组';
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
            "tableOptions" => [
                'class' => 'table table-hover table-striped no-margin'
            ],
            "columns" => [
                [
                    'attribute' => 'name',
                    "format" => "html"
                ],
                'description',
                [
                    'class' => 'hass\base\misc\grid\ActionColumn',
                    "template" => "{permissions} {update} {delete} ",
                    "buttons" => [
                        "permissions" => function ($url) {
                            return Html::a('<span class="glyphicon glyphicon-plus"></span>', $url, [
                                'class' => "btn btn-default btn-xs",
                                "title" => \Yii::t("hass", "权限管理")
                            ]);
                        }
                    ]
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
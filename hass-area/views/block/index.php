<?php
use yii\helpers\Url;
use yii\grid\GridView;
use yii\helpers\Html;
use hass\base\helpers\ArrayHelper;

/**
 * @var $this \yii\web\View
 */
/**
 * @var $model \hass\base\ActiveRecord
 */
/**
 * @var $dataProvider \yii\data\ActiveDataProvider
 */

$this->title = 'Blocks';
$this->params['breadcrumbs'][] = $this->title;

?>

<?php $this->beginBlock('content-header'); ?>
<h1>
	<?php echo $this->title?> <a class="btn bg-purple btn-flat btn-xs "
		href="<?= Url::to(['create']) ?>"> <?= Yii::t('hass', '新区块') ?>
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
            'filterPosition'=>GridView::FILTER_POS_HEADER,
            "tableOptions"=>['class' => 'table table-hover table-striped no-margin'],
            "columns"=>[
                'block_id',
                [
                   'attribute' => 'title',
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
                    'class' => 'hass\base\misc\grid\ActionColumn',
                    'template'=>"{update} {delete}"
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
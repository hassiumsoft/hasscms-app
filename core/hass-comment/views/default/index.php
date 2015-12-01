<?php
/**
 *
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use hass\base\helpers\ArrayHelper;
use hass\base\enums\StatusEnum;
/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */
/**
 * @var $this \yii\web\View
 */
/**
 * @var $model \hass\base\ActiveRecord
 */
/**
 * @var $dataProvider \yii\data\ActiveDataProvider
 */
$this->title = Yii::t('hass', '评论');
$this->params['breadcrumbs'][] = $this->title;
?>


<?php $this->beginBlock('content-header'); ?>
<h1>
	<?php echo $this->title?> <a class="btn bg-purple btn-flat btn-xs "
		href="<?= Url::to(['/comment/default/create']) ?>"><?= Yii::t('hass', '新评论') ?></a>
</h1>
<?php $this->endBlock(); ?>


<div class="box box-solid">
    <div class="box-header with-border">
        <h3 class="box-title">
                             评论列表
        </h3>
    </div>
	<div class="box-body no-padding">

	 <?php
        echo GridView::widget([
            'layout' => "{items}",
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'filterPosition'=>GridView::FILTER_POS_HEADER,
            "tableOptions"=>['class' => 'table table-hover table-striped no-margin'],
            "columns"=>[
                'comment_id',
                [
                   'attribute' => 'content',
                    "format"=>"html",
                    'value'=>function($model, $key, $index, $column)
                    {
                         $params = is_array($key) ? $key : ['id' => (string) $key];
                         $params[0] = "update";
                         $value =  ArrayHelper::getValue($model, $column->attribute);
                         return Html::a($value,$params);
                    }
                ],
                'email',
                'username',
                'user_ip',
                [
                    'attribute' => 'created_at',
                    'value' =>'createdDateTime'
                ],
                [
                    'label'=>"源",
                    'value'=>function($model, $key, $index, $column)
                    {
                        return ArrayHelper::getValue($model, 'entity');
                    }
                ],
                [
                    'class' => 'hass\base\misc\grid\SwitcherColumn',
                    'attribute' => 'status',
                    'filter'=>StatusEnum::listData()
                ],
                [
                    'class' => 'hass\base\misc\grid\ActionColumn',
                    "template"=>'{update} {delete}'
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




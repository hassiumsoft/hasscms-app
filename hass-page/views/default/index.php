<?php
/**
 *
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
use yii\helpers\Url;
use yii\grid\GridView;
use yii\helpers\Html;
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

$this->title = Yii::t('hass', '所有页面');
$this->params['breadcrumbs'][] = $this->title;
?>


<?php $this->beginBlock('content-header'); ?>
<h1>
	<?php echo $this->title?> <a class="btn bg-purple btn-flat btn-xs "
		href="<?= Url::to(['create']) ?>"> <?= Yii::t('hass', '新建页面') ?>
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
                'id',
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
                [
                    'attribute' => 'published_at',
                    'value' =>'publishedDateTime'
                ],
                [
                    'class' => 'hass\base\misc\grid\SwitcherColumn',
                    'attribute' => 'status',
                    'filter'=>StatusEnum::listData()
                ],
                [
                    'class' => 'hass\base\misc\grid\ActionColumn',
                    'urlCreator'=>function($action, $model, $key, $index,$column)
                    {
                        if($action =="view")
                        {
                            $params = is_array($key) ? $key : ['id' => (string) $key];
                            $params[0] ="/page/view";
                            return \Yii::$app->get("appUrlManager")->createUrl($params);
                        }
                    },
                    'template'=>'{up} {down} {view} {update} {delete}'
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
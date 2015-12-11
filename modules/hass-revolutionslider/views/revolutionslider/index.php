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
/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
/**
 *
 * @var $this \yii\web\View
 */
/**
 *
 * @var $model \hass\module\ActiveRecord
 */
/**
 *
 * @var $dataProvider \yii\data\ActiveDataProvider
 */

$this->title = Yii::t('hass', '所有幻灯片');
$this->params['breadcrumbs'][] = $this->title;
?>


<?php $this->beginBlock('content-header'); ?>
<h1>
	<?php echo $this->title?> <a class="btn bg-purple btn-flat btn-xs "
		href="<?= Url::to(['create']) ?>"> <?= Yii::t('hass', '新建幻灯片')?>
	</a>
</h1>
<?php $this->endBlock(); ?>

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
                'revolutionslider_id',
                [
                    'attribute' => 'thumbnail',
                    "format" => "html",
                    'value' => function ($model, $key, $index, $column) {
                        /*@var $attachment \hass\attachment\models\Attachment */

                        if (($attachment = $model->thumbnail)) {
                            return Html::img($attachment->getThumb(200, 100));
                        }

                        return "";
                    }
                ],
                [
                    'class' => 'hass\base\misc\grid\ActionColumn',
                    'template' => '{up} {down} {update} {delete}'
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
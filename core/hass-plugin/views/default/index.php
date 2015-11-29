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
use hass\backend\enums\BooleanEnum;
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
 * @var $model \hass\backend\ActiveRecord
 */
/**
 *
 * @var $dataProvider \yii\data\ActiveDataProvider
 */

$this->title = Yii::t('hass', '插件');
$this->params['breadcrumbs'][] = $this->title;
?>


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
                'name',
                'description',
                'version',
                [
                    'attribute' => 'authors',
                    "format" => "html",
                    'value' => function ($model, $key, $index, $column) {
                        return $model->getFormatAuthors();
                    }
                ],
                [
                    'class' => 'hass\extensions\grid\SwitcherColumn',
                    'label' => "开启",
                    "value" => function ($model, $key, $index, $column) {
                        return $model->getModel()->status;
                    },
                    "cellVisible" => function ($model, $key, $index, $column) {
                        if ($model->getModel()->installed == BooleanEnum::TRUE) {
                            return true;
                        }

                        return "先安装插件";
                    }
                ],
                [
                    'label' => "操作",
                    "format" => "html",
                    "value" => function ($model, $key, $index, $column) {
                        $result = "";
                        if ($model->getModel()->installed == BooleanEnum::TRUE && $model->getModel()->status == StatusEnum::STATUS_OFF) {
                            $result .= Html::a("卸载", [
                                "uninstall",
                                'id' => $model->getPackage()
                            ]);
                        }

                        if ($model->getModel()->installed == BooleanEnum::FLASE) {
                            $result .= Html::a("安装", [
                                "install",
                                'id' => $model->getPackage()
                            ]);
                            $result .= "&nbsp;&nbsp;" . Html::a("删除", [
                                "delete",
                                'id' => $model->getPackage()
                            ]);
                        }
                        if ($model->getHomepage()) {
                            $result .= "&nbsp;&nbsp;" . Html::a("插件主页", $model->getHomepage());
                        }
                        return $result;
                    }
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
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
 * @var $model hass\module\classes\ModuleInfo
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
                    'class' => 'hass\base\misc\grid\SwitcherColumn',
                    'label' => "开启",
                    "value" => function ($model, $key, $index, $column) {
                        
                        if ($model->isCoreModule()) {
                            return "系统模块";
                        }
                        
                        if ($model->installed() == false) {
                            return "请先安装模块";
                        }
                        return $model->enabled();
                    }
                ],
                [
                    'label' => "操作",
                    "format" => "raw",
                    "value" => function ($model, $key, $index, $column) {
                        $result = "";
                        if ($model->canUninstall()) {
                            $result .= Html::a("卸载", [
                                "uninstall",
                                'id' => $model->getPackage()
                            ], [
                                "data-confirm" => "您确定要卸载此模块吗？",
                                "data-method" => "post"
                            ]);
                        }
                        
                        if ($model->canInstall()) {
                            $result .= Html::a("安装", [
                                "install",
                                'id' => $model->getPackage()
                            ]);
                        }
                        
                        if ($model->canDelete()) {
                            $result .= "&nbsp;&nbsp;" . Html::a("删除", [
                                "delete",
                                'id' => $model->getPackage()
                            ], [
                                "data-confirm" => "您确定要删除此模块吗？",
                                "data-method" => "post"
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
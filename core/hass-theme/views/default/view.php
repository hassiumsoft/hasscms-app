<?php
/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
use hass\theme\assets\ThemeAsset;
use yii\bootstrap\Html;
/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *
 */
/* @var $this yii\web\View */
/* @var $model hass\theme\helpers\Theme */
$this->title = Yii::t('hass', '主题详情');
$this->params['breadcrumbs'][] = [
    "label" => "主题",
    "url" => [
        "index"
    ]
];
ThemeAsset::register($this);
?>


<div class="theme-overlay row">
	<div class="theme-screenshots col-md-7">



	              <?php if(!empty($screenshot = $model->getScreenshot())):?>
		<div class="screenshot">
			<img src="<?php echo $screenshot?>" alt="">
		</div>
            <?php else :?>
		<div class="screenshot blank">没有截图</div>
            <?php endif;?>


	</div>

	<div class="theme-info col-md-5">

		<div class="box box-solid">

			<div class="box-header with-border">
				<h3 class=" box-title"><?php echo $model->getName() ?></h3>
				<span class="theme-version">版本：<?php echo $model->getVersion() ?></span>  <?php if( $model->isActive() == true):?>
		<span class="current-label">当前主题</span>
             <?php endif;?>
		</div>
			<div class="box-body">
				<h4 class="theme-author">
					由<?php echo $model->getFormatAuthors() ?>创建
				</h4>
				<p class="theme-description"><?php echo $model->getDescription() ?></p>
				<p class="theme-tags ">
					<span>关键词：</span>
            <?php echo implode($model->getKeyWords(), ",")?>
		</p>

			</div>

		</div>

    <?php if(count($model->support)>0):?>
		<div class="box box-solid">
			<div class="box-header with-border">
				<h4 class="box-title">主题支持</h4>
			</div>
			<div class="box-body">

				<ul>
				<?php if(($support = $model->getSupport()->rawData())):?>
               <?php foreach ($support as $name =>$url):?>
                <li><?php echo Html::a("[".$name."]&nbsp;".$url,$url,["target"=>"_blank"])?></li>
               <?php endforeach;?>
               <?php endif;?>
               </ul>

			</div>

		</div>

		<div class="box box-solid">
        <?php echo  \yii\helpers\Html::a("删除主题",["delete","id"=>$model->getPackage()],["data-confirm"=>"你确定要删除此主题?",'data-method' => 'post',"class"=>"btn bg-maroon btn-flat btn-block"])?>
        </div>
		<?php endif;?>
	</div>
</div>
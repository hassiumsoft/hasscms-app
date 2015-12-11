<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use hass\menu\assets\MenuAsset;

/* @var $this yii\web\View */
/* @var $model hass\menu\models\Menu */

$this->title = $model->name;
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('hass/menu', 'Menus'),
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = $this->title;
MenuAsset::register($this);
?>


<div class="row">
	<div class="col-md-4">

		<div class="box box-solid ">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php echo $linkModuleName?></h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div><!-- /.box-tools -->
                </div>
                    <?php $form = ActiveForm::begin(["action"=>Url::to(["create-link"]),"options"=>["class"=>"menu-item-form"]]); ?>

				<div class="box-body form-horizontal">
					<div class="form-group">
						<label for="inputPassword3" class="col-sm-2 control-label">文本</label>
						<div class="col-sm-10">
						 <?php echo Html::activeInput("text",$linkForm,"name",["class"=>"form-control","placeholder"=>"菜单项目"]);?>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label">URL</label>
						<div class="col-sm-10">
                            <?php echo Html::activeInput("text",$linkForm,"url",["class"=>"form-control"]);?>
						</div>
					</div>
				</div>
				<div class="box-footer">
	               <button type="submit" class="btn bg-maroon btn-flat  pull-right">添加到菜单</button>
				</div>
				<?php  ActiveForm::end();?>
		</div>

    	<div class="box-group" id="accordion">
    	     <?php $i = 0;?>
            <?php foreach ($moduleLinks as $module):?>
    		<div class="box box-solid  <?= $i ==0 ?  "":"collapsed-box"; ?>">
    			<div class="box-header with-border">
    				<h3 class="box-title">
    					<?php echo $module["name"]?>
    				</h3>

    				<div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa  <?= $i ==0 ?  "fa-minus":"fa-plus"; ?>"></i></button>
                     </div><!-- /.box-tools -->
    			</div>

    			<?php echo Html::beginForm(Url::to(["create-links-from-module"]),'post',["class"=>"menu-item-form module-form"])?>

				<div class="box-body" id="module-<?php echo $module["id"]?>">
                    <?php echo $this->render("_menu_item",["tree"=>$module["tree"],"name"=>$module["id"]])?>
				</div>
	            <div class="box-footer">
	               <?php echo Html::input("hidden","module", $module["id"])?>
	               <button class="btn btn-box-tool btn-xs select-all" type="button">全选</button>
                   <button type="submit" class="btn bg-maroon btn-flat  pull-right">添加到菜单</button>
		        </div>

    			<?php echo Html::endForm();?>
    		</div>
    		<?php $i++;?>
            <?php endforeach;?>
    	</div>


    </div>

	<div class="col-md-8">
		<div class="box box-solid">

			<div class="box-header with-border">
				<h3 class="box-title">菜单结构</h3>
			</div>

			<?php //@hass-todo 当删除其中一个,再添加一个的时候会出现bug..索引重复..所以不能用最大索引做索引 ?>
			<?php echo Html::beginForm(Url::to(["create"]),'post',["id"=>"save-menu-form"])?>
			<div class="box-body">
			<?= \hass\base\misc\nestedsortable\NestedSortable::widget(); ?>
			</div>
			 <div class="box-footer">
			       <?php echo Html::input("hidden","menu-root", $model->getPrimaryKey())?>
	               <button type="submit" class="btn bg-maroon btn-flat  pull-right" id="saveMenu">保存菜单</button>
			 </div>
			 <?php echo Html::endForm();?>
		</div>

	</div>
</div>


<script>
var getmenusUrl = "<?php echo Url::to(['view-links','id'=>$model->getPrimaryKey()])?>";
</script>

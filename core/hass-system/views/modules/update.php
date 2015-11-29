<?php

/**
 *
 * @var $this \yii\web\View
 */
/**
 *
 * @var $mdoel \hass\sysetem\models\Module
 */
/**
 *
 * @var $title string
 */
$this->title = "模块配置";
$this->params['breadcrumbs'][] =  ['label' => '模块列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
/**
 * 配置表单要求
 * 1.模块中只要简单配置..例如配置字段和值
 * 2.存储在config表中
 */
?>
<?php echo $this->render("_form",["model"=>$model])?>
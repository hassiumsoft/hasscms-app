<?php
/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *
 */
$this->title = Yii::t('hass', '修改区块');
$this->params['breadcrumbs'][] = ["label"=>"区块列表","url"=>["index"]];
$this->params['breadcrumbs'][] = $this->title;
/* @var $this yii\web\View */
/* @var $searchModel hass\area\models\AreaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>

<?php echo $this->render("_form",["items"=>$items,"title"=>$title,"view"=>$view,"model"=>$model])?>
<?php
/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
use yii\helpers\Html;
/**
 *
 * @var yii\web\View $this
 * @var dektrium\user\Module $module
 */

$this->title = $title;

?>
<div class="container user-module">
	<div class="row">
		<div class="col-md-4 col-md-offset-4 ">
			<div class="panel panel-default panel-page">
				<div class="panel-heading">
					<h2 class="panel-title"><?= Html::encode($this->title) ?></h2>
				</div>
				<div class="panel-body">
           			<?=$this->render('/_alert', ['module' => $module])?>
            	</div>
			</div>
		</div>
	</div>
</div>
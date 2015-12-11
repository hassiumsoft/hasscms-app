<?php
use yii\timeago\TimeAgo;
use yii\base\Widget;
/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *         
 */

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *       
 */
?>
<div class="container">
	<div class="page-header">
		<h1 id="timeline">时间轴</h1>
	</div>
</div>
<div id="timeline" class="main-section">
	<div class="container">
		<ul class="timeline">


        <?php foreach ($models as $model):?>

         <li
				<?php echo  $model->invert?'class="timeline-inverted"':""; ?>>
				<div class="timeline-badge">
					<i class="fa <?php echo $model->type;?>"></i>
				</div>
				<div class="timeline-panel">
					<div class="timeline-heading">
						<h4 class="timeline-title"><?php echo $model->title?></h4>
						<p>
							<small class="text-muted"><i class="glyphicon glyphicon-time"></i> <?php echo TimeAgo::widget(["timestamp"=>$model->published_at])?></small>
						</p>
					</div>
					<div class="timeline-body">
                    <?php echo $model->content?>
            </div>
				</div>
			</li>


        <?php endforeach;?>


    </ul>
	</div>

</div>
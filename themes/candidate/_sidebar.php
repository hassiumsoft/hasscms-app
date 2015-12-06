<?php

/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

use yii\helpers\Url;
use hass\frontend\helpers\ViewHelper;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *       
 */
?>

<?php echo ViewHelper::area(3,[
    "blockClass"=>"sidebar-box-body",
    "headerClass"=>"sidebar-box white animate-onscroll",
    "bodyClass"=>"sidebar-box-header",
])?>

<!-- 评论最多 -->
<div class="sidebar-box white animate-onscroll">
	<h3>评论最多</h3>
	<?php $items = \hass\comment\models\CommentInfo::getEntityOrderByTotal();?>
	<div class="week-hot" style="display: block;">
		<?php $i = 1?>
		<?php foreach ($items as $item) :?>
			<a
			href="<?php echo \yii\helpers\Url::to(\hass\base\helpers\Util::getEntityUrl($item));?>"
			target="_blank" title=""> <span><?php echo $i?></span><?php echo $item->title?></a>
			<?php  $i++;?>
		<?php endforeach;?>
	</div>
</div>
<!-- /评论最多 -->

<!-- 查看最多 -->
<div class="sidebar-box white animate-onscroll">
	<h3>查看最多</h3>
	<div class="week-hot" style="display: block;">
		<?php $items = \hass\post\models\Post::findOrderByViews();?>
		<?php $i = 1?>
		<?php foreach ($items as $item) :?>
			<a
			href="<?php echo \yii\helpers\Url::to(\hass\base\helpers\Util::getEntityUrl($item));?>"
			target="_blank" title=""> <span><?php echo $i?></span><?php echo $item->title?></a>
			<?php  $i++;?>
		<?php endforeach;?>
	</div>
</div>
<!-- /查看最多 -->

<!-- widget_tag_cloud -->
<div class="sidebar-box white animate-onscroll">
	<h3>标签</h3>
	<div class="tagcloud  clearfix">
		<?php $tags = ViewHelper::tags()?>
		<?php foreach ($tags as $tag):?>
			<a
			href="<?= \yii\helpers\Url::to(\hass\base\helpers\Util::getEntityUrl($tag)); ?>"><?php echo $tag['name']?></a>
		<?php endforeach;?>
	</div>
</div>
<!-- /widget_tag_cloud -->

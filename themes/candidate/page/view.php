<?php
/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
use hass\frontend\widgets\MenuRenderWidget;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *       
 */
?>


<section class="section full-width-bg gray-bg">
	<div class="content clearfix">
		<div class="cont-left">

            <?php echo MenuRenderWidget::widget(["slug"=>"page-sidebar","options"=>["class"=>"selects"],'showParentUrl'=>true,'activeCssClass' => 'cur'])?>

        </div>
		<!-- cont-left END 选项卡左边部分-->
		<div class="cont-right">
			<div class="aboutUs">
				<h3><?=$page->title?></h3>
				<p>
                    <?=$page->content?>
                </p>
			</div>
			<!-- updData END 修改用户资料 -->
		</div>
		<!-- cont-right END 选项卡右边部分 -->
	</div>
</section>

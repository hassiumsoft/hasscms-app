<?php

/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
use yii\helpers\Html;
use yii\helpers\Url;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *       
 */
?>



<!-- Section -->
<section class="section full-width-bg gray-bg">
	<div class="row">
		<div class="col-lg-9 col-md-9 col-sm-8">
			<div class="blog-list">
				<?php foreach ($tagIndexs as $tagIndex) :?>
					<?php $model = $tagIndex->entityObject; ?>
					<div class="blog-post" style="opacity: 1;">
					<div class="post-content row">
						<div class="col-md-3">
							<div class="img">


								<a
									href="<?= \yii\helpers\Url::to(\hass\base\helpers\Util::getEntityUrl($model)); ?>"
									class="cover">

										<?php echo $model->thumbnail ? Html::img($model->thumbnail->getThumb(180, 135)) : ""; ?>
									</a>

									<?php $taxonomys = $model->taxonomys; ?>
									<?php foreach ($taxonomys as $taxonomy): ?>
										<a class="sort"
									href="<?= \yii\helpers\Url::to(\hass\base\helpers\Util::getEntityUrl($taxonomy)) ?>"><?php echo $taxonomy->name ?></a>
									<?php endforeach; ?>
								</div>

						</div>
						<div class="col-md-9">
							<div class="post-header">
								<h2>
									<a
										href="<?= \yii\helpers\Url::to(\hass\base\helpers\Util::getEntityUrl($model)); ?>"><?php echo $model->title ?></a>
								</h2>
							</div>
							<div class="post-exceprt">
								<p>
										<?php echo \hass\base\helpers\Util::substr($model->short,0,50)."..."?>
									</p>
							</div>
							<div class="post-meta">
									<?php $author = $model->author; ?>

									<div class="aut">
									<a rel="nofollow"
										href="<?php echo \yii\helpers\Url::to(\hass\base\helpers\Util::getEntityUrl($author));?>"
										target="_blank"> <img src="<?= $author->getAvatar(26,26); ?>"
										width="26" height="26"> <span>
                                            <?=$author->profile->name?>

                                            </span>
									</a>
								</div>



								<div class="time">
									<i></i> <span><?=$model->getPublishedDate();?></span> <span><?=$model->getPublishedTime();?></span>
								</div>



								<a rel="nofollow"
									href="<?= \yii\helpers\Url::to(\hass\base\helpers\Util::getEntityUrl($model)); ?>"
									target="_blank" class="cmt"><i></i><span><?=$model->getCommentTotal()?></span></a>

							</div>

						</div>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
			<!-- Pagination -->
			<div class="row pagination">


				<?php
    $currentPage = $pagination->getPage();
    $pageCount = $pagination->getPageCount();
    
    if (($prev = $currentPage - 1) < 0) {
        $prev = 0;
    }
    if (($next = $currentPage + 1) >= $pageCount - 1) {
        $next = $pageCount - 1;
    }
    
    ?>

				<div
					class="col-lg-6 col-md-6 col-sm-6 button-pagination align-center  <?php echo $currentPage<=0?"disabled":"";?>">
					<a href="<?php echo $pagination->createUrl($prev)?>"
						class="button big previous ">上一页</a>
				</div>

				<div
					class="col-lg-6 col-md-6 col-sm-6 button-pagination align-center <?php echo $currentPage >=$pageCount - 1?"disabled":"";?>">
					<a href="<?php echo $pagination->createUrl($next)?>"
						class="button big next  ">下一页</a>
				</div>
			</div>
			<!-- /Pagination -->
		</div>
		<!-- Sidebar -->
		<div class="col-lg-3 col-md-3 col-sm-4 sidebar">
			<?php echo $this->render("/_sidebar")?>


		</div>
		<!-- /Sidebar -->
	</div>
</section>
<!-- /Section -->

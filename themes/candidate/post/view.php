<?php

/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
use yii\helpers\Url;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
?>
<section class="section full-width-bg">
	<div class="artle-nowsite">
		<div class="inner">
            <?php $breads = \hass\base\helpers\Util::getBreadcrumbs($post);?>
            <?php foreach($breads as $name=>$url):?>
                <a href="<?php echo Url::to($url);?>"><?=$name?></a>&gt;
            <?php endforeach;?>
            正文
        </div>
	</div>

	<div class="row">

		<div class="col-lg-9 col-md-9 col-sm-8">
			<!-- Single Blog Post -->
			<div class="blog-post-single article-left">

				<div class="pageTop">
					<h1><?= $post->title ?></h1>
				</div>
				<div class="pageInfo clr">
					<div class="pi-author">
						<span><?= $post->getPublishedDate() ?></span> <span><?= $post->getPublishedTime() ?></span>
						<a
							href="<?= \yii\helpers\Url::to(\hass\base\helpers\Util::getEntityUrl($post->author)); ?>"
							target="_blank"><?= $post->author->profile->name; ?></a>
					</div>
					<!-- pi-author END -->
					<div class="pi-comment">
						<a
							href="<?= \yii\helpers\Url::to(array_merge(["#" => "comments"], \hass\base\helpers\Util::getEntityUrl($post))); ?>"><span><?php echo $post->getCommentTotal(); ?></span><span>条评论</span></a>
					</div>
					<!-- pi-comment END -->
				</div>
				<div class="pageCont lph-article-comView ">
                    <?= $post->content?>
                </div>
				<!-- Post Meta Track -->
				<div class="post-meta-track animate-onscroll">

					<table class="project-details">
						<tr>
							<td class="share-media">
								<div class="bdsharebuttonbox">
									<a href="#" class="bds_more" data-cmd="more"></a><a href="#"
										class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a
										href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a
										href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a
										href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a><a
										href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a>
								</div> <script>window._bd_share_config = {
                                        "common": {
                                            "bdSnsKey": {},
                                            "bdText": "",
                                            "bdMini": "2",
                                            "bdMiniList": false,
                                            "bdPic": "",
                                            "bdStyle": "1",
                                            "bdSize": "16"
                                        },
                                        "share": {}
                                    };
                                    with (document)0[(getElementsByTagName('head')[0] || body).appendChild(createElement('script')).src = 'http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion=' + ~(-new Date() / 36e5)];</script>
							</td>
							<td class="tags">Tags:


                                <?php foreach ($post->tags as $tag): ?>
                                    <a
								href="<?= \yii\helpers\Url::to(\hass\base\helpers\Util::getEntityUrl($tag)) ?>"><?= $tag->name ?></a>,
                                <?php endforeach; ?>
                            </td>
						</tr>

					</table>

				</div>
				<!-- /Post Meta Track -->

			</div>
			<!-- /Single Blog Post -->
			<!-- Post Comments -->
			<div class="post-comments">
				<h3 class="animate-onscroll">Comments</h3>
                <?php echo \hass\comment\widgets\CommentWidget::widget(["owner" => $post, "entityClass" => 'hass\post\models\Post', "commentUrl" => ["/comment/create"], "replyFormUrl" => ["/comment/replyform"]]); ?>
            </div>
			<!-- /Post Comments -->
		</div>


		<!-- Sidebar -->
		<div class="col-lg-3 col-md-3 col-sm-4 sidebar">



			<div class="about-author" id="article_author_info">
				<div class="aboutAur-main">
					<div class="aboutAur-mes clr">
						<div class="au-face">
							<a rel="nofollow"
								href="<?= \yii\helpers\Url::to(\hass\base\helpers\Util::getEntityUrl($post->author)); ?>"
								target="_blank"> <img
								src="<?= $post->author->getAvatar(100, 100) ?>"
								alt="<?= $post->author->profile->name; ?>">
							</a> <em class="v"></em>
						</div>
						<div class="aboutAur-name">
							<div class="name">
								<a rel="nofollow" href="http://www.leiphone.com/author/kaikai"
									target="_blank"><?= $post->author->profile->name; ?></a>
							</div>
							<div class="rank">专栏作者</div>
							<div class="ope">
								<a href="javascript:void(0);" class="focus">+关注</a>
							</div>
						</div>
					</div>
					<div class="atten-area">
						<em class="l-quote"></em>
                        <?= $post->author->profile->bio ?><em
							class="r-quote"></em>
					</div>


					<div class="monthHot-artle">
						<div class="tit">
							<span>当月热门文章</span>
						</div>
						<div class="list">
							<ul>
                                <?php $posts = \hass\post\models\Post::find()->where(["author_id"=>$post->author->id])->orderBy(["views"=>SORT_DESC])->limit(5)->all();?>

                                <?php $i = 1?>
                                <?php foreach($posts as $post):?>
                                <li
									class="<?php echo  $i==1 ?"first":"";?>"><a
									href="<?= \yii\helpers\Url::to(\hass\base\helpers\Util::getEntityUrl($post)); ?>"
									title="<?=$post->title?>" target="_blank"><?=$post->title?></a>
                                    <?php $i = 0;?>
                                </li>
                                <?php endforeach;?>
                            </ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Sidebar -->
	</div>

</section>


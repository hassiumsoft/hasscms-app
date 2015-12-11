<?php
use yii\helpers\Html;
use hass\install\assets\InstallAsset;
use yii\widgets\Menu;
use hass\backend\Module;
use yii\helpers\Url;

/** @var \yii\web\AssetBundle $bundle */
$bundle = InstallAsset::register($this);
$this->beginPage();
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
<meta charset="<?= Yii::$app->charset ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags()?>
        <title><?= Html::encode($this->title) ?></title>
	    <?php $this->head()?>
    </head>
<body>
    <?php $this->beginBody()?>
		<div class="container" id="wrapper">

		<div class="panel loading" id="target">
			<div class="panel-heading clearfix">
				<h3 class="panel-title pull-left"><?php echo  Module::HASS_CMS_NAME ?></h3>
				<div class="pull-right">
					Version <strong><?php echo  Module::HASS_CMS_VERSION ?></strong>
				</div>
			</div>
			<div class="panel-body ">

			
				<div id="progress">
                                <?php
                                echo Menu::widget([
                                    "options" => [
                                        "class" => "list-group"
                                    ],
                                    "itemOptions" => [
                                        "class" => "list-group-item"
                                    ],
                                    "linkTemplate" => '{label}',
                                    "items" => [
                                        [
                                            'label' => '欢迎页面',
                                            "url" => [
                                                "default/index"
                                            ],
                                            "options" => [
                                                "data-url" => Url::to([
                                                    "default/index"
                                                ])
                                            ]
                                        ],
                                        // [
                                        // 'label' => '选择安装语言',
                                        // "url" => [
                                        // "default/language"
                                        // ],
                                        // "options" => [
                                        // "data-url" => Url::to([
                                        // "default/language"
                                        // ])
                                        // ]
                                        // ],
                                        [
                                            'label' => '许可协议',
                                            "url" => [
                                                "default/license-agreement"
                                            ],
                                            "options" => [
                                                "data-url" => Url::to([
                                                    "default/license-agreement"
                                                ])
                                            ]
                                        ],
                                        [
                                            'label' => '检查安装条件',
                                            "url" => [
                                                "default/check-env"
                                            ],
                                            "options" => [
                                                "data-url" => Url::to([
                                                    "default/check-env"
                                                ])
                                            ]
                                        ],
//                                         [
//                                             'label' => '选择DB',
//                                             "url" => [
//                                                 "default/select-db"
//                                             ],
//                                             "options" => [
//                                                 "data-url" => Url::to([
//                                                     "default/select-db"
//                                                 ])
//                                             ]
//                                         ],
                                        [
                                            'label' => '输入DB信息',
                                            "url" => [
                                                "default/set-db"
                                            ],
                                            "options" => [
                                                "data-url" => Url::to([
                                                    "default/set-db"
                                                ])
                                            ]
                                        ],
                                        [
                                            'label' => '站点设置',
                                            "url" => [
                                                "default/set-site"
                                            ],
                                            "options" => [
                                                "data-url" => Url::to([
                                                    "default/set-site"
                                                ])
                                            ]
                                        ],
                                        [
                                            'label' => '输入管理员信息',
                                            "url" => [
                                                "default/set-admin"
                                            ],
                                            "options" => [
                                                "data-url" => Url::to([
                                                    "default/set-admin"
                                                ])
                                            ]
                                        ]
                                    ]
                                ]);
                                ?>
							</div>
				<div id="content">
					<div class="infoArea">
					<?php echo $content;?>		
				</div>
				
            <?php if (isset($this->blocks['ibtnArea'])): ?>
            	<?= $this->blocks['ibtnArea']?>
            <?php else: ?>
            	<div class="ibtnArea clearfix">
            		<span class="pull-left"> <a href="javascript:void(0)"
            			class="btn btn-small  btn-primary" id="prevButton"><i
            				class="fa fa-arrow-circle-left"></i> 返回 </a>
            		</span> <span class="pull-right"> <a href="javascript:void(0)"
            			class="btn btn-small  btn-primary" id="nextButton">下一歩 <i
            				class="fa fa-arrow-circle-right"></i>
            		</a>
            		</span>
            	</div>
            <?php endif;?>
				</div>
			</div>
		</div>
	</div>
    <?php $this->endBody()?>
    </body>
</html>
<?php $this->endPage()?>

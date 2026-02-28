<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\helpers\Utils;

?>

					<div class="container-fluid px-4">
                        <h1 class="mt-4"><?= Yii::t('app', 'main_page_title'); ?></h1>

						<?php if (empty($content)) { ?>
						<div class="alert alert-info">
							<?= Yii::t('app', 'main_page_no_content'); ?>
						</div>
						<?php } else { ?>
						<?php
						$config = HTMLPurifier_Config::createDefault();
						// $config->set('HTML.Allowed', 'p,b,i,u,a[href],ul,ol,li,br,img[src|alt|class],strong,em');
						$config->set('HTML.Allowed', 'p,br,strong,em,b,i,ul,ol,li,blockquote,code,pre,h1,h2,h3,h4,h5,h6,table,thead,tbody,tr,th,td,a[href|title|target],img[src|alt|title]');
						$config->set('Attr.AllowedFrameTargets', ['_blank']);
						$config->set('URI.AllowedSchemes', ['http','https','mailto']);
						?>
						<?php foreach ($content as $c) { ?>
						<?php
						$post = strip_tags($c['post']);
						$parser = new \app\components\SafeMarkdown();
						$parser->enableNewlines = true;
						$parser->html5 = true;
						$post = $parser->parse($post);
						$post = (new HTMLPurifier($config))->purify($post);
						?>
						<div class="card mb-4">
							<div class="card-body">
								<div class="align-items-center mb-2">
									<?php if (!empty($c['img'])) { ?>
									<img src="<?= Url::to('@web/uploads/articles/block/'.$c['img']); ?>" alt="<?= Html::encode($c['title']); ?>" class="float-end img-thumbnail mini" />
									<!-- <img src="<?= Url::to('@web/uploads/articles/block/'.$c['img']); ?>" alt="<?= Html::encode($c['title']); ?>" class="content-img me-3" /> -->
									<?php } ?>
									<!-- <h5 class="card-title mb-0"><?= Html::encode($c['title']); ?></h5> -->
									<?= $post; ?>
								</div>
								<!-- <a href="<?= Url::to('category/'.$c['category_sef'].'/post/'.$c['id'].'-'.$c['sef']); ?>" class="btn btn-primary"><?= Yii::t('app', 'read_more'); ?></a> -->
							</div>
						</div>
						<?php } ?>
						<?php } ?>
					</div>


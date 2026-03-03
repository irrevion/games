<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\helpers\Utils;
use app\helpers\Out;

?>

					<div class="container-fluid px-4">
                        <h1 class="mt-4"><?= Html::encode($category['name']); ?></h1>

						<?php if (empty($posts)) { ?>
						<div class="alert alert-info">
							<?= Yii::t('app', 'category_page_no_content'); ?>
						</div>
						<?php } else { ?>
						<!-- content blocks -->
						<div class="row row-cols-1 row-cols-lg-2 g-4">
						<?php foreach ($posts as $p) { ?>
							<?php
								$txt = Out::short($p['post'], 180);
							?>
							<div class="col">
								<div class="card h-100 mb-4">
									<div class="card-header">
										<?= Out::catIco($p['category_sef']); ?> <?= Html::encode($p['title']); ?>
									</div>
									<div class="card-body">
										<?php if (!empty($p['img'])) { ?>
										<img src="<?= Url::to('@web/uploads/articles/block/'.$p['img']); ?>" alt="<?= Html::encode($p['title']); ?>" class="float-end img-thumbnail mini" />
										<?php } ?>
										<?= $txt ?> <?= str_ends_with($txt, '...') ? Html::a(Yii::t('app', 'read_more'), ['content/post', 'category_sef' => $p['category_sef'], 'id' => $p['id'], 'slug' => $p['sef'], 'lang' => explode('-', Yii::$app->language)[0]]) : ''; ?>
									</div>
									<div class="card-footer small text-muted"><?= Out::pubTS($p['publish_datetime']); ?></div>
								</div>
							</div>
						<?php } ?>
						</div>
						<?php } ?>
					</div>


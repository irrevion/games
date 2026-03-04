<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\helpers\Utils;
use app\helpers\Out;

?>

					<div class="container-fluid px-4">
                        <h1 class="mt-4"><?= Yii::t('app', 'main_page_title'); ?></h1>

						<?php if (empty($content)) { ?>
						<div class="alert alert-info">
							<?= Yii::t('app', 'main_page_no_content'); ?>
						</div>
						<?php } else { ?>
						<!-- promo block -->
						<div class="card mb-4">
                            <div class="card-body">
                                <?= Yii::t('app', 'welcome'); ?>
                            </div>
                        </div>
						<!-- content blocks -->
						<div class="row row-cols-1 row-cols-lg-2 g-4">
						<?php foreach ($content as $c) { ?>
							<?php
								$txt = Out::short($c['post'], 180);
							?>
							<div class="col">
								<div class="card h-100 mb-4">
									<div class="card-header" title="<?= Html::encode($c['title']); ?>">
										<?= Out::catIco($c['category_sef']); ?> <?= Html::encode(Utils::limitStringLength($c['title'], 42)); ?>
									</div>
									<div class="card-body">
										<?php if (!empty($c['img'])) { ?>
										<img src="<?= Url::to('@web/uploads/articles/block/'.$c['img']); ?>" alt="<?= Html::encode($c['title']); ?>" class="float-end img-thumbnail mini" />
										<?php } ?>
										<?= $txt ?> <?= str_ends_with($txt, '...') ? Html::a(Yii::t('app', 'read_more'), ['content/post', 'category_sef' => $c['category_sef'], 'id' => $c['id'], 'slug' => $c['sef'], 'lang' => explode('-', Yii::$app->language)[0]]) : ''; ?>
									</div>
									<div class="card-footer small text-muted"><?= Out::pubTS($c['publish_datetime']); ?></div>
								</div>
							</div>
						<?php } ?>
						</div>
						<?php } ?>
					</div>


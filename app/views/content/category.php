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
									<div class="card-header" title="<?= Html::encode($p['title']); ?>">
										<?= Out::catIco($category['sef']); ?> <?= Html::encode(Utils::limitStringLength($p['title'], 42)); ?>
									</div>
									<div class="card-body">
										<?php if (!empty($p['img'])) { ?>
										<img src="<?= Url::to('@web/uploads/articles/block/'.$p['img']); ?>" alt="<?= Html::encode($p['title']); ?>" class="float-end img-thumbnail mini" />
										<?php } ?>
										<?= $txt ?> <?= str_ends_with($txt, '...') ? Html::a(Yii::t('app', 'read_more'), ['content/post', 'category_sef' => $category['sef'], 'id' => $p['id'], 'slug' => $p['sef'], 'lang' => explode('-', Yii::$app->language)[0]]) : ''; ?>
									</div>
									<div class="card-footer small text-muted"><?= Out::pubTS($p['publish_datetime']); ?></div>
								</div>
							</div>
						<?php } ?>
						</div>
						<!-- end content blocks -->

						<!-- pagination -->
						<nav class="nav-pagination-container" aria-label="Category pagination">
						<?php
							print \yii\widgets\LinkPager::widget([
								'pagination' => $pg,
								'pageCssClass' => 'page-item',
								'linkOptions' => ['class' => 'page-link'],
								// 'disableCurrentPageButton' => true,
								// 'disabledPageCssClass' => 'disabled',
								'activePageCssClass' => 'active',
								'prevPageCssClass' => 'page-item prev',
								'nextPageCssClass' => 'page-item next',
								'disabledListItemSubTagOptions' => [
									'tag' => 'a',
									'href' => '#',
									'class' => 'page-link disabled'
								],
							]);
						?>
						</nav>
						<!-- end pagination -->
						<?php } ?>
					</div>


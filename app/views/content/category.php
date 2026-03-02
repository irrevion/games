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
						<?php foreach ($posts as $p) { ?>
						<div class="card mb-4">
							<div class="card-body">
								<div class="align-items-center mb-2">
									<?php if (!empty($p['img'])) { ?>
									<img src="<?= Url::to('@web/uploads/articles/block/'.$p['img']); ?>" alt="<?= Html::encode($p['title']); ?>" class="float-end img-thumbnail mini" />
									<?php } ?>
									<!-- <h5 class="card-title mb-0"><?= Html::encode($p['title']); ?></h5> -->
									<?= Out::md2html($p['post']); ?>
								</div>
								<!-- <a href="<?= Url::to('category/'.$p['category_sef'].'/post/'.$p['id'].'-'.$p['sef']); ?>" class="btn btn-primary"><?= Yii::t('app', 'read_more'); ?></a> -->
							</div>
						</div>
						<?php } ?>
						<?php } ?>
					</div>


<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\helpers\Utils;
use app\helpers\Out;
use app\widgets\Breadcrumbs;

?>

					<div class="container-fluid px-4">
                        <h1 class="mt-4"><?= Html::encode($post['title']); ?></h1>
						<?= Breadcrumbs::widget([
							'links' => [
								['title' => Yii::t('app', 'main_page_title'), 'href' => ['site/main'], 'icon' => 'home'],
								['title' => Html::encode($category['name']), 'href' => ['content/category', 'category_sef' => $category['sef'], 'lang' => explode('-', Yii::$app->language)[0]], 'icon' => (Out::$icons[$category['sef']] ?? 'folder')],
								['title' => Html::encode($post['title']), 'href' => '', 'icon' => 'file'],
							],
						]); ?>

						<div class="card mb-4">
							<div class="card-body">
								<div class="align-items-center mb-2">
									<?php if (!empty($post['img'])) { ?>
									<img src="<?= Url::to('@web/uploads/articles/block/'.$post['img']); ?>" alt="<?= Html::encode($post['title']); ?>" class="float-end img-thumbnail mini" />
									<?php } ?>
									<?= Out::md2html($post['post']); ?>
								</div>
							</div>
						</div>
					</div>


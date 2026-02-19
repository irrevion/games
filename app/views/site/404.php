<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\helpers\Env;
use app\helpers\Utils;

?>

					<div class="container-fluid px-4 site-error">
                        <h1 class="mt-4"><?= Yii::t('app', '404_headline'); ?></h1>

						<div class="card mb-4">
                            <div class="card-body">
								<div>
									<!-- <img src="images/404.jpg" alt="Eclipse busters - Horizon Zero Dawn" class="float-end img-thumbnail mini" /> -->
									<img src="<?= Url::to('@web/images/404.jpg') ?>" alt="Eclipse busters - Horizon Zero Dawn" class="float-end img-thumbnail mini" />
									<p><?= Yii::t('app', '404_descr'); ?></p>
									<p><a href="<?= Yii::$app->homeUrl; ?>"><?= Yii::t('app', '404_to_main'); ?></a></p>
									<!-- <p><a href="mailto:admin@irrevion.dp.ua"><?= Yii::t('app', '404_feedback'); ?></a></p> -->
									<p><?= Html::mailto(Yii::t('app', '404_feedback'), Env::get('mailbox')); ?></p>
								</div>
							</div>
						</div>
					</div>


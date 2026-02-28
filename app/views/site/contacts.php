<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\helpers\Env;
use app\helpers\Utils;

?>

					<div class="container-fluid px-4">
                        <h1 class="mt-4"><?= Yii::t('app', 'contacts_page_title'); ?></h1>

						<div class="card mb-4">
                            <div class="card-body">
								<div>
									<img src="<?= Url::to('@web/images/contact.jpg') ?>" alt="Plug in to the Matrix" class="float-end img-thumbnail mini" />

									<p><?= nl2br(Html::encode(Yii::t('app', 'contacts_page_descr'))); ?></p>
									<p><a href="mailto:<?= Html::encode(Env::get('mailbox')); ?>"><i class="fa-solid fa-envelope"></i> <?= Yii::t('app', 'contacts_feedback'); ?></a></p>
									<p><a href="https://youtube.com/@irrevion" title="YouTube" target="_blank"><i class="fa-brands fa-youtube"></i> YouTube</a></p>
									<p><a href="https://www.tiktok.com/@irrevion" title="TikTok" target="_blank"><i class="fa-brands fa-tiktok"></i> TikTok</a></p>
									<p><a href="https://t.me/irrevion_games" title="Telegram" target="_blank"><i class="fa-brands fa-telegram"></i> Telegram</a></p>
								</div>
							</div>
						</div>
					</div>


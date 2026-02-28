<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\helpers\Utils;

?>


			<!-- site language picker -->
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" id="navbarDropdownLang" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" title="<?= Yii::t('app', 'translate'); ?>"><i class="bi bi-translate"></i></a>
				<ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="navbarDropdownLang">
					<?php foreach ($this->context->langs as $ln=>$locale) {
						$t_key = 'lang_'.strtr($locale, '-', '_');
						$href = Url::current(['lang' => $ln]);
						if (Yii::$app->controller->route === 'site/error') {
							$href = Url::to(['site/home', 'lang' => $ln]);
						}
						?>
					<li>
						<a title="<?= Yii::t('app', $t_key.'_title'); ?>" class="dropdown-item<?= ((Yii::$app->language==$locale)? ' active': ''); ?>" href="<?= Html::encode($href); ?>"><?php if (Yii::$app->language == $locale) { echo '<i class="bi bi-check"></i> '; } ?> <?= Yii::t('app', $t_key); ?> <img src="<?= Url::to('@web/images/flag/'.$locale.'.png'); ?>" class="flag" /></a>
					</li>
					<?php } ?>
				</ul>
			</li>
			<!-- / end of site language picker -->


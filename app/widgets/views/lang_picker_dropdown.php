<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\helpers\Utils;

?>


			<!-- site language picker -->
            <div class="dropdown lang-picker">
				<div class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<?= Yii::t('app', Yii::$app->language.'_picker_label'); ?>
				</div>
				<div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="min-width: 5rem;">
					<?php foreach ($this->context->langs_stock as $lng) {
						if ($lng==Yii::$app->language) {
							// skip currently picked language
							continue;
						}
						?>
					<a class="dropdown-item" href="<?= Yii::$app->urlManager->createUrl([
						// 'site/index',
						Yii::$app->controller->id.'/'.Yii::$app->controller->action->id,
						'language' => $lng,
					]); ?>"><?= Yii::t('app', $lng.'_picker_label'); ?></a>
					<?php } ?>
				</div>
            </div>
			<!-- / end of site language picker -->


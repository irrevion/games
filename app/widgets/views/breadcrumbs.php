<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\helpers\Utils;

?>

<ol class="breadcrumb mb-4">
	<?php
		if (!empty($links) && is_array($links)) {
			foreach ($links as $link) {
	?>
	<li class="breadcrumb-item<?=(empty($link['href'])? ' active': '');?>">
		<?=(empty($link['href'])? '': ('<a href="'.Url::to($link['href']).'">'));?>
			<?= (empty($link['icon'])? '': ('<i class="fa fa-'.$link['icon'].'"></i>')); ?> 
			<?= Html::encode($link['title']);?>
		<?= (empty($link['href'])? '': '</a>'); ?>
	</li>
	<?php
			}
		}
	?>
</ol>
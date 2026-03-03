<?php

namespace app\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use app\helpers\Utils;

class Breadcrumbs extends Widget {

	public $links = [];

	public function init() {
        parent::init();
    }

	public function run() {
		return $this->render('breadcrumbs', [
			'links' => $this->links,
		]);
	}
}

?>
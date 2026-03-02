<?php
namespace app\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use app\helpers\Utils;

class LangPicker extends Widget {

	// enlist allowed langs for lang picker links generation
	public $langs = ['en' => 'en-US', 'es' => 'es-MX'];


	public function init() {
		parent::init();
		// get allowed langs from params
		$this->langs = Yii::$app->params['langs'];
	}

	public function run() {
		return $this->render('lang_picker_dropdown');
	}
}

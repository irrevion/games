<?php
namespace app\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use app\helpers\Utils;

class LangPicker extends Widget {

	// enlist allowed langs for lang picker links generation
	public $langs_stock = ['az', 'en' /*, 'ru'*/ ];


	public function init() {
		parent::init();
	}

	public function run() {
		return $this->render('lang_picker_dropdown');
	}
}

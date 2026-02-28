<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\helpers\Utils;

class BaseController extends Controller {

	public function beforeAction($action='') {
		if (!parent::beforeAction($action)) {
			return false;
		}

		$lang = \Yii::$app->request->get('lang');
		if ($lang === 'es') {
			\Yii::$app->language = 'es-MX';
		} else {
			\Yii::$app->language = 'en-US';
		}

		return true;
	}

}
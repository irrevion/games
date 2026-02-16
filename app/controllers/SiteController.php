<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\helpers\Utils;


class SiteController extends Controller {

	public function beforeAction($action='') {
		return true;
	}

	public function actionFeed() {
		$this->layout = false;
		return $this->render('@app/views/site/feed');
	}

	public function actionError() {
		$exception = Yii::$app->errorHandler->exception;
		Yii::$app->response->format = 'json';
		$response = [
			'success' => false,
			'message' => 'Invalid endpoint',
			'code' => 404,
			'errors' => [
				(array) $exception
			],
		];

		return $response;
	}

	/*public function actionRedirect($url) {
		if (substr($url, -1)=='/') {
			return $this->redirect(Yii::$app->getRequest()->getBaseUrl().'/'.rtrim($url, '/'), 301);
		} else {
			throw new NotFoundHttpException;
		}
	}*/

	public function actionRedirect($url='') {
		if (substr($url, -1) == '/') {
			return $this->redirect('/'.substr($url, 0, -1));
		} else {
			throw new NotFoundHttpException;
		}
	}
}

?>
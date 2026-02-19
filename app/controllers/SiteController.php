<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\helpers\Env;
use app\helpers\Utils;


class SiteController extends Controller {

	public function beforeAction($action='') {
		return true;
	}

	public function actionFeed() {
		$this->layout = '@app/views/layouts/main';
		//$this->view->title = Yii::t('app', 'main_page_title');
		$this->view->title = Env::get('sitename');
		return $this->render('@app/views/site/feed');
	}

    public function actionError() {
		//$this->layout = false;
        //$this->layout = '@app/views/layouts/error';
        $this->layout = '@app/views/layouts/main';
		$this->view->title = Yii::t('app', '404_title');

		$exception = Yii::$app->errorHandler->exception;

        return $this->render('@app/views/site/404', [
			'e' => $exception,
			'message' => (empty($exception)? 'Not found': $exception->getMessage()),
		]);
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
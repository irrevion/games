<?php

namespace app\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;
use app\helpers\Env;
use app\helpers\Utils;
use app\controllers\BaseController;
use app\models\Content;


class SiteController extends BaseController {

	public function beforeAction($action='') {
		if (!parent::beforeAction($action)) {
			return false;
		}
		return true;
	}

	public function actionHome() {
		$this->layout = '@app/views/layouts/main';
		$this->view->title = Yii::t('app', 'main_page_title').' - '.Env::get('sitename');
		$this->view->params['canonical'] = Url::current([], true);
		foreach (Yii::$app->params['langs'] as $ln=>$locale) {
			if ($locale != Yii::$app->language) {
				$this->view->params['alternative_langs'][$ln] = Url::current(['lang' => $ln], true);
			}
		}
		$params = [];
		$params['content'] = Content::getHomeLatest(20);
		return $this->render('@app/views/site/main', $params);
	}

	public function actionContacts() {
		$this->layout = '@app/views/layouts/main';
		$this->view->title = Yii::t('app', 'contacts_page_title').' - '.Env::get('sitename');
		$this->view->params['canonical'] = Url::current([], true);
		foreach (Yii::$app->params['langs'] as $ln=>$locale) {
			if ($locale != Yii::$app->language) {
				$this->view->params['alternative_langs'][$ln] = Url::current(['lang' => $ln], true);
			}
		}
		return $this->render('@app/views/site/contacts');
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
<?php

namespace app\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;
use app\helpers\Env;
use app\helpers\Out;
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
		$this->view->params['canonical'] = Url::toRoute(['site/home', 'lang' => $this->lang], true);
		foreach (Yii::$app->params['langs'] as $ln=>$locale) {
			if ($locale != Yii::$app->language) {
				$this->view->params['alternative_langs'][$ln] = Url::toRoute(['site/home', 'lang' => $ln], true);
			}
		}
		$params = [];
		$params['content'] = Content::getHomeLatest(20);
		return $this->render('@app/views/site/main', $params);
	}

	public function actionContacts() {
		$this->layout = '@app/views/layouts/main';
		$this->view->title = Yii::t('app', 'contacts_page_title').' - '.Env::get('sitename');
		$this->view->params['canonical'] = Url::toRoute(['site/contacts', 'lang' => $this->lang], true);
		foreach (Yii::$app->params['langs'] as $ln=>$locale) {
			if ($locale != Yii::$app->language) {
				$this->view->params['alternative_langs'][$ln] = Url::toRoute(['site/contacts', 'lang' => $ln], true);
			}
		}
		return $this->render('@app/views/site/contacts');
	}

    public function actionError() {
        $this->layout = '@app/views/layouts/main';
		$this->view->title = Yii::t('app', '404_title');

		$exception = Yii::$app->errorHandler->exception;

        return $this->render('@app/views/site/404', [
			'e' => $exception,
			'message' => (empty($exception)? 'Not found': $exception->getMessage()),
		]);
    }

	public function actionMap() {
		$this->layout = false;
		\Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
		header('Content-Type: text/xml; charset=utf-8');
		flush();

		$xml = new \XMLWriter();
		$xml->openURI('php://output');
		$xml->startDocument('1.0', 'UTF-8');
		$xml->setIndent(true);

		$xml->startElement('urlset');
		$xml->writeAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
		$langs = Yii::$app->params['langs'];
		foreach ($langs as $ln=>$locale) {
			$urls = Content::getUrls($ln);
			Out::sitemapXmlUrls($xml, $urls);
			flush();
		}
		$xml->endElement(); // end urlset

		$xml->endDocument();
    	$xml->flush();
		flush();
		die;
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
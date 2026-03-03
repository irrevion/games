<?php

namespace app\controllers;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;
use app\helpers\Env;
use app\helpers\Utils;
use app\controllers\BaseController;
use app\models\Content;


class ContentController extends BaseController {

	public function beforeAction($action='') {
		if (!parent::beforeAction($action)) {
			return false;
		}
		return true;
	}

	public function actionCategory($category_sef) {
		$this->layout = '@app/views/layouts/main';
		$params = [];
		$params['category'] = Content::getCategoryBySef($category_sef);
		if (empty($params['category']['id'])) {
			throw new \yii\web\HttpException(404);
		}
		$this->view->title = $params['category']['name'].' - '.Env::get('sitename');
		$this->view->params['canonical'] = Url::toRoute(['content/category', 'category_sef' => $params['category']['sef'], 'lang' => $this->lang], true);
		foreach (Yii::$app->params['langs'] as $ln=>$locale) {
			if ($locale != Yii::$app->language) {
				$this->view->params['alternative_langs'][$ln] = Url::toRoute(['content/category', 'category_sef' => $params['category']['sef'], 'lang' => $ln], true);
			}
		}
		$params['posts'] = Content::getCategoryLatest($params['category']['id'], 20);
		return $this->render('@app/views/content/category', $params);
	}

	public function actionPost($category_sef, $id) {
		$this->layout = '@app/views/layouts/main';
		$params = [];
		$params['category'] = Content::getCategoryBySef($category_sef);
		if (empty($params['category']['id'])) {
			throw new \yii\web\HttpException(404);
		}
		$params['post'] = Content::getPostById($id, $params['category']['id']);
		if (empty($params['post']['id'])) {
			throw new \yii\web\HttpException(404);
		}
		$this->view->title = $params['post']['title'].' - '.Env::get('sitename');
		$this->view->params['canonical'] = Url::toRoute(['content/post', 'category_sef' => $params['category']['sef'], 'id' => $params['post']['id'], 'lang' => $this->lang], true);
		foreach (Yii::$app->params['langs'] as $ln=>$locale) {
			if ($locale != Yii::$app->language) {
				$this->view->params['alternative_langs'][$ln] = Url::toRoute(['content/post', 'category_sef' => $params['category']['sef'], 'id' => $params['post']['id'], 'lang' => $ln], true);
			}
		}
		return $this->render('@app/views/content/post', $params);
	}
}

?>
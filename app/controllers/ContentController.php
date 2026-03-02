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
		$this->view->title = Yii::t('app', $params['category']['name']).' - '.Env::get('sitename');
		$this->view->params['canonical'] = Url::current([], true);
		foreach (Yii::$app->params['langs'] as $ln=>$locale) {
			if ($locale != Yii::$app->language) {
				$this->view->params['alternative_langs'][$ln] = Url::current(['lang' => $ln], true);
			}
		}
		$params['posts'] = Content::getCategoryLatest($params['category']['id'], 20);
		return $this->render('@app/views/content/category', $params);
	}
}

?>
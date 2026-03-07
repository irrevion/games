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
		$routeParams = ['content/category', 'category_sef' => $params['category']['sef'], 'lang' => $this->lang];
		$currentPage = (int)Yii::$app->request->get('page', '1');
		if ($currentPage<1) {
			throw new \yii\web\HttpException(404);
		}
		if ($currentPage>1) {
			$this->view->title = Yii::t('app', 'page_num_title', ['num' => $currentPage]).' - '.$this->view->title;
			$routeParams['page'] = $currentPage;
		}
		$this->view->params['canonical'] = Url::toRoute($routeParams, true);
		foreach (Yii::$app->params['langs'] as $ln=>$locale) {
			if ($locale != Yii::$app->language) {
				$altRouteParams = $routeParams;
				$altRouteParams['lang'] = $ln;
				$this->view->params['alternative_langs'][$ln] = Url::toRoute($altRouteParams, true);
			}
		}

		$params['posts'] = [];
		Content::$items_amount = Content::getCategoryPostsNum($params['category']['id']);
		$pg = new \yii\data\Pagination([
			'totalCount' => Content::$items_amount,
			'pageSize' => Content::$pp,
			// 'route' => 'content/category',
			'pageSizeParam' => false,
			'forcePageParam' => false,
		]);
		if (($currentPage>1) && ($currentPage>$pg->pageCount)) {
			throw new \yii\web\HttpException(404);
		}
		if (Content::$items_amount > 0) {
			Content::$pages_amount = $pg->pageCount;
			Content::$curr_pg = $pg->page + 1;
			$params['posts'] = Content::getCategoryPostsList($params['category']['id'], $pg);
		}
		$params['pg'] = $pg;

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

		// Open Graph meta tags
		$absoluteUrl = Url::toRoute([
			'content/post',
			'category_sef' => $params['category']['sef'],
			'id' => $params['post']['id'],
			'lang' => $this->lang
		], true);

		$description = \app\helpers\Out::md2text($params['post']['post'], 180);

		$image = !empty($params['post']['img'])
			? Url::to('@web/uploads/articles/larges/'.$params['post']['img'], true)
			: Url::to('@web/images/og-default.jpg', true);

		$this->view->params['og'] = [
			'title' => $params['post']['title'],
			'description' => $description,
			'image' => $image,
			'url' => $absoluteUrl,
		];

		return $this->render('@app/views/content/post', $params);
	}
}

?>
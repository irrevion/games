<?php
namespace app\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use app\helpers\Utils;

class Menu extends Widget {

    private $menu = [
		[
			'name' => 'home',
			'icon' => 'home',
			'url' => 'site/home'
		],
		[
			'name' => 'feed',
			'icon' => 'dove',
			'url' => ['content/category', 'category_sef' => 'feed'],
			'match' => [
				'routes' => ['content/category', 'content/post'],
				'params' => ['category_sef' => 'feed'],
			],
		],
		[
			'name' => 'news',
			'icon' => 'newspaper',
			'url' => ['content/category', 'category_sef' => 'news'],
			'match' => [
				'routes' => ['content/category', 'content/post'],
				'params' => ['category_sef' => 'news'],
			],
		],
		[
			'name' => 'reviews',
			'icon' => 'star-half-stroke',
			'url' => ['content/category', 'category_sef' => 'reviews'],
			'match' => [
				'routes' => ['content/category', 'content/post'],
				'params' => ['category_sef' => 'reviews'],
			],
		],
		[
			'name' => 'tips',
			'icon' => 'lightbulb',
			'url' => ['content/category', 'category_sef' => 'tips'],
			'match' => [
				'routes' => ['content/category', 'content/post'],
				'params' => ['category_sef' => 'tips'],
			],
		],
		[
			'name' => 'contacts',
			'icon' => 'headset',
			'url' => 'site/contacts'
		],
	];


	public function init() {
        parent::init();
    }

    public function run() {
		$html = '';
		$cur_page = Yii::$app->controller->id.'/'.Yii::$app->controller->action->id;
		$ln = explode('-', Yii::$app->language)[0];

		foreach ($this->menu as $i=>$item) {
			$active = $this->isActive($item);
			$url = $item['url'];
			if (is_array($url)) {
				$url['lang'] = $ln;
			} else {
				$url = [$url, 'lang' => $ln];
			}
			$html .= '<a class="nav-link'.($active? ' active': '').'" href="'.Yii::$app->urlManager->createUrl($url).'">
				<div class="sb-nav-link-icon"><i class="fas fa-'.$item['icon'].'"></i></div>
				'.Yii::t('app', 'menu_item_'.$item['name']).'
			</a>';
		}

		return $html;
    }

	private function isActive(array $item): bool {
		$currentRoute  = Yii::$app->controller->getRoute();
		$currentParams = Yii::$app->request->get();

		if (!empty($item['match'])) {
			$routes = $item['match']['routes'] ?? [];
			if ($routes && !in_array($currentRoute, $routes, true)) {
				return false;
			}

			foreach (($item['match']['params'] ?? []) as $k => $v) {
				if (!isset($currentParams[$k]) || (string)$currentParams[$k] !== (string)$v) {
					return false;
				}
			}
			return true;
		}

		$itemUrl = $item['url'];

		if (is_string($itemUrl)) {
			return $itemUrl === $currentRoute;
		}

		$urlCopy = $itemUrl;
		$route = array_shift($urlCopy);

		if ($route !== $currentRoute) {
			return false;
		}

		foreach ($urlCopy as $k => $v) {
			if (!isset($currentParams[$k]) || (string)$currentParams[$k] !== (string)$v) {
				return false;
			}
		}

		return true;
	}		
}

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
			'selected' => ['site/home'],
			'url' => 'site/home'
		],
		[
			'name' => 'feed',
			'icon' => 'dove',
			'selected' => ['category/feed'],
			'url' => 'category/feed'
		],
		[
			'name' => 'news',
			'icon' => 'newspaper',
			'selected' => ['category/news'],
			'url' => 'category/news'
		],
		[
			'name' => 'reviews',
			'icon' => 'star-half-stroke',
			'selected' => ['category/reviews'],
			'url' => 'category/reviews'
		],
		[
			'name' => 'tips',
			'icon' => 'lightbulb',
			'selected' => ['category/tips'],
			'url' => 'category/tips'
		],
		[
			'name' => 'contacts',
			'icon' => 'headset',
			'selected' => ['site/contacts'],
			'url' => 'site/contacts'
		],
	];


	public function init() {
        parent::init();
    }

    public function run() {
		$html = '';
		$cur_page = Yii::$app->controller->id.'/'.Yii::$app->controller->action->id;

		foreach ($this->menu as $i=>$item) {
			$active = in_array($cur_page, $item['selected']);
			$html .= '<a class="nav-link'.($active? ' active': '').'" href="'.Yii::$app->urlManager->createUrl($item['url']).'">
				<div class="sb-nav-link-icon"><i class="fas fa-'.$item['icon'].'"></i></div>
				'.Yii::t('app', 'menu_item_'.$item['name']).'
			</a>';
		}

		return $html;
    }
}

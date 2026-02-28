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
			//'url' => 'category/feed',
			'url' => ['content/category', 'category_sef' => 'feed']
		],
		[
			'name' => 'news',
			'icon' => 'newspaper',
			'selected' => ['category/news'],
			'url' => ['content/category', 'category_sef' => 'news']
		],
		[
			'name' => 'reviews',
			'icon' => 'star-half-stroke',
			'selected' => ['category/reviews'],
			'url' => ['content/category', 'category_sef' => 'reviews']
		],
		[
			'name' => 'tips',
			'icon' => 'lightbulb',
			'selected' => ['category/tips'],
			'url' => ['content/category', 'category_sef' => 'tips']
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
		$ln = explode('-', Yii::$app->language)[0];

		foreach ($this->menu as $i=>$item) {
			$active = in_array($cur_page, $item['selected']);
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
}

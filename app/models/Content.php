<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\helpers\Utils;


class Content extends Model {

	public static $curr_pg = 1;
	public static $pp = 20;
	public static $pages_amount = 0;
	public static $items_amount = 0;
	public static $log = [];
	private static $seo = [
		'home' => ['priority' => '1.0', 'changefreq' => 'daily'],
		'static' => ['priority' => '0.5', 'changefreq' => 'monthly'],
		'category' => ['priority' => '0.6', 'changefreq' => 'daily'],
		'post' => ['priority' => '0.7', 'changefreq' => 'weekly'],
	];
	private static $seo_cat_lastmod = true;


	public static function getHomeLatest($limit) {
		$ln = explode('-', Yii::$app->language)[0];
		$sql = "SELECT a.id, a.sef, a.img, a.publish_datetime, a.is_highlighted,
				tr1.text AS `title`, tr2.text AS `post`,
				acr.category_id, m.sef AS category_sef, tr4.text AS category_name
			FROM articles a
				JOIN translates tr1 ON tr1.ref_table='articles' AND tr1.ref_id=a.id AND tr1.lang=:lang AND tr1.fieldname='title'
				JOIN translates tr2 ON tr2.ref_table='articles' AND tr2.ref_id=a.id AND tr2.lang=:lang AND tr2.fieldname='post'
				JOIN translates tr3 ON tr3.ref_table='articles' AND tr3.ref_id=a.id AND tr3.lang=:lang AND tr3.fieldname='is_published_lang' AND tr3.text='1'
				LEFT JOIN (
						SELECT article_id, MIN(category_id) AS category_id
						FROM articles_cats_rel
						GROUP BY article_id
					) acr ON acr.article_id=a.id
				LEFT JOIN menu m ON m.id=acr.category_id AND m.is_deleted='0' AND m.parent_id='0' AND m.type='category'
				LEFT JOIN translates tr4 ON tr4.ref_table='menu' AND tr4.ref_id=m.id AND tr4.lang=:lang AND tr4.fieldname='name'
			WHERE a.is_deleted='0' AND a.is_published='1' AND a.publish_datetime<=:time AND a.show_on_main_page='1'
			ORDER BY a.publish_datetime DESC, a.id DESC
			LIMIT ".(int)$limit;
		$params = [
			':time' => date('Y-m-d H:i:s'),
			':lang' => $ln
		];

		// print "<pre>".Yii::$app->db->createCommand($sql, $params)->rawSql; die();
		$content = Yii::$app->db->createCommand($sql, $params)->queryAll();

		return $content;
	}

	public static function getCategoryBySef($sef) {
		$ln = explode('-', Yii::$app->language)[0];
		$sql = "SELECT m.id, m.sef, tr.text AS name
			FROM menu m
				JOIN translates tr ON tr.ref_table='menu' AND tr.ref_id=m.id AND tr.lang=:lang AND tr.fieldname='name'
			WHERE m.is_deleted='0' AND m.parent_id='0' AND m.type='category' AND m.sef=:sef AND m.is_published='1'
			LIMIT 1";
		$params = [
			':sef' => $sef,
			':lang' => $ln,
		];

		$category = Yii::$app->db->createCommand($sql, $params)->queryOne();

		return $category;
	}

	public static function getPostById($id, $category_id = null) {
		$ln = explode('-', Yii::$app->language)[0];
		$sql = "SELECT a.id, a.sef, a.img, a.publish_datetime, a.is_highlighted,
				tr1.text AS `title`, tr2.text AS `post`
			FROM articles a
				JOIN translates tr1 ON tr1.ref_table='articles' AND tr1.ref_id=a.id AND tr1.lang=:lang AND tr1.fieldname='title'
				JOIN translates tr2 ON tr2.ref_table='articles' AND tr2.ref_id=a.id AND tr2.lang=:lang AND tr2.fieldname='post'
				JOIN translates tr3 ON tr3.ref_table='articles' AND tr3.ref_id=a.id AND tr3.lang=:lang AND tr3.fieldname='is_published_lang' AND tr3.text='1'
				".(!empty($category_id)? "JOIN articles_cats_rel acr ON acr.article_id=a.id AND acr.category_id=:category_id": "")."
			WHERE a.is_deleted='0' AND a.is_published='1' AND a.publish_datetime<=:time AND a.id=:id
			LIMIT 1";
		$params = [
			':time' => date('Y-m-d H:i:s'),
			':lang' => $ln,
			':id' => $id,
		];
		if (!empty($category_id)) {
			$params[':category_id'] = $category_id;
		}

		$post = Yii::$app->db->createCommand($sql, $params)->queryOne();

		return $post;
	}

	public static function getCategoryLatest($category_id, $limit) {
		$ln = explode('-', Yii::$app->language)[0];
		$sql = "SELECT a.id, a.sef, a.img, a.publish_datetime, a.is_highlighted,
				tr1.text AS `title`, tr2.text AS `post`,
				acr.category_id, m.sef AS category_sef, tr4.text AS category_name
			FROM articles a
				JOIN translates tr1 ON tr1.ref_table='articles' AND tr1.ref_id=a.id AND tr1.lang=:lang AND tr1.fieldname='title'
				JOIN translates tr2 ON tr2.ref_table='articles' AND tr2.ref_id=a.id AND tr2.lang=:lang AND tr2.fieldname='post'
				JOIN translates tr3 ON tr3.ref_table='articles' AND tr3.ref_id=a.id AND tr3.lang=:lang AND tr3.fieldname='is_published_lang' AND tr3.text='1'
				JOIN articles_cats_rel acr ON acr.article_id=a.id AND acr.category_id=:category_id
				LEFT JOIN menu m ON m.id=acr.category_id AND m.is_deleted='0' AND m.parent_id='0' AND m.type='category'
				LEFT JOIN translates tr4 ON tr4.ref_table='menu' AND tr4.ref_id=m.id AND tr4.lang=:lang AND tr4.fieldname='name'
			WHERE a.is_deleted='0' AND a.is_published='1' AND a.publish_datetime<=:time
			ORDER BY a.publish_datetime DESC, a.id DESC
			LIMIT ".(int)$limit;
		$params = [
			':time' => date('Y-m-d H:i:s'),
			':lang' => $ln,
			':category_id' => $category_id,
		];

		// print "<pre>".Yii::$app->db->createCommand($sql, $params)->rawSql; die();
		$content = Yii::$app->db->createCommand($sql, $params)->queryAll();

		return $content;
	}

	public static function getCategoryPostsNum($category_id) {
		$ln = explode('-', Yii::$app->language)[0];
		$sql = "SELECT COUNT(*)
			FROM articles a
				JOIN translates tr1 ON tr1.ref_table='articles' AND tr1.ref_id=a.id AND tr1.lang=:lang AND tr1.fieldname='title'
				JOIN translates tr2 ON tr2.ref_table='articles' AND tr2.ref_id=a.id AND tr2.lang=:lang AND tr2.fieldname='post'
				JOIN translates tr3 ON tr3.ref_table='articles' AND tr3.ref_id=a.id AND tr3.lang=:lang AND tr3.fieldname='is_published_lang' AND tr3.text='1'
				JOIN articles_cats_rel acr ON acr.article_id=a.id AND acr.category_id=:category_id
			WHERE a.is_deleted='0' AND a.is_published='1' AND a.publish_datetime<=:time";
		$params = [
			':time' => date('Y-m-d H:i:s'),
			':lang' => $ln,
			':category_id' => $category_id,
		];

		return Yii::$app->db->createCommand($sql, $params)->queryScalar();
	}

	public static function getCategoryPostsList($category_id, $pg) {
		$ln = explode('-', Yii::$app->language)[0];
		$sql = "SELECT a.id, a.sef, a.img, a.publish_datetime, a.is_highlighted,
				tr1.text AS `title`, tr2.text AS `post`,
				acr.category_id
			FROM articles a
				JOIN translates tr1 ON tr1.ref_table='articles' AND tr1.ref_id=a.id AND tr1.lang=:lang AND tr1.fieldname='title'
				JOIN translates tr2 ON tr2.ref_table='articles' AND tr2.ref_id=a.id AND tr2.lang=:lang AND tr2.fieldname='post'
				JOIN translates tr3 ON tr3.ref_table='articles' AND tr3.ref_id=a.id AND tr3.lang=:lang AND tr3.fieldname='is_published_lang' AND tr3.text='1'
				JOIN articles_cats_rel acr ON acr.article_id=a.id AND acr.category_id=:category_id
			WHERE a.is_deleted='0' AND a.is_published='1' AND a.publish_datetime<=:time
			ORDER BY a.publish_datetime DESC, a.id DESC
			LIMIT {$pg->limit} OFFSET {$pg->offset}";
		$params = [
			':time' => date('Y-m-d H:i:s'),
			':lang' => $ln,
			':category_id' => $category_id,
		];

		return Yii::$app->db->createCommand($sql, $params)->queryAll();
	}

	public static function getUrls($ln = 'en') {
		$urls = [];
		$urls[] = self::url(['site/home', 'lang' => $ln], null, 'daily', '1.0');
		$urls[] = self::url(['site/contacts', 'lang' => $ln], date('Y-m-d', filemtime(Yii::getAlias('@app/views/site/contacts.php'))), 'monthly', '0.5');
		$cat_urls = self::getCatUrls($ln);
		$urls = array_merge($urls, $cat_urls);
		unset($cat_urls);
		$post_urls = self::getPostUrls($ln);
		$urls = array_merge($urls, $post_urls);
		unset($post_urls);
		return $urls;
	}

	private static function url($url, $lastmod = null, $changefreq = 'weekly', $priority = '0.7') {
		if (is_array($url)) {
			$url = \yii\helpers\Url::toRoute($url, true);
		}
		return [
			'loc' => $url,
			'lastmod' => $lastmod ?: date('Y-m-d'),
			'changefreq' => $changefreq,
			'priority' => $priority,
		];
	}

	private static function getCatUrls($ln = 'en') {
		$sql = "SELECT m.id, m.sef
			FROM menu m
				JOIN translates tr ON tr.ref_table='menu' AND tr.ref_id=m.id AND tr.lang=:lang AND tr.fieldname='name'
			WHERE m.is_deleted='0' AND m.parent_id='0' AND m.type='category' AND m.is_published='1'";
		$params = [
			':lang' => $ln,
		];

		$categories = Yii::$app->db->createCommand($sql, $params)->queryAll();

		$urls = [];
		foreach ($categories as $cat) {
			$lastmod = null;
			if (self::$seo_cat_lastmod==true) {
				$lastmod = self::getCatLastMod($cat['id'], $ln);
				if (empty($lastmod)) {
					continue;
				}
			}
			$urls[] = self::url(['content/category', 'category_sef' => $cat['sef'], 'lang' => $ln], $lastmod, self::$seo['category']['changefreq'], self::$seo['category']['priority']);
		}

		return $urls;
	}

	private static function getCatLastMod($category_id, $ln = 'en') {
		$sql = "SELECT DATE(MAX(IFNULL(tmp.mod_datetime, tmp.add_datetime))) FROM (
			SELECT a.id, a.add_datetime, a.mod_datetime
					FROM articles a
						JOIN articles_cats_rel acr ON acr.article_id=a.id AND acr.category_id=:category_id
						JOIN translates tr2 ON tr2.ref_table='articles' AND tr2.ref_id=a.id AND tr2.lang=:ln AND tr2.fieldname='is_published_lang' AND tr2.text='1'
				WHERE a.is_deleted='0' AND a.is_published='1' AND a.publish_datetime<=:time
				ORDER BY a.id DESC
				LIMIT 50) AS tmp";
		$params = [
			':category_id' => $category_id,
			':ln' => $ln,
			':time' => date('Y-m-d H:i:s'),
		];

		return Yii::$app->db->createCommand($sql, $params)->queryScalar();
	}

	private static function getPostUrls($ln = 'en') {
		$sql = "SELECT a.id, DATE(IFNULL(a.mod_datetime, a.add_datetime)) AS lastmod, acr.category_id, m.sef AS category_sef
			FROM articles a
				JOIN translates tr3 ON tr3.ref_table='articles' AND tr3.ref_id=a.id AND tr3.lang=:lang AND tr3.fieldname='is_published_lang' AND tr3.text='1'
				JOIN (
						SELECT article_id, MIN(category_id) AS category_id
						FROM articles_cats_rel
						GROUP BY article_id
					) acr ON acr.article_id=a.id
				JOIN menu m ON m.id=acr.category_id AND m.is_deleted='0' AND m.parent_id='0' AND m.type='category'
			WHERE a.is_deleted='0' AND a.is_published='1' AND a.publish_datetime<=:time";
		$params = [
			':time' => date('Y-m-d H:i:s'),
			':lang' => $ln,
		];

		$posts = Yii::$app->db->createCommand($sql, $params)->queryAll();

		$urls = [];
		foreach ($posts as $post) {
			$urls[] = self::url(['content/post', 'category_sef' => $post['category_sef'], 'id' => $post['id'], 'lang' => $ln], $post['lastmod'], self::$seo['post']['changefreq'], self::$seo['post']['priority']);
		}

		return $urls;
	}

}
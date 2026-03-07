<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\helpers\Utils;


class Content extends Model {

	public static $curr_pg = 1;
	public static $pp = 2;
	public static $pages_amount = 0;
	public static $items_amount = 0;
	public static $log = [];


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
}
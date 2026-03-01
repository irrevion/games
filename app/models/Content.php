<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\helpers\Utils;


class Content extends Model {

	public static $curr_pg = 1;
	public static $pp = INF;
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

	public static function countTotal() {
		$sql = "SELECT COUNT(id) AS c
			FROM content
			WHERE is_deleted='0' AND lang=:lang AND is_published='1' AND publish_datetime<=:time";
		$params = [
			':time' => date('Y-m-d H:i:s'),
			':lang' => Yii::$app->language,
		];

		$count = Yii::$app->db->createCommand($sql, $params)->queryScalar();

		return $count;
	}

	public static function getLatest($limit) {
		$sql = "SELECT *
			FROM content
			WHERE is_deleted='0' AND lang=:lang AND is_published='1' AND publish_datetime<=:time
			ORDER BY publish_datetime DESC
			LIMIT ".(int)$limit;
		$params = [
			':time' => date('Y-m-d H:i:s'),
			':lang' => Yii::$app->language,
		];

		// print "<pre>".Yii::$app->db->createCommand($sql, $params)->rawSql; die();
		$content = Yii::$app->db->createCommand($sql, $params)->queryAll();

		return $content;
	}

	public static function getPage($id) {
		$sql = "SELECT *
			FROM content
			WHERE id=:id AND lang=:lang AND is_published='1'
			LIMIT 1";
		$params = [
			':id' => $id,
			':lang' => Yii::$app->language,
		];

		$page = Yii::$app->db->createCommand($sql, $params)->queryOne();

		return $page;
	}

	/*public static function getWhoWeArePageExtraData($id) {
		$sql = "SELECT * FROM content_extra WHERE content_id=:id";
		$params = [':id' => $id];

		$extra_data = Yii::$app->db->createCommand($sql, $params)->queryAll();
		if (!empty($extra_data)) {
			$extra_data_processed = [];
			foreach ($extra_data as $f) {
				$field_info = [];
				$match = preg_match('/^block_(\d+)_(\w+)$/', $f['field_name'], $field_info);
				$block_index = $field_info[1]-1;
				$field_name = $field_info[2];
				$extra_data_processed[$block_index][$field_name] = $f['field_value'];
			}
			$extra_data = $extra_data_processed;
		}

		return $extra_data;
	}*/

	public static function getPageByRoute($route) {
		$sql = "SELECT *
			FROM content
			WHERE is_published='1' AND route=:route AND lang=:lang
			LIMIT 1";
		$params = [
			':route' => $route,
			':lang' => Yii::$app->language,
		];

		$page = Yii::$app->db->createCommand($sql, $params)->queryOne();

		return $page;
	}

	public static function getSearchDataTable($GET_data) {
		$list = [];

		$where = [];
		$params = [];

		$where[] = "is_published='1'";
		$where[] = "show_in_search='1'";
		$where[] = "lang=:lang";
		$params[':lang'] = Yii::$app->language;

		$q = @(string)$GET_data['q'];
		$q = trim($q);
		$q_length = mb_strlen($q, 'UTF-8');
		if ($q_length<2) {
			return $list;
		}

		if (!empty($q)) {
			if (Yii::$app->language=='az') {
				$q_low = Utils::az_lower($q);
				$q_up = Utils::az_upper($q);
				$where[] = "(
					keywords LIKE :q_low OR keywords LIKE :q_up
				)";
				$params[':q_low'] = '%'.$q_low.'%';
				$params[':q_up'] = '%'.$q_up.'%';
			} else {
				$where[] = "(
					keywords LIKE :q
				)";
				$params[':q'] = '%'.Utils::makeSearchable($q).'%';
			}
		}

		$where = (empty($where)? '': ('WHERE '.implode(' AND ', $where)));


		$list_sql = "SELECT *
			FROM `content`
			{$where}
			ORDER BY title ASC";
		$list = Yii::$app->db->createCommand($list_sql, $params)->queryAll();

		self::$items_amount = (is_array($list)? count($list): '0');
		self::$pages_amount = ceil(self::$items_amount/self::$pp);

		return $list;
	}
}
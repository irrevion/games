<?php

namespace app\helpers;

use Yii;

class Out {

	public static $icons = [
		'feed' => 'dove',
		'news' => 'newspaper',
		'reviews' => 'star-half-stroke',
		'tips' => 'lightbulb',
	];

	public static function md2html($md) {
		$config = \HTMLPurifier_Config::createDefault();
		$config->set('HTML.Allowed', 'p,br,hr,strong,em,b,i,u,s,ul,ol,li,blockquote,code,pre,h1,h2,h3,h4,h5,h6,table,thead,tbody,tr,th,td,a[href|title|target],img[src|alt|title]');
		$config->set('Attr.AllowedFrameTargets', ['_blank']);
		$config->set('URI.AllowedSchemes', ['http','https','mailto']);

		// $md = strip_tags($md);
		$parser = new \app\components\SafeMarkdown();
		$parser->enableNewlines = true;
		$parser->html5 = true;
		$html = $parser->parse($md);
		$html = (new \HTMLPurifier($config))->purify($html);

		return $html;
	}

	public static function md2text($md, $len=320) {
		$html = self::md2html($md);
		$text = Utils::html2text($html);
		$text = Utils::limitStringLength($text, $len);
		return $text;
	}

	public static function short($md, $len=320, $more='...') {
		// return nl2br(htmlentities(self::md2text($md, $len)));
		$html = self::md2html($md);
		$text = Utils::html2text($html);
		$text = Utils::truncateByWords($text, $len, $more);
		$text = nl2br(htmlentities($text));
		return $text;
	}

	public static function catIco($cat_sef) {
		return ('<i class="fas fa-'.(self::$icons[$cat_sef] ?? 'gamepad').'"></i>');
	}

	public static function pubTS($datetime) {
		$ts = strtotime($datetime);
		Yii::$app->formatter->timeZone = Yii::$app->timeZone;
		$when = Yii::$app->formatter->asRelativeTime($ts);
		$time = Yii::$app->formatter->asTime($ts, 'short');
		return Yii::t('app', 'published_when_at', ['when' => $when, 'time' => $time]);
	}
}
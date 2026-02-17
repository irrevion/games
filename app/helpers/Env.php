<?php

namespace app\helpers;

class Env {

	public static $loaded = false;
	public static $load_path = '../';
	public static $use_cache = false;
	public static $cache = [];

	public static function get(string $key, ?string $default=null): mixed {
		if (!self::$loaded) self::load(self::$load_path);
		$val = (self::$use_cache? self::$cache[$key]: getenv($key));
		if ($val===false) $val = null;
		return ($val ?? $default);
	}

	protected static function load(string $path='../'): void {
		self::$cache = parse_ini_file($path.'.env', false, INI_SCANNER_NORMAL);
		if (self::$cache) foreach (self::$cache as $k=>$v) {putenv("$k=$v");}
		self::$loaded = true;
	}
}

?>
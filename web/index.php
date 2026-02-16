<?php
error_reporting(E_ALL & ~E_DEPRECATED);
ini_set('display_errors', true);
ini_set('html_errors', true);

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require('../../__yii2/helpers/Env.php');
// require __DIR__ . '/../../__yii2/vendor/autoload.php';
require app\helpers\Env::get('vendor_dir').'autoload.php';
require app\helpers\Env::get('vendor_dir').'yiisoft/yii2/Yii.php';

$config = require app\helpers\Env::get('config_dir').'web.php';

(new yii\web\Application($config))->run();

<?php
namespace app\components;

use yii\web\UrlRule;

class LangUrlRule extends UrlRule
{
    /* default language that should not be included in the URL */
    public string $defaultLang = 'en';

    public function createUrl($manager, $route, $params)
    {
        // If lang=en was passed, remove it to avoid generating /en/...
        if (isset($params['lang']) && $params['lang'] === $this->defaultLang) {
            unset($params['lang']);
        }

        return parent::createUrl($manager, $route, $params);
    }
}
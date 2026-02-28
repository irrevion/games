<?php
namespace app\components;

use yii\web\UrlManager;

class LangUrlManager extends UrlManager
{
    public string $defaultLang = 'en';

    public function createUrl($params)
    {
        // $params = ['route', 'lang' => 'en', ...] или ['route' => ..., ...]
        /*if (is_array($params)) {
            // route может быть в [0] или 'route' — Yii2 принимает оба варианта
            if (isset($params['lang'])) {
                $lang = (string)$params['lang'];

                // считаем дефолтным: en, en-US, en_US
                if ($lang === $this->defaultLang || stripos($lang, $this->defaultLang . '-') === 0 || stripos($lang, $this->defaultLang . '_') === 0) {
                    unset($params['lang']);
                } else {
                    // нормализуем, чтобы правила (en|es) матчились даже если прилетело es-ES
                    if (stripos($lang, 'es') === 0) {
                        $params['lang'] = 'es';
                    } elseif (stripos($lang, 'en') === 0) {
                        $params['lang'] = 'en';
                    }
                }
            }
        }*/

        // If lang=en was passed, remove it to avoid generating /en/...
        if (isset($params['lang']) && $params['lang'] === $this->defaultLang) {
            unset($params['lang']);
        }

        return parent::createUrl($params);
    }
}
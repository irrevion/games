<?php

namespace app\components;

use cebe\markdown\GithubMarkdown;

class SafeMarkdown extends GithubMarkdown
{
    protected function renderLink($block)
    {
        $url = $block['url'];
        $text = $this->renderAbsy($block['text']);

        $attrs = [
            'href' => $url,
        ];

        if ($this->isExternal($url)) {
            $attrs['target'] = '_blank';
            $attrs['rel'] = 'noopener noreferrer';
        }

        return '<a' . $this->renderAttributes($attrs) . '>' . $text . '</a>';
    }

    protected function isExternal($url)
    {
        // We consider relative links to be internal
        if (strpos($url, '/') === 0) {
            return false;
        }

        if (!preg_match('#^https?://#i', $url)) {
            return false;
        }

        $host = parse_url($url, PHP_URL_HOST);
        $currentHost = $_SERVER['HTTP_HOST'] ?? '';

        return $host && strcasecmp($host, $currentHost) !== 0;
    }

    protected function renderAttributes($attrs)
    {
        $html = '';
        foreach ($attrs as $name => $value) {
            $html .= ' ' . $name . '="' . htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '"';
        }
        return $html;
    }
}
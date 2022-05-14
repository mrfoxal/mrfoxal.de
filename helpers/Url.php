<?php

namespace app\helpers;

use yii\helpers\Html;

/**
 * Url helper
 */
class Url
{

    /**
     * Returns query string
     *
     * @param array $params Params
     *
     * @return string
     */
    public static function getQueryString(array $params)
    {
        // Remove page number if page=1
        if (isset($params['page']) && $params['page'] == 1) {
            unset($params['page'], $params['per-page']);
        }

        if (!count($params)) {
            return '';
        }

        return '?' . http_build_query($params);
    }

    /**
     * Generate icon href
     *
     * Input is a string of links -> each link on new line
     *
     * @param string $list
     * @return string
     */
    public static function generateIconHref(string $list): string
    {
        $output = '';
        $items = explode(PHP_EOL, $list);

        if (isset($items)) {
            foreach ($items as $item) {
                $output .= Html::a(
                    Html::img('https://www.google.com/s2/favicons?domain=' . $item),
                    $item,
                    [
                        'target' => '_blank',
                        'rel' => 'nofollow',
                    ]
                );
                $output .= ' ';
            }
        }

        return $output;
    }
}

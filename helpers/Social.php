<?php

namespace app\helpers;

use yii\httpclient\Client;

/**
 * Social helper
 */
class Social
{
    /**
     * @param string $account
     * @return int|null
     */
    public static function getTwitterCount(string $account): ?int
    {
        try {
            $client = new Client();

            $response = $client->createRequest()
                ->setMethod('GET')
                ->setUrl('https://cdn.syndication.twimg.com/widgets/followbutton/info.json?screen_names=' . $account)
                ->send();

            $data = $response->getData();

            if (!empty($data)) {
                return (int) $data[0]['followers_count'] ?? null;
            }

        } catch (\Exception $exception) {
            // nothing to do, skip
        }

        return null;
    }

    /**
     * @param string $account
     * @return int|null
     */
    public static function getTelegramCount(string $account): ?int
    {
        try {
            $html = file_get_contents('https://t.me/' . $account);

            preg_match_all('#(.*?) members, (.*?) online#', $html, $matches);

            return (int) filter_var($matches[1][0], FILTER_SANITIZE_NUMBER_INT);
        } catch (\Exception $exception) {
            // nothing to do, skip
        }

        return null;
    }
}

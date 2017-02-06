<?php

namespace Munouni\Instagram\HttpClients;

use Munouni\Instagram\Http\InstagramRawResponse;

interface InstagramHttpClientInterface
{
    /**
     * @param string $url
     * @param string $method
     * @param array $params
     * @param int $timeOut
     * @return InstagramRawResponse
     */
    public function send($url, $method, $params, $timeOut = 0);
}

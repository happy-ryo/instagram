<?php

namespace Munouni\Instagram\Tests\HttpClients;

use Munouni\Instagram\Http\InstagramRawResponse;
use Munouni\Instagram\HttpClients\InstagramHttpClientInterface;

class InstagramOAuthTestHttpClients implements InstagramHttpClientInterface
{

    /**
     * @param string $url
     * @param string $method
     * @param array $params
     * @param int $timeOut
     * @return InstagramRawResponse
     */
    public function send($url, $method, $params, $timeOut = 0)
    {
        return new InstagramRawResponse('Expires:Sat, 01 Jan 2000 00:00:00 GMT
Content-Type:application/json; charset=utf-8
Pragma:no-cache
Content-Language:en
x-ratelimit-remaining:7272
Vary:Cookie, Accept-Language, Accept-Encoding
x-ratelimit-limit:5000
Date:Tue, 31 Jan 2017 08:47:14 GMT
Cache-Control:private, no-cache, no-store, must-revalidate
Set-Cookie:s_network=""; expires=Tue, 31-Jan-2017 09:47:14 GMT; Max-Age=3600; Path=/, csrftoken=uWIg9gGuRsd7pCAHJ7WtRY7eJea9PWJL; expires=Tue, 30-Jan-2018 08:47:14 GMT; Max-Age=31449600; Path=/; Secure
Connection:keep-alive
Content-Length:53444', '{
    "access_token": "fb2e77d.47a0479900504cb3ab4a1f626d174d2d",
    "user": {
        "id": "1574083",
        "username": "snoopdogg",
        "full_name": "Snoop Dogg",
        "profile_picture": "..."
    }
}', 200);
    }
}
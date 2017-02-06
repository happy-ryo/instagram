<?php

namespace Munouni\Instagram;

use GuzzleHttp\Client;
use Munouni\Instagram\HttpClients\InstagramGuzzeleHttpClient;
use Munouni\Instagram\HttpClients\InstagramHttpClientInterface;
use Munouni\Instagram\HttpRequests\InstagramRequestInterface;

class InstagramClient
{
    const INSTAGRAM_API_BASE_URL = 'https://api.instagram.com/';
    /**
     * @var InstagramHttpClientInterface
     */
    private $instagramHttpClient;

    /**
     * InstagramClient constructor.
     * @param InstagramHttpClientInterface $instagramHttpClient
     */
    public function __construct(InstagramHttpClientInterface $instagramHttpClient = null)
    {
        $this->instagramHttpClient = $instagramHttpClient ?: new InstagramGuzzeleHttpClient(new Client(['base_uri' => static::INSTAGRAM_API_BASE_URL]));
    }

    public function getBaseUrl()
    {
        return static::INSTAGRAM_API_BASE_URL;
    }

    public function sendRequest(InstagramRequestInterface $instagramRequest)
    {
        $instagramRawResponse = $this->instagramHttpClient->send($instagramRequest->getEndPoint(), $instagramRequest->getMethod(), $instagramRequest->getParams());
        return new InstagramResponse($instagramRequest, $instagramRawResponse->getBody(), $instagramRawResponse->getStatusCode(), $instagramRawResponse->getHeaders());
    }

    /**
     * @return InstagramHttpClientInterface
     */
    public function getInstagramHttpClient()
    {
        return $this->instagramHttpClient;
    }
}

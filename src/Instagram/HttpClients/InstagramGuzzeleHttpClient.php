<?php

namespace Munouni\Instagram\HttpClients;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use Munouni\Instagram\Exception\InstagramAPIException;
use Munouni\Instagram\Http\InstagramRawResponse;
use Psr\Http\Message\ResponseInterface;

class InstagramGuzzeleHttpClient implements InstagramHttpClientInterface
{
    private $guzzleClient;

    /**
     * InstagramGuzzeleHttpClient constructor.
     * @param Client|null $guzzleClient
     */
    public function __construct(Client $guzzleClient = null)
    {
            $this->guzzleClient = $guzzleClient ?: new Client();
    }

    /**
     * @param string $url
     * @param string $method
     * @param array $params
     * @param int $timeOut
     * @return InstagramRawResponse
     * @throws InstagramAPIException
     */
    public function send($url, $method, $params, $timeOut = 0)
    {
        $option = [
            'query'           => $params,
            'timeout'         => $timeOut,
            'connect_timeout' => 10
        ];
        $request = new Request($method, $url);
        try {
            $response = $this->guzzleClient->send($request, $option);
        } catch (ClientException $clientException) {
            throw new InstagramAPIException($clientException->getMessage(), $clientException->getCode());
        } catch (RequestException $requestException) {
            throw new InstagramAPIException($requestException->getMessage(), $requestException->getCode());
        }

        $rawHeaders = $this->getHeadersAsString($response);
        $rawBody = $response->getBody();
        $statusCode = $response->getStatusCode();
        return new InstagramRawResponse($rawHeaders, $rawBody, $statusCode);
    }

    /**
     * @param ResponseInterface $response
     * @return string
     */
    public function getHeadersAsString(ResponseInterface $response)
    {
        $headers = $response->getHeaders();
        $tmpHeaders = [];
        foreach ($headers as $header => $value) {
            $tmpHeaders[] = $header . ':' . implode(', ', $value);
        }
        return implode("\n", $tmpHeaders);
    }
}

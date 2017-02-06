<?php

namespace Munouni\Instagram;

use Munouni\Instagram\Exception\InstagramAPIException;
use Munouni\Instagram\HttpRequests\InstagramAPIRequest;
use Munouni\Instagram\HttpRequests\InstagramOAuthRequest;

class Instagram
{
    const ACCESS_TOKEN = 'INSTAGRAM_ACCESS_TOKEN';
    const DEFAULT_INSTAGRAM_API_VERSION = 'v1';
    const scopes = ['basic', 'public_content', 'follower_list', 'comments', 'relationships', 'likes'];

    private $accessToken;
    private $client;
    private $lastResponse;
    private $apiVersion;
    private $clientId;
    private $clientSecret;
    private $redirectUri;

    /**
     * Instagram constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        if (isset($config['access_token'])) {
            $this->accessToken = $config['access_token'];
        } else {
            $this->accessToken = getenv(static::ACCESS_TOKEN);
        }

        if (isset($config['api_version'])) {
            $this->apiVersion = $config['api_version'];
        } else {
            $this->apiVersion = static::DEFAULT_INSTAGRAM_API_VERSION;
        }

        $this->client = new InstagramClient();

        if (isset($config['client_id'], $config['client_secret'], $config['redirect_uri'])) {
            $this->clientId = $config['client_id'];
            $this->clientSecret = $config['client_secret'];
            $this->redirectUri = $config['redirect_uri'];
        }
    }

    /**
     * @param string $accessToken AccessToken.
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @return string Access token.
     * @throws InstagramAPIException
     */
    public function getAccessToken()
    {
        if (empty($this->accessToken)) {
            throw new InstagramAPIException('Required "access_token"');
        }
        return $this->accessToken;
    }

    /**
     * @return InstagramClient
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @return string
     */
    public function getApiVersion()
    {
        return $this->apiVersion;
    }

    /**
     * @param InstagramClient $client
     */
    public function setClient(InstagramClient $client)
    {
        $this->client = $client;
    }

    /**
     * @return InstagramResponse
     */
    public function getLastResponse()
    {
        return $this->lastResponse;
    }

    /**
     * @param string $method
     * @param string $endPoint
     * @param string[] $params
     * @return InstagramAPIRequest
     * @throws \Munouni\Instagram\Exception\InstagramAPIException
     */
    public function createRequest($method, $endPoint, array $params = [])
    {
        return new InstagramAPIRequest($this->getAccessToken(), $method, $endPoint, $params);
    }

    /**
     * @param string $method
     * @param string $endPoint
     * @param string[] $params
     * @return InstagramResponse
     * @throws \Munouni\Instagram\Exception\InstagramAPIException
     */
    public function sendRequest($method, $endPoint, array $params = [])
    {
        $request = $this->createRequest($method, $this->apiVersion . $endPoint, $params);
        return $this->lastResponse = $this->getClient()->sendRequest($request);
    }

    /**
     * @param string[] $scopes
     * @return string
     * @throws InstagramAPIException
     */
    public function getOAuthUrl(array $scopes = ['basic'])
    {
        if (empty($this->clientId) || empty($this->clientSecret) || empty($this->redirectUri)) {
            throw new InstagramAPIException('Invalid args. client_id,client_secret,redirect_uri needed.');
        }
        if (count(array_diff($scopes, static::scopes)) === 0) {
            return InstagramClient::INSTAGRAM_API_BASE_URL . 'oauth/authorize?response_type=code&client_id=' . $this->clientId . '&redirect_uri=' . $this->redirectUri . '&scope=' . implode('+', $scopes);
        } else {
            throw new InstagramAPIException('Invalid scopes.');
        }
    }

    /**
     * @param string $code
     * @return InstagramOAuthRequest
     */
    public function createOAuthRequest($code)
    {
        return new InstagramOAuthRequest($this->clientId, $this->clientSecret, $code, $this->redirectUri);
    }

    /**
     * @param string $code
     * @param bool $returnOriginalResponse
     * @return null|array|string
     */
    public function getOAuthToken($code, $returnOriginalResponse = false)
    {
        $instagramOAuthRequest = $this->createOAuthRequest($code);
        $response = $this->getClient()->sendRequest($instagramOAuthRequest);
        if ($returnOriginalResponse) {
            return $response->getDecodedBody();
        } else {
            return $response->getDecodedBody()['access_token'];
        }
    }
}

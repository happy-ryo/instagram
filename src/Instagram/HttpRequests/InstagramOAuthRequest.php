<?php
/**
 * Created by PhpStorm.
 * User: happy_ryo
 * Date: 2017/02/02
 * Time: 18:08
 */

namespace Munouni\Instagram\HttpRequests;

class InstagramOAuthRequest implements InstagramRequestInterface
{
    private $params;

    public function __construct($clientId, $clientSecret, $code, $redirectUri)
    {
        $this->params = [
            'client_id'     => $clientId,
            'client_secret' => $clientSecret,
            'code'          => $code,
            'redirect_uri'  => $redirectUri,
            'grant_type'    => 'authorization_code'
        ];
    }

    /**
     * @return string
     */
    public function getEndPoint()
    {
        return 'oauth/access_token';
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return 'POST';
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }
}

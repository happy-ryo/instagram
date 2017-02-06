<?php
/**
 * Created by PhpStorm.
 * User: happy_ryo
 * Date: 2017/01/30
 * Time: 11:57
 */

namespace Munouni\Instagram\HttpRequests;

class InstagramAPIRequest implements InstagramRequestInterface
{
    private $accessToken;
    private $method;
    private $endPoint;
    private $params;

    /**
     * InstagramRequest constructor.
     * @param string $accessToken
     * @param string $method
     * @param string $endPoint
     * @param array $params
     */
    public function __construct($accessToken, $method, $endPoint, array $params = [])
    {
        $this->accessToken = $accessToken;
        $this->method = $method;
        $this->endPoint = $endPoint;
        $this->params = $params;
        $this->params['access_token'] = $accessToken;

        $this->replacementEndPointParams();
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @return string
     */
    public function getEndPoint()
    {
        return $this->endPoint;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    public function replacementEndPointParams()
    {
        preg_match_all('/({[^\/]*})/', $this->endPoint, $m);
        if (is_array($m)) {
            foreach ($m[0] as $value) {
                if (array_key_exists($value, $this->params)) {
                    $param = urlencode($this->params[$value]);
                    unset($this->params[$value]);
                    $this->endPoint = str_replace($value, $param, $this->endPoint);
                }
            }
        }
    }
}

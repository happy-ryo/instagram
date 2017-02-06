<?php

namespace Munouni\Instagram;

use Munouni\Instagram\HttpRequests\InstagramRequestInterface;

class InstagramResponse
{
    /**
     * @var InstagramRequestInterface
     */
    private $instagramRequest;
    /**
     * @var string
     */
    private $body;
    /**
     * @var int
     */
    private $httpStatusCode;
    /**
     * @var string
     */
    private $header;

    /**
     * @var array|null
     */
    private $decodedBody;

    /**
     * InstagramResponse constructor.
     * @param InstagramRequestInterface $instagramRequest
     * @param null $body
     * @param null $httpStatusCode
     * @param array $header
     */
    public function __construct(InstagramRequestInterface $instagramRequest, $body = null, $httpStatusCode = null, $header = null)
    {
        $this->instagramRequest = $instagramRequest;
        $this->body = $body;
        $this->httpStatusCode = $httpStatusCode;
        $this->header = $header;

        $this->decodeBody();
    }

    public function decodeBody()
    {
        $this->decodedBody = json_decode($this->body, true);
    }

    /**
     * @return InstagramRequestInterface
     */
    public function getInstagramRequest()
    {
        return $this->instagramRequest;
    }

    /**
     * @return int
     */
    public function getHttpStatusCode()
    {
        return $this->httpStatusCode;
    }

    /**
     * @return null|array
     */
    public function getDecodedBody()
    {
        return $this->decodedBody;
    }

    /**
     * @return string
     */
    public function getHeader()
    {
        return $this->header;
    }
}

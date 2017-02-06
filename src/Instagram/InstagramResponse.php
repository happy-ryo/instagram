<?php

namespace Munouni\Instagram;

use Munouni\Instagram\Exception\InstagramAPIException;
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
     * @param string $header
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

    /**
     * @return bool result
     */
    public function isExistNextUrl()
    {
        if ($this->getDecodedBody() !== null && array_key_exists('pagination', $this->getDecodedBody())) {
            $pagination = $this->getDecodedBody()['pagination'];
            if (array_key_exists('next_url', $pagination)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return string Next url.
     * @throws InstagramAPIException
     */
    public function getNextUrl()
    {
        if ($this->getDecodedBody() !== null && array_key_exists('pagination', $this->getDecodedBody())) {
            $pagination = $this->getDecodedBody()['pagination'];
            if (array_key_exists('next_url', $pagination)) {
                return $pagination['next_url'];
            }
        }
        throw new InstagramAPIException('Next url not found.');
    }
}

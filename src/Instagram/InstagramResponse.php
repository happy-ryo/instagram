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
     * @var string|null
     */
    private $body;
    /**
     * @var int|null
     */
    private $httpStatusCode;
    /**
     * @var array|null
     */
    private $header;

    /**
     * @var array|null
     */
    private $decodedBody;

    /**
     * InstagramResponse constructor.
     * @param InstagramRequestInterface $instagramRequest
     * @param string|null $body
     * @param int|null $httpStatusCode
     * @param array|null $header
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
     * @return int|null
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
     * @return array|null
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

    /**
     * @return int
     * @throws InstagramAPIException
     */
    public function getRateLimit()
    {
        if ($this->getHeader() !== null && array_key_exists('x-ratelimit-limit', $this->getHeader())) {
            return (int)$this->getHeader()['x-ratelimit-limit'][0];
        }
        throw new InstagramAPIException('x-ratelimit-limit not found.');
    }

    /**
     * @return int
     * @throws InstagramAPIException
     */
    public function getRateLimitRemaining()
    {
        if ($this->getHeader() !== null && array_key_exists('x-ratelimit-remaining', $this->getHeader())) {
            return (int)$this->getHeader()['x-ratelimit-remaining'][0];
        }
        throw new InstagramAPIException('x-ratelimit-remaining not found.');
    }

    /**
     * @return bool
     */
    public function isExistRateLimit()
    {
        return $this->getHeader() !== null && array_key_exists('x-ratelimit-limit', $this->getHeader());
    }
}

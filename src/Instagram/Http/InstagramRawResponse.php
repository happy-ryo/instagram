<?php

namespace Munouni\Instagram\Http;

class InstagramRawResponse
{
    private $headers;
    private $body;
    private $statusCode;

    /**
     * InstagramRawResponse constructor.
     * @param string $headers
     * @param string $body
     * @param int $statusCode
     */
    public function __construct($headers, $body, $statusCode)
    {
        $this->headers = $headers;
        $this->body = $body;
        $this->statusCode = $statusCode;
    }

    /**
     * @return string
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }
}

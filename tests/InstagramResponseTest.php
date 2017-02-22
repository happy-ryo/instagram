<?php
/**
 * Created by PhpStorm.
 * User: happy_ryo
 * Date: 2017/02/06
 * Time: 18:00
 */

namespace Munouni\Instagram;

use Munouni\Instagram\HttpRequests\InstagramAPIRequest;
use Munouni\Instagram\Tests\HttpClients\AbstractTestHttpClient;

class InstagramResponseTest extends AbstractTestHttpClient
{
    public function testInitialize()
    {
        $instagramAPIRequest = new InstagramAPIRequest('token', 'GET', '/chihaya');
        $instagramResponse = new InstagramResponse($instagramAPIRequest, $this->fakeRawBody, 200, $this->fakeHeadersAsArray);
        $this->assertEquals($instagramAPIRequest, $instagramResponse->getInstagramRequest());
        $this->assertEquals(200, $instagramResponse->getHttpStatusCode());
        $this->assertEquals($this->fakeDecodeBody, $instagramResponse->getDecodedBody());
        $this->assertEquals($this->fakeHeadersAsArray, $instagramResponse->getHeader());
    }

    public function testIsExistNextUrl()
    {
        $instagramAPIRequest = new InstagramAPIRequest('token', 'GET', '/chihaya');
        $instagramResponse = new InstagramResponse($instagramAPIRequest, $this->fakeRawBodyNextUrl, 200, $this->fakeHeadersAsArray);
        $this->assertTrue($instagramResponse->isExistNextUrl());
    }

    public function testNotExistNextUrl()
    {
        $instagramAPIRequest = new InstagramAPIRequest('token', 'GET', '/chihaya');
        $instagramResponse = new InstagramResponse($instagramAPIRequest, $this->fakeRawBody, 200, $this->fakeHeadersAsArray);
        $this->assertFalse($instagramResponse->isExistNextUrl());
    }

    public function testGetNextUrl()
    {
        $instagramAPIRequest = new InstagramAPIRequest('token', 'GET', '/chihaya');
        $instagramResponse = new InstagramResponse($instagramAPIRequest, $this->fakeRawBodyNextUrl, 200, $this->fakeHeadersAsArray);
        $this->assertEquals('http://next.com', $instagramResponse->getNextUrl());
    }

    /**
     * @expectedException \Munouni\Instagram\Exception\InstagramAPIException
     */
    public function testFailGetNextUrl()
    {
        $instagramAPIRequest = new InstagramAPIRequest('token', 'GET', '/chihaya');
        $instagramResponse = new InstagramResponse($instagramAPIRequest, $this->fakeRawBody, 200, $this->fakeHeadersAsArray);
        $instagramResponse->getNextUrl();
    }

    public function testGetRatelimit()
    {
        $instagramAPIRequest = new InstagramAPIRequest('token', 'GET', '/chihaya');
        $instagramResponse = new InstagramResponse($instagramAPIRequest, $this->fakeRawBodyNextUrl, 200, $this->fakeHeadersAsArray);
        $this->assertEquals(5000, $instagramResponse->getRateLimit());
    }

    /**
     * @expectedException  \Munouni\Instagram\Exception\InstagramAPIException
     */
    public function testFailGetRateLimitLimit()
    {
        $instagramAPIRequest = new InstagramAPIRequest('token', 'GET', '/chihaya');
        $instagramResponse = new InstagramResponse($instagramAPIRequest);
        $instagramResponse->getRateLimit();
    }

    public function testGetRateLimitRemaining()
    {
        $instagramAPIRequest = new InstagramAPIRequest('token', 'GET', '/chihaya');
        $instagramResponse = new InstagramResponse($instagramAPIRequest, $this->fakeRawBodyNextUrl, 200, $this->fakeHeadersAsArray);
        $this->assertEquals(7272, $instagramResponse->getRateLimitRemaining());
    }

    /**
     * @expectedException  \Munouni\Instagram\Exception\InstagramAPIException
     */
    public function testFailGetRateLimitRemaining()
    {
        $instagramAPIRequest = new InstagramAPIRequest('token', 'GET', '/chihaya');
        $instagramResponse = new InstagramResponse($instagramAPIRequest);
        $instagramResponse->getRateLimitRemaining();
    }

    public function testIsExistRateLimit()
    {
        $instagramAPIRequest = new InstagramAPIRequest('token', 'GET', '/chihaya');
        $instagramResponse = new InstagramResponse($instagramAPIRequest, $this->fakeRawBodyNextUrl, 200, $this->fakeHeadersAsArray);
        $this->assertTrue($instagramResponse->isExistRateLimit());
    }

    public function testFailIsExistRateLimit()
    {
        $instagramAPIRequest = new InstagramAPIRequest('token', 'GET', '/chihaya');
        $instagramResponse = new InstagramResponse($instagramAPIRequest);
        $this->assertFalse($instagramResponse->isExistRateLimit());
    }
}

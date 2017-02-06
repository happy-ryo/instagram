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
        $instagramResponse = new InstagramResponse($instagramAPIRequest, $this->fakeRawBody, 200, $this->fakeRawHeader);
        $this->assertEquals($instagramAPIRequest, $instagramResponse->getInstagramRequest());
        $this->assertEquals(200, $instagramResponse->getHttpStatusCode());
        $this->assertEquals($this->fakeDecodeBody, $instagramResponse->getDecodedBody());
        $this->assertEquals($this->fakeRawHeader, $instagramResponse->getHeader());
    }

    public function testIsExistNextUrl()
    {
        $instagramAPIRequest = new InstagramAPIRequest('token', 'GET', '/chihaya');
        $instagramResponse = new InstagramResponse($instagramAPIRequest, $this->fakeRawBodyNextUrl, 200, $this->fakeRawHeader);
        $this->assertTrue($instagramResponse->isExistNextUrl());
    }

    public function testNotExistNextUrl()
    {
        $instagramAPIRequest = new InstagramAPIRequest('token', 'GET', '/chihaya');
        $instagramResponse = new InstagramResponse($instagramAPIRequest, $this->fakeRawBody, 200, $this->fakeRawHeader);
        $this->assertFalse($instagramResponse->isExistNextUrl());
    }

    public function testGetNextUrl()
    {
        $instagramAPIRequest = new InstagramAPIRequest('token', 'GET', '/chihaya');
        $instagramResponse = new InstagramResponse($instagramAPIRequest, $this->fakeRawBodyNextUrl, 200, $this->fakeRawHeader);
        $this->assertEquals('http://next.com', $instagramResponse->getNextUrl());
    }

    /**
     * @expectedException \Munouni\Instagram\Exception\InstagramAPIException
     */
    public function testFailGetNextUrl()
    {
        $instagramAPIRequest = new InstagramAPIRequest('token', 'GET', '/chihaya');
        $instagramResponse = new InstagramResponse($instagramAPIRequest, $this->fakeRawBody, 200, $this->fakeRawHeader);
        $instagramResponse->getNextUrl();
    }
}

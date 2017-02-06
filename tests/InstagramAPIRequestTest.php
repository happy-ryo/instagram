<?php

namespace Munouni\Instagram\Tests;

use Munouni\Instagram\HttpRequests\InstagramAPIRequest;

class InstagramAPIRequestTest extends \PHPUnit_Framework_TestCase
{

    public function testInitialize()
    {
        $instagramRequest = new InstagramAPIRequest('token', 'GET', '/chihaya', ['chihaya' => 'asami']);
        $this->assertEquals('token', $instagramRequest->getAccessToken());
        $this->assertEquals('GET', $instagramRequest->getMethod());
        $this->assertEquals('/chihaya', $instagramRequest->getEndPoint());
        $this->assertArrayHasKey('chihaya', $instagramRequest->getParams());
        $this->assertEquals('asami', $instagramRequest->getParams()['chihaya']);
    }

    public function testReplacementEndPointParams()
    {
        $instagramRequest = new InstagramAPIRequest('token', 'GET', '/chihaya/{value}/kku', ['{value}' => 72]);
        $this->assertEquals('/chihaya/72/kku', $instagramRequest->getEndPoint());
        $this->assertArrayHasKey('access_token', $instagramRequest->getParams());
    }

    public function testReplacementEndPointParamsAndUrlEncode()
    {
        $instagramRequest = new InstagramAPIRequest('token', 'GET', '/kisaragi/{name}/{value}/kku', ['{name}' => '千早', '{value}' => 72]);
        $this->assertEquals('/kisaragi/%E5%8D%83%E6%97%A9/72/kku', $instagramRequest->getEndPoint());
        $this->assertArrayHasKey('access_token', $instagramRequest->getParams());
    }
}

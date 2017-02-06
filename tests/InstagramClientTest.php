<?php

namespace Munouni\Instagram\Tests;

use Munouni\Instagram\HttpClients\InstagramGuzzeleHttpClient;
use Munouni\Instagram\HttpRequests\InstagramAPIRequest;
use Munouni\Instagram\InstagramClient;
use Munouni\Instagram\Tests\HttpClients\AbstractTestHttpClient;
use Munouni\Instagram\Tests\HttpClients\InstagramTestHttpClients;

class InstagramClientTest extends AbstractTestHttpClient
{
    public function testInitialize()
    {
        $instagramClient = new InstagramClient();
        $this->assertInstanceOf(InstagramGuzzeleHttpClient::class, $instagramClient->getInstagramHttpClient());
    }

    public function testInitializeWithHttpClient()
    {
        $instagramClient = new InstagramClient(new InstagramTestHttpClients());
        $this->assertInstanceOf(InstagramTestHttpClients::class, $instagramClient->getInstagramHttpClient());
    }

    public function testSendRequest()
    {
        $instagramClient = new InstagramClient(new InstagramTestHttpClients());
        $instagramRequest = new InstagramAPIRequest('token', 'GET', '/chihaya');
        $instagramResponse = $instagramClient->sendRequest($instagramRequest);
        $this->assertEquals(200, $instagramResponse->getHttpStatusCode());
        $this->assertEquals($this->fakeDecodeBody, json_decode(json_encode($instagramResponse->getDecodedBody()), true));
        $this->assertEquals($this->fakeRawHeader, $instagramResponse->getHeader());
        $this->assertEquals($instagramRequest, $instagramResponse->getInstagramRequest());
        $this->assertEquals('token', $instagramRequest->getParams()['access_token']);
    }
}

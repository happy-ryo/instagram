<?php

namespace Munouni\Instagram\Tests\HttpClients;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Munouni\Instagram\Http\InstagramRawResponse;
use Munouni\Instagram\HttpClients\InstagramGuzzeleHttpClient;
use Mockery as m;

class InstagramGuzzeleTestHttpClient extends AbstractTestHttpClient
{
    private $clientMock;
    /* @var InstagramGuzzeleHttpClient */
    private $instagramClient;

    protected function setUp()
    {
        $this->clientMock = m::mock(Client::class);
        $this->instagramClient = new InstagramGuzzeleHttpClient($this->clientMock);
    }

    public function testNormalRequest()
    {
        $response = new Response(200, $this->fakeHeadersAsArray, $this->fakeRawBody);
        $this->clientMock
            ->shouldReceive('send')
            ->once()
            ->andReturn($response);

        $instagramRawResponse = $this->instagramClient->send('http://test.com', 'GET', null);

        $this->assertInstanceOf(InstagramRawResponse::class, $instagramRawResponse);
        $this->assertEquals($this->fakeRawBody, $instagramRawResponse->getBody());
        $this->assertEquals($this->fakeRawHeader, $instagramRawResponse->getHeaders());
        $this->assertEquals(200, $instagramRawResponse->getStatusCode());
    }

    /**
     * @expectedException \Munouni\Instagram\Exception\InstagramAPIException
     */
    public function testThrowClientException()
    {
        $request = new Request('GET', 'http://test.com');
        $this->clientMock
            ->shouldReceive('send')
            ->once()
            ->andThrow(new ClientException('kku...', $request));

        $this->instagramClient->send('http://test.com', 'GET', null);
    }

    /**
     * @expectedException \Munouni\Instagram\Exception\InstagramAPIException
     */
    public function testThrowRequestException()
    {
        $request = new Request('GET', 'http://test.com');
        $this->clientMock
            ->shouldReceive('send')
            ->once()
            ->andThrow(new RequestException('kku...', $request));

        $this->instagramClient->send('http://test.com', 'GET', null);
    }

    public function testGetHeadersAsString()
    {
        $response = new Response(200, $this->fakeHeadersAsArray);
        $headers = $this->instagramClient->getHeadersAsString($response);
        $this->assertEquals($this->fakeRawHeader, $headers);
    }
}

<?php

namespace Munouni\Instagram\Tests\HttpClients;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Mockery as m;
use Munouni\Instagram\Http\InstagramRawResponse;
use Munouni\Instagram\HttpClients\InstagramGuzzeleHttpClient;

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

    public function testNormalGETRequest()
    {
        $response = new Response(200, $this->fakeHeadersAsArray, $this->fakeRawBody);
        $this->clientMock
            ->shouldReceive('send')
            ->once()
            ->andReturn($response);

        $instagramRawResponse = $this->instagramClient->send('http://test.com', 'GET', null);

        $this->assertInstanceOf(InstagramRawResponse::class, $instagramRawResponse);
        $this->assertEquals($this->fakeRawBody, $instagramRawResponse->getBody());
        $this->assertEquals($this->fakeHeadersAsArray, $instagramRawResponse->getHeaders());
        $this->assertEquals(200, $instagramRawResponse->getStatusCode());
    }

    public function testNormalPOSTRequest()
    {
        $response = new Response(200, $this->fakeHeadersAsArray, $this->fakeRawBody);
        $this->clientMock
            ->shouldReceive('send')
            ->once()
            ->andReturn($response);

        $instagramRawResponse = $this->instagramClient->send('http://test.com', 'POST', null);

        $this->assertInstanceOf(InstagramRawResponse::class, $instagramRawResponse);
        $this->assertEquals($this->fakeRawBody, $instagramRawResponse->getBody());
        $this->assertEquals($this->fakeHeadersAsArray, $instagramRawResponse->getHeaders());
        $this->assertEquals(200, $instagramRawResponse->getStatusCode());
    }

    public function testNormalDELETERequest()
    {
        $response = new Response(200, $this->fakeHeadersAsArray, $this->fakeRawBody);
        $this->clientMock
            ->shouldReceive('send')
            ->once()
            ->andReturn($response);

        $instagramRawResponse = $this->instagramClient->send('http://test.com', 'DELETE', null);

        $this->assertInstanceOf(InstagramRawResponse::class, $instagramRawResponse);
        $this->assertEquals($this->fakeRawBody, $instagramRawResponse->getBody());
        $this->assertEquals($this->fakeHeadersAsArray, $instagramRawResponse->getHeaders());
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
}

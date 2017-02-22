<?php

namespace Munouni\Instagram\Tests\Http;

use Munouni\Instagram\Http\InstagramRawResponse;

class InstagramRawResponseTest extends \PHPUnit_Framework_TestCase
{
    public function testInstagramRawResponse()
    {
        $instagramRawResponse = new InstagramRawResponse(['chihaya' => 'kisaragi'], 'asami', 200);
        $this->assertEquals(['chihaya' => 'kisaragi'], $instagramRawResponse->getHeaders());
        $this->assertEquals('asami', $instagramRawResponse->getBody());
        $this->assertEquals(200, $instagramRawResponse->getStatusCode());
    }
}

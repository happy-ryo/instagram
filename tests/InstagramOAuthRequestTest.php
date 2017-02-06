<?php

namespace Munouni\Instagram\Tests;

use Munouni\Instagram\HttpRequests\InstagramOAuthRequest;

class InstagramOAuthRequestTest extends \PHPUnit_Framework_TestCase
{
    public function testInstagramOAuthRequest()
    {
        $instagramOAuthRequest = new InstagramOAuthRequest('chihaya', 'kisaragi', 'asami', 'http://kisaragichihaya.jp');
        $this->assertEquals('oauth/access_token', $instagramOAuthRequest->getEndPoint());
        $this->assertEquals('POST', $instagramOAuthRequest->getMethod());

        $params = $instagramOAuthRequest->getParams();

        $this->assertEquals('chihaya', $params['client_id']);
        $this->assertEquals('kisaragi', $params['client_secret']);
        $this->assertEquals('asami', $params['code']);
        $this->assertEquals('http://kisaragichihaya.jp', $params['redirect_uri']);
        $this->assertEquals('authorization_code', $params['grant_type']);
    }
}

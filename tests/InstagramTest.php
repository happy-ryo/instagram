<?php
use Munouni\Instagram\Instagram;
use Munouni\Instagram\InstagramClient;

class InstagramTest extends PHPUnit_Framework_TestCase
{
    public function testGetPhpUnitAccessToken()
    {
        $this->assertNotEmpty(PHPUNIT_ACCESS_TOKEN);
    }

    public function testSetAccessToken()
    {
        $instagram = new Instagram();
        $instagram->setAccessToken('chihaya');
        $this->assertEquals('chihaya', $instagram->getAccessToken());
    }

    public function testInitializeAccessToken()
    {
        $instagram = new Instagram(['access_token' => 'chihaya']);
        $this->assertEquals('chihaya', $instagram->getAccessToken());
    }

    public function testEnvAccessToken()
    {
        if (!putenv(Instagram::ACCESS_TOKEN . '=chihaya')) {
            $this->fail('putenv fail.');
        }

        $instagram = new Instagram();
        $this->assertEquals('chihaya', $instagram->getAccessToken());

        if (!putenv(Instagram::ACCESS_TOKEN)) {
            $this->fail('remove env fail.');
        }
    }

    public function testOverrideEnvAccessToken()
    {
        if (!putenv(Instagram::ACCESS_TOKEN . '=chihaya')) {
            $this->fail('putenv fail.');
        }

        $instagramOverride = new Instagram(['access_token' => 'mingosu']);
        $this->assertEquals('mingosu', $instagramOverride->getAccessToken());

        $instagram = new Instagram();
        $this->assertEquals('chihaya', $instagram->getAccessToken());

        if (!putenv(Instagram::ACCESS_TOKEN)) {
            $this->fail('remove env fail.');
        }
    }

    public function testOverrideAPIVersion()
    {
        $instagram = new Instagram(['api_version' => '72']);
        $this->assertEquals('72', $instagram->getApiVersion());
    }

    /**
     * @expectedException Munouni\Instagram\Exception\InstagramAPIException
     */
    public function testThrowExceptionEmptyAccessToken()
    {
        $instagram = new Instagram();
        $instagram->getAccessToken();
    }

    public function testSettingClient()
    {
        $instagram = new Instagram();
        $this->assertInstanceOf(InstagramClient::class, $instagram->getClient());
    }

    public function testCreatingANewRequest()
    {
        $instagram = new Instagram(['access_token' => 'chihaya']);
        $request = $instagram->createRequest('GET', '/test');
        $this->assertEquals('chihaya', $request->getAccessToken());
        $this->assertEquals('/test', $request->getEndPoint());
        $this->assertEquals('https://api.instagram.com/', $instagram->getClient()->getBaseUrl());
    }

    public function testSendRequest()
    {
        $instagram = new Instagram(['access_token' => 'chihaya']);
        $instagram->setClient(new InstagramClient(new Munouni\Instagram\Tests\HttpClients\InstagramTestHttpClients()));
        $instagramResponse = $instagram->sendRequest('GET', '/chihaya');
        $this->assertEquals($instagramResponse, $instagram->getLastResponse());
    }

    public function testGetOAuthUrl()
    {
        $instagram = new Instagram([
            'client_id'     => 'chihaya',
            'client_secret' => 'kisaragi',
            'redirect_uri'  => 'http://kisaragichihaya.jp'
        ]);
        $this->assertEquals(
            'https://api.instagram.com/oauth/authorize?response_type=code&client_id=chihaya&redirect_uri=http://kisaragichihaya.jp&scope=basic',
            $instagram->getOAuthUrl());
    }

    public function testGetOAuthUrlChangeScope()
    {
        $instagram = new Instagram([
            'client_id'     => 'chihaya',
            'client_secret' => 'kisaragi',
            'redirect_uri'  => 'http://kisaragichihaya.jp'
        ]);
        $this->assertEquals(
            'https://api.instagram.com/oauth/authorize?response_type=code&client_id=chihaya&redirect_uri=http://kisaragichihaya.jp&scope=comments+likes',
            $instagram->getOAuthUrl(['comments', 'likes']));
    }

    /**
     * @expectedException \Munouni\Instagram\Exception\InstagramAPIException
     */
    public function testGetOAuthUrlChangeInvalidScope()
    {
        $instagram = new Instagram([
            'client_id'     => 'chihaya',
            'client_secret' => 'kisaragi',
            'redirect_uri'  => 'http://kisaragichihaya.jp'
        ]);
        $instagram->getOAuthUrl(['likes', 'mingosu']);
    }

    /**
     * @expectedException \Munouni\Instagram\Exception\InstagramAPIException
     */
    public function testGetOAuthUrlChangeInvalidApp()
    {
        $instagram = new Instagram([
            'client_secret' => 'kisaragi',
            'redirect_uri'  => 'http://kisaragichihaya.jp'
        ]);
        $instagram->getOAuthUrl();
    }

    public function testCreateOAuthRequest()
    {
        $instagram = new Instagram([
            'client_id'     => 'chihaya',
            'client_secret' => 'kisaragi',
            'redirect_uri'  => 'http://kisaragichihaya.jp'
        ]);
        $this->assertInstanceOf(
            Munouni\Instagram\HttpRequests\InstagramOAuthRequest::class,
            $instagram->createOAuthRequest('chihaya'));
    }

    public function testSendOAuthTokenRequest()
    {
        $instagram = new Instagram(['access_token' => 'chihaya']);
        $instagram->setClient(new InstagramClient(new Munouni\Instagram\Tests\HttpClients\InstagramOAuthTestHttpClients()));
        $this->assertEquals('fb2e77d.47a0479900504cb3ab4a1f626d174d2d', $instagram->getOAuthToken('chihaya'));
    }

    public function testSendOAuthTokenRequestOriginalMode()
    {
        $instagram = new Instagram(['access_token' => 'chihaya']);
        $instagram->setClient(new InstagramClient(new Munouni\Instagram\Tests\HttpClients\InstagramOAuthTestHttpClients()));
        $this->assertEquals('fb2e77d.47a0479900504cb3ab4a1f626d174d2d', $instagram->getOAuthToken('chihaya', true)['access_token']);
    }
}

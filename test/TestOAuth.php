<?php

require 'bootstrap.php';

use PHPUnit\Framework\TestCase;
use Tenko\OceanEngine\App;

class TestOAuth extends TestCase
{
    public function testAuthUrl()
    {
        $redirectUrl = env('redirect_url', 'https://example.com/callback');
        $appId = env('app_id', 'test');

        $app = new App([
            'app_id' => $appId
        ]);

        $uRedirectUrl = urlencode($redirectUrl);
        $uAppId = urlencode($appId);

        $oauth = $app->OAuth;

        $url = $oauth->getAuthUrl($redirectUrl);
        $expected = "https://ad.oceanengine.com/openapi/audit/oauth.html?app_id=$uAppId&redirect_uri=$uRedirectUrl";
        $this->assertEquals($expected, $url);

        $url = $oauth->getAuthUrl($redirectUrl, 'test_state');
        $expected = "https://ad.oceanengine.com/openapi/audit/oauth.html?app_id=$uAppId&redirect_uri=$uRedirectUrl&state=test_state";
        $this->assertEquals($expected, $url);

        $url = $oauth->getAuthUrl($redirectUrl, 'test_state', [1,2,3,41,]);
        $expected = "https://ad.oceanengine.com/openapi/audit/oauth.html?app_id=$uAppId&redirect_uri=$uRedirectUrl&state=test_state&scope=%5B1%2C2%2C3%2C41%5D";
        $this->assertEquals($expected, $url);
    }
}

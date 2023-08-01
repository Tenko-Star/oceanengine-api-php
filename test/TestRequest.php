<?php

require 'bootstrap.php';

use PHPUnit\Framework\TestCase;
use Tenko\OceanEngine\App;
use WpOrg\Requests\Requests;

class TestRequest extends TestCase
{
    public function testRequest()
    {
        $response = Requests::get('https://api.wrdan.com/hitokoto');

        $body = $response->body;

        $json = json_decode($body, true);

        $this->assertIsArray($json);
    }

    public function testGet()
    {
        $token = env('access_token');
        $app = new App([]);

        $response = $app->Request->setToken($token)->get('/2/user/info/');

        $data = $response->getData();

        $this->assertIsArray($data);
    }
}

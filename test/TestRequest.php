<?php

require 'bootstrap.php';

use PHPUnit\Framework\TestCase;
use WpOrg\Requests\Requests;

class TestRequest extends TestCase
{
    public function testRequest() {
        $response = Requests::get('https://api.wrdan.com/hitokoto');

        $body = $response->body;

        $json = json_decode($body, true);

        $this->assertIsArray($json);
    }
}

<?php

namespace Tenko\OceanEngine\Client;

use Tenko\OceanEngine\Object\Token;
use WpOrg\Requests\Requests;

class OAuth extends BaseClient
{
    private array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @param string $authCode
     * @return Token
     * @throws \Exception
     */
    public function getAccessToken(string $authCode): Token
    {
        $api = 'https://ad.oceanengine.com/open_api/oauth2/access_token/';
        $appId = $this->config['app_id'] ?? '';
        $secret = $this->config['secret'] ?? '';

        $data = [
            'app_id' => $appId,
            'secret' => $secret,
            'grant_type' => 'auth_code',
            'auth_code' => $authCode
        ];

        $response = Requests::post($api, ['Content-Type' => 'application/json'], $data);

        if (!$response->success) {
            throw new \Exception('Error: request fail');
        }

        $body = $response->body;

        $data = $this->checkError($body);

        return new Token($data['data']);
    }

    /**
     * @param string $refreshToken
     * @return Token
     * @throws \Exception
     */
    public function refreshToken(string $refreshToken): Token
    {
        $api = 'https://ad.oceanengine.com/open_api/oauth2/refresh_token/';
        $appId = $this->config['app_id'] ?? '';
        $secret = $this->config['secret'] ?? '';

        $data = [
            'app_id' => $appId,
            'secret' => $secret,
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken
        ];

        $response = Requests::post($api, ['Content-Type' => 'application/json'], $data);

        if (!$response->success) {
            throw new \Exception('Error: request fail');
        }

        $body = $response->body;

        $data = $this->checkError($body);

        return new Token($data['data']);
    }

    public function getAuthUrl(string $redirectUrl, string $state = null, array $scope = null): string
    {
        $api = 'https://ad.oceanengine.com/openapi/audit/oauth.html';
        $appId = $this->config['app_id'] ?? '';

        $data = [
            'app_id' => $appId,
            'redirect_uri' => $redirectUrl
        ];

        if ($state !== null) {
            $data['state'] = $state;
        }

        if ($scope !== null) {
            $data['scope'] = '[' . implode(',', $scope) . ']';
        }

        return $this->parseUrl($api, $data);
    }

    public function callback(callable $handler): void
    {
        $authCode = $_GET['auth_code'] ?? '';
        $state = $_GET['state'] ?? '';

        $handler($authCode, $state);
    }
}
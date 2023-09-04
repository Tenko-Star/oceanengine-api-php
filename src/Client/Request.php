<?php

namespace Tenko\OceanEngine\Client;

use Tenko\OceanEngine\Exception\ResponseException;
use Tenko\OceanEngine\Library\Response;
use WpOrg\Requests\Requests;

class Request
{
    private const BASE_URL = 'https://ad.oceanengine.com/open_api/';

    private string $token = '';

    public function setToken(string $token): Request
    {
        $this->token = $token;

        return $this;
    }

    public function get(string $api, array $params = null, array $body = null, bool $json = true): Response
    {
        return $this->request($api, $params, $body, $json);
    }

    public function post(string $api, array $params = null, array $body = null, bool $json = true): Response
    {
        return $this->request($api, $params, $body, $json, Requests::POST);
    }

    public function request(string $api, array $params = null, array $body = null, bool $json = true, string $type = Requests::GET, array $options = []): Response
    {
        $query = '';
        $bodyData = '';
        $header = [
            'Access-Token' => $this->token
        ];

        if ($params !== null) {
            $query = http_build_query($params);
        }

        if ($body !== null) {
            $bodyData = $json ? json_encode($body) : http_build_query($body);
        }

        if (!empty($query)) {
            $api = rtrim($api, '?') . '?' . $query;
        }

        if ($json) {
            $header['Content-Type'] = 'application/json;charset=UTF-8';
        }

        $api = self::BASE_URL . ltrim($api, '/');
        $response = Requests::request($api, $header, $bodyData, $type, $options);

        if (!$response->success) {
            throw new ResponseException(sprintf("request error: \nrequest url: %s\nbody: %s", $api, $response->body));
        }

        $responseBody = json_decode($response->body, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new ResponseException('incorrect response body: ' . json_last_error_msg());
        }

        $this->checkResponse($responseBody);

        return new Response($responseBody['code'], $responseBody['message'], $responseBody['data'], $responseBody['request_id']);
    }

    protected function checkResponse(array &$json): void
    {
        if (
            !isset($json['code']) ||
            !isset($json['message']) ||
            !isset($json['request_id'])
        ) {
            throw new ResponseException(sprintf("incorrect response body: \n%s", json_encode($json)));
        }

        if (
            !is_int($json['code']) ||
            !is_string($json['message']) ||
            !is_string($json['request_id'])
        ) {
            throw new ResponseException(sprintf("incorrect response body: \n%s", json_encode($json)));
        }

        if (!isset($json['data'])) {
            $json['data'] = [];
        }
    }
}
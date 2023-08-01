<?php

namespace Tenko\OceanEngine\Client;

abstract class BaseClient
{
    protected function checkError(string $body): array
    {
        $json = json_decode($body, true);

        if (json_last_error() !== JSON_ERROR_NONE || !isset($json['code'])) {
            throw new \Exception('Error: body error');
        }

        if ($json['code'] > 0) {
            throw new \Exception('Error: ' . ($json['message'] ?? 'unknown error'));
        }

        return $json;
    }

    protected function parseUrl(string $baseUrl, array $params = []): string
    {
        $np = [];
        foreach ($params as $k => $v) {
            $np[] = $k . '=' . urlencode($v);
        }

        $rp = implode('&', $np);

        return rtrim($baseUrl, '?') . '?' . $rp;
    }
}
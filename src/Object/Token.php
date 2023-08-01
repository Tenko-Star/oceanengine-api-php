<?php

namespace Tenko\OceanEngine\Object;

class Token
{
    private string $accessToken;

    private int $expiresIn;

    private string $refreshToken;

    private int $refreshTokenExpiresIn;

    private bool $empty;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->accessToken = $data['access_token'] ?? '';
        $this->expiresIn = $data['expires_in'] ?? 0;
        $this->refreshToken = $data['refresh_token'] ?? '';
        $this->refreshTokenExpiresIn = $data['refresh_token_expires_in'] ?? 0;

        $this->empty = (
            empty($this->accessToken) ||
            empty($this->expiresIn) ||
            empty($this->refreshToken) ||
            empty($this->refreshTokenExpiresIn)
        );
    }

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * @return int
     */
    public function getExpiresIn(): int
    {
        return $this->expiresIn;
    }

    /**
     * @return string
     */
    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }

    /**
     * @return int
     */
    public function getRefreshTokenExpiresIn(): int
    {
        return $this->refreshTokenExpiresIn;
    }

    public function isEmpty(): bool {
        return $this->empty;
    }

}
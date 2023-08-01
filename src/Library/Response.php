<?php

namespace Tenko\OceanEngine\Library;

use Tenko\OceanEngine\Exception\ResponseException;

class Response
{
    private int $code;

    private string $message;

    private array $data;

    private string $requestId;

    /**
     * @param int $code
     * @param string $message
     * @param array $data
     * @param string $requestId
     */
    public function __construct(int $code, string $message, array $data, string $requestId)
    {
        $this->code = $code;
        $this->message = $message;
        $this->data = $data;
        $this->requestId = $requestId;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function getRequestId(): string
    {
        return $this->requestId;
    }

    /**
     * @return void
     * @throws ResponseException
     */
    public function checkResult(): void
    {
        if ($this->code !== 0) {
            $msg = "Request error: {$this->message} [{$this->code}]. Please check https://open.oceanengine.com/labels/7/docs/1696710760866831 to get help.";
            throw new ResponseException($msg, $this->code);
        }
    }
}
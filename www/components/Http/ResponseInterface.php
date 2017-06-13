<?php

namespace Components\Http;

interface ResponseInterface
{
    /**
     * Send HTTP response
     * @return void
     */
    public function send();

    /**
     * @param string $header
     * @param bool $replace
     * @param int $http_response_code
     * @return ResponseInterface
     */
    public function setHeader(string $header, bool $replace = true, int $http_response_code): ResponseInterface;

    /**
     * @param string $body
     * @return ResponseInterface
     */
    public function setBody(string $body): ResponseInterface;


}

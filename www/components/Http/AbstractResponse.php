<?php

namespace Components\Http;

abstract class AbstractResponse implements ResponseInterface
{
    /** @var string $body */
    private $body = '';

    /**
     * @var array
     */
    private $headers = [];

    /**
     * Send response back to the client
     * @return void
     */
    public function send()
    {
        $this->sendHeaders()
            ->sendBody();
    }

    /**
     * @param string $header
     * @param bool $replace
     * @param int $http_response_code
     * @return ResponseInterface
     */
    public function setHeader(string $header, bool $replace = true, int $http_response_code = null): ResponseInterface
    {
        $this->headers[] = [
            'header' => $header,
            'replace' => $replace,
            'code' => $http_response_code
        ];
        return $this;
    }

    /**
     * @param string $body
     * @return ResponseInterface
     */
    public function setBody(string $body): ResponseInterface
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @return AbstractResponse
     */
    private function sendHeaders(): AbstractResponse
    {
        foreach ($this->headers as $header) {
             if (isset($http_response_code) && !empty($http_response_code)) {
                header($header['header'], $header['replace'], $header['code']);
             } else {
                 header($header['header'], $header['replace']);
             }
        }
        return $this;
    }

    /**
     * @return AbstractResponse
     */
    private function sendBody(): AbstractResponse
    {
        echo $this->body;
        return $this;
    }
}

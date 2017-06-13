<?php

namespace Components\Http;

class JsonResponse extends AbstractResponse
{
    /**
     * Send response back to the client
     * @return void
     */
    public function send()
    {
        $this->setHeader('Content-Type: application/json');
        parent::send();
    }

    /**
     * @param array $data
     * @return ResponseInterface
     */
    public function setJson(array $data): ResponseInterface
    {
        $body = json_encode($data);
        return parent::setBody($body);
    }
}
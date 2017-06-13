<?php

namespace Components\Http;

class HtmlResponse extends AbstractResponse
{
    /**
     * Send response back to the client
     * @return void
     */
    public function send()
    {
        $this->setHeader('Content-Type: text/html');
        parent::send();
    }

    public function setBody(string $body): ResponseInterface
    {
        return parent::setBody($body);
    }
}

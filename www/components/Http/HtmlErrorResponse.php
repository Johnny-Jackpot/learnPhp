<?php

namespace Components\Http;

class HtmlErrorResponse extends HtmlResponse
{
    const ERROR_TEMPLATE = ROOT . '/templates/t_main.php';
    const ERROR_LAYOUT = ROOT . '/views/500.php';
    const ERROR_HEADER = 'HTTP/1.1 500 Internal Server Error';
    const ERROR_REPLACE = false;
    const ERROR_CODE = 500;

    /**
     * HtmlErrorResponse constructor.
     * @param string $header
     * @param bool $replace
     * @param int $code
     */
    public function __construct(
        $header = self::ERROR_HEADER,
        $replace = self::ERROR_REPLACE,
        $code = self::ERROR_CODE)
    {
        $this->setHeader($header, $replace, $code);
    }
}
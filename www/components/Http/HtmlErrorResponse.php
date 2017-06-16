<?php

namespace Components\Http;

class HtmlErrorResponse extends HtmlResponse
{
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
<?php

namespace Controllers;

use \Components\Http\ResponseInterface;

interface ControllerInterface
{
    /**
     * Make a response
     * @return ResponseInterface
     */
    public function execute(): ResponseInterface;
}

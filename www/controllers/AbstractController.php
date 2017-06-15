<?php

namespace Controllers;

use Components\Http\ResponseInterface;
use Components\Http\HtmlErrorResponse;
use \Models\Db;
use \Components\View;


abstract class AbstractController implements ControllerInterface
{
    /**
     * store \models\Db instance
     * @var Db
     */
    protected $db;

    public function __construct()
    {
        $this->db = new Db();
    }

    /**
     *
     * @return bool
     */
    protected function isXHR(): bool
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    protected function response501notImplemented(): ResponseInterface
    {
        $view = new View(ROOT . '/templates/t_main.php', ROOT . '/views/v_501_not_implemented.php');
        $response = new HtmlErrorResponse('HTTP/1.1 501 Internal Not Implemented', true, 501);

        return $response->setBody($view->render());

    }
}

<?php

namespace Controllers;

use Components\Http\HtmlResponse;
use Components\Http\ResponseInterface;
use Components\View;

class NonNameSakesController extends AbstractController
{
    public function execute(): ResponseInterface
    {
        $nonNameSakeActors = $this->db->getNonNameSakeActors();
        $data = ['nonNameSakeActors' => $nonNameSakeActors];
        $view = new View(ROOT . '/templates/t_main.php', ROOT . '/views/v_non_name_sake_actors.php');
        $response = new HtmlResponse();

        return $response->setBody($view->render($data));
    }
}
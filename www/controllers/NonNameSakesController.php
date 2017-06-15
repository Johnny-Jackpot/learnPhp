<?php

namespace Controllers;

use Components\Http\HtmlResponse;
use Components\Http\ResponseInterface;
use Components\View;

class NonNameSakesController extends AbstructController
{
    public function execute(): ResponseInterface
    {
        $nonNameSakeActors = $this->db->getNonNameSakeActors();
        $data = ['nonNameSakeActors' => $nonNameSakeActors];
        $template = $this->preparePathToFile(ROOT . '/templates/t_main.php');
        $view = $this->preparePathToFile(ROOT . '/views/v_non_name_sake_actors.php');
        $view = new View($template, $view);
        $response = new HtmlResponse();

        return $response->setBody($view->render($data));
    }
}
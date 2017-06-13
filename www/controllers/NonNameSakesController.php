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
        $template = $this->preparePathToFile(ROOT . '/views/main/nonNameSakeActors.php');
        $view = new View($template);
        $response = new HtmlResponse();

        return $response->setBody($view->render($data));
    }
}
<?php

namespace Controllers;

use Components\Http\HtmlResponse;
use Components\Http\JsonResponse;
use Components\Http\ResponseInterface;
use Components\View;

class ActorsOnStudiosController extends AbstructController
{
    /**
     * Handle request for rendering data from 2-d sql query
     * where form is needed
     * @return ResponseInterface
     */
    public function execute(): ResponseInterface
    {
        //TODO send base html with JS for AJAX

        $template = $this->preparePathToFile(ROOT . '/views/actorsOnStudios.php');
        $view = new View($template);
        $response = new HtmlResponse();
        $data = [
            'studiosList' => [],
            'actorsOnStudiosInfo' => [],
            'activeStudio' => null
        ];

        $studiosList = $this->db->getStudiosList();

        if (!count($studiosList)) {
            return $response->setBody($view->render($data));
        }

        $data = $this->prepareActorsOnStudiosData($data, $studiosList);

        return $response->setBody($view->render($data));
    }

}

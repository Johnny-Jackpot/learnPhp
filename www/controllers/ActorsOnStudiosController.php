<?php

namespace Controllers;

use Components\Http\HtmlResponse;
use Components\Http\JsonResponse;
use Components\Http\ResponseInterface;
use Components\View;

class ActorsOnStudiosController extends AbstractController
{
    /**
     * Handle request for rendering data from 2-d sql query
     * where form is needed
     *
     * Route: /actors_on_studios
     *
     * @return ResponseInterface
     */
    public function execute(): ResponseInterface
    {
        $view = new View(
            ROOT . '/templates/t_actors_on_studios.php',
            ROOT . '/views/v_actors_on_studios.php'
        );
        $response = new HtmlResponse();
        $data = ['studiosList' => []];

        $studiosList = $this->db->getStudiosList();

        if (!count($studiosList)) {
            return $response->setBody($view->render($data));
        }

        $data = ['studiosList' => $studiosList];

        return $response->setBody($view->render($data));
    }

}

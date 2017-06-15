<?php

namespace Controllers;

use Components\Http\HtmlResponse;
use Components\Http\ResponseInterface;
use Components\View;

class MainController extends AbstractController
{
    /**
     * Handle request for rendering data from 1,3,4-th queries
     * @return ResponseInterface
     */
    public function execute(): ResponseInterface
    {
        $view = new View(ROOT . '/templates/t_main.php', ROOT . '/views/v_main.php');
        $response = new HtmlResponse();

        $pathname = '/actors_on_studios';
        $studios = $this->db->getStudiosList();
        $linksToStudios = $this->db->generateLinksForActorsOnStudio($studios, $pathname);

        $data = [
            'studios' => $studios,
            'links_to_studios' => $linksToStudios
        ];

        return $response->setBody($view->render($data));

    }

}

<?php

namespace Controllers;

use Components\Http\JsonResponse;
use Components\Http\ResponseInterface;
use Components\Http\HtmlResponse;
use Components\View;

class ActorsOnStudiosAjaxController extends AbstructController
{
    /**
     * Handle request for rendering data from 2-d sql query
     * where form is needed
     * @return ResponseInterface
     */
    public function execute(): ResponseInterface
    {
        if (!$this->isXHR()) {
            $template = $this->preparePathToFile(ROOT . '/templates/main.php');
            $view = $this->preparePathToFile(ROOT . '/views/v_501_not_implemented.php');
            $view = new View($template, $view);
            $response = new HtmlResponse();

            return $response->setHeader('HTTP/1.1 501 Not Implemented', true, 403)
                            ->setBody($view->render());
        }

        $data = $this->getStatistics();
        $response = new JsonResponse();

        return $response->setJson($data);
    }


    /**
     * Prepare data for AJAX
     * @return array Modified $data array
     */
    protected function getStatistics(): array
    {
        if (!isset($_GET['studio_name']) || empty($_GET['studio_name'])) {
            return [];
        }

        $studioName = filter_var($_GET['studio_name'], FILTER_SANITIZE_STRING);
        $data = [];
        $data['actorsOnStudiosInfo'] = $this->db->actorsOnStudiosInfo($studioName);

        return $data;
    }

}

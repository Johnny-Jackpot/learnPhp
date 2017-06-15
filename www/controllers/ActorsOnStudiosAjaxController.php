<?php

namespace Controllers;

use Components\Http\JsonResponse;
use Components\Http\ResponseInterface;

class ActorsOnStudiosAjaxController extends AbstractController
{
    /**
     * Handle request for rendering data from 2-d sql query
     * where form is needed
     * @return ResponseInterface
     */
    public function execute(): ResponseInterface
    {
        if (!$this->isXHR()) {
            return $this->response501notImplemented();
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

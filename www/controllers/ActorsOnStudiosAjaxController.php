<?php

namespace Controllers;

use Components\Http\JsonResponse;
use Components\Http\ResponseInterface;

class ActorsOnStudiosAjaxController extends AbstructController
{
    /**
     * Handle request for rendering data from 2-d sql query
     * where form is needed
     * @return ResponseInterface
     */
    public function execute(): ResponseInterface
    {
        $response = new JsonResponse();

        $data = [
            'studiosList' => [],
            'actorsOnStudiosInfo' => [],
            'activeStudio' => null
        ];

        $studiosList = $this->db->getStudiosList();

        if (!count($studiosList)) {
            return $response->setJson($data);
        }

        $data = $this->prepareActorsOnStudiosData($data, $studiosList);


        return $response->setJson($data);
    }

    /**
     * Prepare appropriate data for submitted from or
     * loading page first time
     *
     * @param array $data
     * @param array $studiosList
     * @return array Modified $data array
     */
    protected function prepareActorsOnStudiosData(array $data, array $studiosList): array
    {
        $data['studiosList'] = $studiosList;

        return isset($_GET['studio_name']) ?
            $this->processActorsOnStudiosForm($data) :
            $this->setDefaultActorsOnStudiosData($data, $studiosList);
    }

    /**
     * Prepare data for selected studio in form
     *
     * @param array $data
     * @return array Modified $data array
     */
    protected function processActorsOnStudiosForm(array $data): array
    {
        $studioName = filter_var($_GET['studio_name'], FILTER_SANITIZE_STRING);
        $data['actorsOnStudiosInfo'] = $this->db->actorsOnStudiosInfo($studioName);
        $data['activeStudio'] = $studioName;

        return $data;
    }

    /**
     * Prepare data for first studio in "select" list
     * if form wasn't submitted yet
     *
     * @param array $data
     * @param $studiosList array
     * @return array Modified $data array
     */
    protected function setDefaultActorsOnStudiosData(array $data, array $studiosList): array
    {
        $data['actorsOnStudiosInfo'] = $this->db->actorsOnStudiosInfo($studiosList[0]['name']);
        $data['activeStudio'] = $studiosList[0]['name'];

        return $data;
    }

}

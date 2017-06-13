<?php

namespace Controllers;

use Components\Http\HtmlResponse;
use Components\Http\ResponseInterface;
use Components\View;

class MainController extends AbstructController
{
    /**
     * Handle request for rendering data from 1,3,4-th queries
     * @return ResponseInterface
     */
    public function execute(): ResponseInterface
    {
        $actorsYearsFrom = 40;
        $actorsYearsTo = 60;
        $actorsFees = $this->db->getActorsFees($actorsYearsFrom, $actorsYearsTo);

        $nonNameSakeActors = $this->db->getNonNameSakeActors();

        $years = 10;
        $studiosStatistics = $this->db->getStudiosStatistics($years);

        $view = $this->preparePathToFile(ROOT . '/views/main.php');
        $data = [
            'actorsYearsFrom' => $actorsYearsFrom,
            'actorsYearsTo' => $actorsYearsTo,
            'actorsFees' => $actorsFees,
            'nonNameSakeActors' => $nonNameSakeActors,
            'studiosStatistics' => $studiosStatistics
        ];

        $view = new View($view);
        $response = new HtmlResponse();

        return $response->setBody($view->render($data));

    }

}

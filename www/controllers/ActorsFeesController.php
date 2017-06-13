<?php

namespace Controllers;

use Components\Http\HtmlResponse;
use Components\Http\ResponseInterface;
use Components\View;

class ActorsFeesController extends AbstructController
{
    /**
     * @return ResponseInterface
     */
    public function execute(): ResponseInterface
    {
        $actorsYearsFrom = 40;
        $actorsYearsTo = 60;
        $actorsFees = $this->db->getActorsFees($actorsYearsFrom, $actorsYearsTo);
        $data = [
            'actorsYearsFrom' => $actorsYearsFrom,
            'actorsYearsTo' => $actorsYearsTo,
            'actorsFees' => $actorsFees
        ];

        $template = $this->preparePathToFile(ROOT . '/views/main/actorsFees.php');
        $view = new View($template);
        $response = new HtmlResponse();

        return $response->setBody($view->render($data));
    }
}
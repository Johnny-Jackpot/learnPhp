<?php

namespace Controllers;

use Components\Http\HtmlResponse;
use Components\Http\ResponseInterface;
use Components\View;

class ActorsFeesController extends AbstractController
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

        $template = $this->preparePathToFile(ROOT . '/templates/t_main.php');
        $view = $this->preparePathToFile(ROOT . '/views/v_actors_fees.php');
        $view = new View($template, $view);
        $response = new HtmlResponse();

        return $response->setBody($view->render($data));
    }
}
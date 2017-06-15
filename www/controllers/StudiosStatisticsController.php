<?php

namespace Controllers;

use Components\Http\HtmlResponse;
use Components\Http\ResponseInterface;
use Components\View;

class StudiosStatisticsController extends AbstractController
{
    public function execute(): ResponseInterface
    {
        $years = 10;
        $studiosStatistics = $this->db->getStudiosStatistics($years);
        $data = ['studiosStatistics' => $studiosStatistics];
        $view = new View(ROOT . '/templates/t_main.php', ROOT . '/views/v_studios_statistics.php');
        $response = new HtmlResponse();

        return $response->setBody($view->render($data));
    }
}
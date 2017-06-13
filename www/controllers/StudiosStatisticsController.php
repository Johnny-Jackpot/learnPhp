<?php

namespace Controllers;

use Components\Http\HtmlResponse;
use Components\Http\ResponseInterface;
use Components\View;

class StudiosStatisticsController extends AbstructController
{
    public function execute(): ResponseInterface
    {
        $years = 10;
        $studiosStatistics = $this->db->getStudiosStatistics($years);
        $data = ['studiosStatistics' => $studiosStatistics];
        $template = $this->preparePathToFile(ROOT . '/views/main/studiosStatistics.php');
        $view = new View($template);
        $response = new HtmlResponse();

        return $response->setBody($view->render($data));
    }
}
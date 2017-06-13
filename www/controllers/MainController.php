<?php

namespace Controllers;

use Components\View;
use \Models\Db;

class MainController
{
    /**
     * store \models\Db instance
     * @var Db
     */
    protected $db;

    public function __construct()
    {
        $this->db = new Db();
    }

    /**
     * Replace '/' with DIRECTORY_SEPARATOR
     * @param string $path  Path to file
     * @return string
     */
    protected function preparePathToFile(string $path): string
    {
        return str_replace('/', DIRECTORY_SEPARATOR, $path);
    }

    /**
     * Handle request for rendering data from 1,3,4-th queries
     * @return bool
     */
    public function actionIndex(): bool
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

        $view = new \Components\View($view);
        echo $view->render($data);

        return true;
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

        return isset($_POST['studioName']) ?
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
        $studioName = filter_var($_POST['studioName'], FILTER_SANITIZE_STRING);
        $data['actorsOnStudiosInfo'] = $this->db->actorsOnStudiosInfo($studioName);
        $data['activeStudio'] = $_POST['studioName'];

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

    /**
     * Handle request for rendering data from 2-d sql query
     * where form is needed
     * @return bool
     */
    public function actionActorsOnStudios(): bool
    {
        $template = $this->preparePathToFile(ROOT . '/views/actorsOnStudios.php');
        $view = new View($template);
        $data = [
            'studiosList' => [],
            'actorsOnStudiosInfo' => [],
            'activeStudio' => null
        ];

        $studiosList = $this->db->getStudiosList();
        if (!count($studiosList)) {
            //render page with apologize
            echo $view->render($data);
            return true;
        }

        $data = $this->prepareActorsOnStudiosData($data, $studiosList);

        echo $view->render($data);

        return true;
    }
}

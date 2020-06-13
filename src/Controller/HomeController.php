<?php

namespace App\Controller;

use App\Service\DbManager;
use App\Service\Pager;

/**
 * Class HomeController
 *
 * Handles query for homepage
 *
 * @package App\Controller
 */
class HomeController
{
    /**
     * Main action of the controller
     *
     * Serves data of the homepage
     *
     * @param int $page The page queried. If not specified, first page provided
     * @param string $sort Sorting order. If not provided the tasks are sorted by Id
     * @param string $direction Sorting direction. Default value is ASCENDING
     * @return array Array, able to be processed by rendering mechanism
     * @throws \Exception
     */
    public function index($page = 1, $sort = 'id', $direction = 'asc')
    {
        $dbManager = new DbManager();
        $tasksTotal = $dbManager->getAllTasksCount();
        $data = $dbManager->getTasksByPage($page, $sort, $direction);

        if (empty($data)) {
            $content = [
                'status' => 'fail',
                'message' => 'No entries found',
            ];
        } else {
            $content = [
                'status' => 'ok',
                'items' => $data,
                'page' => $page,
                'sort' => $sort,
                'direction' => $direction,
            ];

            if ($tasksTotal > 3) {
                $pager = new Pager;
                $content['pager'] = $pager->getPagination($tasksTotal, $page, $sort, $direction);
            }
        }

        return ['Home.php', $content];
    }
}
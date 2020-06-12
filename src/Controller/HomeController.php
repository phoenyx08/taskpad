<?php

namespace App\Controller;

use App\Service\DbManager;
use App\Service\Pager;

class HomeController
{
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
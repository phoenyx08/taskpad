<?php

namespace App\Controller;

use App\Service\DbManager;
use Exception;

class TaskController
{
    public function add()
    {
        return ['Task/New.php'];
    }

    public function addProcess()
    {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $description = $_POST['description'];

        $dbManager = new DbManager();
        try {
            $dbManager->addTask($username, $email, $description);
        } catch (Exception $e) {
            die($e->getMessage());
        }
        $template = 'Task/NewProcessed.php';
        $data = [
            'status' => 'ok',
            'items' => [
                'username' => $username,
                'email' => $email,
                'description' => $description,
                'status' => $status,
            ],
        ];
        return [$template, $data];
    }

    public function edit($id)
    {
        if (empty($_SESSION['user_logged_in'])) {
            header('Location: http://' . $_SERVER['HTTP_HOST'] . '/login', true, 302);
        }

        $dbManager = new DbManager();
        $task = $dbManager->getTaskById($id);
        if ($task) {
            $template = 'Task/Edit.php';
            $data = [
                'task' => $task,
            ];
        } else {
            $template = 'Error/NotFound.php';
            $data = [
                'message' => 'Incorrect task ID',
            ];
        }
        return [$template, $data];
    }

    public function editProcess($id) {
        if (empty($_SESSION['user_logged_in'])) {
            header('Location: http://' . $_SERVER['HTTP_HOST'] . '/login', true, 302);
        }

        $username = $_POST['username'];
        $email = $_POST['email'];
        $description = $_POST['description'];
        $ready = $_POST['ready'];

        $dbManager = new DbManager();

        $result = $dbManager->updateTask($id, $username, $email, $description, $ready);

        if (!empty($result)) {
            $template='/Task/UpdateSuccess.php';
            $data = [
                'username' => $username,
                'email' => $email,
                'id' => $id,
                'description' => $description,
                'status' => ($ready == 'true') ? 'Ready' : 'In progress',
                'descriptionEdited' => $result['descriptionEdited'],
            ];
        }

        return ([$template, $data]);
    }
}
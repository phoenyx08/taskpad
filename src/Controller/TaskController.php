<?php

namespace App\Controller;

use App\Service\DbManager;

/**
 * Class TaskController
 *
 * Handles queries related to Tasks: creation, modification.
 *
 * @package App\Controller
 */
class TaskController
{
    /**
     * Add task request handler
     *
     * Just instructs which template should be rendered to add a task
     *
     * @return string[]
     */
    public function add()
    {
        return ['Task/New.php'];
    }

    /**
     * Processor of Add Task form
     *
     * Processes data inserted to the Add Task form.
     * If adding the task to the database fails dbService is responsible
     * for exiting the application run
     *
     * @return array Array of data able to be processed by rendering engine.
     */
    public function addProcess()
    {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $description = $_POST['description'];

        $dbManager = new DbManager();
        $dbManager->addTask($username, $email, $description);

        $template = 'Task/NewProcessed.php';
        $data = [
            'status' => 'ok',
            'items' => [
                'username' => $username,
                'email' => $email,
                'description' => $description,
                'status' => 'In progress',
            ],
        ];

        return [$template, $data];
    }

    /**
     * Handles request for Edit Task Form
     *
     * Showed only if the user is logged in as admin.
     * If the task id is absent in the database renders Not Found Error page
     * Finally the form for task modification is rendered
     *
     * @param $id int The Task Id
     * @return array Array of data able to be processed by rendering engine.
     */
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

    /**
     * Processor of Add Task form
     *
     * Processes data inserted to the Edit Task form.
     * If update of the task in the database fails dbService is responsible
     * for exiting the application run
     *
     * @param $id int Task Id
     * @return array Array of information able to be processed by rendering engine
     */
    public function editProcess($id)
    {
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
            $template = '/Task/UpdateSuccess.php';
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
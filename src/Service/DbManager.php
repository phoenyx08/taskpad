<?php

namespace App\Service;

use App\Config;
use Exception;
use PDO;
use PDOException;

/**
 * Class DbManager
 *
 * Service handling dbConnection and queries to the database
 *
 * @package App\Service
 */
class DbManager
{
    /**
     * @var PDO $dbh Keeps PDOObject
     */
    protected $dbh;

    /**
     * DbManager constructor.
     *
     * Constucts instance of DbManager class
     */
    public function __construct()
    {
        $config = new Config();
        $dsn = $this->getDsn($config->getDbName(), $config->getDbHost());
        $user = $config->getDbUser();
        $password = $config->getDbUserPass();

        try {
            $this->dbh = new PDO($dsn, $user, $password);
            return $this;
        } catch (PDOException $e) {
            die ($e->getMessage());
        }
    }

//    /**
//     * @return Task[] Array
//     */
//    public function getAllTasks()
//    {
//        try {
//            $result = $this->dbh->query("SELECT * FROM tasks");
//            if ($result === FALSE) {
//                $error = $this->dbh->errorInfo();
//                if ($error[0] == '42S02' && $error[1] == 1146) {
//                    $this->createTasksTable();
//                    $result = $this->dbh->query("SELECT * FROM tasks");
//                }
//            }
//            if ($result->rowCount() == 0) {
//                return[];
//            }
//            $data = [];
//            while ($item = $result->fetchObject('App\Model\Task')) {
//                $data[] = $item;
//            };
//            return $data;
//        } catch (Exception $e) {
//            die('Something went wrong on getting list of tasks');
//        }
//
//    }

    /**
     * Adding a task
     *
     * Adds a task to database, based on passed parameters
     *
     * @param $username string Username
     * @param $email string User Email
     * @param $description string Task text
     * @param string $status Status of the task
     */
    public function addTask($username, $email, $description, $status = '')
    {
        // App can be missused by a bot. This is a measure against overposting.
        if ($this->getAllTasksCount() >= 100) {
            die('Reached limit for adding tasks');
        }

        try {
            $data = [
                'username' => $username,
                'email' => $email,
                'description' => $description,
                'status' => (!empty($status)) ? $status : 'In progress',
                'updated' => 'no'
            ];
            $sql = "INSERT INTO tasks (
                userName, 
                userEmail, 
                taskDescription, 
                taskStatus, 
                descriptionUpdated
            ) VALUES (
                :username, 
                :email, 
                :description, 
                :status, 
                :updated
            )";
            $this->dbh->prepare($sql)->execute($data);
        } catch (Exception $e) {
            die('Exception on adding a task');
        }
    }

    /**
     * Create tasks table
     *
     * This method is called when found that the table does not exist
     * This way we do not need to prepare database on start of the application with some kind of migration
     */
    protected function createTasksTable()
    {
        $sql = "CREATE TABLE tasks (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            userName VARCHAR(50) NOT NULL, 
            userEmail VARCHAR(250) NOT NULL,
            taskStatus VARCHAR(250) NOT NULL,
            descriptionUpdated VARCHAR(10) NOT NULL,
            taskDescription TEXT NOT NULL);";
        $this->dbh->query($sql);
    }

    /**
     * Get Task by a Page method
     *
     * Gets task object by page and optionally by sort order and direction
     *
     * @param $page
     * @param string $order
     * @param string $direction
     * @return array
     */
    public function getTasksByPage($page, $order = 'id', $direction = 'asc')
    {
        $orderField = $order;
        if ($order == 'name') {
            $orderField = 'userName';
        } elseif ($order == 'email') {
            $orderField = 'userEmail';
        } elseif ($order == 'status') {
            $orderField = 'taskStatus';
        }

        $directionVar = 'ASC';
        if ($direction == 'desc') {
            $directionVar = 'DESC';
        }

        $limit = 3;
        $offset = $page * $limit - $limit;

        try {
            $stmt = $this->dbh->prepare("SELECT * 
                FROM tasks 
                ORDER BY $orderField $directionVar
                LIMIT :limit 
                OFFSET :offset;");
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

            $result = $stmt->execute();

            if ($result === FALSE) {
                die('Error on Getting Tasks by Page');
            }

            if ($stmt->rowCount() == 0) {
                return[];
            }

            $data = [];
            while ($item = $stmt->fetchObject('App\Model\Task')) {
                $data[] = $item;
            }

            return $data;
        } catch (Exception $e) {
            die('Something went wrong on getting list of tasks');
        }
    }

    /**
     * Get number of all tasks in the database
     *
     * Count all tasks. It is necessary for pagination
     *
     * @return int Number of all tasks in the database
     */
    public function getAllTasksCount()
    {
        try {
            $result = $this->dbh->query("SELECT * FROM tasks");

            if ($result === FALSE) {
                $error = $this->dbh->errorInfo();

                if ($error[0] == '42S02' && $error[1] == 1146) {
                    $this->createTasksTable();
                    $result = $this->dbh->query("SELECT * FROM tasks");
                }
            }

            return $result->rowCount();
        } catch (PDOException $e) {
            die('Something went wrong on counting all tasks');
        }
    }

    /**
     * Get Task by Id method
     *
     * Returns one task object by its id in the database
     *
     * @param $id int Task Id
     * @return bool|mixed FALSE returned if the task with specified id is not found
     */
    public function getTaskById($id)
    {
        try {
            $stmt = $this->dbh->prepare("SELECT * 
                FROM tasks 
                WHERE id=:id;");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $result = $stmt->execute();

            if ($result == 1) {
                if ($stmt->rowCount() == 0) {
                    return FALSE;
                }
            }

            return $stmt->fetchObject('App\Model\Task');
        } catch (PDOException $e) {
            die('Something went wrong on getting task');
        }
    }

    /**
     * Get DSN method
     *
     * The method returns connection string
     *
     * @param $dbName string Database name
     * @param $host string Gatabse host
     * @return string Connection string
     */
    protected function getDsn($dbName, $host)
    {
        return 'mysql:dbname=' . $dbName . ';host=' . $host;
    }

    /**
     * Task update
     *
     * Updates a task specified with its Id.
     * If the task description changed accorging property is set to TRUE-equivalent
     *
     * @param $id int Task id. Shows which task we want to update
     * @param $username string New username
     * @param $email string New email
     * @param $description string New task description
     * @param $ready string takes 'true' if the task should be set ready
     * @return string[] array containing information if the description was edited
     */
    public function updateTask($id, $username, $email, $description, $ready)
    {
        $result = ['descriptionUpdated' => 'no'];
        $task = $this->getTaskById($id);
        $descriptionEdited = 'no';

        if ($task->getTaskDescription() !== $description || $task->getDescriptionUpdated() == 'yes') {
            $result['descriptionEdited'] = 'yes';
            $descriptionEdited = 'yes';
        }

        try {
            $data = [
                'username' => $username,
                'id' => $id,
                'email' => $email,
                'description' => $description,
                'edited' => $descriptionEdited,
                'status' => ($ready == "true") ? "Ready" : "In progress",
            ];

            $sql = "UPDATE tasks SET 
                userName=:username, 
                userEmail=:email, 
                taskDescription=:description, 
                taskStatus=:status,
                descriptionUpdated=:edited
            WHERE id=:id;";

            $this->dbh->prepare($sql)->execute($data);

            return $result;
        } catch (Exception $e) {
            die('Exception on task update');
        }
    }
}
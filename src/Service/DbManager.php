<?php


namespace App\Service;

use App\Config;
use Exception;
use PDO;
use PDOException;

class DbManager
{
    protected $dbh;
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
            echo 'Connection Failed: ' . $e->getMessage();
        }
    }
    public function getAllTasks()
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
            if ($result->rowCount() == 0) {
                return[];
            }
            $data = [];
            while ($item = $result->fetchObject('App\Model\Task')) {
                $data[] = $item;
            };
            return $data;
        } catch (Exception $e) {
            throw new Exception('Something went wrong on getting list of tasks');
        }

    }

    public function addTask($username, $email, $description, $status = '')
    {
        try {
            $data = [
                'username' => $username,
                'email' => $email,
                'description' => $description,
                'status' => (!empty($status)) ? $status : 'In progress',
                'updated' => 'no'
            ];
            $sql = "INSERT INTO tasks (userName, userEmail, taskDescription, taskStatus, descriptionUpdated) VALUES (:username, :email, :description, :status, :updated)";
            $this->dbh->prepare($sql)->execute($data);
        } catch (Exception $e) {
            throw new Exception('Exception on adding a task' . $e->getMessage());
        }

    }

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
                $error = $this->dbh->errorInfo();
                if ($error[0] == '42S02' && $error[1] == 1146) {
                    $this->createTasksTable();
                    $stmt->execute();
                }
            }
            if ($stmt->rowCount() == 0) {
                return[];
            }
            $data = [];
            while ($item = $stmt->fetchObject('App\Model\Task')) {
                $data[] = $item;
            };
            return $data;
        } catch (Exception $e) {
            throw new Exception('Something went wrong on getting list of tasks');
        }
    }

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
        } catch (Exception $e) {
            throw new Exception('Something went wrong on counting all tasks');
        }
    }

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
        } catch (Exception $e) {
            throw new Exception('Something went wrong on getting task');
        }
    }

    protected function getDsn($dbName, $host)
    {
        return 'mysql:dbname=' . $dbName . ';host=' . $host;
    }

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
            throw new Exception('Exception on adding a task' . $e->getMessage());
        }
    }
}
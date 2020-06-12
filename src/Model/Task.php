<?php

namespace App\Model;

class Task
{
    protected $id;
    protected $userName;
    protected $userEmail;
    protected $taskDescription;
    protected $taskStatus;
    protected $descriptionUpdated;

    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @return mixed
     */
    public function getDescriptionUpdated()
    {
        return $this->descriptionUpdated;
    }

    /**
     * @param mixed $descriptionUpdated
     */
    public function setDescriptionUpdated($descriptionUpdated)
    {
        $this->descriptionUpdated = $descriptionUpdated;
    }

    /**
     * @return mixed
     */
    public function getTaskStatus()
    {
        return $this->taskStatus;
    }

    /**
     * @param mixed $taskStatus
     */
    public function setTaskStatus($taskStatus)
    {
        $this->taskStatus = $taskStatus;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $userName
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;
    }

    /**
     * @return mixed
     */
    public function getUserEmail()
    {
        return $this->userEmail;
    }

    /**
     * @param mixed $userEmail
     */
    public function setUserEmail($userEmail)
    {
        $this->userEmail = $userEmail;
    }

    /**
     * @return mixed
     */
    public function getTaskDescription()
    {
        return $this->taskDescription;
    }

    /**
     * @param mixed $taskDescription
     */
    public function setTaskDescription($taskDescription)
    {
        $this->taskDescription = $taskDescription;
    }
}
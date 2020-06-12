<?php

namespace App;

class Config
{
    public function getTemplateDir()
    {
        return dirname(__DIR__) . '/template';
    }

    public function getAdminLogin()
    {
        $settings = $this->getSettings();
        return $settings['admin_login'];
    }

    public function getAdminPassword()
    {
        $settings = $this->getSettings();
        return $settings['admin_password'];
    }

    protected function getSettings()
    {
        return parse_ini_file("settings.ini");
    }

    public function getDbName()
    {
        $settings = $this->getSettings();
        return $settings['db_name'];
    }

    public function getDbHost()
    {
        $settings = $this->getSettings();
        return $settings['db_host'];
    }

    public function getDbUser()
    {
        $settings = $this->getSettings();
        return $settings['db_user'];
    }

    public function getDbUserPass()
    {
        $settings = $this->getSettings();
        return $settings['db_user_pass'];
    }


}
<?php

namespace App;

/**
 * Class Config
 *
 * Manages the App configuration
 *
 * @package App
 */
class Config
{
    /**
     * Get template directory method
     *
     * Returns path to the templates directory
     *
     * @return string Absolute path to the templates directory
     */
    public function getTemplateDir()
    {
        return dirname(__DIR__) . '/template';
    }

    /**
     * Get Admin login method
     *
     * Returns Admin user name
     *
     * @return string Admin user name
     */
    public function getAdminLogin()
    {
        $settings = $this->getSettings();
        return $settings['admin_login'];
    }

    /**
     * Get Admin password method
     *
     * Returns Admin's password
     *
     * @return string Admin password
     */
    public function getAdminPassword()
    {
        $settings = $this->getSettings();
        return $settings['admin_password'];
    }

    /**
     * Get app settings method
     *
     * Returns array with all app settings
     *
     * @return array|false Array with the site settings of FALSE if error on opening config file
     */
    protected function getSettings()
    {
        return parse_ini_file("settings.ini");
    }

    /**
     * Get database name method
     *
     * Returns database name form config
     *
     * @return string Database name
     */
    public function getDbName()
    {
        $settings = $this->getSettings();
        return $settings['db_name'];
    }

    /**
     * Get Database Host method
     *
     * Returns database host from config
     *
     * @return string Database host
     */
    public function getDbHost()
    {
        $settings = $this->getSettings();
        return $settings['db_host'];
    }

    /**
     * Get Database User method
     *
     * Returns database user from config
     *
     * @return string Database User
     */
    public function getDbUser()
    {
        $settings = $this->getSettings();
        return $settings['db_user'];
    }

    /**
     * Get Database user password method
     *
     * Returns database user password from config
     *
     * @return string Database user password
     */
    public function getDbUserPass()
    {
        $settings = $this->getSettings();
        return $settings['db_user_pass'];
    }
}
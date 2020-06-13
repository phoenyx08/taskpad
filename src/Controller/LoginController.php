<?php

namespace App\Controller;

use App\Config;

/**
 * Class LoginController
 *
 * Handles user login
 *
 * @package App\Controller
 */
class LoginController
{
    /**
     * Login Form
     *
     * Shows login form
     *
     * @return string[] Path to template of Login Form
     */
    public function loginForm()
    {
        $_SESSION['login_return_link'] = parse_url($_SERVER['HTTP_REFERER'],PHP_URL_PATH);
        return ['Login/LoginForm.php'];
    }

    /**
     * Logout action
     *
     * Processes logout request.
     */
    public function logout()
    {
        unset ($_SESSION['user_logged_in']);
        header('Location: ' . $_SERVER['HTTP_REFERER'], true, 302);
    }

    /**
     * Login Form process action
     *
     * Processes data sent from Login Form
     *
     * @return array Array of data able to be processed by rendering engine.
     * Either confirmation of correct login or login form again but with error message
     */
    public function loginProcess()
    {
        $login = $_POST['login'];
        $password = $_POST['password'];
        $config = new Config();

        if ($login == $config->getAdminLogin() && $password == $config->getAdminPassword()) {
            $_SESSION['user_logged_in'] = 'true';
            $template = 'Login/LoginCorrect.php';

            $data = [
                'returnLink' => $_SESSION['login_return_link'] ?? '/' ,
            ];
        } else {
            $template = 'Login/LoginForm.php';
            $data = [
                'status' => 'fail',
            ];
        }
        return [$template, $data];
    }
}
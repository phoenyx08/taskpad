<?php

namespace App\Controller;

use App\Config;

class LoginController
{
    public function loginForm()
    {
        $_SESSION['login_return_link'] = parse_url($_SERVER['HTTP_REFERER'],PHP_URL_PATH);
        return ['Login/LoginForm.php'];
    }

    public function logout()
    {
        unset ($_SESSION['user_logged_in']);
        header('Location: ' . $_SERVER['HTTP_REFERER'], true, 302);
    }

    public function loginProcess()
    {
        $login = $_POST['login'];
        $password = $_POST['password'];

        $config = new Config();

        if ($login == $config->getAdminLogin() && $password == $config->getAdminPassword()) {
            $_SESSION['user_logged_in'] = 'true';
            $template = 'Login/LoginCorrect.php';
            $returnLink = '/';
            if (!empty($_SESSION['login_return_link'])) {
                $returnLink = $_SESSION['login_return_link'];
            }
            $data = [
                'returnLink' => $returnLink,
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
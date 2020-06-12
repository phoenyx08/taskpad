<?php

namespace App\Service;

class Router
{
    public static function getAction()
    {
        if ($_SERVER['REQUEST_URI'] == '/') {
            return ['App\Controller\HomeController::index',[]];
        }

        if ($_SERVER['REQUEST_URI'] == '/logout') {
            return ['App\Controller\LoginController::logout',[]];
        }

        if ($_SERVER['REQUEST_URI'] == '/task/new') {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                return ['App\Controller\TaskController::addProcess',[]];
            } else {
                return ['App\Controller\TaskController::add', []];
            }
        }

        if ($_SERVER['REQUEST_URI'] == '/login') {
            if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                return ['App\Controller\LoginController::loginProcess',[]];
            } else {
                return ['App\Controller\LoginController::loginForm',[]];
            }
        }

        if (preg_match('/^\/page\/([0-9]*)$/', $_SERVER['REQUEST_URI'], $matches) == 1) {
            return ['App\Controller\HomeController::index', [$matches[1]]];
        }

        if (preg_match('/^\/task\/([0-9]*)\/edit$/', $_SERVER['REQUEST_URI'], $matches) == 1) {
            if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                return ['App\Controller\TaskController::editProcess', [$matches[1]]];
            } else {
                return ['App\Controller\TaskController::edit', [$matches[1]]];
            }
        }

        if (preg_match('/^\/page\/([0-9]*)\/sort\/(name|email|status)\/direction\/(asc|desc)$/', $_SERVER['REQUEST_URI'], $matches) == 1) {
            return ['App\Controller\HomeController::index', [$matches[1], $matches[2], $matches[3]]];
        }

        return ['App\Controller\ErrorController::notFound', []];
    }
}
<?php

namespace App\Controller;

/**
 * Class ErrorController
 *
 * Handles errors
 *
 * @package App\Controller
 */
class ErrorController
{
    /**
     * Not Found action
     *
     * Fires, when requested resource is not found
     *
     * @return array
     */
    public function notFound()
    {
        return ['Error/NotFound.php', ['message' => 'Page not found']];
    }
}
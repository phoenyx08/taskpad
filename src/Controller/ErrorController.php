<?php

namespace App\Controller;

class ErrorController
{
    public function notFound()
    {
        return ['Error/NotFound.php', ['message' => 'Page not found']];
    }
}
<?php

namespace App;

use App\Service\Router;

class Core
{
    public function start()
    {
        session_start();
        $action = Router::getAction();
        $result = call_user_func_array($action[0], $action[1]);
        $this->render($result);
    }

    protected function render($result)
    {
        $config = new Config();
        $templateDir = $config->getTemplateDir();
        $template = join(DIRECTORY_SEPARATOR, [$templateDir, $result[0]]);
        if (!empty($result[1])) {
            $variables = $result[1];
        }
        require_once(join(DIRECTORY_SEPARATOR, [$templateDir, 'Layout.php']));
    }
}
<?php

namespace App;

use App\Service\Router;

/**
 * Class Core
 *
 * Central class of the application
 *
 * @package App
 */
class Core
{
    /**
     * App start method
     *
     * Initializes the session and calls methods of the app lifecycle
     *
     */
    public function start()
    {
        session_start();
        $action = Router::getAction();
        $result = call_user_func_array($action[0], $action[1]);
        $this->render($result);
    }

    /**
     * Render method
     *
     * Renders the specified template using provided variables
     *
     * @param $result array result of the methods of lifecycle before calling renderer
     */
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
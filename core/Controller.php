<?php

declare(strict_types=1);

namespace app\core;

class Controller
{
    public function render(string $view, array $params = [])
    {
        Application::$app->router->renderView($view, $params);
    }

}
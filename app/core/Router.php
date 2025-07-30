<?php

class Router
{
    public function run()
    {
        $uri = $_GET['url'] ?? 'home';

        $controllerName = ucfirst($uri) . 'Controller';
        $controllerFile = 'controllers/' . $controllerName . '.php';

        if (file_exists($controllerFile)){
            require_once $controllerFile;
            $controller = new $controllerName();
            $controller->index();
        } else {
            echo "Página não encontrada!";
        }
    }
}
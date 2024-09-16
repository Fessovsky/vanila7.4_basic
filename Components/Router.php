<?php

namespace Components;

use Components\Contracts\ControllerInterface;

final class Router
{
    private array $routes;

    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    public function dispatch(string $uri, $httpMethod): void
    {
        $uri = parse_url($uri, PHP_URL_PATH);
        $uri = rtrim($uri, '/'); // Удаляем завершающий слеш для консистентности
        if ($uri === '') {
            $uri = '/';
        }
        if (isset($this->routes[$httpMethod][$uri])) {
            $route = $this->routes[$httpMethod][$uri];
            $controllerName = $route['controller'];
            $action = $route['action'];

            if (class_exists($controllerName)) {

                $controller = $this->createController($controllerName);
                if (method_exists($controller, $action)) {
                    $controller->$action();
                    return;
                }
            }
        }

        throw new \Exception('Страница не найдена', 404);
    }
    private function createController(string $controllerName): ControllerInterface
    {
        switch ($controllerName) {
            case 'Components\Controllers\HomeController':
            case 'Components\Controllers\UploadController':
            case 'Components\Controllers\NotifyController':
                return new $controllerName();
            default:
                throw new \Exception('Неизвестный контроллер: ' . $controllerName);
        }
    }
}
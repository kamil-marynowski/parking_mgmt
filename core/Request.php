<?php

declare(strict_types=1);

namespace Core;

class Request
{
    private string $route;

    private string $method;

    public function setRoute(string $route): void
    {
        $this->route = $route;
    }

    public function getRoute(): string
    {
        return $this->route;
    }

    public function post(string $key)
    {
        return $_POST[$key];
    }

    public function get(string $key)
    {
        return $_GET[$key];
    }

    public function routeExists(string $route, array $routes): bool
    {
        return array_key_exists($route, $routes);

    }

    public function setMethod(string $method)
    {
        $this->method = $method;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function runAction(Request $request, array $routes): Response
    {
        $controller = new $routes[$this->route]['controller']();
        $action = $routes[$this->route]['action'];

        return $controller->$action($request);
    }

}
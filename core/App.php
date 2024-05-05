<?php

declare(strict_types=1);

namespace Core;

class App
{
    public function run(): void
    {
        $request = new Request();

        if (!array_key_exists('route', $_GET)) {
            $_GET['route'] = '/';
        }

        $request->setRoute($request->get('route'));
        $request->setMethod($_SERVER['REQUEST_METHOD']);

        $response = $this->handleRequest($request);
        $this->handleResponse($response);
    }

    public static function getProjectRootPath(): string
    {
        return __DIR__ . '/../';
    }

    private function handleRequest(Request $request): Response
    {
        $routes = Config::get('routes', 'routes');

        if (!$request->routeExists($request->getRoute(), $routes)) {
            $response = new Response(Response::VIEW);
            $response->setView((new View('errors/404.view.php', [])));

            return $response;
        }

        if ($request->getMethod() !== $routes[$request->getRoute()]['method']) {
            $response = new Response(Response::VIEW);
            $response->setView((new View('errors/405.view.php', [])));

            return $response;
        }

        return $request->runAction($request, $routes);
    }

    private function handleResponse(Response $response): void
    {
        http_response_code($response->getCode());
        switch ($response->getType()) {
            case Response::VIEW:
                $response->getView()->render();
                break;
            case Response::JSON:
                header('Content-Type: application/json; charset=utf-8');

                printf(json_encode($response->getData()));
                break;
            case Response::REDIRECT:
                header('Location: ' . Config::get('app', 'base_uri') . $response->getRedirectRoute());
                break;
            //there could be more response types but this apps uses only these two so and at this time I avoided make
            //unnecessary (for this project) code
            default:
                break;
        }
    }
}
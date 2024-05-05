<?php

declare(strict_types=1);

namespace Core;

abstract class Controller
{
    /**
     * Creates View and returns view response.
     *
     * @param string $view
     * @param array $data
     * @return Response
     */
    public function view(string $view, array $data = []): Response
    {
        $view = new View(view: $view, data: $data);

        $response = new Response(type: Response::VIEW);
        $response->setView($view);

        return $response;
    }

    /**
     * Creates JSON response.
     *
     * @param array $data
     * @return Response
     */
    public function json(array $data = [], int $code = Response::HTTP_OK): Response
    {
        $response = new Response(type: Response::JSON, code: $code);
        $response->setData($data);

        return $response;
    }

    public function redirect(string $route, array $data = []): Response
    {
        $response = new Response(type: Response::REDIRECT);
        $response->setData($data);

        return $response;
    }
}
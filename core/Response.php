<?php

declare(strict_types=1);

namespace Core;

class Response
{
    public const HTTP_OK = 200;
    public const UNPROCESSABLE_CONTENT = 422;

    /** Response types */
    public const VIEW = 'view';
    public const JSON = 'json';
    public const REDIRECT = 'redirect';

    private string $type;

    private View $view;

    private array $data;

    private string $redirectRoute;

    private int $code;

    public function __construct(string $type, int $code = Response::HTTP_OK)
    {
        $this->type = $type;
        $this->code = $code;
    }

    public function setView(View $view): void
    {
        $this->view = $view;
    }

    public function getView(): View
    {
        return $this->view;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setRedirectRoute(string $route): void
    {
        $this->redirectRoute = $route;
    }

    public function getRedirectRoute(): string
    {
        return $this->redirectRoute;
    }

    public function setCode(int $code): void
    {
        $this->code = $code;
    }

    public function getCode(): int
    {
        return $this->code;
    }
}
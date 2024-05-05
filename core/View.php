<?php

declare(strict_types=1);

namespace Core;

class View
{
    public const DIR = '/views/';

    private string $view;

    private array $data;

    public function __construct(string $view, array $data)
    {
        $this->view = $view;
        $this->data = $data;
    }

    public function render(): void
    {
        $data = $this->data;

        include App::getProjectRootPath() . self::DIR . $this->view;
    }
}
<?php

declare(strict_types=1);

class Router
{
    protected $routes = [];

    private function add_route(string $url, string $page, string $method): void
    {
        $this->routes[] = [
            "page" => $page . '.php',
            "url" => BASE_URL . $url,
            "method" => $method
        ];
    }

    public function get(string $url, string $page): void
    {
        $this->add_route($url, $page, 'GET');
    }

    public function post(string $url, string $page): void
    {
        $this->add_route($url, $page, 'POST');
    }

    public function route(string $url, string $method)
    {
        foreach ($this->routes as $route) {
            if ($route['url'] === $url && $route['method'] === $method) {
                if (str_contains($url, "api")) return require base_path("api/{$route['page']}");

                return require base_path("pages/{$route['page']}");
            }
        }

        http_response_code(404);
        return require base_path("pages/404.php");
    }
}
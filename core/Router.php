<?php

class Router {
    private $routes = [];
    private $config;

    public function __construct($config) {
        $this->config = $config;
    }

    public function get($path, $callback) {
        $this->routes['GET'][$path] = $callback;
    }

    public function post($path, $callback) {
        $this->routes['POST'][$path] = $callback;
    }

    public function resolve() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        $basePath = $this->config['base_path'];

        if (str_starts_with($uri, $basePath)) {
            $uri = substr($uri, strlen($basePath));
        }

        if ($uri === '') {
            $uri = "/";
        }

        foreach ($this->routes[$method] ?? [] as $route => $callback) {
            $pattern = preg_replace('#:([a-zA-Z0-9_]+)#', '([^/]+)', $route);
            $pattern = "#^" . $pattern . "$#";

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // full match eruit

                return call_user_func_array($callback, $matches);
            }
        }

        http_response_code(404);
        return "404";
    }
}
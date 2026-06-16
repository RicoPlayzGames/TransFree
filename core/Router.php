<?php

class Router {
    private $routes = [];
    private $config;

    public function __construct($config) {
                // Sla de configuratie op
        $this->config = $config;
    }

        // Registreer een GET route
    public function get($path, $callback) {
        $this->routes['GET'][$path] = $callback;
    }

        // Registreer een POST route
    public function post($path, $callback) {
        $this->routes['POST'][$path] = $callback;
    }

    public function resolve() {
                // Haal de methode (GET/POST) en het huidig pad op
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        $basePath = $this->config['base_path'];

                // Verwijder het basispad uit de URL
        if (str_starts_with($uri, $basePath)) {
            $uri = substr($uri, strlen($basePath));
        }

                // Als het pad leeg is, gebruik dan de hoofdpagina
        if ($uri === '') {
            $uri = "/";
        }

                // Loop door alle geregistreerde routes
        foreach ($this->routes[$method] ?? [] as $route => $callback) {
                        // Zet de route om naar een regex patroon
            $pattern = preg_replace('#:([a-zA-Z0-9_]+)#', '([^/]+)', $route);
            $pattern = "#^" . $pattern . "$#";

                        // Als de URL overeenkomt met de route, voer dan de bijbehorende functie uit
            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // full match eruit

                return call_user_func_array($callback, $matches);
            }
        }

        http_response_code(404);
        return "404";
    }
}
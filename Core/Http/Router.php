<?php 

namespace App\Core\Http;

class Router {

    protected array $routes = [];
    protected const HTTP_METHODS = ['GET', 'POST'];

    public function get($path, $callback)
    {
        $this->routes['GET'][$path] = $callback;
    }

    public function __call($name, $arguments)
    {
        [$method, $path, $callback] = $arguments;

        if(in_array($method, self::HTTP_METHODS)) {
            echo " {$method} not yet defined";
        }
    }

    public function resolve(Request $request) {
            $path = $request->getPath();
            $method = $request->getMethod();

            $action = $this->routes[$method][$path] ?? function() {echo "404 Not found";};

            call_user_func($action);

    }
}
<?php 

namespace App\Core\Http;

use App\Core\Foundation\Application;
use Closure;

class Router {

    protected array $routes = [];
    protected const HTTP_METHODS = ['GET', 'POST'];

    public function get($path, Closure|string $action, ?string $method = null)
    {
        if($action instanceof Closure) {
            $this->routes['GET'][$path] = $action;

            return;
        }

        if(!!$method) {
            //if there is a method, the classname, methodname 
            $controller = new $action;
            $action = [$controller, $method];
            $this->routes['GET'][$path] = $action;

            return;
         }

        if(strpos($action, '@') === false) {
            //no @ means it tries to return the view
            $action = fn() => 'App\\Resources\\Views\\' . $action; 
            $this->routes['GET'][$path] = $action;
            
            return;
        }
            
        [$controller, $method] = explode('@', $action, 2) + [1 => 'index'];
        $controller = 'App\\Controller\\' . $controller;
        $controller = new $controller;
        $action = [$controller, $method];

        $this->routes['GET'][$path] = $action;
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

            // get wildcard from path, so we have to take a look if there is a match, and we have to go in order
            // we must filter where [path] == [pathInRoute] || [pathInRoutes] == wildcard
            // so maybe
            /*
            $pathExploded = explode('/', $path);
            $pathArguments = [];

            foreach($this->routes[$method] as $registeredRoute)


                $registeredPathExploded = explode('/', $registeredRoute);

                if(count($pathExploded) !== count($registeredPathExploded)) continue; 
                
                foreach($registeredPathExploded as $index => $part) {
                    if (preg_match('{name}')) { //-> wildcard
                            $pathArguments['name'] = $pathExploded[$index];

                            continue;
                    }

                    if($part != $pathExploded[$index]) continue 2; // no wildcard, no match, by outer loop

                    //no it is a match, so just keep on looping
                
                }

                //we are done, so just  return the callback we found
                return call_user_func($action);


            */
            
            return call_user_func($action);
    }

    public function registerRoutes(string $routesFile)
    {
        $routeDirectory = '/Routes';
        include(Application::get()->basePath("{$routeDirectory}/{$routesFile}"));
    }
}
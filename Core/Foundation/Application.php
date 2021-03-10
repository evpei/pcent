<?php
namespace App\Core\Foundation;

use App\Core\Provider\ServiceProvider;
use App\Core\Http\Kernel;
use App\Core\Http\Router;

class Application {

protected Router $router;

protected ServiceProvider $serviceProvider;

protected static ?self $instance = null;

protected array $instances = [];

protected ?string $basePath;


public function __construct(Router $router, ServiceProvider $serviceProvider, $basePath = null)
{  
    $this->router = $router;
    $this->serviceProvider = $serviceProvider;
    $this->basePath = $basePath;
}

static function run($basePath)
{
    $router = new Router();
    $serviceProvider = new ServiceProvider($router);
    $app =  new self($router, $serviceProvider, $basePath);
    static::$instance = $app;

    $app->boot();

   return $app;
}

/*
* Resolve the given type from the container.
*
*/
public function make($abstract, ...$parameters) :object
{
    return new $abstract();
}

public function boot()
{
    $this->instance('router', $this->router);
    $this->serviceProvider->boot();
}

public function __call($name, $arguments)
{
    $function = $name;

    if(str_starts_with($function, 'make')) {
        $function = ltrim($function, 'make');
        $function = lcfirst($function);
    }


    return method_exists($this, $function) ? $this->$function($arguments) : null;
}

public function instance(string $name, object $instance)
{
   $this->instances[$name] = $instance;
}

public function kernel()
{
    return new Kernel($this, $this->router);
}

public function __get($name)
{
    if($this->instances[$name] ?? false) {
        return $this->instances[$name];
    }
}

public static function get() :?self
{
    return static::$instance;
}

public function test()
{
    echo "static";
}

public function basePath(string $path)
{
    return $this->basePath . '/' . $path;
}

}
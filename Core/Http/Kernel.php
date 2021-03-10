<?php
namespace App\Core\Http;

use App\Core\Foundation\Application;

class Kernel {
public function __construct(protected Application $app, protected Router $router)
{ 
}

public function handle(Request $request)
{
    $this->app->instance('request', $request);
    $this->router->resolve($request);    
}

}
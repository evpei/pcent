<?php

namespace App\Core\Provider;

use App\Core\Http\Router;

class ServiceProvider {


    public function __construct(protected Router $router)
    {
    }

    public function boot()
    {
        $this->registerRoutes($this->router);
    }

    public function registerRoutes(Router $router)
    {
        require_once(app()->basePath('routes.php'));
    }
    
}
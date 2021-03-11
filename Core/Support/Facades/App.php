<?php 
namespace App\Core\Support\Facades;

class App extends Facade {

    public static function getFacadeAccessor()
    {
        return 'application';
    }
}
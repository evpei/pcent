<?php 
namespace App\Core\Support\Facades;

use Closure;

class Facade {
    /**
     * The resolved object instances.
     *
     * @var array
     */
    protected static $resolvedInstance;


    public static function getFacadeAccessor()
    {
        echo "RUNTIME ERROR";
        exit;
    }

    public static function getFacadeRoot()
    {
        return static::resolveFacadeInstance(static::getFacadeAccessor());
    }

    protected static function resolveFacadeInstance(string $name)
    {
        if (isset(static::$resolvedInstance[$name])) {
            return static::$resolvedInstance[$name];
        }

        if (app()) {
            return static::$resolvedInstance[$name] = app()->$name;
        }
    }

    public static function __callStatic($method, $args)
    {
        $instance = static::getFacadeRoot();

        if (! $instance) {
            echo "RUNTIME ERROR";
            exit;
        }

        return $instance->$method(...$args);
    }
}
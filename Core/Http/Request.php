<?php

namespace App\Core\Http;

class Request {

protected string|null $queryString;

protected string $requestUri;

protected string $path;

protected string $method;

protected array $data;


    public function __construct( string $method, string $path, string $requestUri, string|null $queryString = null, array $data = [])
    {
       $this->queryString = $queryString;
       $this->requestUri = $requestUri;
       $this->method = $method;
       $this->path = $path;
       $this->data = $data;
    }

    public static function capture()
    {
        $server =  $_SERVER;
        $requestUri = $server['REQUEST_URI'] ?? '/';
        [$path, $queryString] = explode('?', $requestUri, 2) + [ 1 => null];  // to shut down php warning :) 
        $method = $server['REQUEST_METHOD'] ?? 'GET'; // if there is no method, just use get 
        
        return new self($method, $path, $requestUri, $queryString, self::getRequestData());
    }

    public static function getRequestData() :array
    {
        $request = $_REQUEST;

        return is_array($request) ? $request : [];
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getQueryString()
    {
        return $this->queryString;
    }

    public function requestUri()
    {
        return $this->requestUri;
    }

}
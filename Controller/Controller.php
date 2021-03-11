<?php
namespace App\Controller;

class Controller {

    public function go()
    {
        return view('index');
    }

    public function index()
    {
        echo 'index';
        return 'index';
    }
    
}
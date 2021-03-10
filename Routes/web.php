<?php

use App\Core\Support\Facades\Route;

Route::get('/', function() {echo "Hello"; return 'callback';});

Route::get('/action', 'Controller@go');

Route::get('/method', 'App\\Controller\Controller', 'index');

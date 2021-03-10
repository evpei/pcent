<?php

use App\Core\Support\Facades\Route;

Route::get('/', function() {echo "Hello";});

Route::get('/elias', function() {echo "elias";});

Route::get('/peters', function() {echo "peters";});

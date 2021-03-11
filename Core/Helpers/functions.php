<?php

use App\Core\Foundation\Application;

function app() {
    return Application::get();
}

function view(string $viewPath) {
    $viewPath = str_replace('.', '/', $viewPath); //use dots if you want
    $viewExtension = '.tent.php';

    return Application::get()->basePath('Resources/Views/' . $viewPath . $viewExtension);
}
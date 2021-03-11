<?php
$basePath = dirname(__DIR__); // fix this
require_once($basePath . '/vendor/autoload.php');

use App\Core\Http\Request;
use App\Core\Foundation\Application;


$app = Application::run($basePath);

$kernel = $app->makeKernel();
$kernel->handle($request = Request::capture());


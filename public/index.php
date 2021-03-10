<?php
require_once(__DIR__ . '/../vendor/autoload.php');

use App\Core\Http\Request;
use App\Core\Foundation\Application;

$basePath = __DIR__ . '/..'; // fix this

$app = Application::run($basePath);

$kernel = $app->makeKernel();
$kernel->handle($request = Request::capture());


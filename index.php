<?php
require_once(__DIR__ . '/vendor/autoload.php');

use App\Core\Http\Request;
use App\Core\Foundation\Application;

$app = Application::run(__DIR__);

$kernel = $app->makeKernel();
$kernel->handle($request = Request::capture());


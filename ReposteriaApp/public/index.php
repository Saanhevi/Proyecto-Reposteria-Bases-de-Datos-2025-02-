<?php

declare(strict_types=1);

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides an auto-loader for our classes so we just require it
| here. That gives us convenient, instant access to our classes.
|
*/

require __DIR__ . '/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Turn On The Lights
|--------------------------------------------------------------------------
|
| We need to boot up the framework so that it is ready to receive HTTP
| requests. We do that by requiring the bootstrap file which returns
| the application instance.
|
*/

$app = require_once __DIR__ . '/../bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we create the HTTP kernel that handles
| the incoming request and send the response back to the browser.
|
*/

$kernel = $app->make(Kernel::class);

$request = Request::capture();

$response = $kernel->handle($request);

$response->send();

$kernel->terminate($request, $response);

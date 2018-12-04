<?php declare(strict_types=1);

namespace Dykyi\App;

use Dotenv\Dotenv;
use Dykyi\Application\Containers;
use Dykyi\Application\Kernel;
use Symfony\Component\HttpFoundation\Request;
use Whoops\Run as Whoops;

\define('ROOT_DIR', __DIR__ . '/../src');

\call_user_func(function () {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    require_once __DIR__ . '/../vendor/autoload.php';

    if (!class_exists(Dotenv::class)) {
        throw new \RuntimeException('APP_ENV environment variable is not defined');
    }
    (new Dotenv(__DIR__ . '/../'))->load();

    if ((bool)getenv('debug_mode')) {
        Containers::init()->get(Whoops::class);
    }


    $request = Request::createFromGlobals();
    $response = Kernel::handle($request);
    $response->send();
});

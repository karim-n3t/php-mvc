<?php

/**
 * Router
 *
 * PHP version 7.0
 */

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $route) {
    require_once dirname(__DIR__) . '/App/Routes.php';
});

 // Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        echo '404 Not Found'; // ... 404 Not Found
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        echo '405 Method Not Allowed';// ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        //echo 'Hello '. $handler . $vars;// ... call $handler with $vars
        list($class, $method) = explode("@", $handler, 2);
        $class = 'App\Controllers\\'.$class;
        call_user_func_array(array(new $class, $method), $vars);
        break;
}
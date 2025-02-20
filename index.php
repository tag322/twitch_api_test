<?php

require 'vendor/autoload.php'; 

use App\Routing\Router;

$routes = [
    '/' => 'index',
    '/main' => 'main',
    '/redirect_access_token' => 'redirectAccessToken',
    '/retrieve_user_info' => 'retrieveUserInfo',
    '/retrieve_chat' => 'retrieveChat',
    '/api/store_user_info' => 'API_storeUserInfo'
];

function getRequestPath() {
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    return '/' . ltrim(str_replace('index.php', '', $path), '/');
}

function getMethod(array $routes, $path) {
    foreach ($routes as $route => $method) {
        if ($path === $route) {
            return $method;
        }
    }

    return 'notFound';
}

$path = getRequestPath();
$method = getMethod($routes, $path);
$router = new Router();
echo $router->$method();
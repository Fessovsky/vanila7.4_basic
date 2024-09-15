<?php

require 'Components/Router.php';
require 'Components/Autoloader.php';

use Components\Autoloader;
use Components\Router;

Autoloader::register();

include 'Public/header.html';

$routes = require 'routes.php';
$router = new Router($routes);
$uri = $_SERVER['REQUEST_URI'];
$httpMethod = $_SERVER['REQUEST_METHOD'];

try {
    $router->dispatch($uri,$httpMethod);
} catch (\Error|\Exception $e) {
    // TODO implement error handling
    echo '<br>' . $e->getMessage();
    echo '<br><a href="/">Home</a>';
    die();
}


include 'Public/footer.html';
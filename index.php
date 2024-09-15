<?php

require 'Components/Router.php';
require 'Components/Autoloader.php';

use Components\Autoloader;
use Components\DB;
use Components\Router;

Autoloader::register();

$PDO = DB::getInstance();
$connection = $PDO->getConnection();

include 'Public/header.html';

$router = new Router();
$router->router();

include 'Public/footer.html';

// Маршрутизировать uri (Home, Upload)
// Вывести страницу
// URI: /upload загрузку файла, наззвание файла проеверить на валидность .csv не лолжен содержать опасных конструкций
// При загрузке файл должен быть yield-нут в таблицу. при этом нужно передавать байндингами
// При загрузке файла нужно проверить на валидность, если файл не валиден, то вывести ошибку

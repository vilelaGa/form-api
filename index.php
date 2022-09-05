<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-Type: Application/json");

use CoffeeCode\Router\Router;

require __DIR__ . "/vendor/autoload.php";
require __DIR__ . "/app/Config.php";

$router = new Router(HTTP_HOST);

/**
 * Controllers
 */
$router->namespace("App\Controllers");


/**
 * Web
 * home
 */
$router->group(null);
$router->post("/cadastrar/", "Methods:Cadastrar");



/**
 * Web
 * error
 */
$router->group("ops");
$router->get('/{errcode}', "Methods:error");


//Execulta as rotas
$router->dispatch();


//Check erro na rota
if ($router->error()) {
    $router->redirect("/ops/{$router->error()}");
}

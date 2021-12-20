<?php
use app\utils\Db;
use app\controllers\RouterController;

mb_internal_encoding("UTF-8");
ini_set('display_errors', 1);
error_reporting(E_ALL);

spl_autoload_register(function ($class) {
    $class = ltrim($class, "app\\");
    require_once($class . ".php");
});

Db::connect();

$router = new RouterController(array($_SERVER['REQUEST_URI']));
$router->return_view();
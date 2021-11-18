<?php
use app\utils\Db;
use app\controllers\RouterController;

mb_internal_encoding("UTF-8");
ini_set('display_errors', 1);
error_reporting(E_ALL);

const DB_IP_ADDRESS = "127.0.0.1";
const DB_USER = "root";
const DB_PASSWORD = "";
const DB_NAME = "db_conference";

spl_autoload_register(function ($class) {
    $class = ltrim($class, "app\\");
    require_once($class . ".php");
});

Db::connect(DB_IP_ADDRESS, DB_USER, DB_PASSWORD, DB_NAME);

$router = new RouterController(array($_SERVER['REQUEST_URI']));
$router->return_view();
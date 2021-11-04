<?php
const DB_IP_ADDRESS = "127.0.0.1";
const DB_USER = "root";
const DB_PASSWORD = "";
const DB_NAME = "";

mb_internal_encoding("UTF-8");
ini_set('display_errors', 1);
error_reporting(E_ALL);

function autoload_function($class)
{
    if (preg_match('/Controller$/', $class))
        require_once("controllers/" . $class . ".php");
    elseif (preg_match('/Model$/', $class))
        require_once("models/" . $class . ".php");
    else
        require_once("classes/" . $class . ".php");
}

spl_autoload_register("autoload_function");

//Db::connect(DB_IP_ADDRESS, DB_USER, DB_PASSWORD, DB_NAME);

$router = new RouterController(array($_SERVER['REQUEST_URI']));
$router->return_view();
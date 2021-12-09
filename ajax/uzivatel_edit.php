<?php
if (!isset($_REQUEST["id"])) return;

require_once("..\\models\\UsersModel.php");
require_once("..\\utils\\Db.php");

use app\models\UsersModel;
use app\utils\Db;

const DB_IP_ADDRESS = "127.0.0.1";
const DB_USER = "root";
const DB_PASSWORD = "";
const DB_NAME = "db_conference";

Db::connect(DB_IP_ADDRESS, DB_USER, DB_PASSWORD, DB_NAME);

$usersModel = new UsersModel();

if (isset($_REQUEST["toggle_ban"])) {
    $usersModel->toggleUserBan($_REQUEST["id"]);
    echo json_encode($usersModel->getUserBanned($_REQUEST["id"]));
}

if (isset($_REQUEST["new_role"])) {
    $usersModel->changeUserRole($_REQUEST["id"], $_REQUEST["new_role"]);
    echo json_encode($usersModel->getUserRole($_REQUEST["id"]));
}
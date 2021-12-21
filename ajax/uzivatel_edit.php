<?php
require_once("../utils/VariableChecker.php");
require_once("..\\models\\UsersModel.php");
require_once("..\\utils\\Db.php");

use app\models\UsersModel;
use app\utils\Db;
use app\utils\VariableChecker;

$requiredVars = ['admin_id', 'id'];
if (!VariableChecker::requestVarsSet($requiredVars)) return;

Db::connect();

$usersModel = new UsersModel();

$admin = $usersModel->getUserByID($_REQUEST['admin_id']);

if ($admin['banned']) return;

if (isset($_REQUEST["toggle_ban"])) {
    $usersModel->toggleUserBan($_REQUEST["id"]);
    echo json_encode($usersModel->getUserBanned($_REQUEST["id"]));
}

if (isset($_REQUEST["new_role"])) {
    $usersModel->changeUserRole($_REQUEST["id"], $_REQUEST["new_role"]);
    echo json_encode($usersModel->getUserRole($_REQUEST["id"]));
}
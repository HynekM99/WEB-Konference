<?php

use app\models\ArticlesModel;
use app\models\UserRolesModel;
use app\utils\VariableChecker;
use app\models\UsersModel;
use app\utils\Db;

require_once("../models/ArticlesModel.php");
require_once("../models/UserRolesModel.php");
require_once("../utils/VariableChecker.php");
require_once("../models/UsersModel.php");
require_once("../utils/Db.php");

$requiredVars = ["user_id", "article_id"];
if (!VariableChecker::requestVarsSet($requiredVars)) return;

Db::connect();

$articlesModel = new ArticlesModel();
$usersModel = new UsersModel();

$loggedUser = $usersModel->getUserByID($_REQUEST['user_id']);

$allowedUsers = [UserRolesModel::ROLE_AUTHOR, UserRolesModel::ROLE_SUPER];
$canRemove = !$loggedUser['banned'] && in_array($loggedUser['id_user_rights'], $allowedUsers);

if ($canRemove) {
    $articleId = $_REQUEST['article_id'];
    $articlesModel->deleteArticle($articleId);
    echo $articlesModel->getArticle($articleId);
}
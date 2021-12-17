<?php

use app\models\ReviewsModel;
use app\models\UserRolesModel;
use app\utils\VariableChecker;
use app\models\UsersModel;
use app\utils\Db;

require_once("../models/ReviewsModel.php");
require_once("../models/UserRolesModel.php");
require_once("../utils/VariableChecker.php");
require_once("../models/UsersModel.php");
require_once("../utils/Db.php");

$requiredVars = ["admin_id"];
if (!VariableChecker::requestVarsSet($requiredVars)) return;

const DB_IP_ADDRESS = "127.0.0.1";
const DB_USER = "root";
const DB_PASSWORD = "";
const DB_NAME = "db_conference";

Db::connect(DB_IP_ADDRESS, DB_USER, DB_PASSWORD, DB_NAME);

$usersModel = new UsersModel();
$reviewsModel = new ReviewsModel();

$adminId = $_REQUEST['admin_id'];
$admin = $usersModel->getUserByID($adminId);
$isAdmin = $admin['id_user_rights'] == UserRolesModel::ROLE_ADMIN || $admin['id_user_rights'] == UserRolesModel::ROLE_SUPER;
$canEdit = $isAdmin && !$admin['banned'];

if (!$canEdit) return;

if (VariableChecker::requestVarsSet(["article_id", "reviewer_id"])) {
    $articleId = $_REQUEST['article_id'];
    $reviewerId = $_REQUEST['reviewer_id'];

    echo $reviewsModel->setReviewer($reviewerId, $articleId);
}
else if (VariableChecker::requestVarsSet(["review_id"])) {
    $reviewId = $_REQUEST['review_id'];

    $review = $reviewsModel->getReview($reviewId);
    if (!$review) return;
    $reviewsModel->deleteReview($reviewId);

    $reviewer = $usersModel->getUserByID($review['id_reviewer']);
    if ($reviewer['id_user_rights'] == UserRolesModel::ROLE_REVIEWER) {
        echo json_encode(array("id_article" => $review['id_article'], "id_reviewer" => $reviewer['id'], "reviewer_name" => $reviewer['full_name']));
    } else {
        echo json_encode(array("id_article" => $review['id_article']));
    }
}
else {
    echo false;
}
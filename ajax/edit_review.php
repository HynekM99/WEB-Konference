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

$requiredVars = ["user_id", "article_id", "content_score", "relevance_score", "language_score", "comment"];
if (!VariableChecker::requestVarsSet($requiredVars)) return;

Db::connect();

$usersModel = new UsersModel();
$reviewsModel = new ReviewsModel();

$loggedUser = $usersModel->getUserByID($_REQUEST['user_id']);
$canReview = !$loggedUser['banned'] && $loggedUser['id_user_rights'] == UserRolesModel::ROLE_REVIEWER;

if ($canReview) {
    $userId = $_REQUEST['user_id'];
    $articleId = $_REQUEST['article_id'];
    $contentScore = $_REQUEST['content_score'];
    $relevanceScore = $_REQUEST['relevance_score'];
    $languageScore = $_REQUEST['language_score'];
    $overallScore = (int)(($contentScore + $relevanceScore + $languageScore) / 3);
    $comment = $_REQUEST['comment'];

    echo ($reviewsModel->setReview($userId, $articleId, $contentScore, $relevanceScore, $languageScore, $overallScore, $comment) > 0);
}
<?php
namespace app\controllers;

use app\models\ArticlesModel;
use app\models\ReviewsModel;
use app\models\UserRolesModel;
use app\models\UsersModel;
use app\utils\Login;
use app\utils\VariableChecker;

class RecenzentClankyController extends Controller {
    private UsersModel $usersModel;
    private ArticlesModel $articlesModel;
    private ReviewsModel $reviewsModel;

    public function __construct() {
        $this->usersModel = new UsersModel();
        $this->articlesModel = new ArticlesModel();
        $this->reviewsModel = new ReviewsModel();

        $this->header['title'] = 'Vlastní recenze';
        $this->header['keywords'] = 'články, příspěvky, recenze, konference';
        $this->header['description'] = 'Vlastní recenze';
        $this->view = 'moje_recenze';

        $this->processData();
    }

    private function processData() {
        $userId = Login::getUserID();
        $loggedUser = $this->usersModel->getUserByID($userId);
        $this->data['user_id'] = $userId;
        $this->data['logged_id'] = $userId;
        $this->data['is_banned'] = $loggedUser['banned'];

        $postVarsSet = VariableChecker::postVarsSet(["submit", "article_id", "content", "relevance", "language", "comment"]);
        $canReview = !$loggedUser['banned'] && $loggedUser['id_user_rights'] == UserRolesModel::ROLE_REVIEWER;

        if ($canReview && $postVarsSet) {
            $articleId = $_POST['article_id'];
            $contentScore = $_POST['content'];
            $relevanceScore = $_POST['relevance'];
            $languageScore = $_POST['language'];
            $overallScore = (int)(($contentScore + $relevanceScore + $languageScore) / 3);
            $comment = $_POST['comment'];

            $this->reviewsModel->setReview($userId, $articleId, $contentScore, $relevanceScore, $languageScore, $overallScore, $comment);
        }

        $unfinishedReviews = $this->reviewsModel->getUnfinishedReviews($userId);
        $finishedReviews = $this->reviewsModel->getFinishedReviews($userId);

        for ($i=0; $i < count($unfinishedReviews); $i++) {
            $article = $this->articlesModel->getArticle($unfinishedReviews[$i]['id_article']);
            $authors = $this->articlesModel->getArticlesAuthors($article['id']);
            $article['authors'] = $this->formatAuthorNames($authors);
            $unfinishedReviews[$i]['article'] = $article;
        }

        for ($i=0; $i < count($finishedReviews); $i++) {
            $article = $this->articlesModel->getArticle($finishedReviews[$i]['id_article']);
            $authors = $this->articlesModel->getArticlesAuthors($article['id']);
            $article['authors'] = $this->formatAuthorNames($authors);
            $finishedReviews[$i]['article'] = $article;
        }

        $this->data['unfinished_reviews'] = $unfinishedReviews;
        $this->data['finished_reviews'] = $finishedReviews;
    }

    private function formatAuthorNames($authors) {
        $formattedAuthors = $this->formatAuthorName($authors[0]['full_name']);
        
        if (count($authors) == 1) return $formattedAuthors;

        for ($i=1; $i < count($authors) - 1; $i++) {
            $formattedAuthors .= ", ".$this->formatAuthorName($authors[$i]['full_name']);
        }

        $formattedAuthors .= " a ".$this->formatAuthorName(end($authors)['full_name']);

        return $formattedAuthors;
    }

    private function formatAuthorName($fullName) {
        $separated = explode(" ", $fullName);
        $formatted = "";
        $lastName = array_pop($separated);

        foreach ($separated as $name) {
            $formatted .= $name[0].". ";
        }

        $formatted .= $lastName;
        return $formatted;
    }
}
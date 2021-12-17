<?php
namespace app\controllers;

use app\models\ArticlesModel;
use app\models\ReviewsModel;
use app\models\UsersModel;
use app\utils\Login;

class SpravaClankuController extends Controller {
    private UsersModel $usersModel;
    private ArticlesModel $articlesModel;
    private ReviewsModel $reviewsModel;

    public function __construct() {
        $this->usersModel = new UsersModel();
        $this->articlesModel = new ArticlesModel();
        $this->reviewsModel = new ReviewsModel();

        $this->header['title'] = 'Správa článků';
        $this->header['keywords'] = 'správa, články, příspěvky, konference';
        $this->header['description'] = 'Správa článků';
        $this->view = 'sprava_clanku';

        $this->process_data();
    }

    private function process_data() {
        $userId = Login::getUserID();
        $loggedUser = $this->usersModel->getUserByID($userId);
        $this->data['user_id'] = $userId;
        $this->data['is_banned'] = $loggedUser['banned'];

        if (isset($_POST['accept-article'])) {
            $articleId = $_POST['accept-article'];
            $this->articlesModel->updateArticleStatus($articleId, true);
        } else if (isset($_POST['dismiss-article'])) {
            $articleId = $_POST['dismiss-article'];
            $this->articlesModel->updateArticleStatus($articleId, false);
        } else if (isset($_POST['reevaluate-article'])) {
            $articleId = $_POST['reevaluate-article'];
            $this->articlesModel->updateArticleStatus($articleId);
        }

        $allReviewers = $this->usersModel->getReviewers();

        $undecidedArticles = $this->articlesModel->getUndecidedArticles();
        $decidedArticles = $this->articlesModel->getDecidedArticles();

        for ($i=0; $i < count($undecidedArticles); $i++) {
            $authors = $this->articlesModel->getArticlesAuthors($undecidedArticles[$i]['id']);
            $undecidedArticles[$i]['authors'] = $this->formatAuthorNames($authors);

            $reviews = $this->reviewsModel->getReviews($undecidedArticles[$i]['id']);
            $undecidedArticles[$i]['reviews'] = $reviews;
            $undecidedArticles[$i]['required_reviews'] = $this->requiredReviews($reviews);

            $availableReviewers = $this->reviewsModel->getAvailableReviewers($allReviewers, $undecidedArticles[$i]['id']);
            $undecidedArticles[$i]['available_reviewers'] = $availableReviewers;
        }
        
        for ($i=0; $i < count($decidedArticles); $i++) {
            $authors = $this->articlesModel->getArticlesAuthors($decidedArticles[$i]['id']);
            $decidedArticles[$i]['authors'] = $this->formatAuthorNames($authors);

            $reviews = $this->reviewsModel->getReviews($decidedArticles[$i]['id']);
            $decidedArticles[$i]['reviews'] = $reviews;
        }

        $this->data['undecided_articles'] = $undecidedArticles;
        $this->data['decided_articles'] = $decidedArticles;
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

    private function requiredReviews($reviews) {
        $required = 3;
        
        foreach ($reviews as $review) {
            if ($review['overall_score']) $required--;
            if ($required == 0) return true;
        }
        return false;
    }
}
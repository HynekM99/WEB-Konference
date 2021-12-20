<?php
namespace app\controllers;

use app\models\ArticlesModel;
use app\models\UsersModel;
use app\utils\Login;

class AutorClankyController extends Controller {
    private UsersModel $usersModel;
    private ArticlesModel $articlesModel;

    public function __construct() {
        $this->usersModel = new UsersModel();
        $this->articlesModel = new ArticlesModel();

        $this->header['title'] = 'Vlastní články';
        $this->header['keywords'] = 'články, příspěvky, konference';
        $this->header['description'] = 'Vlastní články';
        $this->view = 'moje_clanky';

        $this->processData();
    }

    private function processData() {
        $userId = Login::getUserID();
        $loggedUser = $this->usersModel->getUserByID($userId);
        $this->data['user_id'] = $userId;
        $this->data['is_banned'] = $loggedUser['banned'];

        $articles = $this->articlesModel->getUserArticles($userId);

        if (!$articles) return;

        for ($i=0; $i < count($articles); $i++) {
            $authors = $this->articlesModel->getArticlesAuthors($articles[$i]['id']);
            $articles[$i]['authors'] = $this->formatAuthorNames($authors);
        }

        $this->data['articles'] = $articles;
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
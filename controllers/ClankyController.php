<?php
namespace app\controllers;

use app\models\ArticlesModel;

class ClankyController extends Controller {
    private ArticlesModel $articlesModel;

    public function __construct() {
        $this->articlesModel = new ArticlesModel();

        $this->header['title'] = 'Články';
        $this->header['keywords'] = 'články, příspěvky, konference';
        $this->header['description'] = 'Publikované články';
        
        $this->view = 'clanky';

        $articles = $this->articlesModel->getPublishedArticles();

        for ($i=0; $i < count($articles); $i++) {
            $authors = $this->articlesModel->getArticlesAuthors($articles[$i]['id']);
            $articles[$i]['authors'] = $this->formatAuthorNames($authors);
        }

        $this->data['articles'] = $articles ;
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
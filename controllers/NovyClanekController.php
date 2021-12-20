<?php
namespace app\controllers;

use app\models\ArticlesModel;
use app\models\UsersModel;
use app\utils\Login;
use app\utils\VariableChecker;

class NovyClanekController extends Controller {
    private UsersModel $usersModel;
    private ArticlesModel $articlesModel;

    public function __construct() {
        $this->usersModel = new UsersModel();
        $this->articlesModel = new ArticlesModel();

        $this->header['title'] = 'Nový článek';
        $this->header['keywords'] = 'nový, přidat, články, příspěvky, konference';
        $this->header['description'] = 'Přidání článku';
        
        $this->view = 'novy_clanek';

        $this->proccessData();
    }

    private function proccessData() {
        $userId = Login::getUserID();
        $loggedUser = $this->usersModel->getUserByID($userId);
        if ($loggedUser['banned']) return;
        
        if (VariableChecker::postVarsSet(['submit', 'title', 'abstract'])) {
            $authors = [$userId];
            if (isset($_POST['extra-authors'])) {
                $authors = $_POST['extra-authors'];
                array_push($authors, $userId);
            }

            $title = $_POST['title'];
            $abstract = $_POST['abstract'];
            $file = $_FILES['pdf_file'];
            
            if ($file['error'] == UPLOAD_ERR_OK && $file['type'] == 'application/pdf') {
                $article_id = $this->articlesModel->insertArticle($authors, $title, $abstract, "to_be_changed.pdf");
                move_uploaded_file($file['tmp_name'], 'files/'.$article_id.".pdf");
                $this->data['success'] = true;
            }
        }

        $authors = $this->usersModel->getOtherAuthors($loggedUser['id']);

        $this->data['authors'] = $authors;
    }
}
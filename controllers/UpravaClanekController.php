<?php
namespace app\controllers;

use app\models\ArticlesModel;
use app\models\UsersModel;
use app\utils\Login;
use app\utils\VariableChecker;

class UpravaClanekController extends Controller {
    private UsersModel $usersModel;
    private ArticlesModel $articlesModel;

    public function __construct() {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) return;

        $this->usersModel = new UsersModel();
        $this->articlesModel = new ArticlesModel();

        $loggedUser = $this->usersModel->getUserByID(Login::getUserID());
        if ($loggedUser['banned']) return;

        $this->header['title'] = 'Úprava článku';
        $this->header['keywords'] = 'upravit, přidat, články, příspěvky, konference';
        $this->header['description'] = 'Upravení článku';
        
        $this->view = 'uprava_clanku';

        $this->proccessData();
    }

    private function proccessData() {
        $article_id = $_GET['id'];
        $article = $this->articlesModel->getArticle($article_id);
        $this->data['article'] = $article;
        if (!$article) return;

        if (VariableChecker::postVarsSet(['submit', 'title', 'abstract'])) {
            $title = $_POST['title'];
            $abstract = $_POST['abstract'];
            $file = $_FILES['pdf_file'];

            if ($file['error'] == UPLOAD_ERR_OK && $file['type'] == 'application/pdf') {
                move_uploaded_file($file['tmp_name'], $article['pdf_path']);
            }

            $this->articlesModel->updateArticle($article['id'], $title, $abstract);
            $this->redirect("moje-clanky");
        }
    }
}
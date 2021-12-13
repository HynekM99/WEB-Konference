<?php
namespace app\controllers;

use app\models\UsersModel;
use app\utils\Login;

class PrispevkyController extends Controller {
    private UsersModel $usersModel;

    public function __construct() {
        $this->usersModel = new UsersModel();

        $this->header['title'] = 'Příspěvky';
        $this->header['keywords'] = 'příspěvky, konference';
        $this->header['description'] = 'Všechny příspěvky';
        $this->view = 'prispevky';   

        $this->data['can_add_article'] = false;
        if (!Login::isLogged()) return;

        $logged_user = $this->usersModel->getUserByID(Login::getUserID());
        $this->data['can_add_article'] = !$logged_user['banned'];
    }
}
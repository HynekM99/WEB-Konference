<?php
namespace app\controllers;

use app\models\UserRolesModel;
use app\models\UsersModel;
use app\utils\Login;

class UzivateleController extends Controller {
    private UsersModel $usersModel;

    public function __construct() {
        $this->usersModel = new UsersModel();

        $this->header['title'] = 'Správa uživatelů';
        $this->header['keywords'] = 'uživatelé, správa, přehled';
        $this->header['description'] = 'Správa uživatelů';
        $this->view = 'uzivatele';

        $this->processData();
    }

    private function processData() {
        $users = $this->usersModel->getUsers();
        $logged_user = $this->usersModel->getUserByID(Login::getUserID());

        $this->data['user_id'] = $logged_user['id'];
        $this->data['users'] = $users;
        $this->data['logged_weight'] = $logged_user['weight'];
        $this->data['is_banned'] = $logged_user['banned'];
        $this->data['is_super'] = $logged_user['id_role'] == UserRolesModel::ROLE_SUPER;
    }
}
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
        $this->data['users'] = $users;
    }
}
<?php
namespace app\controllers;

use app\models\UserRolesModel;
use app\models\UsersModel;
use app\settings\RouterSettings;
use app\utils\Login;

class RouterController extends Controller {
    private UsersModel $usersModel;
    protected Controller $controller;

    public function __construct($parameters) {
        if ($parameters[0] == '/') $this->redirect('uvod');
        $this->usersModel = new UsersModel();

        $page = $this->findPage($parameters[0]);
        $controllerClass = RouterSettings::PAGES[$page][RouterSettings::KEY_CONTROLLER];
        
        $this->controller = new $controllerClass();

        $this->data['title'] = $this->controller->header['title'];
        $this->data['description'] = $this->controller->header['description'];
        $this->data['keywords'] = $this->controller->header['keywords'];

        $this->view = 'layout';

        $this->data['logged_in'] = Login::isLogged();
        
        if (!Login::isLogged()) return;
        
        $logged_user = $this->usersModel->getUserByID(Login::getUserID());
        $this->data['username'] = $logged_user['username'];
        $this->data['user_role'] = $logged_user['role_name'];
        $this->data['is_author'] = $logged_user['id_role'] == UserRolesModel::ROLE_AUTHOR;
        $this->data['is_reviewer'] = $logged_user['id_role'] == UserRolesModel::ROLE_REVIEWER;
        $this->data['is_admin'] = $logged_user['id_role'] == UserRolesModel::ROLE_ADMIN;
        $this->data['is_super'] = $logged_user['id_role'] == UserRolesModel::ROLE_SUPER;
    }

    private function findPage($url) {
        $page = parse_url($url)['path'];
        $page = ltrim($page, "/");
        $page = trim($page);
        
        if (!key_exists($page, RouterSettings::PAGES)) {
            return RouterSettings::KEY_ERROR;
        }

        $page_info = RouterSettings::PAGES[$page];

        if (!$page_info[RouterSettings::KEY_LOGIN_REQUIRED]) {
            if (!$page_info[RouterSettings::KEY_DISABLE_ON_LOGIN]) return $page;
            return Login::isLogged() ? RouterSettings::KEY_ERROR : $page;
        }

        if (!Login::isLogged()) {
            return RouterSettings::KEY_ERROR;
        }

        if (!key_exists(RouterSettings::KEY_RESTRICTED_USERS, $page_info)) {
            return $page;
        }

        if (!in_array($this->usersModel->getUserByID(Login::getUserID())['id_role'], $page_info[RouterSettings::KEY_RESTRICTED_USERS])) {
            return $page;
        }

        return RouterSettings::KEY_ERROR;
    }
}
<?php
namespace app\controllers;

use app\models\UserRolesModel;
use app\utils\Login;

class RouterController extends Controller {

    protected Controller $controller;

    public function __construct($parameters) {
        if ($parameters[0] == '/') $this->redirect('uvod');

        $page = $this->findPage($parameters[0]);
        $controllerClass = RouterSettings::PAGES[$page][RouterSettings::KEY_CONTROLLER];

        $this->controller = new $controllerClass();

        $this->data['title'] = $this->controller->header['title'];
        $this->data['description'] = $this->controller->header['description'];
        $this->data['keywords'] = $this->controller->header['keywords'];

        $this->view = 'layout';

        $this->data['logged_in'] = Login::isLogged();
        $this->data['username'] = Login::getUserName();
        $this->data['user_role'] = Login::getUserRole();
        $this->data['is_super'] = Login::getUserRole() == UserRolesModel::ROLE_SUPER;
        $this->data['is_admin'] = Login::getUserRole() == UserRolesModel::ROLE_ADMIN;
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

        if (!in_array(Login::getUserRole(), $page_info[RouterSettings::KEY_RESTRICTED_USERS])) {
            return $page;
        }

        return RouterSettings::KEY_ERROR;
    }
}
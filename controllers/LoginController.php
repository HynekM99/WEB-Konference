<?php
namespace app\controllers;

use app\models\UsersModel;
use app\utils\Login;
use app\utils\VariableChecker;

class LoginController extends Controller {
    private UsersModel $usersModel;

    public function __construct() {
        $this->usersModel = new UsersModel();

        $this->header['title'] = 'Přihlášení';
        $this->header['keywords'] = 'přihlášení, registrace, jméno, heslo';
        $this->header['description'] = 'Přihlašovací formulář pro uživatele';
        $this->view = 'login';

        $this->process_data();
    }

    private function process_data() {
        if (!VariableChecker::postVarsSet(["submit", "name-or-email", "password"])) return;

        $name_or_email = $_POST["name-or-email"];
        $password = $_POST["password"];

        $user = $this->usersModel->getUserByUsernameOrEmail($name_or_email);

        $this->data['dataValid'] = false;

        if (empty($user) || !password_verify($password, $user['password'])) {
            sleep(5);
            return;
        }

        $this->data['dataValid'] = true;

        Login::login($user['username'], $user['id_user_rights'], $user['weight']);
        $this->redirect("uvod");
    }
}
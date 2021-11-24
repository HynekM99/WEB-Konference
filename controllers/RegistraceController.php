<?php
namespace app\controllers;

use app\models\UsersModel;
use app\utils\Login;
use app\utils\VariableChecker;

class RegistraceController extends Controller {
    private UsersModel $usersModel;

    public function __construct() {
        $this->usersModel = new UsersModel();

        $this->header['title'] = 'Registrace';
        $this->header['keywords'] = 'registrace, přihlášení, uživatel, nový, jméno, heslo, email';
        $this->header['description'] = 'Registrační formulář pro uživatele';
        $this->view = 'registrace';

        $this->processData();
    }

    private function processData() {
        if (!VariableChecker::postVarsSet(["submit", "name", "username", "password", "email"])) return;

        $name = $_POST["name"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        $email = $_POST["email"];

        $this->usersModel->registerUser($name, $username, $password, $email);
    }
}
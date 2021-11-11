<?php
class RegistraceController extends Controller {
    private UsersModel $usersModel;

    public function __construct() {
        $this->usersModel = new UsersModel();

        $this->header['title'] = 'Registrace';
        $this->header['keywords'] = 'přihlášení, registrace, jméno, heslo, email, uživatel, nový';
        $this->header['description'] = 'Registrační formulář pro uživatele';
        $this->view = 'registrace';

        $this->processData();
    }

    private function processData() {
        if (!$this->postVarsSet(["submit", "name", "username", "password", "email"])) return;

        $name = $_POST["name"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        $email = $_POST["email"];

        $this->usersModel->registerUser($name, $username, $password, $email);
    }

    private function postVarsSet($vars = array()) {
        foreach ($vars as $var) {
            if (!isset($_POST[$var])) return false;
        }
        return true;
    }
}
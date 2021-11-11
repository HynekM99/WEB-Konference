<?php
class LoginController extends Controller {
    public function __construct() {
        $this->header['title'] = 'Přihlášení';
        $this->header['keywords'] = 'přihlášení, registrace, jméno, heslo';
        $this->header['description'] = 'Přihlašovací formulář pro uživatele';
        $this->view = 'login';   
    }
}
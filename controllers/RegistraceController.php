<?php
class RegistraceController extends Controller {
    public function __construct() {
        $this->header['title'] = 'Registrace';
        $this->header['keywords'] = 'přihlášení, registrace, jméno, heslo, email, uživatel, nový';
        $this->header['description'] = 'Registrační formulář pro uživatele';
        $this->view = 'registrace';
    }
}
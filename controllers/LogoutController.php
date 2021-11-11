<?php
class LogoutController extends Controller {
    public function __construct() {
        Login::logout();
        $this->redirect('uvod');
    }
}
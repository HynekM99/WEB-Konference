<?php
namespace app\controllers;

use app\utils\Login;

class LogoutController extends Controller {
    public function __construct() {
        Login::logout();
        $this->redirect('uvod');
    }
}
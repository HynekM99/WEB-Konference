<?php
namespace app\controllers;

use app\models\UserRolesModel;
use app\utils\Login;

class UzivateleController extends Controller {

    public function __construct() {
        $this->header['title'] = 'Správa uživatelů';
        $this->header['keywords'] = 'uživatelé, správa, přehled';
        $this->header['description'] = 'Správa uživatelů';
        $this->view = 'uzivatele';

        $this->processData();
    }

    private function processData() {
        
    }
}
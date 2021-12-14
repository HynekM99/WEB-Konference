<?php
namespace app\controllers;

class ClankyController extends Controller {
    public function __construct() {
        $this->header['title'] = 'Články';
        $this->header['keywords'] = 'články, příspěvky, konference';
        $this->header['description'] = 'Publikované články';
        $this->view = 'clanky';
    }
}
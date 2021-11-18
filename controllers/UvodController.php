<?php
namespace app\controllers;

class UvodController extends Controller {
    public function __construct() {
        $this->header['title'] = 'Úvod';
        $this->header['keywords'] = 'úvod, přehled';
        $this->header['description'] = 'Úvod';
        $this->view = 'uvod';   
    }
}
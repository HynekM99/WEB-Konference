<?php
namespace app\controllers;

class ErrorController extends Controller {
    public function __construct() {
        header("HTTP/1.0 404 Not Found");
        $this->header['title'] = 'Error 404';
        $this->view = 'error';
    }
}
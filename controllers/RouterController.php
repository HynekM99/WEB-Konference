<?php
namespace app\controllers;

class RouterController extends Controller {

    private const KEY_ERROR = "error";

    private const PAGE_CONTROLLERS = array(
        self::KEY_ERROR => ErrorController::class,
        "uvod" => UvodController::class,
        "login" => LoginController::class,
        "registrace" => RegistraceController::class
    );

    protected Controller $controller;

    public function __construct($parameters) {
        if ($parameters[0] == '/') $this->redirect('uvod');

        $page = $this->url_to_page($parameters[0]);
        $controllerClass = self::PAGE_CONTROLLERS[$page];

        $this->controller = new $controllerClass();

        $this->data['title'] = $this->controller->header['title'];
        $this->data['description'] = $this->controller->header['description'];
        $this->data['keywords'] = $this->controller->header['keywords'];

        $this->view = 'layout';
    }

    private function url_to_page($url) {
        $page = parse_url($url)['path'];
        $page = ltrim($page, "/");
        $page = trim($page);
        return key_exists($page, self::PAGE_CONTROLLERS) ? $page : self::KEY_ERROR;
    }
}
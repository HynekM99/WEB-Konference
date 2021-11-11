<?php
class RouterController extends Controller {
    protected Controller $controller;

    public function __construct($parameters) {
        if ($parameters[0] == '/') $this->redirect('uvod');

        $controller_class = $this->url_to_controller_class($parameters[0]).'Controller';
        
        $this->controller = file_exists('controllers/'.$controller_class.'.php') ? new $controller_class : new ErrorController;

        $this->data['title'] = $this->controller->header['title'];
        $this->data['description'] = $this->controller->header['description'];
        $this->data['keywords'] = $this->controller->header['keywords'];

        $this->view = 'layout';
    }

    private function url_to_controller_class($url) {
        $controller_class = parse_url($url)['path'];
        $controller_class = ltrim($controller_class, "/");
        $controller_class = trim($controller_class);
        $controller_class = $this->to_camelcase($controller_class);
        return $controller_class;
    }

    private function to_camelcase($text) {
        $camelcase = str_replace('/', ' ', $text);
        $camelcase = str_replace('-', ' ', $camelcase);
        $camelcase = ucwords($camelcase);
        $camelcase = str_replace(' ', '', $camelcase);
        return $camelcase;
    }
}
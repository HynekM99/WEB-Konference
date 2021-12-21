<?php
namespace app\controllers;

abstract class Controller 
{
    protected $data = array();
    protected $view = 'error';
    protected $header = array('title' => '', 'keywords' => '', 'description' => '');

    public function return_view() {
        extract($this->xss_fix($this->data));
        require("views/".$this->view.".php");
    }

    public function redirect($url) {
        header("Location: /$url");
        header("Connection: close");
        exit;
    }

    public function xss_fix($x = null)
    {
        if (!isset($x)) return null;
        if (is_string($x)) return htmlspecialchars($x, ENT_QUOTES);
        if (is_array($x)) foreach($x as $k => $v) $x[$k] = $this->xss_fix($v);

        return $x;
    }
}
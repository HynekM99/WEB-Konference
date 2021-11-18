<?php
namespace app\controllers;

abstract class Controller 
{
    protected $data = array();
    protected $view = 'error';
    protected $header = array('title' => '', 'keywords' => '', 'description' => '');
    protected $editable = false;

    public function return_view() {
        $this->data['editor_mode'] = $this->editable;
            
        extract($this->xss_fix($this->data));
        require("views/".$this->view.".phtml");
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
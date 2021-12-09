<?php
namespace app\utils;

class VariableChecker {
    public static function getVarsSet($vars = array()) {
        foreach ($vars as $var) {
            if (!isset($_GET[$var])) return false;
        }
        return true;
    }

    public static function postVarsSet($vars = array()) {
        foreach ($vars as $var) {
            if (!isset($_POST[$var])) return false;
        }
        return true;
    }

    public static function requestVarsSet($vars = array()) {
        foreach ($vars as $var) {
            if (!isset($_REQUEST[$var])) return false;
        }
        return true;
    }
}
<?php
class MySession {

    public function __construct() {
        session_start();
    }

    public function setSession(string $key, $value) {
        $_SESSION[$key] = $value;
    }

    public function isSession(string $key): bool {
        return isset($_SESSION[$key]);
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public function readSession(string $key) {
        if (!$this->isSession($key)) return null;
        return $_SESSION[$key];
    }

    public function removeSession(string $key) {
        unset($_SESSION[$key]);
    }

    public function removeAllSession() {
        session_unset();
    }
}
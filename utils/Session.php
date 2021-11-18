<?php
namespace app\utils;

session_start();

class Session {

    public static function setSession(string $key, $value) {
        $_SESSION[$key] = $value;
    }

    public static function isSession(string $key): bool {
        return isset($_SESSION[$key]);
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public static function readSession(string $key) {
        if (!self::isSession($key)) return null;
        return $_SESSION[$key];
    }

    public static function removeSession(string $key) {
        unset($_SESSION[$key]);
    }

    public function removeAllSession() {
        session_unset();
    }
}
<?php
namespace app\utils;

class Login {
    private const SESSION_KEY = "user";
    private const KEY_NAME = "name";

    public static function login(string $name) {
        $info = [self::KEY_NAME => $name];
        Session::setSession(self::SESSION_KEY, $info);
    }

    public static function isLogged(): bool {
        return Session::isSession(self::SESSION_KEY);
    }

    public static function logout() {
        Session::removeSession(self::SESSION_KEY);
    }

    public static function getUserInfo() {
        $info = Session::readSession(self::SESSION_KEY);
        return $info[self::KEY_NAME];
    }
}
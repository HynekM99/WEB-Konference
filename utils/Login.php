<?php
namespace app\utils;

class Login {
    private const SESSION_KEY = "user";
    private const KEY_NAME = "name";
    private const KEY_ROLE = "role";

    public static function login(string $name, string $role) {
        $info = [self::KEY_NAME => $name, self::KEY_ROLE => $role];
        Session::setSession(self::SESSION_KEY, $info);
    }

    public static function isLogged(): bool {
        return Session::isSession(self::SESSION_KEY);
    }

    public static function logout() {
        Session::removeSession(self::SESSION_KEY);
    }

    public static function getUserRole() {
        $info = Session::readSession(self::SESSION_KEY);
        return $info[self::KEY_ROLE];
    }

    public static function getUserName() {
        $info = Session::readSession(self::SESSION_KEY);
        return $info[self::KEY_NAME];
    }
}
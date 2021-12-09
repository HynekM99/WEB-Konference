<?php
namespace app\utils;

class Login {
    private const SESSION_KEY = "user";
    private const KEY_NAME = "name";
    private const KEY_ROLE = "role";
    private const KEY_WEIGHT = "weight";

    public static function login(string $name, int $role, int $weight) {
        $info = [
            self::KEY_NAME => $name,
            self::KEY_ROLE => $role,
            self::KEY_WEIGHT => $weight
        ];
        Session::setSession(self::SESSION_KEY, $info);
    }

    public static function isLogged(): bool {
        return Session::isSession(self::SESSION_KEY);
    }

    public static function logout() {
        Session::removeSession(self::SESSION_KEY);
    }

    public static function getUserWeight() {
        $info = Session::readSession(self::SESSION_KEY);
        return $info[self::KEY_WEIGHT];
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
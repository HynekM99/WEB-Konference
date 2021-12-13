<?php
namespace app\utils;

class Login {
    private const SESSION_KEY = "user";
    private const KEY_ID = "id";

    public static function login(int $id) {
        $info = [
            self::KEY_ID => $id
        ];
        Session::setSession(self::SESSION_KEY, $info);
    }

    public static function isLogged(): bool {
        return Session::isSession(self::SESSION_KEY);
    }

    public static function logout() {
        Session::removeSession(self::SESSION_KEY);
    }

    public static function getUserID() {
        $info = Session::readSession(self::SESSION_KEY);
        return $info[self::KEY_ID];
    }
}
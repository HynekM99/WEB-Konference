<?php
namespace app\utils;

class Login {
    private const SESSION_KEY = "user";
    private const KEY_NAME = "name";
    private const KEY_DATE = "date";

    public static function login(string $name) {
        $info = [self::KEY_NAME => $name, self::KEY_DATE => date("d. m. Y G:i:s")];
        Session::setSession(self::SESSION_KEY, $info);
    }

    public static function isLogged(): bool {
        return Session::isSession(self::SESSION_KEY);
    }

    public static function logout() {
        Session::removeSession(self::SESSION_KEY);
    }

    public function getUserInfo() {
        $info = $this->session->readSession(self::SESSION_KEY);
        return "
            Jméno: ".$info[self::KEY_NAME]." <br>
            Datum: ".$info[self::KEY_DATE]." <br>
        ";
    }
}
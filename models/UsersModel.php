<?php
namespace app\models;

use app\utils\Db;

class UsersModel {
    public function getUser(string $username_or_email) {
        return Db::requestRow("
            SELECT * FROM users
            WHERE
            username = ?
            OR email = ?
        ", array($username_or_email, $username_or_email));
    }

    public function registerUser(string $name, string $username, string $password, string $email) {
        return Db::request("
            INSERT INTO users
            (full_name, username, password, email)
            VALUES (?,?,?,?)
        ", array($name, $username, password_hash($password, PASSWORD_BCRYPT), $email));
    }
}
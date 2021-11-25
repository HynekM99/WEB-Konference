<?php
namespace app\models;

use app\utils\Db;

class UsersModel {
    public function getUser(string $username_or_email) {
        return Db::requestRow("
            SELECT users.*, user_rights.name FROM users
            INNER JOIN user_rights ON users.id_user_rights = user_rights.id
            WHERE
            users.username = ?
            OR users.email = ?
        ", array($username_or_email, $username_or_email));
    }

    public function getUsers() {
        return Db::requestAll("
            SELECT users.*, user_rights.name FROM users
            INNER JOIN user_rights ON users.id_user_rights = user_rights.id
        ");
    }

    public function registerUser(string $name, string $username, string $password, string $email) {
        return Db::request("
            INSERT INTO users
            (full_name, username, password, email)
            VALUES (?,?,?,?)
        ", array($name, $username, password_hash($password, PASSWORD_BCRYPT), $email));
    }
}
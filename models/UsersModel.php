<?php
namespace app\models;

use app\utils\Db;

class UsersModel {
    public function getUserByUsernameOrEmail(string $username_or_email) {
        return Db::requestRow("
            SELECT users.*, user_rights.id AS id_role, user_rights.name AS role_name, user_rights.weight FROM users
            INNER JOIN user_rights ON users.id_user_rights = user_rights.id
            WHERE
            users.username = ?
            OR users.email = ?
        ", array($username_or_email, $username_or_email));
    }

    public function getUserByID(int $id) {
        return Db::requestRow("
            SELECT users.*, user_rights.id AS id_role, user_rights.name AS role_name, user_rights.weight FROM users
            INNER JOIN user_rights ON users.id_user_rights = user_rights.id
            WHERE users.id = ?
        ", array($id));
    }

    public function getUserBanned(int $id): bool {
        return Db::requestValue("
            SELECT banned FROM users
            WHERE id = ?
        ", "banned", array($id));
    }

    public function getUserRole(int $id) {
        return Db::requestValue("
            SELECT role FROM users
            WHERE id = ?
        ", "role", array($id));
    }

    public function getUsers() {
        return Db::requestAll("
            SELECT users.*, user_rights.name, user_rights.weight FROM users
            INNER JOIN user_rights ON users.id_user_rights = user_rights.id
        ");
    }

    public function getAuthors() {
        return Db::requestAll("
            SELECT * FROM users
            WHERE users.id_user_rights = ?
        ", array(UserRolesModel::ROLE_AUTHOR));
    }

    public function getOtherAuthors($loggedAuthorId) {
        return Db::requestAll("
            SELECT * FROM users
            WHERE users.id_user_rights = ?
            AND users.id <> ?
        ", array(UserRolesModel::ROLE_AUTHOR, $loggedAuthorId));
    }

    public function getReviewers() {
        return Db::requestAll("
            SELECT * FROM users
            WHERE users.id_user_rights = ?
        ", array(UserRolesModel::ROLE_REVIEWER));
    }

    public function registerUser(string $name, string $username, string $password, string $email) {
        return Db::request("
            INSERT INTO users
            (full_name, username, password, email)
            VALUES (?,?,?,?)
        ", array($name, $username, password_hash($password, PASSWORD_BCRYPT), $email));
    }

    public function changeUserRole(int $user_id, int $new_rights) {
        Db::request("
            UPDATE users
            SET id_user_rights = ?
            WHERE id = ?
        ", array($new_rights, $user_id));
    }

    public function toggleUserBan(int $user_id) {
        $currently_banned = $this->getUserBanned($user_id);

        Db::request("
            UPDATE users
            SET banned = ?
            WHERE id = ?
        ", array(!$currently_banned, $user_id));
    }
}
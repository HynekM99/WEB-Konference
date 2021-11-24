<?php
namespace app\models;

use app\utils\Db;

class UserRolesModel {
    public const ROLE_AUTHOR = 4;
    public const ROLE_REVIEWER = 3;
    public const ROLE_ADMIN = 2;
    public const ROLE_SUPER = 1;
}
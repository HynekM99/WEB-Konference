<?php
namespace app\settings;

use app\controllers\AutorClankyController;
use app\controllers\ClankyController;
use app\controllers\ErrorController;
use app\controllers\LoginController;
use app\controllers\LogoutController;
use app\controllers\NovyClanekController;
use app\controllers\RecenzentClankyController;
use app\controllers\RegistraceController;
use app\controllers\SpravaClankuController;
use app\controllers\UpravaClanekController;
use app\controllers\UvodController;
use app\controllers\UzivateleController;
use app\models\UserRolesModel;

class RouterSettings {
    public const KEY_ERROR = "error";
    public const KEY_CONTROLLER = "controller";
    public const KEY_LOGIN_REQUIRED = "login";
    public const KEY_DISABLE_ON_LOGIN = "login-disable";
    public const KEY_RESTRICTED_USERS = "users";
    
    public const PAGES = array(
        self::KEY_ERROR => array(
            self::KEY_CONTROLLER => ErrorController::class,
            self::KEY_LOGIN_REQUIRED => false,
            self::KEY_DISABLE_ON_LOGIN => false
        ),
        "uvod" => array(
            self::KEY_CONTROLLER => UvodController::class,
            self::KEY_LOGIN_REQUIRED => false,
            self::KEY_DISABLE_ON_LOGIN => false
        ),
        "login" => array(
            self::KEY_CONTROLLER => LoginController::class,
            self::KEY_LOGIN_REQUIRED => false,
            self::KEY_DISABLE_ON_LOGIN => true
        ),
        "logout" => array(
            self::KEY_CONTROLLER => LogoutController::class,
            self::KEY_LOGIN_REQUIRED => true
        ),
        "registrace" => array(
            self::KEY_CONTROLLER => RegistraceController::class,
            self::KEY_LOGIN_REQUIRED => false,
            self::KEY_DISABLE_ON_LOGIN => true
        ),
        "uzivatele" => array(
            self::KEY_CONTROLLER => UzivateleController::class,
            self::KEY_LOGIN_REQUIRED => true,
            self::KEY_RESTRICTED_USERS => [UserRolesModel::ROLE_AUTHOR, UserRolesModel::ROLE_REVIEWER]
        ),
        "clanky" => array(
            self::KEY_CONTROLLER => ClankyController::class,
            self::KEY_LOGIN_REQUIRED => false,
            self::KEY_DISABLE_ON_LOGIN => false
        ),
        "moje-clanky" => array(
            self::KEY_CONTROLLER => AutorClankyController::class,
            self::KEY_LOGIN_REQUIRED => true,
            self::KEY_RESTRICTED_USERS => [UserRolesModel::ROLE_REVIEWER, UserRolesModel::ROLE_ADMIN, UserRolesModel::ROLE_SUPER]
        ),
        "moje-clanky/pridat" => array(
            self::KEY_CONTROLLER => NovyClanekController::class,
            self::KEY_LOGIN_REQUIRED => true,
            self::KEY_RESTRICTED_USERS => [UserRolesModel::ROLE_REVIEWER, UserRolesModel::ROLE_ADMIN, UserRolesModel::ROLE_SUPER]
        ),
        "moje-clanky/upravit" => array(
            self::KEY_CONTROLLER => UpravaClanekController::class,
            self::KEY_LOGIN_REQUIRED => true,
            self::KEY_RESTRICTED_USERS => [UserRolesModel::ROLE_REVIEWER, UserRolesModel::ROLE_ADMIN, UserRolesModel::ROLE_SUPER]
        ),
        "moje-recenze" => array(
            self::KEY_CONTROLLER => RecenzentClankyController::class,
            self::KEY_LOGIN_REQUIRED => true,
            self::KEY_RESTRICTED_USERS => [UserRolesModel::ROLE_AUTHOR, UserRolesModel::ROLE_ADMIN, UserRolesModel::ROLE_SUPER]
        ),
        "sprava-clanku" => array(
            self::KEY_CONTROLLER => SpravaClankuController::class,
            self::KEY_LOGIN_REQUIRED => true,
            self::KEY_RESTRICTED_USERS => [UserRolesModel::ROLE_AUTHOR, UserRolesModel::ROLE_REVIEWER]
        )
    );
}
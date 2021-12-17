<?php
namespace app\utils;

use \PDO;

class Db {
    private static $connection;

    private static $settings = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_EMULATE_PREPARES => false
    );

    public static function connect($host, $uzivatel, $heslo, $databaze) {
        if (!isset(self::$connection)) {
            self::$connection = new PDO(
                "mysql:host=$host;dbname=$databaze",
                $uzivatel,
                $heslo,
                self::$settings
            );
        }
    }

    public static function requestRow($request, $parameters = array()) {
        $data = self::$connection->prepare($request);
        $data->execute($parameters);
        return $data->fetch(PDO::FETCH_ASSOC);
    }

    public static function requestAll($request, $parameters = array()) {
        $data = self::$connection->prepare($request);
        $data->execute($parameters);
        return $data->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public static function requestValue($request, $key, $parameters = array()) {
        $data = self::requestRow($request, $parameters);
        return $data[$key];
    }

    public static function requestLastInsertId() {
        $data = self::$connection->prepare("SELECT LAST_INSERT_ID();");
        $data->execute();
        return $data->fetch()[0];
    }

    public static function request($request, $parameters = array()) {
        $data = self::$connection->prepare($request);
        $data->execute($parameters);
        return $data->rowCount();
    }
}
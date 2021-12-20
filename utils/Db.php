<?php
namespace app\utils;

use \PDO;

class Db {
    public const DB_IP_ADDRESS = "127.0.0.1";
    public const DB_USER = "root";
    public const DB_PASSWORD = "";
    public const DB_NAME = "db_conference";

    private static $connection;

    private static $settings = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    );

    public static function connect(
        $host = self::DB_IP_ADDRESS, 
        $user = self::DB_USER, 
        $password = self::DB_PASSWORD, 
        $database = self::DB_NAME
        ) {
        self::$connection = new PDO(
            "mysql:host=$host;dbname=$database",
            $user,
            $password,
            self::$settings
        );
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
<?php

abstract class MySQLConnection
{
    private static $conInstance = null;

    public static function getInstance() {
        if (self::$conInstance == null) {
            self::$conInstance = new PDO("mysql:host=mysql;dbname=magazordapi;", "root", "1234");
        }

        return self::$conInstance;
    }
}
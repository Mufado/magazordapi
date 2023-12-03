<?php

final class MySQLConnection
{
    private static $conInstance = null;

    public static function getInstance() {
        if (self::$conInstance == null) {
            self::$conInstance = new PDO("mysql:host=mysql;dbname=magazordapi;", "root", "1234");
        }

        return self::$conInstance;
    }

    public static function executeSQL($sql, $objType)
    {
        $con = MySQLConnection::getInstance();

        $sql = $con->prepare($sql);
        $sql->execute();

        $results = array();

        while ($row = $sql->fetchObject($objType)) {
            $results[] = $row;
        }

        return $results;
    }
}
<?php

/**
 * Singleton database connection class.
 * 
 * Creates only, and only one, instance of database connection.
 * Other classes and funcions can use this connection freely to make changes in the database.
 */
final class MySQLConnection
{
    private static $instance = null;
    # Enables Singleton Pattern
    private function __construct() {}
    private function __clone() {}


    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new PDO("mysql:host=mysql;dbname=magazordapi;", "root", "1234");
        }

        return self::$instance;
    }

    /**
     * Utility function to execute and SQL using the Singleton connection Instance.
     * 
     * @param string $sql SQL query to execute
     * @param string $objType Model type to return based on results
     * 
     * @return array SQL data returned by connection
     */
    public static function executeSQL($sql, $objType)
    {
        $con = self::getInstance();

        $sql = $con->prepare($sql);
        $sql->execute();

        $results = array();

        while ($row = $sql->fetchObject($objType)) {
            $results[] = $row;
        }

        return $results;
    }
}
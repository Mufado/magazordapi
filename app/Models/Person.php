<?php

final class Person
{
    public int $id;
    public string $name;
    public string $cpf;

    public static function selectAll(): array {
        $sql = "SELECT * FROM person";

        return MySQLConnection::executeSQL($sql, "Person");
    }

    public static function createPerson($properties) {
        $sql = "INSERT INTO `person`(`name`, `cpf`) VALUES ('".$properties['name']."', '".$properties['cpf']."')";

        return MySQLConnection::executeSQL($sql);
    }

    public static function deletePerson($properties) {
        $sql = "DELETE FROM `person` WHERE id = ".$properties['id']."";
        
        return MySQLConnection::executeSQL($sql);
    }
}
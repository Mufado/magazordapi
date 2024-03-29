<?php

final class Person
{
    public int $id;
    public string $name;
    public string $cpf;

    public static function selectById($id): array
    {
        $sql = "SELECT * FROM person WHERE id = :id";
        
        return MySQLConnection::executeSQL($sql, "Person", array(':id' => $id));
    }

    public static function selectAll(): array {
        $sql = "SELECT * FROM person";

        return MySQLConnection::executeSQL($sql, "Person");
    }

    public static function createPerson($properties) {
        $sql = "INSERT INTO `person`(`name`, `cpf`) VALUES (:name, :cpf)";

        $binds = array(
            ":name" => $properties['name'],
            ":cpf" => $properties['cpf']
        );

        return MySQLConnection::executeSQL($sql, null, $binds);
    }

    public static function editPerson($properties) {
        $sql = "UPDATE `person` SET `name` = :name,`cpf` = :cpf WHERE id = :id";

        $binds = array(
            ":id" => $properties['id'],
            ":name" => $properties['name'],
            ":cpf" => $properties['cpf'],
        );
        
        return MySQLConnection::executeSQL($sql, null, $binds);
    }

    public static function deletePerson($properties) {
        $sql = "DELETE FROM `person` WHERE id = :id";

        $binds = array(
            ":id" => $properties['id']
        );
        
        return MySQLConnection::executeSQL($sql, null, $binds);
    }
}
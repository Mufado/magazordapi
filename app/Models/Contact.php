<?php

final class Contact
{
    public int $id;
    public int $idPerson;
    public bool $type;
    public string $description;

    public static function selectById($id): array
    {
        $sql = "SELECT * FROM contact WHERE id = :id";
        
        return MySQLConnection::executeSQL($sql, "Contact", array(':id' => $id));
    }

    public static function selectBySearchText(string $txt): array {
        $sql = "SELECT * FROM contact WHERE description LIKE :txt";

        return MySQLConnection::executeSQL($sql, "Contact", array(":txt" => "%$txt%"));
    }

    public static function selectAll(): array
    {
        $sql = "SELECT * FROM contact";
        
        return MySQLConnection::executeSQL($sql, "Contact");
    }

    public static function createContact($properties) {
        $sql = "INSERT INTO `contact`(`type`, `description`, `idPerson`) VALUES (:type, :description, :idPerson)";
        
        $binds = array(
            ":type" => $properties['type'],
            ":description" => $properties['description'],
            ":idPerson" => $properties['idPerson']
        );

        return MySQLConnection::executeSQL($sql, "Contact", $binds);
    }

    # The contact will not be able to be transfer from one person to another.
    public static function editContact($properties) {
        $sql = "UPDATE `contact` SET `type` = :type,`description` = :description WHERE id = :id";

        $binds = array(
            ":id" => $properties['id'],
            ":type" => $properties['type'],
            ":description" => $properties['description'],
        );
        
        return MySQLConnection::executeSQL($sql, null, $binds);
    }

    public static function deleteContact($properties) {
        $sql = "DELETE FROM `contact` WHERE id = :id";
        
        return MySQLConnection::executeSQL($sql, null, array('id' => $properties['id']));
    }
}
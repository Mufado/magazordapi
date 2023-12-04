<?php

final class Contact
{
    public int $id;
    public int $idPerson;
    public bool $type;
    public string $description;

    public static function selectAll(): array
    {
        $sql = "SELECT * FROM contact";
        
        return MySQLConnection::executeSQL($sql, "Contact");
    }

    public static function createContact($properties) {
        $sql = "INSERT INTO `contact`(`type`, `description`, `idPerson`) VALUES ('".$properties['type']."','".$properties['description']."','".$properties['idPerson']."')";
        
        return MySQLConnection::executeSQL($sql, "Contact");
    }

    public static function deleteContact($properties) {
        $sql = "DELETE FROM `contact` WHERE id = :id";
        
        return MySQLConnection::executeSQL($sql, null, ['id' => $properties['id']]);
    }
}
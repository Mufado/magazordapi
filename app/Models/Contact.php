<?php

class Contact
{
    private int $id;
    private int $idPerson;
    public bool $type;
    public string $description;

    public static function selectAll(): array
    {
        $con = MySQLConnection::getInstance();
        $sql = "SELECT * FROM contact";
        $sql = $con->prepare($sql);
        $sql->execute();

        $results = array();

        while ($row = $sql->fetchObject("Contact")) {
            $results[] = $row;
        }
        
        return $results;
    }
}
<?php

class Person
{
    private int $id;
    public string $name;
    public string $cpf;

    public static function selectAll() 
    {
        $con = MySQLConnection::getInstance();
        $sql = "SELECT * FROM person";
        $sql = $con->prepare($sql);
        $sql->execute();

        $results = array();

        while ($row = $sql->fetchObject("Person")) {
            $results[] = $row;
        }
        
        return $results;
    }
}
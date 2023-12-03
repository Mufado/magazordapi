<?php

class Person
{
    private int $id;
    public string $name;
    public string $cpf;

    public static function selectAll(): array
    {
        $sql = "SELECT * FROM person";
        
        return Utils::executeSQL($sql, "Person");
    }
}
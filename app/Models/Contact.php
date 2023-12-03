<?php

class Contact
{
    private int $id;
    private int $idPerson;
    public bool $type;
    public string $description;

    public static function selectAll(): array
    {
        $sql = "SELECT * FROM contact";
        
        return Utils::executeSQL($sql, "Contact");
    }
}
<?php

class SearchPeopleController
{
    public static function index()
    {
        echo file_get_contents("../Views/SearchPeople/index.html");
    }
}

<?php

class SearchContactsController
{
    function index()
    {
        echo file_get_contents("../Views/SearchContacts/index.html");
    }
}

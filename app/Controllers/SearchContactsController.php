<?php

class SearchContactsController
{
    function index()
    {
        $contacts = Contact::selectAll();

        $loader = new \Twig\Loader\FilesystemLoader("./Views/SearchContacts");
        $twig = new \Twig\Environment($loader);
        
        $params["contacts"] = $contacts;
        
        echo $twig->load("index.html")->render($params);
    }
}

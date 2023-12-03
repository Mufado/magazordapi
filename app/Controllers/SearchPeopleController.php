<?php

class SearchPeopleController
{
    function index()
    {
        $people = Person::selectAll();

        $loader = new \Twig\Loader\FilesystemLoader("./Views/SearchPeople");
        $twig = new \Twig\Environment($loader);
        
        $params["people"] = $people;
        
        echo $twig->load("index.html")->render($params);
    }
}

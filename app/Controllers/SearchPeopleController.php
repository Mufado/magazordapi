<?php

final class SearchPeopleController
{
    function index()
    {
        $people = Person::selectAll();

        Utils::renderTwigTemplate("./Views/SearchPeople", "index.html", array("people" => $people));
    }
}

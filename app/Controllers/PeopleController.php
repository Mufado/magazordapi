<?php

final class PeopleController
{
    function index()
    {
        $people = Person::selectAll();

        Utils::renderTwigTemplate("./Views/People", "index.html", array("people" => $people));
    }
}

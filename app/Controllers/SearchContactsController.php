<?php

final class SearchContactsController
{
    function index()
    {
        $contacts = Contact::selectAll();

        Utils::renderTwigTemplate("./Views/SearchContacts", "index.html", array("contacts" => $contacts));
    }
}

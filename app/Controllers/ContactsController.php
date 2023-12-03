<?php

final class ContactsController
{
    function index()
    {
        $contacts = Contact::selectAll();

        Utils::renderTwigTemplate("./Views/Contacts", "index.html", array("contacts" => $contacts));
    }
}

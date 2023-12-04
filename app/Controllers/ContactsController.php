<?php

final class ContactsController
{
    private $viewSrc = "./Views/Contacts";

    # GET
    function index()
    {
        $contacts = Contact::selectAll();

        Renderer::renderPage($this->viewSrc, "index", array("contacts" => $contacts));
    }
}

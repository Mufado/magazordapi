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

    function goToCreateContactPage() {
        Renderer::renderPage($this->viewSrc, "create-contact", array());
    }

    function goToEditContactPage() {
        Renderer::renderPage($this->viewSrc, "edit-contact", array());
    }

    function createContact() {
        $data = json_decode(file_get_contents('php://input'), true);

        Contact::createContact($data);
        echo "Success";
    }

    function deleteContact() {
        $data = json_decode(file_get_contents('php://input'), true);
        
        Contact::deleteContact($data);
        echo "Success";
    }
}

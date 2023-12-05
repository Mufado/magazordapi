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
        $people = Person::selectAll();

        Renderer::renderPage($this->viewSrc, "create-contact", array("people" => $people));
    }

    function goToEditContactPage() {
        try {
            $contact = Contact::selectById($_GET['id'])[0];

            Renderer::renderPage($this->viewSrc, "edit-contact", array("contact" => $contact));
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }


    function createContact() {
        $data = json_decode(file_get_contents('php://input'), true);

        Contact::createContact($data);
    }

    function searchContacts() {
        $data = urldecode($_GET['txt']);

        $contacts = Contact::selectBySearchText($data);

        Renderer::renderPage($this->viewSrc,'index', array("contacts" => $contacts));
    }

    function editContact() {
        try {
            $jsonData = json_decode(file_get_contents('php://input'), true);
            
            Contact::editContact($jsonData);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    function deleteContact() {
        $data = json_decode(file_get_contents('php://input'), true);
        
        Contact::deleteContact($data);
    }
}

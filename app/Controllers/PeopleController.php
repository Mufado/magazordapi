<?php

class PeopleController
{
    private $viewSrc = "./Views/People";

    # GET
    function index() {
        $people = Person::selectAll();

        Renderer::renderPage($this->viewSrc, "index", array("people" => $people));
    }

    # GET
    function goToCreatePersonPage() {
        Renderer::renderPage($this->viewSrc, "create-person", array());
    }

    function createPerson() {
        $data = json_decode(file_get_contents('php://input'), true);

        Person::createPerson($data);
        echo "Success";
    }

    function deletePerson() {
        $data = json_decode(file_get_contents('php://input'), true);

        Person::deletePerson($data);
        echo "Success";
    }
}

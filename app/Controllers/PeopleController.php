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

    function goToEditPersonPage() {
        try {
            $person = Person::selectById($_GET['id'])[0];

            Renderer::renderPage($this->viewSrc, "edit-person", array("person" => $person));
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    function createPerson() {
        $data = json_decode(file_get_contents('php://input'), true);

        Person::createPerson($data);
        echo "Success";
    }

    function editPerson() {
        $data = json_decode(file_get_contents("php://input"), true);

        Person::editPerson($data);
    }

    function deletePerson() {
        $data = json_decode(file_get_contents('php://input'), true);

        Person::deletePerson($data);
        echo "Success";
    }
}

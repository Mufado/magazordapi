<?php

final class PeopleController
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

    function create() {
        $data = json_decode(file_get_contents("php://input"), true);
        var_dump($data);
        var_dump($_POST);
    }
}

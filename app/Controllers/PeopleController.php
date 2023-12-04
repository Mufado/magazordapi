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
        
        echo $data;
        
        $resposta = array('status' => 'success', 'mensagem' => 'Dados recebidos com sucesso.');
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($resposta);
    }
}

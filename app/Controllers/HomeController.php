<?php

class HomeController
{
    function index()
    {
        $persons = Person::selectAll();

        $loader = new \Twig\Loader\FilesystemLoader("./Views/Home");
        $twig = new \Twig\Environment($loader);
        
        $template = $twig->load("index.html");
        
        $params = array();
        $params['name'] = "Eu";

        $content = $template->render($params);
        echo $content;
    }

    function response($data)
    {
        header("Content-Type:application/json");
        echo json_encode($data);
    }
}

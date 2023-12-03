<?php

class HomeController
{
    function index()
    {
        $persons = Person::selectAll();

        $loader = new \Twig\Loader\FilesystemLoader("./Views/Home");
        $twig = new \Twig\Environment($loader);
        
        $template = $twig->load("index.html");

        

        $content = $template->render();
        echo $content;
    }

    function response($data)
    {
        header("Content-Type:application/json");
        echo json_encode($data);
    }
}

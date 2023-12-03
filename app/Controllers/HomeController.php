<?php

final class HomeController
{
    function index()
    {
        Utils::renderTwigTemplate("./Views/Home", "index.html");
    }

    function response($data)
    {
        header("Content-Type:application/json");
        echo json_encode($data);
    }
}

<?php

final class HomeController
{
    private $viewSrc = "./Views/Home";
    
    # GET
    function index()
    {
        Renderer::renderPage($this->viewSrc, "index");
    }
}

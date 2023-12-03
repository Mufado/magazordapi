<?php

class Router
{
    function route() {
        $controller = "HomeController";

        if(isset($_GET['page'])) {
            $controller = ucfirst($_GET['page'])."Controller";
        }

        if (!class_exists($controller)) {
            $controller = "HomeController";
        }

        call_user_func(array(new $controller, "index"));
    }
}
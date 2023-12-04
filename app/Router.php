<?php

/**
 * Router API (GET).
 *
 * Get the requests and routes to the correct method in some controller.
 * Works as a Front Controller.
 *
 * Recognizable GET elements:
 * - `page`: Receives the controller to instance.
 * - `cd`: Receives the callback function which will be called .
 */
class Router
{
    public function route() {
        $controller = $this->getControllerName();

        $callback = $this->getCallbackName($controller);

        call_user_func(array(new $controller, $callback));
    }

    private function getControllerName() {
        $controller = "HomeController";

        if(isset($_GET['page'])) {
            $controller = ucfirst($_GET['page'])."Controller";
        }

        if (!class_exists($controller)) {
            $controller = "HomeController";
        }

        return $controller;
    }

    private function getCallbackName($controllerName) {
        $callback = "index";

        if(isset($_GET['cb']) && method_exists($controllerName, $_GET['cb'])) {
            $callback = $_GET['cb'];
        }

        return $callback;
    }
}
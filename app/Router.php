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
 * 
 * POST request structure:
 * - `controller/method`: This can be found in the personalized header called `X-Action`.
 */
class Router
{
    public function route() {
        switch ($_SERVER['REQUEST_METHOD']) {
            case "GET":
                $this->processGet();
                break;
            case "POST":
                $this->processPost();
                break;
            default:
                break;
        }
    }

    private function processGet() {
        $controller = "HomeController";

        if(isset($_GET['page'])) {
            $controller = ucfirst($_GET['page'])."Controller";
        }

        if (!class_exists($controller)) {
            $controller = "HomeController";
        }

        $callback = "index";

        if(isset($_GET['cb']) && method_exists($controller, $_GET['cb'])) {
            $callback = $_GET['cb'];
        }

        call_user_func(array(new $controller, $callback));
    }

    private function processPost() {
        $uri = $_SERVER['HTTP_X_ACTION'];

        $parts = explode('/', trim($uri, '/'));

        $controller = array_shift($parts)."Controller";

        $callback = array_shift($parts) ?: 'index';

        if (!class_exists($controller) || !method_exists($controller, $callback)) {
            $controller = "HomeController";
            $callback = "index";
        }

        call_user_func(array(new $controller, $callback));
    }
}

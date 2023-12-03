<?php
require_once "vendor/autoload.php";

require_once "Router.php";
require_once "MySQLConnection.php";
require_once "Utils.php";

require_once "Models/Person.php";
require_once "Models/Contact.php";

require_once "Controllers/HomeController.php";
require_once "Controllers/PeopleController.php";
require_once "Controllers/ContactsController.php";

$layout = file_get_contents("Views/layout.html");

ob_start();
    $router = new Router;
    $router->route();

    $output = ob_get_contents();
ob_end_clean();

echo str_replace("{{{ dynamic }}}", $output, $layout);

<?php
require_once "vendor/autoload.php";

require_once "Router.php";
require_once "MySQLConnection.php";
require_once "Renderer.php";

require_once "Models/Person.php";
require_once "Models/Contact.php";

require_once "Controllers/HomeController.php";
require_once "Controllers/PeopleController.php";
require_once "Controllers/ContactsController.php";

$router = new Router();
$router->route();

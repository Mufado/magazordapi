<?php
require_once "vendor/autoload.php";

require_once "Router.php";
require_once "MySQLConnection.php";
require_once "Utils.php";
require_once "Renderer.php";

require_once "Models/Person.php";
require_once "Models/Contact.php";

require_once "Controllers/HomeController.php";
require_once "Controllers/PeopleController.php";
require_once "Controllers/ContactsController.php";

# This app uses an default layout.
# When layout is done, the app will input the View code in the body
# of the template, loading the full page right after that.

Renderer::getInstance();
$router = new Router();
$router->route();

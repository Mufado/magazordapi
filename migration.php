<?php

$instance = new PDO("mysql:host=127.0.0.1:3306;dbname=magazordapi;", "root", "1234");

$sql =
  "CREATE TABLE `person` (
    `id` int NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `cpf` varchar(14) NOT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
  
  CREATE TABLE `contact` (
    `id` int NOT NULL AUTO_INCREMENT,
    `type` boolean NOT NULL,
    `description` varchar(255) NOT NULL,
    `idPerson` int NOT NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT `contact_ibfk_2` FOREIGN KEY (`idPerson`) REFERENCES `person` (`id`) ON DELETE CASCADE
  ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;";

$instance->prepare($sql)->execute();

$sql = null;
$instance = null;

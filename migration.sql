CREATE TABLE IF NOT EXISTS `person` (
    `id` int NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `cpf` varchar(14) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
  
CREATE TABLE IF NOT EXISTS `contact` (
    `id` int NOT NULL AUTO_INCREMENT,
    `type` boolean NOT NULL,
    `description` varchar(255) NOT NULL,
    `idPerson` int NOT NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT `contact_ibfk_2` FOREIGN KEY (`idPerson`) REFERENCES `person` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
CREATE TABLE IF NOT EXISTS `uzytkownicy` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `login` VARCHAR(50) NOT NULL UNIQUE,
  `haslo` VARCHAR(50) NOT NULL
);

DROP TABLE IF EXISTS `zadania`;

CREATE TABLE `zadania` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,           
  `data_zadania` DATE NOT NULL,     
  `wpis` TEXT NOT NULL,             
  FOREIGN KEY (`user_id`) REFERENCES `uzytkownicy`(`id`) ON DELETE CASCADE
);
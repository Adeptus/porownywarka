CREATE DATABASE db1;
CONNECT db1;

CREATE TABLE `monitory` (
	`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`marka` VARCHAR(50) NOT NULL,
	`nazwa` VARCHAR(50) NOT NULL,
	`Cale` INT(20) UNSIGNED NOT NULL,
	`Jasnosc` INT(20) UNSIGNED NOT NULL,
	`Reakcja` INT(20) UNSIGNED NOT NULL,
	`Kontrast` VARCHAR(30) NOT NULL,
	`Rozdzielczosc` VARCHAR(30) NOT NULL,
	`Katy` VARCHAR(30),
	`Kolor` VARCHAR(30),
	`Pobor` VARCHAR(30),
	`Czuwanie` VARCHAR(30),
	`Waga` VARCHAR(30),	
	`category_id` INT NOT NULL,
	PRIMARY KEY (`id`),
	KEY `category_id` (`category_id`)
	UNIQUE INDEX `nazwa` (`nazwa`)
)ENGINE=INNODB;







CREATE DATABASE dbtest;
CONNECT dbtest;
CREATE TABLE `monitory` (
	`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`marka` VARCHAR(50) NOT NULL,
	`nazwa` VARCHAR(50) NOT NULL,
	`Cale` INT(20) UNSIGNED NOT NULL,
	`Jasnosc` INT(20) UNSIGNED NOT NULL,
	`Reakcja` INT(20) UNSIGNED NOT NULL,
	`Kontrast` VARCHAR(30) NOT NULL,
	`Rozdzielczosc` VARCHAR(30) NOT NULL,
	`Katy` VARCHAR(30),
	`Kolor` VARCHAR(30),
	`Pobor` VARCHAR(30),
	`Czuwanie` VARCHAR(30),
	`Waga` VARCHAR(30),	
	`category_id` INT NOT NULL,
	PRIMARY KEY (`id`),
	KEY `category_id` (`category_id`)
	UNIQUE INDEX `nazwa` (`nazwa`)
)ENGINE=INNODB;
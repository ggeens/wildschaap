SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE TABLE IF NOT EXISTS `wildschaap`.`ws_workshop` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `naam` VARCHAR(80) NOT NULL,
  `omschrijving` MEDIUMTEXT NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `naam` (`naam` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE TABLE IF NOT EXISTS `wildschaap`.`ws_workshop_datum` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `datum` DATE NOT NULL,
  `plaats` VARCHAR(80) NULL DEFAULT NULL,
  `workshop_id` INT(11) NOT NULL,
  `prijs` DECIMAL(10,2) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_ws_workshop_datum_ws_workshop_idx` (`workshop_id` ASC),
  CONSTRAINT `fk_ws_workshop_datum_ws_workshop`
    FOREIGN KEY (`workshop_id`)
    REFERENCES `wildschaap`.`ws_workshop` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE TABLE IF NOT EXISTS `wildschaap`.`ws_account` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `naam` VARCHAR(80) NOT NULL,
  `email` VARCHAR(80) NOT NULL,
  `paswoord` VARCHAR(80) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE TABLE IF NOT EXISTS `wildschaap`.`ws_cursist` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `naam` VARCHAR(80) NOT NULL,
  `email` VARCHAR(80) NULL DEFAULT NULL,
  `adres` VARCHAR(255) NULL DEFAULT NULL,
  `postcode` VARCHAR(45) NULL DEFAULT NULL,
  `gemeente` VARCHAR(45) NULL DEFAULT NULL,
  `telefoon` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE TABLE IF NOT EXISTS `wildschaap`.`ws_betaling` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `datum` DATE NOT NULL,
  `bedrag` DECIMAL(10,2) NOT NULL,
  `opmerking` VARCHAR(255) NULL DEFAULT NULL,
  `cursist_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_ws_betaling_ws_cursist1_idx` (`cursist_id` ASC),
  CONSTRAINT `fk_ws_betaling_ws_cursist1`
    FOREIGN KEY (`cursist_id`)
    REFERENCES `wildschaap`.`ws_cursist` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE TABLE IF NOT EXISTS `wildschaap`.`ws_inschrijving` (
  `ws_workshop_datum_id` INT(11) NOT NULL,
  `ws_cursist_id` INT(11) NOT NULL,
  INDEX `fk_ws_inschrijving_ws_workshop_datum1_idx` (`ws_workshop_datum_id` ASC),
  INDEX `fk_ws_inschrijving_ws_cursist1_idx` (`ws_cursist_id` ASC),
  CONSTRAINT `fk_ws_inschrijving_ws_workshop_datum1`
    FOREIGN KEY (`ws_workshop_datum_id`)
    REFERENCES `wildschaap`.`ws_workshop_datum` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ws_inschrijving_ws_cursist1`
    FOREIGN KEY (`ws_cursist_id`)
    REFERENCES `wildschaap`.`ws_cursist` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

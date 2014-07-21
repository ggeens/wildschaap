SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema wildschaap
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `wildschaap` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `wildschaap` ;

-- -----------------------------------------------------
-- Table `wildschaap`.`ws_workshop`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `wildschaap`.`ws_workshop` ;

CREATE TABLE IF NOT EXISTS `wildschaap`.`ws_workshop` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `naam` VARCHAR(80) NOT NULL,
  `omschrijving` LONGTEXT NULL,
  `deleted` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  INDEX `naam` (`naam` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wildschaap`.`ws_sessie`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `wildschaap`.`ws_sessie` ;

CREATE TABLE IF NOT EXISTS `wildschaap`.`ws_sessie` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `datum` DATE NOT NULL,
  `plaats` LONGTEXT NULL,
  `ws_workshop_id` INT NOT NULL,
  `prijs` DECIMAL(10,2) NULL,
  `capaciteit` INT NOT NULL DEFAULT 0,
  `deleted` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  INDEX `fk_sessie_workshop_idx` (`ws_workshop_id` ASC),
  INDEX `idx_workshop_naam` (`datum` ASC),
  CONSTRAINT `fk_sessie_workshop`
    FOREIGN KEY (`ws_workshop_id`)
    REFERENCES `wildschaap`.`ws_workshop` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wildschaap`.`ws_account`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `wildschaap`.`ws_account` ;

CREATE TABLE IF NOT EXISTS `wildschaap`.`ws_account` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `naam` TINYTEXT NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `paswoord` TINYTEXT NOT NULL,
  `admin` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wildschaap`.`ws_cursist`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `wildschaap`.`ws_cursist` ;

CREATE TABLE IF NOT EXISTS `wildschaap`.`ws_cursist` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `naam` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NULL,
  `adres` TEXT NULL,
  `postcode` TINYTEXT NULL,
  `gemeente` TINYTEXT NULL,
  `telefoon` TINYTEXT NULL,
  `is_mailings` TINYINT(1) NOT NULL DEFAULT 0,
  `opmerkingen` TEXT NULL,
  `deleted` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  INDEX `idx_cursist_naam` (`naam` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wildschaap`.`ws_inschrijving`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `wildschaap`.`ws_inschrijving` ;

CREATE TABLE IF NOT EXISTS `wildschaap`.`ws_inschrijving` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `ws_sessie_id` INT NOT NULL,
  `ws_cursist_id` INT NOT NULL,
  `betaald` TINYINT(1) NOT NULL,
  `deleted` TINYINT(1) NOT NULL DEFAULT 0,
  INDEX `fk_ws_inschrijving_ws_workshop_datum1_idx` (`ws_sessie_id` ASC),
  INDEX `fk_ws_inschrijving_ws_cursist1_idx` (`ws_cursist_id` ASC),
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_ws_inschrijving_ws_workshop_datum1`
    FOREIGN KEY (`ws_sessie_id`)
    REFERENCES `wildschaap`.`ws_sessie` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ws_inschrijving_ws_cursist1`
    FOREIGN KEY (`ws_cursist_id`)
    REFERENCES `wildschaap`.`ws_cursist` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wildschaap`.`ws_translation`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `wildschaap`.`ws_translation` ;

CREATE TABLE IF NOT EXISTS `wildschaap`.`ws_translation` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `key` VARCHAR(200) NOT NULL,
  `tr_nl` VARCHAR(200) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `ws_translation_key` (`key` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wildschaap`.`ws_stuk`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `wildschaap`.`ws_stuk` ;

CREATE TABLE IF NOT EXISTS `wildschaap`.`ws_stuk` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `naam` VARCHAR(255) NOT NULL,
  `omschrijving` TEXT NULL,
  `deleted` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  INDEX `idx_stuk_naam` (`naam` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wildschaap`.`ws_voorstelling`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `wildschaap`.`ws_voorstelling` ;

CREATE TABLE IF NOT EXISTS `wildschaap`.`ws_voorstelling` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `datum` DATE NOT NULL,
  `uur` TIME NOT NULL,
  `plaats` LONGTEXT NULL,
  `prijs` DECIMAL(10,2) NOT NULL,
  `capaciteit` INT NOT NULL,
  `ws_stuk_id` INT NOT NULL,
  `deleted` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  INDEX `idx_voorstelling_datum` (`datum` ASC),
  INDEX `fk_voorstelling_stuk_idx` (`ws_stuk_id` ASC),
  CONSTRAINT `fk_voorstelling_stuk`
    FOREIGN KEY (`ws_stuk_id`)
    REFERENCES `wildschaap`.`ws_stuk` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wildschaap`.`ws_reservatie`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `wildschaap`.`ws_reservatie` ;

CREATE TABLE IF NOT EXISTS `wildschaap`.`ws_reservatie` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `ws_cursist_id` INT NOT NULL,
  `ws_voorstelling_id` INT NOT NULL,
  `betaald` TINYINT(1) NOT NULL DEFAULT 0,
  `aantal` INT NOT NULL DEFAULT 1,
  `deleted` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  INDEX `fk_reservatie_cursist_idx` (`ws_cursist_id` ASC),
  INDEX `fk_reservatie_voorstelling_idx` (`ws_voorstelling_id` ASC),
  CONSTRAINT `fk_reservatie_cursist`
    FOREIGN KEY (`ws_cursist_id`)
    REFERENCES `wildschaap`.`ws_cursist` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_reservatie_voorstelling`
    FOREIGN KEY (`ws_voorstelling_id`)
    REFERENCES `wildschaap`.`ws_voorstelling` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

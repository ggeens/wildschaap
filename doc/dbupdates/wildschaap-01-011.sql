SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE TABLE IF NOT EXISTS `wildschaap`.`ws_stuk` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `naam` VARCHAR(255) NOT NULL,
  `omschrijving` TEXT NULL DEFAULT NULL,
  `deleted` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  INDEX `idx_stuk_naam` (`naam` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE TABLE IF NOT EXISTS `wildschaap`.`ws_voorstelling` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `datum` DATE NOT NULL,
  `uur` TIME NOT NULL,
  `plaats` LONGTEXT NULL DEFAULT NULL,
  `prijs` DECIMAL(10,2) NOT NULL,
  `ws_stuk_id` INT(11) NOT NULL,
  `deleted` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  INDEX `idx_voorstelling_datum` (`datum` ASC),
  INDEX `fk_ws_voorstelling_ws_stuk1_idx` (`ws_stuk_id` ASC),
  CONSTRAINT `fk_ws_voorstelling_ws_stuk1`
    FOREIGN KEY (`ws_stuk_id`)
    REFERENCES `wildschaap`.`ws_stuk` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE TABLE IF NOT EXISTS `wildschaap`.`ws_reservatie` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `ws_cursist_id` INT(11) NOT NULL,
  `ws_voorstelling_id` INT(11) NOT NULL,
  `betaald` TINYINT(1) NOT NULL DEFAULT 0,
  `aantal` INT(11) NOT NULL DEFAULT 1,
  `deleted` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  INDEX `fk_ws_reservatie_ws_cursist1_idx` (`ws_cursist_id` ASC),
  INDEX `fk_ws_reservatie_ws_voorstelling1_idx` (`ws_voorstelling_id` ASC),
  CONSTRAINT `fk_ws_reservatie_ws_cursist1`
    FOREIGN KEY (`ws_cursist_id`)
    REFERENCES `wildschaap`.`ws_cursist` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ws_reservatie_ws_voorstelling1`
    FOREIGN KEY (`ws_voorstelling_id`)
    REFERENCES `wildschaap`.`ws_voorstelling` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

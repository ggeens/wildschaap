SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

ALTER TABLE `wildschaap`.`ws_workshop_datum` 
RENAME TO  `wildschaap`.`ws_sessie` ;

ALTER TABLE `wildschaap`.`ws_account` 
CHANGE COLUMN `naam` `naam` TINYTEXT NOT NULL ,
CHANGE COLUMN `email` `email` VARCHAR(255) NOT NULL ;

ALTER TABLE `wildschaap`.`ws_cursist` 
CHANGE COLUMN `naam` `naam` VARCHAR(255) NOT NULL ,
CHANGE COLUMN `email` `email` VARCHAR(255) NULL DEFAULT NULL ,
CHANGE COLUMN `adres` `adres` TEXT NULL DEFAULT NULL ,
CHANGE COLUMN `postcode` `postcode` TINYTEXT NULL DEFAULT NULL ,
CHANGE COLUMN `gemeente` `gemeente` TINYTEXT NULL DEFAULT NULL ,
CHANGE COLUMN `telefoon` `telefoon` TINYTEXT NULL DEFAULT NULL ,
CHANGE COLUMN `opmerkingen` `opmerkingen` TEXT NULL DEFAULT NULL ;

ALTER TABLE `wildschaap`.`ws_inschrijving` 
DROP FOREIGN KEY `fk_ws_inschrijving_ws_workshop_datum1`;

ALTER TABLE `wildschaap`.`ws_inschrijving` 
CHANGE COLUMN `ws_workshop_datum_id` `ws_sessie_id` INT(11) NOT NULL ;

ALTER TABLE `wildschaap`.`ws_inschrijving` ADD CONSTRAINT `fk_ws_inschrijving_ws_workshop_datum1`
  FOREIGN KEY (`ws_sessie_id`)
  REFERENCES `wildschaap`.`ws_sessie` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

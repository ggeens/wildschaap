-- First update to schema
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

ALTER TABLE `wildschaap`.`ws_workshop` 
CHANGE COLUMN `omschrijving` `omschrijving` LONGTEXT NULL DEFAULT NULL ;

ALTER TABLE `wildschaap`.`ws_workshop_datum` 
CHANGE COLUMN `plaats` `plaats` LONGTEXT NULL DEFAULT NULL ,
ADD INDEX `idx_workshop_naam` (`datum` ASC);

ALTER TABLE `wildschaap`.`ws_cursist` 
ADD COLUMN `mailings` BIT(1) NOT NULL AFTER `telefoon`,
ADD COLUMN `opmerkingen` LONGTEXT NULL DEFAULT NULL AFTER `mailings`,
ADD INDEX `idx_cursist_naam` (`naam` ASC);

ALTER TABLE `wildschaap`.`ws_betaling` 
ADD INDEX `idx_betaling_datum` (`datum` ASC);


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

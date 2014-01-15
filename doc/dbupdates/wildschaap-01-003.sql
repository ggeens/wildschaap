SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

ALTER TABLE `wildschaap`.`ws_betaling` 
DROP FOREIGN KEY `fk_ws_betaling_ws_cursist1`;

ALTER TABLE `wildschaap`.`ws_inschrijving` 
DROP FOREIGN KEY `fk_ws_inschrijving_ws_workshop_datum1`;

ALTER TABLE `wildschaap`.`ws_betaling` 
CHANGE COLUMN `cursist_id` `ws_cursist_id` INT(11) NOT NULL ;

ALTER TABLE `wildschaap`.`ws_inschrijving` 
DROP INDEX `fk_ws_inschrijving_ws_workshop_datum1_idx` ,
ADD INDEX `fk_ws_inschrijving_ws_workshop_datum1_idx` (`ws_sessie_id` ASC);

ALTER TABLE `wildschaap`.`ws_betaling` 
ADD CONSTRAINT `fk_ws_betaling_ws_cursist1`
  FOREIGN KEY (`ws_cursist_id`)
  REFERENCES `wildschaap`.`ws_cursist` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `wildschaap`.`ws_inschrijving` 
ADD CONSTRAINT `fk_ws_inschrijving_ws_workshop_datum1`
  FOREIGN KEY (`ws_sessie_id`)
  REFERENCES `wildschaap`.`ws_sessie` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

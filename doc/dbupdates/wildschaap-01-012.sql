SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

ALTER TABLE `wildschaap`.`ws_voorstelling` 
ADD COLUMN `capaciteit` INT(11) NOT NULL AFTER `prijs`,
ADD INDEX `fk_ws_voorstelling_ws_stuk1_idx` (`ws_stuk_id` ASC),
DROP INDEX `fk_ws_voorstelling_ws_stuk1_idx` ;

ALTER TABLE `wildschaap`.`ws_reservatie` 
ADD INDEX `fk_ws_reservatie_ws_cursist1_idx` (`ws_cursist_id` ASC),
ADD INDEX `fk_ws_reservatie_ws_voorstelling1_idx` (`ws_voorstelling_id` ASC),
DROP INDEX `fk_ws_reservatie_ws_voorstelling1_idx` ,
DROP INDEX `fk_ws_reservatie_ws_cursist1_idx` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

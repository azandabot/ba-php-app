/*
SQLyog Community v13.2.1 (64 bit)
MySQL - 10.4.28-MariaDB : Database - db_ba_php_app
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_ba_php_app` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `db_ba_php_app`;

/*Table structure for table `deliveries` */

DROP TABLE IF EXISTS `deliveries`;

CREATE TABLE `deliveries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `instructions` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `item_id` (`item_id`),
  CONSTRAINT `deliveries_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `deliveries_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `items` */

DROP TABLE IF EXISTS `items`;

CREATE TABLE `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(255) NOT NULL,
  `item_price` decimal(10,2) NOT NULL,
  `available` int(11) NOT NULL,
  `discount` decimal(5,2) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `orders` */

DROP TABLE IF EXISTS `orders`;

CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `instructions` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `item_id` (`item_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `last_login` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/* Procedure structure for procedure `pd_DeleteDelivery` */

/*!50003 DROP PROCEDURE IF EXISTS  `pd_DeleteDelivery` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `pd_DeleteDelivery`(IN p_delivery_id INT)
BEGIN
    DELETE FROM Deliveries WHERE id = p_delivery_id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `pd_DeleteItem` */

/*!50003 DROP PROCEDURE IF EXISTS  `pd_DeleteItem` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `pd_DeleteItem`(IN p_item_id INT)
BEGIN
    DELETE FROM Items WHERE id = p_item_id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `pd_DeleteOrder` */

/*!50003 DROP PROCEDURE IF EXISTS  `pd_DeleteOrder` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `pd_DeleteOrder`(IN p_order_id INT)
BEGIN
    DELETE FROM Orders WHERE id = p_order_id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `pd_DeleteUser` */

/*!50003 DROP PROCEDURE IF EXISTS  `pd_DeleteUser` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `pd_DeleteUser`(IN p_user_id INT)
BEGIN
    DELETE FROM Users WHERE id = p_user_id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `pi_CreateDelivery` */

/*!50003 DROP PROCEDURE IF EXISTS  `pi_CreateDelivery` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `pi_CreateDelivery`(
    IN p_user_id INT,
    IN p_item_id INT,
    IN p_date DATE,
    IN p_qty INT,
    IN p_instructions TEXT
)
BEGIN
    INSERT INTO Deliveries (user_id, item_id, date, qty, instructions)
    VALUES (p_user_id, p_item_id, p_date, p_qty, p_instructions);
END */$$
DELIMITER ;

/* Procedure structure for procedure `pi_CreateItem` */

/*!50003 DROP PROCEDURE IF EXISTS  `pi_CreateItem` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `pi_CreateItem`(
    IN p_item_name VARCHAR(255),
    IN p_item_price DECIMAL(10, 2),
    IN p_available INT,
    IN p_discount DECIMAL(5, 2)
)
BEGIN
    INSERT INTO Items (item_name, item_price, available, discount)
    VALUES (p_item_name, p_item_price, p_available, p_discount);
END */$$
DELIMITER ;

/* Procedure structure for procedure `pi_CreateUser` */

/*!50003 DROP PROCEDURE IF EXISTS  `pi_CreateUser` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `pi_CreateUser`(
    IN p_username VARCHAR(255),
    IN p_email VARCHAR(255),
    IN p_password VARCHAR(255),
    IN p_role VARCHAR(50)
)
BEGIN
    INSERT INTO Users (username, email, password, role)
    VALUES (p_username, p_email, p_password, p_role);
END */$$
DELIMITER ;

/* Procedure structure for procedure `pi_MakeOrder` */

/*!50003 DROP PROCEDURE IF EXISTS  `pi_MakeOrder` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `pi_MakeOrder`(
    IN p_user_id INT,
    IN p_item_id INT,
    IN p_qty INT,
    IN p_status VARCHAR(50),
    IN p_instructions TEXT
)
BEGIN
    INSERT INTO Orders (user_id, item_id, qty, status, instructions)
    VALUES (p_user_id, p_item_id, p_qty, p_status, p_instructions);
END */$$
DELIMITER ;

/* Procedure structure for procedure `pu_EditUser` */

/*!50003 DROP PROCEDURE IF EXISTS  `pu_EditUser` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `pu_EditUser`(
    IN p_user_id INT,
    IN p_username VARCHAR(255),
    IN p_email VARCHAR(255),
    IN p_password VARCHAR(255),
    IN p_role VARCHAR(50)
)
BEGIN
    UPDATE Users
    SET username = p_username, email = p_email, password = p_password, role = p_role
    WHERE id = p_user_id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `pu_UpdateDelivery` */

/*!50003 DROP PROCEDURE IF EXISTS  `pu_UpdateDelivery` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `pu_UpdateDelivery`(
    IN p_delivery_id INT,
    IN p_user_id INT,
    IN p_item_id INT,
    IN p_date DATE,
    IN p_qty INT,
    IN p_instructions TEXT
)
BEGIN
    UPDATE Deliveries
    SET user_id = p_user_id, item_id = p_item_id, date = p_date, qty = p_qty, instructions = p_instructions
    WHERE id = p_delivery_id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `pu_UpdateItem` */

/*!50003 DROP PROCEDURE IF EXISTS  `pu_UpdateItem` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `pu_UpdateItem`(
    IN p_item_id INT,
    IN p_item_name VARCHAR(255),
    IN p_item_price DECIMAL(10, 2),
    IN p_available INT,
    IN p_discount DECIMAL(5, 2)
)
BEGIN
    UPDATE Items
    SET item_name = p_item_name, item_price = p_item_price, available = p_available, discount = p_discount
    WHERE id = p_item_id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `pu_UpdateOrder` */

/*!50003 DROP PROCEDURE IF EXISTS  `pu_UpdateOrder` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `pu_UpdateOrder`(
    IN p_order_id INT,
    IN p_user_id INT,
    IN p_item_id INT,
    IN p_qty INT,
    IN p_status VARCHAR(50),
    IN p_instructions TEXT
)
BEGIN
    UPDATE Orders
    SET user_id = p_user_id, item_id = p_item_id, qty = p_qty, status = p_status, instructions = p_instructions
    WHERE id = p_order_id;
END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

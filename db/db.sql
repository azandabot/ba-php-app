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
  `status` varchar(255) DEFAULT 'Scheduled',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `item_id` (`item_id`),
  CONSTRAINT `deliveries_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `deliveries_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `deliveries` */

/*Table structure for table `items` */

DROP TABLE IF EXISTS `items`;

CREATE TABLE `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(255) NOT NULL,
  `item_price` decimal(10,2) NOT NULL,
  `available` char(1) NOT NULL DEFAULT 'Y',
  `discount` decimal(5,2) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


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

/*Data for the table `orders` */

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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`username`,`email`,`password`,`role`,`created_at`,`last_login`) values 
(1,'Myuser','myuser@a.com','*01C75ECA36F9527217B60ADC00BE10B9BEC0165D','admin','2023-11-20 11:27:43',NULL);


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
    IN p_available char(1),
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
	declare aUserEmailCnt, aUserNameCnt int default 0;
	
	select count(*) into aUserEmailCnt 
	from `users`
	where `email` = p_email;
	
	SELECT COUNT(*) INTO aUserNameCnt 
	FROM `users`
	WHERE `username` = p_username;
	
	if aUserEmailCnt = 0 and aUserNameCnt = 0 then 
	    INSERT INTO Users (username, email, PASSWORD, ROLE)
	    VALUES (p_username, p_email, PASSWORD(p_password), p_role);
	end if;

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
SET username = p_username, email = p_email,
  PASSWORD = CASE WHEN p_password = '' THEN PASSWORD ELSE p_password END,
  ROLE = p_role
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
    in p_status varchar(255),
    IN p_instructions TEXT
)
BEGIN
    UPDATE Deliveries
    SET user_id = p_user_id, item_id = p_item_id, date = p_date, qty = p_qty, instructions = p_instructions, `status` = p_status
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
    IN p_available char(1),
    IN p_discount DECIMAL(5, 2)
)
BEGIN
    UPDATE Items
    SET item_name = p_item_name, item_price = p_item_price, available = p_available, discount = p_discount
    WHERE id = p_item_id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `pu_UpdateItemPrice` */

/*!50003 DROP PROCEDURE IF EXISTS  `pu_UpdateItemPrice` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `pu_UpdateItemPrice`(in p_item_id int, in p_item_price DECIMAL(10, 2))
BEGIN

 DECLARE original_price DECIMAL(10, 2);

    -- Get the original price
    SELECT `item_price` INTO original_price
    FROM `items`
    WHERE `id` = p_item_id;

    -- Update the price and calculate the discount
    UPDATE `items`
    SET 
        `item_price` = p_item_price,
        `discount` = CAST(((original_price - p_item_price) / original_price) * 100 AS DECIMAL(5, 2))
    WHERE `id` = p_item_id;
	
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

/* Procedure structure for procedure `sp_getAllOrders` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_getAllOrders` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_getAllOrders`()
BEGIN
		select 
		`orders`.`id`,
		`items`.`item_name`,
		`orders`.`qty`,
		`orders`.`status`,
		`orders`.`created_at`
		from orders
		left join `items`
		on `orders`.`item_id` = `items`.`id`;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_getDashboardStats` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_getDashboardStats` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_getDashboardStats`()
BEGIN
	
		declare aSysOrders, aSysDeliveries, aSysDiscount, aSysInventory int default 0;
		
		select count(*) into aSysOrders from `orders`;
		SELECT COUNT(*) INTO aSysDeliveries FROM `deliveries`;
		
		SELECT COUNT(*) INTO aSysDiscount 
		FROM `items`
		where `discount` > 0.00;
		
		SELECT sum(`qty`) INTO aSysInventory
		FROM `orders`
		left join `items`
		on `orders`.`item_id` = `items`.`id`;
		
		select aSysOrders, aSysDeliveries, aSysDiscount, aSysInventory;

	END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_getDeliveries` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_getDeliveries` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_getDeliveries`()
BEGIN

		select
		`deliveries`.`id`,
		`items`.`item_name`,
		`deliveries`.`date`, 
		`deliveries`.`qty`,
		`deliveries`.`instructions`,
		`deliveries`.`status`,
		`deliveries`.`created_at`
		from `deliveries`
		left join `items`
		on `deliveries`.`item_id` = `items`.`id`;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_getDeliveriesForUser` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_getDeliveriesForUser` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_getDeliveriesForUser`(in p_user_id int)
BEGIN
	
	SELECT
		`items`.`item_name` as delivery_name,
		(`deliveries`.`qty`*`items`.`item_price`) as delivery_price,
		`deliveries`.`status`
		FROM `deliveries`
		LEFT JOIN `items`
		ON `deliveries`.`item_id` = `items`.`id`
		WHERE `deliveries`.`user_id` = p_user_id;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_getDelivery` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_getDelivery` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_getDelivery`(p_delivery_id int)
BEGIN
		SELECT
		`deliveries`.`id`,
		item_id,
		`deliveries`.`date`, 
		`deliveries`.`qty`,
		`deliveries`.`instructions`,
		`deliveries`.`status`,
		`deliveries`.`created_at`
		FROM `deliveries`
		LEFT JOIN `items`
		ON `deliveries`.`item_id` = `items`.`id`
		where `deliveries`.`id` = p_delivery_id;

	END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_getLoggedUserId` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_getLoggedUserId` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_getLoggedUserId`(p_username varchar(255))
BEGIN

		select `id` as aUserId 
		from `users` 
		where `username` = p_username;
		
	END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_getLoggedUserRole` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_getLoggedUserRole` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_getLoggedUserRole`(p_username varchar(255))
BEGIN
	
		select role as aUserRole
		from users
		where `username` = p_username;

	END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_getMenuItem` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_getMenuItem` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_getMenuItem`(p_itemId INT)
BEGIN
		SELECT * FROM items WHERE id = p_itemId;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_getMenuItems` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_getMenuItems` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_getMenuItems`()
BEGIN
	
		select 
		`id`, `item_name`, `item_price`, `available`, `discount`
		from `items`;

	END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_getOrderDetails` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_getOrderDetails` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_getOrderDetails`(p_order_id int)
BEGIN
	
		SELECT 
		`orders`.`id`,
		`items`.`item_name`,
		`orders`.`qty`,
		`orders`.`status`,
		`orders`.`instructions`,
		`orders`.`created_at`
		FROM orders
		LEFT JOIN `items`
		ON `orders`.`item_id` = `items`.`id`
		where `orders`.`id` = p_order_id;

	END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_getOrdersForUser` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_getOrdersForUser` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_getOrdersForUser`(p_user_id int)
BEGIN
	
		SELECT 
		`orders`.`id`,
		`items`.`item_name` AS 'order_name',
		(`orders`.`qty`*`items`.`item_price`) AS 'order_price',
		`orders`.`status`
		FROM orders
		LEFT JOIN `items`
		ON `orders`.`item_id` = `items`.`id`
		WHERE `orders`.`user_id` = p_user_id;

	END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_getStockSoldOverOrders` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_getStockSoldOverOrders` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_getStockSoldOverOrders`(in p_item_id int)
BEGIN
	
		declare aItemPrice decimal(5,2) default 0;
		
		select `item_price` into aItemPrice
		from `items`
		where `id` = p_item_id;
	
		SELECT COUNT(*) AS TotalSales, SUM(qty) AS TotalQty, aItemPrice as ItemPrice
		from `orders`
		where `item_id` = p_item_id;

	END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_getUser` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_getUser` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_getUser`(p_user_id int)
BEGIN
	
	select * from users where id=p_user_id;

	END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_getUsers` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_getUsers` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_getUsers`()
BEGIN
	
		select * from users;

	END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_LoginUser` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_LoginUser` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_LoginUser`(p_username varchar(255), p_password varchar(255))
BEGIN
	
		declare aCnt int default 0;
		declare aMsg varchar(255) default 'invalid';
		
		select count(*) into aCnt
		from users
		where (`email` = p_username or username = p_username)
		and password = password(p_password);
		
		if aCnt > 0 then
			set aMsg = 'valid';
		end if;
		
		select aMsg;

	END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

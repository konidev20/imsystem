-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 22, 2018 at 02:58 PM
-- Server version: 5.7.19
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `imsdb`
--
CREATE DATABASE IF NOT EXISTS `imsdb` DEFAULT CHARACTER SET latin1 COLLATE latin1_bin;
USE `imsdb`;

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `addOrderItem`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `addOrderItem` (IN `orderID` INT(10), IN `productID` VARCHAR(8), IN `noOfUnits` INT)  MODIFIES SQL DATA
    COMMENT 'adding an order item '
BEGIN
	SET @unitPrice = (SELECT UNIT_PRICE FROM product WHERE PRODUCT_ID = productID);
    SET @itemTotal = (@unitPrice * noOfUnits);
    
    INSERT INTO order_item VALUES (NULL,orderID,productID,noOfUnits,@unitPrice,@itemTotal,0);
END$$

DROP PROCEDURE IF EXISTS `createOrder`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `createOrder` (IN `customerID` VARCHAR(10), IN `shippingCenterID` VARCHAR(10))  MODIFIES SQL DATA
    COMMENT 'creates a blank order'
BEGIN
INSERT INTO orders VALUES(NULL,customerID,shippingCenterID,CURRENT_TIMESTAMP,'0','0');
END$$

DROP PROCEDURE IF EXISTS `dispatchOrder`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `dispatchOrder` (IN `orderID` INT(10), OUT `stat` VARCHAR(8))  MODIFIES SQL DATA
BEGIN
DECLARE totalStock INT DEFAULT 0;
DECLARE itemID INT;
DECLARE prodID VARCHAR(8);
DECLARE quanti INT;
DECLARE finished INT;
DECLARE orderItem CURSOR FOR 
SELECT ITEM_ID, PRODUCT_ID, QUANTITY FROM order_item WHERE ORDER_ID = orderID;
DECLARE CONTINUE HANDLER FOR NOT FOUND SET finished = 1;
SET stat = 0;
OPEN orderItem;
getItems: LOOP
	FETCH orderItem INTO itemID,prodID,quanti;
    IF finished = 1 THEN
    	LEAVE getItems;
    END IF;
    SELECT NO_OF_UNITS INTO totalStock FROM stock WHERE PRODUCT_ID = prodID;
    IF totalStock >= quanti THEN
    	UPDATE stock SET NO_OF_UNITS = (totalStock - quanti) WHERE PRODUCT_ID = prodID;
        UPDATE order_item SET ITEM_STATUS = 1 WHERE PRODUCT_ID = prodID AND ORDER_ID = orderID;
        SET stat = 1;
    ELSE
    	SET stat = prodID;
        LEAVE getItems;
    END IF;
END LOOP;

CLOSE orderItem;

IF stat <=> 1 THEN
	UPDATE orders SET INVOICE_STATUS = 1 WHERE ORDER_ID = orderID;
END IF;

END$$

DROP PROCEDURE IF EXISTS `insertCustomer`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `insertCustomer` (IN `custID` VARCHAR(10), IN `custName` VARCHAR(30), IN `custCity` VARCHAR(20), IN `custAddress` VARCHAR(40), IN `custZipcode` VARCHAR(6), IN `custPhone` VARCHAR(10))  MODIFIES SQL DATA
BEGIN
	INSERT INTO customer VALUES (custID, custName, custCity, custAddress, custZipcode, custPhone);
END$$

DROP PROCEDURE IF EXISTS `markDelivered`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `markDelivered` (IN `orderID` INT(10))  MODIFIES SQL DATA
BEGIN
	UPDATE orders SET INVOICE_STATUS = 2 WHERE ORDER_ID = orderID;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
CREATE TABLE IF NOT EXISTS `customer` (
  `CUSTOMER_ID` varchar(10) COLLATE latin1_bin NOT NULL,
  `NAME` varchar(30) COLLATE latin1_bin NOT NULL,
  `CITY` varchar(20) COLLATE latin1_bin NOT NULL,
  `ADDRESS` varchar(40) COLLATE latin1_bin NOT NULL,
  `ZIPCODE` varchar(6) COLLATE latin1_bin NOT NULL,
  `PHONE` varchar(10) COLLATE latin1_bin NOT NULL,
  PRIMARY KEY (`CUSTOMER_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`CUSTOMER_ID`, `NAME`, `CITY`, `ADDRESS`, `ZIPCODE`, `PHONE`) VALUES
('5000045691', 'POORVIKA MOBILES INTERNATIONAL', 'BANGALORE', 'NO 35 MG ROAD', '560018', '9856098211'),
('5000045692', 'PAI MOBILE INTERNATIONAL', 'BANGALORE', '3RD CROSS JAYANAGAR', '560004', '9845080257'),
('5000045693', 'ANAND & CO', 'BANGALORE', '23 1ST CROSS BANASHANKARI', '506002', '8945123452'),
('5000045694', 'ALPHA COMPUTERS', 'BANGALORE', 'NO 15 16TH CROSS JAYANAGAR', '560001', '8906543214'),
('5000045695', 'ASIF MOBILES & ACCESSORIES', 'CHENNAI', 'SHOP 26 AMMA ROAD', '400400', '7654321422');

-- --------------------------------------------------------

--
-- Table structure for table `manager`
--

DROP TABLE IF EXISTS `manager`;
CREATE TABLE IF NOT EXISTS `manager` (
  `MANAGER_ID` int(11) NOT NULL,
  `MANAGER_NAME` varchar(30) COLLATE latin1_bin NOT NULL,
  PRIMARY KEY (`MANAGER_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin COMMENT='Manager Table';

--
-- Dumping data for table `manager`
--

INSERT INTO `manager` (`MANAGER_ID`, `MANAGER_NAME`) VALUES
(5793834, 'SRIGOVIND');

-- --------------------------------------------------------

--
-- Table structure for table `manufacturer`
--

DROP TABLE IF EXISTS `manufacturer`;
CREATE TABLE IF NOT EXISTS `manufacturer` (
  `MANUFACTURER_ID` varchar(10) COLLATE latin1_bin NOT NULL,
  `MANUFACTURER_NAME` varchar(30) COLLATE latin1_bin NOT NULL,
  `CITY` varchar(20) COLLATE latin1_bin NOT NULL,
  `ZIPCODE` int(6) NOT NULL,
  `PHONE` varchar(10) COLLATE latin1_bin NOT NULL,
  PRIMARY KEY (`MANUFACTURER_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

--
-- Dumping data for table `manufacturer`
--

INSERT INTO `manufacturer` (`MANUFACTURER_ID`, `MANUFACTURER_NAME`, `CITY`, `ZIPCODE`, `PHONE`) VALUES
('1520APPLE9', 'APPLE INDIA', 'MUMBAI', 400011, '24801269'),
('2451OPPO11', 'OPPO INDIA', 'BANGALORE', 560019, '28143215'),
('4131WD1222', 'WESTERN DIGITAL INDIA', 'KOLKATA', 700028, '45678322'),
('7760DELL00', 'DELL INDIA', 'BANGALORE', 560004, '26701865'),
('98ACER4508', 'ACER INDIA', 'HYDERABAD', 500003, '46501855'),
('99029HP001', 'HP INDIA', 'DELHI', 110012, '26543131'),
('SAMGL42', 'SAMSUNG INDIA', 'INDORE', 300012, '7653421012'),
('XIAO982', 'XIAOMI INDIA', 'MUMBAI', 560012, '984563214');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `ORDER_ID` int(10) NOT NULL AUTO_INCREMENT,
  `CUSTOMER_ID` varchar(10) COLLATE latin1_bin NOT NULL,
  `SHIPPING_CENTER_ID` varchar(10) COLLATE latin1_bin NOT NULL,
  `INVOICE_DATE` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `INVOICE_STATUS` int(11) NOT NULL DEFAULT '0',
  `TOTAL_PRICE` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ORDER_ID`),
  KEY `SHIPPINGCENTERID` (`SHIPPING_CENTER_ID`),
  KEY `CUSTOMER_ID` (`CUSTOMER_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1000020017 DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`ORDER_ID`, `CUSTOMER_ID`, `SHIPPING_CENTER_ID`, `INVOICE_DATE`, `INVOICE_STATUS`, `TOTAL_PRICE`) VALUES
(1000020000, '5000045691', '1BLORE0104', '2018-11-17 11:06:08', 1, 1200000),
(1000020001, '5000045692', '1BLORE0104', '2018-11-17 11:07:14', 2, 1495000),
(1000020002, '5000045692', '1BLORE0104', '2018-11-17 11:34:59', 2, 900000),
(1000020003, '5000045692', '1BLORE0104', '2018-11-17 13:50:27', 2, 350000),
(1000020010, '5000045695', '1BLORE0104', '2018-11-19 22:06:59', 1, 2850000),
(1000020014, '5000045691', '1BLORE0104', '2018-11-22 00:09:24', 1, 900000),
(1000020015, '5000045692', '1BLORE0104', '2018-11-22 00:36:59', 1, 72000);

-- --------------------------------------------------------

--
-- Table structure for table `order_item`
--

DROP TABLE IF EXISTS `order_item`;
CREATE TABLE IF NOT EXISTS `order_item` (
  `ITEM_ID` int(11) NOT NULL AUTO_INCREMENT,
  `ORDER_ID` int(10) NOT NULL,
  `PRODUCT_ID` varchar(8) COLLATE latin1_bin NOT NULL,
  `QUANTITY` int(11) NOT NULL,
  `UNIT_PRICE` int(11) NOT NULL,
  `ITEM_TOTAL` int(11) NOT NULL,
  `ITEM_STATUS` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ITEM_ID`),
  KEY `PRODUCTID` (`PRODUCT_ID`),
  KEY `ORDERID` (`ORDER_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=10043 DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

--
-- Dumping data for table `order_item`
--

INSERT INTO `order_item` (`ITEM_ID`, `ORDER_ID`, `PRODUCT_ID`, `QUANTITY`, `UNIT_PRICE`, `ITEM_TOTAL`, `ITEM_STATUS`) VALUES
(10000, 1000020000, '132XPS15', 10, 90000, 900000, 1),
(10001, 1000020000, '2451F1P0', 10, 30000, 300000, 1),
(10003, 1000020001, '2451F1P0', 10, 30000, 300000, 1),
(10004, 1000020001, '1520XSM1', 10, 100000, 1000000, 1),
(10006, 1000020001, '4131WDPS', 10, 4500, 45000, 1),
(10008, 1000020002, '132XPS15', 10, 90000, 900000, 1),
(10010, 1000020003, '2451F1P0', 10, 35000, 350000, 1),
(10023, 1000020010, '1520XSM1', 10, 100000, 1000000, 1),
(10024, 1000020010, '2451F1P0', 10, 35000, 350000, 1),
(10025, 1000020010, '98ACERX1', 20, 75000, 1500000, 1),
(10038, 1000020014, '132XPS15', 10, 90000, 900000, 1),
(10039, 1000020015, '4131WDPS', 12, 6000, 72000, 1);

--
-- Triggers `order_item`
--
DROP TRIGGER IF EXISTS `deleteOrderItem`;
DELIMITER $$
CREATE TRIGGER `deleteOrderItem` AFTER DELETE ON `order_item` FOR EACH ROW BEGIN
	SET @orderID = OLD.ORDER_ID;
    SET @itemTotal = OLD.ITEM_TOTAL;
    SET @orderTotal = (SELECT TOTAL_PRICE FROM orders where ORDER_ID = @orderID);
    
	SET @noItems = (SELECT COUNT(*) FROM order_item WHERE ORDER_ID = @orderID);
    IF @noItems <=> 0 THEN
		DELETE FROM orders WHERE ORDER_ID = @orderID;
    ELSEIF @noItems > 0 THEN
    	UPDATE orders SET TOTAL_PRICE = (@orderTotal - @itemTotal) WHERE ORDER_ID = @orderID;
    END IF;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `updateTotalPrice`;
DELIMITER $$
CREATE TRIGGER `updateTotalPrice` AFTER INSERT ON `order_item` FOR EACH ROW BEGIN
	SET @orderID = NEW.ORDER_ID;
	SET @orderTotal = (SELECT TOTAL_PRICE FROM orders where ORDER_ID = @orderID);
    SET @itemTotal = NEW.ITEM_TOTAL;
    UPDATE orders SET TOTAL_PRICE = (@orderTotal + @itemTotal) WHERE ORDER_ID = @orderID;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `PRODUCT_ID` varchar(8) COLLATE latin1_bin NOT NULL,
  `NAME` varchar(30) COLLATE latin1_bin NOT NULL,
  `MANUFACTURER_ID` varchar(10) COLLATE latin1_bin NOT NULL,
  `UNIT_PRICE` int(10) NOT NULL,
  `CATEGORY_ID` int(4) NOT NULL,
  PRIMARY KEY (`PRODUCT_ID`),
  KEY `MANUFACTURER` (`MANUFACTURER_ID`),
  KEY `CATEGORY` (`CATEGORY_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`PRODUCT_ID`, `NAME`, `MANUFACTURER_ID`, `UNIT_PRICE`, `CATEGORY_ID`) VALUES
('132XPS15', 'DELL XPS 13', '7760DELL00', 100000, 2840),
('1520XSM1', 'iPhone XS Max', '1520APPLE9', 100000, 1001),
('2451F1P0', 'OPPO F1 PLUS', '2451OPPO11', 35000, 1001),
('4131WDPS', 'WD PASSPORT 1TB HDD', '4131WD1222', 6000, 3458),
('44T2WDS', 'WD PASSPORT 4TB SSD', '4131WD1222', 9600, 3458),
('776XPS15', 'DELL XPS 15 9560', '7760DELL00', 160000, 2840),
('98ACERX1', 'ACER SWIFT X1', '98ACER4508', 75000, 2840),
('APHP121', 'APPLE HEADPHONES', '1520APPLE9', 9899, 1342),
('SAMG950U', 'SAMSUNG GALAXY S8', 'SAMGL42', 85000, 1001);

--
-- Triggers `product`
--
DROP TRIGGER IF EXISTS `stockInitialize`;
DELIMITER $$
CREATE TRIGGER `stockInitialize` AFTER INSERT ON `product` FOR EACH ROW BEGIN
	SET @prodID = NEW.PRODUCT_ID;
    SET @sc = '1BLORE0104';
	INSERT INTO stock VALUES (@prodID,@sc,0);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

DROP TABLE IF EXISTS `product_category`;
CREATE TABLE IF NOT EXISTS `product_category` (
  `CATEGORY_ID` int(4) NOT NULL,
  `CATEGORY_NAME` varchar(15) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`CATEGORY_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`CATEGORY_ID`, `CATEGORY_NAME`) VALUES
(1001, 'SMARTPHONES'),
(1201, 'SMARTWATCHES'),
(1342, 'HEADPHONES'),
(2840, 'LAPTOPS'),
(3458, 'STORAGEDRIVE');

-- --------------------------------------------------------

--
-- Table structure for table `shipping_center`
--

DROP TABLE IF EXISTS `shipping_center`;
CREATE TABLE IF NOT EXISTS `shipping_center` (
  `SHIPPING_CENTER_ID` varchar(10) COLLATE latin1_bin NOT NULL,
  `NAME` varchar(30) COLLATE latin1_bin NOT NULL,
  `ADDRESS` varchar(40) COLLATE latin1_bin NOT NULL,
  `PHONE` varchar(10) COLLATE latin1_bin NOT NULL,
  `MANAGER_ID` int(10) DEFAULT NULL,
  `PASSWORD` varchar(10) COLLATE latin1_bin NOT NULL,
  PRIMARY KEY (`SHIPPING_CENTER_ID`),
  KEY `manager_id` (`MANAGER_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

--
-- Dumping data for table `shipping_center`
--

INSERT INTO `shipping_center` (`SHIPPING_CENTER_ID`, `NAME`, `ADDRESS`, `PHONE`, `MANAGER_ID`, `PASSWORD`) VALUES
('1BLORE0104', 'KONI SHIPPING CENTER', '18 BASVANGUDI BANGALORE', '26602256', 5793834, '1bg16cs104');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

DROP TABLE IF EXISTS `stock`;
CREATE TABLE IF NOT EXISTS `stock` (
  `PRODUCT_ID` varchar(8) COLLATE latin1_bin NOT NULL,
  `SHIPPING_CENTER_ID` varchar(10) COLLATE latin1_bin NOT NULL,
  `NO_OF_UNITS` int(11) NOT NULL,
  PRIMARY KEY (`PRODUCT_ID`,`SHIPPING_CENTER_ID`),
  KEY `SHIPPING_CENTER_ID` (`SHIPPING_CENTER_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`PRODUCT_ID`, `SHIPPING_CENTER_ID`, `NO_OF_UNITS`) VALUES
('132XPS15', '1BLORE0104', 50),
('1520XSM1', '1BLORE0104', 73),
('2451F1P0', '1BLORE0104', 130),
('4131WDPS', '1BLORE0104', 24),
('44T2WDS', '1BLORE0104', 100),
('776XPS15', '1BLORE0104', 100),
('98ACERX1', '1BLORE0104', 78),
('APHP121', '1BLORE0104', 0),
('SAMG950U', '1BLORE0104', 100);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `CUSTOMER_ID` FOREIGN KEY (`CUSTOMER_ID`) REFERENCES `customer` (`CUSTOMER_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `SHIPPINGCENTERID` FOREIGN KEY (`SHIPPING_CENTER_ID`) REFERENCES `shipping_center` (`SHIPPING_CENTER_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_item`
--
ALTER TABLE `order_item`
  ADD CONSTRAINT `ORDERID` FOREIGN KEY (`ORDER_ID`) REFERENCES `orders` (`ORDER_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `PRODUCTID` FOREIGN KEY (`PRODUCT_ID`) REFERENCES `product` (`PRODUCT_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `CATEGORY` FOREIGN KEY (`CATEGORY_ID`) REFERENCES `product_category` (`CATEGORY_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `MANUFACTURER` FOREIGN KEY (`MANUFACTURER_ID`) REFERENCES `manufacturer` (`MANUFACTURER_ID`) ON DELETE CASCADE;

--
-- Constraints for table `shipping_center`
--
ALTER TABLE `shipping_center`
  ADD CONSTRAINT `manager_id` FOREIGN KEY (`MANAGER_ID`) REFERENCES `manager` (`MANAGER_ID`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `PRODUCT_ID` FOREIGN KEY (`PRODUCT_ID`) REFERENCES `product` (`PRODUCT_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `SHIPPING_CENTER_ID` FOREIGN KEY (`SHIPPING_CENTER_ID`) REFERENCES `shipping_center` (`SHIPPING_CENTER_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 06, 2022 at 10:36 PM
-- Server version: 5.7.18-log
-- PHP Version: 7.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db19970225`
--

-- --------------------------------------------------------

--
-- Table structure for table `discounts`
--

CREATE TABLE `discounts` (
  `discountId` int(11) NOT NULL,
  `code` varchar(10) COLLATE utf8_swedish_ci NOT NULL,
  `amount` int(11) NOT NULL,
  `isActive` int(11) NOT NULL,
  `isPercent` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Dumping data for table `discounts`
--

INSERT INTO `discounts` (`discountId`, `code`, `amount`, `isActive`, `isPercent`) VALUES
(1, 'GreatDeal', 20, 1, 1),
(2, 'YayYou', 25, 1, 0),
(3, 'ForTheWolf', 13, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `itemList`
--

CREATE TABLE `itemList` (
  `listId` int(11) NOT NULL,
  `orderId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Dumping data for table `itemList`
--

INSERT INTO `itemList` (`listId`, `orderId`, `userId`, `productId`, `amount`, `price`) VALUES
(1, 1, 2, 2, 3, 0),
(3, 1, 3, 1, 5, 0),
(4, 1, 3, 2, 1, 0),
(5, 2, 3, 2, 3, 0),
(6, 2, 3, 1, 2, 0),
(7, 1, 4, 1, 2, 0),
(8, 1, 4, 2, 1, 0),
(9, 2, 4, 1, 1, 0),
(10, 2, 4, 2, 3, 0),
(11, 3, 4, 1, 1, 0),
(12, 3, 4, 2, 3, 0),
(13, 3, 3, 1, 3, 0),
(14, 3, 3, 2, 2, 0),
(15, 4, 3, 1, 10, 0),
(16, 4, 3, 2, 4, 0),
(18, 1, 2, 3, 3, 0),
(22, 2, 2, 1, 3, 0),
(26, 3, 2, 3, 1, 0),
(29, 3, 2, 1, 8, 0),
(34, 5, 3, 1, 2, 0),
(35, 5, 3, 2, 2, 0),
(36, 5, 3, 3, 1, 0),
(37, 4, 2, 2, 1, 0),
(38, 4, 2, 1, 2, 0),
(39, 6, 3, 1, 4, 0),
(40, 6, 3, 2, 3, 0),
(41, 6, 3, 3, 3, 0),
(42, 5, 2, 2, 1, 0),
(43, 5, 2, 1, 1, 0),
(44, 6, 2, 1, 4, 0),
(45, 6, 2, 2, 7, 0),
(46, 6, 2, 3, 1, 0),
(47, 7, 2, 1, 4, 0),
(48, 1, 6, 1, 1, 0),
(49, 1, 6, 2, 1, 0),
(50, 7, 2, 2, 1, 0),
(56, 7, 3, 1, 3, 0),
(57, 7, 3, 2, 1, 0),
(58, 7, 3, 3, 1, 0),
(61, 8, 2, 1, 9, 0),
(62, 2, 6, 2, 2, 0),
(64, 8, 2, 2, 4, 0),
(67, 9, 2, 1, 555, 0),
(69, 2, 6, 3, 88, 0),
(71, 3, 6, 1, 1, 0),
(74, 4, 6, 1, 2, 0),
(75, 4, 6, 2, 2, 0),
(80, 5, 6, 1, 2, 0),
(81, 5, 6, 2, 2, 0),
(82, 10, 2, 1, 2, 0),
(83, 10, 2, 3, 1, 0),
(84, 10, 2, 2, 3, 0),
(85, 11, 2, 1, 1, 0),
(86, 12, 2, 1, 2, 0),
(87, 13, 2, 2, 1, 0),
(88, 14, 2, 2, 3, 0),
(89, 14, 2, 1, 3, 0),
(90, 15, 2, 3, 2, 0),
(91, 16, 2, 1, 2, 0),
(92, 17, 2, 1, 9, 0),
(93, 18, 2, 3, 0, 0),
(95, 18, 2, 2, 0, 0),
(96, 18, 2, 1, 0, 0),
(99, 21, 2, 1, 1, 0),
(102, 25, 2, 1, 1, 0),
(103, 27, 2, 1, 1, 0),
(105, 28, 2, 2, 240, 0),
(106, 29, 2, 3, 0, 0),
(107, 30, 2, 2, 2, 60),
(108, 31, 2, 2, 1, 0),
(109, 32, 2, 1, 1, 0),
(110, 33, 2, 2, 1, 0),
(111, 34, 2, 3, 0, 0),
(112, 35, 2, 3, 0, 0),
(113, 36, 2, 3, 0, 0),
(114, 37, 2, 3, 0, 0),
(115, 38, 2, 2, 1, 0),
(116, 39, 2, 3, 0, 0),
(117, 40, 2, 1, 1, 0),
(118, 42, 2, 2, 1, 0),
(119, 43, 2, 2, 1, 0),
(120, 44, 2, 2, 1, 0),
(121, 45, 2, 1, 1, 0),
(122, 46, 2, 3, 1, 0),
(123, 47, 2, 2, 1, 0),
(124, 48, 2, 1, 1, 0),
(125, 49, 2, 2, 1, 0),
(126, 50, 2, 1, 1, 0),
(127, 51, 2, 3, 1, 0),
(128, 52, 2, 1, 1, 0),
(129, 53, 2, 1, 1, 0),
(130, 54, 2, 2, 1, 0),
(131, 55, 2, 2, 1, 0),
(132, 56, 2, 3, 1, 0),
(133, 57, 2, 2, 1, 0),
(134, 58, 2, 2, 1, 0),
(135, 12, 2, 2, 1, 0),
(136, 1, 9, 1, 1, 0),
(137, 2, 9, 1, 1, 0),
(138, 3, 9, 2, 1, 0),
(139, 18, 2, 1, 1, 0),
(140, 18, 2, 1, 1, 0),
(142, 19, 2, 1, 0, 0),
(143, 20, 2, 1, 1, 0),
(144, 22, 2, 1, 1, 0),
(146, 23, 2, 1, 1, 0),
(147, 24, 2, 1, 1, 0),
(148, 26, 2, 1, 3, 0),
(149, 27, 2, 2, 1, 0),
(152, 28, 2, 3, 1, 0),
(154, 29, 2, 1, 1, 0),
(155, 29, 2, 2, 2, 0),
(156, 29, 2, 3, 1, 0),
(157, 30, 2, 1, 2, 12),
(158, 30, 2, 3, 1, 103),
(159, 30, 2, 4, 1, 10),
(160, 1, 10, 1, 2, 0),
(163, 3, 9, 7, 1, 0),
(164, 4, 9, 7, 1, 0),
(165, 5, 9, 3, 1, 0),
(166, 6, 9, 1, 1, 0),
(167, 6, 9, 2, 1, 0),
(168, 6, 9, 3, 1, 0),
(169, 7, 9, 1, 1, 0),
(170, 7, 9, 2, 1, 0),
(171, 7, 9, 3, 1, 0),
(172, 8, 9, 2, 1, 0),
(173, 8, 9, 1, 1, 0),
(174, 8, 9, 3, 1, 0),
(175, 8, 9, 5, 1, 0),
(176, 8, 9, 6, 1, 0),
(177, 2, 14, 1, 8, 65),
(178, 1, 14, 8, 2, 0),
(182, 1, 15, 9, 1, 45),
(183, 9, 9, 1, 4, 12),
(184, 9, 9, 3, 1, 103),
(185, 9, 9, 2, 1, 60);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `messageId` int(11) NOT NULL,
  `messageType` varchar(20) COLLATE utf8_swedish_ci NOT NULL,
  `sender` int(11) NOT NULL,
  `receiver` int(11) NOT NULL,
  `message` text COLLATE utf8_swedish_ci NOT NULL,
  `date` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `time` varchar(50) COLLATE utf8_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`messageId`, `messageType`, `sender`, `receiver`, `message`, `date`, `time`) VALUES
(1, 'alert', 1, 0, 'Due to [unspecifide virus] we are unabel to send products in time, pleas be patient', '2021-12-16', '16:10'),
(2, 'discount', 1, 9, 'Discount: ForTheWolf', '2021-12-16', '16:12');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orderId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `totalCost` int(11) NOT NULL,
  `adress` text COLLATE utf8_swedish_ci NOT NULL,
  `status` int(11) NOT NULL,
  `message` text COLLATE utf8_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orderId`, `userId`, `totalCost`, `adress`, `status`, `message`) VALUES
(1, 1, 1, '1', 1, 'Notice: it wil take time'),
(1, 2, 156, '', 2, '123456'),
(1, 6, 156, '', 2, 'apa1'),
(1, 9, 12, 'test', 1, ''),
(1, 10, 24, 'time 2', 2, ''),
(1, 14, 2071, 'Total 2096', 1, ' '),
(1, 15, 45, 'adress 1243', 1, ' '),
(2, 6, 156, '', 5, 'apa2'),
(2, 9, 12, 'tets', 2, ''),
(3, 2, 156, '', 1, ''),
(3, 6, 156, '', 1, 'korstroganoff'),
(3, 9, 0, 'd', 1, ''),
(4, 2, 156, 'Korvgatan 23', 1, ''),
(4, 9, 1, 'Mari4', 1, ' '),
(5, 9, 103, 'Mari5', 1, ' '),
(6, 2, 156, 'Korvgatan 23', 1, ''),
(6, 3, 156, 'MinVägrn', 1, ''),
(6, 9, 152, 'Mari11', 2, ' '),
(7, 2, 156, 'Korv 64', 1, 'hej det går att läsa medelandena nu'),
(7, 3, 156, 'Gata', 1, ''),
(7, 9, 152, 'ORG 175', 1, ' '),
(8, 2, 156, '', 1, ''),
(8, 9, 174, 'Total 217', 1, ' '),
(9, 2, 156, '', 1, ''),
(10, 2, 307, 'Funstreet', 1, ''),
(11, 2, 12, 's', 1, ''),
(12, 2, 84, 'test', 1, ''),
(13, 2, 60, 'tr', 1, ''),
(14, 2, 216, 'test', 1, ''),
(15, 2, 206, 'test', 1, ''),
(16, 2, 24, 'dess', 1, ''),
(17, 2, 108, 'Adress 12', 1, ''),
(18, 2, 24, 'Adress', 1, ''),
(19, 2, 12, 'Test', 1, ''),
(20, 2, 12, 'm', 1, ''),
(21, 2, 12, 'revera morning', 1, ''),
(22, 2, 12, 'asdfghjkl', 1, ''),
(23, 2, 0, 'test', 1, ''),
(24, 2, 10, 'Adress', 1, ''),
(25, 2, 12, 'Work will You', 1, ''),
(26, 2, 36, 'Work will You4', 1, ''),
(27, 2, 58, 'Work will You9', 1, 'One or more products where reduced as they are out of stock'),
(28, 2, 14503, 'dfg', 1, ''),
(29, 2, 235, 'tes', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `productId` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `price` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `info` text COLLATE utf8_swedish_ci NOT NULL,
  `content` text COLLATE utf8_swedish_ci NOT NULL,
  `image` text COLLATE utf8_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`productId`, `name`, `price`, `amount`, `info`, `content`, `image`) VALUES
(1, 'Red Ketchup', 12, 29, 'Red of joy and the color of perfection', 'Tomato', '/img/redKetchup.png'),
(2, 'Yellow', 60, 5507, 'Yellow like a fun fellow', 'yellow tomatos', 'img/gulKetchup.png'),
(3, 'Homemade Ketchup', 103, 677, '25 ml of the best', 'Great tomatos', 'https://recipe52.com/wp-content/uploads/2020/04/Homemade-Tomato-Ketchup-8-1.jpg'),
(4, 'green', 10, 30, 'just something, that is nice', 'green tomatos', 'https://editorial01.shutterstock.com/wm-preview-1500/8859028c/2ac65fd8/museum-of-failure-helsingborg-sweden-shutterstock-editorial-8859028c.jpg'),
(5, 'pink ketchup', 21, 11, 'pink with a taste of barbie, life in plastic is fantastic', 'NO PLASTIC, just tomatos and loove~', 'data:image/jpeg;base64,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'),
(6, 'white', 21, 11, 'no need to worry about your clothing wit this one', 'bleached tomatos, totally safe', 'https://thumbs.dreamstime.com/z/tomato-ketchup-bottle-white-vector-ketchup-product-container-red-sauce-food-illustration-tomato-ketchup-bottle-white-vector-140332070.jpg'),
(7, 'purpule ketchup', 1, 0, 'not for me, but great for a prank', 'foodcoloring, alot of foodcoloring', 'https://www.awesomeinventions.com/wp-content/uploads/2019/04/heinz-funky-purple-ez-squirt.jpg'),
(8, 'mystery flavor', 1000, 0, 'A lot, take it before its gone', 'unkown', 'http://cdn.shopify.com/s/files/1/0315/2173/4789/products/BlueKetchup_1024x.jpg?v=1614091139'),
(9, 'blue ketchup', 12, 4, 'its blue', 'blue tomatos', 'http://2.bp.blogspot.com/-A4RTJNbUAfA/UWB9bse-3tI/AAAAAAAACPc/yOk6JEW6ynA/s1600/blue.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `reviewId` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `reviewText` text COLLATE utf8_swedish_ci NOT NULL,
  `numStar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`reviewId`, `productId`, `userId`, `reviewText`, `numStar`) VALUES
(1, 1, 2, 'This one was really red and great!!\r\n10/10 would buy again!', 5),
(2, 1, 2, 'test text', 5),
(7, 1, 2, 'A soft taste unlike any other, reminds me of old memories that lay forgoten', 5),
(12, 2, 3, 'lIKE THE YELLOW', 5),
(20, 1, 2, '3/5 could be better', 3),
(21, 1, 2, 'Dont know whats so great about it', 1),
(22, 3, 2, 'Home made perfection', 4),
(23, 2, 2, 'YAY Great, I LOVE THIS', 5),
(24, 1, 2, 'meh', 2),
(25, 1, 2, 'yes', 4),
(26, 1, 2, 'test', 2),
(27, 1, 2, 'yay', 4),
(28, 7, 9, 'Its interesting...', 3),
(29, 4, 2, 'fdadgslhjfghn ery GOOD', 4),
(30, 1, 9, 'Hello Nice', 5),
(31, 2, 9, 'Hello Lovely', 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userId` int(11) NOT NULL,
  `orderId` int(11) DEFAULT NULL,
  `name` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `pwd` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `userType` varchar(20) COLLATE utf8_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `orderId`, `name`, `pwd`, `email`, `userType`) VALUES
(1, NULL, 'admin', 'admin', 'admin@bestshop.com', 'admin'),
(2, 30, 'member', 'member', 'member@member.com', 'member'),
(3, 8, 'me', 'meme', 'me@meme.com', 'member'),
(4, 4, 'majo', 'momo', 'momo@majo.com', 'member'),
(5, NULL, 'dis', 'dis', 'dis@dis.com', 'distributer'),
(6, 6, 'gustav', 'gustav', 'gustav@gustav.com', 'member'),
(7, 1, 'apa', 'apa', 'apa@apa.com', 'member'),
(8, 1, 'mat', 'mat', 'mat@mat.com', 'member'),
(9, 9, 'name', 'name', 'name@name.com', 'member'),
(10, 2, 'tim', 'tim', 'tim@tam.com', 'member'),
(14, 2, 'Person', 'me', 'namn@me.com', 'member'),
(15, 2, 'nemo', 'nemo', 'nemo@nemo.com', 'member');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `discounts`
--
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`discountId`);

--
-- Indexes for table `itemList`
--
ALTER TABLE `itemList`
  ADD PRIMARY KEY (`listId`),
  ADD KEY `userId` (`userId`),
  ADD KEY `orderId` (`orderId`),
  ADD KEY `productId` (`productId`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`messageId`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderId`,`userId`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`productId`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`reviewId`),
  ADD KEY `productId` (`productId`),
  ADD KEY `reviews_ibfk_2` (`userId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`),
  ADD KEY `cartId` (`orderId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `discounts`
--
ALTER TABLE `discounts`
  MODIFY `discountId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `itemList`
--
ALTER TABLE `itemList`
  MODIFY `listId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=186;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `messageId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `productId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `reviewId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `itemList`
--
ALTER TABLE `itemList`
  ADD CONSTRAINT `itemList_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`),
  ADD CONSTRAINT `itemList_ibfk_3` FOREIGN KEY (`productId`) REFERENCES `products` (`productId`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`productId`) REFERENCES `products` (`productId`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

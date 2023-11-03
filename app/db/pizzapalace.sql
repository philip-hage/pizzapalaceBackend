-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 31 okt 2023 om 16:31
-- Serverversie: 10.4.28-MariaDB
-- PHP-versie: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pizzapalace`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `customers`
--

CREATE TABLE `customers` (
  `customerId` varchar(4) NOT NULL,
  `customerFirstName` varchar(255) NOT NULL,
  `customerLastName` varchar(255) NOT NULL,
  `customerStreetName` varchar(255) NOT NULL,
  `customerZipcdoe` varchar(10) NOT NULL,
  `customerCity` varchar(50) NOT NULL,
  `customerEmail` varchar(255) NOT NULL,
  `customerPhone` varchar(255) NOT NULL,
  `customerType` enum('member','guest') NOT NULL,
  `customerIsActive` tinyint(1) NOT NULL DEFAULT 1,
  `customerCreateDate` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `customers`
--

INSERT INTO `customers` (`customerId`, `customerFirstName`, `customerLastName`, `customerStreetName`, `customerZipcdoe`, `customerCity`, `customerEmail`, `customerPhone`, `customerType`, `customerIsActive`, `customerCreateDate`) VALUES
('5423', 'Peter', 'Van de Vaart', '', '', '', 'peter@vandervaart.nl', '06817274', 'member', 1, 53253),
('5623', 'Je vader', 'Je moeder', '', '', '', 'flip@gmail.com', '068172323', 'member', 1, 532532);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `employees`
--

CREATE TABLE `employees` (
  `employeeId` varchar(4) NOT NULL,
  `employeeStoreId` varchar(4) NOT NULL,
  `employeeFirstName` varchar(255) NOT NULL,
  `employeeRole` enum('deliverer','chef','manager') NOT NULL,
  `employeeIsActive` tinyint(1) NOT NULL DEFAULT 1,
  `employeeCreateDate` int(10) NOT NULL,
  `employeeDescritption` text DEFAULT NULL,
  `employeeLastName` varchar(255) NOT NULL,
  `employeeStreetName` varchar(255) NOT NULL,
  `employeeZipCode` varchar(10) NOT NULL,
  `employeeCity` varchar(255) NOT NULL,
  `employeePhone` varchar(10) NOT NULL,
  `employeeEmail` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ingredients`
--

CREATE TABLE `ingredients` (
  `ingredientId` varchar(4) NOT NULL,
  `ingredientName` varchar(255) NOT NULL,
  `ingredientPrice` decimal(2,2) NOT NULL,
  `ingredientIsActive` tinyint(1) NOT NULL DEFAULT 1,
  `ingredientCreateDate` int(10) NOT NULL,
  `ingredientDescription` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `orderhasproducts`
--

CREATE TABLE `orderhasproducts` (
  `orderId` varchar(4) NOT NULL,
  `productId` varchar(4) NOT NULL,
  `productPrice` decimal(2,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `orders`
--

CREATE TABLE `orders` (
  `orderId` varchar(4) NOT NULL,
  `orderStoreId` varchar(4) NOT NULL,
  `orderCustomerId` varchar(4) NOT NULL,
  `orderState` varchar(255) NOT NULL,
  `orderStatus` enum('success','pending','failed','') NOT NULL,
  `orderPrice` decimal(2,2) NOT NULL,
  `orderCreateDate` int(10) NOT NULL,
  `orderDescription` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `orders`
--

INSERT INTO `orders` (`orderId`, `orderStoreId`, `orderCustomerId`, `orderState`, `orderStatus`, `orderPrice`, `orderCreateDate`, `orderDescription`) VALUES
('4321', '5342', '5623', 'Kutje', 'success', 0.99, 42423, NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `producthasingredients`
--

CREATE TABLE `producthasingredients` (
  `ingredientId` varchar(4) NOT NULL,
  `productId` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `products`
--

CREATE TABLE `products` (
  `productId` varchar(4) NOT NULL,
  `productOwner` varchar(4) DEFAULT NULL,
  `productName` varchar(255) NOT NULL,
  `productPrice` decimal(6,2) NOT NULL,
  `productType` enum('pizza','drink','coupon','snack','custompizza') NOT NULL,
  `productPath` varchar(255) NOT NULL,
  `productIsActive` tinyint(1) NOT NULL DEFAULT 1,
  `productCreateDate` int(10) NOT NULL,
  `productDescription` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `products`
--

INSERT INTO `products` (`productId`, `productOwner`, `productName`, `productPrice`, `productType`, `productPath`, `productIsActive`, `productCreateDate`, `productDescription`) VALUES
('2332', NULL, 'Cola', 3.20, 'drink', 'public/img/coca_cola-8085.png', 1, 532352, NULL),
('3812', NULL, 'Pizza Zwarte Truffel', 6.20, 'pizza', 'public/img/Zwarte_Truffel-9551.jpg', 1, 523352335, NULL),
('4242', NULL, 'Pizza 4 Cheese', 8.20, 'pizza', 'public/img/4_cheese-8013.png', 1, 523253, NULL),
('5253', NULL, 'Pizza BBQ', 8.20, 'pizza', 'public/img/BBQ-9473.jpg', 1, 5232352, NULL),
('532s', NULL, 'Loaded Nachos Chicken', 8.99, 'snack', 'public/img/Loaded_Nachos_Grilled_Chicken-9368.jpg', 1, 423523, NULL),
('5435', NULL, 'Cola Zero', 5.20, 'drink', 'public/img/zero-8081.png', 1, 52552, NULL),
('fds2', NULL, 'Pizza Margheritta', 10.20, 'pizza', 'public/img/Margherita-7711.jpg', 1, 3523521, NULL),
('ff23', NULL, 'Crispy Chicken Tenders', 12.20, 'snack', 'public/img/Chicken_tenders-9385.jpg', 1, 5325323, NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `promotions`
--

CREATE TABLE `promotions` (
  `promotionId` varchar(4) NOT NULL,
  `promotionName` varchar(255) NOT NULL,
  `promotionStartDate` varchar(255) NOT NULL,
  `promotionEndDate` varchar(255) NOT NULL,
  `promotionIsActive` tinyint(1) NOT NULL DEFAULT 1,
  `promotionCreateDate``` int(10) NOT NULL,
  `promotionDescription` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `promotions`
--

INSERT INTO `promotions` (`promotionId`, `promotionName`, `promotionStartDate`, `promotionEndDate`, `promotionIsActive`, `promotionCreateDate```, `promotionDescription`) VALUES
('5231', 'Promotion 2', '23253253', '52352323', 1, 5232523, NULL),
('5322', 'Promotion 1', '2532322', '235235', 1, 423342, NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `reviews`
--

CREATE TABLE `reviews` (
  `reviewId` varchar(4) NOT NULL,
  `reviewCustomerId` varchar(4) NOT NULL,
  `reviewEntityId` varchar(4) NOT NULL,
  `reviewRating` int(3) NOT NULL,
  `reviewIsActive` tinyint(1) NOT NULL DEFAULT 1,
  `reviewCreateDate` int(10) NOT NULL,
  `reviewDescription` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `reviews`
--

INSERT INTO `reviews` (`reviewId`, `reviewCustomerId`, `reviewEntityId`, `reviewRating`, `reviewIsActive`, `reviewCreateDate`, `reviewDescription`) VALUES
('6346', '5423', '4321', 2, 1, 523523, NULL),
('fsd2', '5623', '4321', 4, 1, 523532, NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `screens`
--

CREATE TABLE `screens` (
  `screenId` varchar(4) NOT NULL,
  `screenEntityId` varchar(4) NOT NULL,
  `screenCreateDate` int(10) NOT NULL,
  `screenIsActive` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `stores`
--

CREATE TABLE `stores` (
  `storeId` varchar(4) NOT NULL,
  `storeManagerId` varchar(4) NOT NULL,
  `storeName` varchar(255) NOT NULL,
  `storeZipcode` varchar(255) NOT NULL,
  `storeStreetName` varchar(255) NOT NULL,
  `storeCity` varchar(255) NOT NULL,
  `storePhone` varchar(10) NOT NULL,
  `storeEmail` varchar(255) NOT NULL,
  `storeIsActive` tinyint(1) NOT NULL DEFAULT 1,
  `storeCreateDate` int(10) NOT NULL,
  `storeDescription` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `stores`
--

INSERT INTO `stores` (`storeId`, `storeManagerId`, `storeName`, `storeZipcode`, `storeStreetName`, `storeCity`, `storePhone`, `storeEmail`, `storeIsActive`, `storeCreateDate`, `storeDescription`) VALUES
('5342', '', 'Kanus', '3992BJ', '', '', '', '', 1, 5235, NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `vehicles`
--

CREATE TABLE `vehicles` (
  `vehicleId` varchar(4) NOT NULL,
  `vehicleStoreId` varchar(4) NOT NULL,
  `vehicleType` enum('bike','car','scooter') NOT NULL,
  `vehicleIsActive` tinyint(1) NOT NULL DEFAULT 1,
  `vehicleCreateDate` int(10) NOT NULL,
  `VehicleMaintenanceDate` int(10) NOT NULL,
  `vehicleDescription` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customerId`);

--
-- Indexen voor tabel `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employeeId`),
  ADD KEY `employeeStoreId` (`employeeStoreId`);

--
-- Indexen voor tabel `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`ingredientId`);

--
-- Indexen voor tabel `orderhasproducts`
--
ALTER TABLE `orderhasproducts`
  ADD PRIMARY KEY (`orderId`,`productId`),
  ADD KEY `productId` (`productId`);

--
-- Indexen voor tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderId`),
  ADD KEY `orderCustomerId` (`orderCustomerId`),
  ADD KEY `orderStoreId` (`orderStoreId`);

--
-- Indexen voor tabel `producthasingredients`
--
ALTER TABLE `producthasingredients`
  ADD PRIMARY KEY (`ingredientId`,`productId`),
  ADD KEY `productId` (`productId`);

--
-- Indexen voor tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`productId`);

--
-- Indexen voor tabel `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`promotionId`);

--
-- Indexen voor tabel `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`reviewId`),
  ADD KEY `reviewOrderId` (`reviewEntityId`),
  ADD KEY `reviewCustomerId` (`reviewCustomerId`);

--
-- Indexen voor tabel `screens`
--
ALTER TABLE `screens`
  ADD PRIMARY KEY (`screenId`);

--
-- Indexen voor tabel `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`storeId`);

--
-- Indexen voor tabel `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`vehicleId`),
  ADD KEY `vehicleStoreId` (`vehicleStoreId`);

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`employeeStoreId`) REFERENCES `stores` (`storeId`);

--
-- Beperkingen voor tabel `orderhasproducts`
--
ALTER TABLE `orderhasproducts`
  ADD CONSTRAINT `orderhasproducts_ibfk_1` FOREIGN KEY (`orderId`) REFERENCES `orders` (`orderId`),
  ADD CONSTRAINT `orderhasproducts_ibfk_2` FOREIGN KEY (`productId`) REFERENCES `products` (`productId`);

--
-- Beperkingen voor tabel `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`orderCustomerId`) REFERENCES `customers` (`customerId`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`orderStoreId`) REFERENCES `stores` (`storeId`);

--
-- Beperkingen voor tabel `producthasingredients`
--
ALTER TABLE `producthasingredients`
  ADD CONSTRAINT `producthasingredients_ibfk_1` FOREIGN KEY (`ingredientId`) REFERENCES `ingredients` (`ingredientId`),
  ADD CONSTRAINT `producthasingredients_ibfk_2` FOREIGN KEY (`productId`) REFERENCES `products` (`productId`);

--
-- Beperkingen voor tabel `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`reviewCustomerId`) REFERENCES `customers` (`customerId`);

--
-- Beperkingen voor tabel `vehicles`
--
ALTER TABLE `vehicles`
  ADD CONSTRAINT `vehicles_ibfk_1` FOREIGN KEY (`vehicleStoreId`) REFERENCES `vehicles` (`vehicleId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

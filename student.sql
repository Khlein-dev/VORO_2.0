-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 01, 2025 at 02:29 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `student`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `email` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `id` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`email`, `password`, `id`) VALUES
('admin@gmail.com', '$2y$10$iyMM7qcy8FXpcOtTUnv76epILByMo1a9YDz69aQkN/QnYspGvwyzi', 1),
('mavi@gmail.com', '$2y$10$B.x8h0j31yEVj5KHofCOlOwRLJNiY4iDy7WqpSzCq5vbY/1l2BUAS', 2);

-- --------------------------------------------------------

--
-- Table structure for table `exam`
--

CREATE TABLE `exam` (
  `exam_date` date NOT NULL,
  `email` varchar(256) NOT NULL,
  `score` int(100) NOT NULL,
  `remark` varchar(20) NOT NULL,
  `password` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam`
--

INSERT INTO `exam` (`exam_date`, `email`, `score`, `remark`, `password`) VALUES
('2025-06-30', 'black@gmail.com', 9, 'Passed', '$2y$10$kQmxQ4LRawtVCCs7.0XIc.lniV7NyY8rkotfcwemSpw6tYW82EQwq'),
('2025-06-26', 'blue@gmail.com', 7, 'Passed', '$2y$10$G7X1qMauyo7glnXSA8C.AebvtWxYUsLqVE6ZpeFKL4UqeTvuL5z8K'),
('2025-06-30', 'brown@gmail.com', 1, 'Failed', '$2y$10$DXTyMHFdGmh21MspG.CTQeM8u5s4b6D8E/E8N9vfzMfJ9Ldtd.o..'),
('2025-06-26', 'green@gmail.com', 3, 'Failed', '$2y$10$ybtqDXPheWs.aFhDvZ0.1OJxkc9/gESI3hEq7dvIxuUvkm0VSLV/u'),
('2025-06-30', 'orange@gmail.com', 5, 'Failed', '$2y$10$u1Tj3KXh9p.GTMAU3yFYPOQt7AgAI9nDKUitAdCsxLI26tnrpBFsS'),
('2025-06-30', 'pink@gmail.com', 3, 'Failed', '$2y$10$sI6E7AwM/FX1GRVtQJ8gD.Wzb.1mUZ/.ChuiaMCjU.LhTchQ1M6uq'),
('2025-06-26', 'red@gmail.com', 5, 'Failed', '$2y$10$6Wye1ZhgLKEjg6dNBR0knOKJAzvCRn8pbAk3M1J4nuqTKhuvAHlHW'),
('2025-06-30', 'violet@gmail.com', 9, 'Passed', '$2y$10$.8Jv5E.I3VAmd.2sZXL8d.QUIxYK0kx.pRQpzCNzTNfh440l67IUm'),
('2025-06-30', 'white@gmail.com', 9, 'Passed', '$2y$10$JSSPPei.1fTFGRRo8/psBOeLytSw.AbV0vbeudF9ARQm88qR8lyAS'),
('2025-06-26', 'yellow@gmail.com', 2, 'Failed', '$2y$10$FqBVagw3f0sNHNIaMQP..e9A5jyuNVwjVr3ILFtbFRLQMA24SlIhO');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_date` date NOT NULL,
  `email` varchar(256) NOT NULL,
  `item` varchar(100) NOT NULL,
  `cost` int(5) NOT NULL,
  `quantity` int(5) NOT NULL,
  `amount` int(10) NOT NULL,
  `password` varchar(256) NOT NULL,
  `image` varchar(100) NOT NULL,
  `id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_date`, `email`, `item`, `cost`, `quantity`, `amount`, `password`, `image`, `id`) VALUES
('2025-06-29', 'red@gmail.com', 'Air Jordan', 6395, 3, 19185, '$2y$10$cdORUDXEHDHe8RCao70vyugvWTbO7aWZlECX1zksQ97k4ZnE4d23m', '\r\n                        order/n1.png                    \r\n                    ', 51),
('2025-06-29', 'red@gmail.com', 'Air Max Sneakers', 10895, 5, 54475, '$2y$10$cdORUDXEHDHe8RCao70vyugvWTbO7aWZlECX1zksQ97k4ZnE4d23m', '\r\n                        order/n2.png                    \r\n                    ', 52),
('2025-06-29', 'red@gmail.com', 'Adidas Stan Smith', 3600, 4, 14400, '$2y$10$cdORUDXEHDHe8RCao70vyugvWTbO7aWZlECX1zksQ97k4ZnE4d23m', '\r\n                        order/a3.png                    \r\n                    ', 53),
('2025-06-29', 'blue@gmail.com', 'Sneakers Skate', 3895, 3, 11685, '$2y$10$0KjQ2vnr8PBXXXQhjkrsZ.HjNuFMSua/M9cJ4jy2Q7F8ERjdsprky', '\r\n                        order/n3.png                    \r\n                    ', 55),
('2025-06-29', 'blue@gmail.com', 'Yeezy Boost', 26995, 4, 107980, '$2y$10$0KjQ2vnr8PBXXXQhjkrsZ.HjNuFMSua/M9cJ4jy2Q7F8ERjdsprky', '\r\n                        order/a1.png                    \r\n                    ', 56),
('2025-06-29', 'blue@gmail.com', 'PUMA basketball shoes', 7900, 4, 31600, '$2y$10$0KjQ2vnr8PBXXXQhjkrsZ.HjNuFMSua/M9cJ4jy2Q7F8ERjdsprky', '\r\n                        order/p1.png                    \r\n                    ', 57),
('2025-06-29', 'blue@gmail.com', 'Puma Shoe Fenty Beauty', 5900, 3, 17700, '$2y$10$0KjQ2vnr8PBXXXQhjkrsZ.HjNuFMSua/M9cJ4jy2Q7F8ERjdsprky', '\r\n                        order/p2.png                    \r\n                    ', 58),
('2025-06-29', 'blue@gmail.com', 'Adidas Stan Smith', 3600, 3, 10800, '$2y$10$0KjQ2vnr8PBXXXQhjkrsZ.HjNuFMSua/M9cJ4jy2Q7F8ERjdsprky', '\r\n                        order/a3.png                    \r\n                    ', 59),
('2025-06-30', 'jami@gmail.com', 'Air Jordan', 6395, 1, 6395, '$2y$10$WOqr3N.KevW5gtFmSUkkn.NRBBJhVOq/yAI8QizRSNrQ3DRypY/fe', '\r\n                        order/n1.png                    \r\n                    ', 61),
('2025-06-30', 'jami@gmail.com', 'Adidas Originals Sneakers', 15000, 1, 15000, '$2y$10$WOqr3N.KevW5gtFmSUkkn.NRBBJhVOq/yAI8QizRSNrQ3DRypY/fe', '\r\n                        order/a2.png                    \r\n                    ', 62),
('2025-06-30', 'jami@gmail.com', 'Suede XL Sneakers', 6642, 3, 19926, '$2y$10$WOqr3N.KevW5gtFmSUkkn.NRBBJhVOq/yAI8QizRSNrQ3DRypY/fe', '\r\n                        order/p3.png                    \r\n                    ', 63);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam`
--
ALTER TABLE `exam`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

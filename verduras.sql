-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2025 at 21:51 PM
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
-- Database: `verduleria`
--

-- --------------------------------------------------------

--
-- Table structure for table `verduras`
--

CREATE TABLE `verduras` (
  `id` int(11) NOT NULL,
  `nombre` varchar(64) NOT NULL,
  `descripción` varchar(256) NOT NULL,
  `precio` int(11) NOT NULL,
  `es_nuevo` tinyint(1) NOT NULL,
  `es_oferta` tinyint(1) NOT NULL,
  `es_popular` tinyint(1) NOT NULL,
  `unidad_medida` varchar(32) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `verduras`
--

INSERT INTO `verduras` (`id`, `nombre`, `descripción`, `precio`, `es_nuevo`, `es_oferta`, `es_popular`, `unidad_medida`, `cantidad`) VALUES
(1, 'Zanahoria', 'Dulces y crujientes, llenas de vitaminas.', 500, 0, 0, 1, 'kg', 3),
(2, 'Rábano', 'Ricos y deliciosos rábanos para tus comidas favoritas.', 600, 1, 1, 0, 'kg', 3),
(4, 'Puerro', 'Excelentes y frescos puerros de sabor intenso y delicioso aroma.', 650, 0, 0, 0, 'kg', 3),
(5, 'Repollo', 'Sabrosos repollos para tus ensaladas y preparaciones caseras.', 2000, 0, 0, 1, 'unidad', 3),
(6, 'Tomate', 'Dulces y jugosos tomates para todas tus comidas y ensaladas.', 2290, 0, 0, 0, 'kg', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `verduras`
--
ALTER TABLE `verduras`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `verduras`
--
ALTER TABLE `verduras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

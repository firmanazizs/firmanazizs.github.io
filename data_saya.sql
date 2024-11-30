-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 20, 2024 at 02:36 PM
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
-- Database: `data_saya`
--

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(255) UNSIGNED NOT NULL,
  `menu_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `kategori` enum('Makanan','Cemilan','Minuman') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `menu_name`, `price`, `image`, `kategori`) VALUES
(7, 'Nasi Goreng', 23000.00, 'daftar_menu/1nasi_goreng.jpg', 'Makanan'),
(8, 'Spaghetti Bolognese', 35000.00, 'daftar_menu/1spaghetti_bolognese.jpg', 'Makanan'),
(9, 'Chicken Cheese', 25000.00, 'daftar_menu/1chicken_cheese.jpg', 'Makanan'),
(10, 'Kari Ayam', 28000.00, 'daftar_menu/1kari_ayam.jpg', 'Makanan'),
(11, 'Ramen Katsu', 28000.00, 'daftar_menu/1ramen_katsu.jpg', 'Makanan'),
(12, 'Sate Ayam', 35000.00, 'daftar_menu/1sate_ayam.jpg', 'Makanan'),
(13, 'Fish And Chips', 24000.00, 'daftar_menu/1fish_and_chips.jpg', 'Makanan'),
(14, 'Steak Sapi', 50000.00, 'daftar_menu/1steak_sapi.jpg', 'Makanan'),
(15, 'Cheese  Burger', 23000.00, 'daftar_menu/2cheese_burger.jpg', 'Cemilan'),
(16, 'Croissant', 15000.00, 'daftar_menu/2croissant.jpg', 'Cemilan'),
(17, 'Dimsum Mentai', 23000.00, 'daftar_menu/2dimsum_mentai.jpg', 'Cemilan'),
(18, 'Onion Ring', 15000.00, 'daftar_menu/2onion_ring.jpg', 'Cemilan'),
(19, 'Potato Stick', 12000.00, 'daftar_menu/2potato_stick.jpg', 'Cemilan'),
(20, 'Roti Bakar', 12000.00, 'daftar_menu/2roti_bakar.jpg', 'Cemilan'),
(21, 'Waffle', 18000.00, 'daftar_menu/2waffle.jpg', 'Cemilan'),
(22, 'Zuppa  Soup', 20000.00, 'daftar_menu/2zuppa_soup.jpg', 'Cemilan'),
(23, 'Air Mineral', 5000.00, 'daftar_menu/3air_mineral.jpg', 'Minuman'),
(24, 'Americano', 23000.00, 'daftar_menu/3americano.jpg', 'Minuman'),
(25, 'Caffe Latte', 25000.00, 'daftar_menu/3caffe_latte.jpg', 'Minuman'),
(26, 'Cappucino', 25000.00, 'daftar_menu/3cappucino.jpg', 'Minuman'),
(27, 'Chocolate Boba', 22000.00, 'daftar_menu/3chocolate_boba.jpg', 'Minuman'),
(28, 'Espresso', 23000.00, 'daftar_menu/3espresso.jpg', 'Minuman'),
(29, 'Lemon Tea', 16000.00, 'daftar_menu/3lemon_tea.jpg', 'Minuman'),
(30, 'Matcha  Latte', 23000.00, 'daftar_menu/3matcha_latte.jpg', 'Minuman'),
(31, 'Mocha', 23000.00, 'daftar_menu/3mocha.jpg', 'Minuman'),
(32, 'Soda Gembira', 18000.00, 'daftar_menu/3soda_gembira.jpg', 'Minuman'),
(33, 'Strawberry Milk', 20000.00, 'daftar_menu/3strawberry_milk.jpg', 'Minuman'),
(34, 'Thai Tea', 18000.00, 'daftar_menu/3thai_tea.jpg', 'Minuman');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(255) UNSIGNED NOT NULL,
  `user_id` int(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `struk_id` varchar(255) NOT NULL,
  `menu_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `quantity` int(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `order_date` datetime NOT NULL DEFAULT current_timestamp(),
  `payment_method` varchar(100) NOT NULL,
  `seat_number` varchar(255) NOT NULL,
  `pesan` varchar(255) NOT NULL,
  `bukti_pembayaran` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `user_id`, `username`, `struk_id`, `menu_name`, `quantity`, `price`, `total`, `order_date`, `payment_method`, `seat_number`, `pesan`, `bukti_pembayaran`) VALUES
(120, 2, 'contoh', 'struk_673d8799d9c562.47886123', 'Steak Sapi', 1, 50000.00, 50000.00, '2024-11-20 07:54:17', 'DANA', '', '', 'uploads/Screenshot (113).png'),
(121, 2, 'contoh', 'struk_673d8799d9c562.47886123', 'Cappucino', 1, 25000.00, 25000.00, '2024-11-20 07:54:17', 'DANA', '', '', 'uploads/Screenshot (113).png'),
(122, 2, 'contoh', 'struk_673d8799d9c562.47886123', 'Nasi Goreng', 1, 23000.00, 23000.00, '2024-11-20 07:54:17', 'DANA', '', '', 'uploads/Screenshot (113).png'),
(123, 2, 'contoh', 'struk_673d8826abc697.73165533', 'Chicken Cheese', 1, 25000.00, 25000.00, '2024-11-20 07:56:38', 'DANA', '', '', 'uploads/Screenshot (2).png'),
(124, 2, 'contoh', 'struk_673d8826abc697.73165533', 'Croissant', 10, 15000.00, 150000.00, '2024-11-20 07:56:38', 'DANA', '', '', 'uploads/Screenshot (2).png'),
(125, 2, 'contoh', 'struk_673d8826abc697.73165533', 'Dimsum Mentai', 1, 23000.00, 23000.00, '2024-11-20 07:56:38', 'DANA', '', '', 'uploads/Screenshot (2).png'),
(126, 2, 'contoh', 'struk_673d8826abc697.73165533', 'Steak Sapi', 1, 50000.00, 50000.00, '2024-11-20 07:56:38', 'DANA', '', '', 'uploads/Screenshot (2).png'),
(127, 2, 'contoh', 'struk_673d8826abc697.73165533', 'Waffle', 1, 18000.00, 18000.00, '2024-11-20 07:56:38', 'DANA', '', '', 'uploads/Screenshot (2).png'),
(128, 2, 'contoh', 'struk_673d88cbd40999.05634356', 'Croissant', 1, 15000.00, 15000.00, '2024-11-20 07:59:23', 'DANA', '', '', 'uploads/Screenshot (1).png'),
(129, 2, 'contoh', 'struk_673d88cbd40999.05634356', 'Cheese  Burger', 1, 23000.00, 23000.00, '2024-11-20 07:59:23', 'DANA', '', '', 'uploads/Screenshot (1).png'),
(130, 2, 'contoh', 'struk_673d88cbd40999.05634356', 'Lemon Tea', 1, 16000.00, 16000.00, '2024-11-20 07:59:23', 'DANA', '', '', 'uploads/Screenshot (1).png'),
(131, 2, 'contoh', 'struk_673d8b816678a4.86336373', 'Chicken Cheese', 1, 25000.00, 25000.00, '2024-11-20 08:10:57', 'DANA', '', '', 'uploads/Screenshot (6).png'),
(132, 0, 'aziz', 'struk_673d8d27c78db0.20766321', 'Sate Ayam', 10, 35000.00, 350000.00, '2024-11-20 08:17:59', 'DANA', '4', '', 'uploads/Screenshot (7).png'),
(133, 0, 'aziz', 'struk_673d8d27c78db0.20766321', 'Nasi Goreng', 1, 23000.00, 23000.00, '2024-11-20 08:17:59', 'DANA', '4', '', 'uploads/Screenshot (7).png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(2, 'contoh', 'contoh@gmail.com', '202cb962ac59075b964b07152d234b70', 'user', '2024-11-04 17:40:36'),
(3, 'contoh2', 'contoh2@gmail.com', '202cb962ac59075b964b07152d234b70', 'admin', '2024-11-04 17:40:36'),
(4, 'esteh', 'firmanaziz2005@gmail.com', '202cb962ac59075b964b07152d234b70', 'user', '2024-11-04 18:11:20'),
(5, 'babeh', 'babehmadura@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'user', '2024-11-06 06:06:09'),
(6, 'petualang', 'petualangandora@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'user', '2024-11-10 13:21:52'),
(7, 'contoh3', 'contoh3@gmail.com', '202cb962ac59075b964b07152d234b70', 'user', '2024-11-13 06:49:27'),
(8, 'aziz', 'aziz@gmail.com', '202cb962ac59075b964b07152d234b70', 'user', '2024-11-20 07:17:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

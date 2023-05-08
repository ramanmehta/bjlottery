-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 22, 2023 at 11:47 PM
-- Server version: 8.0.32-0ubuntu0.22.04.2
-- PHP Version: 8.1.2-1ubuntu2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bjlottery`
--

-- --------------------------------------------------------

--
-- Table structure for table `lucky_draw_games`
--

CREATE TABLE `lucky_draw_games` (
  `id` bigint UNSIGNED NOT NULL,
  `game_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `game_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `game_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `winning_prize_amount` double NOT NULL,
  `min_point` int NOT NULL,
  `max_point` int NOT NULL,
  `start_date_time` datetime NOT NULL,
  `end_date_time` datetime NOT NULL,
  `status` tinyint NOT NULL,
  `game_point` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lucky_draw_games`
--

INSERT INTO `lucky_draw_games` (`id`, `game_title`, `game_description`, `game_image`, `winning_prize_amount`, `min_point`, `max_point`, `start_date_time`, `end_date_time`, `status`, `game_point`, `created_at`, `updated_at`) VALUES
(1, 'Wed Draw', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempora voluptatem assumenda quisquam repudiandae quae inventore, ipsam molestias, fugit saepe ipsum similique, nesciunt dolores error iste! Soluta ut laboriosam esse minus?', '/abc/def', 1000, 100, 600, '2023-03-22 18:35:42', '2023-03-30 18:35:42', 1, 600, NULL, NULL),
(4, 'April23', 'It is a long established fact that a reader will be distracted by the \r\nreadable content of a page when looking at its layout. The point of \r\nusing Lorem Ipsum is that it has a more-or-less normal distribution of \r\nletters, as opposed to using \'Content here, content here\', making it \r\nlook like readable English.', NULL, 9999999, 120, 1200, '2023-03-23 00:00:00', '2023-03-25 00:00:00', 0, 800, '2023-03-22 08:56:32', '2023-03-22 12:39:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lucky_draw_games`
--
ALTER TABLE `lucky_draw_games`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lucky_draw_games`
--
ALTER TABLE `lucky_draw_games`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

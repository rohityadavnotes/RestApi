-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 25, 2021 at 01:23 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id14853975_restapi`
--

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `uploadedByName` int(250) DEFAULT NULL,
  `fileName` int(250) DEFAULT NULL,
  `filePath` int(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset`
--

CREATE TABLE `password_reset` (
  `id` int(11) NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `otp` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `otpCreateTime` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `token` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `password_reset`
--

INSERT INTO `password_reset` (`id`, `email`, `otp`, `otpCreateTime`, `token`) VALUES
(9, 'rohitnotes24@gmail.com', '335343', '05:38:21', '1197cf6282df0b75cd561006cdd61ead'),
(11, 'iamrohityadav24@gmail.com', '459355', '06:38:58', 'fb01d35eca648fa65da1c84d53caeffd');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(15) NOT NULL,
  `provider` enum('app','google','facebook','twitter','linkedin') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'app',
  `socialId` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `picture` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `firstName` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastName` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL,
  `countryCode` varchar(10) COLLATE utf8_unicode_ci DEFAULT '91',
  `phoneNumber` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phoneNumberVerified` int(1) NOT NULL DEFAULT 0,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `emailVerified` int(1) NOT NULL DEFAULT 0,
  `password` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fcmToken` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastLogIn` datetime NOT NULL DEFAULT current_timestamp(),
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  `expiredAt` datetime NOT NULL DEFAULT current_timestamp(),
  `accountVerifiedByAdmin` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `provider`, `socialId`, `picture`, `firstName`, `lastName`, `gender`, `countryCode`, `phoneNumber`, `phoneNumberVerified`, `email`, `emailVerified`, `password`, `fcmToken`, `lastLogIn`, `createdAt`, `updatedAt`, `expiredAt`, `accountVerifiedByAdmin`) VALUES
(22, 'app', NULL, 'https://backend24.000webhostapp.com/RestApi/uploaded/a6bb786c3d87c954d67fd882afdcac93374d8a50.png', 'Rohit', 'Yadav', 'MALE', '91', '7898680304', 1, 'iamrohityadav24@gmail.com', 1, 'new', 'SHvX4JuGQciR9lv7q', '2021-02-25 18:37:29', '2021-02-25 18:09:09', '2021-02-25 18:40:19', '2021-02-25 18:09:09', 1),
(23, 'app', NULL, 'https://backend24.000webhostapp.com/RestApi/uploaded/82c7ed190656d4841c089959068d3041d7c42a36.png', 'Wilson', 'Bell', 'MALE', '93', '7898680304', 1, 'bell@gmail.com', 1, 'password', 'SHvX4JuGQciR9lv7q', '2021-02-25 18:10:23', '2021-02-25 18:10:23', '2021-02-25 18:10:23', '2021-02-25 18:10:23', 1),
(24, 'app', NULL, 'https://backend24.000webhostapp.com/RestApi/uploaded/42a9605d8bf718f6f571857657937b441c962687.png', 'Kayla', 'Wright', 'MALE', '33', '7898680304', 1, 'wright@gmail.com', 1, '123456', '5FASHvX4JuGQciR9lv7q', '2021-02-25 18:11:15', '2021-02-25 18:11:15', '2021-02-25 18:11:15', '2021-02-25 18:11:15', 1),
(25, 'app', NULL, 'https://backend24.000webhostapp.com/RestApi/uploaded/424bb080ad44d4c503281f5c6527b7d400d14e89.png', 'Penny', 'griffith', 'MALE', '44', '7898680304', 1, 'griffith@gmail.com', 1, 'griffith', 'ceadaosjdofihaioshdfn', '2021-02-25 18:12:15', '2021-02-25 18:12:15', '2021-02-25 18:12:15', '2021-02-25 18:12:15', 1),
(26, 'app', NULL, 'https://backend24.000webhostapp.com/RestApi/uploaded/08e9358bb45f195855a164f70d4ef324b37b308f.png', 'Martin', 'Carson', 'MALE', '44', '7898680304', 1, 'carson@gmail.com', 1, 'carson_24', 'B818x55FASHvX4JuGQciR9lv7q', '2021-02-25 18:13:20', '2021-02-25 18:13:20', '2021-02-25 18:13:20', '2021-02-25 18:13:20', 1),
(27, 'app', NULL, 'https://backend24.000webhostapp.com/RestApi/uploaded/b430f0f54c41434bd229638bc445495807fe53e1.png', 'Kevin', 'Wood', 'MALE', '22', '7898680304', 1, 'wood@gmail.com', 1, 'wood_24', 'B818x55FASHvX4JuGQciR9lv7q', '2021-02-25 18:14:03', '2021-02-25 18:14:03', '2021-02-25 18:14:03', '2021-02-25 18:14:03', 1),
(28, 'app', NULL, 'https://backend24.000webhostapp.com/RestApi/uploaded/b8d948bcb0e1e6296502681cdb1b3535a75c8ddf.png', 'Elsie', 'Dennis', 'MALE', '77', '7898680304', 1, 'dennis@gmail.com', 1, 'dennis_24', 'B818x55FASHvX4JuGQciR9lv7q', '2021-02-25 18:14:56', '2021-02-25 18:14:56', '2021-02-25 18:14:56', '2021-02-25 18:14:56', 1),
(29, 'app', NULL, 'https://backend24.000webhostapp.com/RestApi/uploaded/411d18151e75f8f76f7e7c8b3c05d49300c75594.png', 'Hazel', 'Flores', 'MALE', '55', '7898680304', 1, 'flores@gmail.com', 1, 'flores_24', 'B818x55FASHvX4JuGQciR9lv7q', '2021-02-25 18:15:45', '2021-02-25 18:15:45', '2021-02-25 18:15:45', '2021-02-25 18:15:45', 1),
(30, 'app', NULL, 'https://backend24.000webhostapp.com/RestApi/uploaded/353e1cd96518caed37b8f275ceaa23611b4a9b76.png', 'Darrin', 'Stephens', 'MALE', '11', '7898680304', 1, 'stephens@gmail.com', 1, 'stephens', 'B818x55FASHvX4JuGQciR9lv7q', '2021-02-25 18:16:32', '2021-02-25 18:16:32', '2021-02-25 18:16:32', '2021-02-25 18:16:32', 1),
(31, 'app', NULL, 'https://backend24.000webhostapp.com/RestApi/uploaded/c207f833e956fe8ebe4cd2cf76a32428fea92324.png', 'Ramiro', 'Frazier', 'MALE', '33', '7898680304', 1, 'frazier@gmail.com', 1, 'Frazier_24', 'B818x55FASHvX4JuGQciR9lv7q', '2021-02-25 18:17:03', '2021-02-25 18:17:03', '2021-02-25 18:17:03', '2021-02-25 18:17:03', 1),
(32, 'app', NULL, 'https://backend24.000webhostapp.com/RestApi/uploaded/02a06dfe2a626ac80391d49e0c6faea01ea29147.png', 'Willis', 'Poole', 'MALE', '66', '7898680304', 1, 'poole@gmail.com', 1, 'polle_24', 'sadfoasdjofhksdfdasds', '2021-02-25 18:17:48', '2021-02-25 18:17:48', '2021-02-25 18:17:48', '2021-02-25 18:17:48', 1),
(33, 'google', '123456789', 'https://avatars.githubusercontent.com/u/71142?v=4', 'Velma', 'Nelson', NULL, '91', NULL, 0, 'iamrohityadav24@gmail.com', 1, NULL, 'SHvX4JuGQciR9lv7q', '2021-02-25 18:20:05', '2021-02-25 18:20:02', '2021-02-25 18:20:05', '2021-02-25 18:20:02', 0),
(34, 'facebook', '123456789', 'https://avatars.githubusercontent.com/u/73608?v=4', 'Debra', 'Daniels', NULL, '91', NULL, 0, 'iamrohityadav24@gmail.com', 1, NULL, 'SHvX4JuGQciR9lv7q', '2021-02-25 18:34:07', '2021-02-25 18:20:34', '2021-02-25 18:34:07', '2021-02-25 18:20:34', 0),
(35, 'facebook', '123456783', 'https://avatars.githubusercontent.com/u/108107?v=4', 'Felicia', 'Mcguire', NULL, '91', NULL, 0, 'iamrohityadav24@gmail.com', 1, NULL, 'SHvX4JuGQciR9lv7q', '2021-02-25 18:35:00', '2021-02-25 18:35:00', '2021-02-25 18:35:00', '2021-02-25 18:35:00', 0),
(36, 'google', '123456783', 'https://avatars.githubusercontent.com/u/111600?v=4', 'Grace', 'Douglas', NULL, '91', NULL, 0, 'iamrohityadav24@gmail.com', 1, NULL, 'SHvX4JuGQciR9lv7q', '2021-02-25 18:36:35', '2021-02-25 18:35:53', '2021-02-25 18:36:35', '2021-02-25 18:35:53', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `password_reset`
--
ALTER TABLE `password_reset`
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
-- AUTO_INCREMENT for table `password_reset`
--
ALTER TABLE `password_reset`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 07, 2021 at 04:04 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.3.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fpe_web_glamour`
--

-- --------------------------------------------------------

--
-- Table structure for table `kt_booking`
--

CREATE TABLE `kt_booking` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `event_type_id` int(11) NOT NULL,
  `amount_paid` double NOT NULL,
  `status` enum('initialized','failed','success') NOT NULL DEFAULT 'success',
  `event_location` text NOT NULL,
  `event_date` varchar(30) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kt_booking`
--

INSERT INTO `kt_booking` (`id`, `user_id`, `event_type_id`, `amount_paid`, `status`, `event_location`, `event_date`, `description`, `created_at`) VALUES
(1, 1, 1, 10000, 'success', 'Ede Osun State', '2021-09-15', 'I need good decoration and cake for my birth with one event hall', '2021-09-06 07:35:56'),
(2, 1, 1, 10000, 'success', 'Ede Osun State', '2021-09-15', 'I need good decoration and cake for my birth with one event hall', '2021-09-06 07:37:24');

-- --------------------------------------------------------

--
-- Table structure for table `kt_event_type`
--

CREATE TABLE `kt_event_type` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `price` double NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kt_event_type`
--

INSERT INTO `kt_event_type` (`id`, `name`, `price`, `created_at`, `updated_at`) VALUES
(1, 'birthday', 10000, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'wedding ceremony', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'festival gatherings', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `kt_transactions`
--

CREATE TABLE `kt_transactions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `amount` decimal(10,0) NOT NULL,
  `reference` text NOT NULL,
  `status` enum('initialized','failed','success','') NOT NULL DEFAULT 'initialized',
  `verified` int(11) NOT NULL DEFAULT 0,
  `paid_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kt_transactions`
--

INSERT INTO `kt_transactions` (`id`, `user_id`, `booking_id`, `amount`, `reference`, `status`, `verified`, `paid_at`, `created_at`) VALUES
(1, 1, 1, '10000', 'wsiaz8sxfv', 'initialized', 0, '2021-09-06 07:35:56', '2021-09-06 07:35:56'),
(2, 1, 2, '10000', 'eeja7p30j9', 'initialized', 0, '2021-09-06 07:37:24', '2021-09-06 07:37:24');

-- --------------------------------------------------------

--
-- Table structure for table `kt_users`
--

CREATE TABLE `kt_users` (
  `id` int(11) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` text NOT NULL,
  `phone` varchar(30) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `role` int(11) NOT NULL DEFAULT 1,
  `code` int(11) NOT NULL DEFAULT 0,
  `account_type` enum('Website','Mobile App','Google','') NOT NULL DEFAULT 'Website',
  `created_at` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kt_users`
--

INSERT INTO `kt_users` (`id`, `fname`, `email`, `password`, `phone`, `status`, `role`, `code`, `account_type`, `created_at`) VALUES
(1, 'Akeem Adewale basit', 'tech4all583@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '09069588201', 1, 1, 6104, 'Website', 1592999367),
(2, 'Glamour', 'admin@glamour.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '09069588201', 1, 2, 1, 'Website', 1592999367),
(3, 'olatona kabirat', 'olatonakabirat50@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '09028912781', 1, 1, 1, 'Website', 1594886331);

-- --------------------------------------------------------

--
-- Table structure for table `kt_vendor`
--

CREATE TABLE `kt_vendor` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `profession` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kt_vendor`
--

INSERT INTO `kt_vendor` (`id`, `name`, `email`, `phone`, `profession`, `address`, `created_at`) VALUES
(1, 'Mrs tawakalitu', 'tawakat@gmail.com', '08060219615', 'Baker', 'Osun State', '2021-09-05 13:58:11');

-- --------------------------------------------------------

--
-- Table structure for table `kt_vendor_event_booking`
--

CREATE TABLE `kt_vendor_event_booking` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `amount_paid` double NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kt_vendor_event_booking`
--

INSERT INTO `kt_vendor_event_booking` (`id`, `booking_id`, `vendor_id`, `amount_paid`, `created_at`) VALUES
(1, 1, 1, 5000, '2021-09-07 13:51:13');

-- --------------------------------------------------------

--
-- Table structure for table `kt_venue`
--

CREATE TABLE `kt_venue` (
  `id` int(11) NOT NULL,
  `image` text NOT NULL,
  `all_images` text NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `venue_type` int(11) NOT NULL,
  `guest` int(11) NOT NULL,
  `amenities` text NOT NULL,
  `state_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `area_id` int(11) NOT NULL,
  `address` text NOT NULL,
  `price` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kt_venue`
--

INSERT INTO `kt_venue` (`id`, `image`, `all_images`, `title`, `description`, `venue_type`, `guest`, `amenities`, `state_id`, `city_id`, `area_id`, `address`, `price`, `created_at`) VALUES
(1, '15935352924.jpg', '[\"15935352924.jpg\",\"15935352923.jpg\",\"15935352922.jpg\",\"15935352921.jpg\"]', 'Nustreams Conference and Culture Centre The Upper Room', '<p>A Conference Hall perfect for presentations or conferences fully \r\nequipped with Modern multimedia facilities to make your conference or \r\nmeeting memorable.</p>', 2, 40, '[\"Air Conditioner\",\"Chair\",\"Changing Room\",\"Rest Room\",\"Security\",\"Tables\"]', 3, 2, 3, '', '100000', '2020-06-30 16:41:32'),
(2, '159353554915487568308e75e8.jpg', '[\"159353554915487568308e75e8.jpg\",\"1593535549154875683137a1f5.jpg\",\"15935355491548756829b5ba38.jpg\",\"159353554915487568302657cf.jpg\",\"1593535549154875683095a054.jpg\",\"1593535549154875673858ebc0.jpg\"]', 'Geeks Event Place Osogbo Glass Marquee', '<p>GEEKS Event Place is Ibadans first and only full glass marquee luxury event center. It is located right on the expressway.<br>\r\nIt has a banquet seating capacity of 600 with an amazing VIP chairs and \r\nClear Dior chairs are all complementary. It is fully air conditioned, \r\ndraped and decorated with gold crystal chandeliers designed to make your\r\n occasion a beautiful one.</p>', 3, 600, '[\"Stage\",\"Air Conditioner\",\"Chair\",\"Changing Room\",\"Parking Space\",\"Security\",\"Sound System\",\"Tables\"]', 3, 2, 1, 'Magazine Road, Ibadan, Oyo, Nigeria', '300000', '2020-06-30 16:45:49'),
(3, '15935358119.jpg', '[\"15935358119.jpg\",\"15935358117.jpg\",\"15935358118.jpg\",\"15935358116.jpg\"]', 'Kelsey Green Villa Conference Hall', '<p>Hoyel Hall for&amp;nbsp for different event types 60 guests.</p>', 4, 60, '[\"Air Conditioner\",\"Chair\",\"Parking Space\",\"Rest Room\",\"Tables\"]', 2, 3, 3, '', '100000', '2020-06-30 16:50:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kt_booking`
--
ALTER TABLE `kt_booking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kt_event_type`
--
ALTER TABLE `kt_event_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kt_transactions`
--
ALTER TABLE `kt_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kt_users`
--
ALTER TABLE `kt_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kt_vendor`
--
ALTER TABLE `kt_vendor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kt_vendor_event_booking`
--
ALTER TABLE `kt_vendor_event_booking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kt_venue`
--
ALTER TABLE `kt_venue`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kt_booking`
--
ALTER TABLE `kt_booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kt_event_type`
--
ALTER TABLE `kt_event_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kt_transactions`
--
ALTER TABLE `kt_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kt_users`
--
ALTER TABLE `kt_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `kt_vendor`
--
ALTER TABLE `kt_vendor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kt_vendor_event_booking`
--
ALTER TABLE `kt_vendor_event_booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kt_venue`
--
ALTER TABLE `kt_venue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 06, 2024 at 08:51 PM
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
-- Database: `track`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_book`
--

CREATE TABLE `tbl_book` (
  `tbl_book_id` int(11) NOT NULL,
  `tbl_category_id` int(11) NOT NULL,
  `book_image` text NOT NULL,
  `book_name` text NOT NULL,
  `book_author` text NOT NULL,
  `book_summary` text NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_book`
--

INSERT INTO `tbl_book` (`tbl_book_id`, `tbl_category_id`, `book_image`, `book_name`, `book_author`, `book_summary`, `user_id`) VALUES
(15, 2, 'the haunting of hill house.jpg', 'The Haunting of Hill House', 'Shirley Jackson', 'Four people, drawn to the infamous Hill House by its sinister reputation, find themselves ensnared in its malevolent grip. As Dr. Montague, Eleanor, Theodora, and Luke explore the house\'s dark corridors and mysterious phenomena, they uncover the chilling truth of its haunted past and the psychological horrors that lurk within its walls.', 36),
(17, 1, 'thenameofthewind.jpg', 'The Name of the Wind', 'Patrick Rothfuss', 'In the first installment of \"The Kingkiller Chronicle,\" we follow the story of Kvothe, a gifted young man with a mysterious past. Through his own narration, Kvothe recounts his journey from a troupe of traveling performers to a renowned arcanist, musician, and swordsman. But behind his tale lies the enigmatic truth of his encounter with the legendary Chandrian and the death of his parents.', 31),
(19, 2, 'theShining.jpg', 'The Shining', 'Stephen King', 'Jack Torrance, a struggling writer and recovering alcoholic, accepts a job as the winter caretaker of the historic Overlook Hotel, hoping for solitude to work on his writing. However, as the hotel\'s sinister past begins to influence his mind, Jack\'s sanity unravels, and his young son Danny\'s psychic abilities reveal terrifying secrets lurking within the hotel\'s corridors.', 31),
(20, 1, 'TheWayOfTheKings.jpg', 'The Way of Kings', 'Brandon Sanderson', ' The first volume of \"The Stormlight Archive\" introduces readers to the shattered world of Roshar, where monstrous storms rage across a landscape scarred by constant warfare. Amidst this turmoil, Kaladin, a former soldier turned slave, seeks redemption, while Dalinar Kholin, a highprince burdened by visions, struggles to unite the fractured kingdom against an imminent apocalypse.', 31),
(22, 1, 'theFinalEmpire_1.jpg', 'Mistborn: The Final Empire', 'Brandon Sanderson', 'In a world oppressed by an immortal tyrant known as the Lord Ruler, the downtrodden skaa labor under the rule of the nobility. Vin, a young street urchin, discovers her latent powers as a Mistborn, capable of wielding Allomancy to manipulate metals. With the help of the rebellious crew led by the charismatic Kelsier, Vin embarks on a daring mission to overthrow the Final Empire and fulfill an ancient prophecy.', 36);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `tbl_category_id` int(11) NOT NULL,
  `category_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`tbl_category_id`, `category_name`) VALUES
(1, 'Fantasy'),
(2, 'Horror'),
(3, 'Thriller'),
(4, 'Fiction'),
(5, 'Non Fiction'),
(6, 'Others');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `code` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `code`) VALUES
(28, 'basim', 'basimshahxx66@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', ''),
(31, 'yumyam', 'yumyamx18@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', ''),
(34, 'gadg', 'test1@gmail.com', 'c20ad4d76fe97759aa27a0c99bff6710', 'd2ec8feef95ce49ccf9545bf22d52133'),
(35, 'gandi warshi', 'GandiWarshi@gmail.com', '202cb962ac59075b964b07152d234b70', '4dc34c5bf3eebe921e53a89706a2c52b'),
(36, 'Yumna Muhammad', 'yumms.m@gmail.com', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_book`
--
ALTER TABLE `tbl_book`
  ADD PRIMARY KEY (`tbl_book_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`tbl_category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_book`
--
ALTER TABLE `tbl_book`
  MODIFY `tbl_book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_book`
--
ALTER TABLE `tbl_book`
  ADD CONSTRAINT `fk_user_book` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

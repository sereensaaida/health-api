-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 11, 2024 at 04:13 PM
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
-- Database: `health-api`
--

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `country_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `population` int(11) DEFAULT NULL,
  `vegetarian_percentage` float DEFAULT NULL,
  `daily_calorie_intake` float DEFAULT NULL,
  `consumed_dishes` text DEFAULT NULL,
  `food_culture` text DEFAULT NULL,
  `nutritional_deficiency` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `diet`
--

CREATE TABLE `diet` (
  `diet_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `calorie_goal` int(11) DEFAULT NULL,
  `protein_goal` float DEFAULT NULL,
  `fat_goal` float DEFAULT NULL,
  `carbohydrate_goal` float DEFAULT NULL,
  `is_vegetarian` tinyint(1) DEFAULT NULL,
  `is_gluten_free` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exercise`
--

CREATE TABLE `exercise` (
  `exercise_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `exercise_type` varchar(50) DEFAULT NULL,
  `calories_burned_per_min` float DEFAULT NULL,
  `equipment_needed` varchar(100) DEFAULT NULL,
  `difficulty_level` tinyint(4) DEFAULT NULL,
  `muscles_targeted` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `food`
--

CREATE TABLE `food` (
  `food_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  `calories` int(11) DEFAULT NULL,
  `serving_size` float DEFAULT NULL,
  `content` float DEFAULT NULL,
  `avg_price` decimal(10,2) DEFAULT NULL,
  `is_vegan` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `food_guideline_recommendation`
--

CREATE TABLE `food_guideline_recommendation` (
  `guideline_id` int(11) NOT NULL,
  `country_id` int(11) DEFAULT NULL,
  `calorie_intake` float DEFAULT NULL,
  `protein_intake` float DEFAULT NULL,
  `fats` float DEFAULT NULL,
  `carbohydrates` float DEFAULT NULL,
  `servings_per_day` int(11) DEFAULT NULL,
  `guideline_notes` text DEFAULT NULL,
  `suggested_food_groups` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nutrition_facts`
--

CREATE TABLE `nutrition_facts` (
  `nutrition_id` int(11) NOT NULL,
  `food_id` int(11) DEFAULT NULL,
  `fat` float DEFAULT NULL,
  `fiber` float DEFAULT NULL,
  `sodium` float DEFAULT NULL,
  `cholesterol` float DEFAULT NULL,
  `description` text DEFAULT NULL,
  `sugar` float DEFAULT NULL,
  `carbohydrates` float DEFAULT NULL,
  `protein` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `workout_recommendations`
--

CREATE TABLE `workout_recommendations` (
  `recommendation_id` int(11) NOT NULL,
  `diet_id` int(11) DEFAULT NULL,
  `exercise_id` int(11) DEFAULT NULL,
  `duration_minutes` int(11) DEFAULT NULL,
  `reps` int(11) DEFAULT NULL,
  `sets` int(11) DEFAULT NULL,
  `distance` float DEFAULT NULL,
  `additional_notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`country_id`);

--
-- Indexes for table `diet`
--
ALTER TABLE `diet`
  ADD PRIMARY KEY (`diet_id`);

--
-- Indexes for table `exercise`
--
ALTER TABLE `exercise`
  ADD PRIMARY KEY (`exercise_id`);

--
-- Indexes for table `food`
--
ALTER TABLE `food`
  ADD PRIMARY KEY (`food_id`);

--
-- Indexes for table `food_guideline_recommendation`
--
ALTER TABLE `food_guideline_recommendation`
  ADD PRIMARY KEY (`guideline_id`),
  ADD KEY `country_id` (`country_id`);

--
-- Indexes for table `nutrition_facts`
--
ALTER TABLE `nutrition_facts`
  ADD PRIMARY KEY (`nutrition_id`),
  ADD KEY `food_id` (`food_id`);

--
-- Indexes for table `workout_recommendations`
--
ALTER TABLE `workout_recommendations`
  ADD PRIMARY KEY (`recommendation_id`),
  ADD KEY `diet_id` (`diet_id`),
  ADD KEY `exercise_id` (`exercise_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `country_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `diet`
--
ALTER TABLE `diet`
  MODIFY `diet_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exercise`
--
ALTER TABLE `exercise`
  MODIFY `exercise_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `food`
--
ALTER TABLE `food`
  MODIFY `food_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `food_guideline_recommendation`
--
ALTER TABLE `food_guideline_recommendation`
  MODIFY `guideline_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nutrition_facts`
--
ALTER TABLE `nutrition_facts`
  MODIFY `nutrition_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `workout_recommendations`
--
ALTER TABLE `workout_recommendations`
  MODIFY `recommendation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `food_guideline_recommendation`
--
ALTER TABLE `food_guideline_recommendation`
  ADD CONSTRAINT `food_guideline_recommendation_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `country` (`country_id`);

--
-- Constraints for table `nutrition_facts`
--
ALTER TABLE `nutrition_facts`
  ADD CONSTRAINT `nutrition_facts_ibfk_1` FOREIGN KEY (`food_id`) REFERENCES `food` (`food_id`);

--
-- Constraints for table `workout_recommendations`
--
ALTER TABLE `workout_recommendations`
  ADD CONSTRAINT `workout_recommendations_ibfk_1` FOREIGN KEY (`diet_id`) REFERENCES `diet` (`diet_id`),
  ADD CONSTRAINT `workout_recommendations_ibfk_2` FOREIGN KEY (`exercise_id`) REFERENCES `exercise` (`exercise_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

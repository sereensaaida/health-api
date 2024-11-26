-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 22, 2024 at 06:35 PM
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
-- Database: `health`
--
CREATE DATABASE IF NOT EXISTS `health` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `health`;
-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `country_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `population` int(11) DEFAULT NULL,
  `vegetarian_percentage` float DEFAULT NULL,
  `daily_calorie_intake` float DEFAULT NULL,
  `consumed_dishes` text DEFAULT NULL,
  `food_culture` text DEFAULT NULL,
  `nutritional_deficiency` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`country_id`, `name`, `population`, `vegetarian_percentage`, `daily_calorie_intake`, `consumed_dishes`, `food_culture`, `nutritional_deficiency`) VALUES
(1, 'India', 1393409038, 30, 2400, 'Paneer, Samosa, Masala Dosa', 'Rich in spices and vegetarian dishes', 'Vitamin B12 deficiency'),
(2, 'USA', 331002651, 5, 2800, 'Burger, Pizza, Hot Dog', 'Diverse, fast food-oriented', 'Obesity, high cholesterol'),
(3, 'Japan', 126476461, 1, 2200, 'Sushi, Tempura, Ramen', 'Focus on seafood and rice', 'Iron deficiency'),
(4, 'China', 1439323776, 5, 2300, 'Dumplings, Noodles, Sweet and Sour Pork', 'Rich in diverse regional cuisines', 'Calcium deficiency'),
(5, 'Brazil', 213993437, 8, 2700, 'Feijoada, Coxinha, Açaí Bowl', 'Lively, varied with tropical flavors', 'Vitamin A deficiency'),
(6, 'Germany', 83783942, 3, 2600, 'Wurst, Sauerkraut, Pretzels', 'Hearty, meat-focused', 'Iron deficiency'),
(7, 'France', 65273511, 2, 2500, 'Baguette, Croissant, Coq au Vin', 'Gourmet, rich in dairy and pastries', 'Obesity');

-- --------------------------------------------------------

--
-- Table structure for table `diets`
--

CREATE TABLE `diets` (
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

--
-- Dumping data for table `diets`
--

INSERT INTO `diets` (`diet_id`, `name`, `description`, `calorie_goal`, `protein_goal`, `fat_goal`, `carbohydrate_goal`, `is_vegetarian`, `is_gluten_free`) VALUES
(1, 'Keto', 'High-fat, low-carb diet', 2000, 75, 165, 30, 0, 1),
(2, 'Mediterranean', 'Emphasizes fruits, vegetables, and healthy fats', 2500, 100, 80, 200, 1, 0),
(3, 'Paleo', 'Focuses on whole foods and avoids processed foods', 2200, 90, 70, 150, 0, 0),
(4, 'Vegan', 'Plant-based diet avoiding all animal products', 2000, 70, 50, 250, 1, 1),
(5, 'Intermittent Fasting', 'Cycles between eating and fasting periods', 1800, 85, 70, 200, 0, 0),
(6, 'Low-Carb', 'Reduces carbohydrate intake significantly', 1900, 80, 60, 100, 0, 1),
(7, 'High-Protein', 'Focuses on increasing protein intake', 2500, 150, 70, 150, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `exercises`
--

CREATE TABLE `exercises` (
  `exercise_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `exercise_type` varchar(50) DEFAULT NULL,
  `calories_burned_per_min` float DEFAULT NULL,
  `equipment_needed` varchar(100) DEFAULT NULL,
  `difficulty_level` tinyint(4) DEFAULT NULL,
  `muscles_targeted` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `exercises`
--

INSERT INTO `exercises` (`exercise_id`, `name`, `exercise_type`, `calories_burned_per_min`, `equipment_needed`, `difficulty_level`, `muscles_targeted`) VALUES
(1, 'Running', 'Cardio', 10, 'None', 3, 'Legs, Cardio'),
(2, 'Push-ups', 'Strength', 7, 'None', 2, 'Chest, Arms'),
(3, 'Cycling', 'Cardio', 8, 'Bicycle', 3, 'Legs, Cardio'),
(4, 'Swimming', 'Cardio', 12, 'Pool', 4, 'Full Body'),
(5, 'Jumping Jacks', 'Cardio', 9, 'None', 2, 'Full Body'),
(6, 'Deadlifts', 'Strength', 6, 'Barbell', 4, 'Back, Legs'),
(7, 'Yoga', 'Flexibility', 4, 'Mat', 2, 'Full Body');

-- --------------------------------------------------------

--
-- Table structure for table `facts`
--

CREATE TABLE `facts` (
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

--
-- Dumping data for table `facts`
--

INSERT INTO `facts` (`nutrition_id`, `food_id`, `fat`, `fiber`, `sodium`, `cholesterol`, `description`, `sugar`, `carbohydrates`, `protein`) VALUES
(1, 1, 0.2, 2.4, 1, 0, 'Sweet and crunchy fruit', 10.4, 14, 0.3),
(2, 2, 3.6, 0, 74, 85, 'Lean poultry meat', 0, 0, 31),
(3, 3, 49.4, 12.5, 1, 0, 'Nutritious nuts with high fat content', 4.2, 21.6, 21),
(4, 4, 0.6, 2.6, 33, 0, 'Cruciferous vegetable', 1.7, 11.2, 3.7),
(5, 5, 13, 0, 50, 60, 'Fatty fish rich in omega-3', 0, 0, 20),
(6, 6, 1.9, 2.8, 5, 0, 'Nutty, protein-rich grain', 0.9, 21, 4.1),
(7, 7, 0.4, 0, 36, 10, 'Thick, creamy dairy product', 4, 3.6, 10);

-- --------------------------------------------------------

--
-- Table structure for table `foods`
--

CREATE TABLE `foods` (
  `food_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  `calories` int(11) DEFAULT NULL,
  `serving_size` float DEFAULT NULL,
  `content` float DEFAULT NULL,
  `avg_price` decimal(10,2) DEFAULT NULL,
  `is_vegan` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `foods`
--

INSERT INTO `foods` (`food_id`, `name`, `category`, `calories`, `serving_size`, `content`, `avg_price`, `is_vegan`) VALUES
(1, 'Apple', 'Fruit', 52, 100, 85, 0.50, 1),
(2, 'Chicken Breast', 'Meat', 165, 100, 31, 2.00, 0),
(3, 'Almonds', 'Nuts', 579, 100, 21, 5.00, 1),
(4, 'Broccoli', 'Vegetable', 55, 100, 3.7, 1.00, 1),
(5, 'Salmon', 'Fish', 208, 100, 13, 6.00, 0),
(6, 'Quinoa', 'Grain', 120, 100, 1.9, 2.50, 1),
(7, 'Greek Yogurt', 'Dairy', 59, 100, 0.4, 1.50, 0),
(8, 'Starfruit', 'Fruit', 22, 75, 35, 1.00, 1),
(9, 'Starfruit', 'Fruit', 22, 75, 35, 1.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `guidelines`
--

CREATE TABLE `guidelines` (
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

--
-- Dumping data for table `guidelines`
--

INSERT INTO `guidelines` (`guideline_id`, `country_id`, `calorie_intake`, `protein_intake`, `fats`, `carbohydrates`, `servings_per_day`, `guideline_notes`, `suggested_food_groups`) VALUES
(1, 1, 2200, 60, 70, 300, 5, 'Focus on plant-based foods', 'Legumes, Nuts, Fruits'),
(2, 2, 2500, 75, 90, 350, 3, 'Moderate fast food intake', 'Vegetables, Lean meats'),
(3, 3, 2000, 70, 50, 250, 4, 'Increase fish consumption', 'Seafood, Rice, Vegetables'),
(4, 4, 2300, 80, 65, 270, 4, 'Balanced diet with various grains', 'Vegetables, Meat, Rice'),
(5, 5, 2700, 85, 75, 350, 4, 'Rich in tropical fruits and legumes', 'Fruits, Beans, Nuts'),
(6, 6, 2600, 70, 80, 280, 3, 'Include whole grains and meats', 'Bread, Meat, Vegetables'),
(7, 7, 2500, 75, 70, 320, 3, 'Focus on dairy and meats', 'Dairy, Meat, Vegetables');

-- --------------------------------------------------------

--
-- Table structure for table `recommendations`
--

CREATE TABLE `recommendations` (
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
-- Dumping data for table `recommendations`
--

INSERT INTO `recommendations` (`recommendation_id`, `diet_id`, `exercise_id`, `duration_minutes`, `reps`, `sets`, `distance`, `additional_notes`) VALUES
(1, 1, 1, 30, NULL, NULL, 5, 'Good for maintaining low body fat'),
(2, 2, 2, 20, 15, 3, NULL, 'Effective for building upper body strength'),
(3, 3, 3, 45, NULL, NULL, 20, 'Great for cardiovascular health'),
(4, 4, 4, 60, NULL, NULL, 1.5, 'Excellent for full body fitness'),
(5, 5, 5, 15, NULL, NULL, 2, 'Ideal for warming up and cardio'),
(6, 6, 6, 25, 12, 4, NULL, 'Targets back and leg muscles effectively'),
(7, 7, 7, 40, NULL, NULL, NULL, 'Enhances flexibility and relaxation');

-- --------------------------------------------------------

--
-- Table structure for table `ws_log`
--

CREATE TABLE `ws_log` (
  `log_id` int(10) UNSIGNED NOT NULL,
  `email` varchar(150) NOT NULL,
  `user_action` varchar(255) NOT NULL,
  `logged_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ws_users`
--

CREATE TABLE `ws_users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`country_id`);

--
-- Indexes for table `diets`
--
ALTER TABLE `diets`
  ADD PRIMARY KEY (`diet_id`);

--
-- Indexes for table `exercises`
--
ALTER TABLE `exercises`
  ADD PRIMARY KEY (`exercise_id`);

--
-- Indexes for table `facts`
--
ALTER TABLE `facts`
  ADD PRIMARY KEY (`nutrition_id`),
  ADD KEY `food_id` (`food_id`);

--
-- Indexes for table `foods`
--
ALTER TABLE `foods`
  ADD PRIMARY KEY (`food_id`);

--
-- Indexes for table `guidelines`
--
ALTER TABLE `guidelines`
  ADD PRIMARY KEY (`guideline_id`),
  ADD KEY `country_id` (`country_id`);

--
-- Indexes for table `recommendations`
--
ALTER TABLE `recommendations`
  ADD PRIMARY KEY (`recommendation_id`),
  ADD KEY `diet_id` (`diet_id`),
  ADD KEY `exercise_id` (`exercise_id`);

--
-- Indexes for table `ws_log`
--
ALTER TABLE `ws_log`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `ws_users`
--
ALTER TABLE `ws_users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `country_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `diets`
--
ALTER TABLE `diets`
  MODIFY `diet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `exercises`
--
ALTER TABLE `exercises`
  MODIFY `exercise_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `facts`
--
ALTER TABLE `facts`
  MODIFY `nutrition_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `foods`
--
ALTER TABLE `foods`
  MODIFY `food_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `guidelines`
--
ALTER TABLE `guidelines`
  MODIFY `guideline_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `recommendations`
--
ALTER TABLE `recommendations`
  MODIFY `recommendation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `ws_log`
--
ALTER TABLE `ws_log`
  MODIFY `log_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ws_users`
--
ALTER TABLE `ws_users`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `facts`
--
ALTER TABLE `facts`
  ADD CONSTRAINT `facts_ibfk_1` FOREIGN KEY (`food_id`) REFERENCES `foods` (`food_id`);

--
-- Constraints for table `guidelines`
--
ALTER TABLE `guidelines`
  ADD CONSTRAINT `guidelines_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `countries` (`country_id`);

--
-- Constraints for table `recommendations`
--
ALTER TABLE `recommendations`
  ADD CONSTRAINT `recommendations_ibfk_1` FOREIGN KEY (`diet_id`) REFERENCES `diets` (`diet_id`),
  ADD CONSTRAINT `recommendations_ibfk_2` FOREIGN KEY (`exercise_id`) REFERENCES `exercises` (`exercise_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

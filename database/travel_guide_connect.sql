-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Apr 19, 2026 at 03:03 PM
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
-- Database: `travel_guide_connect`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'Admin_Mwaura', 'admin@tconnect.co.ke', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2026-03-14 18:56:01');

-- --------------------------------------------------------

--
-- Table structure for table `attractions`
--

CREATE TABLE `attractions` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) DEFAULT 0.00,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `img_url` varchar(255) NOT NULL DEFAULT 'default.jpg',
  `is_dry_season` tinyint(4) NOT NULL,
  `is_long_rains` tinyint(4) NOT NULL,
  `is_short_rains` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attractions`
--

INSERT INTO `attractions` (`id`, `name`, `location`, `description`, `price`, `latitude`, `longitude`, `img_url`, `is_dry_season`, `is_long_rains`, `is_short_rains`) VALUES
(1, 'Maasai Mara', 'Narok', 'World-famous for the Great Migration and the Big Five.', 1500.00, -1.48620000, 35.13240000, 'mara.jpg', 1, 0, 1),
(2, 'Diani Beach', 'Kwale', 'Award-winning white sand beach with crystal clear waters.', 0.00, -4.27980000, 39.59470000, 'diani.jpg', 1, 0, 1),
(3, 'Amboseli', 'Kajiado', 'Famous for its large elephant herds and views of Mt. Kilimanjaro.', 1500.00, -2.65270000, 37.26340000, 'amboseli.jpg', 1, 1, 0),
(4, 'Lake Baringo', 'Baringo', 'Ideal for birdwatching; roads remain accessible.', 0.00, 0.61220000, 36.02450000, 'lake_baringo.jpg', 1, 0, 0),
(5, 'Lake Bogoria', 'Baringo', 'Best for viewing flamingos concentrated in low water levels.', 500.00, 0.25200000, 36.10320000, 'lake_bogoria.jpg', 1, 0, 0),
(6, 'Kerio Valley', 'Baringo', 'Clear views; access roads are safer.', 500.00, 0.46670000, 35.83330000, 'kerio_valley.jpg', 1, 0, 0),
(7, 'Chepkiit Waterfalls', 'Elgeyo-Marakwet', 'Waterfalls are most voluminous during rainy seasons.', 200.00, 0.41000000, 35.18000000, 'chepkiit_waterfalls.jpg', 0, 1, 1),
(8, 'Rimoi National Reserve', 'Elgeyo-Marakwet', 'Game viewing is easier as animals congregate near water.', 500.00, 0.50000000, 35.58330000, 'rimoi_national_reserve.jpg', 1, 0, 0),
(9, 'Torok Waterfalls', 'Elgeyo-Marakwet', 'Peak water flow during rainy seasons.', 150.00, 0.45000000, 35.48330000, 'torok_waterfalls.jpg', 0, 1, 1),
(10, 'Saiwa Swamp National Park', 'Trans Nzoia', 'Trails are less muddy; easier to spot Sitatunga antelope.', 300.00, 1.09670000, 35.11890000, 'saiwa_swamp_national_park.jpg', 1, 0, 0),
(11, 'Mount Elgon National Park', 'Bungoma', 'Safe for hiking and cave exploration.', 150.00, 1.13530000, 34.55140000, 'mount_elgon_national_park.jpg', 1, 0, 0),
(12, 'Kitum Caves', 'Trans Nzoia', 'Minimal flooding inside caves during dry periods.', 500.00, 1.03330000, 34.75000000, 'kitum_caves.jpg', 1, 0, 0),
(13, 'Endebess Bluff', 'Trans Nzoia', 'Clear views of the escarpment.', 500.00, 1.06670000, 34.85000000, 'endebess_bluff.jpg', 1, 0, 0),
(14, 'Kakamega Forest', 'Kakamega', 'Trails are accessible; fewer leeches.', 732.00, 0.28330000, 34.85000000, 'kakamega_forest.jpg', 1, 0, 0),
(15, 'Crying Stone of Ilesi', 'Kakamega', 'Roads are passable for viewing this cultural landmark.', 250.00, 0.24000000, 34.76000000, 'crying_stone_of_ilesi.jpg', 1, 0, 0),
(16, 'Isiukhu Falls', 'Kakamega', 'Waterfalls are at their strongest during rains.', 732.00, 0.32000000, 34.87000000, 'isiukhu_falls.jpg', 0, 1, 1),
(17, 'Malava Forest', 'Kakamega', 'Better for birdwatching and hiking.', 232.00, 0.45000000, 34.85000000, 'malava_forest.jpg', 1, 0, 0),
(18, 'Nabongo Cultural Centre', 'Kakamega', 'Cultural visits are unaffected by weather.', 200.00, 0.35000000, 34.48330000, 'nabongo_cultural_centre.jpg', 1, 1, 1),
(19, 'Kisumu Impala Sanctuary', 'Kisumu', 'Less muddy; easier wildlife viewing.', 405.00, -0.12250000, 34.74750000, 'kisumu_impala_sanctuary.jpg', 1, 0, 0),
(20, 'Ndere Island National Park', 'Kisumu', 'Boat access is safer during dry months.', 675.00, -0.11670000, 34.50000000, 'ndere_island_national_park.jpg', 1, 0, 0),
(21, 'Dunga Beach', 'Kisumu', 'Pleasant weather for boating and sunsets.', 300.00, -0.14000000, 34.74000000, 'dunga_beach.jpg', 1, 0, 0),
(22, 'Kit Mikayi', 'Kisumu', 'Access roads are navigable for rock climbing.', 250.00, -0.01670000, 34.53330000, 'kit_mikayi.jpg', 1, 0, 0),
(23, 'Hippo Point', 'Kisumu', 'Hippos are more visible along the shore.', 0.00, -0.12000000, 34.73000000, 'hippo_point.jpg', 1, 0, 0),
(24, 'Ruma National Park', 'Homa Bay', 'Best for viewing roan antelope and birds.', 675.00, -0.65000000, 34.33330000, 'ruma_national_park.jpg', 1, 0, 0),
(25, 'Simbi Nyaima', 'Homa Bay', 'Accessible roads to the volcanic lake.', 300.00, -0.45000000, 34.61670000, 'simbi_nyaima.jpg', 1, 0, 0),
(26, 'Thimlich Ohinga', 'Migori', 'Roads are passable to this remote dry-stone walled site.', 200.00, -0.96670000, 34.31670000, 'thimlich_ohinga.jpg', 1, 0, 0),
(27, 'Mfangano Island', 'Homa Bay', 'Lake Victoria is calmer for boat travel.', 200.00, -0.46670000, 34.00000000, 'mfangano_island.jpg', 1, 0, 0),
(28, 'Rusinga Island', 'Homa Bay', 'Optimal for fossil sites and birdwatching.', 200.00, -0.40000000, 34.16670000, 'rusinga_island.jpg', 1, 0, 0),
(29, 'Lake Turkana', 'Turkana', 'Extreme heat is milder; roads are passable.', 500.00, 3.50000000, 36.00000000, 'lake_turkana.jpg', 1, 0, 0),
(30, 'Sibiloi National Park', 'Turkana', 'Essential for accessing this remote UNESCO site.', 500.00, 3.75000000, 36.33330000, 'sibiloi_national_park.jpg', 1, 0, 0),
(31, 'Central Island National Park', 'Turkana', 'Calmer waters for boat access to crater lakes.', 500.00, 3.50000000, 36.04000000, 'central_island_national_park.jpg', 1, 0, 0),
(32, 'South Island National Park', 'Turkana', 'Requires calm weather for safe access.', 500.00, 2.50000000, 36.75000000, 'south_island_national_park.jpg', 1, 0, 0),
(33, 'Koobi Fora', 'Turkana', 'Essential for access to world-renowned fossil sites.', 500.00, 3.94580000, 36.18610000, 'koobi_fora.jpg', 1, 0, 0),
(34, 'Meru National Park', 'Meru', 'Best for game viewing; roads become impassable in rains.', 1000.00, 0.18340000, 38.20170000, 'meru_national_park.jpg', 1, 0, 0),
(35, 'Lewa Wildlife Conservancy', 'Isiolo', 'Prime wildlife viewing for Rhino and Grevys Zebra.', 2600.00, 0.20000000, 37.45000000, 'lewa_wildlife_conservancy.jpg', 1, 0, 0),
(36, 'Mount Kenya', 'Meru', 'Safest for climbing and trekking.', 1000.00, -0.15080000, 37.30750000, 'mount_kenya.jpg', 1, 0, 0),
(37, 'Imenti Forest', 'Meru', 'Trails are accessible for nature walks.', 200.00, 0.00000000, 37.61670000, 'imenti_forest.jpg', 1, 0, 0),
(38, 'Njuri Ncheke Shrines', 'Meru', 'Access is weather-dependent but best in dry months.', 200.00, 0.05000000, 37.85000000, 'njuri_ncheke_shrines.jpg', 1, 0, 0),
(39, 'Lake Nakuru National Park', 'Nakuru', 'Wildlife congregates along the lake shore.', 2025.00, -0.36010000, 36.08270000, 'lake_nakuru_national_park.jpg', 1, 0, 0),
(40, 'Menengai Crater', 'Nakuru', 'Clear views and safe hiking.', 282.00, -0.20220000, 36.06830000, 'menengai_crater.jpg', 1, 0, 0),
(41, 'Lord Egerton Castle', 'Nakuru', 'Historic gardens are pleasant year-round.', 200.00, -0.31670000, 35.95000000, 'lord_egerton_castle.jpg', 1, 1, 1),
(42, 'Hyrax Hill', 'Nakuru', 'Clear paths for exploring the archaeological site.', 200.00, -0.28330000, 36.08330000, 'hyrax_hill.jpg', 1, 0, 0),
(43, 'Lake Naivasha', 'Nakuru', 'Ideal for boat rides and walking with giraffes.', 0.00, -0.76670000, 36.33330000, 'lake_naivasha.jpg', 1, 0, 0),
(44, 'Hells Gate National Park', 'Nakuru', 'Best for cycling and hiking; avoid rains.', 1000.00, -0.89200000, 36.33100000, 'hells_gate_national_park.jpg', 1, 0, 0),
(45, 'Mount Longonot', 'Nakuru', 'Essential for safe hiking to the crater rim.', 1000.00, -0.91670000, 36.45000000, 'mount_longonot.jpg', 1, 0, 0),
(46, 'Lake Elementaita', 'Nakuru', 'Excellent for birdwatching and flamingos.', 1200.00, -0.45000000, 36.25000000, 'lake_elementaita.jpg', 1, 0, 0),
(47, 'Subukia Shrine', 'Nakuru', 'Pilgrimage site; roads are best in dry season.', 0.00, -0.01670000, 36.21670000, 'subukia_shrine.jpg', 1, 0, 0),
(48, 'Crescent Island', 'Nakuru', 'Easy walking among animals on dry ground.', 1100.00, -0.77000000, 36.40000000, 'crescent_island.jpg', 1, 0, 0),
(49, 'Nairobi National Park', 'Nairobi', 'Animals are easier to spot with sparse vegetation.', 1350.00, -1.37330000, 36.85330000, 'nairobi_national_park.jpg', 1, 0, 0),
(50, 'David Sheldrick Trust', 'Nairobi', 'Open daily for the elephant nursery experience.', 2000.00, -1.37660000, 36.77410000, 'david_sheldrick_trust.jpg', 1, 1, 1),
(51, 'Giraffe Centre', 'Nairobi', 'Weather does not affect the feeding experience.', 400.00, -1.37680000, 36.74410000, 'giraffe_centre.jpg', 1, 1, 1),
(52, 'Karen Blixen Museum', 'Nairobi', 'Indoor museum, accessible year-round.', 200.00, -1.35000000, 36.71670000, 'karen_blixen_museum.jpg', 1, 1, 1),
(53, 'Bomas of Kenya', 'Nairobi', 'Indoor cultural performances regardless of weather.', 200.00, -1.34000000, 36.77000000, 'bomas_of_kenya.jpg', 1, 1, 1),
(54, 'Kenya National Archives', 'Nairobi', 'Indoor attraction in the city centre.', 50.00, -1.28530000, 36.82480000, 'kenya_national_archives.jpg', 1, 1, 1),
(55, 'Nairobi National Museum', 'Nairobi', 'Indoor attraction with rich heritage.', 500.00, -1.27470000, 36.81420000, 'nairobi_national_museum.jpg', 1, 1, 1),
(56, 'Uhuru Gardens', 'Nairobi', 'Outdoor monument, best on clear days.', 0.00, -1.32500000, 36.79170000, 'uhuru_gardens.jpg', 1, 0, 0),
(57, 'Karura Forest', 'Nairobi', 'Trails are less muddy; better for cycling.', 200.00, -1.23330000, 36.83330000, 'karura_forest.jpg', 1, 0, 0),
(58, 'Fort Jesus', 'Mombasa', 'Comfortable for exploring with lower humidity.', 300.00, -4.06000000, 39.68000000, 'fort_jesus.jpg', 1, 0, 0),
(59, 'Haller Park', 'Mombasa', 'Pleasant weather for walking trails.', 500.00, -3.99330000, 39.71170000, 'haller_park.jpg', 1, 0, 0),
(60, 'Mombasa Marine Park', 'Mombasa', 'Calm seas and clear visibility for snorkeling.', 500.00, -4.03330000, 39.73330000, 'mombasa_marine_park.jpg', 1, 0, 0),
(61, 'Old Town Mombasa', 'Mombasa', 'Comfortable for walking tours through history.', 0.00, -4.06250000, 39.67640000, 'old_town_mombasa.jpg', 1, 0, 0),
(62, 'Nzambani Rock', 'Kitui', 'Roads are accessible for climbing the famous rock.', 200.00, -1.41670000, 38.01670000, 'nzambani_rock.jpg', 1, 0, 0),
(63, 'South Kitui National Reserve', 'Kitui', 'Essential for game viewing; inaccessible during rains.', 300.00, -1.95000000, 38.51670000, 'south_kitui_national_reserve.jpg', 1, 0, 0),
(64, 'Mutomo Hill Sanctuary', 'Kitui', 'Roads are passable to the plant sanctuary.', 0.00, -1.85000000, 38.21670000, 'mutomo_hill_sanctuary.jpg', 1, 0, 0),
(65, 'Ikoo Valley', 'Kitui', 'Easier hiking and rock exploration.', 0.00, -1.20000000, 38.00000000, 'ikoo_valley.jpg', 1, 0, 0),
(66, 'Ngomeni Rock', 'Kitui', 'Clear views and accessible roads.', 0.00, -0.65000000, 38.38330000, 'ngomeni_rock.jpg', 1, 0, 0),
(67, 'Nzaui Hill', 'Makueni', 'Safe for hiking to the hilltop.', 0.00, -1.86670000, 37.58330000, 'nzaui_hill.jpg', 1, 0, 0),
(68, 'Mbui Nzu Hill', 'Makueni', 'Best for climbing and cultural visits.', 0.00, -1.80000000, 37.60000000, 'mbui_nzu_hill.jpg', 1, 0, 0),
(69, 'Chyulu Hills', 'Makueni', 'Clear views of Kilimanjaro; trails are usable.', 675.00, -2.43000000, 37.73000000, 'chyulu_hills.jpg', 1, 0, 0),
(70, 'Kibwezi Forest', 'Makueni', 'Trails are accessible; fewer mosquitoes.', 232.00, -2.41670000, 37.96670000, 'kibwezi_forest.jpg', 1, 0, 0),
(71, 'Mwaluganje Sanctuary', 'Kwale', 'Elephants concentrate near the water source.', 600.00, -4.11670000, 39.43330000, 'mwaluganje_sanctuary.jpg', 1, 0, 0),
(72, 'Shimoni Caves', 'Kwale', 'Caves are accessible year-round.', 200.00, -4.64610000, 39.38280000, 'shimoni_caves.jpg', 1, 1, 1),
(73, 'Wasini Island', 'Kwale', 'Calm seas for dhow rides and snorkeling.', 350.00, -4.66670000, 39.38330000, 'wasini_island.jpg', 1, 0, 0),
(74, 'Mount Kenya (Sirimon Gate)', 'Nyeri', 'The highest mountain in Kenya. The Sirimon route offers a scenic ascent through yellow wood forests and moorlands.', 1000.00, 0.02360000, 37.21100000, 'mt_kenya_nyeri.jpg', 0, 0, 0),
(75, 'Baden-Powell Museum', 'Nyeri', 'The final resting place and cottage (Paxtu) of Lord Baden-Powell, the founder of the Scouting movement.', 200.00, -0.42430000, 36.95150000, 'baden_powell.jpg', 0, 0, 0),
(76, 'Chinga Dam & Waterfall', 'Nyeri', 'A beautiful man-made lake on the edge of the Aberdares, famous for boat rides and the nearby 30m spectacular waterfall.', 150.00, -0.56670000, 36.93330000, 'chinga_falls.jpg', 0, 0, 0),
(77, 'Zaina Falls', 'Nyeri', 'Located deep within the Aberdare forest, this hidden gem offers a steep but rewarding trek to a pristine 60-foot drop.', 232.00, -0.48500000, 36.88420000, 'zaina_falls.jpg', 0, 0, 0),
(78, 'Italian Memorial Chapel', 'Nyeri', 'A historic brick church built to honor Italian Prisoners of War from WWII. A masterpiece of architecture and history.', 200.00, -0.42860000, 36.96310000, 'italian_chapel.jpg', 0, 0, 0),
(79, 'Aberdare Forest', 'Murang\'a', 'A majestic high-altitude forest featuring deep valleys and spectacular waterfalls. It is home to the endangered Black Rhino and diverse wildlife.', 232.00, -0.41670000, 36.66670000, 'aberdare_forest.jpg', 1, 0, 1),
(80, 'Ndakaini Dam', 'Murang\'a', 'A massive scenic reservoir supplying water to Nairobi. It is surrounded by lush tea plantations and is ideal for hiking, cycling, and bird watching.', 0.00, -0.81670000, 36.81670000, 'Ndakaini_dam.jpg', 1, 1, 1),
(81, 'Mukurwe wa Nyagathanga', 'Murang\'a', 'The legendary ancestral home of the Gikuyu people (Gikuyu and Mumbi). This cultural shrine is a centerpiece of Gikuyu history and tradition.', 200.00, -0.71670000, 37.13330000, 'Mukurwe_wa_nyagathanga.jpg', 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `attraction_id` int(11) NOT NULL,
  `guide_id` int(11) DEFAULT NULL,
  `booking_date` date NOT NULL,
  `num_people` int(11) DEFAULT 1,
  `status` enum('Pending','Confirmed','Cancelled') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `attraction_id`, `guide_id`, `booking_date`, `num_people`, `status`, `created_at`) VALUES
(1, 1, 79, 103, '2026-04-03', 3, 'Confirmed', '2026-03-31 07:46:57'),
(2, 5, 69, 9, '2026-04-11', 1, 'Confirmed', '2026-04-01 08:38:14'),
(3, 6, 57, 14, '2026-04-07', 2, 'Confirmed', '2026-04-05 17:08:12'),
(4, 7, 58, 7, '2026-04-30', 3, 'Confirmed', '2026-04-07 07:27:30');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(200) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('unread','read') DEFAULT 'unread'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `subject`, `message`, `created_at`, `status`) VALUES
(1, 'tracy', 't@gmail.com', 'service delivery', 'its pretty decent', '2026-03-14 16:57:42', 'read'),
(2, 'Vinnie', 'vngugi90@gmail.com', 'Enquiry on trips to Lamu', 'Do you like use planes in your trips or sth', '2026-04-14 09:02:19', 'read');

-- --------------------------------------------------------

--
-- Table structure for table `guides`
--

CREATE TABLE `guides` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone` varchar(20) NOT NULL,
  `location` varchar(100) NOT NULL,
  `specialization` varchar(255) NOT NULL,
  `experience_years` int(11) DEFAULT 1,
  `bio` text DEFAULT NULL,
  `profile_img` varchar(255) DEFAULT 'default_guide.jpg',
  `rating` decimal(3,2) DEFAULT 5.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_available` tinyint(1) DEFAULT 1,
  `profile_pic` varchar(255) DEFAULT 'default.png',
  `rate_per_day` int(11) NOT NULL DEFAULT 2500
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guides`
--

INSERT INTO `guides` (`id`, `name`, `email`, `password`, `phone`, `location`, `specialization`, `experience_years`, `bio`, `profile_img`, `rating`, `created_at`, `is_available`, `profile_pic`, `rate_per_day`) VALUES
(3, 'Aisha Mwamvita', 'aisha.m@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0711000001', 'Mombasa', 'Coastal History', 5, 'Expert in coastal history and marine life.', 'guide_default.jpg', 4.80, '2026-03-29 19:11:47', 1, 'default.png', 3000),
(4, 'Hamisi Mwakirefu', 'hamisi.m@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0711000002', 'Mombasa', 'Deep Sea Fishing', 8, 'Deep sea fishing and historical tour specialist.', 'guide_default.jpg', 4.50, '2026-03-29 19:11:47', 1, 'default.png', 3000),
(5, 'Fatuma Kadzo', 'fatuma.k@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0711000003', 'Mombasa', 'Cultural Food', 3, 'Cultural heritage and food tour guide.', 'guide_default.jpg', 4.90, '2026-03-29 19:11:47', 1, 'default.png', 2500),
(6, 'Ali Mwarabu', 'ali.m@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0711000004', 'Mombasa', 'Architecture', 10, 'Architecture and Old Town specialist.', 'guide_default.jpg', 4.70, '2026-03-29 19:11:47', 1, 'default.png', 4000),
(7, 'Zainab Pendo', 'zainab.p@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0711000005', 'Mombasa', 'Water Sports', 4, 'Beach excursions and water sports expert.', 'guide_default.jpg', 4.60, '2026-03-29 19:11:47', 1, 'default.png', 2500),
(8, 'Esther Mueni', 'esther.m@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0722000001', 'Makueni', 'Hiking', 6, 'Specialist in hilly terrain and local culture.', 'guide_default.jpg', 4.80, '2026-03-29 19:11:47', 1, 'default.png', 3000),
(9, 'Patrick Mutuku', 'patrick.m@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0722000002', 'Makueni', 'Agro-tourism', 5, 'Agro-tourism and nature walk expert.', 'guide_default.jpg', 4.40, '2026-03-29 19:11:47', 1, 'default.png', 3000),
(10, 'Janet Ndanu', 'janet.n@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0722000003', 'Makueni', 'Storytelling', 12, 'Local history and storytelling specialist.', 'guide_default.jpg', 5.00, '2026-03-29 19:11:47', 1, 'default.png', 4000),
(11, 'David Muthama', 'david.m@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0722000004', 'Makueni', 'Rock Climbing', 7, 'Hiking and rock climbing enthusiast.', 'guide_default.jpg', 4.30, '2026-03-29 19:11:47', 1, 'default.png', 3000),
(12, 'Grace Mwikali', 'grace.m@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0722000005', 'Makueni', 'Traditional Crafts', 9, 'Traditional crafts and community guide.', 'guide_default.jpg', 4.70, '2026-03-29 19:11:47', 1, 'default.png', 3000),
(13, 'Kevin Otieno', 'kevin.o@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0733000001', 'Nairobi', 'City Tours', 4, 'City excursions and museum specialist.', 'guide_default.jpg', 4.60, '2026-03-29 19:11:47', 1, 'default.png', 2500),
(14, 'Diana Wanjiku', 'diana.w@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0733000002', 'Nairobi', 'Wildlife Photography', 7, 'Nairobi National Park and wildlife expert.', 'guide_default.jpg', 4.90, '2026-03-29 19:11:47', 1, 'default.png', 3000),
(15, 'Brian Kipchoge', 'brian.k@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0733000003', 'Nairobi', 'Urban Culture', 3, 'Nightlife and urban culture guide.', 'guide_default.jpg', 4.50, '2026-03-29 19:11:47', 1, 'default.png', 2500),
(16, 'Catherine Mueni', 'catherine.m@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0733000004', 'Nairobi', 'Art & Shopping', 5, 'Art galleries and shopping tour specialist.', 'guide_default.jpg', 4.80, '2026-03-29 19:11:47', 1, 'default.png', 3000),
(17, 'Mohammed Ali', 'mohammed.a@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0733000005', 'Nairobi', 'Logistics', 15, 'Business and conference logistics expert.', 'guide_default.jpg', 4.70, '2026-03-29 19:11:47', 1, 'default.png', 4000),
(18, 'Peter Mwololo', 'peter.mwo@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0711100001', 'Kitui', 'Wildlife', 5, 'Kitui South Reserve expert.', 'guide_default.jpg', 4.50, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(19, 'Lucy Kanini', 'lucy.k@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0711100002', 'Kitui', 'Culture', 4, 'Kamba heritage specialist.', 'guide_default.jpg', 4.60, '2026-03-29 19:14:12', 1, 'default.png', 2500),
(20, 'Benjamin Kilonzo', 'ben.k@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0711100003', 'Kitui', 'Eco-tourism', 7, 'Environmental conservationist.', 'guide_default.jpg', 4.80, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(21, 'Alice Ndunge', 'alice.n@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0711100004', 'Kitui', 'History', 3, 'Local history expert.', 'guide_default.jpg', 4.40, '2026-03-29 19:14:12', 1, 'default.png', 2500),
(22, 'Samuel Muthui', 'sam.m@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0711100005', 'Kitui', 'Hiking', 6, 'Nzambani Rock guide.', 'guide_default.jpg', 4.70, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(23, 'Joseph Ole Senteu', 'joseph.s@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0711200001', 'Narok', 'Mara Safaris', 12, 'Big five specialist.', 'guide_default.jpg', 5.00, '2026-03-29 19:14:12', 1, 'default.png', 4000),
(24, 'Mary Naserian', 'mary.nas@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0711200002', 'Narok', 'Maasai Culture', 8, 'Community leader.', 'guide_default.jpg', 4.90, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(25, 'Daniel Ole Nchoe', 'dan.n@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0711200003', 'Narok', 'Wildlife Photography', 10, 'Expert tracker.', 'guide_default.jpg', 4.80, '2026-03-29 19:14:12', 1, 'default.png', 4000),
(26, 'Grace Naipanoi', 'grace.n@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0711200004', 'Narok', 'Eco-lodging', 5, 'Sustainability expert.', 'guide_default.jpg', 4.70, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(27, 'Joshua Ole Tipis', 'josh.t@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0711200005', 'Narok', 'Mara Crossings', 15, 'Great Migration specialist.', 'guide_default.jpg', 5.00, '2026-03-29 19:14:12', 1, 'default.png', 4000),
(28, 'Salim Mwacharo', 'salim.m@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0711300001', 'Kwale', 'Marine Life', 7, 'Diani beach specialist.', 'guide_default.jpg', 4.80, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(29, 'Amina Mwaka', 'amina.mw@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0711300002', 'Kwale', 'Kaya Forest', 10, 'Sacred forest guide.', 'guide_default.jpg', 4.90, '2026-03-29 19:14:12', 1, 'default.png', 4000),
(30, 'Hamza Mwakifwa', 'hamza.m@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0711300003', 'Kwale', 'Snorkeling', 5, 'Coral reef expert.', 'guide_default.jpg', 4.60, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(31, 'Saumu Chigulu', 'saumu.c@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0711300004', 'Kwale', 'History', 4, 'Shimoni caves guide.', 'guide_default.jpg', 4.50, '2026-03-29 19:14:12', 1, 'default.png', 2500),
(32, 'Hassan Mwabonwa', 'hassan.m@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0711300005', 'Kwale', 'Culture', 6, 'Digo culture specialist.', 'guide_default.jpg', 4.70, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(33, 'Simon Ole Kina', 'simon.k@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0711400001', 'Kajiado', 'Amboseli Safaris', 9, 'Elephant tracking expert.', 'guide_default.jpg', 4.90, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(34, 'Rebecca Naisiae', 'rebecca.n@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0711400002', 'Kajiado', 'Culture', 5, 'Maasai boma guide.', 'guide_default.jpg', 4.70, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(35, 'James Ole Supeyo', 'james.s@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0711400003', 'Kajiado', 'Birds', 8, 'Bird watching specialist.', 'guide_default.jpg', 4.60, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(36, 'Lydia Nailantei', 'lydia.n@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0711400004', 'Kajiado', 'Hiking', 4, 'Ngong hills guide.', 'guide_default.jpg', 4.80, '2026-03-29 19:14:12', 1, 'default.png', 2500),
(37, 'Samson Ole Nkuruna', 'samson.n@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0711400005', 'Kajiado', 'Ecology', 7, 'Savannah ecosystem expert.', 'guide_default.jpg', 4.50, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(38, 'William Kimosop', 'will.k@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0711500001', 'Baringo', 'Boating', 11, 'Lake Baringo island expert.', 'guide_default.jpg', 4.90, '2026-03-29 19:14:12', 1, 'default.png', 4000),
(39, 'Janet Chelagat', 'janet.chel@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0711500002', 'Baringo', 'Birds', 6, 'Ornithology specialist.', 'guide_default.jpg', 4.70, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(40, 'Paul Kiptoo', 'paul.k@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0711500003', 'Baringo', 'Geology', 8, 'Hot springs guide.', 'guide_default.jpg', 4.60, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(41, 'Sarah Chepkirui', 'sarah.c@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0711500004', 'Baringo', 'Culture', 5, 'Tugen heritage guide.', 'guide_default.jpg', 4.80, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(42, 'John Kipruto', 'john.kip@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0711500005', 'Baringo', 'Hiking', 7, 'Rift Valley viewpoint expert.', 'guide_default.jpg', 4.50, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(43, 'David Kipchumba', 'david.c@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0711600001', 'Nandi', 'High Altitude', 10, 'Athletics training camp guide.', 'guide_default.jpg', 5.00, '2026-03-29 19:14:12', 1, 'default.png', 4000),
(44, 'Martha Chepkoech', 'martha.c@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0711600002', 'Nandi', 'Tea Tours', 6, 'Agro-tourism specialist.', 'guide_default.jpg', 4.80, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(45, 'Elijah Kiprop', 'elijah.k@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0711600003', 'Nandi', 'Forestry', 8, 'Nandi forest guide.', 'guide_default.jpg', 4.70, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(46, 'Ruth Chepchirchir', 'ruth.c@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0711600004', 'Nandi', 'History', 5, 'Koitalel Samoei museum expert.', 'guide_default.jpg', 4.90, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(47, 'Isaac Kipngeno', 'isaac.k@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0711600005', 'Nandi', 'Eco-tourism', 7, 'Nature walk specialist.', 'guide_default.jpg', 4.60, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(48, 'Samuel Kipkemboi', 'sam.kip@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0711700001', 'Elgeyo Marakwet', 'Paragliding', 12, 'Kerio Valley expert.', 'guide_default.jpg', 5.00, '2026-03-29 19:14:12', 1, 'default.png', 4000),
(49, 'Esther Chebet', 'esther.c@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0711700002', 'Elgeyo Marakwet', 'Athletics', 5, 'Training camp guide.', 'guide_default.jpg', 4.80, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(50, 'Caleb Kipkorir', 'caleb.k@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0711700003', 'Elgeyo Marakwet', 'Hiking', 8, 'Escarpment trekking expert.', 'guide_default.jpg', 4.70, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(51, 'Grace Chemutai', 'grace.c@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0711700004', 'Elgeyo Marakwet', 'Culture', 4, 'Marakwet heritage guide.', 'guide_default.jpg', 4.60, '2026-03-29 19:14:12', 1, 'default.png', 2500),
(52, 'Joseph Kiprono', 'joseph.k@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0711700005', 'Elgeyo Marakwet', 'Waterfalls', 7, 'Torok falls specialist.', 'guide_default.jpg', 4.90, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(53, 'Peter Wamalwa', 'peter.w@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0711800001', 'Trans Nzoia', 'Hiking', 10, 'Mt. Elgon park expert.', 'guide_default.jpg', 4.80, '2026-03-29 19:14:12', 1, 'default.png', 4000),
(54, 'Mercy Nasimiyu', 'mercy.n@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0711800002', 'Trans Nzoia', 'Caving', 6, 'Kitum cave specialist.', 'guide_default.jpg', 4.70, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(55, 'John Wafula', 'john.w@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0711800003', 'Trans Nzoia', 'Agro-tourism', 8, 'Seed production farms guide.', 'guide_default.jpg', 4.60, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(56, 'Rose Nekesa', 'rose.n@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0711800004', 'Trans Nzoia', 'Culture', 5, 'Bukusu heritage guide.', 'guide_default.jpg', 4.90, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(57, 'James Wekesa', 'james.w@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0711800005', 'Trans Nzoia', 'Birds', 7, 'Saiwa Swamp specialist.', 'guide_default.jpg', 4.50, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(58, 'Solomon Wanjala', 'solo.w@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0711900001', 'Bungoma', 'History', 9, 'Chetambe hills expert.', 'guide_default.jpg', 4.70, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(59, 'Mary Nafula', 'mary.naf@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0711900002', 'Bungoma', 'Culture', 7, 'Circumcision ceremony guide.', 'guide_default.jpg', 5.00, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(60, 'Timothy Simiyu', 'tim.s@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0711900003', 'Bungoma', 'Nature', 5, 'Mt Elgon caves specialist.', 'guide_default.jpg', 4.60, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(61, 'Elizabeth Naliaka', 'eliz.n@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0711900004', 'Bungoma', 'Hiking', 4, 'Sang\'alo hills guide.', 'guide_default.jpg', 4.50, '2026-03-29 19:14:12', 1, 'default.png', 2500),
(62, 'Moses Wanyonyi', 'moses.w@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0711900005', 'Bungoma', 'Agro-tourism', 6, 'Sugarcane farming expert.', 'guide_default.jpg', 4.80, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(63, 'Zachariah Ayoti', 'zach.a@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0712000001', 'Kakamega', 'Rainforest', 11, 'Tropical forest expert.', 'guide_default.jpg', 4.90, '2026-03-29 19:14:12', 1, 'default.png', 4000),
(64, 'Agnes Avoga', 'agnes.a@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0712000002', 'Kakamega', 'Birds', 8, 'Rainforest bird specialist.', 'guide_default.jpg', 4.80, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(65, 'Nathaniel Muyeka', 'nath.m@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0712000003', 'Kakamega', 'Culture', 6, 'Crying stone guide.', 'guide_default.jpg', 4.70, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(66, 'Beatrice Khayesi', 'beat.k@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0712000004', 'Kakamega', 'Medicinal Plants', 10, 'Herbalist and nature guide.', 'guide_default.jpg', 5.00, '2026-03-29 19:14:12', 1, 'default.png', 4000),
(67, 'Joshua Indeche', 'josh.i@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0712000005', 'Kakamega', 'Hiking', 5, 'Forest canopy walk expert.', 'guide_default.jpg', 4.60, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(68, 'Tom Omondi', 'tom.o@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0712100001', 'Kisumu', 'Boating', 9, 'Lake Victoria specialist.', 'guide_default.jpg', 4.80, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(69, 'Phoebe Atieno', 'phoebe.at@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0712100002', 'Kisumu', 'Wildlife', 5, 'Impala sanctuary guide.', 'guide_default.jpg', 4.70, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(70, 'George Otieno', 'george.o@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0712100003', 'Kisumu', 'Culture', 7, 'Kit Mikayi specialist.', 'guide_default.jpg', 4.90, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(71, 'Mildred Akinyi', 'mildred.a@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0712100004', 'Kisumu', 'Fishing', 4, 'Traditional fishing expert.', 'guide_default.jpg', 4.50, '2026-03-29 19:14:12', 1, 'default.png', 2500),
(72, 'James Odhiambo', 'james.o@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0712100005', 'Kisumu', 'City Tours', 6, 'Lakeside city guide.', 'guide_default.jpg', 4.60, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(73, 'Barack Ochieng', 'barack.o@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0712200001', 'Homa Bay', 'Hiking', 10, 'Mt. Homa park expert.', 'guide_default.jpg', 4.90, '2026-03-29 19:14:12', 1, 'default.png', 4000),
(74, 'Dorcas Achieng', 'dorcas.a@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0712200002', 'Homa Bay', 'History', 6, 'Rusinga island specialist.', 'guide_default.jpg', 4.70, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(75, 'Meshack Owino', 'mesh.o@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0712200003', 'Homa Bay', 'Birds', 8, 'Lakeside bird guide.', 'guide_default.jpg', 4.80, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(76, 'Grace Awuor', 'grace.aw@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0712200004', 'Homa Bay', 'Archaeology', 5, 'Tom Mboya museum expert.', 'guide_default.jpg', 4.60, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(77, 'Fredrick Ouma', 'fred.o@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0712200005', 'Homa Bay', 'Islands', 7, 'Mfangano island guide.', 'guide_default.jpg', 4.50, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(78, 'John Oloo', 'john.oloo@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0712300001', 'Migori', 'History', 11, 'Thimlich Ohinga expert.', 'guide_default.jpg', 5.00, '2026-03-29 19:14:12', 1, 'default.png', 4000),
(79, 'Veronica Akoth', 'veron.a@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0712300002', 'Migori', 'Mining', 4, 'Gold mining area guide.', 'guide_default.jpg', 4.40, '2026-03-29 19:14:12', 1, 'default.png', 2500),
(80, 'Peter Marwa', 'peter.mar@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0712300003', 'Migori', 'Culture', 7, 'Kuria heritage specialist.', 'guide_default.jpg', 4.80, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(81, 'Paul Matagaro', 'paul.m@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0712300004', 'Migori', 'Eco-tourism', 6, 'Lakeside conservationist.', 'guide_default.jpg', 4.60, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(82, 'Eunice Moraa', 'eunice.m@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0712300005', 'Migori', 'Fishing', 5, 'Lake Victoria fishing guide.', 'guide_default.jpg', 4.70, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(83, 'Ekeno Lokiru', 'ekeno.l@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0712400001', 'Turkana', 'Lake Tours', 12, 'Lake Turkana specialist.', 'guide_default.jpg', 5.00, '2026-03-29 19:14:12', 1, 'default.png', 4000),
(84, 'Peter Etiyang', 'peter.e@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0712400002', 'Turkana', 'Archaeology', 8, 'Turkana Boy site expert.', 'guide_default.jpg', 4.90, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(85, 'Mary Nakiru', 'mary.naki@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0712400003', 'Turkana', 'Culture', 10, 'Turkana heritage guide.', 'guide_default.jpg', 4.80, '2026-03-29 19:14:12', 1, 'default.png', 4000),
(86, 'Joseph Lochoto', 'joseph.l@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0712400004', 'Turkana', 'Islands', 6, 'Central Island park expert.', 'guide_default.jpg', 4.70, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(87, 'Ruth Nangiro', 'ruth.n@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0712400005', 'Turkana', 'Nature', 5, 'Eliye Springs guide.', 'guide_default.jpg', 4.60, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(88, 'Henry Mwiti', 'henry.m@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0712500001', 'Meru', 'Safaris', 11, 'Meru National Park expert.', 'guide_default.jpg', 4.90, '2026-03-29 19:14:12', 1, 'default.png', 4000),
(89, 'Gladys Kajuju', 'gladys.k@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0712500002', 'Meru', 'Eco-tourism', 7, 'Nyambene hills guide.', 'guide_default.jpg', 4.80, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(90, 'Silas Muthuri', 'silas.m@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0712500003', 'Meru', 'Agro-tourism', 6, 'Miraa and tea farm expert.', 'guide_default.jpg', 4.60, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(91, 'Lucy Kanana', 'lucy.kana@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0712500004', 'Meru', 'Culture', 5, 'Ameru heritage specialist.', 'guide_default.jpg', 4.70, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(92, 'Patrick Mutembei', 'patrick.mut@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0712500005', 'Meru', 'Hiking', 8, 'Mount Kenya eastern route expert.', 'guide_default.jpg', 4.50, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(93, 'Mohammed Jirma', 'mo.j@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0712600001', 'Isiolo', 'Safaris', 12, 'Buffalo Springs specialist.', 'guide_default.jpg', 5.00, '2026-03-29 19:14:12', 1, 'default.png', 4000),
(94, 'Fatuma Dida', 'fatuma.d@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0712600002', 'Isiolo', 'Culture', 8, 'Northern Kenya heritage guide.', 'guide_default.jpg', 4.80, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(95, 'David Lengees', 'david.l@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0712600003', 'Isiolo', 'Nature', 7, 'Samburu landscape expert.', 'guide_default.jpg', 4.70, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(96, 'Hawa Guyo', 'hawa.g@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0712600004', 'Isiolo', 'Wildlife Photography', 10, 'Expert bush tracker.', 'guide_default.jpg', 4.90, '2026-03-29 19:14:12', 1, 'default.png', 4000),
(97, 'Joseph Leshimba', 'joe.l@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0712600005', 'Isiolo', 'Eco-lodging', 6, 'Wilderness specialist.', 'guide_default.jpg', 4.60, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(98, 'James Mwangi', 'james.mwa@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0712900001', 'Laikipia', 'Safaris', 11, 'Ol Pejeta conservancy expert.', 'guide_default.jpg', 5.00, '2026-03-29 19:14:12', 1, 'default.png', 4000),
(99, 'Mary Naisula', 'mary.nai@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0712900002', 'Laikipia', 'Culture', 7, 'Samburu village guide.', 'guide_default.jpg', 4.80, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(100, 'Joseph Leshao', 'joe.les@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0712900003', 'Laikipia', 'Wildlife Photography', 10, 'Bush tracking specialist.', 'guide_default.jpg', 4.90, '2026-03-29 19:14:12', 1, 'default.png', 4000),
(101, 'Esther Wambui', 'esther.wam@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0712900004', 'Laikipia', 'Eco-tourism', 6, 'Sustainability expert.', 'guide_default.jpg', 4.70, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(102, 'Daniel Ole Ntutu', 'dan.ntu@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0712900005', 'Laikipia', 'Nature', 9, 'Savannah ecology expert.', 'guide_default.jpg', 4.60, '2026-03-29 19:14:12', 1, 'default.png', 3000),
(103, 'James Gathua', 'james.gathua@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0712700001', 'Murang\'a', 'Aberdare Trekking', 8, 'Expert in high-altitude hiking and Aberdare forest trails.', 'guide_default.jpg', 4.90, '2026-03-29 19:20:30', 1, 'default.png', 2500),
(104, 'Mary Wacera', 'mary.wacera@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0712700002', 'Murang\'a', 'Agro-tourism', 6, 'Specialist in coffee and tea farm tours in the central highlands.', 'guide_default.jpg', 4.70, '2026-03-29 19:20:30', 1, 'default.png', 2500),
(105, 'Peter Gĩtahi', 'peter.gitahi@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0712700003', 'Murang\'a', 'Culture', 10, 'Guardian of Mukurwe wa Nyagathanga shrines and Agikuyu history.', 'guide_default.jpg', 5.00, '2026-03-29 19:20:30', 1, 'default.png', 2500),
(106, 'John Masau', 'john.masau@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0712700004', 'Murang\'a', 'Waterfalls & Rivers', 5, 'Expert guide for Sagana river activities and local waterfalls.', 'guide_default.jpg', 4.60, '2026-03-29 19:20:30', 1, 'default.png', 2500),
(107, 'Grace Wamucii', 'grace.wamucii@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0712700005', 'Murang\'a', 'Eco-tourism', 7, 'Specializes in Ndakaini Dam excursions and nature conservation.', 'guide_default.jpg', 4.80, '2026-03-29 19:20:30', 1, 'default.png', 2500),
(108, 'Mwangi Maina', 'mwangi.maina@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0712800001', 'Nyeri', 'Mountaineering', 12, 'Certified Mt. Kenya lead guide with over 50 successful summits.', 'guide_default.jpg', 5.00, '2026-03-29 19:22:52', 1, 'default.png', 2500),
(109, 'Wanjiku Nyawira', 'wanjiku.n@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0712800002', 'Nyeri', 'History & Scouting', 7, 'Specialist in Baden-Powell history and Nyeri town heritage tours.', 'guide_default.jpg', 4.80, '2026-03-29 19:22:52', 1, 'default.png', 2500),
(110, 'Kamau Ngũgĩ', 'kamau.ngugi@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0712800003', 'Nyeri', 'Forest Trekking', 9, 'Expert in Aberdare forest trails, bird watching, and Zaina falls.', 'guide_default.jpg', 4.90, '2026-03-29 19:22:52', 1, 'default.png', 2500),
(111, 'Muthoni Waithaka', 'muthoni.w@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0712800004', 'Nyeri', 'Agro-tourism', 5, 'Specialist in Nyeri coffee tours and tea farm excursions.', 'guide_default.jpg', 4.70, '2026-03-29 19:22:52', 1, 'default.png', 2500),
(112, 'Gĩtonga Mũramĩ', 'gitonga.m@example.com', '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe', '0712800005', 'Nyeri', 'Photography', 6, 'Nature photographer and guide for scenic viewpoints in Nyeri.', 'guide_default.jpg', 4.60, '2026-03-29 19:22:52', 1, 'default.png', 2500)
(115,
    'Kipchumba Bett', 
    'kipchumba.b@example.com', 
    '$2y$10$Hlzb7QZ/cLYVxqd2VXIptu3D3NhhgHgCdiWCvdF7mWoo8Y2V67hCe',
    '0712345678', 
    'Elgeyo-Marakwet', 
    'High-Altitude Hiking & Athletics Tourism', 
    7, 
    'Born and raised in the Home of Champions, I specialize in guiding tourists through the scenic Kerio Valley and organizing high-altitude hiking expeditions in the Iten highlands.', 
    'guide_default.jpg', 
    4.8, '2026-04-19 17:49:20' ,
    1, 
    'default.jpg', 
    3500);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `guide_id` int(11) NOT NULL,
  `attraction_id` int(11) DEFAULT NULL,
  `user_name` varchar(100) NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `guide_id`, `attraction_id`, `user_name`, `rating`, `comment`, `created_at`) VALUES
(2, 103, 79, 'Admin_Mwaura', 5, 'very nice', '2026-04-16 11:21:04');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'chris mwangi', 'test@gmail.com', '$2y$10$zjpW0uXNQ6zwCcmOymJK2OA/WlZsaJLKloS3Q3gAKmuY8tJ8xa05i', 'user', '2026-03-11 09:49:21'),
(2, 'wycl_leaf', 'w@gmail.com', '$2y$10$A0tKft/jDJ3F5XjFj5YFZe1fv7HT0irkoTBKZMhUysgrb68IUrfnS', 'user', '2026-03-14 18:22:33'),
(5, 'eunice', 'eunice@gmail.com', '$2y$10$hpsm.6gJeApI6YZPNG8z..ZOFxAQgPPpSpAa77J4rZzc12EMj7rEu', 'user', '2026-03-29 18:42:39'),
(6, 'yung', 'vngugi90@gmail.com', '$2y$10$/tdpMmJ2XJR5xV6T7Vwu9uqEwIHlCrTYnfMoJWF8NsIoDLGgMvsCu', 'user', '2026-04-05 16:58:24'),
(7, 'john', 'john@masaku.com', '$2y$10$QLhqALTw6kVF2K3s8MDGHODxku65AF2/WAwqU1Vzy.e41rti8NfKa', 'user', '2026-04-07 07:24:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `attractions`
--
ALTER TABLE `attractions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `attraction_id` (`attraction_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guides`
--
ALTER TABLE `guides`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guide_id` (`guide_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `attractions`
--
ALTER TABLE `attractions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `guides`
--
ALTER TABLE `guides`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`attraction_id`) REFERENCES `attractions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`guide_id`) REFERENCES `guides` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

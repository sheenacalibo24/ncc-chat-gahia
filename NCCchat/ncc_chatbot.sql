-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 01, 2026 at 09:19 AM
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
-- Database: `ncc_chatbot`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `role` varchar(50) DEFAULT 'admin',
  `is_active` tinyint(4) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password`, `email`, `role`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 'admin', '$2y$10$EpxpvINDf5Vhcj.D4yScHuuwHcSyz.gwtVdMNgW6lOl4bcXTqti9a', 'admin@nccebu.edu.ph', 'admin', 1, '2026-04-30 16:55:35', '2026-04-30 16:55:35');

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `is_active` tinyint(4) DEFAULT 1,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat_analytics`
--

CREATE TABLE `chat_analytics` (
  `id` int(11) NOT NULL,
  `question` text NOT NULL,
  `ask_count` int(11) DEFAULT 1,
  `last_asked` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

CREATE TABLE `conversations` (
  `id` int(11) NOT NULL,
  `session_id` varchar(255) NOT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `conversations`
--

INSERT INTO `conversations` (`id`, `session_id`, `user_name`, `email`, `created_at`, `updated_at`) VALUES
(1, 'ncc_1777566162005_y87xyaxzy', 'Guest', NULL, '2026-04-30 16:23:05', '2026-04-30 16:23:05');

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE `faq` (
  `id` int(11) NOT NULL,
  `category` varchar(100) NOT NULL,
  `question` text NOT NULL,
  `answer` longtext NOT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faq`
--

INSERT INTO `faq` (`id`, `category`, `question`, `answer`, `keywords`, `created_at`, `updated_at`) VALUES
(1, 'Admissions', 'What are the admission requirements for NCC?', 'NCC accepts students with a high school diploma or equivalent. For college programs, you need to submit: high school transcript, entrance exam result, and a completed application form. For inquiries, visit our admission office.', 'admission requirements', '2026-04-30 16:22:42', '2026-04-30 16:22:42'),
(2, 'Admissions', 'What is the admission process?', '1. Submit application form\n2. Take entrance exam\n3. Review results\n4. Attend orientation\n5. Enroll in courses', 'admission process steps', '2026-04-30 16:22:42', '2026-04-30 16:22:42'),
(3, 'Admissions', 'What programs does NCC offer?', 'NCC offers various programs including: Engineering, Business Administration, Information Technology, Education, Nursing, and General Academic Strand. Visit our website for complete program list.', 'programs courses', '2026-04-30 16:22:42', '2026-04-30 16:22:42'),
(4, 'Finance', 'How much is the tuition fee?', 'Tuition fees vary by program. Approximately: High School - ₱50,000-70,000/year, College - ₱80,000-120,000/year. Contact our finance office for exact rates and scholarship options.', 'tuition fees cost', '2026-04-30 16:22:42', '2026-04-30 16:22:42'),
(5, 'Finance', 'Do you offer scholarships?', 'Yes! NCC offers academic scholarships, athletic scholarships, and need-based financial aid. Contact the Financial Aid Office for more information.', 'scholarships financial aid', '2026-04-30 16:22:42', '2026-04-30 16:22:42'),
(6, 'Campus Life', 'What activities are available at NCC?', 'We have sports clubs, academic societies, student government, cultural groups, debate team, and various special interest clubs. Check the Student Affairs office for membership details.', 'clubs activities organizations', '2026-04-30 16:22:42', '2026-04-30 16:22:42'),
(7, 'Campus Life', 'What facilities does NCC have?', 'NCC features: modern classrooms, computer labs, science laboratories, library, cafeteria, gymnasium, sports complex, and student commons area.', 'facilities amenities infrastructure', '2026-04-30 16:22:42', '2026-04-30 16:22:42'),
(8, 'Academic', 'What is the academic calendar?', 'School Year: June-April. First Semester: June-October. Second Semester: November-April. Summer classes: May.', 'academic calendar schedule', '2026-04-30 16:22:42', '2026-04-30 16:22:42'),
(9, 'Academic', 'How can I get academic support?', 'NCC provides: tutoring services, counseling, academic advisors, and peer mentoring. Visit the Student Services office for assistance.', 'help support tutoring', '2026-04-30 16:22:42', '2026-04-30 16:22:42'),
(10, 'Contact', 'How do I contact NCC?', 'Main Office: (032) 268-8000\nEmail: info@nccebu.edu.ph\nAddress: Osmeña Blvd, Cebu City\nVisit: www.nccebu.edu.ph', 'contact number phone', '2026-04-30 16:22:42', '2026-04-30 16:22:42');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `conversation_id` int(11) NOT NULL,
  `sender` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `conversation_id`, `sender`, `message`, `created_at`) VALUES
(1, 1, 'user', 'Tell me about NCC', '2026-04-30 16:23:05'),
(2, 1, 'bot', 'Thank you for your question! ???? I don\'t have specific information about that in my database, but here are some ways to get help:\n\n• Visit our website: www.nccebu.edu.ph\n• Call our office: (032) 268-8000\n• Email: info@nccebu.edu.ph\n• Visit us at: Osmeña Blvd, Cebu City\n\nIs there anything else I can help you with?', '2026-04-30 16:23:05'),
(3, 1, 'user', 'What programs are available', '2026-04-30 16:23:11'),
(4, 1, 'bot', 'Thank you for your question! ???? I don\'t have specific information about that in my database, but here are some ways to get help:\n\n• Visit our website: www.nccebu.edu.ph\n• Call our office: (032) 268-8000\n• Email: info@nccebu.edu.ph\n• Visit us at: Osmeña Blvd, Cebu City\n\nIs there anything else I can help you with?', '2026-04-30 16:23:11'),
(5, 1, 'user', 'How much is tuition', '2026-04-30 16:23:14'),
(6, 1, 'bot', 'Thank you for your question! ???? I don\'t have specific information about that in my database, but here are some ways to get help:\n\n• Visit our website: www.nccebu.edu.ph\n• Call our office: (032) 268-8000\n• Email: info@nccebu.edu.ph\n• Visit us at: Osmeña Blvd, Cebu City\n\nIs there anything else I can help you with?', '2026-04-30 16:23:14'),
(7, 1, 'user', 'Contact information', '2026-04-30 16:23:24'),
(8, 1, 'bot', 'Thank you for your question! ???? I don\'t have specific information about that in my database, but here are some ways to get help:\n\n• Visit our website: www.nccebu.edu.ph\n• Call our office: (032) 268-8000\n• Email: info@nccebu.edu.ph\n• Visit us at: Osmeña Blvd, Cebu City\n\nIs there anything else I can help you with?', '2026-04-30 16:23:24'),
(9, 1, 'user', 'hi', '2026-04-30 16:23:43'),
(10, 1, 'bot', 'Hello! ???? Welcome to NCC (Northeastern Cebu Colleges) Chatbot. How can I help you today? Feel free to ask me about admissions, programs, tuition, campus life, or any other school information!', '2026-04-30 16:23:43'),
(11, 1, 'user', 'How much is tuition', '2026-04-30 17:15:21'),
(12, 1, 'bot', 'Thank you for your question! ???? I don\'t have specific information about that in my database, but here are some ways to get help:\n\n• Visit our website: www.nccebu.edu.ph\n• Call our office: (032) 268-8000\n• Email: info@nccebu.edu.ph\n• Visit us at: Osmeña Blvd, Cebu City\n\nIs there anything else I can help you with?', '2026-04-30 17:15:21'),
(13, 1, 'user', 'Contact information', '2026-04-30 17:15:30'),
(14, 1, 'bot', 'Thank you for your question! ???? I don\'t have specific information about that in my database, but here are some ways to get help:\n\n• Visit our website: www.nccebu.edu.ph\n• Call our office: (032) 268-8000\n• Email: info@nccebu.edu.ph\n• Visit us at: Osmeña Blvd, Cebu City\n\nIs there anything else I can help you with?', '2026-04-30 17:15:30'),
(15, 1, 'user', 'What programs are available', '2026-04-30 17:15:33'),
(16, 1, 'bot', 'Thank you for your question! ???? I don\'t have specific information about that in my database, but here are some ways to get help:\n\n• Visit our website: www.nccebu.edu.ph\n• Call our office: (032) 268-8000\n• Email: info@nccebu.edu.ph\n• Visit us at: Osmeña Blvd, Cebu City\n\nIs there anything else I can help you with?', '2026-04-30 17:15:33'),
(17, 1, 'user', 'How much is tuition', '2026-04-30 17:15:35'),
(18, 1, 'bot', 'Thank you for your question! ???? I don\'t have specific information about that in my database, but here are some ways to get help:\n\n• Visit our website: www.nccebu.edu.ph\n• Call our office: (032) 268-8000\n• Email: info@nccebu.edu.ph\n• Visit us at: Osmeña Blvd, Cebu City\n\nIs there anything else I can help you with?', '2026-04-30 17:15:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `username_2` (`username`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `is_active` (`is_active`);

--
-- Indexes for table `chat_analytics`
--
ALTER TABLE `chat_analytics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ask_count` (`ask_count`);

--
-- Indexes for table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `session_id` (`session_id`),
  ADD KEY `session_id_2` (`session_id`);

--
-- Indexes for table `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category` (`category`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `conversation_id` (`conversation_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chat_analytics`
--
ALTER TABLE `chat_analytics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `faq`
--
ALTER TABLE `faq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `announcements_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `admin_users` (`id`);

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 21, 2025 at 08:19 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `college_web_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `announcement` text DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `announcement`, `created_by`, `created_at`) VALUES
(9, 'Todays All Lecture Are Cancled...', 'Prof D R Pardhi', '2025-03-10 06:55:45'),
(10, 'Hrllo', 'Prof D R Pardhi', '2025-03-21 11:33:40');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `lecture_type` enum('lecture','practical') DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `student_id`, `course_id`, `date`, `lecture_type`, `subject`, `status`) VALUES
(7, 1, NULL, '2025-03-04', 'practical', 'MAN', 1),
(8, 1, NULL, '2025-03-05', 'lecture', 'MAD', 1),
(9, 1, NULL, '2025-03-05', 'practical', 'pwp', 1),
(10, 1, NULL, '2025-03-21', 'lecture', 'php', 1),
(11, 1, NULL, '2025-03-21', 'lecture', 'sss', 1),
(12, 2, NULL, '2025-03-21', 'lecture', 'sss', 0),
(13, 3, NULL, '2025-03-21', 'lecture', 'sss', 1),
(14, 1, NULL, '2025-03-21', 'practical', 'sss', 0),
(15, 2, NULL, '2025-03-21', 'practical', 'sss', 0),
(16, 3, NULL, '2025-03-21', 'practical', 'sss', 0),
(17, 4, NULL, '2025-03-21', 'practical', 'sss', 1),
(18, 1, NULL, '2025-03-11', 'lecture', 'ooo', 1),
(19, 2, NULL, '2025-03-11', 'lecture', 'ooo', 0),
(20, 3, NULL, '2025-03-11', 'lecture', 'ooo', 1),
(21, 4, NULL, '2025-03-11', 'lecture', 'ooo', 0),
(22, 1, NULL, '2025-03-24', 'lecture', 'wer', 1),
(23, 2, NULL, '2025-03-24', 'lecture', 'wer', 0),
(24, 3, NULL, '2025-03-24', 'lecture', 'wer', 1),
(25, 4, NULL, '2025-03-24', 'lecture', 'wer', 0),
(26, 1, NULL, '2025-03-22', 'lecture', 'abc', 1),
(27, 2, NULL, '2025-03-22', 'lecture', 'abc', 1),
(28, 3, NULL, '2025-03-22', 'lecture', 'abc', 1),
(29, 4, NULL, '2025-03-22', 'lecture', 'abc', 1),
(30, 1, NULL, '2025-03-22', 'lecture', 'xyz', 1),
(31, 2, NULL, '2025-03-22', 'lecture', 'xyz', 1),
(32, 3, NULL, '2025-03-22', 'lecture', 'xyz', 0),
(33, 4, NULL, '2025-03-22', 'lecture', 'xyz', 1);

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `course_name` varchar(100) DEFAULT NULL,
  `course_code` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `crs`
--

CREATE TABLE `crs` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `dept` varchar(50) DEFAULT NULL,
  `year` varchar(10) DEFAULT NULL,
  `semester` int(11) DEFAULT NULL,
  `enrollment_no` varchar(50) DEFAULT NULL,
  `mobile_no` varchar(15) DEFAULT NULL,
  `cr_code` varchar(50) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `crs`
--

INSERT INTO `crs` (`id`, `name`, `email`, `password`, `dept`, `year`, `semester`, `enrollment_no`, `mobile_no`, `cr_code`, `profile_picture`) VALUES
(1, 'Sakshi Karale', 'pqr@email.com', '$2y$10$.QhOJ2bC4yyBgEjTwVut/O9z/nuvWUdLJsFORGVWa0lM8foEXq3uq', 'CS', '1st', 1, '123', '7070707070', 'CR001', 'uploads/profile_pictures/download.png');

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `dept` varchar(50) DEFAULT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `mobile_no` varchar(15) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`id`, `name`, `email`, `password`, `dept`, `subject`, `mobile_no`, `profile_picture`) VALUES
(1, 'Prof D R Pardhi', 'xyz@email.com', '$2y$10$ylUonqjOACLRvBlzBDuQL.QkjSdfbMBnDqVda3UkqtsoZMjEqxnza', 'CS', 'mad', '7070707070', 'uploads/profile_pictures/WhatsApp Image 2025-03-10 at 12.05.51 PM.jpeg'),
(2, 'satish patil', 'satishpatil@gmail.com', '$2y$10$iRXUhUH89.f3LJOO5OaYcObSCmcaxOmU2OG.UbZAwcfnAYmXDH01.', 'CS', 'MAN', '8446294458', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `queries`
--

CREATE TABLE `queries` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `query` text DEFAULT NULL,
  `response` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `queries`
--

INSERT INTO `queries` (`id`, `student_id`, `query`, `response`, `created_at`) VALUES
(5, 2, 'Is There Any Lecture Today?', 'No...All Lecture Are Canceled ', '2025-03-10 06:53:10'),
(6, 2, 'hello', 'ok', '2025-03-10 10:06:25'),
(7, 2, 'hwllo', 'hello', '2025-03-21 11:35:27');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `dept` varchar(50) DEFAULT NULL,
  `year` varchar(10) DEFAULT NULL,
  `semester` int(11) DEFAULT NULL,
  `enrollment_no` varchar(50) DEFAULT NULL,
  `mobile_no` varchar(15) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `email`, `password`, `dept`, `year`, `semester`, `enrollment_no`, `mobile_no`, `profile_picture`) VALUES
(1, 'abc', 'abc@email', '$2y$10$OPdF6KBmeouHYjMl9PNtbex1VeH.i/qIxTQvKOSWjXR0/c//XD4XS', 'CS', '1st', 1, '123', '7070707070', 'uploads/profile_pictures/Screenshot (4).png'),
(2, 'Onkar Bansode ', 'onkarbansode066@gmail.com', '$2y$10$mwx7A.zWgxqMA/hpThMYIOH6TqYCxxvDyNisUbePYiIvC6WcBQ26e', 'CS', '1st', 1, '2201300276', '9359206011', 'uploads/profile_pictures/logo.webp'),
(3, 'Aditya Dandwate', 'dandwateaditya@gmail.com', '$2y$10$DDfrI39oUzI4Rj3RWmj58uZ/WZvYX2agWdcsuUnKtPUvhaF/wrCuW', 'CS', '3rd', 6, '2201300283', '8605609207', 'uploads/profile_pictures/20240831_094102.jpg'),
(4, 'Pranav Sherkar', 'pranavsherkar2006@gmail.com', '$2y$10$qzvA7UNz8biEyhoMFcUcb.bB4vHWWTWuOlWQS.73r/VBZ.xodTcjy', 'CS', '3rd', 6, '2201300330', '8624069640', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `students_courses`
--

CREATE TABLE `students_courses` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `study_material`
--

CREATE TABLE `study_material` (
  `id` int(11) NOT NULL,
  `subject_name` varchar(255) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `uploaded_by` int(11) DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `study_material`
--

INSERT INTO `study_material` (`id`, `subject_name`, `course_id`, `file_path`, `uploaded_by`, `uploaded_at`) VALUES
(4, 'PHP', NULL, 'uploads/study_materials/Php 7-16 pract.pdf', 1, '2025-03-10 06:55:13'),
(5, 'wbp', NULL, 'uploads/study_materials/New kpi_norms 04Sept2018 (I).pdf', 1, '2025-03-10 10:08:34'),
(6, 'itr', NULL, 'uploads/study_materials/Scanned_20250303_232626.pdf', 1, '2025-03-21 11:34:13');

-- --------------------------------------------------------

--
-- Table structure for table `test_marks`
--

CREATE TABLE `test_marks` (
  `id` int(11) NOT NULL,
  `subject_name` varchar(255) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `marks_pdf` varchar(255) DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `uploaded_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `test_marks`
--

INSERT INTO `test_marks` (`id`, `subject_name`, `student_id`, `course_id`, `marks_pdf`, `uploaded_at`, `uploaded_by`) VALUES
(3, 'PHP', NULL, NULL, 'uploads/test_marks/PHP_UT_-_1_ans..pdf', '2025-03-10 06:56:21', 1);

-- --------------------------------------------------------

--
-- Table structure for table `timetable`
--

CREATE TABLE `timetable` (
  `id` int(11) NOT NULL,
  `day` varchar(10) DEFAULT NULL,
  `time` varchar(10) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `faculty_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`,`course_id`,`date`,`lecture_type`,`subject`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `crs`
--
ALTER TABLE `crs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `queries`
--
ALTER TABLE `queries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `students_courses`
--
ALTER TABLE `students_courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `study_material`
--
ALTER TABLE `study_material`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `uploaded_by` (`uploaded_by`);

--
-- Indexes for table `test_marks`
--
ALTER TABLE `test_marks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `uploaded_by` (`uploaded_by`);

--
-- Indexes for table `timetable`
--
ALTER TABLE `timetable`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `faculty_id` (`faculty_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `crs`
--
ALTER TABLE `crs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `queries`
--
ALTER TABLE `queries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `students_courses`
--
ALTER TABLE `students_courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `study_material`
--
ALTER TABLE `study_material`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `test_marks`
--
ALTER TABLE `test_marks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `timetable`
--
ALTER TABLE `timetable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`),
  ADD CONSTRAINT `attendance_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`);

--
-- Constraints for table `queries`
--
ALTER TABLE `queries`
  ADD CONSTRAINT `queries_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);

--
-- Constraints for table `students_courses`
--
ALTER TABLE `students_courses`
  ADD CONSTRAINT `students_courses_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`),
  ADD CONSTRAINT `students_courses_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`);

--
-- Constraints for table `study_material`
--
ALTER TABLE `study_material`
  ADD CONSTRAINT `study_material_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
  ADD CONSTRAINT `study_material_ibfk_2` FOREIGN KEY (`uploaded_by`) REFERENCES `faculty` (`id`),
  ADD CONSTRAINT `study_material_ibfk_3` FOREIGN KEY (`uploaded_by`) REFERENCES `faculty` (`id`);

--
-- Constraints for table `test_marks`
--
ALTER TABLE `test_marks`
  ADD CONSTRAINT `test_marks_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`),
  ADD CONSTRAINT `test_marks_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
  ADD CONSTRAINT `test_marks_ibfk_3` FOREIGN KEY (`uploaded_by`) REFERENCES `faculty` (`id`),
  ADD CONSTRAINT `test_marks_ibfk_4` FOREIGN KEY (`uploaded_by`) REFERENCES `faculty` (`id`);

--
-- Constraints for table `timetable`
--
ALTER TABLE `timetable`
  ADD CONSTRAINT `timetable_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
  ADD CONSTRAINT `timetable_ibfk_2` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

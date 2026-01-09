-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 09, 2026 at 07:19 AM
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
-- Database: `studyspark`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `activity_log_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `date` varchar(100) NOT NULL,
  `action` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`activity_log_id`, `username`, `date`, `action`) VALUES
(12, 'aini', '2025-05-07 02:11:33', 'Edit User razak'),
(13, 'aini', '2025-05-07 02:13:04', 'Edit User aisyah'),
(14, 'aini', '2025-05-07 02:13:39', 'Edit User aini'),
(15, 'aini', '2025-05-07 02:28:32', 'Edit User razak'),
(16, 'razak', '2025-05-07 02:51:37', 'Add School Year a'),
(17, 'aini', '2025-05-18 18:09:21', 'Edit Course CSP650'),
(18, 'aini', '2025-05-18 18:16:21', 'Edit Course ICT602'),
(19, 'aini', '2025-05-18 18:17:07', 'Edit Course ICT602'),
(20, 'aini', '2025-05-18 18:18:15', 'Edit Course ICT602'),
(21, 'aini', '2025-07-01 00:15:03', 'Add User ainayasmin'),
(22, 'aini', '2025-07-06 15:52:09', 'Add Semester OCTOBER 2025 â€“ FEBRUARY 2026'),
(23, 'aini', '2025-07-06 15:52:15', 'Add Semester OKTOBER 2025 â€“ FEBRUARI 2026'),
(24, 'aini', '2025-07-06 16:18:10', 'Add Semester OKTOBER 2025 â€“ FEBRUARI 2026'),
(25, 'aini', '2025-07-06 16:20:04', 'Add Semester OKTOBER 2025 â€“ FEBRUARI 2027'),
(26, 'aini', '2025-07-06 16:48:51', 'Add Semester OCTOBER 2024 â€“ FEBRUARY 2025'),
(27, '3', '2025-07-06 16:56:41', 'Edited semester name from \"MARCH - AUGUST 2025\" to \"OCTOBER 2024 â€“ FEBRUARY 2025\"'),
(28, '3', '2025-07-06 16:56:43', 'Edited semester name from \"OCTOBER 2024 â€“ FEBRUARY 2025\" to \"MARCH - AUGUST 2025\"'),
(29, '3', '2025-07-06 16:56:43', 'Edited semester name from \"MARCH - AUGUST 2025\" to \"MARCH - AUGUST 2025\"'),
(30, '3', '2025-07-06 16:57:04', 'Edited semester name from \"OCTOBER 2024 â€“ FEBRUARY 2025\" to \"OCTOBER 2024 â€“ FEBRUARY 2045\"'),
(31, '3', '2025-07-06 16:57:04', 'Edited semester name from \"OCTOBER 2024 â€“ FEBRUARY 2045\" to \"OCTOBER 2024 â€“ FEBRUARY 2045\"'),
(32, '3', '2025-07-06 16:57:35', 'Edited semester name from \"OCTOBER 2024 â€“ FEBRUARY 2045\" to \"OCTOBER 2024 â€“ FEBRUARY 2025\"'),
(33, '3', '2025-07-06 16:57:35', 'Edited semester name from \"OCTOBER 2024 â€“ FEBRUARY 2025\" to \"OCTOBER 2024 â€“ FEBRUARY 2025\"'),
(34, '3', '2025-07-06 16:58:44', 'Edited semester name from \"MARCH - AUGUST 2025\" to \"MARCH - AUGUST\"'),
(35, '3', '2025-07-06 16:58:44', 'Edited semester name from \"MARCH - AUGUST\" to \"MARCH - AUGUST\"'),
(36, '3', '2025-07-06 16:59:04', 'Edited semester name from \"MARCH - AUGUST\" to \"MARCH - AUGUST 2025\"'),
(37, 'aini', '2025-07-06 16:59:30', 'Add Semester MARCH - AUGUST 2025'),
(38, 'aini', '2025-07-06 17:05:52', 'Add Semester OCTOBER 2024 â€“ FEBRUARY 2025'),
(39, 'aini', '2025-07-06 17:06:12', 'Add Semester MARCH - AUGUST 2025'),
(40, 'aini', '2025-07-06 17:08:00', 'Add Semester OCTOBER 2026 â€“ FEBRUARY 2027'),
(41, '3', '2025-07-06 17:08:36', 'Edited semester name from \"MARCH - AUGUST 2025\" to \"MARCH 2025 - AUGUST 2025\"'),
(42, '3', '2025-07-06 17:08:36', 'Edited semester name from \"MARCH 2025 - AUGUST 2025\" to \"MARCH 2025 - AUGUST 2025\"'),
(43, 'aini', '2025-07-06 17:20:42', 'Add Semester OCTOBER 2025 â€“ FEBRUARY 2026'),
(44, 'aini', '2025-07-06 17:21:30', 'Add Semester OCTda'),
(45, '3', '2025-07-07 01:19:05', 'Edited semester name from \"OCTOBER 2024 â€“ FEBRUARY 2025\" to \"OCTOBER 2024 â€“ FEBRUAR 2025\"'),
(46, '3', '2025-07-07 01:19:22', 'Edited semester name from \"OCTOBER 2024 â€“ FEBRUAR 2025\" to \"OCTOBER 2024 â€“ FEBRUARY 2025\"'),
(47, '3', '2025-07-07 01:19:25', 'Edited semester name from \"MARCH 2025 - AUGUST 2025\" to \"MARCH 2025 - AUGUS 2025\"'),
(48, '3', '2025-07-07 01:19:36', 'Edited semester name from \"MARCH 2025 - AUGUS 2025\" to \"MARCH 2025 - AUGUST 2025\"'),
(49, 'aini', '2025-07-07 01:19:53', 'Add Semester OKTOBER 2025 â€“ FEBRUARI 2026'),
(50, 'aini', '2025-07-17 11:07:15', 'Add Semester MARCH 2026 - AUGUST 2026');

-- --------------------------------------------------------

--
-- Table structure for table `answer`
--

CREATE TABLE `answer` (
  `answer_id` int(11) NOT NULL,
  `quiz_question_id` int(11) NOT NULL,
  `answer_text` varchar(100) NOT NULL,
  `choices` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `answer`
--

INSERT INTO `answer` (`answer_id`, `quiz_question_id`, `answer_text`, `choices`) VALUES
(113, 55, 'To increase data redundancy', 'A'),
(114, 55, 'To improve printing capabilities', 'B'),
(115, 55, 'To generate measurable change in stakeholder experience', 'C'),
(116, 55, 'To reduce employee count', 'D'),
(117, 56, 'A software application for payroll', 'A'),
(118, 56, 'A static organizational chart', 'B'),
(119, 56, 'A description of how work is performed in an organization', 'C'),
(120, 56, 'A tool for visualizing sales graphs', 'D'),
(121, 57, 'Managing hardware installations', 'A'),
(122, 57, 'Creating animations for data visualization', 'B'),
(123, 57, 'Using basic statistics and visualizing data to support conclusions', 'C'),
(124, 57, 'Designing network topologies', 'D'),
(125, 58, 'Data science only focuses on creating reports', 'A'),
(126, 58, 'Data analytics is more complex than data science', 'B'),
(127, 58, 'Data science includes broader activities like machine learning and data mining', 'C'),
(128, 58, 'Data science does not require statistics', 'D'),
(129, 59, 'It reduces internet usage', 'A'),
(130, 59, 'It slows down data collection', 'B'),
(131, 59, 'It replaces physical mediums, saving time and cost', 'C'),
(132, 59, 'It eliminates the need for customer feedback', 'D'),
(133, 60, '', 'A'),
(134, 60, '', 'B'),
(135, 60, '', 'C'),
(136, 60, '', 'D'),
(137, 61, '', 'A'),
(138, 61, '', 'B'),
(139, 61, '', 'C'),
(140, 61, '', 'D'),
(141, 62, '', 'A'),
(142, 62, '', 'B'),
(143, 62, '', 'C'),
(144, 62, '', 'D'),
(145, 63, '', 'A'),
(146, 63, '', 'B'),
(147, 63, '', 'C'),
(148, 63, '', 'D'),
(149, 65, 'Support schema-less data storage.', 'A'),
(150, 65, 'Provide out-of-the-box redundancy and high availability.', 'B'),
(151, 65, 'Are relational in nature.', 'C'),
(152, 65, 'Have fast read/write capability.', 'D'),
(153, 72, 'Support schema-less data storage.', 'A'),
(154, 72, 'Provide out-of-the-box redundancy and high availability.', 'B'),
(155, 72, 'Are relational in nature.', 'C'),
(156, 72, 'Have fast read/write capability.', 'D'),
(157, 74, '64 MB', 'A'),
(158, 74, '128 MB', 'B'),
(159, 74, '256 MB', 'C'),
(160, 74, '512 MB', 'D'),
(161, 78, 'Online processing with low-latency responses.', 'A'),
(162, 78, 'Online processing with low-latency responses.', 'B'),
(163, 78, 'Offline processing, typically involving large quantities of data with sequential read/writes.', 'C'),
(164, 78, 'Primarily used for Online Transaction Processing (OLTP) systems.', 'D'),
(165, 80, 'DataNode', 'A'),
(166, 80, 'NameNode', 'B'),
(167, 80, 'Resilient Distributed Dataset (RDD)', 'C'),
(168, 80, 'MapReduce Job', 'D'),
(169, 83, 'Key/value Stores', 'A'),
(170, 83, 'Document Stores', 'B'),
(171, 83, 'Relational Stores', 'C'),
(172, 83, 'Graph Databases', 'D'),
(173, 85, 'The database system is always available despite network failures.', 'A'),
(174, 85, 'Database nodes may be inconsistent when a read operation is performed.', 'B'),
(175, 85, 'All nodes in the database are immediately consistent after a write operation.', 'C'),
(176, 85, 'The system continues to operate despite arbitrary message delays.', 'D'),
(177, 88, 'Lucene is a complete application, while Solr is a programmatic library.', 'A'),
(178, 88, 'Solr is the engine, and Lucene is the car.', 'B'),
(179, 88, 'Solr is the car, and Lucene is its engine.', 'C'),
(180, 88, 'They are two completely independent search technologies with no relation.', 'D'),
(181, 90, 'Request Handler', 'A'),
(182, 90, 'Search Component', 'B'),
(183, 90, 'Query Parser', 'C'),
(184, 90, 'Response Writer', 'D'),
(185, 93, 'Hive and HBase', 'A'),
(186, 93, 'HDFS and MapReduce', 'B'),
(187, 93, 'Sqoop and Flume', 'C'),
(188, 93, 'YARN and Zookeeper', 'D'),
(189, 95, 'To transfer data between relational databases and Hadoop.', 'A'),
(190, 95, 'To provide a distributed, scalable NoSQL database.', 'B'),
(191, 95, 'To offer a data warehouse framework for querying and managing large datasets in HDFS using a SQL-lik', 'C'),
(192, 95, 'To collect, aggregate, and transfer streaming data flows.', 'D'),
(193, 98, 'Big Data, Data Mining, and Data Visualization', 'A'),
(194, 98, 'Big Data, Data Science, and Data Discovery', 'B'),
(195, 98, 'Data Warehousing, Data Lakes, and Data Analytics', 'C'),
(196, 98, 'Machine Learning, Deep Learning, and Artificial Intelligence', 'D'),
(197, 100, 'Analyzing text in online conversations (e.g., Facebook)', 'A'),
(198, 100, 'Traditional relational database management', 'B'),
(199, 100, 'Speech recognition on smartphones', 'C'),
(200, 100, 'Processing medical images for health diagnosis', 'D');

-- --------------------------------------------------------

--
-- Table structure for table `assignment`
--

CREATE TABLE `assignment` (
  `assignment_id` int(11) NOT NULL,
  `floc` varchar(300) NOT NULL,
  `fdatein` varchar(100) NOT NULL,
  `fdesc` varchar(100) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `fname` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `assignment`
--

INSERT INTO `assignment` (`assignment_id`, `floc`, `fdatein`, `fdesc`, `teacher_id`, `class_id`, `fname`) VALUES
(34, 'admin/uploads/3257_File_ICT602.pdf', '2025-06-19 02:41:58', 'Due tba', 9, 191, 'CASE STUDY'),
(36, 'admin/uploads/5567_File_xlsx.pdf', '2025-06-25 22:11:33', 'okay', 9, 191, 'assignment 1'),
(38, 'admin/uploads/2481_File_xlsx.pdf', '2025-06-25 22:11:52', 'again', 9, 191, 'again'),
(39, 'admin/uploads/2574_File_DSC650 Group Project.pdf', '2025-06-26 15:54:28', 'Due 11/07/2025', 9, 194, 'Group Project'),
(47, 'admin/uploads/5929_File_DSC650 Case Study.pdf', '2025-07-07 19:56:38', 'Due 11/7', 9, 202, 'Case Study'),
(48, 'admin/uploads/5929_File_DSC650 Case Study.pdf', '2025-07-07 19:56:38', 'Due 11/7', 9, 203, 'Case Study'),
(49, 'admin/uploads/3978_File_DSC650 Group Project.pdf', '2025-07-07 19:57:15', 'Due 27/9', 9, 202, 'Group Project'),
(50, 'admin/uploads/4881_File_DSC650 Group Project.pdf', '2025-07-07 19:57:48', 'Due 27/9', 9, 203, 'Group Project'),
(51, 'admin/uploads/9605_File_DSC650 Individual Assignment.pdf', '2025-07-07 20:04:42', 'Due 6/6', 9, 202, 'Individual Assignment'),
(52, 'admin/uploads/9605_File_DSC650 Individual Assignment.pdf', '2025-07-07 20:04:42', 'Due 6/6', 9, 203, 'Individual Assignment');

-- --------------------------------------------------------

--
-- Table structure for table `chat_message`
--

CREATE TABLE `chat_message` (
  `message_id` int(11) NOT NULL,
  `teacher_class_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `message_content` text NOT NULL,
  `media_type_1` varchar(50) DEFAULT NULL,
  `media_path_1` varchar(255) DEFAULT NULL,
  `media_type_2` varchar(50) DEFAULT NULL,
  `media_path_2` varchar(255) DEFAULT NULL,
  `media_type_3` varchar(50) DEFAULT NULL,
  `media_path_3` varchar(255) DEFAULT NULL,
  `message_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `teacher_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chat_message`
--

INSERT INTO `chat_message` (`message_id`, `teacher_class_id`, `student_id`, `message_content`, `media_type_1`, `media_path_1`, `media_type_2`, `media_path_2`, `media_type_3`, `media_path_3`, `message_date`, `teacher_id`) VALUES
(160, 194, NULL, 'fs', NULL, NULL, NULL, NULL, NULL, NULL, '2025-07-05 18:10:55', 9),
(161, 202, NULL, 'Hi everyone, Iâ€™ve just uploaded the Quiz 2 exercise.', NULL, NULL, NULL, NULL, NULL, NULL, '2025-07-07 14:08:52', 9),
(162, 202, 69, 'Thank you, Dr. Iskandar! Is it due this week?', NULL, NULL, NULL, NULL, NULL, NULL, '2025-07-07 14:09:09', NULL),
(163, 202, NULL, 'Yes, the deadline is Sunday, 11:59 PM. Make sure to submit before then.', NULL, NULL, NULL, NULL, NULL, NULL, '2025-07-07 14:09:32', 9),
(164, 202, 66, 'Dr., are we allowed to discuss the questions with our friends?', NULL, NULL, NULL, NULL, NULL, NULL, '2025-07-07 14:10:21', NULL),
(165, 202, NULL, 'You can discuss general concepts, but please donâ€™t share exact answers. I want to see your individual understanding.', NULL, NULL, NULL, NULL, NULL, NULL, '2025-07-07 14:10:44', 9),
(167, 202, 66, 'Got it, Dr!', NULL, NULL, NULL, NULL, NULL, NULL, '2025-07-07 14:11:38', NULL),
(169, 202, 65, 'Thank you Dr', NULL, NULL, NULL, NULL, NULL, NULL, '2025-07-09 10:46:45', NULL),
(171, 202, 65, 'Hey all, do we present tomorrow or next week?', NULL, NULL, NULL, NULL, NULL, NULL, '2025-07-16 08:57:39', NULL),
(173, 202, 3, 'hi', 'image', 'uploads/images/6878687fb771d.png', NULL, NULL, NULL, NULL, '2025-07-17 03:05:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `class_id` int(11) NOT NULL,
  `class_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`class_id`, `class_name`) VALUES
(1, ' AS2226A'),
(2, 'AS2026A'),
(3, 'AS2036A'),
(4, 'AS2436A'),
(5, 'AS2456A'),
(6, 'AS2546A'),
(7, 'BA2406A'),
(8, 'BA2426A'),
(9, 'BA2436A'),
(10, 'CDCS2406A'),
(11, 'CDCS2406B'),
(12, 'CDCS2516A'),
(13, 'CDCS2516B'),
(14, 'CDCS2556A'),
(15, 'CDCS2556B');

-- --------------------------------------------------------

--
-- Table structure for table `class_quiz`
--

CREATE TABLE `class_quiz` (
  `class_quiz_id` int(11) NOT NULL,
  `teacher_class_id` int(11) NOT NULL,
  `quiz_time` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `class_quiz`
--

INSERT INTO `class_quiz` (`class_quiz_id`, `teacher_class_id`, `quiz_time`, `quiz_id`) VALUES
(34, 191, 3600, 11),
(35, 194, 1800, 12),
(36, 194, 1800, 13),
(49, 202, 1800, 12),
(50, 203, 1800, 12),
(51, 202, 1800, 13),
(52, 203, 1800, 13),
(53, 202, 1800, 25),
(54, 203, 1800, 25),
(55, 202, 1800, 26),
(56, 203, 1800, 26),
(57, 202, 1800, 27),
(58, 203, 1800, 27),
(59, 202, 1800, 28),
(60, 203, 1800, 28),
(61, 202, 1800, 29),
(62, 203, 1800, 29),
(63, 202, 1800, 30),
(64, 203, 1800, 30);

-- --------------------------------------------------------

--
-- Table structure for table `class_subject_overview`
--

CREATE TABLE `class_subject_overview` (
  `class_subject_overview_id` int(11) NOT NULL,
  `teacher_class_id` int(11) NOT NULL,
  `content` varchar(10000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `class_subject_overview`
--

INSERT INTO `class_subject_overview` (`class_subject_overview_id`, `teacher_class_id`, `content`) VALUES
(2, 194, '<p>The course will give the students to explore key data analysis and management techniques, which applied to massive data sets are the cornerstone that enables real-time decision making in distributed environments, business intelligence in the Web, and scientific discovery at large scale. In particular, the students will examine the map-reduce parallel computing paradigm and associated technologies such as Hadoop distributed file systems, and no sql databases.</p>\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE `content` (
  `content_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`content_id`, `title`, `content`) VALUES
(1, 'Mission', '<pre>\r\n<span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\"><strong><span style=\"font-size:22px\">OUR MISSION</span></strong>\r\n\r\nTo lead the development of agile, professional bumiputeras through state-of-the-art curricula and impactful research</span></span></pre>\r\n\r\n<p>&nbsp;</p>\r\n'),
(2, 'Vision', '<pre>\r\n<span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\"><strong><span style=\"font-size:22px\">OUR VISION</span></strong>\r\n\r\nTo establish UiTM as a Globally Renowned University of Science, Technology, Humanities and Entrepreneurship.</span></span></pre>\r\n\r\n<p>&nbsp;</p>\r\n'),
(3, 'History', '<p><span style=\"font-family:times new roman,times,serif\"><span style=\"font-size:22px\"><strong>Our campuses are living laboratories for sustainability.</strong></span></span></p>\r\n\r\n<p style=\"text-align: justify;\"><br />\r\n<span style=\"font-family:times new roman,times,serif\">UiTM Perlis Branch is a prominent public higher education institution in Perlis. It was officially established on 5 July 1974, with the enrolment of 258 pioneer students, undergoing 1 preparatory course and 5 diploma programmes. It began operations at a temporary site of the Scout House at Jalan Padang Katong, Kangar, with 15 academic staff and 31 administrative and support staff. In 1980, the campus moved to its permanent site on a of 335-acre plot in Arau.</span></p>\r\n\r\n<p style=\"text-align: justify;\"><span style=\"font-family:times new roman,times,serif\">UiTM Perlis Branch has grown into a premier public higher education institution by physical infrastructure, staff organisation and student enrolment. The university is made up of 7 faculties, with a total of 34 programmes offered which include 17 degree programmes and 16 diploma programmes. In addition, various infrastructure and facilities are also provided. There are 15 residential colleges which are segregated by gender, 67 science laboratories, 22 computer laboratories, 3 language laboratories, a large hall, a mosque, a mini stadium and a gymnasium. Some facilities such as hostels, halls and gyms offered to public for rental.</span></p>\r\n'),
(4, 'Footer', '<p style=\"text-align:center\">Study Spark</p>\r\n'),
(6, 'Title', '<p><span style=\"font-family:trebuchet ms,geneva\">Study Spark</span></p>\r\n');
INSERT INTO `content` (`content_id`, `title`, `content`) VALUES
(10, 'Academic Calendar', '<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n	<tbody>\r\n		<tr>\r\n			<td style=\"height:84px; width:547px\">\r\n			<p dir=\"rtl\" style=\"margin-right:41.15pt; text-align:left\"><strong><span style=\"font-size:22px\"><span style=\"font-family:times new roman,times,serif\">ACADEMIC CALENDAR&nbsp;SESSION&nbsp;I&nbsp;I 2024&nbsp;/ 2025</span></span></strong></p>\r\n\r\n			<p dir=\"rtl\" style=\"margin-right:41.15pt; text-align:left\"><span style=\"font-size:22px\"><span style=\"font-family:times new roman,times,serif\">PROGRAM FOR DIPLOMA, DIPLOMA</span></span></p>\r\n\r\n			<p dir=\"rtl\" style=\"margin-right:41.15pt; text-align:left\"><span style=\"font-size:22px\"><span style=\"font-family:times new roman,times,serif\">BACHELOR&#39;S, MASTER&#39;S AND DOCTORAL DEGREES</span></span></p>\r\n			</td>\r\n			<td style=\"height:84px; width:269px\">\r\n			<p>&nbsp;</p>\r\n\r\n			<p style=\"margin-left:10.6pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\"><img alt=\"\" src=\"https://hea.uitm.edu.my/v4/images/logo/logo-hea-TNC.jpg\" style=\"border:0px; height:auto; vertical-align:middle; width:420px\" /></span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td colspan=\"2\" style=\"height:23px; width:815px\">\r\n			<p dir=\"rtl\" style=\"margin-right:11.95pt; text-align:left\"><strong><span style=\"font-size:22px\"><span style=\"font-family:times new roman,times,serif\">SEMESTER&nbsp;MARCH&nbsp;-&nbsp;AUGUST&nbsp;2025 [20252]</span></span></strong></p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\">\r\n	<thead>\r\n		<tr>\r\n			<th colspan=\"3\" style=\"height:16px; width:728px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">NEW STUDENT REGISTRATION ACTIVITIES</span></span></p>\r\n			</th>\r\n		</tr>\r\n		<tr>\r\n			<th style=\"height:14px; width:151px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">PROGRAM&nbsp;LEVEL</span></span></p>\r\n			</th>\r\n			<th style=\"height:14px; width:397px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">ACTIVITIES</span></span></p>\r\n			</th>\r\n			<th style=\"height:14px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">DATE</span></span></p>\r\n			</th>\r\n		</tr>\r\n	</thead>\r\n	<tbody>\r\n		<tr>\r\n			<td rowspan=\"20\" style=\"height:16px; width:151px\">\r\n			<p style=\"margin-left:23.5pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pre-Diploma / Diploma (Full-Time only)</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">[1]&nbsp;&nbsp;&nbsp;&nbsp;Consent to Accept UiTM Offer</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\">&nbsp;</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pra-Diploma</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">Will be informed</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Diploma</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">10 Jan &ndash; 16 Mar 2025</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Diploma (&nbsp;Application&nbsp;)</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">Will be informed</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">[2]&nbsp;&nbsp;&nbsp;&nbsp;Online Registration as a Full-Time Student</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\">&nbsp;</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pra-Diploma</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">Will be informed</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Diploma</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">10 Jan &ndash; 16 Mar 2025</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;UiTM Diploma (&nbsp;Application&nbsp;)</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">Will be informed</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Second Offer</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\">&nbsp;</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">[3]&nbsp;&nbsp;&nbsp;&nbsp;Physical Registration &amp; Submission of New Student Documents</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\">&nbsp;</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Diploma</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">5 &ndash; 6 April 2025</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pra-Diploma</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">5 &ndash; 6 April 2025</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Second Offer</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\">&nbsp;</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">[4]&nbsp;&nbsp;&nbsp;Deadline for Generation of Virtual Student Cards on&nbsp;iStudent Apps</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">16 Mac 2025</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">[5]&nbsp;&nbsp;&nbsp;Deadline for Updating Student Records on&nbsp;iStudent Portal</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">16 Mac 2025</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">[6]&nbsp;&nbsp;&nbsp;Student Destination Week Program&nbsp;(MDS)</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">17 &ndash; 21 Mac&nbsp;2025 (Online)</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">[7]&nbsp;&nbsp;&nbsp;Edu â€‹â€‹Sunday Program&nbsp;5.0@UiTM</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">22 &ndash; 23 Mac&nbsp;2025 (Online)</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">[8]&nbsp;&nbsp;&nbsp;&nbsp;Boarding College Registration</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\">&nbsp;</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;New Students</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">5 &ndash; 6 April 2025</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Old Students (For Those Who Receive Approval)</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">5 &ndash; 6 April 2025</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td rowspan=\"2\" style=\"height:12px; width:151px\">\r\n			<p style=\"margin-left:19pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Diploma and Bachelor&#39;s Degree (Part-Time Only)</span></span></p>\r\n			</td>\r\n			<td style=\"height:12px; width:397px\">\r\n			<p style=\"margin-left:21.1pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">[1]&nbsp;&nbsp;&nbsp;&nbsp;New Student Document Submission Process</span></span></p>\r\n			</td>\r\n			<td style=\"height:12px; width:180px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">Will be informed</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:12px; width:397px\">\r\n			<p style=\"margin-left:21.1pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">[2]&nbsp;&nbsp;&nbsp;&nbsp;Registration of New Students e-PJJ and PLK and Briefing on New Students e-PJJ and PLK Programs</span></span></p>\r\n			</td>\r\n			<td style=\"height:12px; width:180px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">Will be informed</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td rowspan=\"2\" style=\"height:12px; width:151px\">\r\n			<p style=\"margin-left:19pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Masters and Doctorates</span></span></p>\r\n			</td>\r\n			<td style=\"height:12px; width:397px\">\r\n			<p style=\"margin-left:21.1pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">[1]&nbsp;&nbsp;&nbsp;&nbsp;New Student Registration (Masters, Postgraduate and Doctoral)</span></span></p>\r\n			</td>\r\n			<td rowspan=\"2\" style=\"height:12px; width:180px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">3 - 21 Mac 2025</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:12px; width:397px\">\r\n			<p style=\"margin-left:21.1pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">[2]&nbsp;&nbsp;&nbsp;&nbsp;Registration for New Students Second Offer (UiTM Shah Alam and UiTM Branches)</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td rowspan=\"22\" style=\"height:12px; width:151px\">\r\n			<p style=\"margin-left:19pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bachelor (Full-Time)</span></span></p>\r\n			</td>\r\n			<td style=\"height:12px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">[1]&nbsp;&nbsp;&nbsp;&nbsp;Consent to Accept UiTM Offer</span></span></p>\r\n			</td>\r\n			<td style=\"height:12px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\">&nbsp;</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:32px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;STPM / STAM / Matriculation / Foundation / Other IPT Diploma Graduates</span></span></p>\r\n			</td>\r\n			<td style=\"height:32px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">February 21 &ndash; March 9, 2025</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:11px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Graduates of UiTM Final Year Diploma Application / UiTM Diploma</span></span></p>\r\n			</td>\r\n			<td style=\"height:11px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">17&nbsp;&ndash; 23 Mac 2025</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:18px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">[2]&nbsp;&nbsp;&nbsp;&nbsp;Online Registration as a New Full-Time Student</span></span></p>\r\n			</td>\r\n			<td style=\"height:18px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\">&nbsp;</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:20px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;STPM / STAM / Matriculation / Foundation / Other IPT Diploma Graduates</span></span></p>\r\n			</td>\r\n			<td style=\"height:20px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">February 21 &ndash; March 9, 2025</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:14px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Graduates of UiTM Final Year Diploma Application</span></span></p>\r\n			</td>\r\n			<td style=\"height:14px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">17 &ndash; 23 Mac 2025&nbsp;&nbsp;</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Second Offer&nbsp;(UiTM Shah Alam and UiTM Branches)</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">8&nbsp;&ndash; 11 April 2025</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">[3]&nbsp;&nbsp;&nbsp;&nbsp;Physical Registration &amp; Submission of New Student Documents</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\">&nbsp;</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;STPM / STAM / Matriculation / Foundation / Other IPT Diploma / UiTM Diploma)</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">5 &ndash; 6 April 2025</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Second Offer&nbsp;(UiTM Shah Alam and UiTM Branches)</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">10 &ndash; 11 April 2025</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">[4]&nbsp;&nbsp;&nbsp;&nbsp;Deadline for Generation of Virtual Student Cards on iStudent Apps</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\">&nbsp;</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;STPM / STAM / Matriculation / Foundation / Other IPT Diploma / UiTM Diploma)</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">16 Mac 2025</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Graduates of UiTM Final Year Diploma Application</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">Will be informed</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">[5]&nbsp;&nbsp;&nbsp;&nbsp;Deadline for Updating Student Records on iStudent Portal</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\">&nbsp;</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;STPM / STAM / Matriculation / Foundation / Other IPT Diploma / UiTM Diploma)</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">8 &ndash; 9 Mac 2025</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Graduates of UiTM Final Year Diploma Application</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">Will be informed</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">[6]&nbsp;&nbsp;&nbsp;Student Destination Week Program&nbsp;(MDS)</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">17 &ndash; 21 Mac 2025 (Online)</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">[7]&nbsp;&nbsp;&nbsp;Edu â€‹â€‹Sunday Program&nbsp;5.0@UiTM</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">22 &ndash; 23 Mac 2025 (Online)</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">[8]&nbsp;&nbsp;&nbsp;Student Destination Strengthening Program&nbsp;(PDS)</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">12 April 2025</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:17px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">[9]&nbsp;&nbsp;&nbsp;&nbsp;College Registration (Those Who Received Placement Approval)</span></span></p>\r\n			</td>\r\n			<td style=\"height:17px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\">&nbsp;</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:5px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;New Students&nbsp;</span></span></p>\r\n			</td>\r\n			<td style=\"height:5px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">5 &ndash; 6 April 2025</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:19px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Old and New Students (Application/Appeal)</span></span></p>\r\n			</td>\r\n			<td style=\"height:19px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">5 &ndash; 6 April 2025</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td colspan=\"3\" style=\"height:16px; width:728px\">\r\n			<p style=\"margin-left:5.5pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">COURSE REGISTRATION ACTIVITIES</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:151px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">PROGRAM LEVEL</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:397px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">ACTIVITIES</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">DATE</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td rowspan=\"2\" style=\"height:8px; width:151px\">\r\n			<p style=\"margin-left:5.65pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">Pre-Diploma&nbsp;/ Diploma (&nbsp;Part 1 Students Only)</span></span></p>\r\n			</td>\r\n			<td style=\"height:8px; width:397px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">Add and Drop New Student Course Registration (Interim)</span></span></p>\r\n			</td>\r\n			<td style=\"height:8px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\">&nbsp;</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:18px; width:397px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">Interim Week Lectures Begin</span></span></p>\r\n			</td>\r\n			<td style=\"height:18px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\">&nbsp;</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td rowspan=\"3\" style=\"height:16px; width:151px\">\r\n			<p style=\"margin-left:5.65pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">All Students</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:397px\">\r\n			<p style=\"margin-left:20.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">[1]&nbsp;&nbsp;&nbsp;New Student Course Registration ePJJ / PLK mode</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">March 17 &ndash; April 11, 2025</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:397px\">\r\n			<p style=\"margin-left:20.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">[2]&nbsp;&nbsp;&nbsp;Adding and Dropping Undergraduate Student Course Registration</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">March 19 &ndash; April 11, 2025</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:397px\">\r\n			<p style=\"margin-left:20.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">[3]&nbsp;&nbsp;&nbsp;Add and Drop Pre-Diploma / Diploma / Master&#39;s Student Course Registration</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">March 21 &ndash; April 11, 2025</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:32px; width:151px\">\r\n			<p style=\"margin-left:5.65pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">Bachelor (Full-Time)</span></span></p>\r\n			</td>\r\n			<td style=\"height:32px; width:397px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">Online Registration for the English Exit Test Course (&nbsp;EET699&nbsp;) for Eligible Candidates Only</span></span></p>\r\n			</td>\r\n			<td style=\"height:32px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">March 19 &ndash; April 11, 2025</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td rowspan=\"15\" style=\"height:16px; width:151px\">\r\n			<p style=\"margin-left:5.65pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">All Students</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">[1]&nbsp;&nbsp;&nbsp;&nbsp;LECTURE STARTS</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">24 Mac 2025</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:32px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">[2]&nbsp;&nbsp;&nbsp;Deadline for Students to Apply for Fee Payment Deferral</span></span></p>\r\n			</td>\r\n			<td style=\"height:32px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">30 April 2025</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">[3]&nbsp;&nbsp;&nbsp;Deadline for Decision on Application for Deferral of Fee Payment</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">30 April 2025</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">[4]&nbsp;&nbsp;&nbsp;&nbsp;FEE PAYMENT DEADLINE</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">30 April 2025</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">[5]&nbsp;&nbsp;&nbsp;Validation Period for Registered Courses for the Current Semester</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">12 &ndash; 18 April 2025</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">[6]&nbsp;&nbsp;&nbsp;Late/Out of Time Course Registration/Drop Application</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">19 &ndash; 23 April 2025</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">[7]&nbsp;&nbsp;&nbsp;&nbsp;FALLING DOWN</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">May 7, 2025</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">[8]&nbsp;&nbsp;&nbsp;Students Start Printing Exam Sitting Slips</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">May 23, 2025</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">[9]&nbsp;&nbsp;&nbsp;Application for Appeal for Cancellation of Loss of Status (RPGT)</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">7&nbsp;&nbsp;&ndash; 13 May 2025</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">[10]&nbsp;Decision on Appeal for Cancellation of Disqualification (RPGT)</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">8 - 14 May 2025</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:32px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">[11]&nbsp;Fee Payment Deadline for Students Who Are Approved by RPGT and Those Who Are Allowed to Pay Late Fees</span></span></p>\r\n			</td>\r\n			<td style=\"height:32px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">May 21, 2025</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">[12]&nbsp;Loss of Status for Students Who Still Do Not Pay Overdue / Deferred Fees (GT2)</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">May 26, 2025</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:32px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">[13]&nbsp;Fee Payment Deadline for Students Approved for Fee Payment Deferral</span></span></p>\r\n			</td>\r\n			<td style=\"height:32px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">23 Jun 2025</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">[14]&nbsp;FINAL FALL</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">30 Jun 2025</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:397px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">[15]&nbsp;Deadline for Payment of Fees Other than Tuition Fees (One week before examination results)</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:180px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">August 27, 2025</span></span></p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"width:728px\">\r\n	<thead>\r\n		<tr>\r\n			<th colspan=\"4\" style=\"height:16px; width:728px\">\r\n			<p style=\"margin-left:-0.95pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">LECTURE ACTIVITIES</span></span></p>\r\n			</th>\r\n		</tr>\r\n		<tr>\r\n			<th style=\"height:16px; width:151px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">PROGRAM LEVEL</span></span></p>\r\n			</th>\r\n			<th style=\"height:16px; width:284px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">ACTIVITIES</span></span></p>\r\n			</th>\r\n			<th style=\"height:16px; width:208px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">DATE</span></span></p>\r\n			</th>\r\n			<th style=\"height:16px; width:85px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">PERIOD</span></span></p>\r\n			</th>\r\n		</tr>\r\n	</thead>\r\n	<tbody>\r\n		<tr>\r\n			<td rowspan=\"2\" style=\"height:18px; width:151px\">\r\n			<p style=\"margin-left:5.65pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">Pre-Diploma / Diploma (Part 1 Students Only)</span></span></p>\r\n			</td>\r\n			<td style=\"height:18px; width:284px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">Interim Week</span></span></p>\r\n			</td>\r\n			<td style=\"height:18px; width:208px\">\r\n			<p style=\"margin-left:2.85pt\">&nbsp;</p>\r\n			</td>\r\n			<td style=\"height:18px; width:85px\">\r\n			<p style=\"margin-left:2.85pt\">&nbsp;</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:284px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">Interim Sunday Leave</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:208px\">\r\n			<p style=\"margin-left:2.85pt\">&nbsp;</p>\r\n			</td>\r\n			<td style=\"height:16px; width:85px\">\r\n			<p style=\"margin-left:2.85pt\">&nbsp;</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td rowspan=\"15\" style=\"height:16px; width:151px\">\r\n			<p style=\"margin-left:5.65pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">All Students</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:284px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">Lecture 1</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:208px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">24 &ndash; 30 Mac 2025</span></span></p>\r\n\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">*24 &ndash; 29 Mac 2025</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:85px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">1 Week&nbsp;(Online)</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:284px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">Proses Entrance Survey</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:208px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">March 24 &ndash; April 27, 2025</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:85px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">4 Weeks</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:284px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">Special Holiday Celebrations</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:208px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">March 31 - April 5, 2025</span></span></p>\r\n\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">[Aidil-Fitri: 31 March &ndash; 1 April]</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:85px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">1 week</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:284px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">Lecture 2</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:208px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">April 7 &ndash; May 29, 2025</span></span></p>\r\n\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">*April 6 &ndash; May 29, 2025</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:85px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">8 Weeks</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:284px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">Mid Semester Leave/</span></span></p>\r\n\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">Special Holiday Celebrations</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:208px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">30 May &ndash; 8 Jun 2025</span></span></p>\r\n\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">*30 May &ndash; 7 Jun 2025</span></span></p>\r\n\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">[Harvest Feast: May 30 &ndash; 31]</span></span></p>\r\n\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">[Gawai: 1 &ndash; 2 June]<br />\r\n			&nbsp;[Eid al-Adha: 7 June]&nbsp;&nbsp;</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:85px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">1 week</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:284px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">Lecture 3</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:208px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">June 9 &ndash; July 13, 2025</span></span></p>\r\n\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">*8 June &ndash; 12 July 2025</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:85px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">5 Weeks</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:284px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">Student Feedback Online (SuFO)</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:208px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">June 23 &ndash; July 27, 2025</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:85px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">5 Weeks</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:284px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">Proses Exit Survey</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:208px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">June 23 &ndash; July 27, 2025</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:85px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">5 Weeks</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:284px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">English Exit Test (Speaking)</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:208px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">14 &ndash; 20&nbsp;July&nbsp;2025</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:85px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">1 week</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:284px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">Review Break</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:208px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">14 &ndash; 20&nbsp;July&nbsp;2025</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:85px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">1 week</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:284px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">Assessment / Final Examination/EET (Writing)</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:208px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">July 21 &ndash; August 10, 2025</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:85px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">3&nbsp;Weeks</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:284px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">Intersession Lectures&nbsp;/ Short Semester</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:208px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">August 4 &ndash; September 21, 2025</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:85px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">7 Weeks</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:284px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">Announcement of Final Assessment / Examination Results</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:208px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">4 September 2025</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:85px\">\r\n			<p style=\"margin-left:2.85pt\">&nbsp;</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:284px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">Examination / Special Assessment /</span></span></p>\r\n\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">Intersession / Semester III</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:208px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">22 - 28 September 2025</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:85px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">1 week</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:16px; width:284px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">Semester Leave</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:208px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">11 August &ndash; 5 October 2025</span></span></p>\r\n			</td>\r\n			<td style=\"height:16px; width:85px\">\r\n			<p style=\"margin-left:2.85pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">8 Weeks</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td colspan=\"4\" style=\"height:16px; width:728px\">\r\n			<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\"><em>Note:</em><em>&nbsp;[*] For the States of Kedah / Kelantan / Terengganu Only.</em></span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td colspan=\"4\" style=\"height:16px; width:728px\">\r\n			<p>&nbsp;</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"width:832px\">\r\n	<tbody>\r\n		<tr>\r\n			<td style=\"height:16px; width:832px\">\r\n			<p style=\"margin-left:6.45pt\"><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">UPDATED 2 JULY&nbsp;&nbsp;2025 (BASED ON THE APPROVAL OF THE 303rd UiTM SENATE)</span></span></p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>\r\n');
INSERT INTO `content` (`content_id`, `title`, `content`) VALUES
(11, 'Directories', '<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\"><span style=\"font-size:22px\"><strong>Contact Us</strong></span></span></span></p>\r\n\r\n<p><br />\r\n<span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">Universiti Teknologi MARA<br />\r\nCawangan Perlis, Kampus Arau,<br />\r\n02600 Arau, Perlis, Malaysia</span></span></p>\r\n\r\n<p><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">ðŸ“ž <strong>Phone</strong>: +604-9882000<br />\r\nðŸ“  <strong>Fax</strong>: +604-9882019<br />\r\nðŸ“§ <strong>Email</strong>: korporatperlis@uitm.edu.my</span></span></p>\r\n'),
(14, 'Campus', '<h3><span style=\"font-size:20px\"><span style=\"font-family:times new roman,times,serif\">UiTM Perlis Branch</span></span></h3>\r\n\r\n<div>&nbsp;</div>\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `department_id` int(11) NOT NULL,
  `department_name` varchar(100) NOT NULL,
  `dean` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`department_id`, `department_name`, `dean`) VALUES
(1, 'Faculty Of Computer & Mathematical Sciences', 'Dr. Nur Fatihah binti Fauzi'),
(2, 'Faculty Of Applied Sciences', 'Dr. Nur Nasulhah Kasim'),
(3, 'Faculty Of Accountancy', 'Prof. Madya Dr. Azrul Abdullah'),
(4, 'Faculty Of Business And Management', 'Dr Ismalaili Ismail');

-- --------------------------------------------------------

--
-- Table structure for table `discussion_post`
--

CREATE TABLE `discussion_post` (
  `discussion_post_id` int(11) NOT NULL,
  `teacher_class_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `post_content` text NOT NULL,
  `post_date` datetime DEFAULT current_timestamp(),
  `media_type` varchar(20) DEFAULT NULL,
  `media_path` varchar(255) DEFAULT NULL,
  `media_type_1` varchar(20) DEFAULT NULL,
  `media_path_1` varchar(255) DEFAULT NULL,
  `media_type_2` varchar(20) DEFAULT NULL,
  `media_path_2` varchar(255) DEFAULT NULL,
  `media_type_3` varchar(20) DEFAULT NULL,
  `media_path_3` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `discussion_post`
--

INSERT INTO `discussion_post` (`discussion_post_id`, `teacher_class_id`, `student_id`, `teacher_id`, `post_content`, `post_date`, `media_type`, `media_path`, `media_type_1`, `media_path_1`, `media_type_2`, `media_path_2`, `media_type_3`, `media_path_3`) VALUES
(19, 194, NULL, 9, 'Hi everyone,\r\n\r\nAfter going through Lecture 1: Overview of Data Technology, itâ€™s clear how critical data has become in shaping decisions and innovations in todayâ€™s digital landscape. One of the most striking points for me was how data technology has evolved to not only manage massive datasets but also integrate information from various sources to uncover business insights.\r\n\r\nThe introduction to Big Data and the 5 Vâ€™sâ€”Volume, Velocity, Variety, Veracity, and Valueâ€”provides a useful framework to understand the scope and complexity of todayâ€™s data challenges. Each â€œVâ€ reveals a different dimension of Big Data, highlighting why traditional data processing methods are no longer sufficient.\r\n\r\nAnother interesting takeaway is the distinction between data analysis and data analytics. While data analysis focuses on identifying patterns and relationships within datasets, data analytics encompasses the entire data lifecycleâ€”including collection, cleaning, storage, analysis, and governance. The categorization into descriptive, diagnostic, predictive, and prescriptive analytics shows how analytics is progressing from simply describing past events to actually recommending actions.\r\n\r\nLastly, the classification of data typesâ€”structured, semi-structured, and unstructuredâ€”reminds us of the diversity in modern data formats. It\'s fascinating that unstructured data makes up about 80% of enterprise data, including things like images, videos, and social media posts.\r\n\r\nðŸ’¬ Letâ€™s Discuss:\r\nWhich of the 5 Vâ€™s of Big Data do you think presents the greatest challenge to organizations today, and why?\r\n\r\nHow do you see prescriptive analytics influencing decision-making in industries like healthcare or finance?\r\n\r\nCan you think of a real-world example where unstructured data provided critical business insight?\r\n\r\nLooking forward to your thoughts and examples!', '2025-06-26 16:05:24', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(72, 202, NULL, 9, 'These two images provide a quick and valuable visual reference for selecting the appropriate database type for your project and enhancing your understanding of SQL queries and commands.', '2025-07-07 22:21:06', NULL, NULL, 'image', 'uploads/images/686bd7d240528.jpg', 'image', 'uploads/images/686bd7d240f50.jpg', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `discussion_reply`
--

CREATE TABLE `discussion_reply` (
  `discussion_reply_id` int(11) NOT NULL,
  `discussion_post_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `reply_content` text NOT NULL,
  `reply_date` datetime DEFAULT current_timestamp(),
  `media_type` varchar(20) DEFAULT NULL,
  `media_path` varchar(255) DEFAULT NULL,
  `media_type_1` varchar(20) DEFAULT NULL,
  `media_path_1` varchar(255) DEFAULT NULL,
  `media_type_2` varchar(20) DEFAULT NULL,
  `media_path_2` varchar(255) DEFAULT NULL,
  `media_type_3` varchar(20) DEFAULT NULL,
  `media_path_3` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `discussion_reply`
--

INSERT INTO `discussion_reply` (`discussion_reply_id`, `discussion_post_id`, `student_id`, `teacher_id`, `reply_content`, `reply_date`, `media_type`, `media_path`, `media_type_1`, `media_path_1`, `media_type_2`, `media_path_2`, `media_type_3`, `media_path_3`) VALUES
(6, 7, NULL, 9, 'tq', '2025-06-19 03:05:07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 18, 65, NULL, 'okay', '2025-06-25 11:16:26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 18, 65, NULL, 'okay', '2025-06-25 11:16:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(40, 19, 65, NULL, '1. Which of the 5 Vâ€™s of Big Data do you think presents the greatest challenge to organizations today, and why?\r\nðŸ”¹ Veracity â€” because ensuring the accuracy and trustworthiness of data is difficult, especially when dealing with large, diverse, and unstructured sources.\r\n\r\n2. How do you see prescriptive analytics influencing decision-making in industries like healthcare or finance?\r\nðŸ”¹ In healthcare, it can suggest the best treatment plans based on patient history and current data. In finance, it can recommend investment strategies or fraud prevention actions.\r\n\r\n3. Can you think of a real-world example where unstructured data provided critical business insight?\r\nðŸ”¹ Social media sentiment analysis during a product launch helped a company quickly respond to customer feedback and adjust their marketing strategy.', '2025-06-27 15:25:01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(110, 72, 66, NULL, 'Thank you sir', '2025-07-07 22:21:33', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(111, 72, 3, NULL, 'Thank you sir', '2025-07-16 16:40:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `event_id` int(11) NOT NULL,
  `event_title` varchar(100) NOT NULL,
  `teacher_class_id` int(11) NOT NULL,
  `date_start` varchar(100) NOT NULL,
  `date_end` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`event_id`, `event_title`, `teacher_class_id`, `date_start`, `date_end`) VALUES
(12, 'Kuliah 1 (Online)', 0, '03/24/2025', '03/30/2025'),
(13, 'Proses Entrance Survey', 0, '03/24/2025', '04/27/2025'),
(14, 'Cuti Khas Perayaan', 0, '03/31/2025', '04/05/2013'),
(15, 'Kuliah 2', 0, '04/07/2025', '05/29/2025'),
(16, 'Cuti Pertengahan Semester / Cuti Khas Perayaan', 0, '05/30/2025', '06/08/2025'),
(17, 'Kuliah 3', 0, '06/09/2025', '07/13/2025'),
(18, 'Student Feedback Online (SuFO)', 0, '06/23/2025', '07/27/2025'),
(19, 'Proses Exit Survey', 0, '06/23/2025', '07/27/2025'),
(20, 'Cuti Ulangkaji', 0, '07/14/2025', '07/20/2025'),
(21, 'Penilaian / Peperiksaan Akhir / EET (Writing)', 0, '07/21/2025', '08/10/2025'),
(23, 'Cuti Semester', 0, '08/11/2025', '10/05/2025'),
(26, 'DSC650 GROUP PROJECT', 194, '06/11/2025', '07/11/2025'),
(37, 'CASE STUDY', 202, '06/23/2025', '07/11/2025'),
(38, 'GROUP PROJECT', 202, '07/27/2025', '09/27/2025'),
(39, 'INDIVIDUAL ASSIGNMENT', 202, '05/19/2025', '06/06/2025');

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `file_id` int(11) NOT NULL,
  `floc` varchar(500) NOT NULL,
  `fdatein` varchar(200) NOT NULL,
  `fdesc` varchar(100) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `uploaded_by` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`file_id`, `floc`, `fdatein`, `fdesc`, `teacher_id`, `class_id`, `fname`, `uploaded_by`) VALUES
(146, 'admin/uploads/5667_File_Lecture 1 - Overview of Data Technology.pdf', '2025-06-26 15:33:53', 'Overview of Data Technology', 9, 194, 'Lecture 1', 'Iskandar RahmanAli'),
(147, 'admin/uploads/8971_File_Lecture 2 - Business Motivations and Drivers for Big Data Adoption.pdf', '2025-06-26 15:48:46', 'Business Motivations and Drivers for Big Data Adoption', 9, 194, 'Lecture 2', 'Iskandar RahmanAli'),
(148, 'admin/uploads/9864_File_Lecture 3 - Data Storage Technology - 5.pdf', '2025-06-26 15:49:08', 'Data Storage Technology', 9, 194, 'Lecture 3', 'Iskandar RahmanAli'),
(149, 'admin/uploads/4931_File_Lecture 4 - Data Processing.pdf', '2025-06-26 15:49:22', 'Data Processing', 9, 194, 'Lecture 4', 'Iskandar RahmanAli'),
(150, 'admin/uploads/1426_File_Lecture 5 - NoSQL.pdf', '2025-06-26 15:49:35', 'NoSQL', 9, 194, 'Lecture 5', 'Iskandar RahmanAli'),
(151, 'admin/uploads/2686_File_Lecture 6 - Searching and Indexing Big Data.pdf', '2025-06-26 15:49:48', 'Searching and Indexing Big Data', 9, 194, 'Lecture 6', 'Iskandar RahmanAli'),
(152, 'admin/uploads/3751_File_Lecture 7 - Big Data Technologies ODL.pdf', '2025-06-26 15:50:01', 'Big Data Technologies ODL', 9, 194, 'Lecture 7', 'Iskandar RahmanAli'),
(153, 'admin/uploads/1451_File_Lecture 8 - Trend in Data Technology - ODL.pdf', '2025-06-26 15:50:21', 'Trend in Data Technology', 9, 194, 'Lecture 8', 'Iskandar RahmanAli'),
(154, 'admin/uploads/5781_File_SOW DSC650.pdf', '2025-06-26 15:50:37', 'DSC650', 9, 194, 'SOW', 'Iskandar RahmanAli'),
(157, 'admin/uploads/7235_File_GROUP 1 DCS650 GROUP PROJECT.pdf', '2025-07-05 16:08:00', 'rdsdsf', 9, 194, 'resr', 'Ts. Dr. Iskandar Bin RahmanAli'),
(158, 'admin/uploads/8438_File_GROUP 1 DCS650 GROUP PROJECT.pdf', '2025-07-06 04:16:18', 'dad', 9, 194, 'da', 'Ts. Dr. Iskandar Bin RahmanAli'),
(159, 'admin/uploads/5667_File_Lecture 1 - Overview of Data Technology.pdf', '2025-07-06 05:00:14', 'Overview of Data Technology', 22, 196, 'Lecture 1', ''),
(160, 'admin/uploads/7235_File_GROUP 1 DCS650 GROUP PROJECT.pdf', '2025-07-06 05:00:14', 'rdsdsf', 22, 196, 'resr', ''),
(161, 'admin/uploads/5781_File_SOW DSC650.pdf', '2025-07-06 05:00:14', 'DSC650', 22, 196, 'SOW', ''),
(162, 'admin/uploads/1451_File_Lecture 8 - Trend in Data Technology - ODL.pdf', '2025-07-06 05:00:14', 'Trend in Data Technology', 22, 196, 'Lecture 8', ''),
(163, 'admin/uploads/3751_File_Lecture 7 - Big Data Technologies ODL.pdf', '2025-07-06 05:00:14', 'Big Data Technologies ODL', 22, 196, 'Lecture 7', ''),
(164, 'admin/uploads/2686_File_Lecture 6 - Searching and Indexing Big Data.pdf', '2025-07-06 05:00:14', 'Searching and Indexing Big Data', 22, 196, 'Lecture 6', ''),
(165, 'admin/uploads/1426_File_Lecture 5 - NoSQL.pdf', '2025-07-06 05:00:14', 'NoSQL', 22, 196, 'Lecture 5', ''),
(166, 'admin/uploads/4931_File_Lecture 4 - Data Processing.pdf', '2025-07-06 05:00:14', 'Data Processing', 22, 196, 'Lecture 4', ''),
(167, 'admin/uploads/9864_File_Lecture 3 - Data Storage Technology - 5.pdf', '2025-07-06 05:00:14', 'Data Storage Technology', 22, 196, 'Lecture 3', ''),
(168, 'admin/uploads/8971_File_Lecture 2 - Business Motivations and Drivers for Big Data Adoption.pdf', '2025-07-06 05:00:14', 'Business Motivations and Drivers for Big Data Adoption', 22, 196, 'Lecture 2', ''),
(169, 'admin/uploads/8438_File_GROUP 1 DCS650 GROUP PROJECT.pdf', '2025-07-06 05:00:14', 'dad', 22, 196, 'da', ''),
(170, 'admin/uploads/5667_File_Lecture 1 - Overview of Data Technology.pdf', '2025-07-06 05:00:14', 'Overview of Data Technology', 22, 196, 'Lecture 1', ''),
(171, 'admin/uploads/7235_File_GROUP 1 DCS650 GROUP PROJECT.pdf', '2025-07-06 05:00:14', 'rdsdsf', 22, 196, 'resr', ''),
(172, 'admin/uploads/5781_File_SOW DSC650.pdf', '2025-07-06 05:00:14', 'DSC650', 22, 196, 'SOW', ''),
(173, 'admin/uploads/1451_File_Lecture 8 - Trend in Data Technology - ODL.pdf', '2025-07-06 05:00:14', 'Trend in Data Technology', 22, 196, 'Lecture 8', ''),
(174, 'admin/uploads/3751_File_Lecture 7 - Big Data Technologies ODL.pdf', '2025-07-06 05:00:14', 'Big Data Technologies ODL', 22, 196, 'Lecture 7', ''),
(175, 'admin/uploads/2686_File_Lecture 6 - Searching and Indexing Big Data.pdf', '2025-07-06 05:00:14', 'Searching and Indexing Big Data', 22, 196, 'Lecture 6', ''),
(176, 'admin/uploads/1426_File_Lecture 5 - NoSQL.pdf', '2025-07-06 05:00:14', 'NoSQL', 22, 196, 'Lecture 5', ''),
(177, 'admin/uploads/4931_File_Lecture 4 - Data Processing.pdf', '2025-07-06 05:00:14', 'Data Processing', 22, 196, 'Lecture 4', ''),
(178, 'admin/uploads/9864_File_Lecture 3 - Data Storage Technology - 5.pdf', '2025-07-06 05:00:14', 'Data Storage Technology', 22, 196, 'Lecture 3', ''),
(179, 'admin/uploads/8971_File_Lecture 2 - Business Motivations and Drivers for Big Data Adoption.pdf', '2025-07-06 05:00:14', 'Business Motivations and Drivers for Big Data Adoption', 22, 196, 'Lecture 2', ''),
(180, 'admin/uploads/8438_File_GROUP 1 DCS650 GROUP PROJECT.pdf', '2025-07-06 05:00:14', 'dad', 22, 196, 'da', ''),
(181, 'admin/uploads/5667_File_Lecture 1 - Overview of Data Technology.pdf', '2025-07-06 05:00:48', 'Overview of Data Technology', 22, 197, 'Lecture 1', ''),
(182, 'admin/uploads/7235_File_GROUP 1 DCS650 GROUP PROJECT.pdf', '2025-07-06 05:00:48', 'rdsdsf', 22, 197, 'resr', ''),
(183, 'admin/uploads/5781_File_SOW DSC650.pdf', '2025-07-06 05:00:48', 'DSC650', 22, 197, 'SOW', ''),
(184, 'admin/uploads/1451_File_Lecture 8 - Trend in Data Technology - ODL.pdf', '2025-07-06 05:00:48', 'Trend in Data Technology', 22, 197, 'Lecture 8', ''),
(185, 'admin/uploads/3751_File_Lecture 7 - Big Data Technologies ODL.pdf', '2025-07-06 05:00:48', 'Big Data Technologies ODL', 22, 197, 'Lecture 7', ''),
(186, 'admin/uploads/2686_File_Lecture 6 - Searching and Indexing Big Data.pdf', '2025-07-06 05:00:48', 'Searching and Indexing Big Data', 22, 197, 'Lecture 6', ''),
(187, 'admin/uploads/1426_File_Lecture 5 - NoSQL.pdf', '2025-07-06 05:00:48', 'NoSQL', 22, 197, 'Lecture 5', ''),
(188, 'admin/uploads/4931_File_Lecture 4 - Data Processing.pdf', '2025-07-06 05:00:48', 'Data Processing', 22, 197, 'Lecture 4', ''),
(189, 'admin/uploads/9864_File_Lecture 3 - Data Storage Technology - 5.pdf', '2025-07-06 05:00:48', 'Data Storage Technology', 22, 197, 'Lecture 3', ''),
(190, 'admin/uploads/8971_File_Lecture 2 - Business Motivations and Drivers for Big Data Adoption.pdf', '2025-07-06 05:00:48', 'Business Motivations and Drivers for Big Data Adoption', 22, 197, 'Lecture 2', ''),
(191, 'admin/uploads/8438_File_GROUP 1 DCS650 GROUP PROJECT.pdf', '2025-07-06 05:00:48', 'dad', 22, 197, 'da', ''),
(192, 'admin/uploads/5667_File_Lecture 1 - Overview of Data Technology.pdf', '2025-07-06 05:00:48', 'Overview of Data Technology', 22, 197, 'Lecture 1', ''),
(193, 'admin/uploads/7235_File_GROUP 1 DCS650 GROUP PROJECT.pdf', '2025-07-06 05:00:48', 'rdsdsf', 22, 197, 'resr', ''),
(194, 'admin/uploads/5781_File_SOW DSC650.pdf', '2025-07-06 05:00:48', 'DSC650', 22, 197, 'SOW', ''),
(195, 'admin/uploads/1451_File_Lecture 8 - Trend in Data Technology - ODL.pdf', '2025-07-06 05:00:48', 'Trend in Data Technology', 22, 197, 'Lecture 8', ''),
(196, 'admin/uploads/3751_File_Lecture 7 - Big Data Technologies ODL.pdf', '2025-07-06 05:00:48', 'Big Data Technologies ODL', 22, 197, 'Lecture 7', ''),
(197, 'admin/uploads/2686_File_Lecture 6 - Searching and Indexing Big Data.pdf', '2025-07-06 05:00:48', 'Searching and Indexing Big Data', 22, 197, 'Lecture 6', ''),
(198, 'admin/uploads/1426_File_Lecture 5 - NoSQL.pdf', '2025-07-06 05:00:48', 'NoSQL', 22, 197, 'Lecture 5', ''),
(199, 'admin/uploads/4931_File_Lecture 4 - Data Processing.pdf', '2025-07-06 05:00:48', 'Data Processing', 22, 197, 'Lecture 4', ''),
(200, 'admin/uploads/9864_File_Lecture 3 - Data Storage Technology - 5.pdf', '2025-07-06 05:00:48', 'Data Storage Technology', 22, 197, 'Lecture 3', ''),
(201, 'admin/uploads/8971_File_Lecture 2 - Business Motivations and Drivers for Big Data Adoption.pdf', '2025-07-06 05:00:48', 'Business Motivations and Drivers for Big Data Adoption', 22, 197, 'Lecture 2', ''),
(202, 'admin/uploads/8438_File_GROUP 1 DCS650 GROUP PROJECT.pdf', '2025-07-06 05:00:48', 'dad', 22, 197, 'da', ''),
(243, 'admin/uploads/5677_File_Lecture 7 - Big Data Technologies ODL.pdf', '2025-07-07 03:29:38', 'Big Data Technologies ODL', 9, 202, 'Lecture 7', 'Ts. Dr. Iskandar Bin RahmanAli'),
(242, 'admin/uploads/4052_File_Lecture 6 - Searching and Indexing Big Data.pdf', '2025-07-07 03:29:17', 'Searching and Indexing Big Data', 9, 202, 'Lecture 6', 'Ts. Dr. Iskandar Bin RahmanAli'),
(241, 'admin/uploads/7996_File_Lecture 5 - NoSQL.pdf', '2025-07-07 03:29:02', 'NoSQL', 9, 202, 'Lecture 5', 'Ts. Dr. Iskandar Bin RahmanAli'),
(240, 'admin/uploads/7768_File_Lecture 4 - Data Processing.pdf', '2025-07-07 03:28:49', 'Data Processing', 9, 202, 'Lecture 4', 'Ts. Dr. Iskandar Bin RahmanAli'),
(239, 'admin/uploads/8835_File_Lecture 3 - Data Storage Technology - 5.pdf', '2025-07-07 03:28:35', 'Data Storage Technology', 9, 202, 'Lecture 3', 'Ts. Dr. Iskandar Bin RahmanAli'),
(225, 'admin/uploads/8438_File_GROUP 1 DCS650 GROUP PROJECT.pdf', '2025-07-06 05:07:36', 'dad', 0, 195, 'da', 'Ts. Dr. Iskandar Bin RahmanAli'),
(226, 'admin/uploads/7235_File_GROUP 1 DCS650 GROUP PROJECT.pdf', '2025-07-06 05:07:36', 'rdsdsf', 0, 195, 'resr', 'Ts. Dr. Iskandar Bin RahmanAli'),
(227, 'admin/uploads/5781_File_SOW DSC650.pdf', '2025-07-06 05:07:36', 'DSC650', 0, 195, 'SOW', 'Iskandar RahmanAli'),
(228, 'admin/uploads/1451_File_Lecture 8 - Trend in Data Technology - ODL.pdf', '2025-07-06 05:07:36', 'Trend in Data Technology', 0, 195, 'Lecture 8', 'Iskandar RahmanAli'),
(229, 'admin/uploads/3751_File_Lecture 7 - Big Data Technologies ODL.pdf', '2025-07-06 05:07:36', 'Big Data Technologies ODL', 0, 195, 'Lecture 7', 'Iskandar RahmanAli'),
(230, 'admin/uploads/2686_File_Lecture 6 - Searching and Indexing Big Data.pdf', '2025-07-06 05:07:36', 'Searching and Indexing Big Data', 0, 195, 'Lecture 6', 'Iskandar RahmanAli'),
(231, 'admin/uploads/1426_File_Lecture 5 - NoSQL.pdf', '2025-07-06 05:07:36', 'NoSQL', 0, 195, 'Lecture 5', 'Iskandar RahmanAli'),
(232, 'admin/uploads/4931_File_Lecture 4 - Data Processing.pdf', '2025-07-06 05:07:36', 'Data Processing', 0, 195, 'Lecture 4', 'Iskandar RahmanAli'),
(233, 'admin/uploads/9864_File_Lecture 3 - Data Storage Technology - 5.pdf', '2025-07-06 05:07:36', 'Data Storage Technology', 0, 195, 'Lecture 3', 'Iskandar RahmanAli'),
(234, 'admin/uploads/8971_File_Lecture 2 - Business Motivations and Drivers for Big Data Adoption.pdf', '2025-07-06 05:07:36', 'Business Motivations and Drivers for Big Data Adoption', 0, 195, 'Lecture 2', 'Iskandar RahmanAli'),
(235, 'admin/uploads/5667_File_Lecture 1 - Overview of Data Technology.pdf', '2025-07-06 05:07:36', 'Overview of Data Technology', 0, 195, 'Lecture 1', 'Iskandar RahmanAli'),
(236, 'admin/uploads/9265_File_SOW DSC650.pdf', '2025-07-07 03:27:23', 'DSC650', 9, 202, 'SOW', 'Ts. Dr. Iskandar Bin RahmanAli'),
(237, 'admin/uploads/2996_File_Lecture 1 - Overview of Data Technology.pdf', '2025-07-07 03:27:54', 'Overview of Data Technology', 9, 202, 'Lecture 1', 'Ts. Dr. Iskandar Bin RahmanAli'),
(238, 'admin/uploads/2052_File_Lecture 2 - Business Motivations and Drivers for Big Data Adoption.pdf', '2025-07-07 03:28:19', 'Business Motivations and Drivers for Big Data Adoption', 9, 202, 'Lecture 2', 'Ts. Dr. Iskandar Bin RahmanAli'),
(244, 'admin/uploads/4864_File_Lecture 8 - Trend in Data Technology - ODL.pdf', '2025-07-07 03:29:59', 'Trend in Data Technology', 9, 202, 'Lecture 8', 'Ts. Dr. Iskandar Bin RahmanAli'),
(245, 'admin/uploads/4864_File_Lecture 8 - Trend in Data Technology - ODL.pdf', '2025-07-07 03:31:10', 'Trend in Data Technology', 0, 203, 'Lecture 8', 'Ts. Dr. Iskandar Bin RahmanAli'),
(246, 'admin/uploads/5677_File_Lecture 7 - Big Data Technologies ODL.pdf', '2025-07-07 03:31:10', 'Big Data Technologies ODL', 0, 203, 'Lecture 7', 'Ts. Dr. Iskandar Bin RahmanAli'),
(247, 'admin/uploads/4052_File_Lecture 6 - Searching and Indexing Big Data.pdf', '2025-07-07 03:31:10', 'Searching and Indexing Big Data', 0, 203, 'Lecture 6', 'Ts. Dr. Iskandar Bin RahmanAli'),
(248, 'admin/uploads/7996_File_Lecture 5 - NoSQL.pdf', '2025-07-07 03:31:10', 'NoSQL', 0, 203, 'Lecture 5', 'Ts. Dr. Iskandar Bin RahmanAli'),
(249, 'admin/uploads/7768_File_Lecture 4 - Data Processing.pdf', '2025-07-07 03:31:10', 'Data Processing', 0, 203, 'Lecture 4', 'Ts. Dr. Iskandar Bin RahmanAli'),
(250, 'admin/uploads/8835_File_Lecture 3 - Data Storage Technology - 5.pdf', '2025-07-07 03:31:10', 'Data Storage Technology', 0, 203, 'Lecture 3', 'Ts. Dr. Iskandar Bin RahmanAli'),
(251, 'admin/uploads/2052_File_Lecture 2 - Business Motivations and Drivers for Big Data Adoption.pdf', '2025-07-07 03:31:10', 'Business Motivations and Drivers for Big Data Adoption', 0, 203, 'Lecture 2', 'Ts. Dr. Iskandar Bin RahmanAli'),
(252, 'admin/uploads/2996_File_Lecture 1 - Overview of Data Technology.pdf', '2025-07-07 03:31:10', 'Overview of Data Technology', 0, 203, 'Lecture 1', 'Ts. Dr. Iskandar Bin RahmanAli'),
(253, 'admin/uploads/9265_File_SOW DSC650.pdf', '2025-07-07 03:31:10', 'DSC650', 0, 203, 'SOW', 'Ts. Dr. Iskandar Bin RahmanAli'),
(254, 'admin/uploads/7118_File_DSC650 Case Study.pdf', '2025-07-10 10:57:12', 'Case Study', 22, 205, 'DSC650', 'Dr. Dahlia Karisma BintiZainal');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `message_id` int(11) NOT NULL,
  `reciever_id` int(11) NOT NULL,
  `content` varchar(200) NOT NULL,
  `date_sended` varchar(100) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `reciever_name` varchar(50) NOT NULL,
  `sender_name` varchar(200) NOT NULL,
  `message_status` varchar(100) NOT NULL,
  `reciever_student_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`message_id`, `reciever_id`, `content`, `date_sended`, `sender_id`, `reciever_name`, `sender_name`, `message_status`, `reciever_student_id`) VALUES
(79, 8, 'Lah, harini dah buat test 2', '2025-06-27 20:48:17', 69, 'Abdullah Zainal', 'Mazidah Binti Muhsin', '', NULL),
(86, 66, 'Hi', '2025-07-02 00:22:20', 70, 'Amanina Syamimi Binti Roslan', 'Irdina Dayini Binti Azamuddin', '', NULL),
(87, 68, 'Hi', '2025-07-02 00:22:59', 70, 'Mutmainnah Radiah Binti Jamal Abdul Hekim', 'Irdina Dayini Binti Azamuddin', 'read', NULL),
(88, 70, 'Hi\r\n', '2025-07-02 00:23:06', 68, 'Irdina Dayini Binti Azamuddin', 'Mutmainnah Radiah Binti Jamal Abdul Hekim', '', NULL),
(180, 65, 'Hi', '2025-07-10 10:28:18', 66, 'Alif Najmuddin Bin Akmar Jalil', 'Ahmad Aiman Hakim Bin Mohd Saleh', '', NULL),
(181, 66, 'Hi Aiman', '2025-07-10 10:28:27', 65, 'Ahmad Aiman Hakim Bin Mohd Saleh', 'Alif Najmuddin Bin Akmar Jalil', '', NULL),
(182, 9, 'Hi Dr', '2025-07-10 02:49:26', 22, '', '', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `message_sent`
--

CREATE TABLE `message_sent` (
  `message_sent_id` int(11) NOT NULL,
  `reciever_id` int(11) NOT NULL,
  `content` varchar(200) NOT NULL,
  `date_sended` varchar(100) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `reciever_name` varchar(100) NOT NULL,
  `sender_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `message_sent`
--

INSERT INTO `message_sent` (`message_sent_id`, `reciever_id`, `content`, `date_sended`, `sender_id`, `reciever_name`, `sender_name`) VALUES
(16, 65, 'hello', '2025-05-08 00:51:37', 67, 'Salina Ali', 'Jamilah Ahmad'),
(20, 64, 'Kindly meet me any time today. Thank you', '2025-06-26 23:26:22', 9, 'Adam Rahman', 'Iskandar Rahman Ali'),
(21, 10, 'Thanks, Farah! Glad to hear that. I try to keep the 5 Vâ€™s simple for the students to grasp.', '2025-06-26 23:32:00', 9, '', ''),
(22, 64, 'Please meet me any time tomorrow. Thank you', '2025-06-26 23:35:56', 9, 'Adam Rahman', 'Iskandar Rahman Ali'),
(23, 64, 'Please meet me any time tomorrow. Thank you', '2025-06-26 23:36:53', 9, 'Adam Rahman', 'Iskandar Rahman Ali'),
(24, 66, 'Please meet me any time tomorrow. Thank you', '2025-06-27 00:13:13', 9, 'Aminah Abdullah', 'Ts. Dr. Iskandar Rahman Ali'),
(25, 70, 'Sent to:', '2025-06-27 00:14:40', 9, 'Aidan Rayyan Mohd Ali', 'Ts. Dr. Iskandar Rahman Ali'),
(26, 64, 'Please meet me any time tomorrow. Thank you', '2025-06-27 00:14:58', 9, 'Adam Rahman', 'Ts. Dr. Iskandar Rahman Ali'),
(27, 0, 'Thanks, Farah! Glad to hear that. I try to keep the 5 Vâ€™s simple for the students to grasp.', '2025-06-27 00:16:33', 9, '', ''),
(28, 0, 'Sent to:', '2025-06-27 00:18:35', 9, 'Unknown', ''),
(29, 66, 'sada', '2025-06-27 00:21:23', 9, 'Aminah Abdullah', 'Ts. Dr. Iskandar Rahman Ali'),
(30, 67, 'fdafdfdajamilah', '2025-06-27 00:21:54', 9, 'Jamilah Ahmad', 'Ts. Dr. Iskandar Rahman Ali'),
(31, 70, 'aidan', '2025-06-27 00:24:04', 9, 'Aidan Rayyan Mohd Ali', 'Ts. Dr. Iskandar Rahman Ali'),
(32, 64, 'Please meet me tomorrow. Thank you', '2025-06-27 00:31:21', 9, 'Adam Rahman', 'Ts. Dr. Iskandar Rahman Ali'),
(33, 0, 'Thanks, Farah! Glad to hear that. I try to keep the 5 Vâ€™s simple for the students to grasp.', '2025-06-27 00:31:55', 9, 'Unknown', ''),
(34, 0, 'Thanks, Farah! Glad to hear that. I try to keep the 5 Vâ€™s simple for the students to grasp.', '2025-06-27 00:34:02', 9, 'Unknown', ''),
(35, 10, 'Thanks, Farah! Glad to hear that. I try to keep the 5 Vâ€™s simple for the students to grasp.', '2025-06-27 00:34:41', 9, 'Hafizah Hasan', 'Ts. Dr. Iskandar Rahman Ali'),
(36, 9, 'Mind if I borrow that approach for my next session?', '2025-06-27 00:35:04', 10, 'Aisyah Nur Mohd Salleh', 'Ts. Farah Nabila Hassan'),
(37, 10, 'Of course, go ahead! Let me know how it goes.', '2025-06-27 00:35:27', 9, 'Hafizah Hasan', 'Ts. Dr. Iskandar Rahman Ali'),
(38, 9, 'Sure Dr', '2025-06-27 00:36:23', 64, 'Ts. Dr. Iskandar Rahman Ali', 'Adam Rahman'),
(39, 9, 'May I know when you will be available tomorrow?', '2025-06-27 00:38:34', 64, 'Ts. Dr. Iskandar Rahman Ali', 'Adam Rahman'),
(40, 64, 'I will be free 10-12', '2025-06-27 00:39:10', 9, 'Adam Rahman', 'Ts. Dr. Iskandar Rahman Ali'),
(43, 64, 'Hello', '2025-06-27 00:41:28', 67, 'Adam Rahman', 'Jamilah Ahmad'),
(44, 10, 'Hi madam, may I meet you tomorrow. I want to make an interview with you regarding my final year project.', '2025-06-27 00:42:48', 67, 'Ts. Farah Nabila Hassan', 'Jamilah Ahmad'),
(45, 67, 'Yes sure, meet me after 2', '2025-06-27 00:43:05', 10, 'Jamilah Ahmad', 'Ts. Farah Nabila Hassan'),
(48, 8, 'Lah, harini dah buat test 2', '2025-06-27 20:48:17', 69, 'Abdullah Zainal', 'Mazidah Binti Muhsin'),
(55, 66, 'Hi', '2025-07-02 00:22:20', 70, 'Amanina Syamimi Binti Roslan', 'Irdina Dayini Binti Azamuddin'),
(56, 68, 'Hi', '2025-07-02 00:22:59', 70, 'Mutmainnah Radiah Binti Jamal Abdul Hekim', 'Irdina Dayini Binti Azamuddin'),
(57, 70, 'Hi\r\n', '2025-07-02 00:23:06', 68, 'Irdina Dayini Binti Azamuddin', 'Mutmainnah Radiah Binti Jamal Abdul Hekim'),
(59, 11, 'hi', '2025-07-05 00:32:23', 1, 'Aizatul Sufi Binti Sulaiman Shah', 'Ahmad Zulkifli Ismail'),
(60, 47, 'hi', '2025-07-05 00:32:36', 1, 'Nur Fauziah Hanim Binti Hassan', 'Ahmad Zulkifli Ismail'),
(61, 47, 'dada', '2025-07-05 00:39:03', 9, 'Nur Fauziah Hanim Binti Hassan', 'Ts. Dr. Iskandar Bin Rahman Ali'),
(63, 47, 'dada', '2025-07-05 00:39:50', 9, 'Nur Fauziah Hanim Binti Hassan', 'Ts. Dr. Iskandar Bin Rahman Ali'),
(64, 47, 'dada', '2025-07-05 00:39:50', 9, 'Nur Fauziah Hanim Binti Hassan', 'Ts. Dr. Iskandar Bin Rahman Ali'),
(66, 47, 'fdafa', '2025-07-05 00:40:45', 9, 'Nur Fauziah Hanim Binti Hassan', 'Ts. Dr. Iskandar Bin Rahman Ali'),
(67, 47, 'faff', '2025-07-05 00:41:17', 9, 'Nur Fauziah Hanim Binti Hassan', 'Ts. Dr. Iskandar Bin Rahman Ali'),
(71, 47, 'yo', '2025-07-05 00:45:59', 9, 'Nur Fauziah Hanim Binti Hassan', 'Ts. Dr. Iskandar Bin Rahman Ali'),
(79, 47, 'lajhhh', '2025-07-05 00:52:11', 9, 'Nur Fauziah Hanim Binti Hassan', 'Ts. Dr. Iskandar Bin Rahman Ali'),
(81, 47, 'hanim', '2025-07-05 00:54:10', 9, 'Nur Fauziah Hanim Binti Hassan', 'Ts. Dr. Iskandar Bin Rahman Ali'),
(133, 65, 'Hi', '2025-07-10 10:28:18', 66, 'Alif Najmuddin Bin Akmar Jalil', 'Ahmad Aiman Hakim Bin Mohd Saleh'),
(134, 66, 'Hi Aiman', '2025-07-10 10:28:27', 65, 'Ahmad Aiman Hakim Bin Mohd Saleh', 'Alif Najmuddin Bin Akmar Jalil');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `notification_id` int(11) NOT NULL,
  `teacher_class_id` int(11) NOT NULL,
  `notification` varchar(100) NOT NULL,
  `date_of_notification` varchar(50) NOT NULL,
  `link` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`notification_id`, `teacher_class_id`, `notification`, `date_of_notification`, `link`) VALUES
(140, 202, 'Add Practice Quiz file', '2025-07-07 20:26:28', 'student_quiz_list.php'),
(141, 202, 'Add Annoucements', '2025-07-10 10:31:30', 'announcements_student.php'),
(142, 205, 'Add Downloadable Materials file name <b>DSC650</b>', '2025-07-10 10:57:12', 'downloadable_student.php');

-- --------------------------------------------------------

--
-- Table structure for table `notification_read`
--

CREATE TABLE `notification_read` (
  `notification_read_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `student_read` varchar(50) NOT NULL,
  `notification_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification_read_teacher`
--

CREATE TABLE `notification_read_teacher` (
  `notification_read_teacher_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `student_read` varchar(100) NOT NULL,
  `notification_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `notification_read_teacher`
--

INSERT INTO `notification_read_teacher` (`notification_read_teacher_id`, `teacher_id`, `student_read`, `notification_id`) VALUES
(12, 9, 'yes', 26),
(13, 9, 'yes', 25),
(14, 9, 'yes', 24),
(15, 9, 'yes', 23),
(16, 9, 'yes', 22),
(17, 9, 'yes', 42),
(18, 9, 'yes', 41),
(19, 9, 'yes', 40),
(20, 9, 'yes', 39),
(21, 9, 'yes', 38),
(22, 9, 'yes', 37),
(23, 9, 'yes', 36),
(24, 9, 'yes', 35),
(25, 9, 'yes', 34),
(26, 9, 'yes', 33),
(27, 9, 'yes', 32),
(28, 9, 'yes', 31),
(29, 9, 'yes', 30),
(30, 9, 'yes', 29),
(31, 9, 'yes', 28),
(32, 9, 'yes', 27);

-- --------------------------------------------------------

--
-- Table structure for table `question_type`
--

CREATE TABLE `question_type` (
  `question_type_id` int(11) NOT NULL,
  `question_type` varchar(150) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `question_type`
--

INSERT INTO `question_type` (`question_type_id`, `question_type`) VALUES
(1, 'Multiple Choice'),
(2, 'True or False');

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE `quiz` (
  `quiz_id` int(11) NOT NULL,
  `quiz_title` varchar(50) NOT NULL,
  `quiz_description` varchar(100) NOT NULL,
  `date_added` varchar(100) NOT NULL,
  `teacher_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `quiz`
--

INSERT INTO `quiz` (`quiz_id`, `quiz_title`, `quiz_description`, `date_added`, `teacher_id`) VALUES
(12, 'Lecture 1', 'Overview of Data Technology', '2025-06-26 15:57:09', 9),
(13, 'Lecture 2', 'Business Motivations and Drivers for Big Data Adoption', '2025-06-26 15:59:24', 9),
(25, 'Lecture 3', 'Data Storage Technology', '2025-07-07 03:50:00', 9),
(26, 'Lecture 4', 'Data Processing', '2025-07-07 04:04:31', 9),
(27, 'Lecture 5', 'NoSQL', '2025-07-07 04:06:29', 9),
(28, 'Lecture 6', 'Searching and Indexing Big Data', '2025-07-07 04:10:52', 9),
(29, 'Lecture 7', 'Big Data Technologies ODL', '2025-07-07 04:13:32', 9),
(30, 'Lecture 8', 'Trend in Data Technology', '2025-07-07 04:16:21', 9);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_question`
--

CREATE TABLE `quiz_question` (
  `quiz_question_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `question_text` varchar(100) NOT NULL,
  `question_type_id` int(11) NOT NULL,
  `points` int(11) NOT NULL,
  `date_added` varchar(100) NOT NULL,
  `answer` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `quiz_question`
--

INSERT INTO `quiz_question` (`quiz_question_id`, `quiz_id`, `question_text`, `question_type_id`, `points`, `date_added`, `answer`) VALUES
(43, 7, '<p>Mobile operating systems like Android and iOS use different kernels to manage hardware interactio', 2, 0, '2025-06-19 02:37:03', 'True'),
(44, 7, '<p>4G networks are slower than 3G networks in terms of data transfer speed.</p>\r\n', 2, 0, '2025-06-19 02:37:16', 'False'),
(45, 7, '<p>Mobile apps can only be developed using platform-specific languages such as Swift for iOS and Jav', 2, 0, '2025-06-19 02:37:26', 'False'),
(46, 8, '<p>Which of the following are characteristics of a <strong>relational database</strong>? <em>(Select', 1, 0, '2025-06-19 02:49:08', 'A'),
(47, 10, '', 1, 0, '2025-06-25 22:20:40', 'A'),
(48, 11, '<p>asassa</p>\r\n', 1, 0, '2025-06-25 22:23:41', 'A'),
(49, 11, '<p>asa</p>\r\n', 1, 0, '2025-06-25 22:23:54', 'A'),
(50, 12, '<p>Big Data can only handle structured data.</p>\r\n', 2, 0, '2025-06-26 15:57:34', 'False'),
(51, 12, '<p>One of the goals of data analysis is to support better decision-making.</p>\r\n', 2, 0, '2025-06-26 15:57:45', 'True'),
(52, 12, '<p>Velocity in Big Data refers to the variety of data types.</p>\r\n', 2, 0, '2025-06-26 15:57:55', 'False'),
(53, 12, '<p>Diagnostic analytics focuses on predicting future outcomes.</p>\r\n', 2, 0, '2025-06-26 15:58:07', 'False'),
(54, 12, '<p>XML and JSON files are examples of semi-structured data.</p>\r\n', 2, 0, '2025-06-26 15:58:17', 'True'),
(55, 13, '<p>What is a primary motivation for organizations to adopt Big Data technologies?</p>\r\n', 1, 0, '2025-06-26 16:00:17', 'C'),
(56, 13, '<p>In the context of business process management, what is a business process?</p>\r\n', 1, 0, '2025-06-26 16:00:40', 'C'),
(57, 13, '<p>Which of the following best describes data analytics?</p>\r\n', 1, 0, '2025-06-26 16:01:08', 'C'),
(58, 13, '<p>How does data science differ from data analytics?</p>\r\n', 1, 0, '2025-06-26 16:01:41', 'C'),
(59, 13, '<p>Why is digitization important in modern business operations?</p>\r\n', 1, 0, '2025-06-26 16:02:07', 'C'),
(71, 25, '<p>Relational Database Management Systems (RDBMS) are ideal for long-term storage of data that accum', 2, 0, '2025-07-07 03:58:58', 'False'),
(72, 25, '<p>Which of the following is NOT a characteristic of Distributed File Systems (DFS)?</p>', 1, 0, '2025-07-07 04:00:20', 'C'),
(73, 25, '<p>In HDFS, the NameNode is responsible for storing the actual data blocks of files.</p>', 2, 0, '2025-07-07 04:00:54', 'False'),
(74, 25, '<p>What is the default block size for files in Hadoop Distributed File System (HDFS)?</p>', 1, 0, '2025-07-07 04:02:14', 'B'),
(75, 0, '<p>One of the benefits of HDFS Rack Awareness is to improve network bandwidth through a closer repli', 2, 0, '2025-07-07 04:02:27', 'True'),
(76, 25, '<p>One of the benefits of HDFS Rack Awareness is to improve network bandwidth through a closer repli', 2, 0, '2025-07-07 04:03:19', 'True'),
(77, 26, '<p>Data munging is also known as data wrangling and involves transforming raw data into a more appro', 2, 0, '2025-07-07 04:04:48', 'True'),
(78, 0, '<p>Which of the following best describes &quot;Batch&quot; processing workloads?</p>', 1, 0, '2025-07-07 04:05:21', 'C'),
(79, 0, '<p>Primarily used for Online Transaction Processing (OLTP) systems.</p>', 2, 0, '2025-07-07 04:05:35', 'False'),
(80, 0, '<p>What is the core concept in Apache Spark that represents a fault-tolerant, immutable, and distrib', 1, 0, '2025-07-07 04:06:06', 'C'),
(81, 0, '<p>Data locality in Hadoop MapReduce aims to move large data to the computation instead of moving th', 2, 0, '2025-07-07 04:06:17', 'False'),
(82, 27, '<p>NoSQL databases typically require a fixed schema, similar to traditional Relational Database Mana', 2, 0, '2025-07-07 04:07:24', 'False'),
(83, 27, '<p>Which of the following is NOT a type of NoSQL database mentioned in the document?</p>', 1, 0, '2025-07-07 04:08:01', 'C'),
(84, 27, '<p>The BASE properties (Basically available, Soft state, Eventual consistency) are characteristic of', 2, 0, '2025-07-07 04:09:56', 'False'),
(85, 27, '<p>In the context of NoSQL databases, what does &quot;Soft state&quot; in BASE properties imply?</p>', 1, 0, '2025-07-07 04:10:26', 'B'),
(86, 27, '<p>HBase is a row-oriented database built on top of Hadoop and HDFS.</p>', 2, 0, '2025-07-07 04:10:40', 'False'),
(87, 28, '<p>Solr is a standalone search platform built using Apache Lucene, and it is written entirely in C++', 2, 0, '2025-07-07 04:11:56', 'False'),
(88, 28, '<p>Which of the following best describes the relationship between Solr and Lucene, as conceptualized', 1, 0, '2025-07-07 04:12:27', 'C'),
(89, 28, '<p>In the Solr indexing process, &quot;Field analysis&quot; is the step where the inverted index is ', 2, 0, '2025-07-07 04:12:47', 'False'),
(90, 28, '<p>Which component in Solr is responsible for translating the user query into instructions that Luce', 1, 0, '2025-07-07 04:13:12', 'C'),
(91, 28, '<p>Elasticsearch is built on top of Lucene, and its development is merged with Lucene, ensuring it a', 2, 0, '2025-07-07 04:13:21', 'False'),
(92, 29, '<p>Apache Hadoop is a database system designed to replace traditional relational databases for all d', 2, 0, '2025-07-07 04:13:58', 'False'),
(93, 29, '<p>Which of the following are the two main components of Apache Hadoop?</p>', 1, 0, '2025-07-07 04:14:30', 'B'),
(94, 29, '<p>In Hadoop V1, MapReduce was solely responsible for data processing, while a separate component ha', 2, 0, '2025-07-07 04:14:43', 'False'),
(95, 29, '<p>What is the primary purpose of Apache Hive?</p>', 1, 0, '2025-07-07 04:15:16', 'C'),
(96, 29, '<p>Apache Sqoop supports bi-directional data transfer between a relational database and Apache Hive.', 2, 0, '2025-07-07 04:16:08', 'False'),
(97, 30, '<p>Data Discovery is a business user-oriented process that primarily focuses on generating complex s', 2, 0, '2025-07-07 04:16:46', 'False'),
(98, 30, '<p>According to Gartner, Big Data Discovery is a combination of which three elements?</p>', 1, 0, '2025-07-07 04:17:22', 'B'),
(99, 30, '<p>Deep learning is a subfield of artificial intelligence that focuses on creating small, simple neu', 2, 0, '2025-07-07 04:17:33', 'False'),
(100, 30, '<p>In which of the following real-world applications is deep learning NOT mentioned as being used?</', 1, 0, '2025-07-07 04:18:01', 'B'),
(101, 30, '<p>Machine learning involves the development of algorithms that enable a computer to extract functio', 2, 0, '2025-07-07 04:18:16', 'True');

-- --------------------------------------------------------

--
-- Table structure for table `school_year`
--

CREATE TABLE `school_year` (
  `school_year_id` int(11) NOT NULL,
  `school_year` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `school_year`
--

INSERT INTO `school_year` (`school_year_id`, `school_year`) VALUES
(1, 'OCTOBER 2024 â€“ FEBRUARY 2025'),
(2, 'MARCH 2025 - AUGUST 2025');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `class_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `total_study_time` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `firstname`, `lastname`, `class_id`, `username`, `password`, `location`, `status`, `total_study_time`) VALUES
(1, 'Muhammad Abu', 'Abdullah', 1, '2021646248', 'ali', 'uploads/ChatGPT Image May 7, 2025, 10_50_09 PM.png', 'Registered', 0),
(2, 'Siti Aisyah', 'Ahmad', 1, '2021569889', 'aisyah', 'uploads/ChatGPT Image May 7, 2025, 10_49_06 PM.png', 'Registered', 0),
(3, 'Muhammad Muzhahir Bin', 'Yahaya', 10, '2021458998', 'Muzhahir@123', 'uploads/2.png', 'Registered', 0),
(4, 'Nurul Huda', 'Mohd Yusof', 1, '2021556558', 'huda', 'uploads/ChatGPT Image May 7, 2025, 10_49_04 PM.png', 'Registered', 0),
(5, 'Muhammad Iqbal', 'Nasir', 1, '2021663336', 'iqbal', 'uploads/ChatGPT Image May 7, 2025, 10_47_47 PM.png', 'Registered', 0),
(6, 'Siti Khadijah', 'Abdul Rahman', 1, '2021556363', 'katty', 'uploads/ChatGPT Image May 7, 2025, 10_49_04 PM.png', 'Registered', 0),
(7, 'Nur Humaira Binti', 'Ahmad', 1, '2021554778', 'Humaira@123', 'uploads/ChatGPT Image May 7, 2025, 10_50_51 PM.png', 'Registered', 0),
(8, 'Abdullah', 'Zainal', 2, '2021665224', 'abdul', 'uploads/ChatGPT Image May 7, 2025, 10_50_09 PM.png', 'Registered', 0),
(10, 'Hafizah', 'Hasan', 2, '2021663285', 'hafizah', 'uploads/ChatGPT Image May 7, 2025, 10_49_06 PM.png', 'Registered', 0),
(11, 'Aizatul Sufi Binti', 'Sulaiman Shah', 2, '2021558998', 'sufi', 'uploads/ChatGPT Image May 7, 2025, 10_47_47 PM.png', 'Registered', 0),
(12, 'Sharifah Ameerah', 'Ali', 2, '2021589885', 'sharifah', 'uploads/ChatGPT Image May 7, 2025, 10_49_06 PM.png', 'Registered', 0),
(13, 'Nabil', 'Azman', 2, '2021558774', 'nabil', 'uploads/ChatGPT Image May 7, 2025, 10_47_47 PM.png', 'Registered', 0),
(14, 'Fahmi', 'Ahmad', 2, '2021554778', 'fahmi', 'uploads/ChatGPT Image May 7, 2025, 10_47_47 PM.png', 'Registered', 0),
(15, 'Nur Fadilah', 'Omar', 3, '2021442336', 'fadilah', 'uploads/ChatGPT Image May 7, 2025, 10_49_04 PM.png', 'Registered', 0),
(16, 'Muhammad Rizal', 'Saad', 3, '2021663321', 'rizal', 'uploads/ChatGPT Image May 7, 2025, 10_50_51 PM.png', 'Registered', 0),
(17, 'Farhan', 'Mohd Zaki', 3, '2021488554', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(18, 'Amina', 'Hassan', 3, '2021445887', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(19, 'Kamal', 'Ibrahim', 3, '2021448889', 'kamal', 'uploads/ChatGPT Image May 7, 2025, 10_47_47 PM.png', 'Registered', 0),
(20, 'Siti Mariam', 'Yusof', 3, '2021544879', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(21, 'Akmal', 'Azlan', 3, '2021789654', 'akmal', 'uploads/ChatGPT Image May 7, 2025, 10_50_51 PM.png', 'Registered', 0),
(22, 'Zulkifli', 'Mustapha', 4, '2021448775', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(23, 'Nor Azimah', 'Ibrahim', 4, '2021448996', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(24, 'Abdul Karim', 'Zainuddin', 4, '2021448795', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(25, 'Rashid', 'Ismail', 4, '2021448996', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(26, 'Siti Fatimah', 'Osman', 4, '2021452114', 'fatimah', 'uploads/ChatGPT Image May 7, 2025, 10_49_04 PM.png', 'Registered', 0),
(27, 'Ahmad Zahid', 'Khalid', 4, '2021421325', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(28, 'Nabila', 'Manaf', 4, '2021559998', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(29, 'Saiful Anwar', 'Ismail', 5, '2021558996', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(30, 'Nadya', 'Rahman', 5, '2021558996', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(31, 'Arif', 'Samad', 5, '2021447885', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(32, 'Rina', 'Idris', 5, '2021559886', 'rina', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(33, 'Izzuddin', 'Zulkifli', 5, '2021447785', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(34, 'Sharifah Nurul', 'Syed Ali', 5, '2021448775', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(35, 'Syafikah', 'Zakaria', 5, '2021448785', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(36, 'Amir', 'Azhar', 6, '2021448775', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(37, 'Siti Nur', 'Syed Ibrahim', 6, '2021448796', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(38, 'Mohd Faiz', 'Omar', 6, '2021448554', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(39, 'Nurul Hidayah', 'Mohd Rafi', 6, '2021587556', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(40, 'Yusuf', 'Jamal', 6, '202144878', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(41, 'Hidayah', 'Halim', 6, '2021445789', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(42, 'Najiha Binti', 'Mahazir', 6, '2021487542', 'najiha', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(43, 'Imran', 'Hashim', 7, '2021543212', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(44, 'Ammar', 'Mohammad', 7, '2021448662', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(45, 'Siti Zubaidah', 'Jamil', 7, '2021557996', 'zubaidah', 'uploads/ChatGPT Image May 7, 2025, 10_49_06 PM.png', 'Registered', 0),
(46, 'Rizki', 'Abdurrahman', 7, '2021785632', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(47, 'Nur Fauziah Hanim Binti', 'Hassan', 7, '2021487563', 'Hanim@123', 'uploads/ChatGPT Image May 7, 2025, 10_49_06 PM.png', 'Registered', 0),
(48, 'Aiman', 'Faris', 7, '2021896325', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(49, 'Siti Aminah', 'Mohd Jamil', 7, '2021457986', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(50, 'Faris Rayyan', 'Ismail', 8, '2021457896', 'faris@123', 'uploads/ChatGPT Image May 7, 2025, 10_50_51 PM.png', 'Registered', 0),
(51, 'Norazlina', 'Ahmad', 8, '2021578965', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(52, 'Azman', 'Saad', 8, '2021457445', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(53, 'Mira', 'Khalid', 8, '2021445784', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(54, 'Syed Ahmad', 'Syed Zain', 8, '2021457451', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(55, 'Siti Nabilah', 'Ismail', 8, '2021487542', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(56, 'Rashidah', 'Abdul Rahman', 8, '2021457854', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(57, 'Hassan', 'Muhammad', 9, '2021457542', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(58, 'Siti Aisyah', 'Anwar', 9, '2021548962', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(59, 'Razif', 'Hassan', 9, '2021452123', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(60, 'Nina', 'Syed Abdul', 9, '20214545688', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(61, 'Hakim', 'Ismail', 9, '2021451369', 'hakim', 'uploads/ChatGPT Image May 7, 2025, 10_50_09 PM.png', 'Registered', 0),
(62, 'Lina', 'Ahmad', 9, '2021548875', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(63, 'Siti Zaitun', 'Mohd Sidi', 9, '2021545525', 'zaitun', 'uploads/ChatGPT Image May 7, 2025, 10_49_04 PM.png', 'Registered', 0),
(64, 'Nur Iriana Binti', 'Muhamad Shukri', 10, '2021542322', 'Iriana@123', 'uploads/9.png', 'Registered', 0),
(65, 'Alif Najmuddin Bin', 'Akmar Jalil', 10, '2021457892', 'Alif@123', 'uploads/1.png', 'Registered', 0),
(66, 'Ahmad Aiman Hakim Bin', 'Mohd Saleh', 10, '2021185121', 'Aiman@123', 'uploads/5.png', 'Registered', 0),
(67, 'Anis Yasmin Binti', 'Muhamad Shaharuddin', 10, '2021548896', 'Anis@123', 'uploads/3.png', 'Registered', 0),
(68, 'Mutmainnah Radiah Binti', 'Jamal Abdul Hekim', 10, '2021457456', 'Mutmainnah@123', 'uploads/4.png', 'Registered', 0),
(69, 'Mazidah Binti', 'Muhsin', 10, '2021548565', 'Mazidah@123', 'uploads/7.png', 'Registered', 0),
(70, 'Irdina Dayini Binti', 'Azamuddin', 10, '2021557896', 'Irdina@123', 'uploads/8.png', 'Registered', 0),
(71, 'Mohamad Airel Aidit Bin', 'Rosli', 11, '2021665889', 'Airel@123', 'uploads/1.png', 'Registered', 0),
(72, 'Muhammad Syafiq Norhazwan Bin', 'Nor Razmzi', 11, '2021557120', 'Syafiq@123', 'uploads/2.png', 'Registered', 0),
(73, 'Muhammad Nur Ilham Bin', 'Muhamad Nazir', 11, '2021454120', 'Ilham@123', 'uploads/5.png', 'Registered', 0),
(74, 'Irfan Naqiuddin Bin', 'Mazdi Faizal', 11, '2021541001', 'Irfan@123', 'uploads/6.png', 'Registered', 0),
(75, 'Amanina Syamimi Binti', 'Roslan', 11, '2021452001', 'Amanina@123', 'uploads/7.png', 'Registered', 0),
(76, 'Busyra Binti', 'Sukria', 11, '2021456523', 'Busyra@123', 'uploads/8.png', 'Registered', 0),
(77, 'Nurtysha Balqis Binti', 'Muhamad Yazid', 11, '2021669856', 'Tysha@123', 'uploads/9.png', 'Registered', 0),
(78, 'Nur Aqilah Humaira Binti', 'Ahmad', 11, '2021541020', 'Aqilah@123', 'uploads/12.png', 'Registered', 0),
(79, 'Zidan Farhan', 'Azman', 12, '2021001232', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(80, 'Fikri Nabil', 'Mohd Noor', 12, '2021332636', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(81, 'Danish Hariz', 'Zainal', 12, '20211021121', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(82, 'Muhammad Haydar Bin', 'Rosli', 10, '2021332298', 'Haydar@123', 'uploads/6.png', 'Registered', 0),
(83, 'Nashriq Zulkifli', 'Ahmad', 12, '2021653212', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(84, 'Fayez Darrel', 'Rauf', 12, '2021548789', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(85, 'Khalil Rayyan', 'Mahmud', 12, '2021554789', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(86, 'Zarif Kael', 'Jamal', 13, '2021558989', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(87, 'Hassan Rafael', 'Ibrahim', 13, '20214114121', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(88, 'Qayyum Milan', 'Ariff', 13, '2021554656', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(89, 'Naim Kayson', 'Zainuddin', 13, '2021445656', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(90, 'Syakir Zayyan', 'Aziz', 13, '2021201115', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(91, 'Izwan Amir', 'Hafiz', 13, '2021201430', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(92, 'Kamil Reza', 'Shamsuddin', 13, '2021200984', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(93, 'Iqbal Rayyan', 'Mohd Roslan', 14, '2021100527', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(94, 'Aidan Zul', 'Faizal', 14, '2021200935', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(95, 'Naufal Ben', 'Hassan', 14, '2021201268', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(96, 'Zayn Idris', 'Rahman', 14, '2021100293', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(97, 'Mikhail Kye', 'Mahmud', 14, '2021100613', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(98, 'Zairil Arman', 'Khalid', 14, '2021300413', 'zairil', 'uploads/ChatGPT Image May 7, 2025, 10_50_51 PM.png', 'Registered', 0),
(99, 'Rizal Jaden', 'Sulaiman', 14, '2021300311', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(100, 'Raziq Dylan', 'Ismail', 14, '2021300036', 'raziq', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(101, 'Nadhir Kieran', 'Mohamad', 15, '2021101123', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(102, 'Irfan Zachary', 'Haris', 15, '2021200363', 'irfan', 'uploads/ChatGPT Image May 7, 2025, 10_50_51 PM.png', 'Registered', 0),
(103, 'Syafiq Kyle', 'Abdul Razak', 15, '2021300410', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(104, 'Ariq Azlan', 'Firdaus', 15, '2021300375', 'maayeeh', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(105, 'Izhar Kyler', 'Hafizan', 15, '2021300258', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(106, 'Aidan Zayyan', 'Nordin', 15, '2021300176', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(107, 'Darren Izzan', 'Sharif', 15, '2021200507', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(108, 'Rayyan Khalil', 'Mustafa', 15, '2021100452', 'rayyan', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(109, 'Adlan Neo', 'Sayed', 15, '2021211120', 'neo', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(220, 'Nur Ain Syuhada Binti', 'Mohd Nasir', 11, '2022646556', 'Syuhada@123', 'uploads/11.png', 'Registered', 0),
(221, 'Syahirah', 'Zainal', 6, '2022648998', '', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Unregistered', 0),
(222, 'Fakhrul Hafiz Bin', 'Hisham', 10, '2021646666', 'Fakhrul@123', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0),
(223, 'Tun Laila Binti', 'Abu Kasim', 10, '2022588555', 'Laila@123', 'uploads/NO-IMAGE-AVAILABLE.jpg', 'Registered', 0);

-- --------------------------------------------------------

--
-- Table structure for table `student_assignment`
--

CREATE TABLE `student_assignment` (
  `student_assignment_id` int(11) NOT NULL,
  `assignment_id` int(11) NOT NULL,
  `floc` varchar(100) NOT NULL,
  `assignment_fdatein` varchar(50) NOT NULL,
  `fdesc` varchar(100) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `student_id` int(11) NOT NULL,
  `grade` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `student_assignment`
--

INSERT INTO `student_assignment` (`student_assignment_id`, `assignment_id`, `floc`, `assignment_fdatein`, `fdesc`, `fname`, `student_id`, `grade`) VALUES
(3, 33, 'admin/uploads/1782_File_ICT602.pdf', '2025-06-19 02:42:26', 'GP 1', 'Case study', 64, '100'),
(4, 37, 'admin/uploads/4366_File_ChatGPT_Image_May_8__2025__01_52_43_AM-removebg-preview.png', '2025-06-25 22:25:34', 'aina', 'ain', 65, ''),
(5, 39, 'admin/uploads/8108_File_GROUP 1 DCS650 GROUP PROJECT.pdf', '2025-06-27 02:40:29', 'CDCS2406A', 'GROUP 1', 64, '90'),
(6, 39, 'admin/uploads/9287_File_GROUP 1 DCS650 GROUP PROJECT.pdf', '2025-06-27 20:42:07', 'testt', 'Testt', 69, '93'),
(7, 39, 'admin/uploads/5763_File_GROUP 1 DCS650 GROUP PROJECT.pdf', '2025-06-27 20:57:17', 'dah siapp', 'qiqi comel', 7, '92'),
(8, 39, 'admin/uploads/4010_File_GROUP 1 DCS650 GROUP PROJECT.pdf', '2025-06-27 21:22:10', 'testt', 'CASE STUDY', 68, '91'),
(9, 39, 'admin/uploads/7053_File_GROUP 1 DCS650 GROUP PROJECT.pdf', '2025-06-27 21:46:00', 'ain muthalib', 'Nebuva', 220, '95'),
(10, 47, 'admin/uploads/5485_File_DSC650 Case Study.pdf', '2025-07-09 17:45:16', '2021185121', 'CASE STUDY', 66, '91'),
(11, 49, 'admin/uploads/5360_File_GROUP 1 DCS650 GROUP PROJECT.pdf', '2025-07-09 17:46:05', 'Group 1', 'Group Project', 66, '87'),
(12, 51, 'admin/uploads/1159_File_DSC650 Individual Assignment.pdf', '2025-07-09 17:47:19', '2021185121', 'Group Project', 66, '91'),
(13, 47, 'admin/uploads/6653_File_GROUP 2 - DSC650 Case Study.pdf', '2025-07-09 17:55:26', 'Group 2', 'CASE STUDY', 68, '90'),
(14, 51, 'admin/uploads/8195_File_DSC650 Individual Assignment.pdf', '2025-07-09 17:55:51', '2021457456', 'Individual', 68, '83'),
(15, 47, 'admin/uploads/7968_File_GROUP 3 - DSC650 Case Study.pdf', '2025-07-09 18:01:24', 'Group 3', 'CASE STUDY', 3, '93'),
(16, 49, 'admin/uploads/8244_File_GROUP 2 DCS650 GROUP PROJECT.pdf', '2025-07-09 18:01:37', 'Group 2', 'Group Project', 3, '89'),
(17, 51, 'admin/uploads/3498_File_DSC650 Individual Assignment.pdf', '2025-07-09 18:01:55', '2021458998', 'Individual', 3, '81'),
(18, 47, 'admin/uploads/6651_File_GROUP 1 - DSC650 Case Study.pdf', '2025-07-09 18:09:14', 'Group 4', 'CASE STUDY', 65, '95'),
(19, 49, 'admin/uploads/8588_File_GROUP 3 DCS650 GROUP PROJECT.pdf', '2025-07-09 18:09:28', 'Group 3', 'Group Project', 65, '84'),
(20, 51, 'admin/uploads/9204_File_DSC650 Individual Assignment.pdf', '2025-07-09 18:09:42', '2021457892', 'Individual', 65, '80'),
(21, 51, 'admin/uploads/4290_File_DSC650 Individual Assignment.pdf', '2025-07-09 18:14:38', '2021548565', 'Individual', 69, '87'),
(22, 51, 'admin/uploads/5890_File_DSC650 Individual Assignment.pdf', '2025-07-09 18:15:08', '2021548896', 'Individual', 67, '89'),
(23, 51, 'admin/uploads/2208_File_DSC650 Individual Assignment.pdf', '2025-07-09 18:15:50', '2021557896', 'Individual', 70, '86'),
(24, 47, 'admin/uploads/7532_File_GROUP 1 - DSC650 Case Study.pdf', '2025-07-09 18:16:07', 'Group 1', 'CASE STUDY', 70, '90'),
(25, 51, 'admin/uploads/7048_File_DSC650 Individual Assignment.pdf', '2025-07-09 18:18:09', '2021332298', 'Individual', 82, '84');

-- --------------------------------------------------------

--
-- Table structure for table `student_backpack`
--

CREATE TABLE `student_backpack` (
  `file_id` int(11) NOT NULL,
  `floc` varchar(100) NOT NULL,
  `fdatein` varchar(100) NOT NULL,
  `fdesc` varchar(100) NOT NULL,
  `student_id` int(11) NOT NULL,
  `fname` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `student_backpack`
--

INSERT INTO `student_backpack` (`file_id`, `floc`, `fdatein`, `fdesc`, `student_id`, `fname`) VALUES
(5, 'admin/uploads/9157_File_ICT602.pdf', '2025-06-19 02:32:08', 'Due : TBA', 64, 'CASE STUDY'),
(12, 'admin/uploads/5781_File_SOW DSC650.pdf', '2025-06-28 01:30:39', 'DSC650', 64, 'SOW'),
(13, 'admin/uploads/1451_File_Lecture 8 - Trend in Data Technology - ODL.pdf', '2025-06-28 01:30:44', 'Trend in Data Technology', 64, 'Lecture 8'),
(14, 'admin/uploads/5781_File_SOW DSC650.pdf', '2025-06-28 12:14:26', 'DSC650', 82, 'SOW'),
(15, 'admin/uploads/3751_File_Lecture 7 - Big Data Technologies ODL.pdf', '2025-06-28 12:22:13', 'Big Data Technologies ODL', 82, 'Lecture 7'),
(16, 'admin/uploads/5781_File_SOW DSC650.pdf', '2025-06-28 12:35:40', 'DSC650', 3, 'SOW'),
(17, 'admin/uploads/5781_File_SOW DSC650.pdf', '2025-06-30 04:07:41', 'DSC650', 47, 'SOW'),
(18, 'admin/uploads/1451_File_Lecture 8 - Trend in Data Technology - ODL.pdf', '2025-06-30 04:07:49', 'Trend in Data Technology', 47, 'Lecture 8'),
(19, 'admin/uploads/3751_File_Lecture 7 - Big Data Technologies ODL.pdf', '2025-06-30 04:09:04', 'Big Data Technologies ODL', 47, 'Lecture 7'),
(20, 'admin/uploads/4864_File_Lecture 8 - Trend in Data Technology - ODL.pdf', '2025-07-10 10:29:35', 'Trend in Data Technology', 65, 'Lecture 8'),
(21, 'admin/uploads/4864_File_Lecture 8 - Trend in Data Technology - ODL.pdf', '2025-07-11 11:07:02', 'Trend in Data Technology', 66, 'Lecture 8');

-- --------------------------------------------------------

--
-- Table structure for table `student_class_quiz`
--

CREATE TABLE `student_class_quiz` (
  `student_class_quiz_id` int(11) NOT NULL,
  `class_quiz_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `student_quiz_time` varchar(100) NOT NULL,
  `grade` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `student_class_quiz`
--

INSERT INTO `student_class_quiz` (`student_class_quiz_id`, `class_quiz_id`, `student_id`, `student_quiz_time`, `grade`) VALUES
(7, 19, 64, '3600', '0 out of 3'),
(8, 21, 64, '3600', '0 out of 0'),
(9, 25, 64, '3600', '0 out of 0'),
(10, 27, 64, '3600', '0 out of 1'),
(11, 29, 65, '3600', '0 out of 0'),
(12, 27, 65, '3600', '0 out of 1'),
(13, 19, 65, '3600', '0 out of 3'),
(14, 31, 65, '3600', '0 out of 1'),
(15, 33, 65, '3600', '2 out of 2'),
(16, 35, 64, '3600', '2 out of 5'),
(17, 36, 65, '3600', '5 out of 5'),
(18, 35, 65, '3600', '5 out of 5'),
(19, 35, 69, '3600', '2 out of 5'),
(20, 36, 69, '3600', '5 out of 5'),
(21, 35, 7, '3600', '5 out of 5'),
(22, 35, 68, '3600', '5 out of 5'),
(23, 36, 68, '3600', '5 out of 5'),
(24, 35, 220, '3600', '2 out of 5'),
(25, 36, 220, '3600', '5 out of 5'),
(26, 36, 70, '3600', '5 out of 5'),
(27, 36, 64, '3600', '2 out of 5'),
(28, 35, 67, '3600', '0 out of 5'),
(29, 35, 11, '3600', '2 out of 5'),
(30, 35, 42, '3600', '3 out of 5'),
(31, 36, 42, '3600', '5 out of 5'),
(32, 36, 7, '3600', '5 out of 5'),
(33, 36, 67, '3600', '5 out of 5'),
(34, 35, 70, '3600', '1 out of 5'),
(35, 36, 11, '3600', '5 out of 5'),
(36, 35, 82, '3600', '2 out of 5'),
(37, 35, 50, '3600', '5 out of 5'),
(38, 36, 50, '3600', '5 out of 5'),
(39, 35, 47, '3600', '3 out of 5'),
(40, 36, 47, '3600', '1 out of 5'),
(41, 35, 78, '3600', '2 out of 5'),
(42, 35, 3, '3600', '3 out of 5'),
(43, 36, 3, '1717', ''),
(44, 35, 66, '1792', ''),
(45, 37, 47, '3600', '0 out of 0'),
(46, 38, 47, '3600', '2 out of 5'),
(47, 49, 66, '3600', '5 out of 5'),
(48, 51, 66, '3600', '5 out of 5'),
(49, 53, 66, '3600', '5 out of 5'),
(50, 55, 66, '3600', '1 out of 1'),
(51, 57, 66, '3600', '5 out of 5'),
(52, 59, 66, '3600', '5 out of 5'),
(53, 61, 66, '3600', '5 out of 5'),
(54, 63, 66, '3600', '5 out of 5'),
(55, 49, 68, '3600', '5 out of 5'),
(56, 51, 68, '3600', '5 out of 5'),
(57, 53, 68, '3600', '5 out of 5'),
(58, 55, 68, '3600', '1 out of 1'),
(59, 57, 68, '3600', '5 out of 5'),
(60, 49, 67, '3600', '5 out of 5'),
(61, 51, 67, '3600', '5 out of 5'),
(62, 53, 67, '3600', '5 out of 5'),
(63, 55, 67, '3600', '1 out of 1'),
(64, 57, 67, '3600', '4 out of 5'),
(65, 59, 67, '3600', '5 out of 5'),
(66, 61, 67, '3600', '5 out of 5'),
(67, 63, 67, '3600', '5 out of 5'),
(68, 49, 64, '3600', '3 out of 5'),
(69, 51, 64, '3600', '4 out of 5'),
(70, 53, 64, '3600', '2 out of 5'),
(71, 55, 64, '3600', '1 out of 1'),
(72, 57, 64, '3600', '5 out of 5'),
(73, 59, 64, '3600', '3 out of 5'),
(74, 61, 64, '3600', '4 out of 5'),
(75, 63, 64, '3600', '4 out of 5'),
(76, 63, 65, '3600', '4 out of 5'),
(77, 61, 65, '3600', '4 out of 5'),
(78, 59, 65, '3600', '3 out of 5'),
(79, 57, 65, '3600', '2 out of 5'),
(80, 55, 65, '3600', '0 out of 1'),
(81, 53, 65, '3600', '3 out of 5'),
(82, 51, 65, '3600', '1 out of 5'),
(83, 49, 65, '3600', '4 out of 5'),
(84, 63, 69, '3600', '2 out of 5'),
(85, 53, 69, '3600', '1 out of 5'),
(86, 51, 69, '3600', '2 out of 5'),
(87, 49, 69, '3600', '1 out of 5'),
(88, 55, 69, '3600', '1 out of 1'),
(89, 57, 69, '3600', '3 out of 5'),
(90, 59, 69, '3600', '2 out of 5'),
(91, 61, 69, '3600', '2 out of 5'),
(92, 63, 70, '3600', '2 out of 5'),
(93, 49, 70, '3600', '2 out of 5'),
(94, 51, 70, '3600', '1 out of 5'),
(95, 53, 70, '3600', '2 out of 5'),
(96, 49, 82, '3600', '3 out of 5'),
(97, 49, 3, '1777', ''),
(98, 59, 68, '1797', '');

-- --------------------------------------------------------

--
-- Table structure for table `student_material_access`
--

CREATE TABLE `student_material_access` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  `access_type` varchar(20) NOT NULL DEFAULT 'download',
  `accessed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `student_material_access`
--

INSERT INTO `student_material_access` (`id`, `student_id`, `class_id`, `file_id`, `access_type`, `accessed_at`) VALUES
(1, 65, 190, 145, 'download', '2025-06-25 15:15:17'),
(2, 65, 190, 144, 'download', '2025-06-25 15:15:17'),
(3, 65, 190, 143, 'download', '2025-06-25 15:15:17'),
(40, 70, 194, 146, 'download', '2025-06-26 07:38:15'),
(41, 70, 194, 154, 'download', '2025-06-26 07:50:44'),
(42, 70, 194, 153, 'download', '2025-06-26 07:50:44'),
(43, 70, 194, 152, 'download', '2025-06-26 07:50:44'),
(44, 70, 194, 151, 'download', '2025-06-26 07:50:44'),
(45, 70, 194, 150, 'download', '2025-06-26 07:50:44'),
(46, 70, 194, 149, 'download', '2025-06-26 07:50:45'),
(47, 70, 194, 148, 'download', '2025-06-26 07:50:45'),
(48, 70, 194, 147, 'download', '2025-06-26 07:50:45'),
(54, 64, 194, 154, 'download', '2025-06-26 16:56:06'),
(55, 64, 194, 153, 'download', '2025-06-26 16:56:06'),
(56, 64, 194, 152, 'download', '2025-06-26 16:56:06'),
(57, 64, 194, 151, 'download', '2025-06-26 16:56:06'),
(106, 64, 194, 150, 'download', '2025-06-26 18:03:02'),
(107, 64, 194, 149, 'download', '2025-06-26 18:03:02'),
(108, 64, 194, 148, 'download', '2025-06-26 18:03:02'),
(109, 64, 194, 147, 'download', '2025-06-26 18:03:03'),
(110, 64, 194, 146, 'download', '2025-06-26 18:03:03'),
(227, 65, 194, 154, 'view', '2025-06-27 07:29:35'),
(228, 65, 194, 153, 'view', '2025-06-27 07:29:35'),
(229, 65, 194, 152, 'view', '2025-06-27 07:29:35'),
(230, 65, 194, 151, 'view', '2025-06-27 07:29:35'),
(243, 65, 194, 150, 'view', '2025-06-27 07:29:56'),
(244, 65, 194, 149, 'view', '2025-06-27 07:29:56'),
(245, 65, 194, 148, 'view', '2025-06-27 07:29:56'),
(246, 65, 194, 147, 'view', '2025-06-27 07:29:56'),
(255, 65, 194, 146, 'view', '2025-06-27 07:30:08'),
(260, 65, 194, 154, 'download', '2025-06-27 07:30:22'),
(261, 67, 194, 154, 'view', '2025-06-27 08:43:52'),
(262, 67, 194, 153, 'view', '2025-06-27 08:43:52'),
(263, 67, 194, 152, 'view', '2025-06-27 08:43:52'),
(264, 67, 194, 151, 'view', '2025-06-27 08:43:52'),
(298, 69, 194, 154, 'view', '2025-06-27 12:40:32'),
(299, 69, 194, 153, 'view', '2025-06-27 12:40:32'),
(300, 69, 194, 152, 'view', '2025-06-27 12:40:32'),
(301, 69, 194, 151, 'view', '2025-06-27 12:40:32'),
(302, 69, 194, 150, 'view', '2025-06-27 12:40:34'),
(303, 69, 194, 149, 'view', '2025-06-27 12:40:34'),
(304, 69, 194, 148, 'view', '2025-06-27 12:40:35'),
(305, 69, 194, 147, 'view', '2025-06-27 12:40:35'),
(306, 69, 194, 146, 'view', '2025-06-27 12:40:35'),
(307, 69, 194, 146, 'download', '2025-06-27 12:40:51'),
(308, 7, 194, 154, 'view', '2025-06-27 12:55:45'),
(309, 7, 194, 153, 'view', '2025-06-27 12:55:45'),
(310, 7, 194, 152, 'view', '2025-06-27 12:55:45'),
(311, 7, 194, 151, 'view', '2025-06-27 12:55:45'),
(312, 7, 194, 152, 'download', '2025-06-27 12:55:53'),
(313, 7, 194, 150, 'view', '2025-06-27 12:56:03'),
(314, 7, 194, 149, 'view', '2025-06-27 12:56:03'),
(315, 7, 194, 148, 'view', '2025-06-27 12:56:10'),
(316, 7, 194, 147, 'view', '2025-06-27 12:56:10'),
(317, 7, 194, 146, 'view', '2025-06-27 12:56:13'),
(318, 66, 194, 154, 'view', '2025-06-27 13:13:55'),
(319, 66, 194, 153, 'view', '2025-06-27 13:13:55'),
(320, 66, 194, 152, 'view', '2025-06-27 13:13:55'),
(321, 66, 194, 151, 'view', '2025-06-27 13:13:56'),
(322, 68, 194, 154, 'view', '2025-06-27 13:20:42'),
(323, 68, 194, 153, 'view', '2025-06-27 13:20:42'),
(324, 68, 194, 152, 'view', '2025-06-27 13:20:42'),
(325, 68, 194, 151, 'view', '2025-06-27 13:20:42'),
(326, 68, 194, 154, 'download', '2025-06-27 13:20:51'),
(327, 68, 194, 150, 'view', '2025-06-27 13:21:04'),
(328, 68, 194, 149, 'view', '2025-06-27 13:21:04'),
(329, 68, 194, 148, 'view', '2025-06-27 13:21:05'),
(330, 68, 194, 147, 'view', '2025-06-27 13:21:05'),
(331, 68, 194, 146, 'view', '2025-06-27 13:21:06'),
(342, 220, 194, 154, 'view', '2025-06-27 13:42:42'),
(343, 220, 194, 153, 'view', '2025-06-27 13:42:42'),
(344, 220, 194, 152, 'view', '2025-06-27 13:42:42'),
(345, 220, 194, 151, 'view', '2025-06-27 13:42:42'),
(346, 220, 194, 154, 'download', '2025-06-27 13:42:47'),
(347, 220, 194, 150, 'view', '2025-06-27 13:43:09'),
(348, 220, 194, 149, 'view', '2025-06-27 13:43:09'),
(349, 220, 194, 148, 'view', '2025-06-27 13:43:09'),
(350, 220, 194, 147, 'view', '2025-06-27 13:43:09'),
(351, 220, 194, 146, 'view', '2025-06-27 13:43:10'),
(352, 220, 194, 146, 'download', '2025-06-27 13:43:11'),
(362, 220, 194, 147, 'download', '2025-06-27 13:58:53'),
(363, 220, 194, 148, 'download', '2025-06-27 13:58:54'),
(364, 220, 194, 149, 'download', '2025-06-27 13:58:57'),
(365, 220, 194, 150, 'download', '2025-06-27 13:58:58'),
(366, 220, 194, 151, 'download', '2025-06-27 13:59:01'),
(367, 220, 194, 152, 'download', '2025-06-27 13:59:02'),
(368, 220, 194, 153, 'download', '2025-06-27 13:59:05'),
(381, 70, 194, 154, 'view', '2025-06-27 14:12:25'),
(382, 70, 194, 153, 'view', '2025-06-27 14:12:25'),
(383, 70, 194, 152, 'view', '2025-06-27 14:12:25'),
(384, 70, 194, 151, 'view', '2025-06-27 14:12:25'),
(385, 70, 194, 150, 'view', '2025-06-27 14:12:30'),
(386, 70, 194, 149, 'view', '2025-06-27 14:12:30'),
(387, 70, 194, 148, 'view', '2025-06-27 14:12:30'),
(388, 70, 194, 147, 'view', '2025-06-27 14:12:30'),
(389, 70, 194, 146, 'view', '2025-06-27 14:12:31'),
(399, 64, 194, 154, 'view', '2025-06-27 14:26:21'),
(400, 64, 194, 153, 'view', '2025-06-27 14:26:21'),
(401, 64, 194, 152, 'view', '2025-06-27 14:26:21'),
(402, 64, 194, 151, 'view', '2025-06-27 14:26:21'),
(403, 64, 194, 150, 'view', '2025-06-27 14:26:22'),
(404, 64, 194, 149, 'view', '2025-06-27 14:26:22'),
(405, 64, 194, 148, 'view', '2025-06-27 14:26:25'),
(406, 64, 194, 147, 'view', '2025-06-27 14:26:25'),
(420, 64, 194, 146, 'view', '2025-06-27 14:31:20'),
(435, 11, 194, 154, 'view', '2025-06-27 14:57:53'),
(436, 11, 194, 151, 'view', '2025-06-27 14:57:53'),
(437, 11, 194, 152, 'view', '2025-06-27 14:57:53'),
(438, 11, 194, 153, 'view', '2025-06-27 14:57:53'),
(443, 11, 194, 154, 'download', '2025-06-27 14:58:08'),
(444, 50, 194, 154, 'view', '2025-06-27 15:18:56'),
(445, 50, 194, 153, 'view', '2025-06-27 15:18:56'),
(446, 50, 194, 152, 'view', '2025-06-27 15:18:56'),
(447, 50, 194, 151, 'view', '2025-06-27 15:18:56'),
(448, 47, 194, 154, 'view', '2025-06-27 16:37:22'),
(449, 47, 194, 153, 'view', '2025-06-27 16:37:22'),
(450, 47, 194, 152, 'view', '2025-06-27 16:37:22'),
(451, 47, 194, 151, 'view', '2025-06-27 16:37:22'),
(492, 47, 194, 150, 'view', '2025-06-27 16:44:58'),
(493, 47, 194, 149, 'view', '2025-06-27 16:44:59'),
(494, 47, 194, 148, 'view', '2025-06-27 16:44:59'),
(495, 47, 194, 147, 'view', '2025-06-27 16:44:59'),
(496, 47, 194, 146, 'view', '2025-06-27 16:44:59'),
(603, 82, 194, 154, 'view', '2025-06-28 04:14:09'),
(604, 82, 194, 153, 'view', '2025-06-28 04:14:09'),
(605, 82, 194, 152, 'view', '2025-06-28 04:14:09'),
(606, 82, 194, 151, 'view', '2025-06-28 04:14:09'),
(607, 82, 194, 154, 'download', '2025-06-28 04:14:13'),
(612, 82, 194, 150, 'view', '2025-06-28 04:22:02'),
(613, 82, 194, 149, 'view', '2025-06-28 04:22:02'),
(614, 82, 194, 148, 'view', '2025-06-28 04:22:02'),
(615, 82, 194, 147, 'view', '2025-06-28 04:22:02'),
(616, 82, 194, 146, 'view', '2025-06-28 04:22:03'),
(626, 3, 194, 154, 'view', '2025-06-28 04:35:37'),
(627, 3, 194, 153, 'view', '2025-06-28 04:35:37'),
(628, 3, 194, 152, 'view', '2025-06-28 04:35:37'),
(629, 3, 194, 151, 'view', '2025-06-28 04:35:37'),
(630, 3, 194, 150, 'view', '2025-06-28 04:35:38'),
(631, 3, 194, 149, 'view', '2025-06-28 04:35:38'),
(632, 3, 194, 148, 'view', '2025-06-28 04:35:38'),
(633, 3, 194, 147, 'view', '2025-06-28 04:35:38'),
(634, 3, 194, 146, 'view', '2025-06-28 04:35:38'),
(657, 50, 194, 150, 'view', '2025-06-28 04:50:19'),
(658, 50, 194, 149, 'view', '2025-06-28 04:50:20'),
(659, 50, 194, 148, 'view', '2025-06-28 04:50:23'),
(660, 50, 194, 147, 'view', '2025-06-28 04:50:23'),
(661, 50, 194, 146, 'view', '2025-06-28 04:50:24'),
(703, 47, 194, 154, 'download', '2025-06-29 19:54:08'),
(923, 3, 194, 154, 'download', '2025-07-02 04:08:02'),
(928, 66, 194, 150, 'view', '2025-07-03 04:40:48'),
(929, 66, 194, 149, 'view', '2025-07-03 04:40:48'),
(939, 47, 194, 152, 'download', '2025-07-04 15:16:41'),
(964, 47, 194, 156, 'view', '2025-07-04 16:29:23'),
(970, 47, 194, 157, 'view', '2025-07-05 08:08:02'),
(976, 47, 194, 158, 'view', '2025-07-05 20:16:55'),
(982, 66, 202, 244, 'view', '2025-07-06 20:23:04'),
(983, 66, 202, 243, 'view', '2025-07-06 20:23:04'),
(984, 66, 202, 242, 'view', '2025-07-06 20:23:04'),
(985, 66, 202, 241, 'view', '2025-07-06 20:23:04'),
(990, 66, 202, 240, 'view', '2025-07-06 20:26:05'),
(991, 66, 202, 239, 'view', '2025-07-06 20:26:05'),
(992, 66, 202, 238, 'view', '2025-07-06 20:26:05'),
(993, 66, 202, 237, 'view', '2025-07-06 20:26:05'),
(994, 66, 202, 236, 'view', '2025-07-06 20:26:05'),
(995, 67, 202, 244, 'view', '2025-07-07 10:34:37'),
(996, 67, 202, 243, 'view', '2025-07-07 10:34:37'),
(997, 67, 202, 242, 'view', '2025-07-07 10:34:37'),
(998, 67, 202, 241, 'view', '2025-07-07 10:34:37'),
(999, 64, 202, 244, 'view', '2025-07-07 12:10:15'),
(1000, 64, 202, 243, 'view', '2025-07-07 12:10:15'),
(1001, 64, 202, 242, 'view', '2025-07-07 12:10:15'),
(1002, 64, 202, 241, 'view', '2025-07-07 12:10:15'),
(1003, 65, 202, 244, 'view', '2025-07-07 12:11:21'),
(1004, 65, 202, 243, 'view', '2025-07-07 12:11:21'),
(1005, 65, 202, 242, 'view', '2025-07-07 12:11:21'),
(1006, 65, 202, 241, 'view', '2025-07-07 12:11:21'),
(1015, 3, 202, 244, 'view', '2025-07-07 14:04:50'),
(1016, 3, 202, 243, 'view', '2025-07-07 14:04:50'),
(1017, 3, 202, 242, 'view', '2025-07-07 14:04:50'),
(1018, 3, 202, 241, 'view', '2025-07-07 14:04:50'),
(1019, 69, 202, 244, 'view', '2025-07-07 14:13:29'),
(1020, 69, 202, 243, 'view', '2025-07-07 14:13:29'),
(1021, 69, 202, 242, 'view', '2025-07-07 14:13:29'),
(1022, 69, 202, 241, 'view', '2025-07-07 14:13:29'),
(1023, 69, 202, 240, 'view', '2025-07-07 14:13:30'),
(1024, 69, 202, 239, 'view', '2025-07-07 14:13:30'),
(1025, 69, 202, 238, 'view', '2025-07-07 14:13:30'),
(1026, 69, 202, 237, 'view', '2025-07-07 14:13:30'),
(1027, 69, 202, 236, 'view', '2025-07-07 14:13:30'),
(1065, 66, 202, 244, 'download', '2025-07-09 09:52:00'),
(1066, 68, 202, 244, 'view', '2025-07-09 09:53:48'),
(1067, 68, 202, 243, 'view', '2025-07-09 09:53:48'),
(1068, 68, 202, 242, 'view', '2025-07-09 09:53:48'),
(1069, 68, 202, 241, 'view', '2025-07-09 09:53:48'),
(1070, 68, 202, 240, 'view', '2025-07-09 09:53:51'),
(1071, 68, 202, 239, 'view', '2025-07-09 09:53:51'),
(1072, 68, 202, 238, 'view', '2025-07-09 09:53:51'),
(1073, 68, 202, 237, 'view', '2025-07-09 09:53:51'),
(1074, 68, 202, 236, 'view', '2025-07-09 09:53:51'),
(1079, 68, 202, 244, 'download', '2025-07-09 09:54:04'),
(1080, 68, 202, 243, 'download', '2025-07-09 09:54:06'),
(1081, 68, 202, 242, 'download', '2025-07-09 09:54:07'),
(1082, 68, 202, 241, 'download', '2025-07-09 09:54:07'),
(1085, 68, 202, 239, 'download', '2025-07-09 09:54:09'),
(1086, 68, 202, 240, 'download', '2025-07-09 09:54:09'),
(1089, 68, 202, 238, 'download', '2025-07-09 09:54:11'),
(1090, 68, 202, 237, 'download', '2025-07-09 09:54:11'),
(1092, 68, 202, 236, 'download', '2025-07-09 09:54:13'),
(1101, 3, 202, 244, 'download', '2025-07-09 10:01:00'),
(1102, 3, 202, 243, 'download', '2025-07-09 10:01:01'),
(1103, 3, 202, 242, 'download', '2025-07-09 10:01:02'),
(1104, 3, 202, 241, 'download', '2025-07-09 10:01:02'),
(1105, 3, 202, 240, 'view', '2025-07-09 10:01:02'),
(1106, 3, 202, 239, 'view', '2025-07-09 10:01:02'),
(1107, 3, 202, 239, 'download', '2025-07-09 10:01:03'),
(1108, 3, 202, 240, 'download', '2025-07-09 10:01:04'),
(1109, 3, 202, 238, 'view', '2025-07-09 10:01:04'),
(1110, 3, 202, 237, 'view', '2025-07-09 10:01:04'),
(1111, 3, 202, 238, 'download', '2025-07-09 10:01:05'),
(1112, 3, 202, 237, 'download', '2025-07-09 10:01:05'),
(1113, 3, 202, 236, 'view', '2025-07-09 10:01:06'),
(1114, 3, 202, 236, 'download', '2025-07-09 10:01:06'),
(1119, 67, 202, 240, 'view', '2025-07-09 10:05:16'),
(1120, 67, 202, 239, 'view', '2025-07-09 10:05:16'),
(1121, 67, 202, 238, 'view', '2025-07-09 10:05:16'),
(1122, 67, 202, 237, 'view', '2025-07-09 10:05:16'),
(1123, 67, 202, 236, 'view', '2025-07-09 10:05:16'),
(1124, 67, 202, 236, 'download', '2025-07-09 10:05:17'),
(1125, 67, 202, 238, 'download', '2025-07-09 10:05:18'),
(1126, 67, 202, 237, 'download', '2025-07-09 10:05:19'),
(1127, 67, 202, 239, 'download', '2025-07-09 10:05:20'),
(1128, 67, 202, 240, 'download', '2025-07-09 10:05:21'),
(1129, 67, 202, 242, 'download', '2025-07-09 10:05:22'),
(1130, 67, 202, 241, 'download', '2025-07-09 10:05:22'),
(1131, 67, 202, 243, 'download', '2025-07-09 10:05:24'),
(1132, 67, 202, 244, 'download', '2025-07-09 10:05:24'),
(1137, 64, 202, 244, 'download', '2025-07-09 10:08:01'),
(1142, 65, 202, 240, 'view', '2025-07-09 10:08:39'),
(1143, 65, 202, 239, 'view', '2025-07-09 10:08:39'),
(1144, 65, 202, 238, 'view', '2025-07-09 10:08:39'),
(1145, 65, 202, 237, 'view', '2025-07-09 10:08:39'),
(1146, 65, 202, 236, 'view', '2025-07-09 10:08:39'),
(1147, 65, 202, 236, 'download', '2025-07-09 10:08:41'),
(1148, 65, 202, 238, 'download', '2025-07-09 10:08:41'),
(1149, 65, 202, 237, 'download', '2025-07-09 10:08:42'),
(1150, 65, 202, 239, 'download', '2025-07-09 10:08:43'),
(1151, 65, 202, 240, 'download', '2025-07-09 10:08:44'),
(1152, 65, 202, 242, 'download', '2025-07-09 10:08:45'),
(1153, 65, 202, 241, 'download', '2025-07-09 10:08:45'),
(1154, 65, 202, 243, 'download', '2025-07-09 10:08:46'),
(1155, 65, 202, 244, 'download', '2025-07-09 10:08:47'),
(1160, 69, 202, 244, 'download', '2025-07-09 10:14:05'),
(1161, 69, 202, 243, 'download', '2025-07-09 10:14:06'),
(1162, 69, 202, 242, 'download', '2025-07-09 10:14:07'),
(1163, 69, 202, 241, 'download', '2025-07-09 10:14:07'),
(1164, 70, 202, 244, 'view', '2025-07-09 10:16:15'),
(1165, 70, 202, 243, 'view', '2025-07-09 10:16:15'),
(1166, 70, 202, 242, 'view', '2025-07-09 10:16:15'),
(1167, 70, 202, 241, 'view', '2025-07-09 10:16:15'),
(1168, 82, 202, 244, 'view', '2025-07-09 10:17:57'),
(1169, 82, 202, 243, 'view', '2025-07-09 10:17:57'),
(1170, 82, 202, 242, 'view', '2025-07-09 10:17:57'),
(1171, 82, 202, 241, 'view', '2025-07-09 10:17:57');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `subject_id` int(11) NOT NULL,
  `subject_code` varchar(100) NOT NULL,
  `subject_title` varchar(100) NOT NULL,
  `description` longtext NOT NULL,
  `unit` int(11) NOT NULL,
  `semester` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`subject_id`, `subject_code`, `subject_title`, `description`, `unit`, `semester`) VALUES
(1, 'CSP650', 'PROJECT', '<p><span style=\"font-size:medium\"><em>Course Description</em></span></p>\r\n\r\n<p>This course will enable the students to experience the planning, analysis, design and development phases in handling information technology project. The student develops solutions based on the formulated problem. Students should be able to compile, analyse and present the project carried out in the form of a thesis. Students also should be able to communicate the project outcome effectively through oral and poster presentation.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Transferable Skills:</p>\r\n\r\n<p>Independent and Critical Thinker and life long learning</p>\r\n\r\n<p>&nbsp;</p>\r\n', 6, '6'),
(2, 'DSC650', 'DATA TECHNOLOGY AND FUTURE EMERGENCE', '<p><span style=\"font-size: medium;\"><em>Course Description</em></span></p>\r\n<p>The course will give the students to explore key data analysis and management techniques, which applied to massive data sets are the cornerstone that enables real-time decision making in distributed environments, business intelligence in the Web, and scientific discovery at large scale. In particular, the students will examine the map-reduce parallel computing paradigm and associated technologies such as Hadoop distributed file systems, and no sql databases.</p>\r\n<p>&nbsp;</p>\r\n<p>Transferable Skills:</p>\r\n<p>Strong interpersonal, oral and written communication and presentation skills, ability to communicate complex findings.</p>\r\n<p>&nbsp;</p>', 3, '6'),
(3, 'EET699', 'ENGLISH EXIT TEST', '<p><span style=\"font-size: medium;\"><em>Course Description</em></span></p>\r\n<p>no description provided</p> \r\n<p>&nbsp;</p>\r\n<p>Transferable Skills:</p>\r\n<p>N/A</p>\r\n<p>&nbsp;</p>', 0, '6'),
(4, 'ENT600', 'TECHNOLOGY ENTREPRENEURSHIP', '<p><span style=\"font-size: medium;\"><em>Course Description</em></span></p>\r\n<p>Behind every successful technology company is a visionary, effective and efficient technopreneur. In this course, students will be exposed to entrepreneurship and apply their entrepreneurial skills in developing an advanced technology that could be a basis for the creation and development of a technology-based venture. This subject is designed to inculcate the entrepreneurial skills among science and technology cluster students and promote the development of technology-based entrepreneurship knowledge. The course delivery combines both theoretical and practical aspects of technology entrepreneurship. Theoretical aspect is looking at the important elements in understanding technology entrepreneurship, while practical aspect is engaging the students to develop their technology based idea business blueprint. The course has two key components of face-to-face lectures and practical project-based assignments monitored with the course lecturer.</p> \r\n<p>&nbsp;</p>\r\n<p>Transferable Skills:</p>\r\n<p>Entrepreneurship and apply their entrepreneurial skills in developing an advanced technology that could be a basis for the creation and development of a technology-based venture</p>\r\n<p>&nbsp;</p>', 3, '6'),
(5, 'ICT652', 'ETHICAL, SOCIAL, AND PROFESSIONAL ISSUES IN ICT', '<p><span style=\"font-size: medium;\"><em>Course Description</em></span></p>\r\n<p>This course will cover the social issues related to society, issues on history, development and economics of ICT will be covered. The issues that will be discussed include the effects of the ICT application on the Malaysian society, the changing nature of work, the ethical issues and computer crime. The issues covered are relevant to being a responsible computer user, professional or personal. The course also expresses the Islamic perspective to the students as effort to elevate the value among the students.</p> \r\n<p>&nbsp;</p>\r\n<p>Transferable Skills:</p>\r\n<p>Students about to be exposed to the actual corporate environment will be equipped with the ethical knowledge, \'right\' decision making and some ethical philosophies.</p>\r\n<p>&nbsp;</p>', 3, '6'),
(6, 'ICT653', 'TECHNOLOGIES FOR FUTURISTIC SYSTEMS', '', 3, '6'),
(7, 'ISP565', 'DATA MINING', '', 3, '6'),
(8, 'DSC651', 'DATA REPRESENTATION AND REPORTING TECHNIQUES', '', 3, '6'),
(9, 'STA404', 'STATISTICS FOR BUSINESS AND SOCIAL SCIENCES', '', 3, '5'),
(10, 'ICT606', 'ICT IN INDUSTRIES', '', 3, '5'),
(11, 'ICT603', 'INFORMATION ARCHITECTURE', '', 3, '5'),
(12, 'ICT651', 'SYSTEMS INTEGRATION AND ARCHITECTURE', '', 3, '5'),
(13, 'CSP600', 'PROJECT FORMULATION', '', 3, '5'),
(14, 'ICT600', 'WEB TECHNOLOGY AND APPLICATION ', '', 3, '5'),
(15, 'ICT602', 'MOBILE TECHNOLOGY AND DEVELOPMENT', '<p style=\"text-align: justify;\">Mobile Technology and Development is a comprehensive course designed to explore the evolving landscape of mobile technology and its role in modern software development. This course covers the fundamental concepts of mobile systems, the architecture of mobile devices, and the tools and platforms used for mobile application development. Students will gain hands-on experience with both Android and iOS development frameworks, learning how to create and deploy mobile applications that leverage the unique features of mobile devices such as GPS, camera, sensors, and touch interfaces.</p>\r\n\r\n<p style=\"text-align: justify;\">The course also examines the mobile development lifecycle, from conceptualization and design to deployment and maintenance. Topics include mobile programming languages, mobile user interface (UI) design principles, app performance optimization, mobile security, and cross-platform development techniques. Furthermore, students will explore the integration of mobile applications with backend services, databases, and cloud infrastructure to create scalable and dynamic mobile solutions.</p>\r\n\r\n<p style=\"text-align: justify;\">By the end of the course, students will be equipped with the skills necessary to design, develop, and deploy mobile applications that meet industry standards and address real-world challenges in the mobile technology space.</p>\r\n', 3, '5'),
(16, 'TAC501', 'ARABIC LEVEL III', '', 3, '5'),
(17, 'TMC501', 'MANDARIN LEVEL III', '', 3, '5'),
(18, 'ICT552', 'E-COMMERCE TECHNOLOGY', '', 3, '4'),
(19, 'ICT550', 'PRINCIPLES OF DATA MANAGEMENT', '', 3, '4'),
(20, 'ISP640', 'COMPUTING PROJECT MANAGEMENT', '', 3, '4'),
(21, 'ISP550', 'INFORMATION SYSTEMS ENGINEERING ', '', 3, '4'),
(22, 'CSC584', 'ENTERPRISE PROGRAMMING', '', 3, '4'),
(23, 'ELC550', 'ENGLISH FOR ACADEMIC WRITING', '', 3, '4'),
(24, 'TAC451', 'ARABIC LEVEL II', '', 3, '4'),
(25, 'TMC451', 'MANDARIN LEVEL II', '', 3, '4');

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `teacher_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `department_id` int(11) NOT NULL,
  `location` varchar(200) NOT NULL,
  `teacher_status` varchar(20) NOT NULL,
  `teacher_stat` varchar(100) NOT NULL,
  `about` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`teacher_id`, `username`, `password`, `firstname`, `lastname`, `department_id`, `location`, `teacher_status`, `teacher_stat`, `about`) VALUES
(2, '307887', 'Aisyah@123', 'Siti Aisyah Binti', 'Ibrahim', 1, 'uploads/B.png', 'Registered', 'Activated', NULL),
(1, '301412', 'Zulkifli@123', 'Dr. Ahmad Zulkifli Bin', 'Ismail', 1, 'uploads/A.png', 'Registered', 'Activated', NULL),
(3, '309889', 'Hasan@123', 'Faizal Hasan Bin', 'Ahmad', 1, 'uploads/D.png', 'Registered', 'Activated', NULL),
(5, '307441', 'Zainal@123', 'Zainal Ariffin Bin', 'Omar', 2, 'uploads/E.png', 'Registered', 'Activated', NULL),
(4, '301545', 'Huda@123', 'Nurul Huda Binti', 'Abdullah', 2, 'uploads/F.png', 'Registered', 'Activated', NULL),
(6, '306556', 'Amina@123', 'Ts. Amina Azizah Binti', 'Abdul Rahman', 2, 'uploads/G.png', 'Registered', 'Activated', NULL),
(7, '301595', 'Anwar@123', 'Dr. Khairul Syafiq Bin', 'Zainal', 3, 'uploads/K.png', 'Registered', 'Activated', 'Senior Lecturer\nInformation Technology\n+6049562151\nkhairulzainal@uitm.edu.my'),
(8, '306543', 'Mariam@123', 'Mariam Maisara Binti', 'Muhammad', 3, 'uploads/H.png', 'Registered', 'Activated', NULL),
(9, '304774', 'Iskandar123@', 'Ts. Dr. Iskandar Bin', 'Rahman Ali', 4, 'uploads/C.png', 'Registered', 'Activated', 'Senior Lecturer\nInformation Technology\n+6046212851\niskandarrahman@uitm.edu.my'),
(10, '309874', 'Farah@123', 'Ts. Farah Nabila Binti', 'Hassan', 4, 'uploads/I.png', 'Registered', 'Activated', 'Senior Lecturer\nComputer Science\n+6048752353\nfarahhassan@uitm.edu.my'),
(22, '309965', 'Dahlia@123', 'Dr. Dahlia Karisma Binti', 'Zainal', 3, 'uploads/J.png', '', 'Activated', NULL),
(27, '304776', 'Alif@123', 'Dr Alif Aiman Bin', 'Kamal', 1, 'uploads/NO-IMAGE-AVAILABLE.jpg', '', 'Activated', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `teacher_backpack`
--

CREATE TABLE `teacher_backpack` (
  `file_id` int(11) NOT NULL,
  `floc` varchar(100) NOT NULL,
  `fdatein` varchar(100) NOT NULL,
  `fdesc` varchar(100) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `fname` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `teacher_backpack`
--

INSERT INTO `teacher_backpack` (`file_id`, `floc`, `fdatein`, `fdesc`, `teacher_id`, `fname`) VALUES
(36, 'admin/uploads/5781_File_SOW DSC650.pdf', '2025-07-06 04:48:31', 'DSC650', 9, 'SOW'),
(37, 'admin/uploads/1451_File_Lecture 8 - Trend in Data Technology - ODL.pdf', '2025-07-06 04:48:31', 'Trend in Data Technology', 9, 'Lecture 8'),
(38, 'admin/uploads/3751_File_Lecture 7 - Big Data Technologies ODL.pdf', '2025-07-06 04:48:31', 'Big Data Technologies ODL', 9, 'Lecture 7'),
(39, 'admin/uploads/2686_File_Lecture 6 - Searching and Indexing Big Data.pdf', '2025-07-06 04:48:31', 'Searching and Indexing Big Data', 9, 'Lecture 6'),
(40, 'admin/uploads/1426_File_Lecture 5 - NoSQL.pdf', '2025-07-06 04:48:31', 'NoSQL', 9, 'Lecture 5'),
(41, 'admin/uploads/4931_File_Lecture 4 - Data Processing.pdf', '2025-07-06 04:48:31', 'Data Processing', 9, 'Lecture 4'),
(42, 'admin/uploads/9864_File_Lecture 3 - Data Storage Technology - 5.pdf', '2025-07-06 04:48:31', 'Data Storage Technology', 9, 'Lecture 3'),
(43, 'admin/uploads/8971_File_Lecture 2 - Business Motivations and Drivers for Big Data Adoption.pdf', '2025-07-06 04:48:31', 'Business Motivations and Drivers for Big Data Adoption', 9, 'Lecture 2'),
(44, 'admin/uploads/5667_File_Lecture 1 - Overview of Data Technology.pdf', '2025-07-06 04:48:31', 'Overview of Data Technology', 9, 'Lecture 1'),
(49, 'admin/uploads/1451_File_Lecture 8 - Trend in Data Technology - ODL.pdf', '2025-07-06 05:00:54', 'Trend in Data Technology', 22, 'Lecture 8'),
(50, 'admin/uploads/3751_File_Lecture 7 - Big Data Technologies ODL.pdf', '2025-07-06 05:00:54', 'Big Data Technologies ODL', 22, 'Lecture 7'),
(51, 'admin/uploads/2686_File_Lecture 6 - Searching and Indexing Big Data.pdf', '2025-07-06 05:00:54', 'Searching and Indexing Big Data', 22, 'Lecture 6'),
(52, 'admin/uploads/1426_File_Lecture 5 - NoSQL.pdf', '2025-07-06 05:00:54', 'NoSQL', 22, 'Lecture 5'),
(53, 'admin/uploads/4931_File_Lecture 4 - Data Processing.pdf', '2025-07-06 05:00:54', 'Data Processing', 22, 'Lecture 4'),
(54, 'admin/uploads/9864_File_Lecture 3 - Data Storage Technology - 5.pdf', '2025-07-06 05:00:54', 'Data Storage Technology', 22, 'Lecture 3'),
(57, 'admin/uploads/5667_File_Lecture 1 - Overview of Data Technology.pdf', '2025-07-06 05:00:54', 'Overview of Data Technology', 22, 'Lecture 1'),
(59, 'admin/uploads/5781_File_SOW DSC650.pdf', '2025-07-06 05:00:54', 'DSC650', 22, 'SOW'),
(66, 'admin/uploads/8971_File_Lecture 2 - Business Motivations and Drivers for Big Data Adoption.pdf', '2025-07-06 05:00:54', 'Business Motivations and Drivers for Big Data Adoption', 22, 'Lecture 2');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_class`
--

CREATE TABLE `teacher_class` (
  `teacher_class_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `thumbnails` varchar(100) NOT NULL,
  `school_year` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `teacher_class`
--

INSERT INTO `teacher_class` (`teacher_class_id`, `teacher_id`, `class_id`, `subject_id`, `thumbnails`, `school_year`) VALUES
(194, 9, 10, 2, 'admin/uploads/thumbnails.jpg', 'MARCH - AUGUST 2025'),
(199, 22, 10, 3, 'admin/uploads/thumbnails.jpg', 'MARCH - AUGUST 2025'),
(200, 9, 11, 2, 'admin/uploads/thumbnails.jpg', 'MARCH - AUGUST 2025'),
(202, 9, 10, 2, 'admin/uploads/thumbnails.jpg', 'MARCH 2025 - AUGUST 2025'),
(203, 9, 11, 2, 'admin/uploads/thumbnails.jpg', 'MARCH 2025 - AUGUST 2025'),
(204, 2, 1, 24, 'admin/uploads/thumbnails.jpg', 'MARCH 2025 - AUGUST 2025'),
(205, 22, 10, 5, 'admin/uploads/thumbnails.jpg', 'MARCH 2025 - AUGUST 2025');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_class_announcements`
--

CREATE TABLE `teacher_class_announcements` (
  `teacher_class_announcements_id` int(11) NOT NULL,
  `content` varchar(500) NOT NULL,
  `teacher_id` varchar(100) NOT NULL,
  `teacher_class_id` int(11) NOT NULL,
  `date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `teacher_class_announcements`
--

INSERT INTO `teacher_class_announcements` (`teacher_class_announcements_id`, `content`, `teacher_id`, `teacher_class_id`, `date`) VALUES
(42, '<p>I have uploaded the group project requirements. The due is 11/7/2025</p>\r\n', '9', 194, '2025-06-26 15:55:17'),
(56, '<p>I have added the requirement, Thank&nbsp;you</p>\r\n', '9', 202, '2025-07-10 10:31:30');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_class_student`
--

CREATE TABLE `teacher_class_student` (
  `teacher_class_student_id` int(11) NOT NULL,
  `teacher_class_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `teacher_class_student`
--

INSERT INTO `teacher_class_student` (`teacher_class_student_id`, `teacher_class_id`, `student_id`, `teacher_id`) VALUES
(455, 194, 64, 9),
(456, 194, 65, 9),
(457, 194, 66, 9),
(458, 194, 67, 9),
(459, 194, 68, 9),
(460, 194, 69, 9),
(461, 194, 70, 9),
(462, 194, 220, 9),
(463, 194, 47, 9),
(464, 194, 7, 9),
(466, 194, 78, 9),
(467, 194, 82, 9),
(468, 194, 50, 9),
(469, 194, 11, 9),
(470, 194, 3, 9),
(500, 199, 3, 22),
(501, 199, 64, 22),
(502, 199, 65, 22),
(503, 199, 66, 22),
(504, 199, 67, 22),
(505, 199, 68, 22),
(506, 199, 69, 22),
(507, 199, 70, 22),
(508, 199, 82, 22),
(509, 200, 71, 9),
(510, 200, 72, 9),
(511, 200, 73, 9),
(512, 200, 74, 9),
(513, 200, 75, 9),
(514, 200, 76, 9),
(515, 200, 77, 9),
(516, 200, 78, 9),
(517, 200, 220, 9),
(518, 194, 42, 9),
(519, 194, 1, 9),
(520, 194, 2, 9),
(521, 194, 4, 9),
(522, 194, 5, 9),
(523, 194, 6, 9),
(533, 202, 3, 9),
(534, 202, 64, 9),
(535, 202, 65, 9),
(536, 202, 66, 9),
(537, 202, 67, 9),
(538, 202, 68, 9),
(539, 202, 69, 9),
(540, 202, 70, 9),
(541, 202, 82, 9),
(542, 203, 71, 9),
(543, 203, 72, 9),
(544, 203, 73, 9),
(545, 203, 74, 9),
(546, 203, 75, 9),
(547, 203, 76, 9),
(548, 203, 77, 9),
(549, 203, 78, 9),
(550, 203, 220, 9),
(551, 204, 1, 2),
(552, 204, 2, 2),
(553, 204, 4, 2),
(554, 204, 5, 2),
(555, 204, 6, 2),
(556, 204, 7, 2),
(557, 205, 3, 22),
(558, 205, 64, 22),
(559, 205, 65, 22),
(560, 205, 66, 22),
(561, 205, 67, 22),
(562, 205, 68, 22),
(563, 205, 69, 22),
(564, 205, 70, 22),
(565, 205, 82, 22);

-- --------------------------------------------------------

--
-- Table structure for table `teacher_notification`
--

CREATE TABLE `teacher_notification` (
  `teacher_notification_id` int(11) NOT NULL,
  `teacher_class_id` int(11) NOT NULL,
  `notification` varchar(100) NOT NULL,
  `date_of_notification` varchar(100) NOT NULL,
  `link` varchar(100) NOT NULL,
  `student_id` int(11) NOT NULL,
  `assignment_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `teacher_notification`
--

INSERT INTO `teacher_notification` (`teacher_notification_id`, `teacher_class_id`, `notification`, `date_of_notification`, `link`, `student_id`, `assignment_id`) VALUES
(20, 190, 'Submit Assignment file name <b>Case study</b>', '2025-06-19 02:42:26', 'view_submit_assignment.php', 64, 33),
(21, 190, 'Submit Assignment file name <b>ain</b>', '2025-06-25 22:25:34', 'view_submit_assignment.php', 65, 37),
(22, 194, 'Submit Assignment file name <b>GROUP 1</b>', '2025-06-27 02:40:29', 'view_submit_assignment.php', 64, 39),
(23, 194, 'Submit Assignment file name <b>Testt</b>', '2025-06-27 20:42:07', 'view_submit_assignment.php', 69, 39),
(24, 194, 'Submit Assignment file name <b>qiqi comel</b>', '2025-06-27 20:57:17', 'view_submit_assignment.php', 7, 39),
(25, 194, 'Submit Assignment file name <b>CASE STUDY</b>', '2025-06-27 21:22:10', 'view_submit_assignment.php', 68, 39),
(26, 194, 'Submit Assignment file name <b>Nebuva</b>', '2025-06-27 21:46:00', 'view_submit_assignment.php', 220, 39),
(27, 202, 'Submit Assignment file name <b>CASE STUDY</b>', '2025-07-09 17:45:16', 'view_submit_assignment.php', 66, 47),
(28, 202, 'Submit Assignment file name <b>Group Project</b>', '2025-07-09 17:46:05', 'view_submit_assignment.php', 66, 49),
(29, 202, 'Submit Assignment file name <b>Group Project</b>', '2025-07-09 17:47:19', 'view_submit_assignment.php', 66, 51),
(30, 202, 'Submit Assignment file name <b>CASE STUDY</b>', '2025-07-09 17:55:26', 'view_submit_assignment.php', 68, 47),
(31, 202, 'Submit Assignment file name <b>Individual</b>', '2025-07-09 17:55:51', 'view_submit_assignment.php', 68, 51),
(32, 202, 'Submit Assignment file name <b>CASE STUDY</b>', '2025-07-09 18:01:24', 'view_submit_assignment.php', 3, 47),
(33, 202, 'Submit Assignment file name <b>Group Project</b>', '2025-07-09 18:01:37', 'view_submit_assignment.php', 3, 49),
(34, 202, 'Submit Assignment file name <b>Individual</b>', '2025-07-09 18:01:55', 'view_submit_assignment.php', 3, 51),
(35, 202, 'Submit Assignment file name <b>CASE STUDY</b>', '2025-07-09 18:09:14', 'view_submit_assignment.php', 65, 47),
(36, 202, 'Submit Assignment file name <b>Group Project</b>', '2025-07-09 18:09:28', 'view_submit_assignment.php', 65, 49),
(37, 202, 'Submit Assignment file name <b>Individual</b>', '2025-07-09 18:09:42', 'view_submit_assignment.php', 65, 51),
(38, 202, 'Submit Assignment file name <b>Individual</b>', '2025-07-09 18:14:38', 'view_submit_assignment.php', 69, 51),
(39, 202, 'Submit Assignment file name <b>Individual</b>', '2025-07-09 18:15:08', 'view_submit_assignment.php', 67, 51),
(40, 202, 'Submit Assignment file name <b>Individual</b>', '2025-07-09 18:15:50', 'view_submit_assignment.php', 70, 51),
(41, 202, 'Submit Assignment file name <b>CASE STUDY</b>', '2025-07-09 18:16:07', 'view_submit_assignment.php', 70, 47),
(42, 202, 'Submit Assignment file name <b>Individual</b>', '2025-07-09 18:18:09', 'view_submit_assignment.php', 82, 51);

-- --------------------------------------------------------

--
-- Table structure for table `teacher_shared`
--

CREATE TABLE `teacher_shared` (
  `teacher_shared_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `shared_teacher_id` int(11) NOT NULL,
  `floc` varchar(100) NOT NULL,
  `fdatein` varchar(100) NOT NULL,
  `fdesc` varchar(100) NOT NULL,
  `fname` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `teacher_shared`
--

INSERT INTO `teacher_shared` (`teacher_shared_id`, `teacher_id`, `shared_teacher_id`, `floc`, `fdatein`, `fdesc`, `fname`) VALUES
(48, 9, 22, 'admin/uploads/4864_File_Lecture 8 - Trend in Data Technology - ODL.pdf', '2025-07-10 10:55:51', 'Trend in Data Technology', 'Lecture 8'),
(49, 22, 9, 'admin/uploads/7118_File_DSC650 Case Study.pdf', '2025-07-10 10:57:20', 'Case Study', 'DSC650');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `firstname`, `lastname`) VALUES
(1, 'razak', 'Razak@123', 'Razak Bin', 'Osman'),
(2, 'aisyah', 'Aisyah@123', 'Siti Nur Aisyah Binti', 'Zulkifli'),
(3, 'aini', 'Aini@123', 'Noraini Binti', 'Mohamed'),
(16, 'ainayasmin', 'Aina@123', 'Aina Yasmin Binti', 'Zulkifli');

-- --------------------------------------------------------

--
-- Table structure for table `user_log`
--

CREATE TABLE `user_log` (
  `user_log_id` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `login_date` varchar(30) NOT NULL,
  `logout_date` varchar(30) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user_log`
--

INSERT INTO `user_log` (`user_log_id`, `username`, `login_date`, `logout_date`, `user_id`) VALUES
(1, 'aini', '2025-05-07 02:57:31', '2025-09-09 15:12:02', 3),
(2, 'razak', '2025-05-07 03:05:08', '2025-05-07 04:08:02', 1),
(3, 'razak', '2025-05-07 11:08:55', '2025-05-08 03:06:43', 1),
(4, 'razak', '2025-05-07 23:06:09', '2025-05-08 03:06:43', 1),
(95, 'aini', '2025-05-08 02:36:33', '2025-09-09 15:12:02', 3),
(96, 'razak', '2025-05-08 02:38:43', '2025-05-08 03:06:43', 1),
(97, 'aini', '2025-05-17 23:58:27', '2025-09-09 15:12:02', 3),
(98, 'aini', '2025-05-18 17:16:15', '2025-09-09 15:12:02', 3),
(99, 'aini', '2025-05-18 18:05:29', '2025-09-09 15:12:02', 3),
(102, 'aini', '2025-05-21 11:18:11', '2025-09-09 15:12:02', 3),
(103, 'aini', '2025-05-28 10:04:35', '2025-09-09 15:12:02', 3),
(104, 'aini', '2025-06-12 02:24:12', '2025-09-09 15:12:02', 3),
(105, 'aini', '2025-06-12 04:13:17', '2025-09-09 15:12:02', 3),
(106, 'aini', '2025-06-18 01:28:06', '2025-09-09 15:12:02', 3),
(107, 'aini', '2025-06-19 10:05:01', '2025-09-09 15:12:02', 3),
(108, 'aini', '2025-06-26 15:13:23', '2025-09-09 15:12:02', 3),
(109, 'aini', '2025-06-26 15:16:20', '2025-09-09 15:12:02', 3),
(110, 'aini', '2025-06-30 23:15:58', '2025-09-09 15:12:02', 3),
(111, 'aini', '2025-06-30 23:19:11', '2025-09-09 15:12:02', 3),
(112, 'aini', '2025-06-30 23:31:42', '2025-09-09 15:12:02', 3),
(113, 'aini', '2025-06-30 23:33:56', '2025-09-09 15:12:02', 3),
(114, 'aini', '2025-07-01 00:50:37', '2025-09-09 15:12:02', 3),
(115, 'aini', '2025-07-01 00:54:07', '2025-09-09 15:12:02', 3),
(116, 'aini', '2025-07-01 01:13:57', '2025-09-09 15:12:02', 3),
(117, 'aini', '2025-07-01 03:31:24', '2025-09-09 15:12:02', 3),
(118, 'aini', '2025-07-01 19:35:37', '2025-09-09 15:12:02', 3),
(119, 'aini', '2025-07-02 00:45:45', '2025-09-09 15:12:02', 3),
(120, 'aini', '2025-07-02 02:46:27', '2025-09-09 15:12:02', 3),
(121, 'aini', '2025-07-02 11:36:22', '2025-09-09 15:12:02', 3),
(122, 'aini', '2025-07-04 22:14:32', '2025-09-09 15:12:02', 3),
(123, 'aini', '2025-07-06 06:18:18', '2025-09-09 15:12:02', 3),
(124, 'aini', '2025-07-06 15:44:42', '2025-09-09 15:12:02', 3),
(125, 'aini', '2025-07-06 15:47:33', '2025-09-09 15:12:02', 3),
(126, 'aini', '2025-07-07 19:14:16', '2025-09-09 15:12:02', 3),
(127, 'aini', '2025-07-07 19:16:26', '2025-09-09 15:12:02', 3),
(128, 'aini', '2025-07-07 20:18:10', '2025-09-09 15:12:02', 3),
(129, 'aini', '2025-07-09 19:34:48', '2025-09-09 15:12:02', 3),
(130, 'aini', '2025-07-10 11:31:01', '2025-09-09 15:12:02', 3),
(131, 'aini', '2025-07-17 07:54:18', '2025-09-09 15:12:02', 3),
(132, 'aini', '2025-07-17 10:37:15', '2025-09-09 15:12:02', 3),
(133, 'aini', '2025-07-30 22:23:40', '2025-09-09 15:12:02', 3),
(134, 'aini', '2025-09-09 12:25:55', '2025-09-09 15:12:02', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`activity_log_id`);

--
-- Indexes for table `answer`
--
ALTER TABLE `answer`
  ADD PRIMARY KEY (`answer_id`);

--
-- Indexes for table `assignment`
--
ALTER TABLE `assignment`
  ADD PRIMARY KEY (`assignment_id`);

--
-- Indexes for table `chat_message`
--
ALTER TABLE `chat_message`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `teacher_class_id` (`teacher_class_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `class_quiz`
--
ALTER TABLE `class_quiz`
  ADD PRIMARY KEY (`class_quiz_id`);

--
-- Indexes for table `class_subject_overview`
--
ALTER TABLE `class_subject_overview`
  ADD PRIMARY KEY (`class_subject_overview_id`);

--
-- Indexes for table `content`
--
ALTER TABLE `content`
  ADD PRIMARY KEY (`content_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `discussion_post`
--
ALTER TABLE `discussion_post`
  ADD PRIMARY KEY (`discussion_post_id`);

--
-- Indexes for table `discussion_reply`
--
ALTER TABLE `discussion_reply`
  ADD PRIMARY KEY (`discussion_reply_id`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`file_id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `message_sent`
--
ALTER TABLE `message_sent`
  ADD PRIMARY KEY (`message_sent_id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`notification_id`);

--
-- Indexes for table `notification_read`
--
ALTER TABLE `notification_read`
  ADD PRIMARY KEY (`notification_read_id`);

--
-- Indexes for table `notification_read_teacher`
--
ALTER TABLE `notification_read_teacher`
  ADD PRIMARY KEY (`notification_read_teacher_id`);

--
-- Indexes for table `question_type`
--
ALTER TABLE `question_type`
  ADD PRIMARY KEY (`question_type_id`);

--
-- Indexes for table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`quiz_id`);

--
-- Indexes for table `quiz_question`
--
ALTER TABLE `quiz_question`
  ADD PRIMARY KEY (`quiz_question_id`);

--
-- Indexes for table `school_year`
--
ALTER TABLE `school_year`
  ADD PRIMARY KEY (`school_year_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `student_assignment`
--
ALTER TABLE `student_assignment`
  ADD PRIMARY KEY (`student_assignment_id`);

--
-- Indexes for table `student_backpack`
--
ALTER TABLE `student_backpack`
  ADD PRIMARY KEY (`file_id`);

--
-- Indexes for table `student_class_quiz`
--
ALTER TABLE `student_class_quiz`
  ADD PRIMARY KEY (`student_class_quiz_id`);

--
-- Indexes for table `student_material_access`
--
ALTER TABLE `student_material_access`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_access` (`student_id`,`class_id`,`file_id`,`access_type`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`subject_id`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`teacher_id`);

--
-- Indexes for table `teacher_backpack`
--
ALTER TABLE `teacher_backpack`
  ADD PRIMARY KEY (`file_id`);

--
-- Indexes for table `teacher_class`
--
ALTER TABLE `teacher_class`
  ADD PRIMARY KEY (`teacher_class_id`);

--
-- Indexes for table `teacher_class_announcements`
--
ALTER TABLE `teacher_class_announcements`
  ADD PRIMARY KEY (`teacher_class_announcements_id`);

--
-- Indexes for table `teacher_class_student`
--
ALTER TABLE `teacher_class_student`
  ADD PRIMARY KEY (`teacher_class_student_id`);

--
-- Indexes for table `teacher_notification`
--
ALTER TABLE `teacher_notification`
  ADD PRIMARY KEY (`teacher_notification_id`);

--
-- Indexes for table `teacher_shared`
--
ALTER TABLE `teacher_shared`
  ADD PRIMARY KEY (`teacher_shared_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_log`
--
ALTER TABLE `user_log`
  ADD PRIMARY KEY (`user_log_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `activity_log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `answer`
--
ALTER TABLE `answer`
  MODIFY `answer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;

--
-- AUTO_INCREMENT for table `assignment`
--
ALTER TABLE `assignment`
  MODIFY `assignment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `chat_message`
--
ALTER TABLE `chat_message`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=174;

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `class_quiz`
--
ALTER TABLE `class_quiz`
  MODIFY `class_quiz_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `class_subject_overview`
--
ALTER TABLE `class_subject_overview`
  MODIFY `class_subject_overview_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `content`
--
ALTER TABLE `content`
  MODIFY `content_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `discussion_post`
--
ALTER TABLE `discussion_post`
  MODIFY `discussion_post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `discussion_reply`
--
ALTER TABLE `discussion_reply`
  MODIFY `discussion_reply_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=255;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=183;

--
-- AUTO_INCREMENT for table `message_sent`
--
ALTER TABLE `message_sent`
  MODIFY `message_sent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT for table `notification_read`
--
ALTER TABLE `notification_read`
  MODIFY `notification_read_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT for table `notification_read_teacher`
--
ALTER TABLE `notification_read_teacher`
  MODIFY `notification_read_teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `quiz_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `quiz_question`
--
ALTER TABLE `quiz_question`
  MODIFY `quiz_question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `school_year`
--
ALTER TABLE `school_year`
  MODIFY `school_year_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=224;

--
-- AUTO_INCREMENT for table `student_assignment`
--
ALTER TABLE `student_assignment`
  MODIFY `student_assignment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `student_backpack`
--
ALTER TABLE `student_backpack`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `student_class_quiz`
--
ALTER TABLE `student_class_quiz`
  MODIFY `student_class_quiz_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `student_material_access`
--
ALTER TABLE `student_material_access`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1212;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `teacher_backpack`
--
ALTER TABLE `teacher_backpack`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `teacher_class`
--
ALTER TABLE `teacher_class`
  MODIFY `teacher_class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=206;

--
-- AUTO_INCREMENT for table `teacher_class_announcements`
--
ALTER TABLE `teacher_class_announcements`
  MODIFY `teacher_class_announcements_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `teacher_class_student`
--
ALTER TABLE `teacher_class_student`
  MODIFY `teacher_class_student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=567;

--
-- AUTO_INCREMENT for table `teacher_notification`
--
ALTER TABLE `teacher_notification`
  MODIFY `teacher_notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `teacher_shared`
--
ALTER TABLE `teacher_shared`
  MODIFY `teacher_shared_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `user_log`
--
ALTER TABLE `user_log`
  MODIFY `user_log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chat_message`
--
ALTER TABLE `chat_message`
  ADD CONSTRAINT `chat_message_ibfk_1` FOREIGN KEY (`teacher_class_id`) REFERENCES `teacher_class` (`teacher_class_id`),
  ADD CONSTRAINT `chat_message_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

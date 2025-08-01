-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2024 at 01:11 PM
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
-- Database: `mindmaze`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `Admin_Name` varchar(50) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `EmailAddress` varchar(100) NOT NULL,
  `PhoneNum` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`Admin_Name`, `Name`, `Password`, `EmailAddress`, `PhoneNum`) VALUES
('ben', 'BEN', '1111', 'ben1111@gmail.com', 1234567891);

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE `quiz` (
  `Quiz_Code` char(4) NOT NULL,
  `Quiz_Title` varchar(50) NOT NULL,
  `Teach_Name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz`
--

INSERT INTO `quiz` (`Quiz_Code`, `Quiz_Title`, `Teach_Name`) VALUES
('M001', 'FRUIT', 'yikwei123'),
('M002', 'FAMILY', 'yikwei123'),
('m003', 'FRIEND', 'yikwei123');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_question`
--

CREATE TABLE `quiz_question` (
  `Question_ID` int(11) NOT NULL,
  `Quiz_Code` char(4) NOT NULL,
  `Question` varchar(50) NOT NULL,
  `Option1` varchar(50) NOT NULL,
  `Option2` varchar(50) NOT NULL,
  `Option3` varchar(50) NOT NULL,
  `Option4` varchar(50) NOT NULL,
  `Answer` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_question`
--

INSERT INTO `quiz_question` (`Question_ID`, `Quiz_Code`, `Question`, `Option1`, `Option2`, `Option3`, `Option4`, `Answer`) VALUES
(1, 'M001', '__PPLE', 'D', 'P', 'A', 'E', 'C'),
(2, 'M001', '__ANANA', 'P', 'B', 'S', 'T', 'B'),
(3, 'M001', 'PE__R', 'E', 'O', 'A', 'I', 'C'),
(4, 'M001', 'CHER__Y', 'E', 'Y', 'R', 'U', 'C'),
(5, 'M002', 'F__TH__R', 'E,A', 'A,A', 'A,E', 'E,E', 'C'),
(6, 'M002', 'MOTH__ __', 'E,R', 'E,E', 'R,E', 'A,R', 'A'),
(7, 'm003', 'B__Y', 'O', 'A', 'E', 'U', 'A'),
(8, 'm003', 'GI__', 'TY', 'RL', 'RY', 'EY', 'B');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `User_Name` varchar(50) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `EmailAddress` varchar(50) NOT NULL,
  `PhoneNum` int(11) NOT NULL,
  `Teach_Name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`User_Name`, `Name`, `Password`, `EmailAddress`, `PhoneNum`, `Teach_Name`) VALUES
('boze1123', 'CHIN BO ZE', '8888', 'boze1234@outlook.com', 1128683773, 'yikwei123'),
('tamil11', 'tamil', '3333', 'tamil123@gmail.com', 2147483647, 'kelvin123');

-- --------------------------------------------------------

--
-- Table structure for table `student_result`
--

CREATE TABLE `student_result` (
  `Quiz_Code` char(4) NOT NULL,
  `User_Name` varchar(50) NOT NULL,
  `Num_Of_Correct` int(100) NOT NULL,
  `Num_Of_Wrong` int(100) NOT NULL,
  `Final_Score` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_result`
--

INSERT INTO `student_result` (`Quiz_Code`, `User_Name`, `Num_Of_Correct`, `Num_Of_Wrong`, `Final_Score`) VALUES
('m001', 'boze1123', 1, 3, 25),
('m002', 'boze1123', 2, 0, 100),
('M001', 'tamil11', 3, 1, 75),
('m002', 'tamil11', 2, 0, 100),
('M003', 'boze1123', 2, 0, 100);

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `Teach_Name` varchar(50) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `EmailAddress` varchar(50) NOT NULL,
  `PhoneNum` int(11) NOT NULL,
  `Admin_Name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`Teach_Name`, `Name`, `Password`, `EmailAddress`, `PhoneNum`, `Admin_Name`) VALUES
('kelvin123', 'kelvin', '2222', 'kl12@gmial.com', 2147483647, 'ben'),
('yikwei123', 'NG YIK WEI', '2222', 'yw1234@gmail.com', 124354657, 'ben');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`Admin_Name`);

--
-- Indexes for table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`Quiz_Code`),
  ADD KEY `Teach_Name` (`Teach_Name`);

--
-- Indexes for table `quiz_question`
--
ALTER TABLE `quiz_question`
  ADD PRIMARY KEY (`Question_ID`),
  ADD KEY `Quiz_Code` (`Quiz_Code`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`User_Name`),
  ADD KEY `Teach_Name` (`Teach_Name`);

--
-- Indexes for table `student_result`
--
ALTER TABLE `student_result`
  ADD KEY `student_result_ibfk_1` (`User_Name`),
  ADD KEY `Quiz_Code` (`Quiz_Code`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`Teach_Name`),
  ADD KEY `Admin_Name` (`Admin_Name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `quiz_question`
--
ALTER TABLE `quiz_question`
  MODIFY `Question_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `quiz`
--
ALTER TABLE `quiz`
  ADD CONSTRAINT `quiz_ibfk_1` FOREIGN KEY (`Teach_Name`) REFERENCES `teacher` (`Teach_Name`);

--
-- Constraints for table `quiz_question`
--
ALTER TABLE `quiz_question`
  ADD CONSTRAINT `quiz_question_ibfk_1` FOREIGN KEY (`Quiz_Code`) REFERENCES `quiz` (`Quiz_Code`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`Teach_Name`) REFERENCES `teacher` (`Teach_Name`);

--
-- Constraints for table `student_result`
--
ALTER TABLE `student_result`
  ADD CONSTRAINT `student_result_ibfk_1` FOREIGN KEY (`User_Name`) REFERENCES `student` (`User_Name`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_result_ibfk_2` FOREIGN KEY (`Quiz_Code`) REFERENCES `quiz` (`Quiz_Code`);

--
-- Constraints for table `teacher`
--
ALTER TABLE `teacher`
  ADD CONSTRAINT `teacher_ibfk_1` FOREIGN KEY (`Admin_Name`) REFERENCES `admin` (`Admin_Name`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

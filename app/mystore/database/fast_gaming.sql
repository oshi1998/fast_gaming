-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 26, 2021 at 10:42 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fast_gaming`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `cus_username` varchar(255) NOT NULL COMMENT 'ชื่อผู้ใช้งาน',
  `cus_firstname` varchar(255) NOT NULL COMMENT 'ชื่อจริง',
  `cus_lastname` varchar(255) NOT NULL COMMENT 'นามสกุล',
  `cus_address` text NOT NULL COMMENT 'ที่อยู่',
  `cus_phone` varchar(255) NOT NULL COMMENT 'เบอร์โทร',
  `cus_email` varchar(255) NOT NULL COMMENT 'อีเมล',
  `cus_gender` varchar(10) NOT NULL COMMENT 'เพศ',
  `cus_password` varchar(255) NOT NULL COMMENT 'รหัสผ่าน',
  `cus_created` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'สร้างเมื่อ',
  `cus_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'อัพเดตล่าสุด'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `emp_id` varchar(255) NOT NULL COMMENT 'รหัสพนักงาน',
  `emp_firstname` varchar(255) NOT NULL COMMENT 'ชื่อจริง',
  `emp_lastname` varchar(255) NOT NULL COMMENT 'นามสกุล',
  `emp_contact` text NOT NULL COMMENT 'ข้อมูลติดต่อ',
  `emp_level` varchar(255) NOT NULL COMMENT 'ระดับผู้ใช้งาน',
  `emp_password` varchar(255) NOT NULL COMMENT 'รหัสผ่าน',
  `emp_avatar` text NOT NULL COMMENT 'รูประจำตัวพนักงาน',
  `emp_id_card_code` varchar(255) NOT NULL COMMENT 'รหัสบัตรประชาชน',
  `emp_id_card_img` text NOT NULL COMMENT 'รูปภาพบัตรประจำตัวประชาชน',
  `emp_join_date` date DEFAULT NULL COMMENT 'วันเข้าทำงาน',
  `emp_out_date` date DEFAULT NULL COMMENT 'วันที่พ้นสภาพ',
  `emp_status` varchar(255) NOT NULL COMMENT 'สถานะพนักงาน',
  `emp_note` text NOT NULL COMMENT 'หมายเหตุ',
  `emp_contract` text NOT NULL COMMENT 'ไฟล์สัญญาจ้าง',
  `emp_created` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'สร้างเมื่อ',
  `emp_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'อัพเดตล่าสุด'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `store`
--

CREATE TABLE `store` (
  `st_name` varchar(255) NOT NULL COMMENT 'ชื่อเว็บ',
  `st_address` text NOT NULL COMMENT 'ที่อยู่',
  `st_phone` varchar(255) NOT NULL COMMENT 'เบอร์โทร',
  `st_email` varchar(255) NOT NULL COMMENT 'อีเมล',
  `st_facebook` varchar(255) NOT NULL COMMENT 'เฟสบุ๊ค',
  `st_twitter` varchar(255) NOT NULL COMMENT 'ทวิตเตอร์',
  `st_ig` varchar(255) NOT NULL COMMENT 'ไอจี',
  `st_youtube` varchar(255) NOT NULL COMMENT 'ยูทูป',
  `st_line` varchar(255) NOT NULL COMMENT 'ไอดีไลน์',
  `st_logo` text NOT NULL COMMENT 'ภาพโลโก้',
  `st_description` text NOT NULL COMMENT 'รายละเอียดเว็บ',
  `st_keywords` text NOT NULL COMMENT 'คำค้นหาสำคัญ',
  `st_author` varchar(255) NOT NULL COMMENT 'ผู้เขียนเว็บ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `store`
--

INSERT INTO `store` (`st_name`, `st_address`, `st_phone`, `st_email`, `st_facebook`, `st_twitter`, `st_ig`, `st_youtube`, `st_line`, `st_logo`, `st_description`, `st_keywords`, `st_author`) VALUES
('The Fast Gaming Gear', '40/88-89 หมู่บ้านพรธิสาร 3 ซอย 11 ตำบลคลองหก อำเภอคลองหลวง จังหวัดปทุมธานี 12120', '0969247674', '', 'https://www.facebook.com/TheFast.co.th/', '', '', '', '@574aabzd', '6150d61f4ba9c.jpg', 'ร้าน The Fast เป็นร้านขายอุปกรณ์คอมพิวเตอร์ทุกชนิด ตั้งอยู่ที่ 40/88-89 หมู่บ้านพรธิสาร 3 ซอย 11 ตำบลคลองหก อำเภอคลองหลวง จังหวัดปทุมธานี 12120', 'เมาส์เกมมิ่งเกียร์,คีย์บอร์ดเกมมิ่งเกียร์,หูฟังเกมมิ่งเกียร์,เก้าอี้เกมมิ่งเกียร์\r\n', 'Supakit Sarasit');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `usr_username` varchar(255) NOT NULL COMMENT 'ชื่อผู้ใช้งาน',
  `usr_firstname` varchar(255) NOT NULL COMMENT 'ชื่อจริง',
  `usr_lastname` varchar(255) NOT NULL COMMENT 'นามสกุล',
  `usr_contact` text NOT NULL COMMENT 'ข้อมูลติดต่อ',
  `usr_level` varchar(255) NOT NULL COMMENT 'ระดับผู้ใช้งาน',
  `usr_password` varchar(255) NOT NULL COMMENT 'รหัสผ่าน',
  `usr_created` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'สร้างเมื่อ',
  `usr_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'อัพเดตล่าสุด'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`usr_username`, `usr_firstname`, `usr_lastname`, `usr_contact`, `usr_level`, `usr_password`, `usr_created`, `usr_updated`) VALUES
('supakit', 'Supakit', 'Sarasit', '', 'เจ้าของร้าน', '$2y$10$bzjZ3S4sDL.1IAU6GAYhvubE6zm3TLWmvllNz2dBaiP1XurrodJsa', '2021-09-26 10:28:41', '2021-09-26 11:59:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`cus_username`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`emp_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`usr_username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 27, 2021 at 11:42 PM
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
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `brand_id` int(11) NOT NULL COMMENT 'รหัสยี่ห้อ',
  `brand_name` varchar(255) NOT NULL COMMENT 'ชื่อยี่ห้อ',
  `brand_created` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'สร้างเมื่อ',
  `brand_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'อัพเดตเมื่อ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`brand_id`, `brand_name`, `brand_created`, `brand_updated`) VALUES
(3, 'Fantech', '2021-09-27 17:14:34', '2021-09-27 17:16:34'),
(4, 'Razer', '2021-09-27 17:16:29', '2021-09-27 17:16:48');

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
-- Table structure for table `discount_codes`
--

CREATE TABLE `discount_codes` (
  `dc_id` int(11) NOT NULL COMMENT 'รหัส',
  `dc_code` varchar(255) NOT NULL COMMENT 'โค้ดส่วนลด',
  `dc_type` varchar(255) NOT NULL COMMENT 'ประเภทส่วนลด',
  `dc_value` double(10,2) NOT NULL COMMENT 'ส่วนลด',
  `dc_created` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'สร้างเมื่อ',
  `dc_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'อัพเดตล่าสุด'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `discount_codes`
--

INSERT INTO `discount_codes` (`dc_id`, `dc_code`, `dc_type`, `dc_value`, `dc_created`, `dc_updated`) VALUES
(2, 'TEST2', 'ส่วนลดเปอร์เซ็น', 10.00, '2021-09-27 20:26:02', '2021-09-27 20:26:02'),
(3, 'TEST66', 'ส่วนลดเงินสด', 100.00, '2021-09-27 20:26:15', '2021-09-27 20:26:15'),
(4, 'TESTAAA1', 'ส่วนลดเปอร์เซ็น', 50.00, '2021-09-27 20:28:40', '2021-09-27 20:29:58'),
(5, 'NEWCUSTOMER2021', 'ส่วนลดเปอร์เซ็น', 5.00, '2021-09-27 21:00:44', '2021-09-27 21:00:44');

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
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `pro_id` varchar(255) NOT NULL COMMENT 'รหัสสินค้า',
  `pro_name` varchar(255) NOT NULL COMMENT 'ชื่อสินค้า',
  `pro_detail` longtext NOT NULL COMMENT 'รายละเอียดสินค้า',
  `pro_qty` int(11) NOT NULL COMMENT 'จำนวนคงเหลือ',
  `pro_price` double(10,2) NOT NULL COMMENT 'ราคา',
  `pro_type` int(11) NOT NULL COMMENT 'รหัสประเภท',
  `pro_brand` int(11) NOT NULL COMMENT 'รหัสแบรนด์',
  `pro_img` text NOT NULL COMMENT 'ไฟล์ภาพสินค้า',
  `pro_view` int(11) NOT NULL DEFAULT 0 COMMENT 'ยอดผู้ชม',
  `pro_created` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'สร้างเมื่อ',
  `pro_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'อัพเดตเมื่อ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`pro_id`, `pro_name`, `pro_detail`, `pro_qty`, `pro_price`, `pro_type`, `pro_brand`, `pro_img`, `pro_view`, `pro_created`, `pro_updated`) VALUES
('PRO202192843841', 'MOUSE (เมาส์) FANTECH BLAKE X17 (WHITE)', '', 10, 740.00, 2, 3, '615239ec48398.jpg', 0, '2021-09-27 21:38:52', '2021-09-27 21:38:52');

-- --------------------------------------------------------

--
-- Table structure for table `product_types`
--

CREATE TABLE `product_types` (
  `pt_id` int(11) NOT NULL COMMENT 'รหัสประเภทสินค้า',
  `pt_name` varchar(255) NOT NULL COMMENT 'ชื่อประเภท',
  `pt_created` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'สร้างเมื่อ',
  `pt_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'อัพเดตล่าสุด'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_types`
--

INSERT INTO `product_types` (`pt_id`, `pt_name`, `pt_created`, `pt_updated`) VALUES
(2, 'เมาส์เกมมิ่งเกียร์', '2021-09-27 17:43:10', '2021-09-27 17:43:10'),
(3, 'คีย์บอร์ดเกมมิ่งเกียร์', '2021-09-27 19:19:31', '2021-09-27 19:19:31');

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
('The Fast Gaming Gear', '40/88-89 หมู่บ้านพรธิสาร 3 ซอย 11 ตำบลคลองหก อำเภอคลองหลวง จังหวัดปทุมธานี 12120', '0969247674', '', 'https://www.facebook.com/TheFast.co.th/', '', '', '', '@574aabzd', '6151952416084.jpg', 'ร้าน The Fast เป็นร้านขายอุปกรณ์คอมพิวเตอร์ทุกชนิด ตั้งอยู่ที่ 40/88-89 หมู่บ้านพรธิสาร 3 ซอย 11 ตำบลคลองหก อำเภอคลองหลวง จังหวัดปทุมธานี 12120', 'เมาส์เกมมิ่งเกียร์,คีย์บอร์ดเกมมิ่งเกียร์,หูฟังเกมมิ่งเกียร์,เก้าอี้เกมมิ่งเกียร์\r\n', 'Supakit Sarasit');

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
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`cus_username`);

--
-- Indexes for table `discount_codes`
--
ALTER TABLE `discount_codes`
  ADD PRIMARY KEY (`dc_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`emp_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`pro_id`),
  ADD KEY `pro_brand` (`pro_brand`),
  ADD KEY `pro_type` (`pro_type`);

--
-- Indexes for table `product_types`
--
ALTER TABLE `product_types`
  ADD PRIMARY KEY (`pt_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`usr_username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสยี่ห้อ', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `discount_codes`
--
ALTER TABLE `discount_codes`
  MODIFY `dc_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัส', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product_types`
--
ALTER TABLE `product_types`
  MODIFY `pt_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสประเภทสินค้า', AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`pro_brand`) REFERENCES `brands` (`brand_id`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`pro_type`) REFERENCES `product_types` (`pt_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

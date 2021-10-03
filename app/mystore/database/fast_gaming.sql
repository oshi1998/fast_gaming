-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 03, 2021 at 02:43 PM
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
-- Table structure for table `banks`
--

CREATE TABLE `banks` (
  `bank_id` int(11) NOT NULL COMMENT 'รหัส',
  `bank_name` varchar(255) NOT NULL COMMENT 'ชื่อธนาคาร',
  `bank_acc_number` varchar(255) NOT NULL COMMENT 'เลขบัญชี',
  `bank_acc_name` varchar(255) NOT NULL COMMENT 'ชื่อบัญชี',
  `bank_created` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'สร้างเมื่อ',
  `bank_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'อัพเดตล่าสุด'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `banks`
--

INSERT INTO `banks` (`bank_id`, `bank_name`, `bank_acc_number`, `bank_acc_name`, `bank_created`, `bank_updated`) VALUES
(1, 'ไทยพาณิชย์', '4066171712', 'Fast Gaming Gear', '2021-10-01 14:36:00', '2021-10-01 14:36:00');

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
(4, 'Razer', '2021-09-27 17:16:29', '2021-09-27 17:16:48'),
(5, 'Ducky', '2021-09-30 16:32:43', '2021-09-30 16:32:43'),
(6, 'Skull Candy', '2021-09-30 16:33:22', '2021-09-30 16:33:22');

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

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`cus_username`, `cus_firstname`, `cus_lastname`, `cus_address`, `cus_phone`, `cus_email`, `cus_gender`, `cus_password`, `cus_created`, `cus_updated`) VALUES
('oshi', 'วงศ์วสันต์', 'ดวงเกตุ', 'ร้อยเอ็ด', '0972651700', '', 'ชาย', '$2y$10$BnZQcdd6/0bHIlbD52g5suQ6RY3IGYUwqcLihuoPsjVVxcrBz/HHa', '2021-09-28 18:46:53', '2021-10-01 21:47:52');

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
(3, 'TEST66', 'ส่วนลดเงินสด', 100.00, '2021-09-27 20:26:15', '2021-10-01 23:10:53'),
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

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`emp_id`, `emp_firstname`, `emp_lastname`, `emp_contact`, `emp_level`, `emp_password`, `emp_avatar`, `emp_id_card_code`, `emp_id_card_img`, `emp_join_date`, `emp_out_date`, `emp_status`, `emp_note`, `emp_contract`, `emp_created`, `emp_updated`) VALUES
('EMP2021103172144', 'วงศ์วสันต์', 'ดวงเกตุ', '', 'พนักงาน', '$2y$10$G/nZ5fvvUSpLErQapotgQeI4zjixRG/OviReA8DamrY2IjiybamNm', '6159844718724.jpg', '', '', '2021-10-03', NULL, 'พนักงานประจำ', '', '', '2021-10-03 10:21:59', '2021-10-03 11:15:02');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `od_id` varchar(255) NOT NULL COMMENT 'รหัส',
  `od_cus_username` varchar(255) NOT NULL COMMENT 'ลูกค้า',
  `od_amount` int(11) NOT NULL COMMENT 'จำนวน',
  `od_pro_total` double(10,2) NOT NULL COMMENT 'ราคาสินค้าทั้งหมด',
  `od_shipping_cost` double(10,2) NOT NULL COMMENT 'ค่าส่ง',
  `od_discount_cost` double(10,2) NOT NULL COMMENT 'ส่วนลด',
  `od_total` double(10,2) NOT NULL COMMENT 'รวมทั้งหมด',
  `od_payment_method` varchar(255) NOT NULL COMMENT 'ช่องทางการชำระเงิน',
  `od_delivery_type` varchar(255) NOT NULL COMMENT 'การจัดส่ง',
  `od_delivery_date` date NOT NULL COMMENT 'วันที่ดำเนินการจัดส่ง',
  `od_ems` varchar(255) NOT NULL COMMENT 'หมายเลข EMS',
  `od_status` varchar(255) NOT NULL COMMENT 'สถานะ',
  `od_note` text NOT NULL COMMENT 'หมายเหตุ',
  `od_created` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'สร้างเมื่อ',
  `od_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'อัพเดตล่าสุด'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`od_id`, `od_cus_username`, `od_amount`, `od_pro_total`, `od_shipping_cost`, `od_discount_cost`, `od_total`, `od_payment_method`, `od_delivery_type`, `od_delivery_date`, `od_ems`, `od_status`, `od_note`, `od_created`, `od_updated`) VALUES
('OD20211002-1094', 'oshi', 1, 3490.00, 100.00, 359.00, 3231.00, 'เก็บเงินปลายทาง', 'Fast Delivery - ส่งด่วนในประเทศ', '2021-10-03', 'EF582621151TH', 'สำเร็จ', '', '2021-10-02 09:21:56', '2021-10-02 17:54:59'),
('OD20211002-739', 'oshi', 2, 6040.00, 100.00, 100.00, 6040.00, 'โอน/ชำระผ่านบัญชีธนาคาร', 'Fast Delivery - ส่งด่วนในประเทศ', '2021-10-03', '', 'สำเร็จ', '', '2021-10-02 08:20:46', '2021-10-03 12:08:09'),
('OD20211003-984', 'oshi', 1, 25800.00, 70.00, 0.00, 25870.00, 'โอน/ชำระผ่านบัญชีธนาคาร', 'Standard Delivery - ส่งธรรมดาในประเทศ', '0000-00-00', '', 'ยกเลิกแล้ว', 'สินค้าไม่พร้อมส่ง', '2021-10-02 18:38:31', '2021-10-02 18:53:59');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `odd_id` int(11) NOT NULL COMMENT 'รหัส',
  `odd_od_id` varchar(255) NOT NULL COMMENT 'รหัสออเดอร์',
  `odd_pro_id` varchar(255) NOT NULL COMMENT 'รหัสสินค้า',
  `odd_amount` int(11) NOT NULL COMMENT 'จำนวน'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`odd_id`, `odd_od_id`, `odd_pro_id`, `odd_amount`) VALUES
(3, 'OD20211002-739', 'PRO202192843841', 1),
(4, 'OD20211002-739', 'PRO2021930233444', 1),
(5, 'OD20211002-1094', 'PRO202193023347', 1),
(6, 'OD20211003-984', 'PRO2021930233544', 2);

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
('PRO202192843841', 'MOUSE (เมาส์) FANTECH BLAKE X17 (WHITE)', 'SENSOR\r\nConnectivity : Wired\r\nSensor Type : Optical\r\nSensor : PixArt PMW3325\r\nAdjustable LOD : No\r\nResolution : 200-10,000 DPI\r\nIPS : 100\r\nAcceleration : 20G\r\nPolling Rate : 1000Hz\r\nOn-board Memory : Yes\r\nDESIGN\r\nBack Cover Material : UV Matte\r\nCore Construction : ABS Plastic\r\nShape : Ambidextrous\r\nTotal Button : 8\r\nSwitch Type & Lifetime : Huano 20 million clicks\r\nIllumination : Running RGB with 7 RGB modes\r\nWeight : 91gr without cable\r\nDimension : 125*62*42mm\r\nCable : 1.8m Nylon braided cable\r\nCOMPATIBILITY\r\nOS : Windows and Mac OS X. USB Port Required\r\nSoftware : Windows (7 or Newer)\r\n', 9, 740.00, 2, 3, '615239ec48398.jpg', 219, '2021-09-27 21:38:52', '2021-10-02 08:20:46'),
('PRO2021930233444', 'HEADPHONE (หูฟังไร้สาย) SKULLCANDY HESH 3.0 BLUETOOTH (SK-S6HTW-K617) BLUE', 'Weight: 200g\r\nConnection Type: Bluetooth® or Wired\r\nImpedence: 32 Ohms\r\nRapid Charge: 10 Min = 4 Hours of Play\r\nDriver Diameter: 40mm\r\nTHD: ≦2.0% @ 1KHz 1mW\r\nSound Pressure Level: 97.3db @1KHz\r\nFrequency Response: 20Hz - 20KHz\r\nHeadphone Type: Over-Ear\r\n', 19, 5300.00, 4, 6, '6155e73bf111e.jpg', 6, '2021-09-30 16:35:07', '2021-10-02 08:20:46'),
('PRO202193023347', 'KEYBOARD (คีย์บอร์ด) DUCKY ONE 2 MINI RGB PURE WHITE (CHERRY MX BROWN) (EN/TH)', '•	Structure : Mechanical structure\r\n•	Trigger switch : Cherry MX mechanical switches\r\n•	Connection interface : USB 2.0\r\n•	Output key number : USB N-Key Rollover\r\n•	Printing technology : Double-Shot or Laser Engraved\r\n•	Dimensions : 302 x 108 x 40 mm\r\n•	Weight : 590g\r\n', 19, 3490.00, 3, 5, '6155e70f816bc.jpg', 12, '2021-09-30 16:34:23', '2021-10-02 09:21:57'),
('PRO2021930233544', 'GAMING CHAIR (เก้าอี้เกมมิ่ง) RAZER ISKUR X (RZ38-02840100-R3U1) BLACK-GREEN', '•	Recommended Weight : < 136 kg (< 299 lbs)\r\n•	Recommended Height : 170 cm - 190 cm (5’6” to 6’2”)\r\n•	Chair Cover Color : Black and Green\r\n•	Chair Cover Material : PVC Leather\r\n•	Base : 5-star metal powder coated\r\n•	Frame : Metal & Plywood\r\n•	Armrests : 2D\r\n•	Casters : 6 cm Caster Wheel\r\n•	Gas Lift Class : 4\r\n•	Foam Type : High Density Molded Foam\r\n•	Adjustable Back Angle : 139 Degrees\r\n•	Adjustable Lumbar Cushion : No\r\n•	Adjustable Headrest : No\r\n', 10, 12900.00, 5, 4, '6155e76f7545e.jpg', 6, '2021-09-30 16:35:59', '2021-10-02 18:54:05');

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
(3, 'คีย์บอร์ดเกมมิ่งเกียร์', '2021-09-27 19:19:31', '2021-09-27 19:19:31'),
(4, 'หูฟังเกมมิ่งเกียร์', '2021-09-30 16:32:12', '2021-09-30 16:32:12'),
(5, 'เก้าอี้เกมมิ่งเกียร์', '2021-09-30 16:32:21', '2021-09-30 16:32:21');

-- --------------------------------------------------------

--
-- Table structure for table `shipping`
--

CREATE TABLE `shipping` (
  `shp_id` int(11) NOT NULL COMMENT 'รหัส',
  `shp_name` varchar(255) NOT NULL COMMENT 'ชื่อ',
  `shp_cost` double(10,2) NOT NULL COMMENT 'ค่าส่ง',
  `shp_created` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'สร้างเมื่อ',
  `shp_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'อัพเดตล่าสุด'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `shipping`
--

INSERT INTO `shipping` (`shp_id`, `shp_name`, `shp_cost`, `shp_created`, `shp_updated`) VALUES
(1, 'Standard Delivery - ส่งธรรมดาในประเทศ', 70.00, '2021-10-01 13:24:12', '2021-10-01 13:25:45'),
(2, 'Fast Delivery - ส่งด่วนในประเทศ', 100.00, '2021-10-01 14:11:55', '2021-10-01 21:08:28');

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
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `tst_id` varchar(255) NOT NULL COMMENT 'รหัส',
  `tst_cus_username` varchar(255) NOT NULL COMMENT 'ลูกค้า',
  `tst_od_id` varchar(255) NOT NULL COMMENT 'รหัสออเดอร์',
  `tst_amount` double(10,2) NOT NULL COMMENT 'ยอดเงิน',
  `tst_slip` text NOT NULL COMMENT 'ไฟล์ภาพสลิป',
  `tst_re_bank` varchar(255) NOT NULL COMMENT 'ธนาคารผู้รับ',
  `tst_re_acc_number` varchar(255) NOT NULL COMMENT 'เลขบัญชีผู้รับ',
  `tst_re_acc_name` varchar(255) NOT NULL COMMENT 'ชื่อบัญชีผู้รับ',
  `tst_transfer_bank` varchar(255) NOT NULL COMMENT 'ธนาคารผู้โอน',
  `tst_transfer_acc_number` varchar(255) NOT NULL COMMENT 'เลขบัญชีผู้โอน',
  `tst_transfer_acc_name` varchar(255) NOT NULL COMMENT 'ชื่อบัญชีผู้โอน',
  `tst_transfer_datetime` datetime NOT NULL COMMENT 'วันเวลาที่โอน',
  `tst_created` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'สร้างเมื่อ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`tst_id`, `tst_cus_username`, `tst_od_id`, `tst_amount`, `tst_slip`, `tst_re_bank`, `tst_re_acc_number`, `tst_re_acc_name`, `tst_transfer_bank`, `tst_transfer_acc_number`, `tst_transfer_acc_name`, `tst_transfer_datetime`, `tst_created`) VALUES
('TST20211002-461', 'oshi', 'OD20211002-739', 6040.00, 'OD20211002-739.jpg', 'ไทยพาณิชย์', '4066171712', 'Fast Gaming Gear', 'ธนาคารไทยพาณิชย์', '4066171712', 'วงศ์วสันต์ ดวงเกตุ', '2021-10-02 15:33:00', '2021-10-02 08:33:24');

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

-- --------------------------------------------------------

--
-- Table structure for table `using_dc`
--

CREATE TABLE `using_dc` (
  `use_id` int(11) NOT NULL COMMENT 'รหัส',
  `use_cus_username` varchar(255) NOT NULL COMMENT 'ลูกค้า',
  `use_dc_code` varchar(255) NOT NULL COMMENT 'โค้ดที่ใช้',
  `use_od_id` varchar(255) DEFAULT NULL COMMENT 'รหัสออเดอร์',
  `use_created` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'สร้างเมื่อ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `using_dc`
--

INSERT INTO `using_dc` (`use_id`, `use_cus_username`, `use_dc_code`, `use_od_id`, `use_created`) VALUES
(2, 'oshi', 'TEST66', 'OD20211002-739', '2021-10-01 22:19:30'),
(3, 'oshi', 'TEST2', 'OD20211002-1094', '2021-10-02 09:25:43'),
(4, 'oshi', 'NEWCUSTOMER2021', NULL, '2021-10-03 10:18:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`bank_id`);

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
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`od_id`),
  ADD KEY `od_cus_username` (`od_cus_username`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`odd_id`),
  ADD KEY `odd_od_id` (`odd_od_id`),
  ADD KEY `odd_pro_id` (`odd_pro_id`);

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
-- Indexes for table `shipping`
--
ALTER TABLE `shipping`
  ADD PRIMARY KEY (`shp_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`tst_id`),
  ADD KEY `tst_cus_username` (`tst_cus_username`),
  ADD KEY `tst_od_id` (`tst_od_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`usr_username`);

--
-- Indexes for table `using_dc`
--
ALTER TABLE `using_dc`
  ADD PRIMARY KEY (`use_id`),
  ADD KEY `use_od_id` (`use_od_id`),
  ADD KEY `use_cus_username` (`use_cus_username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banks`
--
ALTER TABLE `banks`
  MODIFY `bank_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัส', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสยี่ห้อ', AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `discount_codes`
--
ALTER TABLE `discount_codes`
  MODIFY `dc_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัส', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `odd_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัส', AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `product_types`
--
ALTER TABLE `product_types`
  MODIFY `pt_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสประเภทสินค้า', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `shipping`
--
ALTER TABLE `shipping`
  MODIFY `shp_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัส', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `using_dc`
--
ALTER TABLE `using_dc`
  MODIFY `use_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัส', AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`od_cus_username`) REFERENCES `customers` (`cus_username`);

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`odd_od_id`) REFERENCES `orders` (`od_id`),
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`odd_pro_id`) REFERENCES `products` (`pro_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`pro_brand`) REFERENCES `brands` (`brand_id`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`pro_type`) REFERENCES `product_types` (`pt_id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`tst_cus_username`) REFERENCES `customers` (`cus_username`),
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`tst_od_id`) REFERENCES `orders` (`od_id`);

--
-- Constraints for table `using_dc`
--
ALTER TABLE `using_dc`
  ADD CONSTRAINT `using_dc_ibfk_1` FOREIGN KEY (`use_od_id`) REFERENCES `orders` (`od_id`),
  ADD CONSTRAINT `using_dc_ibfk_2` FOREIGN KEY (`use_cus_username`) REFERENCES `customers` (`cus_username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

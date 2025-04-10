-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3318
-- Generation Time: Oct 24, 2023 at 01:48 AM
-- Server version: 5.7.11
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `invoicedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `bom`
--

CREATE TABLE `bom` (
  `bom_id` int(11) NOT NULL,
  `bom_name` varchar(25) DEFAULT NULL,
  `bom_fitem` varchar(25) DEFAULT NULL,
  `bom_uom` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bom`
--

INSERT INTO `bom` (`bom_id`, `bom_name`, `bom_fitem`, `bom_uom`) VALUES
(1, 'ASNPK', '10', 1),
(2, 'ASNPK', '10', 1);

-- --------------------------------------------------------

--
-- Table structure for table `bomitems`
--

CREATE TABLE `bomitems` (
  `bomi_id` int(11) NOT NULL,
  `bom_id` int(11) NOT NULL,
  `bom_item` varchar(25) NOT NULL,
  `bom_loc` varchar(25) NOT NULL,
  `bom_type` varchar(25) NOT NULL,
  `bom_qty` decimal(10,6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bomitems`
--

INSERT INTO `bomitems` (`bomi_id`, `bom_id`, `bom_item`, `bom_loc`, `bom_type`, `bom_qty`) VALUES
(1, 2, '3', '1', 'component', '30.000000'),
(2, 2, '1', '1', 'component', '17.500000'),
(3, 2, '2', '1', 'component', '2.500000');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `loc_id` int(11) NOT NULL,
  `loc_code` varchar(25) DEFAULT NULL,
  `loc_name` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`loc_id`, `loc_code`, `loc_name`) VALUES
(1, 'LOC_AAE_WHSE', 'AAE Warehouse'),
(2, 'LOC_PROD', 'Production Floor'),
(4, 'TM-KPONE', 'KPONE Warehouse'),
(5, 'TML', 'Tamale Warehouse'),
(6, 'KSI_EV_WHSE', 'Enepa Asokwa Warehouse'),
(8, 'samp_loc', 'Sample Warehouse'),
(9, 'sp_loc', 'Shelf Warehouse ');

-- --------------------------------------------------------

--
-- Table structure for table `manufact`
--

CREATE TABLE `manufact` (
  `mf_id` int(11) NOT NULL,
  `mf_date` timestamp NULL DEFAULT NULL,
  `mf_reftype` varchar(25) DEFAULT NULL,
  `mf_refno` varchar(12) DEFAULT NULL,
  `mf_fitem` varchar(25) DEFAULT NULL,
  `mf_bom` varchar(25) DEFAULT NULL,
  `mf_loc` varchar(25) DEFAULT NULL,
  `mf_fqty` varchar(25) DEFAULT NULL,
  `mf_note` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `manufact`
--

INSERT INTO `manufact` (`mf_id`, `mf_date`, `mf_reftype`, `mf_refno`, `mf_fitem`, `mf_bom`, `mf_loc`, `mf_fqty`, `mf_note`) VALUES
(1, '2023-09-26 00:00:00', 'blending', 'mf001', '10', '2', '2', '2000', 'Smooth run with 100% input to output');

-- --------------------------------------------------------

--
-- Table structure for table `manufactitems`
--

CREATE TABLE `manufactitems` (
  `mfi_id` int(11) NOT NULL,
  `mf_id` int(11) NOT NULL,
  `mf_rmitem` varchar(25) DEFAULT NULL,
  `mf_rmloc` varchar(25) DEFAULT NULL,
  `mf_stdqty` decimal(10,4) DEFAULT NULL,
  `mf_actqty` decimal(10,4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `manufactitems`
--

INSERT INTO `manufactitems` (`mfi_id`, `mf_id`, `mf_rmitem`, `mf_rmloc`, `mf_stdqty`, `mf_actqty`) VALUES
(1, 1, 'Ammonium Sulphate', 'AAE Warehouse', '48.0000', '48.0000'),
(2, 1, 'NPK 14-07-04', 'AAE Warehouse', '700.0000', '700.0000'),
(3, 1, 'NPK 0-12-20', 'AAE Warehouse', '100.0000', '100.0000');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `i_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `icode` varchar(25) NOT NULL,
  `iname` varchar(25) NOT NULL,
  `icat` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`i_id`, `u_id`, `icode`, `iname`, `icat`) VALUES
(1, 5, 'RM-001', 'NPK 14-07-04', 'Raw Material'),
(2, 5, 'RM-002', 'NPK 0-12-20', 'Raw Material'),
(3, 7, 'RM-003', 'Ammonium Sulphate', 'Raw Material'),
(4, 5, 'RM-004', 'NPK 21-5-5', 'Raw Material'),
(5, 6, 'MZ-WM', 'White Maize', 'Raw Material'),
(6, 6, 'MZ-WM', 'White Maize', 'Raw Material'),
(7, 9, 'PKG-001', 'AMG251010 (25kg) Sack', 'Packaging Materials'),
(8, 9, 'PKG-002', 'AMG251010 (50kg) Sack', 'Packaging Materials'),
(9, 5, 'FG-001', 'NPK 25:10:10', 'Finished Goods'),
(10, 5, 'SFG-001', 'NPK 25:10:10 Blend', 'Semi-Finished Goods'),
(11, 5, 'MZ-YG', 'Yellow Maize Grits', 'Finished Goods'),
(12, 6, 'MZ-WM', 'White Maize', 'Raw Material');

-- --------------------------------------------------------

--
-- Table structure for table `uom`
--

CREATE TABLE `uom` (
  `u_id` int(11) NOT NULL,
  `ucode` varchar(25) NOT NULL,
  `uname` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `uom`
--

INSERT INTO `uom` (`u_id`, `ucode`, `uname`) VALUES
(1, 'kg', 'kilogram'),
(2, 'g', 'grams'),
(3, 'pcs', 'pieces'),
(4, 'bag', 'bags'),
(5, '50kg', '50kilograms'),
(6, '25kg', '25kilograms'),
(7, '1250kg', '1250kilograms'),
(8, 'tn', 'ton'),
(9, '500pcs', '500pieces'),
(10, 'ctn', 'carton');

-- --------------------------------------------------------

--
-- Table structure for table `vhrdetails`
--

CREATE TABLE `vhrdetails` (
  `vhrd_id` int(11) NOT NULL,
  `vhrd_date` timestamp NULL DEFAULT NULL,
  `vhrd_reftype` varchar(25) DEFAULT NULL,
  `vhrd_refno` varchar(12) DEFAULT NULL,
  `vhrd_locin` varchar(25) NOT NULL,
  `vhrd_locout` varchar(25) NOT NULL,
  `vhrd_supplier` varchar(25) DEFAULT NULL,
  `vhrd_customer` varchar(25) DEFAULT NULL,
  `vhrd_note` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vhrdetails`
--

INSERT INTO `vhrdetails` (`vhrd_id`, `vhrd_date`, `vhrd_reftype`, `vhrd_refno`, `vhrd_locin`, `vhrd_locout`, `vhrd_supplier`, `vhrd_customer`, `vhrd_note`) VALUES
(1, '2023-09-25 00:00:00', 'tn', 'TN001', '', '', NULL, NULL, 'Transfer from AAE to KPONE'),
(2, '2023-09-25 00:00:00', 'tn', 'TN001', '', '', NULL, NULL, 'Transfer from AAE to KPONE'),
(3, '2023-09-25 00:00:00', 'rn', 'GRN001', '', '', 'AMG KPONE', NULL, 'Goods receipts from KPONE at AAE'),
(4, '2023-09-24 00:00:00', 'rn', 'GRN001', '', '', 'AMG KPONE', NULL, 'Goods Receipts from KPONE at AAE'),
(5, '2023-09-24 00:00:00', 'rn', 'GRN002', '', '', 'AMG KPONE', NULL, 'Received from KPONE at AAE'),
(6, '2023-09-24 00:00:00', 'rn', 'GRN003', '', '', 'AMG KPONE', NULL, 'Received from KPONE'),
(7, '2023-09-25 00:00:00', 'rn', 'GRN004', '', '', 'AMG KPONE', NULL, 'Receipts from KPONE'),
(8, '2023-09-26 00:00:00', 'rn', 'GRN005', '1', '4', 'AMG KPONE', NULL, 'Received from KPONE');

-- --------------------------------------------------------

--
-- Table structure for table `vhritems`
--

CREATE TABLE `vhritems` (
  `vhritem_id` int(11) NOT NULL,
  `vhrd_id` int(11) NOT NULL,
  `vhritem_product` varchar(25) DEFAULT NULL,
  `vhritem_uom` varchar(12) DEFAULT NULL,
  `vhritem_qty` int(11) DEFAULT NULL,
  `vhritem_vehno` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vhritems`
--

INSERT INTO `vhritems` (`vhritem_id`, `vhrd_id`, `vhritem_product`, `vhritem_uom`, `vhritem_qty`, `vhritem_vehno`) VALUES
(1, 1, 'NPK 21:5:5', '50kg', 1500, 'GE 5492-18'),
(2, 2, 'NPK 25:10:10 ', '50kg', 2000, 'GN 4632-18'),
(3, 3, 'AMG251010 Sacks', 'Bales of 500', 100, 'GN 4632-18'),
(4, 4, 'NPK 14-07-04', '50kg', 5000, 'GR 9852 -17'),
(5, 7, 'Ammonium Sulphate', '1250kg', 96, 'GC 7236-12'),
(6, 7, 'NPK 14-07-04', '50kg', 2000, 'GN 9852-20'),
(7, 7, 'AMG251010 (25kg) Sacks', '500pcs', 18, 'GN 9852-20'),
(12, 8, '3', '1250kg', 96, 'GC 4273-12'),
(13, 8, '2', '50kg', 1200, 'GC 7236-12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bom`
--
ALTER TABLE `bom`
  ADD PRIMARY KEY (`bom_id`);

--
-- Indexes for table `bomitems`
--
ALTER TABLE `bomitems`
  ADD PRIMARY KEY (`bomi_id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`loc_id`);

--
-- Indexes for table `manufact`
--
ALTER TABLE `manufact`
  ADD PRIMARY KEY (`mf_id`);

--
-- Indexes for table `manufactitems`
--
ALTER TABLE `manufactitems`
  ADD PRIMARY KEY (`mfi_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`i_id`);

--
-- Indexes for table `uom`
--
ALTER TABLE `uom`
  ADD PRIMARY KEY (`u_id`);

--
-- Indexes for table `vhrdetails`
--
ALTER TABLE `vhrdetails`
  ADD PRIMARY KEY (`vhrd_id`);

--
-- Indexes for table `vhritems`
--
ALTER TABLE `vhritems`
  ADD PRIMARY KEY (`vhritem_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bom`
--
ALTER TABLE `bom`
  MODIFY `bom_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bomitems`
--
ALTER TABLE `bomitems`
  MODIFY `bomi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `loc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `manufact`
--
ALTER TABLE `manufact`
  MODIFY `mf_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `manufactitems`
--
ALTER TABLE `manufactitems`
  MODIFY `mfi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `i_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `uom`
--
ALTER TABLE `uom`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `vhrdetails`
--
ALTER TABLE `vhrdetails`
  MODIFY `vhrd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `vhritems`
--
ALTER TABLE `vhritems`
  MODIFY `vhritem_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

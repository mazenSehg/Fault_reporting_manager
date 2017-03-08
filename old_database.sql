-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 08, 2017 at 11:39 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fault-management`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_access_log`
--

CREATE TABLE `tbl_access_log` (
  `ID` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `ip_address` text COLLATE utf8_unicode_ci NOT NULL,
  `device` text COLLATE utf8_unicode_ci NOT NULL,
  `user_agent` text COLLATE utf8_unicode_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_centres`
--

CREATE TABLE `tbl_centres` (
  `ID` bigint(20) NOT NULL,
  `name` varchar(1024) NOT NULL,
  `programme` varchar(1024) NOT NULL,
  `region` bigint(20) NOT NULL,
  `centre_code` varchar(1024) NOT NULL,
  `approved` int(1) NOT NULL,
  `ad1` varchar(150) NOT NULL,
  `ad2` varchar(150) NOT NULL,
  `ad3` varchar(150) NOT NULL,
  `ad4` varchar(150) DEFAULT NULL,
  `postcode` varchar(150) NOT NULL,
  `phone` varchar(150) NOT NULL,
  `fax` varchar(150) NOT NULL,
  `support_Rad` varchar(150) NOT NULL,
  `support_Rad_email` varchar(150) NOT NULL,
  `programme_manag` varchar(150) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_equipment`
--

CREATE TABLE `tbl_equipment` (
  `ID` bigint(20) NOT NULL,
  `name` varchar(1024) NOT NULL,
  `centre` bigint(20) NOT NULL,
  `equipment_code` varchar(1024) NOT NULL,
  `equipment_type` bigint(20) NOT NULL,
  `manufacturer` bigint(20) NOT NULL,
  `model` varchar(1024) NOT NULL,
  `supplier` bigint(20) NOT NULL,
  `service_agent` bigint(20) NOT NULL,
  `location_id` varchar(1024) NOT NULL,
  `location` varchar(1024) NOT NULL,
  `serial_number` varchar(1024) NOT NULL,
  `year_manufacturered` int(4) NOT NULL,
  `year_installed` int(4) NOT NULL,
  `year_decommisoned` int(4) NOT NULL,
  `decommed` int(1) NOT NULL,
  `spare` int(1) NOT NULL,
  `comment` text NOT NULL,
  `x_ray` int(1) NOT NULL,
  `approved` int(1) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_equipment_type`
--

CREATE TABLE `tbl_equipment_type` (
  `ID` bigint(20) NOT NULL,
  `code` varchar(150) NOT NULL,
  `name` varchar(1024) NOT NULL,
  `centre` bigint(20) NOT NULL,
  `supplier` text NOT NULL,
  `approved` int(1) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_fault`
--

CREATE TABLE `tbl_fault` (
  `ID` bigint(20) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `centre` bigint(20) NOT NULL,
  `name` varchar(1024) NOT NULL,
  `user_id` varchar(1000) NOT NULL,
  `equipment_type` bigint(20) NOT NULL,
  `equipment` bigint(20) NOT NULL,
  `fault_type` bigint(20) NOT NULL,
  `date_of_fault` varchar(1024) NOT NULL,
  `current_servicing_agency` varchar(1024) NOT NULL,
  `time_of_fault` varchar(1024) NOT NULL,
  `description_of_fault` text NOT NULL,
  `service_call_no` varchar(1024) NOT NULL,
  `action_taken` text NOT NULL,
  `fault_corrected_by_user` int(1) NOT NULL,
  `to_fix_at_next_service_visit` int(1) NOT NULL,
  `engineer_called_out` int(1) NOT NULL,
  `adverse_incident_report` int(1) NOT NULL,
  `equipment_status` int(1) NOT NULL,
  `equipment_downtime` int(11) NOT NULL,
  `screening_downtime` int(11) NOT NULL,
  `repeat_images` int(11) NOT NULL,
  `cancelled_women` int(11) NOT NULL,
  `technical_recalls` int(11) NOT NULL,
  `satisfied_servicing_organisation` int(1) NOT NULL,
  `satisfied_service_engineer` int(1) NOT NULL,
  `satisfied_equipment` int(1) NOT NULL,
  `approved` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_fault_type`
--

CREATE TABLE `tbl_fault_type` (
  `ID` bigint(20) NOT NULL,
  `name` varchar(1024) NOT NULL,
  `equipment_type` bigint(20) NOT NULL,
  `description` text NOT NULL,
  `approved` int(1) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_manufacturer`
--

CREATE TABLE `tbl_manufacturer` (
  `ID` bigint(20) NOT NULL,
  `name` varchar(1024) NOT NULL,
  `equipment_type` text NOT NULL,
  `approved` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_model`
--

CREATE TABLE `tbl_model` (
  `ID` bigint(20) NOT NULL,
  `name` varchar(1024) NOT NULL,
  `manufacturer` bigint(20) NOT NULL,
  `approved` int(1) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_notifications`
--

CREATE TABLE `tbl_notifications` (
  `ID` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `title` text NOT NULL,
  `notification` text NOT NULL,
  `read` int(1) NOT NULL DEFAULT '0',
  `hide` int(1) NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_options`
--

CREATE TABLE `tbl_options` (
  `ID` bigint(20) NOT NULL,
  `option_name` text NOT NULL,
  `option_value` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_region`
--

CREATE TABLE `tbl_region` (
  `ID` bigint(20) NOT NULL,
  `name` varchar(1024) NOT NULL,
  `body` bigint(20) NOT NULL,
  `approved` int(1) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_region_body`
--

CREATE TABLE `tbl_region_body` (
  `ID` bigint(20) NOT NULL,
  `name` varchar(1024) NOT NULL,
  `approved` int(1) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_service_agent`
--

CREATE TABLE `tbl_service_agent` (
  `ID` bigint(20) NOT NULL,
  `name` varchar(1024) NOT NULL,
  `equipment_type` text NOT NULL,
  `approved` int(1) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_supplier`
--

CREATE TABLE `tbl_supplier` (
  `ID` bigint(20) NOT NULL,
  `name` varchar(1024) NOT NULL,
  `approved` int(1) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_usermeta`
--

CREATE TABLE `tbl_usermeta` (
  `ID` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `meta_key` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `ID` bigint(20) NOT NULL,
  `user_email` varchar(512) NOT NULL,
  `user_pass` varchar(512) NOT NULL,
  `first_name` varchar(256) NOT NULL,
  `last_name` varchar(256) NOT NULL,
  `user_role` varchar(256) NOT NULL,
  `user_status` int(11) NOT NULL,
  `centre` text NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `registered_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`ID`, `user_email`, `user_pass`, `first_name`, `last_name`, `user_role`, `user_status`, `centre`, `created_by`, `registered_at`) VALUES
(1, 'admin@admin.com', '21232f297a57a5a743894a0e4a801fc3', 'Mazen', 'Sehgal', 'admin', 1, '', 0, '2016-06-14 08:35:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_access_log`
--
ALTER TABLE `tbl_access_log`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_centres`
--
ALTER TABLE `tbl_centres`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_equipment`
--
ALTER TABLE `tbl_equipment`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_equipment_type`
--
ALTER TABLE `tbl_equipment_type`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_fault`
--
ALTER TABLE `tbl_fault`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_fault_type`
--
ALTER TABLE `tbl_fault_type`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_manufacturer`
--
ALTER TABLE `tbl_manufacturer`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_model`
--
ALTER TABLE `tbl_model`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_notifications`
--
ALTER TABLE `tbl_notifications`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_options`
--
ALTER TABLE `tbl_options`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_region`
--
ALTER TABLE `tbl_region`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_region_body`
--
ALTER TABLE `tbl_region_body`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_service_agent`
--
ALTER TABLE `tbl_service_agent`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_usermeta`
--
ALTER TABLE `tbl_usermeta`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_access_log`
--
ALTER TABLE `tbl_access_log`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `tbl_centres`
--
ALTER TABLE `tbl_centres`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10000902864;
--
-- AUTO_INCREMENT for table `tbl_equipment`
--
ALTER TABLE `tbl_equipment`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10000825917;
--
-- AUTO_INCREMENT for table `tbl_equipment_type`
--
ALTER TABLE `tbl_equipment_type`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10000698757;
--
-- AUTO_INCREMENT for table `tbl_fault`
--
ALTER TABLE `tbl_fault`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10000925869;
--
-- AUTO_INCREMENT for table `tbl_fault_type`
--
ALTER TABLE `tbl_fault_type`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10000766185;
--
-- AUTO_INCREMENT for table `tbl_manufacturer`
--
ALTER TABLE `tbl_manufacturer`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10000966384;
--
-- AUTO_INCREMENT for table `tbl_model`
--
ALTER TABLE `tbl_model`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10000871520;
--
-- AUTO_INCREMENT for table `tbl_notifications`
--
ALTER TABLE `tbl_notifications`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=279;
--
-- AUTO_INCREMENT for table `tbl_options`
--
ALTER TABLE `tbl_options`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `tbl_region`
--
ALTER TABLE `tbl_region`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10000256403;
--
-- AUTO_INCREMENT for table `tbl_region_body`
--
ALTER TABLE `tbl_region_body`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10000479533;
--
-- AUTO_INCREMENT for table `tbl_service_agent`
--
ALTER TABLE `tbl_service_agent`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10000243240;
--
-- AUTO_INCREMENT for table `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10000490079;
--
-- AUTO_INCREMENT for table `tbl_usermeta`
--
ALTER TABLE `tbl_usermeta`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10000991734;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

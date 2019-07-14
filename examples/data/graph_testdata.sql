-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 14, 2019 at 06:59 PM
-- Server version: 10.4.5-MariaDB-1:10.4.5+maria~bionic-log
-- PHP Version: 7.3.4-1+ubuntu18.04.1+deb.sury.org+3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `graph_testdata`
--

-- --------------------------------------------------------

--
-- Table structure for table `graphdata_nodetypetests`
--

CREATE TABLE `graphdata_nodetypetests` (
  `source_id` varchar(50) NOT NULL,
  `source_name` varchar(255) NOT NULL,
  `source_size` int(11) NOT NULL DEFAULT 0,
  `source_type` varchar(255) NOT NULL,
  `source_group` varchar(255) NOT NULL,
  `source_longitude` decimal(17,7) NOT NULL DEFAULT 0.0000000,
  `source_latitude` decimal(17,7) NOT NULL DEFAULT 0.0000000,
  `source_img` varchar(255) DEFAULT NULL,
  `target_id` varchar(50) NOT NULL,
  `target_name` varchar(255) NOT NULL,
  `target_size` int(11) NOT NULL DEFAULT 0,
  `target_type` varchar(255) NOT NULL,
  `target_group` varchar(255) NOT NULL,
  `target_longitude` decimal(17,7) NOT NULL DEFAULT 0.0000000,
  `target_latitude` decimal(17,7) NOT NULL DEFAULT 0.0000000,
  `target_img` varchar(255) DEFAULT NULL,
  `weight` int(11) NOT NULL DEFAULT 50,
  `link_type` varchar(255) NOT NULL,
  `query_num` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `graphdata_nodetypetests`
--

INSERT INTO `graphdata_nodetypetests` (`source_id`, `source_name`, `source_size`, `source_type`, `source_group`, `source_longitude`, `source_latitude`, `source_img`, `target_id`, `target_name`, `target_size`, `target_type`, `target_group`, `target_longitude`, `target_latitude`, `target_img`, `weight`, `link_type`, `query_num`) VALUES
('1114904687', 'Magid', 300, 'npi', 'Start', '0.0000000', '0.0000000', 'https://kyruus-app-static.kyruus.com/providermatch/hm/photos/200/magid-jonathann-1114904687.jpg', '1891995221', 'Alice', 200, 'npi', 'End', '0.0000000', '0.0000000', '0', 100, 'Referral', 1),
('1114904687', 'Magid', 300, 'npi', 'Start', '0.0000000', '0.0000000', 'https://kyruus-app-static.kyruus.com/providermatch/hm/photos/200/magid-jonathann-1114904687.jpg', '7', '77006', 400, 'zipcode', 'Provider Zip Code', '29.7413230', '-95.3910490', '0', 50, 'Practices In', 1),
('1891995221', 'Alice', 300, 'npi', 'End', '0.0000000', '0.0000000', '', '7', '77006', 400, 'zipcode', 'Provider Zip Code', '29.7413230', '-95.3910490', '0', 50, 'Practices In', 1),
('1972539492', 'Medical Clinic', 0, 'npi', 'Clinic', '29.7725600', '-95.4009520', '', '1114904687', 'Magid', 200, 'npi', 'Start Provider', '0.0000000', '0.0000000', '0', 400, 'Affiliation', 1),
('1972539492', 'Medical Clinic', 200, 'npi', 'Clinic', '29.7725600', '-95.4009520', '', '741181532', 'Clinic Tax Num', 200, 'taxnum', 'Clinic', '0.0000000', '0.0000000', 'http://mchllp.com/mch/images/newmchbanner11.JPG', 50, 'Self', 1),
('1114904687', 'Magid', 0, 'npi', 'Start', '29.7725600', '-95.4009520', NULL, '7135265511', '7135265511', 0, 'phone', 'Start', '0.0000000', '0.0000000', NULL, 50, 'phone', 1),
('1114904687', 'Magid', 0, 'npi', 'Start', '29.7725600', '-95.4009520', NULL, '3923', 'CLIA 01D0299897 ROBERT D TAYLOR MD', 0, 'clia', 'Start', '0.0000000', '0.0000000', NULL, 50, 'clia lab', 1),
('1891995221', 'Alice', 0, 'npi', 'Start', '0.0000000', '0.0000000', NULL, 'D508', 'D508 Other iron deficiency anemias', 300, 'diagnosis', 'Start', '0.0000000', '0.0000000', NULL, 150, 'diagnosis', 1),
('1891995221', 'Alice', 0, 'npi', 'Start', '0.0000000', '0.0000000', NULL, 'J0696', 'J0696 Injection, ceftriaxone sodium, per 250 mg', 300, 'procedure', 'Start', '0.0000000', '0.0000000', NULL, 150, 'procedure', 1),
('1972539492', 'Medical Clinic', 200, 'npi', 'Clinic', '29.7725600', '0.0000000', '', '5', 'Health South', 200, 'system', 'Clinic', '0.0000000', '0.0000000', '0', 50, 'Self', 1),
('healthsouth.com', 'healthsouth.com', 200, 'domain', 'System', '0.0000000', '0.0000000', '', '5', 'Health South', 200, 'system', 'System', '0.0000000', '0.0000000', '0', 70, 'Self', 1),
('1114904', 'Magid', 300, 'someid', 'Start', '29.7725600', '0.0000000', '', '1891995', 'Alice', 200, 'npi', 'End', '0.0000000', '0.0000000', '0', 100, 'Referral', 2),
('1114904', 'Magid', 300, 'someid', 'Start', '29.7725600', '0.0000000', '', '7', '77006', 400, 'zipcode', 'Provider Zip Code', '29.7413230', '-95.3910490', '0', 50, 'Practices In', 2),
('1891995', 'Alice', 300, 'someid', 'End', '0.0000000', '0.0000000', '', '7', '77006', 400, 'zipcode', 'Provider Zip Code', '29.7413230', '-95.3910490', '0', 50, 'Practices In', 2),
('1972539', 'Medical Clinic', 0, 'someid', 'Clinic', '0.0000000', '0.0000000', '', '1114904', 'Magid', 200, 'someid', 'Start Provider', '0.0000000', '0.0000000', '0', 400, 'Affiliation', 2),
('1972539', 'Medical Clinic', 200, 'someid', 'Clinic', '0.0000000', '0.0000000', '', '741181532', 'Clinic Tax Num', 200, 'taxnum', 'Clinic', '0.0000000', '0.0000000', '0', 50, 'Self', 2),
('1114904', 'Magid', 0, 'someid', 'Start', '29.7725600', '-95.4009520', NULL, '7135265', '7135265', 0, 'phone', 'Start', '0.0000000', '0.0000000', NULL, 50, 'phone', 2),
('1114904', 'Magid', 0, 'someid', 'Start', '29.7725600', '-95.4009520', NULL, '3923', 'CLIA 01D0299897 ROBERT D TAYLOR MD', 0, 'clia', 'Start', '0.0000000', '0.0000000', NULL, 50, 'clia lab', 2),
('1891995', 'Alice', 0, 'someid', 'Start', '0.0000000', '0.0000000', NULL, 'D508', 'D508 Other iron deficiency anemias', 300, 'diagnosis', 'Start', '0.0000000', '0.0000000', NULL, 150, 'diagnosis', 2),
('1891995', 'Alice', 0, 'someid', 'Start', '0.0000000', '0.0000000', NULL, 'J0696', 'J0696 Injection, ceftriaxone sodium, per 250 mg', 300, 'procedure', 'Start', '0.0000000', '0.0000000', NULL, 150, 'procedure', 2),
('1972539', 'Medical Clinic', 200, 'someid', 'Clinic', '29.7725600', '-95.4009520', '', '5', 'Health South', 200, 'system', 'Clinic', '0.0000000', '0.0000000', '0', 50, 'Self', 2);

-- --------------------------------------------------------

--
-- Table structure for table `shoulderror_different_latlon`
--

CREATE TABLE `shoulderror_different_latlon` (
  `source_id` varchar(50) NOT NULL,
  `source_name` varchar(255) NOT NULL,
  `source_size` int(11) NOT NULL DEFAULT 0,
  `source_type` varchar(255) NOT NULL,
  `source_group` varchar(255) NOT NULL,
  `source_longitude` decimal(17,7) NOT NULL DEFAULT 0.0000000,
  `source_latitude` decimal(17,7) NOT NULL DEFAULT 0.0000000,
  `source_img` varchar(255) DEFAULT NULL,
  `target_id` varchar(50) NOT NULL,
  `target_name` varchar(255) NOT NULL,
  `target_size` int(11) NOT NULL DEFAULT 0,
  `target_type` varchar(255) NOT NULL,
  `target_group` varchar(255) NOT NULL,
  `target_longitude` decimal(17,7) NOT NULL DEFAULT 0.0000000,
  `target_latitude` decimal(17,7) NOT NULL DEFAULT 0.0000000,
  `target_img` varchar(255) DEFAULT NULL,
  `weight` int(11) NOT NULL DEFAULT 50,
  `link_type` varchar(255) NOT NULL,
  `query_num` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shoulderror_different_latlon`
--

INSERT INTO `shoulderror_different_latlon` (`source_id`, `source_name`, `source_size`, `source_type`, `source_group`, `source_longitude`, `source_latitude`, `source_img`, `target_id`, `target_name`, `target_size`, `target_type`, `target_group`, `target_longitude`, `target_latitude`, `target_img`, `weight`, `link_type`, `query_num`) VALUES
('1114904687', 'Magid', 300, 'npi', 'Start', '0.0000000', '0.0000000', 'https://kyruus-app-static.kyruus.com/providermatch/hm/photos/200/magid-jonathann-1114904687.jpg', '1891995221', 'Alice', 200, 'npi', 'End', '0.0000000', '0.0000000', '0', 100, 'Referral', 1),
('1114904687', 'Magid', 300, 'npi', 'Start', '0.0000000', '0.0000000', 'https://kyruus-app-static.kyruus.com/providermatch/hm/photos/200/magid-jonathann-1114904687.jpg', '7', '77006', 400, 'zipcode', 'Provider Zip Code', '29.7413230', '-95.3910490', '0', 50, 'Practices In', 1),
('1891995221', 'Alice', 300, 'npi', 'End', '0.0000000', '0.0000000', '', '7', '77006', 400, 'zipcode', 'Provider Zip Code', '29.7413230', '-95.3910490', '0', 50, 'Practices In', 1),
('1972539492', 'Medical Clinic', 0, 'npi', 'Clinic', '29.7725600', '-95.4009520', '', '1114904687', 'Magid', 200, 'npi', 'Start Provider', '0.0000000', '0.0000000', '0', 400, 'Affiliation', 1),
('1972539492', 'Medical Clinic', 200, 'npi', 'Clinic', '29.7725601', '-95.4009520', '', '741181532', 'Clinic Tax Num', 200, 'taxnum', 'Clinic', '0.0000000', '0.0000000', 'http://mchllp.com/mch/images/newmchbanner11.JPG', 50, 'Self', 1),
('1114904687', 'Magid', 0, 'npi', 'Start', '29.7725600', '-95.4009520', NULL, '7135265511', '7135265511', 0, 'phone', 'Start', '0.0000000', '0.0000000', NULL, 50, 'phone', 1),
('1114904687', 'Magid', 0, 'npi', 'Start', '29.7725600', '-95.4009520', NULL, '3923', 'CLIA 01D0299897 ROBERT D TAYLOR MD', 0, 'clia', 'Start', '0.0000000', '0.0000000', NULL, 50, 'clia lab', 1),
('1891995221', 'Alice', 0, 'npi', 'Start', '0.0000000', '0.0000000', NULL, 'D508', 'D508 Other iron deficiency anemias', 300, 'diagnosis', 'Start', '0.0000000', '0.0000000', NULL, 150, 'diagnosis', 1),
('1891995221', 'Alice', 0, 'npi', 'Start', '0.0000000', '0.0000000', NULL, 'J0696', 'J0696 Injection, ceftriaxone sodium, per 250 mg', 300, 'procedure', 'Start', '0.0000000', '0.0000000', NULL, 150, 'procedure', 1),
('1972539492', 'Medical Clinic', 200, 'npi', 'Clinic', '29.7725600', '0.0000000', '', '5', 'Health South', 200, 'system', 'Clinic', '0.0000000', '0.0000000', '0', 50, 'Self', 1),
('healthsouth.com', 'healthsouth.com', 200, 'domain', 'System', '0.0000000', '0.0000000', '', '5', 'Health South', 200, 'system', 'System', '0.0000000', '0.0000000', '0', 70, 'Self', 1),
('1114904', 'Magid', 300, 'someid', 'Start', '29.7725600', '0.0000000', '', '1891995', 'Alice', 200, 'npi', 'End', '0.0000000', '0.0000000', '0', 100, 'Referral', 2),
('1114904', 'Magid', 300, 'someid', 'Start', '29.7725600', '0.0000000', '', '7', '77006', 400, 'zipcode', 'Provider Zip Code', '29.7413230', '-95.3910490', '0', 50, 'Practices In', 2),
('1891995', 'Alice', 300, 'someid', 'End', '0.0000000', '0.0000000', '', '7', '77006', 400, 'zipcode', 'Provider Zip Code', '29.7413230', '-95.3910490', '0', 50, 'Practices In', 2),
('1972539', 'Medical Clinic', 0, 'someid', 'Clinic', '0.0000000', '0.0000000', '', '1114904', 'Magid', 200, 'someid', 'Start Provider', '0.0000000', '0.0000000', '0', 400, 'Affiliation', 2),
('1972539', 'Medical Clinic', 200, 'someid', 'Clinic', '0.0000000', '0.0000000', '', '741181532', 'Clinic Tax Num', 200, 'taxnum', 'Clinic', '0.0000000', '0.0000000', '0', 50, 'Self', 2),
('1114904', 'Magid', 0, 'someid', 'Start', '29.7725600', '-95.4009520', NULL, '7135265', '7135265', 0, 'phone', 'Start', '0.0000000', '0.0000000', NULL, 50, 'phone', 2),
('1114904', 'Magid', 0, 'someid', 'Start', '29.7725600', '-95.4009520', NULL, '3923', 'CLIA 01D0299897 ROBERT D TAYLOR MD', 0, 'clia', 'Start', '0.0000000', '0.0000000', NULL, 50, 'clia lab', 2),
('1891995', 'Alice', 0, 'someid', 'Start', '0.0000000', '0.0000000', NULL, 'D508', 'D508 Other iron deficiency anemias', 300, 'diagnosis', 'Start', '0.0000000', '0.0000000', NULL, 150, 'diagnosis', 2),
('1891995', 'Alice', 0, 'someid', 'Start', '0.0000000', '0.0000000', NULL, 'J0696', 'J0696 Injection, ceftriaxone sodium, per 250 mg', 300, 'procedure', 'Start', '0.0000000', '0.0000000', NULL, 150, 'procedure', 2),
('1972539', 'Medical Clinic', 200, 'someid', 'Clinic', '29.7725600', '-95.4009520', '', '5', 'Health South', 200, 'system', 'Clinic', '0.0000000', '0.0000000', '0', 50, 'Self', 2);

-- --------------------------------------------------------

--
-- Table structure for table `shoulderror_group_mismatch`
--

CREATE TABLE `shoulderror_group_mismatch` (
  `source_id` varchar(50) NOT NULL,
  `source_name` varchar(255) NOT NULL,
  `source_size` int(11) NOT NULL DEFAULT 0,
  `source_type` varchar(255) NOT NULL,
  `source_group` varchar(255) NOT NULL,
  `source_longitude` decimal(17,7) NOT NULL DEFAULT 0.0000000,
  `source_latitude` decimal(17,7) NOT NULL DEFAULT 0.0000000,
  `source_img` varchar(255) DEFAULT NULL,
  `target_id` varchar(50) NOT NULL,
  `target_name` varchar(255) NOT NULL,
  `target_size` int(11) NOT NULL DEFAULT 0,
  `target_type` varchar(255) NOT NULL,
  `target_group` varchar(255) NOT NULL,
  `target_longitude` decimal(17,7) NOT NULL DEFAULT 0.0000000,
  `target_latitude` decimal(17,7) NOT NULL DEFAULT 0.0000000,
  `target_img` varchar(255) DEFAULT NULL,
  `weight` int(11) NOT NULL DEFAULT 50,
  `link_type` varchar(255) NOT NULL,
  `query_num` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shoulderror_group_mismatch`
--

INSERT INTO `shoulderror_group_mismatch` (`source_id`, `source_name`, `source_size`, `source_type`, `source_group`, `source_longitude`, `source_latitude`, `source_img`, `target_id`, `target_name`, `target_size`, `target_type`, `target_group`, `target_longitude`, `target_latitude`, `target_img`, `weight`, `link_type`, `query_num`) VALUES
('1114904687', 'Magid', 300, 'npi', 'Start', '0.0000000', '0.0000000', 'https://kyruus-app-static.kyruus.com/providermatch/hm/photos/200/magid-jonathann-1114904687.jpg', '1891995221', 'Alice', 200, 'npi', 'End', '0.0000000', '0.0000000', '0', 100, 'Referral', 1),
('1114904687', 'Magid', 300, 'npi', 'Start', '0.0000000', '0.0000000', 'https://kyruus-app-static.kyruus.com/providermatch/hm/photos/200/magid-jonathann-1114904687.jpg', '7', '77006', 400, 'zipcode', 'Provider Zip Code', '29.7413230', '-95.3910490', '0', 50, 'Practices In', 1),
('1891995221', 'Alice', 300, 'npi', 'End', '0.0000000', '0.0000000', '', '7', '77006', 400, 'zipcode', 'Provider Zip Code', '29.7413230', '-95.3910490', '0', 50, 'Practices In', 1),
('1972539492', 'Medical Clinic', 0, 'npi', 'Clinic', '29.7725600', '-95.4009520', '', '1114904687', 'Magid', 200, 'npi', 'Start Provider', '0.0000000', '0.0000000', '0', 400, 'Affiliation', 1),
('1972539492', 'Medical Clinic', 200, 'npi', 'Clinic', '29.7725600', '-95.4009520', '', '741181532', 'Clinic Tax Num', 200, 'taxnum', 'Clinic', '0.0000000', '0.0000000', 'http://mchllp.com/mch/images/newmchbanner11.JPG', 50, 'Self', 1),
('1114904687', 'Magid', 0, 'npi', 'Starting', '29.7725600', '-95.4009520', NULL, '7135265511', '7135265511', 0, 'phone', 'Start', '0.0000000', '0.0000000', NULL, 50, 'phone', 1),
('1114904687', 'Magid', 0, 'npi', 'Start', '29.7725600', '-95.4009520', NULL, '3923', 'CLIA 01D0299897 ROBERT D TAYLOR MD', 0, 'clia', 'Start', '0.0000000', '0.0000000', NULL, 50, 'clia lab', 1),
('1891995221', 'Alice', 0, 'npi', 'Start', '0.0000000', '0.0000000', NULL, 'D508', 'D508 Other iron deficiency anemias', 300, 'diagnosis', 'Start', '0.0000000', '0.0000000', NULL, 150, 'diagnosis', 1),
('1891995221', 'Alice', 0, 'npi', 'Start', '0.0000000', '0.0000000', NULL, 'J0696', 'J0696 Injection, ceftriaxone sodium, per 250 mg', 300, 'procedure', 'Start', '0.0000000', '0.0000000', NULL, 150, 'procedure', 1),
('1972539492', 'Medical Clinic', 200, 'npi', 'Clinic', '29.7725600', '0.0000000', '', '5', 'Health South', 200, 'system', 'Clinic', '0.0000000', '0.0000000', '0', 50, 'Self', 1),
('healthsouth.com', 'healthsouth.com', 200, 'domain', 'System', '0.0000000', '0.0000000', '', '5', 'Health South', 200, 'system', 'System', '0.0000000', '0.0000000', '0', 70, 'Self', 1),
('1114904', 'Magid', 300, 'someid', 'Start', '29.7725600', '0.0000000', '', '1891995', 'Alice', 200, 'npi', 'End', '0.0000000', '0.0000000', '0', 100, 'Referral', 2),
('1114904', 'Magid', 300, 'someid', 'Start', '29.7725600', '0.0000000', '', '7', '77006', 400, 'zipcode', 'Provider Zip Code', '29.7413230', '-95.3910490', '0', 50, 'Practices In', 2),
('1891995', 'Alice', 300, 'someid', 'End', '0.0000000', '0.0000000', '', '7', '77006', 400, 'zipcode', 'Provider Zip Code', '29.7413230', '-95.3910490', '0', 50, 'Practices In', 2),
('1972539', 'Medical Clinic', 0, 'someid', 'Clinic', '0.0000000', '0.0000000', '', '1114904', 'Magid', 200, 'someid', 'Start Provider', '0.0000000', '0.0000000', '0', 400, 'Affiliation', 2),
('1972539', 'Medical Clinic', 200, 'someid', 'Clinic', '0.0000000', '0.0000000', '', '741181532', 'Clinic Tax Num', 200, 'taxnum', 'Clinic', '0.0000000', '0.0000000', '0', 50, 'Self', 2),
('1114904', 'Magid', 0, 'someid', 'Start', '29.7725600', '-95.4009520', NULL, '7135265', '7135265', 0, 'phone', 'Start', '0.0000000', '0.0000000', NULL, 50, 'phone', 2),
('1114904', 'Magid', 0, 'someid', 'Start', '29.7725600', '-95.4009520', NULL, '3923', 'CLIA 01D0299897 ROBERT D TAYLOR MD', 0, 'clia', 'Start', '0.0000000', '0.0000000', NULL, 50, 'clia lab', 2),
('1891995', 'Alice', 0, 'someid', 'Start', '0.0000000', '0.0000000', NULL, 'D508', 'D508 Other iron deficiency anemias', 300, 'diagnosis', 'Start', '0.0000000', '0.0000000', NULL, 150, 'diagnosis', 2),
('1891995', 'Alice', 0, 'someid', 'Start', '0.0000000', '0.0000000', NULL, 'J0696', 'J0696 Injection, ceftriaxone sodium, per 250 mg', 300, 'procedure', 'Start', '0.0000000', '0.0000000', NULL, 150, 'procedure', 2),
('1972539', 'Medical Clinic', 200, 'someid', 'Clinic', '29.7725600', '-95.4009520', '', '5', 'Health South', 200, 'system', 'Clinic', '0.0000000', '0.0000000', '0', 50, 'Self', 2);

-- --------------------------------------------------------

--
-- Table structure for table `shoulderror_id_name_mismatch`
--

CREATE TABLE `shoulderror_id_name_mismatch` (
  `source_id` varchar(50) NOT NULL,
  `source_name` varchar(255) NOT NULL,
  `source_size` int(11) NOT NULL DEFAULT 0,
  `source_type` varchar(255) NOT NULL,
  `source_group` varchar(255) NOT NULL,
  `source_longitude` decimal(17,7) NOT NULL DEFAULT 0.0000000,
  `source_latitude` decimal(17,7) NOT NULL DEFAULT 0.0000000,
  `source_img` varchar(255) DEFAULT NULL,
  `target_id` varchar(50) NOT NULL,
  `target_name` varchar(255) NOT NULL,
  `target_size` int(11) NOT NULL DEFAULT 0,
  `target_type` varchar(255) NOT NULL,
  `target_group` varchar(255) NOT NULL,
  `target_longitude` decimal(17,7) NOT NULL DEFAULT 0.0000000,
  `target_latitude` decimal(17,7) NOT NULL DEFAULT 0.0000000,
  `target_img` varchar(255) DEFAULT NULL,
  `weight` int(11) NOT NULL DEFAULT 50,
  `link_type` varchar(255) NOT NULL,
  `query_num` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shoulderror_id_name_mismatch`
--

INSERT INTO `shoulderror_id_name_mismatch` (`source_id`, `source_name`, `source_size`, `source_type`, `source_group`, `source_longitude`, `source_latitude`, `source_img`, `target_id`, `target_name`, `target_size`, `target_type`, `target_group`, `target_longitude`, `target_latitude`, `target_img`, `weight`, `link_type`, `query_num`) VALUES
('1114904687', 'Magid', 300, 'npi', 'Start', '0.0000000', '0.0000000', 'https://kyruus-app-static.kyruus.com/providermatch/hm/photos/200/magid-jonathann-1114904687.jpg', '1891995221', 'Alice', 200, 'npi', 'End', '0.0000000', '0.0000000', '0', 100, 'Referral', 1),
('1114904687', 'Dr. Magid', 300, 'npi', 'Start', '0.0000000', '0.0000000', 'https://kyruus-app-static.kyruus.com/providermatch/hm/photos/200/magid-jonathann-1114904687.jpg', '7', '77006', 400, 'zipcode', 'Provider Zip Code', '29.7413230', '-95.3910490', '0', 50, 'Practices In', 1),
('1891995221', 'Alice', 300, 'npi', 'End', '0.0000000', '0.0000000', '', '7', '77006', 400, 'zipcode', 'Provider Zip Code', '29.7413230', '-95.3910490', '0', 50, 'Practices In', 1),
('1972539492', 'Medical Clinic', 0, 'npi', 'Clinic', '29.7725600', '-95.4009520', '', '1114904687', 'Magid', 200, 'npi', 'Start Provider', '0.0000000', '0.0000000', '0', 400, 'Affiliation', 1),
('1972539492', 'Medical Clinic', 200, 'npi', 'Clinic', '29.7725600', '-95.4009520', '', '741181532', 'Clinic Tax Num', 200, 'taxnum', 'Clinic', '0.0000000', '0.0000000', 'http://mchllp.com/mch/images/newmchbanner11.JPG', 50, 'Self', 1),
('1114904687', 'Magid', 0, 'npi', 'Start', '29.7725600', '-95.4009520', NULL, '7135265511', '7135265511', 0, 'phone', 'Start', '0.0000000', '0.0000000', NULL, 50, 'phone', 1),
('1114904687', 'Magid', 0, 'npi', 'Start', '29.7725600', '-95.4009520', NULL, '3923', 'CLIA 01D0299897 ROBERT D TAYLOR MD', 0, 'clia', 'Start', '0.0000000', '0.0000000', NULL, 50, 'clia lab', 1),
('1891995221', 'Alice', 0, 'npi', 'Start', '0.0000000', '0.0000000', NULL, 'D508', 'D508 Other iron deficiency anemias', 300, 'diagnosis', 'Start', '0.0000000', '0.0000000', NULL, 150, 'diagnosis', 1),
('1891995221', 'Alice', 0, 'npi', 'Start', '0.0000000', '0.0000000', NULL, 'J0696', 'J0696 Injection, ceftriaxone sodium, per 250 mg', 300, 'procedure', 'Start', '0.0000000', '0.0000000', NULL, 150, 'procedure', 1),
('1972539492', 'Medical Clinic', 200, 'npi', 'Clinic', '29.7725600', '0.0000000', '', '5', 'Health South', 200, 'system', 'Clinic', '0.0000000', '0.0000000', '0', 50, 'Self', 1),
('healthsouth.com', 'healthsouth.com', 200, 'domain', 'System', '0.0000000', '0.0000000', '', '5', 'Health South', 200, 'system', 'System', '0.0000000', '0.0000000', '0', 70, 'Self', 1),
('1114904', 'Magid', 300, 'someid', 'Start', '29.7725600', '0.0000000', '', '1891995', 'Alice', 200, 'npi', 'End', '0.0000000', '0.0000000', '0', 100, 'Referral', 2),
('1114904', 'Magid', 300, 'someid', 'Start', '29.7725600', '0.0000000', '', '7', '77006', 400, 'zipcode', 'Provider Zip Code', '29.7413230', '-95.3910490', '0', 50, 'Practices In', 2),
('1891995', 'Alice', 300, 'someid', 'End', '0.0000000', '0.0000000', '', '7', '77006', 400, 'zipcode', 'Provider Zip Code', '29.7413230', '-95.3910490', '0', 50, 'Practices In', 2),
('1972539', 'Medical Clinic', 0, 'someid', 'Clinic', '0.0000000', '0.0000000', '', '1114904', 'Magid', 200, 'someid', 'Start Provider', '0.0000000', '0.0000000', '0', 400, 'Affiliation', 2),
('1972539', 'Medical Clinic', 200, 'someid', 'Clinic', '0.0000000', '0.0000000', '', '741181532', 'Clinic Tax Num', 200, 'taxnum', 'Clinic', '0.0000000', '0.0000000', '0', 50, 'Self', 2),
('1114904', 'Magid', 0, 'someid', 'Start', '29.7725600', '-95.4009520', NULL, '7135265', '7135265', 0, 'phone', 'Start', '0.0000000', '0.0000000', NULL, 50, 'phone', 2),
('1114904', 'Magid', 0, 'someid', 'Start', '29.7725600', '-95.4009520', NULL, '3923', 'CLIA 01D0299897 ROBERT D TAYLOR MD', 0, 'clia', 'Start', '0.0000000', '0.0000000', NULL, 50, 'clia lab', 2),
('1891995', 'Alice', 0, 'someid', 'Start', '0.0000000', '0.0000000', NULL, 'D508', 'D508 Other iron deficiency anemias', 300, 'diagnosis', 'Start', '0.0000000', '0.0000000', NULL, 150, 'diagnosis', 2),
('1891995', 'Alice', 0, 'someid', 'Start', '0.0000000', '0.0000000', NULL, 'J0696', 'J0696 Injection, ceftriaxone sodium, per 250 mg', 300, 'procedure', 'Start', '0.0000000', '0.0000000', NULL, 150, 'procedure', 2),
('1972539', 'Medical Clinic', 200, 'someid', 'Clinic', '29.7725600', '-95.4009520', '', '5', 'Health South', 200, 'system', 'Clinic', '0.0000000', '0.0000000', '0', 50, 'Self', 2);

-- --------------------------------------------------------

--
-- Table structure for table `shoulderror_type_mismatch`
--

CREATE TABLE `shoulderror_type_mismatch` (
  `source_id` varchar(50) NOT NULL,
  `source_name` varchar(255) NOT NULL,
  `source_size` int(11) NOT NULL DEFAULT 0,
  `source_type` varchar(255) NOT NULL,
  `source_group` varchar(255) NOT NULL,
  `source_longitude` decimal(17,7) NOT NULL DEFAULT 0.0000000,
  `source_latitude` decimal(17,7) NOT NULL DEFAULT 0.0000000,
  `source_img` varchar(255) DEFAULT NULL,
  `target_id` varchar(50) NOT NULL,
  `target_name` varchar(255) NOT NULL,
  `target_size` int(11) NOT NULL DEFAULT 0,
  `target_type` varchar(255) NOT NULL,
  `target_group` varchar(255) NOT NULL,
  `target_longitude` decimal(17,7) NOT NULL DEFAULT 0.0000000,
  `target_latitude` decimal(17,7) NOT NULL DEFAULT 0.0000000,
  `target_img` varchar(255) DEFAULT NULL,
  `weight` int(11) NOT NULL DEFAULT 50,
  `link_type` varchar(255) NOT NULL,
  `query_num` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shoulderror_type_mismatch`
--

INSERT INTO `shoulderror_type_mismatch` (`source_id`, `source_name`, `source_size`, `source_type`, `source_group`, `source_longitude`, `source_latitude`, `source_img`, `target_id`, `target_name`, `target_size`, `target_type`, `target_group`, `target_longitude`, `target_latitude`, `target_img`, `weight`, `link_type`, `query_num`) VALUES
('1114904687', 'Magid', 300, 'npi', 'Start', '0.0000000', '0.0000000', 'https://kyruus-app-static.kyruus.com/providermatch/hm/photos/200/magid-jonathann-1114904687.jpg', '1891995221', 'Alice', 200, 'npi', 'End', '0.0000000', '0.0000000', '0', 100, 'Referral', 1),
('1114904687', 'Magid', 300, 'notnpi', 'Start', '0.0000000', '0.0000000', 'https://kyruus-app-static.kyruus.com/providermatch/hm/photos/200/magid-jonathann-1114904687.jpg', '7', '77006', 400, 'zipcode', 'Provider Zip Code', '29.7413230', '-95.3910490', '0', 50, 'Practices In', 1),
('1891995221', 'Alice', 300, 'npi', 'End', '0.0000000', '0.0000000', '', '7', '77006', 400, 'zipcode', 'Provider Zip Code', '29.7413230', '-95.3910490', '0', 50, 'Practices In', 1),
('1972539492', 'Medical Clinic', 0, 'npi', 'Clinic', '29.7725600', '-95.4009520', '', '1114904687', 'Magid', 200, 'npi', 'Start Provider', '0.0000000', '0.0000000', '0', 400, 'Affiliation', 1),
('1972539492', 'Medical Clinic', 200, 'npi', 'Clinic', '29.7725600', '-95.4009520', '', '741181532', 'Clinic Tax Num', 200, 'taxnum', 'Clinic', '0.0000000', '0.0000000', 'http://mchllp.com/mch/images/newmchbanner11.JPG', 50, 'Self', 1),
('1114904687', 'Magid', 0, 'npi', 'Start', '29.7725600', '-95.4009520', NULL, '7135265511', '7135265511', 0, 'phone', 'Start', '0.0000000', '0.0000000', NULL, 50, 'phone', 1),
('1114904687', 'Magid', 0, 'npi', 'Start', '29.7725600', '-95.4009520', NULL, '3923', 'CLIA 01D0299897 ROBERT D TAYLOR MD', 0, 'clia', 'Start', '0.0000000', '0.0000000', NULL, 50, 'clia lab', 1),
('1891995221', 'Alice', 0, 'npi', 'Start', '0.0000000', '0.0000000', NULL, 'D508', 'D508 Other iron deficiency anemias', 300, 'diagnosis', 'Start', '0.0000000', '0.0000000', NULL, 150, 'diagnosis', 1),
('1891995221', 'Alice', 0, 'npi', 'Start', '0.0000000', '0.0000000', NULL, 'J0696', 'J0696 Injection, ceftriaxone sodium, per 250 mg', 300, 'procedure', 'Start', '0.0000000', '0.0000000', NULL, 150, 'procedure', 1),
('1972539492', 'Medical Clinic', 200, 'npi', 'Clinic', '29.7725600', '0.0000000', '', '5', 'Health South', 200, 'system', 'Clinic', '0.0000000', '0.0000000', '0', 50, 'Self', 1),
('healthsouth.com', 'healthsouth.com', 200, 'domain', 'System', '0.0000000', '0.0000000', '', '5', 'Health South', 200, 'system', 'System', '0.0000000', '0.0000000', '0', 70, 'Self', 1),
('1114904', 'Magid', 300, 'someid', 'Start', '29.7725600', '0.0000000', '', '1891995', 'Alice', 200, 'npi', 'End', '0.0000000', '0.0000000', '0', 100, 'Referral', 2),
('1114904', 'Magid', 300, 'someid', 'Start', '29.7725600', '0.0000000', '', '7', '77006', 400, 'zipcode', 'Provider Zip Code', '29.7413230', '-95.3910490', '0', 50, 'Practices In', 2),
('1891995', 'Alice', 300, 'someid', 'End', '0.0000000', '0.0000000', '', '7', '77006', 400, 'zipcode', 'Provider Zip Code', '29.7413230', '-95.3910490', '0', 50, 'Practices In', 2),
('1972539', 'Medical Clinic', 0, 'someid', 'Clinic', '0.0000000', '0.0000000', '', '1114904', 'Magid', 200, 'someid', 'Start Provider', '0.0000000', '0.0000000', '0', 400, 'Affiliation', 2),
('1972539', 'Medical Clinic', 200, 'someid', 'Clinic', '0.0000000', '0.0000000', '', '741181532', 'Clinic Tax Num', 200, 'taxnum', 'Clinic', '0.0000000', '0.0000000', '0', 50, 'Self', 2),
('1114904', 'Magid', 0, 'someid', 'Start', '29.7725600', '-95.4009520', NULL, '7135265', '7135265', 0, 'phone', 'Start', '0.0000000', '0.0000000', NULL, 50, 'phone', 2),
('1114904', 'Magid', 0, 'someid', 'Start', '29.7725600', '-95.4009520', NULL, '3923', 'CLIA 01D0299897 ROBERT D TAYLOR MD', 0, 'clia', 'Start', '0.0000000', '0.0000000', NULL, 50, 'clia lab', 2),
('1891995', 'Alice', 0, 'someid', 'Start', '0.0000000', '0.0000000', NULL, 'D508', 'D508 Other iron deficiency anemias', 300, 'diagnosis', 'Start', '0.0000000', '0.0000000', NULL, 150, 'diagnosis', 2),
('1891995', 'Alice', 0, 'someid', 'Start', '0.0000000', '0.0000000', NULL, 'J0696', 'J0696 Injection, ceftriaxone sodium, per 250 mg', 300, 'procedure', 'Start', '0.0000000', '0.0000000', NULL, 150, 'procedure', 2),
('1972539', 'Medical Clinic', 200, 'someid', 'Clinic', '29.7725600', '-95.4009520', '', '5', 'Health South', 200, 'system', 'Clinic', '0.0000000', '0.0000000', '0', 50, 'Self', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `graphdata_nodetypetests`
--
ALTER TABLE `graphdata_nodetypetests`
  ADD PRIMARY KEY (`source_id`,`source_type`,`target_id`,`target_type`);

--
-- Indexes for table `shoulderror_different_latlon`
--
ALTER TABLE `shoulderror_different_latlon`
  ADD UNIQUE KEY `source_id` (`source_id`,`target_id`);

--
-- Indexes for table `shoulderror_group_mismatch`
--
ALTER TABLE `shoulderror_group_mismatch`
  ADD UNIQUE KEY `source_id` (`source_id`,`target_id`);

--
-- Indexes for table `shoulderror_id_name_mismatch`
--
ALTER TABLE `shoulderror_id_name_mismatch`
  ADD UNIQUE KEY `source_id` (`source_id`,`target_id`);

--
-- Indexes for table `shoulderror_type_mismatch`
--
ALTER TABLE `shoulderror_type_mismatch`
  ADD UNIQUE KEY `source_id` (`source_id`,`target_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

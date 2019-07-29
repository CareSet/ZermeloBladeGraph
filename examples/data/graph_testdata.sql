-- MySQL dump 10.16  Distrib 10.2.22-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: testdata
-- ------------------------------------------------------
-- Server version	10.2.22-MariaDB-10.2.22+maria~xenial-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `graphdata_nodetypetests`
--

DROP TABLE IF EXISTS `graphdata_nodetypetests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
  `target_img` int(11) DEFAULT NULL,
  `weight` int(11) NOT NULL DEFAULT 50,
  `link_type` varchar(255) NOT NULL,
  `query_num` int(11) NOT NULL,
  PRIMARY KEY (`source_id`,`source_type`,`target_id`,`target_type`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `graphdata_nodetypetests`
--

LOCK TABLES `graphdata_nodetypetests` WRITE;
/*!40000 ALTER TABLE `graphdata_nodetypetests` DISABLE KEYS */;
INSERT INTO `graphdata_nodetypetests` VALUES ('1114904687','Magid',300,'npi','Provider',0.0000000,0.0000000,NULL,'1891995221','Alice',200,'npi','Provider',0.0000000,0.0000000,NULL,100,'Referral',1),('1114904687','Magid',300,'npi','Provider',0.0000000,0.0000000,NULL,'7','77006',400,'zipcode','Provider Zip Code',0.0000000,0.0000000,NULL,50,'Practices In',1),('1891995221','Alice',300,'npi','Provider',0.0000000,0.0000000,NULL,'7','77006',400,'zipcode','Provider Zip Code',0.0000000,0.0000000,NULL,50,'Practices In',1),('1972539492','Medical Clinic',0,'npi','Clinic',0.0000000,0.0000000,NULL,'1114904687','Magid',200,'npi','Provider',0.0000000,0.0000000,NULL,400,'Affiliation',1),('1972539492','Medical Clinic',200,'npi','Clinic',0.0000000,0.0000000,NULL,'741181532','Clinic Tax Num',200,'taxnum','Taxnum',0.0000000,0.0000000,NULL,50,'Self',1),('1114904687','Magid',0,'npi','Provider',0.0000000,0.0000000,NULL,'7135265511','7135265511',0,'phone','Phone',0.0000000,0.0000000,NULL,50,'phone',1),('1114904687','Magid',0,'npi','Provider',0.0000000,0.0000000,NULL,'3923','CLIA 01D0299897 ROBERT D TAYLOR MD',0,'clia','Laboratory',0.0000000,0.0000000,NULL,50,'clia lab',1),('1891995221','Alice',0,'npi','Provider',0.0000000,0.0000000,NULL,'D508','D508 Other iron deficiency anemias',300,'diagnosis','Diagnosis',0.0000000,0.0000000,NULL,150,'diagnosis',1),('1891995221','Alice',0,'npi','Provider',0.0000000,0.0000000,NULL,'J0696','J0696 Injection, ceftriaxone sodium, per 250 mg',300,'procedure','Procedure',0.0000000,0.0000000,NULL,150,'procedure',1),('1972539492','Medical Clinic',200,'npi','Clinic',0.0000000,0.0000000,NULL,'5','Health South',200,'system','System',0.0000000,0.0000000,NULL,50,'Self',1),('healthsouth.com','healthsouth.com',200,'domain','Website',0.0000000,0.0000000,NULL,'5','Health South',200,'system','System',0.0000000,0.0000000,NULL,70,'Self',1),('1114904','Magid',300,'npi','Provider',0.0000000,0.0000000,NULL,'1891995','Alice',200,'npi','Provider',0.0000000,0.0000000,NULL,100,'Referral',2),('1114904','Magid',300,'npi','Provider',0.0000000,0.0000000,NULL,'7','77006',400,'zipcode','Provider Zip Code',0.0000000,0.0000000,NULL,50,'Practices In',2),('1891995','Alice',300,'npi','Provider',0.0000000,0.0000000,NULL,'7','77006',400,'zipcode','Provider Zip Code',0.0000000,0.0000000,NULL,50,'Practices In',2),('1972539','Medical Clinic',0,'npi','Clinic',0.0000000,0.0000000,NULL,'1114904','Magid',200,'npi','Provider',0.0000000,0.0000000,NULL,400,'Affiliation',2),('1972539','Medical Clinic',200,'npi','Clinic',0.0000000,0.0000000,NULL,'741181532','Clinic Tax Num',200,'taxnum','Taxnum',0.0000000,0.0000000,NULL,50,'Self',2),('1114904','Magid',0,'npi','Provider',0.0000000,0.0000000,NULL,'7135265','7135265',0,'phone','Phone',0.0000000,0.0000000,NULL,50,'phone',2),('1114904','Magid',0,'npi','Provider',0.0000000,0.0000000,NULL,'3923','CLIA 01D0299897 ROBERT D TAYLOR MD',0,'clia','Laboratory',0.0000000,0.0000000,NULL,50,'clia lab',2),('1891995','Alice',0,'npi','Provider',0.0000000,0.0000000,NULL,'D508','D508 Other iron deficiency anemias',300,'diagnosis','Diagnosis',0.0000000,0.0000000,NULL,150,'diagnosis',2),('1891995','Alice',0,'npi','Provider',0.0000000,0.0000000,NULL,'J0696','J0696 Injection, ceftriaxone sodium, per 250 mg',300,'procedure','Procedure',0.0000000,0.0000000,NULL,150,'procedure',2),('1972539','Medical Clinic',200,'npi','Clinic',0.0000000,0.0000000,NULL,'5','Health South',200,'system','System',0.0000000,0.0000000,NULL,50,'Self',2);
/*!40000 ALTER TABLE `graphdata_nodetypetests` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-07-28 21:46:25

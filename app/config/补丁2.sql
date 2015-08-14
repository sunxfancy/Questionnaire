CREATE DATABASE  IF NOT EXISTS `questionnaire` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `questionnaire`;
-- MySQL dump 10.13  Distrib 5.5.44, for debian-linux-gnu (x86_64)
--
-- Host: 127.0.0.1    Database: questionnaire
-- ------------------------------------------------------
-- Server version	5.5.44-0ubuntu0.14.04.1

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
-- Table structure for table `examinee`
--

DROP TABLE IF EXISTS `examinee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `examinee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` varchar(45) NOT NULL COMMENT '被试人员编号，等同username',
  `password` varchar(256) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `other` text COMMENT '其他内容，存成json字符串',
  `sex` tinyint(1) DEFAULT NULL,
  `native` varchar(200) DEFAULT NULL COMMENT '籍贯',
  `education` varchar(200) DEFAULT NULL COMMENT '学历',
  `politics` varchar(200) DEFAULT NULL COMMENT '政治面貌',
  `professional` varchar(200) DEFAULT NULL COMMENT '职称',
  `degree` varchar(200) DEFAULT NULL COMMENT '学位',
  `employer` varchar(200) DEFAULT NULL COMMENT '工作单位',
  `unit` varchar(200) DEFAULT NULL COMMENT '部门',
  `team` varchar(200) DEFAULT NULL COMMENT '班子/系统成员',
  `duty` varchar(200) DEFAULT NULL COMMENT '职务',
  `project_id` int(11) NOT NULL COMMENT '所属项目id',
  `birthday` date DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `is_exam_com` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`number`),
  KEY `index3` (`project_id`),
  CONSTRAINT `fk_examinee_1` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `examinee`
--

LOCK TABLES `examinee` WRITE;
/*!40000 ALTER TABLE `examinee` DISABLE KEYS */;
INSERT INTO `examinee` VALUES (12,'15010001','efxonl','孙西风','{\"education\":[],\"work\":[]}',1,'河北','大本','群众',NULL,NULL,'','',NULL,'',1,'1993-11-12',NULL,0),(13,'15010002','2oumzy','孙西风','{\"education\":[],\"work\":[]}',1,'河北','大本','群众',NULL,NULL,'','',NULL,'',1,'1993-11-12',NULL,0),(14,'15010003','0mzg2o','孙西风','{\"education\":[],\"work\":[]}',1,'河北','大本','群众',NULL,NULL,'','',NULL,'',1,'1993-11-12',NULL,0),(15,'15010004','zkxvjb','孙西风','{\"education\":[],\"work\":[]}',1,'河北','大本','群众',NULL,NULL,'','',NULL,'',1,'1993-11-12',NULL,0);
/*!40000 ALTER TABLE `examinee` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-08-14  9:28:58

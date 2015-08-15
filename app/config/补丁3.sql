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
-- Table structure for table `index`
--

DROP TABLE IF EXISTS `index`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `index` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL COMMENT '指标名',
  `father_index` int(11) DEFAULT NULL COMMENT '父指标id，计算时会使用',
  `module_id` int(11) DEFAULT NULL COMMENT '模块id',
  `children` varchar(2000) DEFAULT NULL COMMENT '下级内容，用逗号分隔',
  `children_type` varchar(1000) DEFAULT NULL COMMENT '下级内容的类型，是index还是factor',
  `chs_name` varchar(45) DEFAULT NULL COMMENT '中文名字，导出报告时使用',
  `ans_do` varchar(1000) DEFAULT NULL COMMENT '结尾动作函数',
  `action` varchar(1000) DEFAULT NULL COMMENT '动作函数名',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`),
  KEY `index2` (`father_index`),
  KEY `index3` (`module_id`),
  CONSTRAINT `fk_index_1` FOREIGN KEY (`father_index`) REFERENCES `index` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `fk_index_2` FOREIGN KEY (`module_id`) REFERENCES `module` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `factor`
--

DROP TABLE IF EXISTS `factor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `factor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `factor` double DEFAULT NULL COMMENT '因子系数，并未使用，暂时保留',
  `father_factor` int(11) DEFAULT NULL COMMENT '父因子id，在不存在时为空',
  `paper_id` int(11) DEFAULT NULL COMMENT '所属试卷id',
  `children` varchar(2000) DEFAULT NULL COMMENT '下级内容\n',
  `children_type` varchar(1000) DEFAULT NULL COMMENT '下级内容的类型，是factor还是question',
  `action` varchar(1000) DEFAULT NULL COMMENT '动作函数',
  `ans_do` varchar(1000) DEFAULT NULL COMMENT '结尾动作函数',
  `chabiao` varchar(1000) DEFAULT NULL COMMENT '查询常模转换表',
  `chs_name` varchar(45) DEFAULT NULL COMMENT '中文名字，导出报告时使用',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`),
  KEY `index2` (`father_factor`),
  KEY `index4` (`paper_id`),
  CONSTRAINT `fk_factor_1` FOREIGN KEY (`father_factor`) REFERENCES `factor` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=141 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-08-15 11:42:52

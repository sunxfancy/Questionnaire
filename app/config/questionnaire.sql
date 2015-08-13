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
  ` professional` varchar(200) DEFAULT NULL COMMENT '职称',
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
  `children_type` varchar(45) DEFAULT NULL COMMENT '下级内容的类型，是factor还是question',
  `action` varchar(1000) DEFAULT NULL COMMENT '动作函数',
  `ans_do` varchar(1000) DEFAULT NULL COMMENT '结尾动作函数',
  `chabiao` varchar(1000) DEFAULT NULL COMMENT '查询常模转换表',
  `chs_name` varchar(45) DEFAULT NULL COMMENT '中文名字，导出报告时使用',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`),
  KEY `index2` (`father_factor`),
  KEY `index4` (`paper_id`),
  CONSTRAINT `fk_factor_1` FOREIGN KEY (`father_factor`) REFERENCES `factor` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `factor`
--

LOCK TABLES `factor` WRITE;
/*!40000 ALTER TABLE `factor` DISABLE KEYS */;
INSERT INTO `factor` VALUES (55,'lqx',NULL,NULL,NULL,'3,26,27,51,52,76,101,126,151,176','','sum',NULL,NULL,NULL),(56,'syyjl',NULL,NULL,NULL,'hyx,ylx,jzx,wdx,gwx,zlx','','38+2*hyx+3*ylx+4*jzx-(2*wdx+2*gwx+2*zlx))/10',NULL,NULL,NULL),(57,'cznl',NULL,NULL,NULL,'chx,yhx,zlx,xfx','','chx+yhx+zlx+(11-xfx)',NULL,NULL,NULL),(58,'cjxy',NULL,NULL,NULL,NULL,NULL,'sum',NULL,NULL,NULL),(59,'obse',NULL,NULL,NULL,'3,9,10,28,38,45,46,51,55,65','','avg',NULL,NULL,NULL),(60,'sjz',NULL,NULL,NULL,'3,7,12,15,19,23,27,31,35,39,43,47,51,57,59,63,67,69,73,74,77,78,82,86','','sum',NULL,NULL,NULL);
/*!40000 ALTER TABLE `factor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `factor_ans`
--

DROP TABLE IF EXISTS `factor_ans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `factor_ans` (
  `score` int(11) DEFAULT NULL COMMENT '因子得分',
  `std_score` int(11) DEFAULT NULL COMMENT '因子标准分',
  `examinee_id` int(11) NOT NULL COMMENT '被试人员id，并非编号',
  `factor_id` int(11) NOT NULL COMMENT '所属因子id',
  `ans_score` int(11) DEFAULT NULL,
  PRIMARY KEY (`examinee_id`,`factor_id`),
  KEY `fk_factor_ans_2_idx` (`factor_id`),
  CONSTRAINT `fk_factor_ans_1` FOREIGN KEY (`examinee_id`) REFERENCES `examinee` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_factor_ans_2` FOREIGN KEY (`factor_id`) REFERENCES `factor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `factor_ans`
--

LOCK TABLES `factor_ans` WRITE;
/*!40000 ALTER TABLE `factor_ans` DISABLE KEYS */;
/*!40000 ALTER TABLE `factor_ans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `firel`
--

DROP TABLE IF EXISTS `firel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `firel` (
  `factor_id` int(11) NOT NULL,
  `index_id` int(11) NOT NULL,
  PRIMARY KEY (`factor_id`,`index_id`),
  KEY `fk_firel_2_idx` (`index_id`),
  CONSTRAINT `fk_firel_1` FOREIGN KEY (`factor_id`) REFERENCES `factor` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_firel_2` FOREIGN KEY (`index_id`) REFERENCES `index` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `firel`
--

LOCK TABLES `firel` WRITE;
/*!40000 ALTER TABLE `firel` DISABLE KEYS */;
/*!40000 ALTER TABLE `firel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fqrel`
--

DROP TABLE IF EXISTS `fqrel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fqrel` (
  `factor_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  PRIMARY KEY (`factor_id`,`question_id`),
  KEY `fk_fqrel_2_idx` (`question_id`),
  CONSTRAINT `fk_fqrel_1` FOREIGN KEY (`factor_id`) REFERENCES `factor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_fqrel_2` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fqrel`
--

LOCK TABLES `fqrel` WRITE;
/*!40000 ALTER TABLE `fqrel` DISABLE KEYS */;
/*!40000 ALTER TABLE `fqrel` ENABLE KEYS */;
UNLOCK TABLES;

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
  `children_type` varchar(45) DEFAULT NULL COMMENT '下级内容的类型，是index还是factor',
  `chs_name` varchar(45) DEFAULT NULL COMMENT '中文名字，导出报告时使用',
  `ans_do` varchar(1000) DEFAULT NULL COMMENT '结尾动作函数',
  `action` varchar(1000) DEFAULT NULL COMMENT '动作函数名',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`),
  KEY `index2` (`father_index`),
  KEY `index3` (`module_id`),
  CONSTRAINT `fk_index_2` FOREIGN KEY (`module_id`) REFERENCES `module` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_index_1` FOREIGN KEY (`father_index`) REFERENCES `index` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `index`
--

LOCK TABLES `index` WRITE;
/*!40000 ALTER TABLE `index` DISABLE KEYS */;
INSERT INTO `index` VALUES (1,'ldnl',NULL,NULL,'pdyjcnl,zznl,cxnl,ybnl,dlgznl','',NULL,NULL,'(2*(pdyjcnl + zznl) + cxnl + ybnl + dlgznl)/7');
/*!40000 ALTER TABLE `index` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `index_ans`
--

DROP TABLE IF EXISTS `index_ans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `index_ans` (
  `score` int(11) DEFAULT NULL COMMENT '指标最终得分\n',
  `index_id` int(11) NOT NULL COMMENT '指标id',
  `examinee_id` int(11) NOT NULL COMMENT '被试人员id，并非编号',
  PRIMARY KEY (`index_id`,`examinee_id`),
  KEY `fk_index_ans_1_idx` (`examinee_id`),
  KEY `fk_index_ans_2_idx` (`index_id`),
  CONSTRAINT `fk_index_ans_1` FOREIGN KEY (`examinee_id`) REFERENCES `examinee` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_index_ans_2` FOREIGN KEY (`index_id`) REFERENCES `index` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `index_ans`
--

LOCK TABLES `index_ans` WRITE;
/*!40000 ALTER TABLE `index_ans` DISABLE KEYS */;
/*!40000 ALTER TABLE `index_ans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inquery`
--

DROP TABLE IF EXISTS `inquery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inquery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) DEFAULT NULL COMMENT '所属项目id',
  `description` text COMMENT '指导语',
  PRIMARY KEY (`id`),
  UNIQUE KEY `project_id_UNIQUE` (`project_id`),
  CONSTRAINT `fk_inquery_1` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inquery`
--

LOCK TABLES `inquery` WRITE;
/*!40000 ALTER TABLE `inquery` DISABLE KEYS */;
/*!40000 ALTER TABLE `inquery` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inquery_ans`
--

DROP TABLE IF EXISTS `inquery_ans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inquery_ans` (
  `inquery_id` int(11) NOT NULL,
  `examinee_id` int(11) NOT NULL,
  `option` text,
  PRIMARY KEY (`inquery_id`,`examinee_id`),
  KEY `fk_inquery_ans_2_idx` (`examinee_id`),
  CONSTRAINT `fk_inquery_ans_1` FOREIGN KEY (`inquery_id`) REFERENCES `inquery` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_inquery_ans_2` FOREIGN KEY (`examinee_id`) REFERENCES `examinee` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inquery_ans`
--

LOCK TABLES `inquery_ans` WRITE;
/*!40000 ALTER TABLE `inquery_ans` DISABLE KEYS */;
/*!40000 ALTER TABLE `inquery_ans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inquery_question`
--

DROP TABLE IF EXISTS `inquery_question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inquery_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `topic` text COMMENT '题目描述',
  `options` text,
  `is_radio` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inquery_question`
--

LOCK TABLES `inquery_question` WRITE;
/*!40000 ALTER TABLE `inquery_question` DISABLE KEYS */;
/*!40000 ALTER TABLE `inquery_question` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `interview`
--

DROP TABLE IF EXISTS `interview`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `interview` (
  `advantage` text COMMENT '5条优势',
  `disadvantage` text COMMENT '3条劣势',
  `remark` text COMMENT '评语',
  `manager_id` int(11) NOT NULL,
  `examinee_id` int(11) NOT NULL,
  PRIMARY KEY (`manager_id`,`examinee_id`),
  KEY `fk_interview_2_idx` (`examinee_id`),
  CONSTRAINT `fk_interview_1` FOREIGN KEY (`manager_id`) REFERENCES `manager` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_interview_2` FOREIGN KEY (`examinee_id`) REFERENCES `examinee` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `interview`
--

LOCK TABLES `interview` WRITE;
/*!40000 ALTER TABLE `interview` DISABLE KEYS */;
/*!40000 ALTER TABLE `interview` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ksdf`
--

DROP TABLE IF EXISTS `ksdf`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ksdf` (
  `TH` varchar(255) DEFAULT NULL,
  `F1` varchar(255) DEFAULT NULL,
  `F2` varchar(255) DEFAULT NULL,
  `F3` varchar(255) DEFAULT NULL,
  `XZXS` varchar(255) DEFAULT NULL,
  `WX1` varchar(255) DEFAULT NULL,
  `WY1` varchar(255) DEFAULT NULL,
  `WX2` varchar(255) DEFAULT NULL,
  `WY2` varchar(255) DEFAULT NULL,
  `TMX` varchar(255) DEFAULT NULL,
  `TMY` varchar(255) DEFAULT NULL,
  `XZX` varchar(255) DEFAULT NULL,
  `XZY` varchar(255) DEFAULT NULL,
  `TMHK` varchar(255) DEFAULT NULL,
  `XZ` varchar(255) DEFAULT NULL,
  `FLAG` varchar(255) DEFAULT NULL,
  `COLOR1` varchar(255) DEFAULT NULL,
  `COLOR2` varchar(255) DEFAULT NULL,
  `YZ` varchar(255) DEFAULT NULL,
  `A` varchar(255) DEFAULT NULL,
  `B` varchar(255) DEFAULT NULL,
  `C` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ksdf`
--

LOCK TABLES `ksdf` WRITE;
/*!40000 ALTER TABLE `ksdf` DISABLE KEYS */;
INSERT INTO `ksdf` VALUES ('1','A','B','C','3','12','5','21','70','14','18','16','18','46','A','0','W+/B','N+/W+','','0','0','0'),('2','A','B','C','3','12','5','21','70','14','18','16','18','46','C','0','W+/B','N+/W+','','0','0','0'),('3','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','A','2','1','0'),('4','A','B','C','3','12','5','21','70','14','18','16','18','46','A','0','W+/B','N+/W+','C','2','1','0'),('5','A','B','C','3','12','5','21','70','14','18','16','18','46','C','0','W+/B','N+/W+','C','0','1','2'),('6','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','E','0','1','2'),('7','A','B','C','3','12','5','21','70','14','18','16','18','46','A','0','W+/B','N+/W+','E','2','1','0'),('8','A','B','C','3','12','5','21','70','14','18','16','18','46','C','0','W+/B','N+/W+','F','0','1','2'),('9','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','G','0','1','2'),('10','A','B','C','3','12','5','21','70','14','18','16','18','46','A','0','W+/B','N+/W+','H','2','1','0'),('11','A','B','C','3','12','5','21','70','14','18','16','18','46','C','0','W+/B','N+/W+','I','0','1','2'),('12','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','I','0','1','2'),('13','A','B','C','3','12','5','21','70','14','18','16','18','46','A','0','W+/B','N+/W+','L','2','1','0'),('14','A','B','C','3','12','5','21','70','14','18','16','18','46','C','0','W+/B','N+/W+','M','0','1','2'),('15','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','M','0','1','2'),('16','A','B','C','3','12','5','21','70','14','18','16','18','46','A','0','W+/B','N+/W+','N','0','1','2'),('17','A','B','C','3','12','5','21','70','14','18','16','18','46','C','0','W+/B','N+/W+','N','2','1','0'),('18','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','O','2','1','0'),('19','A','B','C','3','12','5','21','70','14','18','16','18','46','A','0','W+/B','N+/W+','O','0','1','2'),('20','A','B','C','3','12','5','21','70','14','18','16','18','46','C','0','W+/B','N+/W+','Q1','2','1','0'),('21','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','Q1','2','1','0'),('22','A','B','C','3','12','5','21','70','14','18','16','18','46','A','0','W+/B','N+/W+','Q2','0','1','2'),('23','A','B','C','3','12','5','21','70','14','18','16','18','46','C','0','W+/B','N+/W+','Q3','0','1','2'),('24','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','Q3','0','1','2'),('25','A','B','C','3','12','5','21','70','14','18','16','18','46','A','0','W+/B','N+/W+','Q4','2','1','0'),('26','A','B','C','3','12','5','21','70','14','18','16','18','46','C','0','W+/B','N+/W+','A','0','1','2'),('27','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','A','0','1','2'),('28','A','B','C','3','12','5','21','70','14','18','16','18','46','A','0','W+/B','N+/W+','B','0','1','0'),('29','A','B','C','3','12','5','21','70','14','18','16','18','46','C','0','W+/B','N+/W+','C','0','1','2'),('30','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','C','2','1','0'),('31','A','B','C','3','12','5','21','70','14','18','16','18','46','A','0','W+/B','N+/W+','E','0','1','2'),('32','A','B','C','3','12','5','21','70','14','18','16','18','46','C','0','W+/B','N+/W+','E','0','1','2'),('33','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','F','2','1','0'),('34','A','B','C','3','12','5','21','70','14','18','16','18','46','A','0','W+/B','N+/W+','G','0','1','2'),('35','A','B','C','3','12','5','21','70','14','18','16','18','46','C','0','W+/B','N+/W+','H','0','1','2'),('36','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','H','2','1','0'),('37','A','B','C','3','12','5','21','70','14','18','16','18','46','A','0','W+/B','N+/W+','I','2','1','0'),('38','A','B','C','3','12','5','21','70','14','18','16','18','46','C','0','W+/B','N+/W+','L','2','1','0'),('39','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','M','2','1','0'),('40','A','B','C','3','12','5','21','70','14','18','16','18','46','A','0','W+/B','N+/W+','M','2','1','0'),('41','A','B','C','3','12','5','21','70','14','18','16','18','46','C','0','W+/B','N+/W+','N','0','1','2'),('42','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','N','2','1','0'),('43','A','B','C','3','12','5','21','70','14','18','16','18','46','A','0','W+/B','N+/W+','O','2','1','0'),('44','A','B','C','3','12','5','21','70','14','18','16','18','46','C','0','W+/B','N+/W+','O','0','1','2'),('45','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','Q1','0','1','2'),('46','A','B','C','3','12','5','21','70','14','18','16','18','46','A','0','W+/B','N+/W+','Q1','2','1','0'),('47','A','B','C','3','12','5','21','70','14','18','16','18','46','A','0','W+/B','N+/W+','Q2','2','1','0'),('48','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','Q3','2','1','0'),('49','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','Q4','2','1','0'),('50','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','Q4','2','1','0'),('51','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','A','0','1','2'),('52','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','A','2','1','0'),('53','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','B','0','1','0'),('54','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','B','0','1','0'),('55','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','C','2','1','0'),('56','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','E','2','1','0'),('57','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','E','0','1','2'),('58','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','F','2','1','0'),('59','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','G','2','1','0'),('60','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','H','0','1','2'),('61','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','H','0','1','2'),('62','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','I','0','1','2'),('63','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','L','0','1','2'),('64','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','L','0','1','2'),('65','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','M','2','1','0'),('66','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','N','0','1','2'),('67','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','N','0','1','2'),('68','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','O','0','1','2'),('69','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','O','2','1','0'),('70','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','Q1','2','1','0'),('71','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','Q2','2','1','0'),('72','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','Q2','2','1','0'),('73','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','Q3','2','1','0'),('74','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','Q4','2','1','0'),('75','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','Q4','0','1','2'),('76','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','A','0','1','2'),('77','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','B','0','0','1'),('78','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','B','0','1','0'),('79','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','C','0','1','2'),('80','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','C','0','1','2'),('81','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','E','0','1','2'),('82','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','F','0','1','2'),('83','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','F','0','1','2'),('84','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','G','0','1','2'),('85','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','H','0','1','2'),('86','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','H','0','1','2'),('87','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','I','0','1','2'),('88','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','L','2','1','0'),('89','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','L','0','1','2'),('90','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','M','0','1','2'),('91','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','M','2','1','0'),('92','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','N','0','1','2'),('93','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','O','0','1','2'),('94','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','O','0','1','2'),('95','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','Q1','0','1','2'),('96','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','Q2','0','1','2'),('97','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','Q2','0','1','2'),('98','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','Q3','2','1','0'),('99','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','Q4','2','1','0'),('100','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','Q4','0','1','2'),('101','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','A','2','1','0'),('102','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','B','0','0','1'),('103','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','B','0','1','0'),('104','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','C','2','1','0'),('105','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','C','2','1','0'),('106','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','E','0','1','2'),('107','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','F','0','1','2'),('108','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','F','0','1','2'),('109','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','G','2','1','0'),('110','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','H','2','1','0'),('111','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','H','2','1','0'),('112','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','I','2','1','0'),('113','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','L','2','1','0'),('114','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','L','2','1','0'),('115','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','M','2','1','0'),('116','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','M','0','1','2'),('117','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','N','2','1','0'),('118','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','O','2','1','0'),('119','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','O','2','1','0'),('120','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','Q1','0','1','2'),('121','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','Q2','0','1','2'),('122','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','Q2','0','1','2'),('123','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','Q3','0','1','2'),('124','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','Q4','2','1','0'),('125','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','Q4','0','1','2'),('126','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','A','2','1','0'),('127','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','B','0','0','1'),('128','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','B','0','1','0'),('129','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','C','2','1','0'),('130','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','C','2','1','0'),('131','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','E','2','1','0'),('132','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','F','2','1','0'),('133','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','F','2','1','0'),('134','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','G','2','1','0'),('135','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','H','0','1','2'),('136','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','H','2','1','0'),('137','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','I','0','1','2'),('138','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','I','2','1','0'),('139','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','L','0','1','2'),('140','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','M','2','1','0'),('141','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','M','0','1','2'),('142','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','N','2','1','0'),('143','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','O','2','1','0'),('144','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','O','0','1','2'),('145','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','Q1','2','1','0'),('146','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','Q2','2','1','0'),('147','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','Q3','2','1','0'),('148','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','Q3','2','1','0'),('149','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','Q4','2','1','0'),('150','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','Q4','2','1','0'),('151','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','A','0','1','2'),('152','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','B','0','1','0'),('153','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','B','0','0','1'),('154','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','C','0','1','2'),('155','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','E','2','1','0'),('156','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','E','2','1','0'),('157','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','F','0','1','2'),('158','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','F','0','1','2'),('159','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','G','0','1','2'),('160','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','G','2','1','0'),('161','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','H','0','1','2'),('162','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','I','0','1','2'),('163','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','I','2','1','0'),('164','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','L','2','1','0'),('165','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','M','0','1','2'),('166','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','M','0','1','2'),('167','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','N','2','1','0'),('168','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','O','2','1','0'),('169','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','Q1','2','1','0'),('170','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','Q1','0','1','2'),('171','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','Q2','2','1','0'),('172','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','Q3','0','1','2'),('173','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','Q3','2','1','0'),('174','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','Q4','2','1','0'),('175','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','Q4','0','1','2'),('176','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','A','2','1','0'),('177','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','B','1','0','0'),('178','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','B','1','0','0'),('179','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','C','2','1','0'),('180','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','E','2','1','0'),('181','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','E','2','1','0'),('182','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','F','2','1','0'),('183','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','F','2','1','0'),('184','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','G','2','1','0'),('185','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','G','2','1','0'),('186','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','H','2','1','0'),('187','A','B','C','3','12','5','21','70','14','18','16','18','46','B','0','W+/B','N+/W+','','0','0','0');
/*!40000 ALTER TABLE `ksdf` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `manager`
--

DROP TABLE IF EXISTS `manager`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `manager` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `password` varchar(256) NOT NULL,
  `role` varchar(45) DEFAULT NULL COMMENT '角色信息，目前仅能存入以下大写字符：M-Manager管理者，P-PM项目经理，E-Examinee被试，G-Guest访客，L-Leader领导，I-Interviewer面询',
  `project_id` int(11) DEFAULT NULL COMMENT '所属项目编号，只有在角色是项目经理、领导、面试官等角色时才会有值，否则为空',
  `name` varchar(45) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `index3` (`username`),
  KEY `index2` (`project_id`),
  CONSTRAINT `fk_manager_project` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=111 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `manager`
--

LOCK TABLES `manager` WRITE;
/*!40000 ALTER TABLE `manager` DISABLE KEYS */;
INSERT INTO `manager` VALUES (1,'sa','123456','M',NULL,'gly','2015-08-10 16:47:38'),(2,'pm','123456','P',1,'经理','2015-08-10 17:12:40'),(8,'hh','123456',NULL,NULL,'哈哈',NULL),(11,'hw','123456',NULL,NULL,'汉王',NULL),(60,'pm2','123456','P',2,'pm2.5','2015-08-10 17:12:48'),(81,'107779','380188','L',1,'领导1',NULL),(82,'478933','923609','L',1,'领导2',NULL),(83,'699855','114125','L',1,'领导3',NULL),(84,'664102','614373','L',1,'领导4',NULL),(85,'528774','233122','L',1,'领导5',NULL),(86,'416103','544602','L',1,'领导6',NULL),(87,'953904','088360','L',1,'领导7',NULL),(88,'155695','344652','L',1,'领导8',NULL),(89,'760173','910870','L',1,'领导9',NULL),(90,'189825','525131','L',1,'领导10',NULL),(91,'691693','565973','I',1,'专家1',NULL),(92,'037667','956424','I',1,'专家2',NULL),(93,'288094','410167','I',1,'专家3',NULL),(94,'149848','241186','I',1,'专家4',NULL),(95,'441307','827849','I',1,'专家5',NULL),(96,'337145','838631','I',1,'专家6',NULL),(97,'811966','935330','I',1,'专家7',NULL),(98,'538858','700752','I',1,'专家8',NULL),(99,'732481','682496','I',1,'专家9',NULL),(100,'092720','602570','I',1,'专家10',NULL),(101,'857909','687630','I',2,'专家1',NULL),(102,'768711','779959','I',2,'专家2',NULL),(103,'485404','535543','I',2,'专家3',NULL),(104,'720167','015617','I',2,'专家4',NULL),(105,'582359','503611','I',2,'专家5',NULL),(106,'434872','993470','I',2,'专家6',NULL),(107,'867420','059915','I',2,'专家7',NULL),(108,'332178','493653','I',2,'专家8',NULL),(109,'638373','197289','I',2,'专家9',NULL),(110,'358676','646598','I',2,'专家10',NULL);
/*!40000 ALTER TABLE `manager` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `module`
--

DROP TABLE IF EXISTS `module`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL COMMENT '模块名',
  `belong_module` varchar(45) DEFAULT NULL,
  `chs_name` varchar(45) DEFAULT NULL,
  `children` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `module`
--

LOCK TABLES `module` WRITE;
/*!40000 ALTER TABLE `module` DISABLE KEYS */;
INSERT INTO `module` VALUES (9,'ldl','胜任力',NULL,'ldnl,pdyjcnl,zzglnl');
/*!40000 ALTER TABLE `module` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paper`
--

DROP TABLE IF EXISTS `paper`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paper` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(2000) DEFAULT NULL COMMENT '指导语',
  `name` varchar(200) DEFAULT NULL COMMENT '试卷名',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paper`
--

LOCK TABLES `paper` WRITE;
/*!40000 ALTER TABLE `paper` DISABLE KEYS */;
INSERT INTO `paper` VALUES (31,'本问卷共有88个问题，请根据自己的实际情况作“是”或“不是”的回答，请在“是”的题号前画“Ｏ”。这些问题要求你按自己的实际情况回答，不要去猜测怎样才是正确的回答。因为这里不存在正确或错误的回答，也没有捉弄人的问题，将问题的意思看懂了就快点回答，不要花很多时间去想。每个问题都要问答。问卷无时间限制，但不要拖延太长，也不要未看懂问题便回答。','EPQA'),(32,'卡特尔十六种人格因素测验包括一些有关个人兴趣与态度的问题。每个人都有自己的看法，对问题的回答自然不同。无所谓正确或错误。请来试者尽量表达自己的意见。<br />本测验共有187道题， 每道题有三种选择，请将你的选择用“Ｘ”号标记在答卷纸上相应的空格内。作答时，请注意下列四点：<br />１．请不要费时斟酌。应当顺其自然地依你个人的反应选答。一般地说来，问题都略嫌简短而不能包含所有有关的因素或条件。通常每分钟可作五六题，全部问题应在半小时内完成。<br />２．除非在万不得已的情形下，尽量避免如“介乎Ａ与Ｃ之间”或“不甚确定”这样的中性答案。<br />３．请不要遗漏，务必对每一个问题作答。 有些问题似乎不符合于你，有些问题又似乎涉及隐私，但本测验的目的，在于研究比较青年或成人的兴趣和态度，希望来试者真实作答。<br />４．作答时，请坦白表达自己的兴趣与态度，不必顾虑到主试者或其他人的意见与立场。','16PF'),(33,'本测验含有一系列观点的陈述，请仔细阅读每一条，看看自己对它的感觉如何，如果你同意某个观点或该陈述真实地反映了你的情况，就作“是”的回答，在该题号上划“√”，否则作“否”的回答。','CPI'),(34,'本测验包括许多成对的语句，任何选择都无所谓对错，对它们所描述的特征，你可能喜欢，也可能不喜欢，其方式你可能曾感觉到，也可能没有感觉到，请你从中选出最能表现或接近你当前特征或感觉的那一个，并将你的选择用“√”标记于答卷纸相应的位置处。如果两句话都没有正确描述你的情况，那你应当选择你认为能比较正确反映你的情况的那一个。<br /> 总之，对于每道题的A、B两种选择你必须而且只能选择其一。','EPPS'),(35,'以下列出了有些人可能会有的问题，请仔细地阅读每一条，然后根据最近一星期以内下述情况影响您的实际感觉，在每个问题后标明该题的程度得分。其中，“没有”选1，“很轻”选2，“中等”选3， “偏重”选4，“严重”选5。','SCL'),(36,'下面要做的是一个有趣的测试，完成它时要认真看、认真想， 前面的题认真了，会对做后面的题目有好处；<br />本测试共有60道题，每道测试题都有一张主题图，在主题图中，图案是缺了一部分的，主题图下有6－8张小图片，其中有一张小图片可以使主题图整个图案合理与完整。请确定哪一张小图片补充在主题图缺少的空白处最合适。<br />本测验无时间限制，请认真去做，一般完成它需用40分钟的时间。请记住，每个题目只有一个正确答案。','SPM');
/*!40000 ALTER TABLE `paper` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pmrel`
--

DROP TABLE IF EXISTS `pmrel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pmrel` (
  `project_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  PRIMARY KEY (`project_id`,`module_id`),
  KEY `fk_pmrel_2_idx` (`module_id`),
  CONSTRAINT `fk_pmrel_1` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_pmrel_2` FOREIGN KEY (`module_id`) REFERENCES `module` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pmrel`
--

LOCK TABLES `pmrel` WRITE;
/*!40000 ALTER TABLE `pmrel` DISABLE KEYS */;
/*!40000 ALTER TABLE `pmrel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project`
--

DROP TABLE IF EXISTS `project`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `begintime` datetime DEFAULT NULL COMMENT '开始时间',
  `endtime` datetime DEFAULT NULL COMMENT '结束时间',
  `name` varchar(200) NOT NULL COMMENT '项目名',
  `description` varchar(2000) DEFAULT NULL COMMENT '项目备注，详细描述',
  `manager_id` int(11) NOT NULL COMMENT '项目经理id',
  `last_examinee_id` int(11) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_project_1_idx` (`manager_id`),
  CONSTRAINT `fk_project_1` FOREIGN KEY (`manager_id`) REFERENCES `manager` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project`
--

LOCK TABLES `project` WRITE;
/*!40000 ALTER TABLE `project` DISABLE KEYS */;
INSERT INTO `project` VALUES (1,'2015-07-01 15:42:00','2015-08-03 15:43:00','小测验','这是周五的小测验',2,5),(2,'2015-08-04 19:30:00','2015-08-21 23:55:00','lalala','更详细的信息描述...',60,1);
/*!40000 ALTER TABLE `project` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question`
--

DROP TABLE IF EXISTS `question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `topic` text COMMENT '题目描述',
  `options` text COMMENT '题目选项，不同选项用竖线隔开',
  `grade` text COMMENT '得分表，各个选项的得分数字依次用竖线隔开，总个数和options对应 （目前暂时不再使用）',
  `number` int(11) NOT NULL COMMENT '题目在试卷中的编号',
  `paper_id` int(11) DEFAULT NULL COMMENT '所属试卷id',
  PRIMARY KEY (`id`),
  KEY `fk_question_1_idx` (`paper_id`),
  CONSTRAINT `fk_question_1` FOREIGN KEY (`paper_id`) REFERENCES `paper` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3146 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question`
--

LOCK TABLES `question` WRITE;
/*!40000 ALTER TABLE `question` DISABLE KEYS */;
INSERT INTO `question` VALUES (2326,'头痛。','没有|很轻|中等|偏重|严重',NULL,1,35),(2327,'神经过敏，心中不踏实。','没有|很轻|中等|偏重|严重',NULL,2,35),(2328,'头脑中有不必要的想法或字句盘旋。','没有|很轻|中等|偏重|严重',NULL,3,35),(2329,'头昏或昏倒。','没有|很轻|中等|偏重|严重',NULL,4,35),(2330,'对异性的兴趣减退。','没有|很轻|中等|偏重|严重',NULL,5,35),(2331,'对旁人责备求全。','没有|很轻|中等|偏重|严重',NULL,6,35),(2332,'感到别人能控制您的思想。','没有|很轻|中等|偏重|严重',NULL,7,35),(2333,'责怪别人制造麻烦。','没有|很轻|中等|偏重|严重',NULL,8,35),(2334,'忘记性大。','没有|很轻|中等|偏重|严重',NULL,9,35),(2335,'担心自己的衣饰整齐及仪态的端正。','没有|很轻|中等|偏重|严重',NULL,10,35),(2336,'容易烦恼和激动。','没有|很轻|中等|偏重|严重',NULL,11,35),(2337,'胸痛。','没有|很轻|中等|偏重|严重',NULL,12,35),(2338,'害怕空旷的场所或街道。','没有|很轻|中等|偏重|严重',NULL,13,35),(2339,'感到自己的精力下降，活动减慢。','没有|很轻|中等|偏重|严重',NULL,14,35),(2340,'想结束自己的生命。','没有|很轻|中等|偏重|严重',NULL,15,35),(2341,'听到旁人听不到的声音。','没有|很轻|中等|偏重|严重',NULL,16,35),(2342,'发抖。','没有|很轻|中等|偏重|严重',NULL,17,35),(2343,'感到大多数人都不可信任。','没有|很轻|中等|偏重|严重',NULL,18,35),(2344,'胃口不好。','没有|很轻|中等|偏重|严重',NULL,19,35),(2345,'容易哭泣。','没有|很轻|中等|偏重|严重',NULL,20,35),(2346,'同异性相处时感到害羞不自在。','没有|很轻|中等|偏重|严重',NULL,21,35),(2347,'感到受骗，中了圈套或有人想抓住您。','没有|很轻|中等|偏重|严重',NULL,22,35),(2348,'无缘无故地突然感到害怕。','没有|很轻|中等|偏重|严重',NULL,23,35),(2349,'自己不能控制地大发脾气。','没有|很轻|中等|偏重|严重',NULL,24,35),(2350,'怕单独出门。','没有|很轻|中等|偏重|严重',NULL,25,35),(2351,'经常责怪自己。','没有|很轻|中等|偏重|严重',NULL,26,35),(2352,'腰痛。','没有|很轻|中等|偏重|严重',NULL,27,35),(2353,'感到难以完成任务。','没有|很轻|中等|偏重|严重',NULL,28,35),(2354,'感到孤独。','没有|很轻|中等|偏重|严重',NULL,29,35),(2355,'感到苦闷。','没有|很轻|中等|偏重|严重',NULL,30,35),(2356,'过分担忧。','没有|很轻|中等|偏重|严重',NULL,31,35),(2357,'对事物不感兴趣。','没有|很轻|中等|偏重|严重',NULL,32,35),(2358,'感到害怕。','没有|很轻|中等|偏重|严重',NULL,33,35),(2359,'您的感情容易受到伤害。','没有|很轻|中等|偏重|严重',NULL,34,35),(2360,'旁人能知道您的私下想法。','没有|很轻|中等|偏重|严重',NULL,35,35),(2361,'感到别人不理解您、不同情您。','没有|很轻|中等|偏重|严重',NULL,36,35),(2362,'感到人们对您不友好，不喜欢您。','没有|很轻|中等|偏重|严重',NULL,37,35),(2363,'做事必须做得很慢以保证做得正确。','没有|很轻|中等|偏重|严重',NULL,38,35),(2364,'心跳得很厉害。','没有|很轻|中等|偏重|严重',NULL,39,35),(2365,'恶心或胃部不舒服。','没有|很轻|中等|偏重|严重',NULL,40,35),(2366,'感到比不上他人。','没有|很轻|中等|偏重|严重',NULL,41,35),(2367,'肌肉酸痛。','没有|很轻|中等|偏重|严重',NULL,42,35),(2368,'感到有人在监视您、谈论您。','没有|很轻|中等|偏重|严重',NULL,43,35),(2369,'难以入睡。','没有|很轻|中等|偏重|严重',NULL,44,35),(2370,'做事必须反复检查。','没有|很轻|中等|偏重|严重',NULL,45,35),(2371,'难以作出决定。','没有|很轻|中等|偏重|严重',NULL,46,35),(2372,'怕乘电车、公共汽车、地铁或火车。','没有|很轻|中等|偏重|严重',NULL,47,35),(2373,'呼吸有困难。','没有|很轻|中等|偏重|严重',NULL,48,35),(2374,'一阵阵发冷或发热。','没有|很轻|中等|偏重|严重',NULL,49,35),(2375,'因为感到害怕而避开某些东西、场合或活动。','没有|很轻|中等|偏重|严重',NULL,50,35),(2376,'脑子变空了。','没有|很轻|中等|偏重|严重',NULL,51,35),(2377,'身体发麻或刺痛。','没有|很轻|中等|偏重|严重',NULL,52,35),(2378,'喉咙有梗塞感。','没有|很轻|中等|偏重|严重',NULL,53,35),(2379,'感到前途没有希望。','没有|很轻|中等|偏重|严重',NULL,54,35),(2380,'不能集中注意。','没有|很轻|中等|偏重|严重',NULL,55,35),(2381,'感到身体的某一部分软弱无力。','没有|很轻|中等|偏重|严重',NULL,56,35),(2382,'感到紧张或容易紧张。','没有|很轻|中等|偏重|严重',NULL,57,35),(2383,'感到手或脚发重。','没有|很轻|中等|偏重|严重',NULL,58,35),(2384,'想到死亡的事。','没有|很轻|中等|偏重|严重',NULL,59,35),(2385,'吃得太多。','没有|很轻|中等|偏重|严重',NULL,60,35),(2386,'当别人看着您或谈论您时感到不自在。','没有|很轻|中等|偏重|严重',NULL,61,35),(2387,'有一些不属于您自己的想法。','没有|很轻|中等|偏重|严重',NULL,62,35),(2388,'有想打人或伤害他人的冲动。','没有|很轻|中等|偏重|严重',NULL,63,35),(2389,'醒得太早。','没有|很轻|中等|偏重|严重',NULL,64,35),(2390,'必须反复洗手、点数目或触摸某些东西。','没有|很轻|中等|偏重|严重',NULL,65,35),(2391,'睡得不稳不深。','没有|很轻|中等|偏重|严重',NULL,66,35),(2392,'有想摔坏或破坏东西的冲动。','没有|很轻|中等|偏重|严重',NULL,67,35),(2393,'有一些别人没有的想法或念头。','没有|很轻|中等|偏重|严重',NULL,68,35),(2394,'感到对别人神经过敏。','没有|很轻|中等|偏重|严重',NULL,69,35),(2395,'在商店或电影院等人多的地方感到不自在。','没有|很轻|中等|偏重|严重',NULL,70,35),(2396,'感到任何事情都很困难。','没有|很轻|中等|偏重|严重',NULL,71,35),(2397,'一阵阵恐惧或惊恐。','没有|很轻|中等|偏重|严重',NULL,72,35),(2398,'感到在公共场合吃东西很不舒服。','没有|很轻|中等|偏重|严重',NULL,73,35),(2399,'经常与人争论。','没有|很轻|中等|偏重|严重',NULL,74,35),(2400,'单独一个人时神经很紧张。','没有|很轻|中等|偏重|严重',NULL,75,35),(2401,'别人对您的成绩没有作出恰当的评价。','没有|很轻|中等|偏重|严重',NULL,76,35),(2402,'即使和别人在一起也感到孤单。','没有|很轻|中等|偏重|严重',NULL,77,35),(2403,'感到坐立不安心神不定。','没有|很轻|中等|偏重|严重',NULL,78,35),(2404,'感到自己没有什么价值。','没有|很轻|中等|偏重|严重',NULL,79,35),(2405,'感到熟悉的东西变成陌生或不象是真的。','没有|很轻|中等|偏重|严重',NULL,80,35),(2406,'大叫或摔东西。','没有|很轻|中等|偏重|严重',NULL,81,35),(2407,'害怕会在公共场合昏倒。','没有|很轻|中等|偏重|严重',NULL,82,35),(2408,'感到别人想占您的便宜。','没有|很轻|中等|偏重|严重',NULL,83,35),(2409,'为一些有关性的想法而很苦恼。','没有|很轻|中等|偏重|严重',NULL,84,35),(2410,'您认为应该因为自己的过错而受到惩罚。','没有|很轻|中等|偏重|严重',NULL,85,35),(2411,'感到要很快把事情做完。','没有|很轻|中等|偏重|严重',NULL,86,35),(2412,'感到自己的身体有严重问题。','没有|很轻|中等|偏重|严重',NULL,87,35),(2413,'从未感到和其他人很亲近。','没有|很轻|中等|偏重|严重',NULL,88,35),(2414,'感到自己有罪。','没有|很轻|中等|偏重|严重',NULL,89,35),(2415,'感到自己的脑子有毛病。','没有|很轻|中等|偏重|严重',NULL,90,35),(2416,'我喜欢参加公众集会，目的是为了同别人在一起。','是|否',NULL,1,33),(2417,'我觉得我父亲是个理想的人。','是|否',NULL,2,33),(2418,'一个人需要不时地“显示”一下自己。','是|否',NULL,3,33),(2419,'同别人在一块时，我通常去做对其他人有益的事，而不是光提意见建议。','是|否',NULL,4,33),(2420,'我常常觉得在专业选择上自己犯了个错误。','是|否',NULL,5,33),(2421,'我一贯遵守这样一条原则：先工作，后娱乐。','是|否',NULL,6,33),(2422,'我有时会感到好象就要发生什么可怕的事情，这种感觉一周内有好几次。','是|否',NULL,7,33),(2423,'我希望当一名记者。','是|否',NULL,8,33),(2424,'我觉得自己愿意干建筑承包工作。','是|否',NULL,9,33),(2425,'我曾有过非常独特、奇异的体验。','是|否',NULL,10,33),(2426,'总的来看，穷人比富人境况好。','是|否',NULL,11,33),(2427,'我一听到自己熟悉的人获得成功，就象自己失败了一样。','是|否',NULL,12,33),(2428,'我希望当服装设计师。','是|否',NULL,13,33),(2429,'别人常常说我莽撞。','是|否',NULL,14,33),(2430,'有时我也讲点闲话。','是|否',NULL,15,33),(2431,'我怀疑自己能否会做好领导工作。','是|否',NULL,16,33),(2432,'我感到很难开口同陌生人交谈。','是|否',NULL,17,33),(2433,'一觉得有人注视我，我就会变得紧张。','是|否',NULL,18,33),(2434,'如果人们能够掌握所有实际情况，对大多数问题来说，只有一个正确的答案。','是|否',NULL,19,33),(2435,'有时我装作比我实际懂得多的样子。','是|否',NULL,20,33),(2436,'为公共事务操心，一点用处也没有，反正自己的所作所为对公共事务毫无影响。','是|否',NULL,21,33),(2437,'有时我真想摔瓶摔碗，发泄一下。','是|否',NULL,22,33),(2438,'不应该让妇女单独在酒馆里喝酒。','是|否',NULL,23,33),(2439,'如果某人冤枉了我，我觉得只要有可能就该批评他，这样做的目的是为了维护原则。','是|否',NULL,24,33),(2440,'我好象和周围的大多数人一样聪明能干。','是|否',NULL,25,33),(2441,'我希望拥有支配他人的权力。','是|否',NULL,26,33),(2442,'我感到很难集中精力去完成一项工作。','是|否',NULL,27,33),(2443,'一想到别人不赞同我，我就变得非常紧张、焦虑。','是|否',NULL,28,33),(2444,'许多人的困难在于他们办事不够认真严肃。','是|否',NULL,29,33),(2445,'我过去喜欢上学。','是|否',NULL,30,33),(2446,'我害怕雷暴雨。','是|否',NULL,31,33),(2447,'有时我真想骂街。','是|否',NULL,32,33),(2448,'我肯定，世界上纯粹、真正的宗教只有一种。','是|否',NULL,33,33),(2449,'听到下流的故事时，我感到窘迫。','是|否',NULL,34,33),(2450,'我有时为避开和某人相遇而穿过马路。','是|否',NULL,35,33),(2451,'我过去常写日记。','是|否',NULL,36,33),(2452,'应该和少数民族搞好团结，但这件事与我无关。','是|否',NULL,37,33),(2453,'我感到很难向任何人谈及自己的情况。','是|否',NULL,38,33),(2454,'我们应该为自己的国家担忧，让世界上其他国家自己管理自己。','是|否',NULL,39,33),(2455,'我经常感到好象整个世界对我毫不在意，在飘然而去。','是|否',NULL,40,33),(2456,'我感到厌烦的时候，喜欢挑起刺激性的事端。','是|否',NULL,41,33),(2457,'我喜欢不时地夸耀一下自己取得的成绩。','是|否',NULL,42,33),(2458,'我害怕深水。','是|否',NULL,43,33),(2459,'必须承认，我常常想方设法按自己的方式行事，丝毫不考虑别人可能要做什么。','是|否',NULL,44,33),(2460,'我觉得自己希望当汽车修理工。','是|否',NULL,45,33),(2461,'在正式的舞会或集会上，我总感到紧张和不舒适。','是|否',NULL,46,33),(2462,'我不愿意看到人们穿戴邋邋遢遢，过于随便。','是|否',NULL,47,33),(2463,'我每周会有一次或多次觉得突然浑身发烧，却没有明显的原因。','是|否',NULL,48,33),(2464,'有时我觉得一切都糟糕得不愿张口提及。','是|否',NULL,49,33),(2465,'如果一切照现在这个样子继续下去，人们很难期望会发生什么了不起的事。','是|否',NULL,50,33),(2466,'我无法使自己的思想集中到某一件事上。','是|否',NULL,51,33),(2467,'必须承认，我经常对工作能少干就少干。','是|否',NULL,52,33),(2468,'我喜欢成为人们注意的中心。','是|否',NULL,53,33),(2469,'单独走进别人正在聚集聊天的房间，我并不感到害怕。','是|否',NULL,54,33),(2470,'有时我非常泄气。','是|否',NULL,55,33),(2471,'想到自己会遭受车祸，我很害怕。','是|否',NULL,56,33),(2472,'和大家在一起的时候，我总想不出恰当的话来说。','是|否',NULL,57,33),(2473,'中学教师总抱怨他们的收入少，但我认为他们也就该挣这么多钱。','是|否',NULL,58,33),(2474,'有时我真想与某人动手打一架。','是|否',NULL,59,33),(2475,'听那种没有自己主见的人讲课很令人讨厌。','是|否',NULL,60,33),(2476,'一个人倘若事先把一切活动都安排好，他很可能会把生活中的乐趣全部剥夺掉。','是|否',NULL,61,33),(2477,'过去念书时，我接受知识很慢。','是|否',NULL,62,33),(2478,'我喜欢诗歌。','是|否',NULL,63,33),(2479,'我不喜欢与别人说话，除非他们先开口。','是|否',NULL,64,33),(2480,'我觉得自己希望骑一辆赛车。','是|否',NULL,65,33),(2481,'有时没有任何原因，甚至当一切很糟糕的时候，我反而又激动又高兴，感到万事如意。','是|否',NULL,66,33),(2482,'我一生的目的之一，就是完成某件我母亲可以引为自豪的工作。','是|否',NULL,67,33),(2483,'我很容易恋爱，也很容易失恋。','是|否',NULL,68,33),(2484,'只要不犯法，回避法律条款也没什么不好。','是|否',NULL,69,33),(2485,'现在做父母的对子女管教太松。','是|否',NULL,70,33),(2486,'我很怕黑暗。','是|否',NULL,71,33),(2487,'碰到困难的问题，我往往容易打退堂鼓。','是|否',NULL,72,33),(2488,'别人的批评和训斥，使我很不舒服。','是|否',NULL,73,33),(2489,'我有一些奇特、少有的念头。','是|否',NULL,74,33),(2490,'身体不舒服的时候，我容易生气发火。','是|否',NULL,75,33),(2491,'我患有漫游癖，只有在闭逛旅游时，我才感到愉快。','是|否',NULL,76,33),(2492,'我常常发现，在试图做某件事的时候，我的手在发抖。','是|否',NULL,77,33),(2493,'假如迫不得已，非要见很多人的话，我感到很紧张。','是|否',NULL,78,33),(2494,'我希望听到著名歌手在歌剧中演唱。','是|否',NULL,79,33),(2495,'有时没有任何充分的理由，我就生气、发脾气。','是|否',NULL,80,33),(2496,'我喜欢参加社交聚会和联欢会。','是|否',NULL,81,33),(2497,'我父母常常对我的朋友表示反感。','是|否',NULL,82,33),(2498,'我希望同时是好几个俱乐部或社团的成员。','是|否',NULL,83,33),(2499,'过去我的家庭生活一直很幸福。','是|否',NULL,84,33),(2500,'我往往凭一时冲动，鲁莽行事，而没有停下来思考一下。','是|否',NULL,85,33),(2501,'我做事的方法常易被人误解。','是|否',NULL,86,33),(2502,'有时，我突然感到一阵晕眩，所干的事情被打断，周围发生的一切都不知道。','是|否',NULL,87,33),(2503,'某人为我做了一件好事，我常常自问其背后隐藏的动机是什么。','是|否',NULL,88,33),(2504,'我确实缺乏自信心。','是|否',NULL,89,33),(2505,'当某人招致不幸时，其他人大都暗自高兴。','是|否',NULL,90,33),(2506,'假如在某个群众团体工作，我喜欢担任领导职务。','是|否',NULL,91,33),(2507,'有时我觉得好象非要伤害自己或伤害他人。','是|否',NULL,92,33),(2508,'我有不少份外的事要操心。','是|否',NULL,93,33),(2509,'我常常只图一时快乐，即使这样做有损于长远目标也在所不惜。','是|否',NULL,94,33),(2510,'除非与我熟知的人在一起，我一般不爱多说话。','是|否',NULL,95,33),(2511,'我记得自己曾经为了摆脱某件事而假装生病。','是|否',NULL,96,33),(2512,'碰到一位陌生人，我常常感到他比我强。','是|否',NULL,97,33),(2513,'我喜欢让别人去猜测我下一步将干什么。','是|否',NULL,98,33),(2514,'和众人在一起时，假如让我主持一个讨论或就我熟知的事情发表意见，我不会觉得难为情的。','是|否',NULL,99,33),(2515,'事情出了差错，我有时责怪他人。','是|否',NULL,100,33),(2516,'我更喜欢自己下了赌注的比赛或游戏。','是|否',NULL,101,33),(2517,'我常常发现，别人嫉妒我的好主意，就是因为他们没有先想到这些主意。','是|否',NULL,102,33),(2518,'我喜欢参加社交集会和其他热热闹闹的活动。','是|否',NULL,103,33),(2519,'我爱打猎。','是|否',NULL,104,33),(2520,'当独自一个人的时候，我发现自己常常在琢磨一些抽象的问题，比如：自由意志、邪恶等等。','是|否',NULL,105,33),(2521,'听到有人被非法地阻止参加选举，我非常气愤。','是|否',NULL,106,33),(2522,'我从前上学时，有时因为惹老师生气被送去见班主任。','是|否',NULL,107,33),(2523,'我希望当一名图书管理员。','是|否',NULL,108,33),(2524,'我很喜欢参加舞会。','是|否',NULL,109,33),(2525,'多数人从内心里并不愿意花力气帮助他人。','是|否',NULL,110,33),(2526,'人们装出他们互相很关心，而实际上并非如此。','是|否',NULL,111,33),(2527,'多数人在性的问题上忧虑过多。','是|否',NULL,112,33),(2528,'遇到不熟悉的人我很难想出什么话题来说。','是|否',NULL,113,33),(2529,'我很喜欢对称的东西，而不喜欢不对称的东西。','是|否',NULL,114,33),(2530,'我宁愿做一名踏踏实实、可以信赖的人，而不愿做一名才华横溢而见异思迁的人。','是|否',NULL,115,33),(2531,'一有机会，我总爱以某种方式显露一下自己。','是|否',NULL,116,33),(2532,'对某些问题，我太容易动肝火，所以无法谈论它们。','是|否',NULL,117,33),(2533,'有时候，我好象简直无力开展工作。','是|否',NULL,118,33),(2534,'若有人没有把贵重物品妥善保管，使其成为诱饵，一旦该物被偷了的话，则放物的人和小偷应受到同样的谴责。','是|否',NULL,119,33),(2535,'我同什么样的人都合得来。','是|否',NULL,120,33),(2536,'我常常被不断涌现又毫无意义的思想所烦忧。','是|否',NULL,121,33),(2537,'假如我是记者，我很希望报道有关剧院的新闻。','是|否',NULL,122,33),(2538,'男人与女人在一起的时候，总想取得女人的好感。','是|否',NULL,123,33),(2539,'我喜欢看指导人们亲自动手做事情的杂志。','是|否',NULL,124,33),(2540,'必须承认，我感到很难在严格的规章制度下工作。','是|否',NULL,125,33),(2541,'我喜欢盛大喧闹的聚会。','是|否',NULL,126,33),(2542,'我有时觉得自己是别人的负担。','是|否',NULL,127,33),(2543,'只有傻子才试图改变我们中国人的生活方式。','是|否',NULL,128,33),(2544,'我常常感到好象做了什么错误的或邪恶的事。','是|否',NULL,129,33),(2545,'以前上学时，我感到很难在全班同学面前讲话。','是|否',NULL,130,33),(2546,'我通常感到人生很有价值。','是|否',NULL,131,33),(2547,'我们应该离开非洲国家，以便澄清他们的问题，我们没有任何理由去帮助他们。','是|否',NULL,132,33),(2548,'有几次，我对某个人很刻薄。','是|否',NULL,133,33),(2549,'我觉得多数人会为了超过他人而说慌。','是|否',NULL,134,33),(2550,'我爱自己讲话，而不爱听别人讲话。','是|否',NULL,135,33),(2551,'我喜欢科学。','是|否',NULL,136,33),(2552,'我常常发脾气。','是|否',NULL,137,33),(2553,'必须承认，搬到一个陌生的地方去我会有些害怕。','是|否',NULL,138,33),(2554,'在公共场所，比如在公共汽车上或在商店里，我对盯着我瞧的人感到很烦恼。','是|否',NULL,139,33),(2555,'我自信知道应怎样解决我们今天所面临的国际问题。','是|否',NULL,140,33),(2556,'有时我爱做那些不应该做的、违反制度的事。','是|否',NULL,141,33),(2557,'我很少和家里人吵架。','是|否',NULL,142,33),(2558,'买东西时，如果多找给了我钱，我总是把钱送回去。','是|否',NULL,143,33),(2559,'我常常厌恶自己。','是|否',NULL,144,33),(2560,'相当多的人都会由于不正当的性行为而感到内疚。','是|否',NULL,145,33),(2561,'我喜欢阅读科学方面的书籍。','是|否',NULL,146,33),(2562,'和大家在一起时，我很难表现得自然。','是|否',NULL,147,33),(2563,'有些游戏，我根本不参加，因为我不擅长。','是|否',NULL,148,33),(2564,'我希望加入某个合唱团。','是|否',NULL,149,33),(2565,'小时候，我常因表现不好受到严厉的惩罚。','是|否',NULL,150,33),(2566,'有时，我在实际上无足轻重的事上绞尽了脑汁。','是|否',NULL,151,33),(2567,'我觉得自己常常无缘无故地受到惩罚。','是|否',NULL,152,33),(2568,'我希望当电影或戏剧演员。','是|否',NULL,153,33),(2569,'我情愿自己出钱为他人雪冤，尽管我与此案没有牵连。','是|否',NULL,154,33),(2570,'有时候，我真想做件有害的或惊人的事。','是|否',NULL,155,33),(2571,'我常常感到身体的某些部分有虫爬、火烧、刺痛和即将麻木的感觉。','是|否',NULL,156,33),(2572,'我常常违背父母的意愿。','是|否',NULL,157,33),(2573,'假如是我驾驶汽车，我会尽量不让别人超过我。','是|否',NULL,158,33),(2574,'对明明知道不会伤害自己的事物和人，我也曾感到很害  怕。','是|否',NULL,159,33),(2575,'当年，我父母很希望我出类拔萃。','是|否',NULL,160,33),(2576,'我愿意把自己说成是一个性格坚强的人。','是|否',NULL,161,33),(2577,'我几乎从来没有睡着过。','是|否',NULL,162,33),(2578,'投票选举完全是件令人烦恼、毫无意义的事。','是|否',NULL,163,33),(2579,'我觉得生活上井井有条、按时作息很适合我的脾性。','是|否',NULL,164,33),(2580,'我很难同情那种对事物总持怀疑态度、缺乏信心的人。','是|否',NULL,165,33),(2581,'我吃什么东西都是一个味。','是|否',NULL,166,33),(2582,'我做事情常常有始无终，虎头蛇尾。','是|否',NULL,167,33),(2583,'假如一个朋友也没有，我也会很愉快。','是|否',NULL,168,33),(2584,'当我出于无奈去向某人讨个职业时，会感到很紧张。','是|否',NULL,169,33),(2585,'我有时做事胆子很小。','是|否',NULL,170,33),(2586,'我常常希望离开家庭。','是|否',NULL,171,33),(2587,'我的整个脑袋每天好象要疼好长时间。','是|否',NULL,172,33),(2588,'过去在学校里，多数老师对我都很公正和诚恳。','是|否',NULL,173,33),(2589,'必须承认，我讲话很公正。','是|否',NULL,174,33),(2590,'在弄清事实之前，我从不对任何人下结论。','是|否',NULL,175,33),(2591,'假如某人很聪明，从别人身上骗取了一大笔钱，应该允许他拥有这笔钱。','是|否',NULL,176,33),(2592,'如果没有报酬，就不要指望有谁会对社会服务。','是|否',NULL,177,33),(2593,'我家里有好几个人的习惯，既给我添麻烦又添烦恼。','是|否',NULL,178,33),(2594,'必须承认，对于学习新东西，我并没有很强的欲望。','是|否',NULL,179,33),(2595,'好象没有人能理解我。','是|否',NULL,180,33),(2596,'我常常自认为是周围人的领导。','是|否',NULL,181,33),(2597,'老实人要在世界上获得成功，是根本不可能的。','是|否',NULL,182,33),(2598,'我喜欢把一切安排得整整齐齐，井然有序。','是|否',NULL,183,33),(2599,'我很讨厌自己的日常生活和工作被意外的事情打扰。','是|否',NULL,184,33),(2600,'我觉得未来似乎毫无希望。','是|否',NULL,185,33),(2601,'我过去的家庭生活总是很愉快。','是|否',NULL,186,33),(2602,'我有理由嫉妒家里的某一两个人。','是|否',NULL,187,33),(2603,'如果要以牺牲个人乐趣为代价，那我决不会有意地去帮助别人。','是|否',NULL,188,33),(2604,'我参与的辩论或争吵多数是原则问题。','是|否',NULL,189,33),(2605,'大家公认我是一名勤劳、踏实、愿为大家服务的人。','是|否',NULL,190,33),(2606,'一天到晚，我几乎总是口干舌燥。','是|否',NULL,191,33),(2607,'假如过去从未上过学，多数人的经济状况要比现在好。','是|否',NULL,192,33),(2608,'在辩论中，别人很容易把我驳倒。','是|否',NULL,193,33),(2609,'我不喜欢事情总是变化不定、玄不可测。','是|否',NULL,194,33),(2610,'我常饮酒过度。','是|否',NULL,195,33),(2611,'过去，我想弃家出走。','是|否',NULL,196,33),(2612,'生活常常对我很不公平。','是|否',NULL,197,33),(2613,'我认为自己在事非问题上比多数人更严肃认真。','是|否',NULL,198,33),(2614,'我生来就有影响别人的天赋。','是|否',NULL,199,33),(2615,'我赞成从严加强法制，不论其后果如何。','是|否',NULL,200,33),(2616,'人们常常在背后说我的坏话。','是|否',NULL,201,33),(2617,'我有几种坏习气很根深蒂固，所以要想克服它们，只是白费劲儿。','是|否',NULL,202,33),(2618,'我总想把自己的工作计划组织好。','是|否',NULL,203,33),(2619,'一周有几次，由于胃酸过多，我感到不舒服。','是|否',NULL,204,33),(2620,'我喜欢对别人加以指点，把工作开展起来。','是|否',NULL,205,33),(2621,'我对家里几个人所做的那种工作，感到很难为情。','是|否',NULL,206,33),(2622,'我觉得别人看上去比我幸福。','是|否',NULL,207,33),(2623,'只要工资高，什么工作对我来说都很好。','是|否',NULL,208,33),(2624,'我和不熟悉的人在一起感到难为情。','是|否',NULL,209,33),(2625,'我的生活常常好象毫无意义。','是|否',NULL,210,33),(2626,'年轻时，我有时偷别人的东西。','是|否',NULL,211,33),(2627,'事情一旦不顺利，我就想马上打退堂鼓。','是|否',NULL,212,33),(2628,'过去和我关系密切，同时是我在儿童时代最崇拜的人，是一位女性（母亲、姐妹、姑姨或其他女性）。','是|否',NULL,213,33),(2629,'我常常感到内疚，因为我曾装作对某事后悔莫及，而实际上并非如此。','是|否',NULL,214,33),(2630,'有几次，我生气极了。','是|否',NULL,215,33),(2631,'小时候，我们家不象大多数人家那样安定、平静。','是|否',NULL,216,33),(2632,'家里有些人做的事，使我胆颤心惊。','是|否',NULL,217,33),(2633,'小时候上学时，我常给老师添许多麻烦。','是|否',NULL,218,33),(2634,'假如工钱合理，我希望和一家马戏团或流动曲艺团一道巡回演出。','是|否',NULL,219,33),(2635,'我有突然感到恶心、呕吐的毛病。','是|否',NULL,220,33),(2636,'过去，我们一家相互之间总是亲热异常。','是|否',NULL,221,33),(2637,'我常常在半夜里受到恐吓而惊醒。','是|否',NULL,222,33),(2638,'许多人的毛病在于他们对事物不够认真。','是|否',NULL,223,33),(2639,'我不是那种适合当政治领袖的人。','是|否',NULL,224,33),(2640,'我父母过去从未真正理解过我。','是|否',NULL,225,33),(2641,'假如看到几个孩子打另一个小孩，我一定会设法制止他  们。','是|否',NULL,226,33),(2642,'别人在做出决策之前，都似乎很自然地找我征求意见。','是|否',NULL,227,33),(2643,'我对自己要求很高，并且觉得别人也该照着去做。','是|否',NULL,228,33),(2644,'一个人假如谁也不信任，生活就会忧郁得多。','是|否',NULL,229,33),(2645,'那些对事情缺乏信心、无把握的人，使我感到不舒服。','是|否',NULL,230,33),(2646,NULL,'当我的朋友有麻烦时，我喜欢帮助他们。|对我所承担的一切事情，我都喜欢尽我最大的努力去做。',NULL,1,34),(2647,NULL,'我喜欢探求伟人对我所感兴趣的各种问题有什么看法。|我喜欢完成具有重大意义的事情。',NULL,2,34),(2648,NULL,'我喜欢我写的所有的东西都很精确、清楚、有条有理。|我喜欢在某些职工、专业或专门项目上自己是公认的权威。',NULL,3,34),(2649,NULL,'我喜欢在宴会上讲些趣事与笑话。|我喜欢写本伟大的小说或剧本。',NULL,4,34),(2650,NULL,'我喜欢能随我的意志来去自如。|我喜欢能够自豪地说我将一件难题成功处理了。',NULL,5,34),(2651,NULL,'我喜欢解答其他人觉得困难的谜语与问题。|我喜欢遵从指示去做人家期待我做的事。',NULL,6,34),(2652,NULL,'我喜欢在日常生活中经验到新奇与改变。|当我认为我的上级做得对时，我喜欢对他们表示我的看法。',NULL,7,34),(2653,NULL,'对我所承担的任何工作，我喜欢对其细节作计划与组织。|我喜欢遵从指示做我所该做的事。',NULL,8,34),(2654,NULL,'在公共场合中，我喜欢人们注意和评价我的外表。|我喜欢读伟人的故事。',NULL,9,34),(2655,NULL,'我喜欢回避要我按照例行方法办事的场合。|我喜欢读伟人的故事。',NULL,10,34),(2656,NULL,'我喜欢在某些职业、专业或专门项目上自己是个公认的权威。|我喜欢在工作开始之前做好组织和计划。',NULL,11,34),(2657,NULL,'我喜欢探求伟人们对各种我所感兴趣的问题的看  法。|假如我必须旅行时，我喜欢把事情先安排好。',NULL,12,34),(2658,NULL,'我喜欢将我开了头的工作或任务完成。|我喜欢保持我的书桌或工作间的清洁与整齐。',NULL,13,34),(2659,NULL,'我喜欢告诉别人我所经历的冒险与奇特的事情。|我喜欢饮食有规律，并且有固定时间吃东西。',NULL,14,34),(2660,NULL,'我喜欢独立决定我所要做的事。|我喜欢保持书桌或工作间的清洁与整齐。',NULL,15,34),(2661,NULL,'我喜欢比其他人做得更好。|我喜欢在宴会上讲些趣闻与笑话。',NULL,16,34),(2662,NULL,'我喜欢遵从习俗，并避免做我所尊敬的人认为不合常规的事。|我喜欢谈我的成就。',NULL,17,34),(2663,NULL,'我喜欢我的生活按排得好，过得顺利，而不用对我的计划作太多的改变。|我喜欢告诉别人我所经历的冒险与奇特的事情。',NULL,18,34),(2664,NULL,'我喜欢阅读以性为主体的书与剧本。|我喜欢在团体中成为众目所瞩的对象。',NULL,19,34),(2665,NULL,'我喜欢批评权威人士。|我喜欢用些别人不懂其义的字眼。',NULL,20,34),(2666,NULL,'我喜欢完成其他人认为需要技巧和努力的工作。|我喜欢能随我的意志来去自如。',NULL,21,34),(2667,NULL,'我喜欢称赞我所崇拜的人。|我喜欢很自如地做我所想做的事。',NULL,22,34),(2668,NULL,'我喜欢将我的信、帐单和其他文件整齐地排列着并以某种系统存档。|我希望独立决定我所要做的事。',NULL,23,34),(2669,NULL,'我喜欢提出的明知没有人能回答得出来的问题。|我喜欢批评权威人士。',NULL,24,34),(2670,NULL,'当我动怒时，我想摔东西。|我喜欢回避责任与义务。',NULL,25,34),(2671,NULL,'我喜欢将所承担有事办成功。|我喜欢结交新朋友。',NULL,26,34),(2672,NULL,'我喜欢遵照指示去做我所该做的事。|我喜欢与朋友有深厚的交情。',NULL,27,34),(2673,NULL,'我喜欢我写的所有的东西都很精确、清楚、有条有理。|我喜欢广交朋友。',NULL,28,34),(2674,NULL,'我喜欢在宴会中说趣闻与笑话。|我喜欢写信给我的朋友。',NULL,29,34),(2675,NULL,'我喜欢能随我的意志来去自如。|我喜欢与朋友共享一切。',NULL,30,34),(2676,NULL,'我喜欢解答别人认为困难的谜语与问题。|我喜欢就一个人为什么做去判断他，而不是从他实际上做什么去判断他。',NULL,31,34),(2677,NULL,'我喜欢接受我所崇拜的人领导。|我喜欢了解我的朋友们对他们所面对的各种问题怎样感觉。',NULL,32,34),(2678,NULL,'我喜欢饮食有规律，并且在固定时间吃东西。|我喜欢研究与分析别人的行动。',NULL,33,34),(2679,NULL,'我喜欢说些别人认为机智与聪明的事。|我喜欢将自己放在别人的立场上，看自己若处于相同的情境会有什么感觉。',NULL,34,34),(2680,NULL,'我喜欢照我的意思做我想做的事。|我喜欢观察其他人在某个场合的感觉。',NULL,35,34),(2681,NULL,'我喜欢完成别人认为需要技巧和努力的工作。|我喜欢在我失败的时候朋友们能鼓励我。',NULL,36,34),(2682,NULL,'作计划时，我喜欢从其见解为我所敬重的人那里获得些建议。|我喜欢我的朋友对我仁慈。',NULL,37,34),(2683,NULL,'我喜欢我的朋友的生活安排得好，过得顺利，而不用对我的计划作太多的改变。|当我生病时，我喜欢我的朋友感到不安。',NULL,38,34),(2684,NULL,'我喜欢在团体中成为众目所瞩的对象。|当我受伤或生病时，我喜欢我的朋友小题大作。',NULL,39,34),(2685,NULL,'我喜欢回避要我按照例行方法办事的场合。|当我沮丧时，我喜欢我的朋友们同情并使我愉快。',NULL,40,34),(2686,NULL,'我想写一本伟大的小说或剧本。|当作为群众团体的一个成员时，我喜欢被指定或被选为领导者。',NULL,41,34),(2687,NULL,'在团体中，我喜欢接受别人的领导来决定团体该做什么。|只要可能，我就喜欢监督与指导别人的行动。',NULL,42,34),(2688,NULL,'我喜欢将我的信、帐单或其他文件整齐地排列着，并依某种系统存档。|我喜欢成为我所属的机构与团体的领导者之一。',NULL,43,34),(2689,NULL,'我喜欢问些明知没人回答得出来的问题。|我喜欢告诉别人怎么做他们的工作。',NULL,44,34),(2690,NULL,'我喜欢回避责任与义务。|我喜欢被人们叫去做和事佬。',NULL,45,34),(2691,NULL,'我喜欢在某种职业、专业或专门的项目上成为公认的权威。|每当我做错了事，我感到有罪恶感。',NULL,46,34),(2692,NULL,'我喜欢读伟人的故事。|我觉得我必须承认我所做的一些错事。',NULL,47,34),(2693,NULL,'对我所承担的任何工作，我喜欢对其细节作好计划与组织。|当事情不顺时，我感到我比任何人更该受到责备。',NULL,48,34),(2694,NULL,'我喜欢用些别人常常不明白其意义的字眼。|我觉得样样不如别人。',NULL,49,34),(2695,NULL,'我喜欢批评权威人士。|在认为是我的上司的人面前，我感到胆怯。',NULL,50,34),(2696,NULL,'对我所承担的一切事情，我喜欢尽力而为。|我喜欢帮助比我不幸的人。',NULL,51,34),(2697,NULL,'我喜欢探求伟人们对我所感兴趣的各种问题有什么看法。|我喜欢对我的朋友们慷慨。',NULL,52,34),(2698,NULL,'在处理难题时，我喜欢在开始之前作计划。|我喜欢为我的朋友做点小事。',NULL,53,34),(2699,NULL,'我喜欢对别人谈我所经历的冒险与奇特的事。|我喜欢我的朋友信任我，并对我倾诉他们的麻烦。',NULL,54,34),(2700,NULL,'我喜欢发表我对事情的看法。|我喜欢原谅有时可能伤害了我的朋友。',NULL,55,34),(2701,NULL,'我喜欢自己能比别人做得更好。|我喜欢在新奇的餐厅里吃饮。',NULL,56,34),(2702,NULL,'我喜欢遵从习俗避免做我所尊敬的人认为不合常规的事情。|我喜欢追求。',NULL,57,34),(2703,NULL,'在开始工作之前，我喜欢对它做好组织和计划。|我喜欢旅行和到处观光。',NULL,58,34),(2704,NULL,'在公共场合，我喜欢人们注意和评价我的外表。|我喜欢搬家，住到不同的地方。',NULL,59,34),(2705,NULL,'我喜欢独立决定我所要做的事。|我喜欢做些新鲜且有变化的事。',NULL,60,34),(2706,NULL,'我喜欢我能自豪地说我解决了一个难题。|对我所承担的事，我喜欢认真去做。',NULL,61,34),(2707,NULL,'当我认为我的上司做得对时，我喜欢对他们表示我的看法。|我喜欢在接受其他事之前完成手头的事。',NULL,62,34),(2708,NULL,'假如我必须旅行时，我喜欢事先计划好。|我喜欢继续解我的难题或问题，直到解决为止。',NULL,63,34),(2709,NULL,'我有时喜欢做些事情，只为了想看看别人对此事的反应。|我喜欢固定于某一职业或问题上，甚至看来它好象没有什么希望。',NULL,64,34),(2710,NULL,'我喜欢作别人认为不合常规的事。|我喜欢不受干扰地长时间工作。',NULL,65,34),(2711,NULL,'我喜欢完成具有重大意义的事。|我不在乎与谜人的异性表示亲切。',NULL,66,34),(2712,NULL,'我喜欢称赞我所崇拜的人。|我喜欢被异性认为身材吸引人。',NULL,67,34),(2713,NULL,'我喜欢保持我的书桌与工作间的清洁与整齐。|我喜欢与异性谈情说爱。',NULL,68,34),(2714,NULL,'我喜欢谈我的成就。|我喜欢听或说以性为主的笑话。',NULL,69,34),(2715,NULL,'我喜欢依我的方式做事而不在乎别人的看法。|我喜欢看以性为主的书或剧本。',NULL,70,34),(2716,NULL,'我喜欢写本伟大的小说或剧本。|我喜欢考虑与我看法相反的观点。',NULL,71,34),(2717,NULL,'在团体中我喜欢接受别人的领导来决定团体该做什么。|假如某人罪有应得的话我想公开的进行批评。',NULL,72,34),(2718,NULL,'我喜欢我的生活安排得好，过得顺利而不用对我的计划做太多的改变。|当我动怒时，我想摔东西。',NULL,73,34),(2719,NULL,'我喜欢问些没有人能回答的问题。|我喜欢对别人说我对他们的看法。',NULL,74,34),(2720,NULL,'我喜欢回避责任与义务。|我想取笑那些我认为他们行为愚蠢的人。',NULL,75,34),(2721,NULL,'我喜欢对我的朋友忠实。|对所有我承担的事，我喜欢尽力做好。',NULL,76,34),(2722,NULL,'我喜欢观察别人在某些情况下的感觉。|我喜欢我能自豪在说我成功地解决了一件难题。',NULL,77,34),(2723,NULL,'当我失败时，我喜欢我的朋友鼓励我。|我喜欢将所承担的事做得很成功。',NULL,78,34),(2724,NULL,'我喜欢成为所属机构与团体的领导之一。|我喜欢能比别人做得更好。',NULL,79,34),(2725,NULL,'当发生差错时，我觉得比别人更该受到责备。|我喜欢解答别人认为困难的谜语与问题。',NULL,80,34),(2726,NULL,'我喜欢为我的朋友做事。|作计划时，我喜欢从其见解为我所尊敬的人那里得到些建议。',NULL,81,34),(2727,NULL,'我喜欢将自己放在别人的处境上，去想象同样情况下也会有什么感觉。|当我认为我的上司做得对时，我喜欢对他们表示我的看法。',NULL,82,34),(2728,NULL,'当我有问题时，我喜欢被我的朋友同情与了解。|我喜欢接受我所尊敬的人领导。',NULL,83,34),(2729,NULL,'在郡众团体中，我喜欢被指定或选为领导者。|在团体中，我喜欢接受别人的领导来决定团体该怎么做。',NULL,84,34),(2730,NULL,'假如我作错了事，我觉得应该受到处罚。|我喜欢遵从习俗，避免我所尊敬的我认为不合常规的事。',NULL,85,34),(2731,NULL,'我喜欢与朋友共享一切。|在开始做困难的事情之前，我喜欢先做计划。',NULL,86,34),(2732,NULL,'我喜欢了解我的朋友在面临各种问题时的感觉。|假如我必须旅行，我喜欢先将事情安排好。',NULL,87,34),(2733,NULL,'我喜欢我的朋友对我仁慈。|在开始之前，我喜欢将工作组织计划好。',NULL,88,34),(2734,NULL,'我喜欢被别人看作领导。|我喜欢将我的信、帐单或其他文件整齐地排列着, 并依某种系统存档。',NULL,89,34),(2735,NULL,'我感到我所受的痛苦与折磨对我而言是好处多于坏处。|我喜欢我的生活安排的好，过得顺利，而不用对我的计划做太多的改变。',NULL,90,34),(2736,NULL,'我喜欢与我的朋友有深厚的交情。|我喜欢说些别人认为机智与聪明的事。',NULL,91,34),(2737,NULL,'我喜欢探求朋友们的性格并尝试找出他们成为这样的原因。|我有时喜欢做些事情，只是为了想看看别人对它的反应。',NULL,92,34),(2738,NULL,'当我受伤或生病时，我喜欢，的朋友小题大作。|我喜欢谈我的成就。',NULL,93,34),(2739,NULL,'我喜欢告诉别人该怎么做他们的工作。|我喜欢成为团体中众目所瞩的对象。',NULL,94,34),(2740,NULL,'在所认定的强者面前我感到胆怯。|我喜欢用些别人不懂其义的字眼。',NULL,95,34),(2741,NULL,'我比较喜欢与朋友共事而不喜欢独自工作。|我不表达我对事情的看法。',NULL,96,34),(2742,NULL,'我喜欢研究与分析他人的行动。|我喜欢作别人认为不合常规的事。',NULL,97,34),(2743,NULL,'当我生病时，我喜欢朋友们为我感伤。|我喜欢避免需要依常规做事的场合。',NULL,98,34),(2744,NULL,'只要可能，我喜欢监督与指导别人的行为。|我喜欢依我的方式办事不管别人的想法。',NULL,99,34),(2745,NULL,'我觉得处处不如人。|我喜欢回避责任与义务。',NULL,100,34),(2746,NULL,'我喜欢将我所承担的事办成功。|我喜欢结交新朋友。',NULL,101,34),(2747,NULL,'我喜欢分析我自己的动机与情感。|我喜欢广交朋友。',NULL,102,34),(2748,NULL,'当我遇困难时，我喜欢我的朋友帮助我。|我喜欢为我的朋友做事。',NULL,103,34),(2749,NULL,'当我的观点被冲击时，我喜欢为之辩护。|我喜欢写信给我的朋友。',NULL,104,34),(2750,NULL,'每当我做错事时，我感到内疚。|我喜欢与朋友有深交。',NULL,105,34),(2751,NULL,'我喜欢与朋友共享一切。|我喜欢分析我自己的动机与感情。',NULL,106,34),(2752,NULL,'我喜欢接受我所尊敬的人的领导。|我喜欢了解我的朋友在面临各种问题时的感觉。',NULL,107,34),(2753,NULL,'我喜欢我的朋友们高兴地为我办点小事。|我喜欢从人们为什么那样做而不从他实际做什么来判断人。',NULL,108,34),(2754,NULL,'大家在一起时，我喜欢决定人们该做什么。|我喜欢预测我的朋友们在各种情况下的反应。',NULL,109,34),(2755,NULL,'当我退让或避免了冲突时，我觉得比争取达到目标的还好些。|我喜欢分析他人的感情与动机。',NULL,110,34),(2756,NULL,'我喜欢结交新朋友。|当我有麻烦时，我喜欢我的朋友帮助我。',NULL,111,34),(2757,NULL,'我喜欢从人们为什么那样做而不从他实际做什么来判断人。|我喜欢我的朋友们对我有深情。',NULL,112,34),(2758,NULL,'我喜欢将我的生活安排好，过得顺利，而不用对我的计划作太大的改变。|当我生病时，我喜欢我的朋友们为我感伤。',NULL,113,34),(2759,NULL,'我喜欢被人们叫去作和事佬。|我喜欢我的朋友们高兴地为我办点小事。',NULL,114,34),(2760,NULL,'我觉得我必须承认自己做错了的事。|当我沮丧时，我喜欢我的朋友们同情我，并使我愉快。',NULL,115,34),(2761,NULL,'我喜欢与朋友们共事而不喜欢独自进行工作。|当我的观点被攻击时，我喜欢为之辩护。',NULL,116,34),(2762,NULL,'我喜欢观察我的朋友们的性格，试着找出究竟是什么缘故使他们成为现在这样。|我喜欢能说服与影响其他人去做我想做的事。',NULL,117,34),(2763,NULL,'当我沮丧时我喜欢我的朋友同情我，并使我愉快。|在团体中，我喜欢决定我们该做什么。',NULL,118,34),(2764,NULL,'我喜欢问我明知没有人回答得出来的问题。|我喜欢告诉别人怎么做他们的工作。',NULL,119,34),(2765,NULL,'在我所认定的强者面前，我感到胆怯。|只要我能够的话，我喜欢监督与指导别人的行动。',NULL,120,34),(2766,NULL,'我喜欢加入一个成员之间彼此温暖与友善的团体。|我知道自己作错了事时会感到内疚。',NULL,121,34),(2767,NULL,'我喜欢分析别人的感情与动机。|由于自己无能处理各种情况使我感到沮丧。',NULL,122,34),(2768,NULL,'当我生病时，我喜欢我的朋友们为我感伤。|当我退让与避免争执时，我感到比争取达到目的还好些。',NULL,123,34),(2769,NULL,'我喜欢我能够说服与影响他人做我想做的事。|由于自己无能处理各种情况使我感到沮丧。',NULL,124,34),(2770,NULL,'我喜欢批评权威人士。|在我认为是自己的人面前，我感到胆怯。',NULL,125,34),(2771,NULL,'我喜欢加入在成员之间彼此具有温暖与友善感情的团体。|当我的朋友们有麻烦时，我喜欢帮助他们。',NULL,126,34),(2772,NULL,'我喜欢分析我的动机与情感。|当我的朋友们受伤时，我喜欢同情他们。',NULL,127,34),(2773,NULL,'当我有麻烦时，我喜欢我的朋友帮助我。|我喜欢待人仁慈与同情。',NULL,128,34),(2774,NULL,'我喜欢成为我所属机构与团体的领导之一。|当我朋友受伤或生病时，我喜欢同情他们。',NULL,129,34),(2775,NULL,'我觉得我所受的痛苦与不幸是好处多于坏处。|我喜欢对我的朋友表示自己的深情。',NULL,130,34),(2776,NULL,'我喜欢与朋友共事而不喜欢独立工作。|我喜欢试验与尝试新东西。',NULL,131,34),(2777,NULL,'我喜欢思索我的朋友们的性格，探讨为什么他们象现在这样。|我喜欢尝试新的职业，而不喜欢一直做同样的老事情。',NULL,132,34),(2778,NULL,'当我有问题时，我喜欢我的朋友们能同情与了解。|我喜欢那些原来不熟悉的人。',NULL,133,34),(2779,NULL,'当我的观点被攻击时，我喜欢为之辩护。|我喜欢在日常生活中经历新鲜与变迁。',NULL,134,34),(2780,NULL,'当我退让避免了争执时，我感到比照自己的方式做还好些。|我喜欢搬家住到不同的地方。',NULL,135,34),(2781,NULL,'我喜欢为我的朋友办事。|当我有功课要做时，我喜欢及时做并一直工作至完成为止。',NULL,136,34),(2782,NULL,'我喜欢分析别人的感情与动机。|当我工作时，我喜欢避开干扰。',NULL,137,34),(2783,NULL,'我喜欢我的朋友们高兴地为我办点小事。|我喜欢熬夜将工作完成。',NULL,138,34),(2784,NULL,'我喜欢被别人当作领导。|我喜欢长时间地工作而不受别人干扰。',NULL,139,34),(2785,NULL,'假如我做错了事的话，我觉得我应受责备。|我喜欢坚持我的职业与方向，甚至看来好象没什么进展时，我也不在乎。',NULL,140,34),(2786,NULL,'我喜欢对我的朋友忠实。|我喜欢与迷人的异性约会。',NULL,141,34),(2787,NULL,'我喜欢预测我的朋友在各种情况下的行动。|我喜欢参与有关性与性行为的讨论。',NULL,142,34),(2788,NULL,'我喜欢我的朋友们对我有深情。|我喜欢变得性兴奋。',NULL,143,34),(2789,NULL,'在一群人中，我喜欢由我决定该做什么。|我喜欢参与有性的社交场合。',NULL,144,34),(2790,NULL,'我为自己无力处理各种情况感到沮丧。|我喜欢看以性为主题的书与剧本。',NULL,145,34),(2791,NULL,'我喜欢写信给我的朋友。|我喜欢看报上有关谋杀与其他暴力方面的新闻。',NULL,146,34),(2792,NULL,'我喜欢预测我的朋友们在各种情况下将怎样做。|我喜欢攻击与我观点相反的看法。',NULL,147,34),(2793,NULL,'当我受伤或生病时，我喜欢我的朋友们为我小题大作。|当事情不顺时，我想责怪别人。',NULL,148,34),(2794,NULL,'我喜欢告诉别人如何做他们的工作。|当有人侮辱我时，我想报复。',NULL,149,34),(2795,NULL,'我感到我处处不如人。|当我不赞同他们的看法时，我喜欢说服他们。',NULL,150,34),(2796,NULL,'当我的朋友们有麻烦时，我喜欢帮助他们。|对我所承担的事，我喜欢尽力而为。',NULL,151,34),(2797,NULL,'对我所承担的一切事情，我喜欢认真去做。|我喜欢完成某些具有重大意义的事。',NULL,152,34),(2798,NULL,'对我所承担的一切事情，我喜欢认真去做。|我喜欢完成某些具有重大意义的事。',NULL,153,34),(2799,NULL,'我喜欢与迷人的异性约会。|对我所承担的事我希望能够做成功。',NULL,154,34),(2800,NULL,'我喜欢看报上有关谋杀与其他形式的暴力新闻。|我想写本伟大的小说或剧本。',NULL,155,34),(2801,NULL,'我喜欢为我的朋友们做点小事。|作计划时，我喜欢我所敬重的人给我提出些建议。',NULL,156,34),(2802,NULL,'我喜欢在日常生活中经历新奇与变异。|当我认为我的上司做的对时，我喜欢对他们表示我的看法。',NULL,157,34),(2803,NULL,'我喜欢熬夜将工作完成。|我增欢称赞我所仰慕的人。',NULL,158,34),(2804,NULL,'我喜欢变得性兴奋。|我喜欢接受我所仰慕的人领导。',NULL,159,34),(2805,NULL,'当有人侮辱我时，我想报复。|在团体中，我喜欢接受别人的领导来决定团体该做什么。',NULL,160,34),(2806,NULL,'我喜欢对我的朋友们慷慨。|在做困难的事之前，我喜欢作个计划。',NULL,161,34),(2807,NULL,'我喜欢交新朋友。|我希望我的一切作品都是严密、整齐而有条理的。',NULL,162,34),(2808,NULL,'我喜欢将我开了头的事情或工作完成。|我喜欢使我的书桌与工作间保持清洁与整齐。',NULL,163,34),(2809,NULL,'我喜欢被别人认为身材迷人。|对我所承担的任何事，我喜欢巨细无遗地进行计划与组织。',NULL,164,34),(2810,NULL,'我喜欢告诉别人我对他们的看法。|我喜欢饮食有规律，并在固定的时间吃东西。',NULL,165,34),(2811,NULL,'我喜欢对我的朋友表示深情。|我喜欢说些别人认为机智与聪明的事。',NULL,166,34),(2812,NULL,'我喜欢尝试新的工作而不喜欢一直做同样的老事  情。|我有时想做一些事情的目的只为了想看别人对它的反应。',NULL,167,34),(2813,NULL,'我喜欢坚持自己的工作与方向，即使看来好象已进入了无底深渊，我也不在乎。|在公共场合中我喜欢人注意我和评价我的外表。',NULL,168,34),(2814,NULL,'我喜欢看以性为主题的书与剧本。|在团体中，我喜欢成为众人所注目的对象。',NULL,169,34),(2815,NULL,'当事情不顺时，我想责怪别人。|我喜欢问些明知没人能回答的问题。',NULL,170,34),(2816,NULL,'当我的朋友们受伤或生病时，我喜欢对他们表示同情。|我喜欢说我对事情的看法。',NULL,171,34),(2817,NULL,'我喜欢在新奇的餐厅吃饭。|我喜欢做些别人认为不合常规的事。',NULL,172,34),(2818,NULL,'在承担其他事之前，我喜欢每次只作一件事并将它完成。|我喜欢能自如地做我想作的事。',NULL,173,34),(2819,NULL,'我喜欢参与有关性与性行为的讨论。|我喜欢照我自己的方式来做而不管别人有什么看  法。',NULL,174,34),(2820,NULL,'当我动怒时，我想摔东西。|我喜欢回避责任与义务。',NULL,175,34),(2821,NULL,'当我的朋友们有困难时，我喜欢帮助他们。|我喜欢对我的朋友们忠实。',NULL,176,34),(2822,NULL,'我喜欢做些新鲜的事。|我喜欢交新朋友。',NULL,177,34),(2823,NULL,'当我有功课要做时，我喜欢即时开始并持续到工作完成为止。|我喜欢参与那些成员之间具有温暖与友善情感的团体。',NULL,178,34),(2824,NULL,'我喜欢与迷人的异性约会。|我喜欢广交朋友。',NULL,179,34),(2825,NULL,'我喜欢攻击与我观点相反的看法。|我喜欢给朋友写信。',NULL,180,34),(2826,NULL,'我喜欢对我的朋友们慷慨。|我喜欢观察别人在某一情况下的感觉。',NULL,181,34),(2827,NULL,'我喜欢在新奇的餐厅吃饭。|我喜欢将自己放在别人的立场来想象在同样的情况下我会有什么感觉。',NULL,182,34),(2828,NULL,'我喜欢熬夜将工作完成。|我喜欢预测我的朋友们在各种情况下会怎么做。',NULL,183,34),(2829,NULL,'我喜欢变得性兴奋。|我喜欢研究分析别人的行为。',NULL,184,34),(2830,NULL,'我喜欢取笑那些我觉得是做了蠢事的人。|我喜欢预测我的朋友们在各种情况下会怎么做。',NULL,185,34),(2831,NULL,'对有时伤害我的朋友，我喜欢原谅他们。|当我失败时，我喜欢我的朋友们鼓励我。',NULL,186,34),(2832,NULL,'我喜欢试验与尝试新的事情。|当我有问题时，我喜欢我的朋友们能同情与了解。',NULL,187,34),(2833,NULL,'我喜欢持续地了解迷语与问题,直到解决为止。|我喜欢我的朋友对我仁慈。',NULL,188,34),(2834,NULL,'我喜欢被异性认为身材迷人。|我喜欢我的朋友们对我有深情。',NULL,189,34),(2835,NULL,'假如某人是罪有应得，我会公开批评他。|当我受伤或生病时，我喜欢我的朋友们小题大作。',NULL,190,34),(2836,NULL,'我喜欢对我的朋友们有深情。|我喜欢被人当作领导。',NULL,191,34),(2837,NULL,'我喜欢尝试新的工作而不愿一直做同样的老事情。|在群众团体中，我喜欢被指定或被选为领导。',NULL,192,34),(2838,NULL,'对我起了头的一切事情，我都喜欢将它完成。|我喜欢我能够说服与影响别人做我所要做的事。',NULL,193,34),(2839,NULL,'我喜欢参与有关性行为的讨论。|我愿意被人们叫去做和事佬。',NULL,194,34),(2840,NULL,'当我动怒时，我想摔东西。|我喜欢告诉别人怎么去做他的工作。',NULL,195,34),(2841,NULL,'我喜欢对我的朋友们表示深情。|当事情有差错时，我觉得我比任何人都更该受到责备。',NULL,196,34),(2842,NULL,'我喜欢搬家，住在不同的地方。|当我做错事时，我觉得我该受到处罚。',NULL,197,34),(2843,NULL,'我喜欢坚持自己的工作或方向，甚至当它们看来好象已使我陷入无底深渊时，我也不在乎。|我觉得我所受的痛苦与不幸是好处多于坏处。',NULL,198,34),(2844,NULL,'我喜欢看以性为主题的书与剧本。|我觉得我必须承认有些事我做错了。',NULL,199,34),(2845,NULL,'当事情不顺时，我想责怪别人。|我觉得我处处不如人。',NULL,200,34),(2846,NULL,'对我所承担的一切事情，我喜欢尽力而为。|我喜欢帮助比我不幸的人。',NULL,201,34),(2847,NULL,'我喜欢做新的和各不相同的事。|我喜欢待人仁慈和同情。',NULL,202,34),(2848,NULL,'当我有功课做时，我喜欢及时开始并一直做到完成为止。|我喜欢帮助比我不幸的人。',NULL,203,34),(2849,NULL,'我喜欢参与有异性的社交场合。|我喜欢原谅有时可能伤害了我的朋友。',NULL,204,34),(2850,NULL,'我喜欢攻击与我观点相反的看法。|我喜欢我的朋友们信任我并告诉我他们的问题。',NULL,205,34),(2851,NULL,'我喜欢待人仁慈和同情。|我喜欢旅行到各处看看。',NULL,206,34),(2852,NULL,'我喜欢遵照习俗，避免做人家认为不合常规的事。|我喜欢追求新潮流与时髦。',NULL,207,34),(2853,NULL,'对我所承担的一切事情，  我喜欢认真去做。|我喜欢在日常生活中经历新奇与变异。',NULL,208,34),(2854,NULL,'我不在乎与迷人的异性表示亲近。|我喜欢试验与尝试的事情。',NULL,209,34),(2855,NULL,'当我不赞同他人的意见时，我想指责别人。|我喜欢追求新潮流与时髦。',NULL,210,34),(2856,NULL,'我喜欢帮助比我不幸的人。|我喜欢将我开了头的任何事情或工作完成。',NULL,211,34),(2857,NULL,'我喜欢搬家，住在不同的地方。|我喜欢长时间地工作而不受干扰。',NULL,212,34),(2858,NULL,'假如我必须旅行的话，我喜欢先将事情安排好。|我喜欢持续地解难题直到解出为止。',NULL,213,34),(2859,NULL,'我喜欢与异性谈恋爱。|在承担别的事之前，我喜欢将现在的工作或任务完成。',NULL,214,34),(2860,NULL,'我喜欢对别人说我对他们的看法。|当我工作时，我喜欢避免干扰。',NULL,215,34),(2861,NULL,'我喜欢为我的朋友们办点小事。|我喜欢参与有异性的社交场合。',NULL,216,34),(2862,NULL,'我喜欢见到不熟识的人。|我不在乎与迷人的异性表示亲近。',NULL,217,34),(2863,NULL,'我喜欢持续解难题直到解出为止。|我喜欢与异性谈恋爱。',NULL,218,34),(2864,NULL,'我喜欢谈论我的成就。|我喜欢听或说以性为主的笑话。',NULL,219,34),(2865,NULL,'我想取笑那些我认为是做了蠢事的人。|我喜欢听或说以性为主的笑话。',NULL,220,34),(2866,NULL,'我喜欢我的朋友们信任我，并告诉我他们的麻烦。|我喜欢报上有关谋杀与其它形式暴力的新闻。',NULL,221,34),(2867,NULL,'我喜欢追求新潮流与时髦。|假如某人罪有应得，我会公开批评他。',NULL,222,34),(2868,NULL,'当我工作时，我喜欢避免干扰。|当我不赞同别人的看法，我想责怪他们。',NULL,223,34),(2869,NULL,'我喜欢听说以性为主的笑话。|当有人侮辱我时，我想报复。',NULL,224,34),(2870,NULL,'我喜欢回避责任与义务。|当有人做了我认为很愚蠢的事情时，我想取笑他  们。',NULL,225,34),(2871,'你是否有许多不同的业余爱好？','是|不是',NULL,1,31),(2872,'你是否在做任何事情以前都要停下来仔细思考？','是|不是',NULL,2,31),(2873,'你的心境是否常有起伏？','是|不是',NULL,3,31),(2874,'你曾有过明知是别人的功劳而你去接受奖励的事吗？','是|不是',NULL,4,31),(2875,'你是否健谈？','是|不是',NULL,5,31),(2876,'欠债会使你不安吗？','是|不是',NULL,6,31),(2877,'你曾无缘无故觉得“真是难受”吗？','是|不是',NULL,7,31),(2878,'你曾贪图过份外之物吗？','是|不是',NULL,8,31),(2879,'你是否在晚上小心翼翼地关好门窗？','是|不是',NULL,9,31),(2880,'你是否比较活跃？','是|不是',NULL,10,31),(2881,'你在见到一小孩或一动物受折磨时是否会感到非常难过？','是|不是',NULL,11,31),(2882,'你是否常常为自己不该作而作了的事，不该说而说了的话而紧张吗？','是|不是',NULL,12,31),(2883,'你喜欢跳降落伞吗？','是|不是',NULL,13,31),(2884,'通常你能在热闹联欢会中尽情地玩吗？','是|不是',NULL,14,31),(2885,'你容易激动吗？','是|不是',NULL,15,31),(2886,'你曾经将自己的过错推给别人吗？','是|不是',NULL,16,31),(2887,'你喜欢会见陌生人吗？','是|不是',NULL,17,31),(2888,'你是否相信保险制度是一种好办法？','是|不是',NULL,18,31),(2889,'你是一个容易伤感情的人吗？','是|不是',NULL,19,31),(2890,'你所有的习惯都是好的吗？','是|不是',NULL,20,31),(2891,'在社交场合你是否总不愿露头角？','是|不是',NULL,21,31),(2892,'你会服用奇异或危险作用的药物吗？','是|不是',NULL,22,31),(2893,'你常有“厌倦”之感吗？','是|不是',NULL,23,31),(2894,'你曾拿过别人的东西吗（那怕一针一线）？','是|不是',NULL,24,31),(2895,'你是否常爱外出？','是|不是',NULL,25,31),(2896,'你是否从伤害你所宠爱的人而感到乐趣？','是|不是',NULL,26,31),(2897,'你常为有罪恶之感所苦恼吗？','是|不是',NULL,27,31),(2898,'你在谈论中是否有时不懂装懂？','是|不是',NULL,28,31),(2899,'你是否宁愿去看书而不愿去多见人？','是|不是',NULL,29,31),(2900,'你有要伤害你的仇人吗？','是|不是',NULL,30,31),(2901,'你觉得自己是一个神经过敏的人吗？','是|不是',NULL,31,31),(2902,'对人有所失礼时你是否经常要表示歉意？','是|不是',NULL,32,31),(2903,'你有许多朋友吗？','是|不是',NULL,33,31),(2904,'你是否喜爱讲些有时确能伤害人的笑话？','是|不是',NULL,34,31),(2905,'你是一个多忧多虑的人吗？','是|不是',NULL,35,31),(2906,'你在童年是否按照吩咐要做什么便做什么，毫无怨言？','是|不是',NULL,36,31),(2907,'你认为你是一个乐天派吗？','是|不是',NULL,37,31),(2908,'你很讲究礼貌和整洁吗？','是|不是',NULL,38,31),(2909,'你是否总在担心会发生可怕的事情？','是|不是',NULL,39,31),(2910,'你曾损坏或遗失过别人的东西吗？','是|不是',NULL,40,31),(2911,'交新朋友时一般是你采取主动吗？','是|不是',NULL,41,31),(2912,'当别人向你诉苦时，你是否容易理解他们的苦哀？','是|不是',NULL,42,31),(2913,'你认为自己很紧张，如同“拉紧的弦”一样吗？','是|不是',NULL,43,31),(2914,'在没有废纸篓时，你是否将废纸扔在地板上？','是|不是',NULL,44,31),(2915,'当你与别人在一起时，你是否言语很少？','是|不是',NULL,45,31),(2916,'你是否认为结婚制度是过时了，应该废止？','是|不是',NULL,46,31),(2917,'你是否有时感到自己可怜？','是|不是',NULL,47,31),(2918,'你是否有时有点自夸？','是|不是',NULL,48,31),(2919,'你是否很容易将一个沉寂的集会搞得活跃起来？','是|不是',NULL,49,31),(2920,'你是否讨厌那种小心翼翼地开车的人？','是|不是',NULL,50,31),(2921,'你为你的健康担忧吗？','是|不是',NULL,51,31),(2922,'你曾讲过什么人的坏话吗？','是|不是',NULL,52,31),(2923,'你是否喜欢对朋友讲笑话和有趣的故事？','是|不是',NULL,53,31),(2924,'你小时候曾对父母粗暴无礼吗？','是|不是',NULL,54,31),(2925,'你是否喜欢与人混在一起？','是|不是',NULL,55,31),(2926,'你如知道自己工作有错误，这会使你感到难过吗？','是|不是',NULL,56,31),(2927,'你患失眠吗？','是|不是',NULL,57,31),(2928,'你吃饭前必定洗手吗？','是|不是',NULL,58,31),(2929,'你常无缘无故感到无精打采和倦怠吗？','是|不是',NULL,59,31),(2930,'和别人玩游戏时，你有过欺骗行为吗？','是|不是',NULL,60,31),(2931,'你是否喜欢从事一些动作迅速的工作？','是|不是',NULL,61,31),(2932,'你的母亲是一位善良的妇人吗？','是|不是',NULL,62,31),(2933,'你是否常常觉得人生非常无味？','是|不是',NULL,63,31),(2934,'你曾利用过某人为自己取得好处吗？','是|不是',NULL,64,31),(2935,'你是否常常参加许多活动，超过你的时间所允许？','是|不是',NULL,65,31),(2936,'是否有几个人总在躲避你？','是|不是',NULL,66,31),(2937,'你是否为你的容貌而非常烦恼？','是|不是',NULL,67,31),(2938,'你是否觉得人们为了未来有保障而办理储蓄和保险所花的时间太多？','是|不是',NULL,68,31),(2939,'你曾有过不如死了为好的愿望吗？','是|不是',NULL,69,31),(2940,'如果有把握永远不会被别人发现，你会逃税吗？','是|不是',NULL,70,31),(2941,'你能使一个集会顺利进行吗？','是|不是',NULL,71,31),(2942,'你能克制自己不对人无礼吗？','是|不是',NULL,72,31),(2943,'遇到一次难堪的经历后，你是否在一段很长的时间内还感到难受？','是|不是',NULL,73,31),(2944,'你患有“神经过敏”吗？','是|不是',NULL,74,31),(2945,'你曾经故意说些什么来伤害别人的感情吗？','是|不是',NULL,75,31),(2946,'你与别人的友谊是否容易破裂，虽然不是你的过错？','是|不是',NULL,76,31),(2947,'你常感到孤单吗？','是|不是',NULL,77,31),(2948,'当人家寻你的差错，找你工作中的缺点时，你是否容易在精神上受挫伤？','是|不是',NULL,78,31),(2949,'你赴约会或上班曾迟到过吗？','是|不是',NULL,79,31),(2950,'你喜欢忙忙碌碌地过日子吗？','是|不是',NULL,80,31),(2951,'你愿意别人怕你吗？','是|不是',NULL,81,31),(2952,'你是否觉得有时浑身是劲，而有时又是懒洋洋的吗？','是|不是',NULL,82,31),(2953,'你有时把今天应做的事拖到明天去做吗？','是|不是',NULL,83,31),(2954,'别人认为你是生气勃勃吗？','是|不是',NULL,84,31),(2955,'别人是否对你说了许多谎话？','是|不是',NULL,85,31),(2956,'你是否容易对某些事物容易冒火？','是|不是',NULL,86,31),(2957,'当你犯了错误时，你是否常常愿意承认它？','是|不是',NULL,87,31),(2958,'你会为一动物落入圈套被捉拿而感到很难过吗？','是|不是',NULL,88,31),(2959,'我很明了本测验的说明:','是的|不一定|不是的',NULL,1,32),(2960,'我对本测验每个问题都会按自己的真实情况作答:','是的|不一定|不同意',NULL,2,32),(2961,'有度假机会时,我宁愿:','去一个繁华的都市|介乎A与C之间|闲居清静而偏僻的郊区',NULL,3,32),(2962,'我有足够的能力应付困难:','是的|不一定|不是的',NULL,4,32),(2963,'即使是关在铁笼内的猛兽,我见了也会惴惴不安:','是的|不一定|不是的',NULL,5,32),(2964,'我总避免批评别人的言行:','是的|有时如此|不是的',NULL,6,32),(2965,'我的思想似乎:','走在了时代前面|不太一定|正符合时代',NULL,7,32),(2966,'我不擅长说笑话讲趣事:','是的|介乎A与C之间|不是的',NULL,8,32),(2967,'当我看到亲友邻居争执时,我总是:','任其自己解决|置之不理|予以劝解',NULL,9,32),(2968,'在社交场合中,我:','谈吐自然|介乎A与C之间|退避三舍,保持沉默',NULL,10,32),(2969,'我愿做一名:','建筑工程师|不确定|社会科学的教员',NULL,11,32),(2970,'阅读时,我宁愿选读:','著名的宗教教义|不确定|国家政治组织的理论',NULL,12,32),(2971,'我相信许多人都有些心理不正常，但他们都不愿意这样承认:','是的|介乎A与C之间|不是的',NULL,13,32),(2972,'我所希望的结婚对象应擅长交际而无须有文艺才能:','是的|不一定|不是的',NULL,14,32),(2973,'对于头脑简单和不讲理的人,我仍然能待之以礼:','是的|介乎A与C之间|不是的',NULL,15,32),(2974,'受人侍奉时我常感到不安:','是的|介乎A与C之间|不是的',NULL,16,32),(2975,'从事体力或脑力劳动后，我比平常人需要更多的休息才能恢复工作效率:','是的|介乎A与C之间|不是的',NULL,17,32),(2976,'半夜醒来,我会为种种忧虑而不能再入眠:','常常如此|有时如此|极少如此',NULL,18,32),(2977,'事情进行不顺利时,我常会急得掉眼泪:','从不如此|有时如此|时常如此',NULL,19,32),(2978,'我认为只要双方同意就可以离婚，不应当受传统礼教的束缚:','是的|介乎A与C之间|不是的',NULL,20,32),(2979,'我对于人或物的兴趣都很容易改变:','是的|介乎A与C之间|不是的',NULL,21,32),(2980,'筹划事务时,我宁愿:','和别人合作|不确定|自己单独进行',NULL,22,32),(2981,'我常会无端地自言自语:','常常如此|偶然如此|从不如此',NULL,23,32),(2982,'无论工作,饮食或出游,我总:','很匆忙,不能尽兴|介乎A与C之间|很从容不迫',NULL,24,32),(2983,'有时我会怀疑别人是否对我的言谈真正有兴趣:','是的|介乎A与C之间|不是的',NULL,25,32),(2984,'在工厂中,我宁愿负责:','机械组|介乎A与C之间|人事组',NULL,26,32),(2985,'在阅读时,我宁愿选读:','太空旅行|不太确定|家庭教育',NULL,27,32),(2986,'下列三个字中哪个字与其它两个字属于不同类别:','狗|石|牛',NULL,28,32),(2987,'如果我能重新做人,我要:','把生活安排得和以前不同|不确定|生活得和以前相仿',NULL,29,32),(2988,'在我的一生中,我总能达到我所预期的目标:','是的|不一定|不是的',NULL,30,32),(2989,'当我说谎时,我总觉得内心不安,不敢正视对方:','是的|不一定|不是的',NULL,31,32),(2990,'假使我手持一支装有子弹的手枪，我必须取出子弹后才能心安:','是的|介乎A与C之间|不是的',NULL,32,32),(2991,'朋友们大都认为我是一个说话有风趣的人:','是的|不一定|不是的',NULL,33,32),(2992,'如果人们知道我的内心世界,他们都会感到惊讶:','是的|不一定|不是的',NULL,34,32),(2993,'在社交场合中,如果我突然成为众所注意的中心,我会感到局促不安:','是的|介乎A与C之间|不是的',NULL,35,32),(2994,'我总喜欢参加规模庞大的聚会,舞会或公共集会:','是的|介乎A与C之间|不是的',NULL,36,32),(2995,'在下列工作中,我喜欢的是:','音乐|不一定|手工',NULL,37,32),(2996,'我常常怀疑那些过于友善的人动机是否如此:','是的|介乎A与C之间|不是的',NULL,38,32),(2997,'我宁愿自己的生活象:','一个艺人或博物学家|不确定|会计师或保险公司的经纪人',NULL,39,32),(2998,'目前世界所需要的是:','多产生一些富有改善世界计划的理想家|不确定|脚踏实地的可靠公民',NULL,40,32),(2999,'有时候我觉得我需要做剧烈的体力活动:','是的|介乎A与C之间|不是的',NULL,41,32),(3000,'我愿意与有礼貌有教养的人来往，而不愿和粗卤野蛮的人为伍:','是的|介乎A与C之间|不是的',NULL,42,32),(3001,'在处理一些必须凭籍智慧的事务中,我的父母的确:','较一般人差|普通|超人一等',NULL,43,32),(3002,'当上司(或教师)召见我时,我:','总觉得可以趁机会提出建议|介乎A与C之间|总怀疑自己做错了什么事',NULL,44,32),(3003,'假使薪俸优厚,我愿意专任照料精神病人的职务:','是的|介乎A与C之间|不是的',NULL,45,32),(3004,'看报时,我喜欢读:','当前世界基本社会问题的辩论|介乎A与C之间|地方新闻的报道',NULL,46,32),(3005,'我曾担任过:','一般职务|多种职务|非常多的职务',NULL,47,32),(3006,'逛街时,我宁愿观看一个画家写生,而不愿听人家的辩论:','是的|不一定|不是的',NULL,48,32),(3007,'我的神经脆弱,稍有刺激的声音就会使我战惊:','时常如此|有时如此|从未如此',NULL,49,32),(3008,'我在清晨起身时,就常常感到疲乏不堪:','是的|介乎A与C之间|不是的',NULL,50,32),(3009,'我宁愿是一个:','管森林的工作人员|不一定|中小学教员',NULL,51,32),(3010,'每逢年节或亲友生日,我:','喜欢互相赠送礼物|不太确定|觉得交换礼物是麻烦多事',NULL,52,32),(3011,'下列数字中,哪个数字与其他两个数字属于不同类别:','  5|  2|  7',NULL,53,32),(3012,'[猫]与[鱼]就如同[牛]与:','牛乳|牧草|盐',NULL,54,32),(3013,'在做人处事的各个方面,我的父母很值得敬佩:','是的|不一定|不是的',NULL,55,32),(3014,'我觉得我有一些别人所不及的优良品质:','是的|不一定|不是的',NULL,56,32),(3015,'只要有利于大家,尽管别人认为卑贱的工作,我也乐而为之,不以为耻:','是的|不太确定|不是的',NULL,57,32),(3016,'我喜欢看电影或参加其他娱乐活动:','每周一次以上(比一般人多)|每周一次(与通常人相似)|偶然一次(比通常人少)',NULL,58,32),(3017,'我喜欢从事需要精确技术的工作:','是的|介乎A与C之间|不是的',NULL,59,32),(3018,'在有思想,有地位的长者面前,我总较为缄默:','是的|介乎A与C之间|不是的',NULL,60,32),(3019,'就我来说,在大众前演讲或表演是一件不容易的事:','是的|介乎A与C之间|不是的',NULL,61,32),(3020,'我宁愿:','指挥几个人工作|不确定|和团体共同工作',NULL,62,32),(3021,'纵使我做了一桩贻笑大方的事，我也仍然能够将它淡然忘却:','是的|介乎A与C之间|不是的',NULL,63,32),(3022,'没有人会幸灾乐祸地希望我遭遇困难:','是的|不确定|不是的',NULL,64,32),(3023,'堂堂男子汉应该:','考虑人生的意义|不确定|谋家庭的温饱',NULL,65,32),(3024,'我喜欢解决别人已弄得一塌糊涂的问题:','是的|介乎A与C之间|不是的',NULL,66,32),(3025,'我十分高兴的时候总有[好景不常]之感:','是的|介乎A与C之间|不是的',NULL,67,32),(3026,'在一般困难处境下,我总能保持乐观:','是的|不一定|不是的',NULL,68,32),(3027,'迁居是一桩极不愉快的事:','是的|介乎A与C之间|不是的',NULL,69,32),(3028,'在我年轻的时候,如果我和父母的意见不同,我经常:','坚持自己的意见|介乎A与C之间|接受他们的意见',NULL,70,32),(3029,'我希望我的爱人能够使家庭:','有其本身的欢乐与活动|介乎A与C之间|成为邻里社交活动的一部分',NULL,71,32),(3030,'我解决问题多数依靠:','个人独立思考|介乎A与C之间|与人互相讨论',NULL,72,32),(3031,'需要[当机立断]时,我总:','镇静地运用理智|介乎A与C之间|常常紧张兴奋,不能冷静思考',NULL,73,32),(3032,'最近,在一两桩事情上,我觉得自己是无辜受累:','是的|介乎A与C之间|不是的',NULL,74,32),(3033,'我善于控制我的表情:','是的|介乎A与C之间|不是的',NULL,75,32),(3034,'如果薪俸相等,我宁愿做:','一个化学研究师|不确定|旅行社经理',NULL,76,32),(3035,'[惊讶]与[新奇]犹如[惧怕]与:','勇敢|焦虑|恐怖',NULL,77,32),(3036,'下列三个分数中,哪一个与其他两个属不同类别:','  3/7|  3/9|  3/11',NULL,78,32),(3037,'不知什么缘故,有些人故意回避或冷淡我:','是的|不一定|不是的',NULL,79,32),(3038,'我虽善意待人,却得不到好报:','是的|不一定|不是的',NULL,80,32),(3039,'我不喜欢那些夜郎自大,目空一切的人:','是的|介乎A与C之间|不是的',NULL,81,32),(3040,'和一般人相比,我的朋友的确太少:','是的|介乎A与C之间|不是的',NULL,82,32),(3041,'出于万不得已时,我才参加社交集会,否则我总设法回避:','是的|不一定|不是的',NULL,83,32),(3042,'在服务机关中,对上级的逢迎得当,比工作上的表现更为重要:','是的|介乎A与C之间|不是的',NULL,84,32),(3043,'参加竞赛时,我看重的是竞赛活动,而不计较其成败:','总是如此|一般如此|偶然如此',NULL,85,32),(3044,'我宁愿我所就的职业有:','固定可靠的薪水|介乎A与C之间|薪资高低能随我工作的表现而随时调整',NULL,86,32),(3045,'我宁愿阅读:','军事与政治的事实记载|不一定|一部富有情感与幻想的作品',NULL,87,32),(3046,'有许多人不敢欺骗或犯罪,主要原因是怕受到惩罚:','是的|介乎A与C之间|不是的',NULL,88,32),(3047,'我的父母(或保护人)从未很严格地要我事事顺从:','是的|不一定|不是的',NULL,89,32),(3048,'[百折不挠][再接再励]的精神似乎完全被现代人忽视了:','是的|不一定|不是的',NULL,90,32),(3049,'如果有人对我发怒,我总:','设法使他镇静下来|不太确定|也会恼怒起来',NULL,91,32),(3050,'我希望大家都提倡:','多吃水果以避免杀生|不一定|发展农业捕灭对农产品有害的动物',NULL,92,32),(3051,'无论在极高的屋顶上或极深的隧道中，我很少觉得胆怯不安:','是的|介乎A与C之间|不是的',NULL,93,32),(3052,'我只要没有过错,不管人家怎样归咎于我,我总能心安理得:','是的|不一定|不是的',NULL,94,32),(3053,'凡是无法运用理智来解决的问题，有时就不得不靠权力来处理:','是的|介乎A与C之间|不是的',NULL,95,32),(3054,'我十六、七岁时与异性朋友的交游:','极多|介乎A与C之间|不很多',NULL,96,32),(3055,'我在交际场或所参加的组织中是一个活跃分子:','是的|介乎A与C之间|不是的',NULL,97,32),(3056,'在人声噪杂中,我仍能不受妨碍,专心工作:','是的|介乎A与C之间|不是的',NULL,98,32),(3057,'在某环境下,我常因困惑引起幻想而将工作搁置下来:','是的|介乎A与C之间|不是的',NULL,99,32),(3058,'我很少用难堪的话去中伤别人的感情:','是的|不太确定|不是的',NULL,100,32),(3059,'我更愿意做一名:','商店经理|不确定|建筑师',NULL,101,32),(3060,'[理不胜辞]的意思是:','理不如辞|理多而辞寡|辞藻丰富而理由不足',NULL,102,32),(3061,'[锄头]与[挖掘]犹如[刀子]与:','雕刻|切剖|铲除',NULL,103,32),(3062,'我常横过街道,以回避我不愿招乎的人:','很少如此|偶然如此|有时如此',NULL,104,32),(3063,'在我倾听音乐时,如果人家高谈阔论:','我仍然能够专心听,不受影响|介乎A与C之间|我会不能专心欣赏而感到恼恐',NULL,105,32),(3064,'在课堂上,如果我的意见与教师不同,我常:','保持缄默|不一定|当场表明立场',NULL,106,32),(3065,'我和异性友伴交谈时, 竭力避免涉及有关 [性] 的话题:','是的|介乎A与C之间|不是的',NULL,107,32),(3066,'我待人接物的确不太成功:','是的|不尽然|不是的',NULL,108,32),(3067,'每当考虑困难问题时,我总是:','一切都未雨稠缪|介乎A与C之间|相信到时候会自然解决',NULL,109,32),(3068,'我所结交的朋友中,男女各占一半:','是的|介乎A与C之间|不是的',NULL,110,32),(3069,'我宁可:','结识很多的人|不一定|维持几个深交的朋友',NULL,111,32),(3070,'我宁为哲学家,而不做机械工程师:','是的|不确定|不是的',NULL,112,32),(3071,'如果我发现某人自私不义，我总不计一切指摘他的弱点:','是的|介乎A与C之间|不是的',NULL,113,32),(3072,'我善用心机去影响同伴,使他们能协助实现我的目标:','是的|介乎A与C之间|不是的',NULL,114,32),(3073,'我喜欢做戏剧,音乐,歌剧等新闻采访工作:','是的|不一定|不是的',NULL,115,32),(3074,'当人们颂扬我时,我总觉得不好意思:','是的|介乎A与C之间|不是的',NULL,116,32),(3075,'我以为现代最需要解决的问题是:','政治纠纷|不太确定|道德标准的有无',NULL,117,32),(3076,'我有时会无故地产生一种面临横祸的恐惧:','是的|有时如此|不是的',NULL,118,32),(3077,'我在童年时,害怕黑暗的次数:','极多|不太多|没有',NULL,119,32),(3078,'黄昏闲暇,我喜欢:','看一部历史探险影片|不一定|念一本科学幻想小说',NULL,120,32),(3079,'当人们批评我古怪时,我觉得:','非常气恼|有些动气|无所谓',NULL,121,32),(3080,'在一个陌生的城市找住址时,我经常:','就人问路|介乎A与C之间|参考市区地图',NULL,122,32),(3081,'朋友们申言要在家休息时,我仍设法怂恿他们外出:','是的|不一定|不是的',NULL,123,32),(3082,'在就寝时,我:','不易入睡|介乎A与C之间|极容易入睡',NULL,124,32),(3083,'有人烦扰我时,我:','能不露生色|介乎A与C之间|要说给别人听,以泄气愤',NULL,125,32),(3084,'如果薪俸相等,我宁愿做一个:','律师|不确定|飞行员或航海员',NULL,126,32),(3085,'时间永恒是比喻:','时间过得很慢|忘了时间|光阴一去不复返',NULL,127,32),(3086,'下列三项记号中,哪一项应紧接:*OOOO**OOO***','  *O*|  OO*|  O**',NULL,128,32),(3087,'在陌生的地方,我仍能清楚地辩别东西南北的方向:','是的|介乎A与C之间|不是的',NULL,129,32),(3088,'我的确比一般人幸运,因为我能从事自己所乐的工作:','是的|不一定|不是的',NULL,130,32),(3089,'如果我急于想借用别人的东西而物主恰又不在，我认为不告而取亦无大碍:','是的|介乎A与C之间|不是的',NULL,131,32),(3090,'我喜欢向友人追述一些已往有趣的社交经验:','是的|介乎A与C之间|不是的',NULL,132,32),(3091,'我更愿意做一名:','演员|不确定|建筑师',NULL,133,32),(3092,'工作学习之余,我总要安排计划,不使时间浪费:','是的|介乎A与C之间|不是的',NULL,134,32),(3093,'与人交际时,我常会无端地产生一种自卑感:','是的|介乎A与C之间|不是的',NULL,135,32),(3094,'主动与陌生人交谈:','是一桩难事|介乎A与C之间|毫无困难',NULL,136,32),(3095,'我喜欢的音乐,多数是:','轻快活泼|介乎A与C之间|富于情感',NULL,137,32),(3096,'我爱做[白日梦]即[完全沉浸于幻想之中]:','是的|不一定|不是的',NULL,138,32),(3097,'未来二十年的世界局势定将好:','是的|不一定|不是的',NULL,139,32),(3098,'童年时,我喜欢阅读:','战争故事|不确定|神仙幻想故事',NULL,140,32),(3099,'我素来对机械、汽车、飞机等有兴趣:','是的|介乎A与C之间|不是的',NULL,141,32),(3100,'我愿意做一个缓刑释放罪犯的管理监视人:','是的|介乎A与C之间|不是的',NULL,142,32),(3101,'人们认为我只不过是一个能苦干,稍有成就的人而已:','是的|介乎A与C之间|不是的',NULL,143,32),(3102,'在逆境中,我总能保持精神振奋:','是的|不太确定|不是的',NULL,144,32),(3103,'我以为人工节育是解决世界经济与和平问题的要诀:','是的|不太确定|不是的',NULL,145,32),(3104,'我喜欢独自筹划，避免人家的干涉和猜议:','是的|介乎A与C之间|不是的',NULL,146,32),(3105,'我相信[上司不可能没有过错,但他仍有权做当权者]:','是的|不一定|不是的',NULL,147,32),(3106,'我总设法使自己不粗心大意,忽略细节:','是的|介乎A与C之间|不是的',NULL,148,32),(3107,'与人争辩或险遭事故后，我常发抖，精疲力竭，不能安心工作:','是的|介乎A与C之间|不是的',NULL,149,32),(3108,'没有医生处方,我从不乱用药:','是的|介乎A与C之间|不是的',NULL,150,32),(3109,'为了培养个人的兴趣,我愿意参加:','摄影组|不确定|辩论会',NULL,151,32),(3110,'星火,燎原对等于姑息:','同情|养奸|纵容',NULL,152,32),(3111,'[钟表]与[时间]犹如[载缝]与:','西装|剪刀|布料',NULL,153,32),(3112,'生动的梦境常常滋扰我的睡眠:','时常如此|偶然如此|从未如此',NULL,154,32),(3113,'我过去曾撕毁一些禁止人们自由的布告:','是的|介乎A与C之间|不是的',NULL,155,32),(3114,'在一个陌生的城市中,我会:','到处闲游|不确定|避免去较不安全的地方',NULL,156,32),(3115,'我宁愿服饰素洁大方,而不愿争奇斗艳惹人注目:','是的|不太确定|不是的',NULL,157,32),(3116,'黄昏时,安静的娱乐远胜过热闹的宴会:','是的|不太确定|不是的',NULL,158,32),(3117,'我常常明知故犯,不愿意接受好心的建议:','偶然如此|罕有如此|从不如此',NULL,159,32),(3118,'我总把[是非][善恶]作为判断或取舍的原则:','是的|介乎A与C之间|不是的',NULL,160,32),(3119,'我工作时不喜欢有许多人在旁参观:','是的|介乎A与C之间|不是的',NULL,161,32),(3120,'故意去为难一般有教养的人, 如医生, 教师等人的尊严, 是一件有趣的事:','是的|介乎A与C之间|不是的',NULL,162,32),(3121,'在各种课程中,我较喜欢:','语文|不确定|数学',NULL,163,32),(3122,'那些自以为是、道貌岸然的人最使我生气:','是的|介乎A与C之间|不是的',NULL,164,32),(3123,'与平常循规蹈矩的人交谈:','颇有兴趣.亦有所得|介乎A与C之间|他们思想的肤浅使我厌烦',NULL,165,32),(3124,'我喜欢:','有几个有时对我很苛求而富有感情的朋友|介乎A与C之间|不受别人的牵涉',NULL,166,32),(3125,'如果做民意投票时,我宁愿投票赞同:','切实根绝有生理缺陷者的生育|不确定|对杀人犯判处死刑',NULL,167,32),(3126,'我有时会无端地感到沮丧痛苦:','是的|介乎A与C之间|不是的',NULL,168,32),(3127,'当我与立场相反的人辩论时,我主张:','尽量找出基本观点的差异|不一定|彼此让步以解决矛盾',NULL,169,32),(3128,'我一向重感情而不重理智,因此我的观点常动摇不定:','是的|不敢如此|不是的',NULL,170,32),(3129,'我的学习效率多有赖于:','阅读好书|介乎A与C之间|参加团体讨论',NULL,171,32),(3130,'我宁选一个薪俸高的工作,不在乎有无保障;而不愿任薪俸低的固定工作:','是的|不太确定|不是的',NULL,172,32),(3131,'在参加辩论以前,我总先把握住自己的立场:','经常如此|一般如此|必要时才如此',NULL,173,32),(3132,'我常被一些无所谓的琐事所烦扰:','是的|介乎A与C之间|不是的',NULL,174,32),(3133,'我宁愿住在嘈杂的城市,而不愿住在安静的乡村:','是的|不太确定|不是的',NULL,175,32),(3134,'我宁愿:','负责领导儿童游戏|不确定|协助钟表修理',NULL,176,32),(3135,'一人__事,众人受累:','愤|偾|喷',NULL,177,32),(3136,'望子成龙的家长往往__苗助长:','揠|堰|偃',NULL,178,32),(3137,'气侯的转变并不影响我的情绪:','是的|介乎A与C之间|不是的',NULL,179,32),(3138,'因为我对于一切问题都有些见解，大家都公认我富于思想:','是的|介乎A与C之间|不是的',NULL,180,32),(3139,'我讲话的声音:','宏亮|介乎A与C之间|低沉',NULL,181,32),(3140,'人们公认我是一个活跃热情的人:','是的|介乎A与C之间|不是的',NULL,182,32),(3141,'我喜欢有旅行和变动机会的工作，而不计较工作本身之是否有保障:','是的|介乎A与C之间|不是的',NULL,183,32),(3142,'我治事严格,凡事都务求正确尽善:','是的|介乎A与C之间|不是的',NULL,184,32),(3143,'在取回或归还东西时，我总仔细检查是否东西还保持原状:','是的|介乎A与C之间|不是的',NULL,185,32),(3144,'我通常精力充沛,忙碌多事:','是的|不一定|不是的',NULL,186,32),(3145,'我确信我没有遗漏或不经心回答上面任何问题:','是的|不确定|不是的',NULL,187,32);
/*!40000 ALTER TABLE `question` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question_ans`
--

DROP TABLE IF EXISTS `question_ans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question_ans` (
  `paper_id` int(11) NOT NULL COMMENT '对应题目的id',
  `examinee_id` int(11) NOT NULL COMMENT '被试id',
  `option` text COMMENT '题目原始选项，目前是单选，如果要考虑多选时，最后将这里改成字符串存储',
  `score` text COMMENT '原始选项得分,竖线分隔',
  `question_number_list` text COMMENT '题目的number的列表,注意是试卷内的编号,而不是id',
  PRIMARY KEY (`paper_id`,`examinee_id`),
  KEY `fk_question_ans_1_idx` (`examinee_id`),
  KEY `fk_question_ans_2_idx` (`paper_id`),
  CONSTRAINT `fk_question_ans_1` FOREIGN KEY (`examinee_id`) REFERENCES `examinee` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_question_ans_2` FOREIGN KEY (`paper_id`) REFERENCES `paper` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question_ans`
--

LOCK TABLES `question_ans` WRITE;
/*!40000 ALTER TABLE `question_ans` DISABLE KEYS */;
/*!40000 ALTER TABLE `question_ans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `scldf`
--

DROP TABLE IF EXISTS `scldf`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `scldf` (
  `TH` varchar(255) DEFAULT NULL,
  `A` varchar(255) DEFAULT NULL,
  `B` varchar(255) DEFAULT NULL,
  `C` varchar(255) DEFAULT NULL,
  `D` varchar(255) DEFAULT NULL,
  `E` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scldf`
--

LOCK TABLES `scldf` WRITE;
/*!40000 ALTER TABLE `scldf` DISABLE KEYS */;
INSERT INTO `scldf` VALUES ('1','1','2','3','4','5'),('2','1','2','3','4','5'),('3','1','2','3','4','5'),('4','1','2','3','4','5'),('5','1','2','3','4','5'),('6','1','2','3','4','5'),('7','1','2','3','4','5'),('8','1','2','3','4','5'),('9','1','2','3','4','5'),('10','1','2','3','4','5'),('11','1','2','3','4','5'),('12','1','2','3','4','5'),('13','1','2','3','4','5'),('14','1','2','3','4','5'),('15','1','2','3','4','5'),('16','1','2','3','4','5'),('17','1','2','3','4','5'),('18','1','2','3','4','5'),('19','1','2','3','4','5'),('20','1','2','3','4','5'),('21','1','2','3','4','5'),('22','1','2','3','4','5'),('23','1','2','3','4','5'),('24','1','2','3','4','5'),('25','1','2','3','4','5'),('26','1','2','3','4','5'),('27','1','2','3','4','5'),('28','1','2','3','4','5'),('29','1','2','3','4','5'),('30','1','2','3','4','5'),('31','1','2','3','4','5'),('32','1','2','3','4','5'),('33','1','2','3','4','5'),('34','1','2','3','4','5'),('35','1','2','3','4','5'),('36','1','2','3','4','5'),('37','1','2','3','4','5'),('38','1','2','3','4','5'),('39','1','2','3','4','5'),('40','1','2','3','4','5'),('41','1','2','3','4','5'),('42','1','2','3','4','5'),('43','1','2','3','4','5'),('44','1','2','3','4','5'),('45','1','2','3','4','5'),('46','1','2','3','4','5'),('47','1','2','3','4','5'),('48','1','2','3','4','5'),('49','1','2','3','4','5'),('50','1','2','3','4','5'),('51','1','2','3','4','5'),('52','1','2','3','4','5'),('53','1','2','3','4','5'),('54','1','2','3','4','5'),('55','1','2','3','4','5'),('56','1','2','3','4','5'),('57','1','2','3','4','5'),('58','1','2','3','4','5'),('59','1','2','3','4','5'),('60','1','2','3','4','5'),('61','1','2','3','4','5'),('62','1','2','3','4','5'),('63','1','2','3','4','5'),('64','1','2','3','4','5'),('65','1','2','3','4','5'),('66','1','2','3','4','5'),('67','1','2','3','4','5'),('68','1','2','3','4','5'),('69','1','2','3','4','5'),('70','1','2','3','4','5'),('71','1','2','3','4','5'),('72','1','2','3','4','5'),('73','1','2','3','4','5'),('74','1','2','3','4','5'),('75','1','2','3','4','5'),('76','1','2','3','4','5'),('77','1','2','3','4','5'),('78','1','2','3','4','5'),('79','1','2','3','4','5'),('80','1','2','3','4','5'),('81','1','2','3','4','5'),('82','1','2','3','4','5'),('83','1','2','3','4','5'),('84','1','2','3','4','5'),('85','1','2','3','4','5'),('86','1','2','3','4','5'),('87','1','2','3','4','5'),('88','1','2','3','4','5'),('89','1','2','3','4','5'),('90','1','2','3','4','5');
/*!40000 ALTER TABLE `scldf` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `spmdf`
--

DROP TABLE IF EXISTS `spmdf`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `spmdf` (
  `TH` varchar(255) DEFAULT NULL,
  `BZ` varchar(255) DEFAULT NULL,
  `XH` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `spmdf`
--

LOCK TABLES `spmdf` WRITE;
/*!40000 ALTER TABLE `spmdf` DISABLE KEYS */;
INSERT INTO `spmdf` VALUES ('A1','4','1'),('A2','5','2'),('A3','1','3'),('A4','2','4'),('A5','6','5'),('A6','3','6'),('A7','6','7'),('A8','2','8'),('A9','1','9'),('A10','3','10'),('A11','4','11'),('A12','5','12'),('B1','2','13'),('B2','6','14'),('B3','1','15'),('B4','2','16'),('B5','1','17'),('B6','3','18'),('B7','5','19'),('B8','6','20'),('B9','4','21'),('B10','3','22'),('B11','4','23'),('B12','5','24'),('C1','8','25'),('C2','2','26'),('C3','3','27'),('C4','8','28'),('C5','7','29'),('C6','4','30'),('C7','5','31'),('C8','1','32'),('C9','7','33'),('C10','6','34'),('C11','1','35'),('C12','2','36'),('D1','3','37'),('D2','4','38'),('D3','3','39'),('D4','7','40'),('D5','8','41'),('D6','6','42'),('D7','5','43'),('D8','4','44'),('D9','1','45'),('D10','2','46'),('D11','5','47'),('D12','6','48'),('E1','7','49'),('E2','6','50'),('E3','8','51'),('E4','2','52'),('E5','1','53'),('E6','5','54'),('E7','1','55'),('E8','6','56'),('E9','3','57'),('E10','2','58'),('E11','4','59'),('E12','5','60');
/*!40000 ALTER TABLE `spmdf` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-08-12 14:14:51

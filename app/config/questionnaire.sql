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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paper`
--

LOCK TABLES `paper` WRITE;
/*!40000 ALTER TABLE `paper` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question`
--

LOCK TABLES `question` WRITE;
/*!40000 ALTER TABLE `question` DISABLE KEYS */;
/*!40000 ALTER TABLE `question` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question_ans`
--

DROP TABLE IF EXISTS `question_ans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question_ans` (
  `option` text COMMENT '题目原始选项，目前是单选，如果要考虑多选时，最后将这里改成字符串存储',
  `score` text COMMENT '原始选项得分',
  `paper_id` int(11) NOT NULL COMMENT '对应题目的id',
  `examinee_id` int(11) NOT NULL COMMENT '被试id',
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
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-08-11 16:53:59

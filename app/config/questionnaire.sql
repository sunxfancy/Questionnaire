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
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`number`),
  KEY `index3` (`project_id`),
  CONSTRAINT `fk_examinee_1` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `examinee`
--

LOCK TABLES `examinee` WRITE;
/*!40000 ALTER TABLE `examinee` DISABLE KEYS */;
/*!40000 ALTER TABLE `examinee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `factor`
--

DROP TABLE IF EXISTS `factor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `factor` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `factor` double DEFAULT NULL COMMENT '因子系数，并未使用，暂时保留',
  `father_factor` int(11) DEFAULT NULL COMMENT '父因子id，在不存在时为空',
  `paper_id` int(11) NOT NULL COMMENT '所属试卷id',
  PRIMARY KEY (`id`),
  KEY `index2` (`father_factor`),
  KEY `index4` (`paper_id`),
  CONSTRAINT `fk_factor_1` FOREIGN KEY (`father_factor`) REFERENCES `factor` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_factor_3` FOREIGN KEY (`paper_id`) REFERENCES `paper` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `factor`
--

LOCK TABLES `factor` WRITE;
/*!40000 ALTER TABLE `factor` DISABLE KEYS */;
/*!40000 ALTER TABLE `factor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `factor_ans`
--

DROP TABLE IF EXISTS `factor_ans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `factor_ans` (
  `id` int(11) NOT NULL,
  `score` int(11) DEFAULT NULL COMMENT '因子得分',
  `std_score` int(11) DEFAULT NULL COMMENT '因子标准分',
  `examinee_id` int(11) NOT NULL COMMENT '被试人员id，并非编号',
  `factor_id` int(11) NOT NULL COMMENT '所属因子id',
  `ans_score` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_factor_ans_1_idx` (`examinee_id`),
  KEY `fk_factor_ans_2_idx` (`factor_id`),
  CONSTRAINT `fk_factor_ans_1` FOREIGN KEY (`examinee_id`) REFERENCES `examinee` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_factor_ans_2` FOREIGN KEY (`factor_id`) REFERENCES `factor` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
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
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL COMMENT '指标名',
  `father_index` int(11) DEFAULT NULL COMMENT '父指标id，计算时会使用',
  `module_id` int(11) NOT NULL COMMENT '模块id',
  PRIMARY KEY (`id`),
  KEY `index2` (`father_index`),
  KEY `index3` (`module_id`),
  CONSTRAINT `fk_index_1` FOREIGN KEY (`father_index`) REFERENCES `index` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_index_2` FOREIGN KEY (`module_id`) REFERENCES `module` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `index`
--

LOCK TABLES `index` WRITE;
/*!40000 ALTER TABLE `index` DISABLE KEYS */;
/*!40000 ALTER TABLE `index` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `index_ans`
--

DROP TABLE IF EXISTS `index_ans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `index_ans` (
  `id` int(11) NOT NULL,
  `score` int(11) DEFAULT NULL COMMENT '指标最终得分\n',
  `index_id` int(11) NOT NULL COMMENT '指标id',
  `examinee_id` int(11) NOT NULL COMMENT '被试人员id，并非编号',
  PRIMARY KEY (`id`),
  KEY `fk_index_ans_1_idx` (`examinee_id`),
  KEY `fk_index_ans_2_idx` (`index_id`),
  CONSTRAINT `fk_index_ans_1` FOREIGN KEY (`examinee_id`) REFERENCES `examinee` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_index_ans_2` FOREIGN KEY (`index_id`) REFERENCES `index` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
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
  PRIMARY KEY (`id`),
  UNIQUE KEY `index3` (`username`),
  KEY `index2` (`project_id`),
  CONSTRAINT `fk_manager_project` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `manager`
--

LOCK TABLES `manager` WRITE;
/*!40000 ALTER TABLE `manager` DISABLE KEYS */;
INSERT INTO `manager` VALUES (1,'sa','123456','M',NULL,'gly');
/*!40000 ALTER TABLE `manager` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `module`
--

DROP TABLE IF EXISTS `module`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `module` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL COMMENT '模块名',
  `belong_module` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `module`
--

LOCK TABLES `module` WRITE;
/*!40000 ALTER TABLE `module` DISABLE KEYS */;
/*!40000 ALTER TABLE `module` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paper`
--

DROP TABLE IF EXISTS `paper`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paper` (
  `id` int(11) NOT NULL,
  `description` varchar(2000) DEFAULT NULL COMMENT '指导语',
  `name` varchar(200) DEFAULT NULL COMMENT '试卷名',
  PRIMARY KEY (`id`)
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
  `id` int(11) NOT NULL,
  `begintime` datetime DEFAULT NULL COMMENT '开始时间',
  `endtime` datetime DEFAULT NULL COMMENT '结束时间',
  `name` varchar(200) NOT NULL COMMENT '项目名',
  `description` varchar(2000) DEFAULT NULL COMMENT '项目备注，详细描述',
  `manager_id` int(11) NOT NULL COMMENT '项目经理id',
  PRIMARY KEY (`id`),
  KEY `fk_project_1_idx` (`manager_id`),
  CONSTRAINT `fk_project_1` FOREIGN KEY (`manager_id`) REFERENCES `manager` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project`
--

LOCK TABLES `project` WRITE;
/*!40000 ALTER TABLE `project` DISABLE KEYS */;
/*!40000 ALTER TABLE `project` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question`
--

DROP TABLE IF EXISTS `question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question` (
  `id` int(11) NOT NULL,
  `topic` text COMMENT '题目描述',
  `options` text COMMENT '题目选项，不同选项用竖线隔开',
  `grade` text COMMENT '得分表，各个选项的得分数字依次用竖线隔开，总个数和options对应',
  PRIMARY KEY (`id`)
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
  `id` int(11) NOT NULL,
  `option` int(11) DEFAULT NULL COMMENT '题目原始选项，目前是单选，如果要考虑多选时，最后将这里改成字符串存储',
  `score` int(11) DEFAULT NULL COMMENT '原始选项得分',
  `question_id` int(11) NOT NULL COMMENT '对应题目的id',
  `examinee_id` int(11) NOT NULL COMMENT '被试id',
  PRIMARY KEY (`id`),
  KEY `fk_question_ans_1_idx` (`examinee_id`),
  KEY `fk_question_ans_2_idx` (`question_id`),
  CONSTRAINT `fk_question_ans_1` FOREIGN KEY (`examinee_id`) REFERENCES `examinee` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_question_ans_2` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
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

-- Dump completed on 2015-08-02 16:20:42

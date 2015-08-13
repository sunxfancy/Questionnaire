-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 13, 2015 at 10:48 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `questionnaire`
--

-- --------------------------------------------------------

--
-- Table structure for table `question_ans`
--

CREATE TABLE IF NOT EXISTS `question_ans` (
  `paper_id` int(11) NOT NULL COMMENT '对应题目的id',
  `examinee_id` int(11) NOT NULL COMMENT '被试id',
  `option` text COMMENT '题目原始选项，目前是单选，如果要考虑多选时，最后将这里改成字符串存储',
  `score` text COMMENT '原始选项得分,竖线分隔',
  `question_number_list` text COMMENT '题目的number的列表,注意是试卷内的编号,而不是id',
  PRIMARY KEY (`paper_id`,`examinee_id`),
  KEY `fk_question_ans_1_idx` (`examinee_id`),
  KEY `fk_question_ans_2_idx` (`paper_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `question_ans`
--

INSERT INTO `question_ans` (`paper_id`, `examinee_id`, `option`, `score`, `question_number_list`) VALUES
(31, 12, 'A|B', NULL, '1|2'),
(32, 12, 'A|B|C|A|B|C|A|B|C|A|B|C|A|B|C|A|B|C', NULL, '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18'),
(33, 12, 'A|B', NULL, '1|2'),
(34, 12, 'A|B', NULL, '1|2'),
(35, 12, 'A|B', NULL, '1|2'),
(36, 12, 'A|B|C|D|A|B|C|D|A|B|C|D|A|B|C|D|A|B|C|D|A', NULL, '10|11|12|13|14|15|16|17|18|19|20|1|2|3|4|5|6|7|8|9|10');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `question_ans`
--
ALTER TABLE `question_ans`
  ADD CONSTRAINT `fk_question_ans_1` FOREIGN KEY (`examinee_id`) REFERENCES `examinee` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_question_ans_2` FOREIGN KEY (`paper_id`) REFERENCES `paper` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

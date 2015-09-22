/*
Navicat MySQL Data Transfer

Source Server         : loaclhost
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : questionnaire

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2015-09-22 17:03:24
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `cpidf`
-- ----------------------------
DROP TABLE IF EXISTS `cpidf`;
CREATE TABLE `cpidf` (
  `TH` int(11) NOT NULL,
  `XZ` tinyint(4) NOT NULL,
  `DO` tinyint(4) DEFAULT NULL,
  `CS` tinyint(4) DEFAULT NULL,
  `SY` tinyint(4) DEFAULT NULL,
  `SP` tinyint(4) DEFAULT NULL,
  `SA` tinyint(4) DEFAULT NULL,
  `WB` tinyint(4) DEFAULT NULL,
  `RE` tinyint(4) DEFAULT NULL,
  `SO` tinyint(4) DEFAULT NULL,
  `SC` tinyint(4) DEFAULT NULL,
  `PO` tinyint(4) DEFAULT NULL,
  `GI` tinyint(4) DEFAULT NULL,
  `CM` tinyint(4) DEFAULT NULL,
  `AC` tinyint(4) DEFAULT NULL,
  `AI` tinyint(4) DEFAULT NULL,
  `IE` tinyint(4) DEFAULT NULL,
  `PY` tinyint(4) DEFAULT NULL,
  `FX` tinyint(4) DEFAULT NULL,
  `FE` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`TH`,`XZ`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cpidf
-- ----------------------------
INSERT INTO `cpidf` VALUES ('1', '1', '0', null, '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('1', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('2', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('2', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('3', '1', '0', null, null, '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('3', '2', '0', null, null, null, null, null, null, null, '1', null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('4', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('4', '2', '0', null, null, null, '1', null, null, null, null, null, null, null, null, '1', null, null, null, null);
INSERT INTO `cpidf` VALUES ('5', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('5', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', null, null);
INSERT INTO `cpidf` VALUES ('6', '1', '0', null, null, null, null, null, null, null, null, null, '1', null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('6', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('7', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('7', '2', '0', null, null, null, null, '1', null, null, null, '1', null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('8', '1', '0', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('8', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('9', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('9', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1');
INSERT INTO `cpidf` VALUES ('10', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('10', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('11', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('11', '2', '0', null, null, '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('12', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('12', '2', '0', null, null, null, null, null, null, null, null, '1', null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('13', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1');
INSERT INTO `cpidf` VALUES ('13', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('14', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('14', '2', '0', null, null, null, null, null, null, null, '1', null, null, null, '1', null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('15', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('15', '2', '0', null, null, null, null, null, null, null, null, null, '1', null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('16', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('16', '2', '0', null, null, null, '1', null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('17', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('17', '2', '0', null, null, null, '1', null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('18', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('18', '2', '0', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('19', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('19', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, '1', null, null, null, null);
INSERT INTO `cpidf` VALUES ('20', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('20', '2', '0', null, null, null, null, null, null, null, '1', null, '1', null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('21', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('21', '2', '0', null, null, null, null, null, '1', null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('22', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('22', '2', '0', null, null, null, null, null, null, null, '1', null, '1', null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('23', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('23', '2', '0', '1', null, '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('24', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('24', '2', '0', null, null, null, null, null, '1', null, null, null, null, null, '1', null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('25', '1', '0', null, '1', '1', null, null, null, null, null, null, null, null, null, null, '1', null, null, null);
INSERT INTO `cpidf` VALUES ('25', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('26', '1', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('26', '2', '0', null, null, null, null, null, null, null, '1', null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('27', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('27', '2', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', null, null);
INSERT INTO `cpidf` VALUES ('28', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1');
INSERT INTO `cpidf` VALUES ('28', '2', '0', null, null, '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('29', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('29', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, '1', null, null, null, null);
INSERT INTO `cpidf` VALUES ('30', '1', '0', null, null, null, null, null, '1', null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('30', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('31', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1');
INSERT INTO `cpidf` VALUES ('31', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('32', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('32', '2', '0', null, null, null, null, null, null, null, null, null, '1', null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('33', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('33', '2', '0', null, null, null, null, null, null, null, null, '1', null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('34', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('34', '2', '0', null, null, '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('35', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('35', '2', '0', null, null, null, null, '1', null, null, null, null, '1', null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('36', '1', '0', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('36', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('37', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('37', '2', '0', null, null, null, null, null, '1', null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('38', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('38', '2', '0', null, '1', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('39', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('39', '2', '0', null, null, null, null, null, '1', null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('40', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('40', '2', '0', null, null, '1', null, null, null, null, null, null, null, null, null, null, '1', null, null, null);
INSERT INTO `cpidf` VALUES ('41', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('41', '2', '0', null, null, null, null, null, '1', null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('42', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('42', '2', '0', null, null, null, null, null, null, null, '1', null, '1', null, null, null, null, null, null, '1');
INSERT INTO `cpidf` VALUES ('43', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('43', '2', '0', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('44', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('44', '2', '0', null, null, null, null, null, null, null, null, null, '1', null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('45', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('45', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1');
INSERT INTO `cpidf` VALUES ('46', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('46', '2', '0', null, '1', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('47', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('47', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', null, null);
INSERT INTO `cpidf` VALUES ('48', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('48', '2', '0', null, null, null, null, '1', null, null, null, '1', null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('49', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('49', '2', '0', null, null, null, null, null, null, null, null, null, '1', null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('50', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('50', '2', '0', '1', null, null, null, null, null, null, null, '1', null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('51', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('51', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', null, null);
INSERT INTO `cpidf` VALUES ('52', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('52', '2', '0', null, null, null, null, null, null, null, null, null, '1', null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('53', '1', '0', null, '1', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('53', '2', '0', null, null, null, null, null, null, null, '1', null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('54', '1', '0', null, '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('54', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('55', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('55', '2', '0', null, null, null, null, null, null, null, null, null, '1', null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('56', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1');
INSERT INTO `cpidf` VALUES ('56', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('57', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('57', '2', '1', null, '1', null, '1', null, null, null, null, null, null, null, null, null, '1', null, null, null);
INSERT INTO `cpidf` VALUES ('58', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('58', '2', '0', null, null, null, null, null, '1', null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('59', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('59', '2', '0', null, null, null, null, null, null, null, '1', null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('60', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('60', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, '1', null, null, null, null);
INSERT INTO `cpidf` VALUES ('61', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('61', '2', '0', null, null, null, null, null, null, null, null, null, null, null, '1', null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('62', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('62', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, '1', null, null, null, null);
INSERT INTO `cpidf` VALUES ('63', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('63', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('64', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('64', '2', '0', null, '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('65', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('65', '2', '0', null, null, null, null, null, '1', null, null, null, null, null, null, null, null, null, null, '1');
INSERT INTO `cpidf` VALUES ('66', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('66', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, '1', null, null, null, null);
INSERT INTO `cpidf` VALUES ('67', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('67', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', null, null);
INSERT INTO `cpidf` VALUES ('68', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('68', '2', '0', null, null, null, null, null, null, null, '1', null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('69', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('69', '2', '0', null, null, null, null, null, '1', null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('70', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('70', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, '1', null, null, null, null);
INSERT INTO `cpidf` VALUES ('71', '1', '0', null, null, null, null, null, null, '1', null, null, null, null, null, null, null, null, null, '1');
INSERT INTO `cpidf` VALUES ('71', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('72', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('72', '2', '0', null, '1', null, null, null, null, null, null, null, null, null, '1', null, null, '1', null, null);
INSERT INTO `cpidf` VALUES ('73', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('73', '2', '0', null, null, null, null, null, null, null, null, null, '1', null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('74', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('74', '2', '0', null, null, null, null, null, null, null, '1', '1', null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('75', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('75', '2', '0', null, null, null, null, null, null, null, null, null, '1', null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('76', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('76', '2', '0', null, null, null, null, null, null, null, null, null, null, null, '1', null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('77', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('77', '2', '0', null, null, null, null, null, null, null, null, '1', null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('78', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('78', '2', '0', null, null, null, null, null, null, null, null, null, '1', null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('79', '1', '0', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('79', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('80', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('80', '2', '0', null, null, null, null, null, null, null, null, null, null, null, '1', null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('81', '1', '0', null, '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('81', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('82', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('82', '2', '0', null, null, null, null, null, '1', '1', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('83', '1', '1', '1', '1', null, null, null, null, null, null, null, null, null, null, null, '1', null, null, null);
INSERT INTO `cpidf` VALUES ('83', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('84', '1', '0', null, null, null, null, null, null, '1', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('84', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('85', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('85', '2', '0', null, null, null, null, null, null, null, '1', null, '1', null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('86', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('86', '2', '0', null, null, null, null, null, null, null, '1', null, null, null, '1', null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('87', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('87', '2', '0', null, null, null, null, null, null, null, null, null, null, null, '1', null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('88', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('88', '2', '0', null, null, null, null, null, null, null, null, '1', null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('89', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('89', '2', '1', null, null, '1', '1', null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('90', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('90', '2', '0', null, null, null, null, null, null, null, '1', null, '1', null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('91', '1', '1', null, null, null, '1', null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('91', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('92', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('92', '2', '0', null, null, null, null, null, null, null, '1', '1', null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('93', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('93', '2', '0', null, null, null, null, null, null, null, null, '1', null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('94', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('94', '2', '0', null, null, null, null, null, null, null, '1', null, null, null, null, null, null, '1', null, null);
INSERT INTO `cpidf` VALUES ('95', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('95', '2', '0', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('96', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('96', '2', '0', null, null, null, null, '1', null, null, '1', null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('97', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('97', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('98', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('98', '2', '0', null, null, null, null, null, null, null, null, null, null, null, '1', null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('99', '1', '0', '1', null, '1', null, null, null, null, null, null, null, null, null, null, '1', null, null, null);
INSERT INTO `cpidf` VALUES ('99', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('100', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('100', '2', '0', null, null, null, null, null, null, null, null, null, '1', null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('101', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('101', '2', '0', null, null, null, null, null, '1', null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('102', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('102', '2', '0', null, null, null, null, null, null, null, null, '1', null, null, null, '1', null, null, null, null);
INSERT INTO `cpidf` VALUES ('103', '1', '0', null, null, '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('103', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('104', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('104', '2', '0', null, null, null, null, null, '1', null, null, null, null, null, null, null, null, null, null, '1');
INSERT INTO `cpidf` VALUES ('105', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('105', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', null, null);
INSERT INTO `cpidf` VALUES ('106', '1', '0', null, null, null, null, null, '1', null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('106', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('107', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('107', '2', '0', null, null, null, null, null, null, '1', null, null, null, null, '1', null, null, null, null, '1');
INSERT INTO `cpidf` VALUES ('108', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1');
INSERT INTO `cpidf` VALUES ('108', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('109', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('109', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('110', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('110', '2', '0', null, null, null, null, null, null, null, null, '1', null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('111', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('111', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, '1', null, null, null, null);
INSERT INTO `cpidf` VALUES ('112', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('112', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', null, null);
INSERT INTO `cpidf` VALUES ('113', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('113', '2', '0', '1', null, '1', '1', null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('114', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('114', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', null, null);
INSERT INTO `cpidf` VALUES ('115', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('115', '2', '0', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('116', '1', '0', null, null, '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('116', '2', '0', null, null, null, null, null, null, null, '1', null, '1', null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('117', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('117', '2', '0', null, null, null, null, '1', null, null, null, null, null, null, '1', null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('118', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('118', '2', '0', null, null, null, null, null, null, null, null, null, '1', null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('119', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('119', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, '1', null, null, null, null);
INSERT INTO `cpidf` VALUES ('120', '1', '0', null, '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('120', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('121', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('121', '2', '0', null, null, null, null, null, null, null, '1', null, null, null, '1', null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('122', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1');
INSERT INTO `cpidf` VALUES ('122', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('123', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('123', '2', '0', null, null, null, null, null, null, null, null, '1', null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('124', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('124', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1');
INSERT INTO `cpidf` VALUES ('125', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('125', '2', '0', null, null, null, null, null, null, null, null, null, null, null, '1', null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('126', '1', '0', null, null, '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('126', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('127', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('127', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, '1', null, null, null, null);
INSERT INTO `cpidf` VALUES ('128', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('128', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, '1', null, null, null, null);
INSERT INTO `cpidf` VALUES ('129', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('129', '2', '0', null, null, null, null, null, null, null, '1', '1', null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('130', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('130', '2', '1', null, '1', null, '1', null, null, null, null, null, null, null, null, null, '1', null, null, null);
INSERT INTO `cpidf` VALUES ('131', '1', '0', null, null, '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('131', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('132', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('132', '2', '0', null, null, null, null, null, '1', null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('133', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('133', '2', '0', null, null, null, null, null, null, null, null, null, '1', null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('134', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('134', '2', '0', null, null, null, null, '1', null, null, null, '1', null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('135', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('135', '2', '0', null, null, null, null, null, null, null, '1', null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('136', '1', '0', null, '1', null, null, null, null, null, null, null, null, null, null, null, '1', null, null, null);
INSERT INTO `cpidf` VALUES ('136', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('137', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('137', '2', '0', null, null, null, null, null, null, null, null, null, null, null, '1', null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('138', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1');
INSERT INTO `cpidf` VALUES ('138', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('139', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('139', '2', '0', '1', null, null, null, null, null, null, null, null, null, null, null, '1', null, null, null, null);
INSERT INTO `cpidf` VALUES ('140', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('140', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1');
INSERT INTO `cpidf` VALUES ('141', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('141', '2', '0', null, null, null, null, null, null, null, '1', null, '1', null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('142', '1', '0', null, null, null, null, null, null, null, '1', null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('142', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('143', '1', '0', null, null, null, null, null, '1', null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('143', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('144', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('144', '2', '0', null, null, null, null, null, null, null, null, null, null, null, '1', null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('145', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('145', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', null, null);
INSERT INTO `cpidf` VALUES ('146', '1', '0', null, '1', null, null, null, null, null, null, null, null, null, null, null, '1', null, null, null);
INSERT INTO `cpidf` VALUES ('146', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('147', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('147', '2', '0', null, '1', null, '1', null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('148', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('148', '2', '0', null, null, null, null, null, null, null, null, '1', null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('149', '1', '0', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('149', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('150', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('150', '2', '0', null, null, null, null, null, '1', null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('151', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('151', '2', '0', null, null, null, null, null, null, null, null, null, '1', null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('152', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('152', '2', '0', null, null, null, null, null, null, null, '1', '1', null, null, null, '1', null, null, null, null);
INSERT INTO `cpidf` VALUES ('153', '1', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('153', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('154', '1', '0', null, null, null, '1', null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('154', '2', '0', null, null, null, null, null, null, null, '1', null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('155', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('155', '2', '0', null, null, null, null, '1', null, null, '1', null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('156', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('156', '2', '0', null, null, null, null, null, null, null, '1', null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('157', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('157', '2', '0', null, null, null, null, null, null, '1', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('158', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('158', '2', '0', null, null, null, null, null, null, null, null, null, null, '1', null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('159', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('159', '2', '0', null, null, null, null, '1', null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('160', '1', '0', null, null, null, null, null, null, null, null, null, null, '1', null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('160', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('161', '1', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('161', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('162', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('162', '2', '0', null, null, null, null, null, null, null, null, null, null, '1', null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('163', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('163', '2', '0', null, null, null, null, null, null, null, null, null, null, '1', null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('164', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('164', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', null);
INSERT INTO `cpidf` VALUES ('165', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('165', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', null);
INSERT INTO `cpidf` VALUES ('166', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('166', '2', '0', null, null, null, null, '1', null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('167', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', null);
INSERT INTO `cpidf` VALUES ('167', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('168', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('168', '2', '0', null, null, null, null, null, null, null, null, null, null, '1', null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('169', '1', '0', null, null, null, null, null, null, '1', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('169', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('170', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('170', '2', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('171', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('171', '2', '0', null, null, null, null, null, null, '1', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('172', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('172', '2', '0', null, null, null, null, '1', null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('173', '1', '0', null, null, null, null, null, null, null, null, null, null, '1', null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('173', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('174', '1', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('174', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('175', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('175', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', null);
INSERT INTO `cpidf` VALUES ('176', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('176', '2', '0', null, null, null, null, null, null, null, null, null, null, '1', null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('177', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('177', '2', '0', null, null, null, null, null, null, null, null, null, null, '1', null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('178', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('178', '2', '0', null, null, null, null, '1', null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('179', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('179', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, '1', null, null, null);
INSERT INTO `cpidf` VALUES ('180', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('180', '2', '0', null, null, null, null, '1', null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('181', '1', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('181', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('182', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('182', '2', '0', null, null, null, null, null, null, null, null, null, null, '1', null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('183', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('183', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', null);
INSERT INTO `cpidf` VALUES ('184', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('184', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', null);
INSERT INTO `cpidf` VALUES ('185', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('185', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, '1', null, null, null);
INSERT INTO `cpidf` VALUES ('186', '1', '0', null, null, null, null, null, null, '1', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('186', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('187', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('187', '2', '0', null, null, null, null, '1', null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('188', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('188', '2', '0', null, null, null, null, null, null, null, null, null, null, '1', null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('189', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('189', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', null);
INSERT INTO `cpidf` VALUES ('190', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('190', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', null);
INSERT INTO `cpidf` VALUES ('191', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('191', '2', '0', null, null, null, null, '1', null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('192', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('192', '2', '0', null, null, null, null, null, null, null, null, null, null, '1', null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('193', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('193', '2', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('194', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('194', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', null);
INSERT INTO `cpidf` VALUES ('195', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('195', '2', '0', null, null, null, null, null, null, '1', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('196', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('196', '2', '0', null, null, null, null, null, null, '1', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('197', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('197', '2', '0', null, null, null, null, null, null, '1', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('198', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('198', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', null);
INSERT INTO `cpidf` VALUES ('199', '1', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('199', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('200', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('200', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('201', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('201', '2', '0', null, null, null, null, null, null, '1', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('202', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('202', '2', '0', null, null, null, null, '1', null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('203', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('203', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', null);
INSERT INTO `cpidf` VALUES ('204', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('204', '2', '0', null, null, null, null, '1', null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('205', '1', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('205', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('206', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('206', '2', '0', null, null, null, null, '1', null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('207', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('207', '2', '0', null, null, null, null, null, null, '1', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('208', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('208', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, '1', null, null, null);
INSERT INTO `cpidf` VALUES ('209', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('209', '2', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('210', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('210', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, '1', null, null, null);
INSERT INTO `cpidf` VALUES ('211', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('211', '2', '0', null, null, null, null, null, null, '1', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('212', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('212', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, '1', null, null, null);
INSERT INTO `cpidf` VALUES ('213', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('213', '2', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('214', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('214', '2', '0', null, null, null, null, '1', null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('215', '1', '0', null, null, null, null, null, null, null, null, null, null, '1', null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('215', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('216', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('216', '2', '0', null, null, null, null, null, null, '1', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('217', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('217', '2', '0', null, null, null, null, '1', null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('218', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('218', '2', '0', null, null, null, null, null, null, '1', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('219', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('219', '2', '0', null, null, null, null, null, null, '1', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('220', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('220', '2', '0', null, null, null, null, '1', null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('221', '1', '0', null, null, null, null, null, null, '1', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('221', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('222', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('222', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, '1', null, null, null);
INSERT INTO `cpidf` VALUES ('223', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('223', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', null);
INSERT INTO `cpidf` VALUES ('224', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('224', '2', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('225', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('225', '2', '0', null, null, null, null, null, null, '1', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('226', '1', '0', null, null, null, null, null, null, null, null, null, null, '1', null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('226', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('227', '1', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('227', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('228', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('228', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', null);
INSERT INTO `cpidf` VALUES ('229', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('229', '2', '0', null, null, null, null, null, null, '1', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('230', '1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `cpidf` VALUES ('230', '2', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', null);

-- ----------------------------
-- Table structure for `cpidf_memory`
-- ----------------------------
DROP TABLE IF EXISTS `cpidf_memory`;
CREATE TABLE `cpidf_memory` (
  `TH` int(11) NOT NULL,
  `XZ` tinyint(4) NOT NULL,
  `DO` tinyint(4) DEFAULT NULL,
  `CS` tinyint(4) DEFAULT NULL,
  `SY` tinyint(4) DEFAULT NULL,
  `SP` tinyint(4) DEFAULT NULL,
  `SA` tinyint(4) DEFAULT NULL,
  `WB` tinyint(4) DEFAULT NULL,
  `RE` tinyint(4) DEFAULT NULL,
  `SO` tinyint(4) DEFAULT NULL,
  `SC` tinyint(4) DEFAULT NULL,
  `PO` tinyint(4) DEFAULT NULL,
  `GI` tinyint(4) DEFAULT NULL,
  `CM` tinyint(4) DEFAULT NULL,
  `AC` tinyint(4) DEFAULT NULL,
  `AI` tinyint(4) DEFAULT NULL,
  `IE` tinyint(4) DEFAULT NULL,
  `PY` tinyint(4) DEFAULT NULL,
  `FX` tinyint(4) DEFAULT NULL,
  `FE` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`TH`,`XZ`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cpidf_memory
-- ----------------------------

-- ----------------------------
-- Table structure for `cpimd`
-- ----------------------------
DROP TABLE IF EXISTS `cpimd`;
CREATE TABLE `cpimd` (
  `DM` tinyint(4) NOT NULL,
  `YZ` char(2) NOT NULL,
  `M` float(11,2) NOT NULL,
  `SD` float(11,2) NOT NULL,
  PRIMARY KEY (`DM`,`YZ`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cpimd
-- ----------------------------
INSERT INTO `cpimd` VALUES ('1', 'AC', '8.72', '2.56');
INSERT INTO `cpimd` VALUES ('1', 'AI', '6.69', '2.31');
INSERT INTO `cpimd` VALUES ('1', 'CM', '9.84', '1.89');
INSERT INTO `cpimd` VALUES ('1', 'CS', '6.08', '2.40');
INSERT INTO `cpimd` VALUES ('1', 'DO', '9.25', '3.52');
INSERT INTO `cpimd` VALUES ('1', 'FE', '7.04', '2.31');
INSERT INTO `cpimd` VALUES ('1', 'FX', '4.81', '2.53');
INSERT INTO `cpimd` VALUES ('1', 'GI', '10.03', '3.38');
INSERT INTO `cpimd` VALUES ('1', 'IE', '9.86', '2.29');
INSERT INTO `cpimd` VALUES ('1', 'PO', '9.57', '3.10');
INSERT INTO `cpimd` VALUES ('1', 'PY', '5.62', '2.04');
INSERT INTO `cpimd` VALUES ('1', 'RE', '10.12', '2.54');
INSERT INTO `cpimd` VALUES ('1', 'SA', '4.71', '2.27');
INSERT INTO `cpimd` VALUES ('1', 'SC', '15.04', '4.97');
INSERT INTO `cpimd` VALUES ('1', 'SO', '13.03', '3.10');
INSERT INTO `cpimd` VALUES ('1', 'SP', '8.82', '2.92');
INSERT INTO `cpimd` VALUES ('1', 'SY', '9.21', '3.37');
INSERT INTO `cpimd` VALUES ('1', 'WB', '14.21', '3.38');
INSERT INTO `cpimd` VALUES ('2', 'AC', '8.98', '2.48');
INSERT INTO `cpimd` VALUES ('2', 'AI', '6.63', '2.33');
INSERT INTO `cpimd` VALUES ('2', 'CM', '9.97', '1.83');
INSERT INTO `cpimd` VALUES ('2', 'CS', '5.64', '2.51');
INSERT INTO `cpimd` VALUES ('2', 'DO', '8.51', '3.12');
INSERT INTO `cpimd` VALUES ('2', 'FE', '9.09', '2.35');
INSERT INTO `cpimd` VALUES ('2', 'FX', '4.79', '2.68');
INSERT INTO `cpimd` VALUES ('2', 'GI', '9.99', '3.93');
INSERT INTO `cpimd` VALUES ('2', 'IE', '9.64', '2.46');
INSERT INTO `cpimd` VALUES ('2', 'PO', '9.78', '3.10');
INSERT INTO `cpimd` VALUES ('2', 'PY', '5.86', '1.99');
INSERT INTO `cpimd` VALUES ('2', 'RE', '10.93', '2.42');
INSERT INTO `cpimd` VALUES ('2', 'SA', '4.37', '2.20');
INSERT INTO `cpimd` VALUES ('2', 'SC', '16.26', '5.01');
INSERT INTO `cpimd` VALUES ('2', 'SO', '13.83', '3.06');
INSERT INTO `cpimd` VALUES ('2', 'SP', '8.32', '2.76');
INSERT INTO `cpimd` VALUES ('2', 'SY', '9.14', '3.18');
INSERT INTO `cpimd` VALUES ('2', 'WB', '14.34', '3.29');

-- ----------------------------
-- Table structure for `cpimd_memory`
-- ----------------------------
DROP TABLE IF EXISTS `cpimd_memory`;
CREATE TABLE `cpimd_memory` (
  `DM` tinyint(4) NOT NULL,
  `YZ` char(2) NOT NULL,
  `M` float(11,2) NOT NULL,
  `SD` float(11,2) NOT NULL,
  PRIMARY KEY (`DM`,`YZ`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cpimd_memory
-- ----------------------------

-- ----------------------------
-- Table structure for `eppsdf`
-- ----------------------------
DROP TABLE IF EXISTS `eppsdf`;
CREATE TABLE `eppsdf` (
  `A` tinyint(4) NOT NULL,
  `B` tinyint(4) NOT NULL,
  `TH` int(11) NOT NULL,
  PRIMARY KEY (`TH`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of eppsdf
-- ----------------------------
INSERT INTO `eppsdf` VALUES ('1', '1', '1');
INSERT INTO `eppsdf` VALUES ('2', '1', '2');
INSERT INTO `eppsdf` VALUES ('3', '1', '3');
INSERT INTO `eppsdf` VALUES ('4', '1', '4');
INSERT INTO `eppsdf` VALUES ('5', '1', '5');
INSERT INTO `eppsdf` VALUES ('1', '2', '6');
INSERT INTO `eppsdf` VALUES ('2', '2', '7');
INSERT INTO `eppsdf` VALUES ('3', '2', '8');
INSERT INTO `eppsdf` VALUES ('4', '2', '9');
INSERT INTO `eppsdf` VALUES ('5', '2', '10');
INSERT INTO `eppsdf` VALUES ('1', '3', '11');
INSERT INTO `eppsdf` VALUES ('2', '3', '12');
INSERT INTO `eppsdf` VALUES ('3', '3', '13');
INSERT INTO `eppsdf` VALUES ('4', '3', '14');
INSERT INTO `eppsdf` VALUES ('5', '3', '15');
INSERT INTO `eppsdf` VALUES ('1', '4', '16');
INSERT INTO `eppsdf` VALUES ('2', '4', '17');
INSERT INTO `eppsdf` VALUES ('3', '4', '18');
INSERT INTO `eppsdf` VALUES ('4', '4', '19');
INSERT INTO `eppsdf` VALUES ('5', '4', '20');
INSERT INTO `eppsdf` VALUES ('1', '5', '21');
INSERT INTO `eppsdf` VALUES ('2', '5', '22');
INSERT INTO `eppsdf` VALUES ('3', '5', '23');
INSERT INTO `eppsdf` VALUES ('4', '5', '24');
INSERT INTO `eppsdf` VALUES ('5', '5', '25');
INSERT INTO `eppsdf` VALUES ('1', '6', '26');
INSERT INTO `eppsdf` VALUES ('2', '6', '27');
INSERT INTO `eppsdf` VALUES ('3', '6', '28');
INSERT INTO `eppsdf` VALUES ('4', '6', '29');
INSERT INTO `eppsdf` VALUES ('5', '6', '30');
INSERT INTO `eppsdf` VALUES ('1', '7', '31');
INSERT INTO `eppsdf` VALUES ('2', '7', '32');
INSERT INTO `eppsdf` VALUES ('3', '7', '33');
INSERT INTO `eppsdf` VALUES ('4', '7', '34');
INSERT INTO `eppsdf` VALUES ('5', '7', '35');
INSERT INTO `eppsdf` VALUES ('1', '8', '36');
INSERT INTO `eppsdf` VALUES ('2', '8', '37');
INSERT INTO `eppsdf` VALUES ('3', '8', '38');
INSERT INTO `eppsdf` VALUES ('4', '8', '39');
INSERT INTO `eppsdf` VALUES ('5', '8', '40');
INSERT INTO `eppsdf` VALUES ('1', '9', '41');
INSERT INTO `eppsdf` VALUES ('2', '9', '42');
INSERT INTO `eppsdf` VALUES ('3', '9', '43');
INSERT INTO `eppsdf` VALUES ('4', '9', '44');
INSERT INTO `eppsdf` VALUES ('5', '9', '45');
INSERT INTO `eppsdf` VALUES ('1', '10', '46');
INSERT INTO `eppsdf` VALUES ('2', '10', '47');
INSERT INTO `eppsdf` VALUES ('3', '10', '48');
INSERT INTO `eppsdf` VALUES ('4', '10', '49');
INSERT INTO `eppsdf` VALUES ('5', '10', '50');
INSERT INTO `eppsdf` VALUES ('1', '11', '51');
INSERT INTO `eppsdf` VALUES ('2', '11', '52');
INSERT INTO `eppsdf` VALUES ('3', '11', '53');
INSERT INTO `eppsdf` VALUES ('4', '11', '54');
INSERT INTO `eppsdf` VALUES ('5', '11', '55');
INSERT INTO `eppsdf` VALUES ('1', '12', '56');
INSERT INTO `eppsdf` VALUES ('2', '12', '57');
INSERT INTO `eppsdf` VALUES ('3', '12', '58');
INSERT INTO `eppsdf` VALUES ('4', '12', '59');
INSERT INTO `eppsdf` VALUES ('5', '12', '60');
INSERT INTO `eppsdf` VALUES ('1', '13', '61');
INSERT INTO `eppsdf` VALUES ('2', '13', '62');
INSERT INTO `eppsdf` VALUES ('3', '13', '63');
INSERT INTO `eppsdf` VALUES ('4', '13', '64');
INSERT INTO `eppsdf` VALUES ('5', '13', '65');
INSERT INTO `eppsdf` VALUES ('1', '14', '66');
INSERT INTO `eppsdf` VALUES ('2', '14', '67');
INSERT INTO `eppsdf` VALUES ('3', '14', '68');
INSERT INTO `eppsdf` VALUES ('4', '14', '69');
INSERT INTO `eppsdf` VALUES ('5', '14', '70');
INSERT INTO `eppsdf` VALUES ('1', '15', '71');
INSERT INTO `eppsdf` VALUES ('2', '15', '72');
INSERT INTO `eppsdf` VALUES ('3', '15', '73');
INSERT INTO `eppsdf` VALUES ('4', '15', '74');
INSERT INTO `eppsdf` VALUES ('5', '15', '75');
INSERT INTO `eppsdf` VALUES ('6', '1', '76');
INSERT INTO `eppsdf` VALUES ('7', '1', '77');
INSERT INTO `eppsdf` VALUES ('8', '1', '78');
INSERT INTO `eppsdf` VALUES ('9', '1', '79');
INSERT INTO `eppsdf` VALUES ('10', '1', '80');
INSERT INTO `eppsdf` VALUES ('6', '2', '81');
INSERT INTO `eppsdf` VALUES ('7', '2', '82');
INSERT INTO `eppsdf` VALUES ('8', '2', '83');
INSERT INTO `eppsdf` VALUES ('9', '2', '84');
INSERT INTO `eppsdf` VALUES ('10', '2', '85');
INSERT INTO `eppsdf` VALUES ('6', '3', '86');
INSERT INTO `eppsdf` VALUES ('7', '3', '87');
INSERT INTO `eppsdf` VALUES ('8', '3', '88');
INSERT INTO `eppsdf` VALUES ('9', '3', '89');
INSERT INTO `eppsdf` VALUES ('10', '3', '90');
INSERT INTO `eppsdf` VALUES ('6', '4', '91');
INSERT INTO `eppsdf` VALUES ('7', '4', '92');
INSERT INTO `eppsdf` VALUES ('8', '4', '93');
INSERT INTO `eppsdf` VALUES ('9', '4', '94');
INSERT INTO `eppsdf` VALUES ('10', '4', '95');
INSERT INTO `eppsdf` VALUES ('6', '5', '96');
INSERT INTO `eppsdf` VALUES ('7', '5', '97');
INSERT INTO `eppsdf` VALUES ('8', '5', '98');
INSERT INTO `eppsdf` VALUES ('9', '5', '99');
INSERT INTO `eppsdf` VALUES ('10', '5', '100');
INSERT INTO `eppsdf` VALUES ('6', '6', '101');
INSERT INTO `eppsdf` VALUES ('7', '6', '102');
INSERT INTO `eppsdf` VALUES ('8', '6', '103');
INSERT INTO `eppsdf` VALUES ('9', '6', '104');
INSERT INTO `eppsdf` VALUES ('10', '6', '105');
INSERT INTO `eppsdf` VALUES ('6', '7', '106');
INSERT INTO `eppsdf` VALUES ('7', '7', '107');
INSERT INTO `eppsdf` VALUES ('8', '7', '108');
INSERT INTO `eppsdf` VALUES ('9', '7', '109');
INSERT INTO `eppsdf` VALUES ('10', '7', '110');
INSERT INTO `eppsdf` VALUES ('6', '8', '111');
INSERT INTO `eppsdf` VALUES ('7', '8', '112');
INSERT INTO `eppsdf` VALUES ('8', '8', '113');
INSERT INTO `eppsdf` VALUES ('9', '8', '114');
INSERT INTO `eppsdf` VALUES ('10', '8', '115');
INSERT INTO `eppsdf` VALUES ('6', '9', '116');
INSERT INTO `eppsdf` VALUES ('7', '9', '117');
INSERT INTO `eppsdf` VALUES ('8', '9', '118');
INSERT INTO `eppsdf` VALUES ('9', '9', '119');
INSERT INTO `eppsdf` VALUES ('10', '9', '120');
INSERT INTO `eppsdf` VALUES ('6', '10', '121');
INSERT INTO `eppsdf` VALUES ('7', '10', '122');
INSERT INTO `eppsdf` VALUES ('8', '10', '123');
INSERT INTO `eppsdf` VALUES ('9', '10', '124');
INSERT INTO `eppsdf` VALUES ('10', '10', '125');
INSERT INTO `eppsdf` VALUES ('6', '11', '126');
INSERT INTO `eppsdf` VALUES ('7', '11', '127');
INSERT INTO `eppsdf` VALUES ('8', '11', '128');
INSERT INTO `eppsdf` VALUES ('9', '11', '129');
INSERT INTO `eppsdf` VALUES ('10', '11', '130');
INSERT INTO `eppsdf` VALUES ('6', '12', '131');
INSERT INTO `eppsdf` VALUES ('7', '12', '132');
INSERT INTO `eppsdf` VALUES ('8', '12', '133');
INSERT INTO `eppsdf` VALUES ('9', '12', '134');
INSERT INTO `eppsdf` VALUES ('10', '12', '135');
INSERT INTO `eppsdf` VALUES ('6', '13', '136');
INSERT INTO `eppsdf` VALUES ('7', '13', '137');
INSERT INTO `eppsdf` VALUES ('8', '13', '138');
INSERT INTO `eppsdf` VALUES ('9', '13', '139');
INSERT INTO `eppsdf` VALUES ('10', '13', '140');
INSERT INTO `eppsdf` VALUES ('6', '14', '141');
INSERT INTO `eppsdf` VALUES ('7', '14', '142');
INSERT INTO `eppsdf` VALUES ('8', '14', '143');
INSERT INTO `eppsdf` VALUES ('9', '14', '144');
INSERT INTO `eppsdf` VALUES ('10', '14', '145');
INSERT INTO `eppsdf` VALUES ('6', '15', '146');
INSERT INTO `eppsdf` VALUES ('7', '15', '147');
INSERT INTO `eppsdf` VALUES ('8', '15', '148');
INSERT INTO `eppsdf` VALUES ('9', '15', '149');
INSERT INTO `eppsdf` VALUES ('10', '15', '150');
INSERT INTO `eppsdf` VALUES ('11', '1', '151');
INSERT INTO `eppsdf` VALUES ('12', '1', '152');
INSERT INTO `eppsdf` VALUES ('13', '1', '153');
INSERT INTO `eppsdf` VALUES ('14', '1', '154');
INSERT INTO `eppsdf` VALUES ('15', '1', '155');
INSERT INTO `eppsdf` VALUES ('11', '2', '156');
INSERT INTO `eppsdf` VALUES ('12', '2', '157');
INSERT INTO `eppsdf` VALUES ('13', '2', '158');
INSERT INTO `eppsdf` VALUES ('14', '2', '159');
INSERT INTO `eppsdf` VALUES ('15', '2', '160');
INSERT INTO `eppsdf` VALUES ('11', '3', '161');
INSERT INTO `eppsdf` VALUES ('12', '3', '162');
INSERT INTO `eppsdf` VALUES ('13', '3', '163');
INSERT INTO `eppsdf` VALUES ('14', '3', '164');
INSERT INTO `eppsdf` VALUES ('15', '3', '165');
INSERT INTO `eppsdf` VALUES ('11', '4', '166');
INSERT INTO `eppsdf` VALUES ('12', '4', '167');
INSERT INTO `eppsdf` VALUES ('13', '4', '168');
INSERT INTO `eppsdf` VALUES ('14', '4', '169');
INSERT INTO `eppsdf` VALUES ('15', '4', '170');
INSERT INTO `eppsdf` VALUES ('11', '5', '171');
INSERT INTO `eppsdf` VALUES ('12', '5', '172');
INSERT INTO `eppsdf` VALUES ('13', '5', '173');
INSERT INTO `eppsdf` VALUES ('14', '5', '174');
INSERT INTO `eppsdf` VALUES ('15', '5', '175');
INSERT INTO `eppsdf` VALUES ('11', '6', '176');
INSERT INTO `eppsdf` VALUES ('12', '6', '177');
INSERT INTO `eppsdf` VALUES ('13', '6', '178');
INSERT INTO `eppsdf` VALUES ('14', '6', '179');
INSERT INTO `eppsdf` VALUES ('15', '6', '180');
INSERT INTO `eppsdf` VALUES ('11', '7', '181');
INSERT INTO `eppsdf` VALUES ('12', '7', '182');
INSERT INTO `eppsdf` VALUES ('13', '7', '183');
INSERT INTO `eppsdf` VALUES ('14', '7', '184');
INSERT INTO `eppsdf` VALUES ('15', '7', '185');
INSERT INTO `eppsdf` VALUES ('11', '8', '186');
INSERT INTO `eppsdf` VALUES ('12', '8', '187');
INSERT INTO `eppsdf` VALUES ('13', '8', '188');
INSERT INTO `eppsdf` VALUES ('14', '8', '189');
INSERT INTO `eppsdf` VALUES ('15', '8', '190');
INSERT INTO `eppsdf` VALUES ('11', '9', '191');
INSERT INTO `eppsdf` VALUES ('12', '9', '192');
INSERT INTO `eppsdf` VALUES ('13', '9', '193');
INSERT INTO `eppsdf` VALUES ('14', '9', '194');
INSERT INTO `eppsdf` VALUES ('15', '9', '195');
INSERT INTO `eppsdf` VALUES ('11', '10', '196');
INSERT INTO `eppsdf` VALUES ('12', '10', '197');
INSERT INTO `eppsdf` VALUES ('13', '10', '198');
INSERT INTO `eppsdf` VALUES ('14', '10', '199');
INSERT INTO `eppsdf` VALUES ('15', '10', '200');
INSERT INTO `eppsdf` VALUES ('11', '11', '201');
INSERT INTO `eppsdf` VALUES ('12', '11', '202');
INSERT INTO `eppsdf` VALUES ('13', '11', '203');
INSERT INTO `eppsdf` VALUES ('14', '11', '204');
INSERT INTO `eppsdf` VALUES ('15', '11', '205');
INSERT INTO `eppsdf` VALUES ('11', '12', '206');
INSERT INTO `eppsdf` VALUES ('12', '12', '207');
INSERT INTO `eppsdf` VALUES ('13', '12', '208');
INSERT INTO `eppsdf` VALUES ('14', '12', '209');
INSERT INTO `eppsdf` VALUES ('15', '12', '210');
INSERT INTO `eppsdf` VALUES ('11', '13', '211');
INSERT INTO `eppsdf` VALUES ('12', '13', '212');
INSERT INTO `eppsdf` VALUES ('13', '13', '213');
INSERT INTO `eppsdf` VALUES ('14', '13', '214');
INSERT INTO `eppsdf` VALUES ('15', '13', '215');
INSERT INTO `eppsdf` VALUES ('11', '14', '216');
INSERT INTO `eppsdf` VALUES ('12', '14', '217');
INSERT INTO `eppsdf` VALUES ('13', '14', '218');
INSERT INTO `eppsdf` VALUES ('14', '14', '219');
INSERT INTO `eppsdf` VALUES ('15', '14', '220');
INSERT INTO `eppsdf` VALUES ('11', '15', '221');
INSERT INTO `eppsdf` VALUES ('12', '15', '222');
INSERT INTO `eppsdf` VALUES ('13', '15', '223');
INSERT INTO `eppsdf` VALUES ('14', '15', '224');
INSERT INTO `eppsdf` VALUES ('15', '15', '225');

-- ----------------------------
-- Table structure for `eppsdf_memory`
-- ----------------------------
DROP TABLE IF EXISTS `eppsdf_memory`;
CREATE TABLE `eppsdf_memory` (
  `A` tinyint(4) NOT NULL,
  `B` tinyint(4) NOT NULL,
  `TH` int(11) NOT NULL,
  PRIMARY KEY (`TH`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of eppsdf_memory
-- ----------------------------

-- ----------------------------
-- Table structure for `epqadf`
-- ----------------------------
DROP TABLE IF EXISTS `epqadf`;
CREATE TABLE `epqadf` (
  `TH` int(11) NOT NULL,
  `XZ` tinyint(4) NOT NULL,
  `E` tinyint(4) DEFAULT NULL,
  `N` tinyint(4) DEFAULT NULL,
  `P` tinyint(4) DEFAULT NULL,
  `L` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`TH`,`XZ`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of epqadf
-- ----------------------------
INSERT INTO `epqadf` VALUES ('1', '1', '1', '0', '0', '0');
INSERT INTO `epqadf` VALUES ('1', '2', '0', '0', '0', '0');
INSERT INTO `epqadf` VALUES ('2', '1', '0', '0', '0', '0');
INSERT INTO `epqadf` VALUES ('2', '2', '0', '0', '1', '0');
INSERT INTO `epqadf` VALUES ('3', '1', '0', '1', '0', '0');
INSERT INTO `epqadf` VALUES ('3', '2', '0', '0', '0', '0');
INSERT INTO `epqadf` VALUES ('4', '1', '0', '0', '0', '0');
INSERT INTO `epqadf` VALUES ('4', '2', '0', '0', '0', '1');
INSERT INTO `epqadf` VALUES ('5', '1', '1', null, null, null);
INSERT INTO `epqadf` VALUES ('5', '2', null, null, null, null);
INSERT INTO `epqadf` VALUES ('6', '1', null, '0', null, null);
INSERT INTO `epqadf` VALUES ('6', '2', null, null, '1', null);
INSERT INTO `epqadf` VALUES ('7', '1', null, '1', '0', null);
INSERT INTO `epqadf` VALUES ('7', '2', null, null, null, '0');
INSERT INTO `epqadf` VALUES ('8', '1', null, null, null, '0');
INSERT INTO `epqadf` VALUES ('8', '2', null, null, '0', '1');
INSERT INTO `epqadf` VALUES ('9', '1', '0', null, null, null);
INSERT INTO `epqadf` VALUES ('9', '2', '0', null, '1', null);
INSERT INTO `epqadf` VALUES ('10', '1', '1', '0', null, null);
INSERT INTO `epqadf` VALUES ('10', '2', null, null, '0', null);
INSERT INTO `epqadf` VALUES ('11', '1', null, '0', null, null);
INSERT INTO `epqadf` VALUES ('11', '2', null, null, '1', '0');
INSERT INTO `epqadf` VALUES ('12', '1', null, '1', '0', '0');
INSERT INTO `epqadf` VALUES ('12', '2', null, null, null, null);
INSERT INTO `epqadf` VALUES ('13', '1', '1', null, null, null);
INSERT INTO `epqadf` VALUES ('13', '2', null, null, null, null);
INSERT INTO `epqadf` VALUES ('14', '1', '1', '0', null, null);
INSERT INTO `epqadf` VALUES ('14', '2', null, null, null, null);
INSERT INTO `epqadf` VALUES ('15', '1', null, '1', '0', null);
INSERT INTO `epqadf` VALUES ('15', '2', null, null, null, '0');
INSERT INTO `epqadf` VALUES ('16', '1', '0', null, null, null);
INSERT INTO `epqadf` VALUES ('16', '2', null, null, null, '1');
INSERT INTO `epqadf` VALUES ('17', '1', '1', null, null, null);
INSERT INTO `epqadf` VALUES ('17', '2', null, null, '0', null);
INSERT INTO `epqadf` VALUES ('18', '1', null, '0', null, null);
INSERT INTO `epqadf` VALUES ('18', '2', null, null, '1', null);
INSERT INTO `epqadf` VALUES ('19', '1', '0', '1', '0', null);
INSERT INTO `epqadf` VALUES ('19', '2', null, null, null, null);
INSERT INTO `epqadf` VALUES ('20', '1', null, '0', null, '1');
INSERT INTO `epqadf` VALUES ('20', '2', null, null, null, '0');
INSERT INTO `epqadf` VALUES ('21', '1', '0', null, null, null);
INSERT INTO `epqadf` VALUES ('21', '2', '1', null, null, '0');
INSERT INTO `epqadf` VALUES ('22', '1', '0', '0', '1', null);
INSERT INTO `epqadf` VALUES ('22', '2', null, null, null, null);
INSERT INTO `epqadf` VALUES ('23', '1', null, '1', '0', null);
INSERT INTO `epqadf` VALUES ('23', '2', null, null, null, null);
INSERT INTO `epqadf` VALUES ('24', '1', null, '0', null, '0');
INSERT INTO `epqadf` VALUES ('24', '2', null, null, null, '1');
INSERT INTO `epqadf` VALUES ('25', '1', '1', null, null, null);
INSERT INTO `epqadf` VALUES ('25', '2', null, null, null, '0');
INSERT INTO `epqadf` VALUES ('26', '1', null, '0', '1', null);
INSERT INTO `epqadf` VALUES ('26', '2', '0', null, null, null);
INSERT INTO `epqadf` VALUES ('27', '1', null, '1', '0', '0');
INSERT INTO `epqadf` VALUES ('27', '2', null, null, null, null);
INSERT INTO `epqadf` VALUES ('28', '1', '0', '0', null, null);
INSERT INTO `epqadf` VALUES ('28', '2', null, null, null, '1');
INSERT INTO `epqadf` VALUES ('29', '1', '0', '0', null, null);
INSERT INTO `epqadf` VALUES ('29', '2', '1', null, null, null);
INSERT INTO `epqadf` VALUES ('30', '1', null, '0', '1', null);
INSERT INTO `epqadf` VALUES ('30', '2', null, null, '0', null);
INSERT INTO `epqadf` VALUES ('31', '1', null, '1', null, '0');
INSERT INTO `epqadf` VALUES ('31', '2', null, null, null, null);
INSERT INTO `epqadf` VALUES ('32', '1', '0', null, '0', '1');
INSERT INTO `epqadf` VALUES ('32', '2', null, null, null, null);
INSERT INTO `epqadf` VALUES ('33', '1', '1', null, null, null);
INSERT INTO `epqadf` VALUES ('33', '2', null, null, '0', null);
INSERT INTO `epqadf` VALUES ('34', '1', null, '0', '1', null);
INSERT INTO `epqadf` VALUES ('34', '2', null, null, null, null);
INSERT INTO `epqadf` VALUES ('35', '1', '0', '1', '0', null);
INSERT INTO `epqadf` VALUES ('35', '2', null, null, null, null);
INSERT INTO `epqadf` VALUES ('36', '1', null, '0', null, '1');
INSERT INTO `epqadf` VALUES ('36', '2', null, null, null, null);
INSERT INTO `epqadf` VALUES ('37', '1', '1', null, null, null);
INSERT INTO `epqadf` VALUES ('37', '2', '0', null, null, null);
INSERT INTO `epqadf` VALUES ('38', '1', null, '0', '0', null);
INSERT INTO `epqadf` VALUES ('38', '2', null, null, '1', null);
INSERT INTO `epqadf` VALUES ('39', '1', null, '1', '0', null);
INSERT INTO `epqadf` VALUES ('39', '2', null, null, null, '0');
INSERT INTO `epqadf` VALUES ('40', '1', '0', null, null, null);
INSERT INTO `epqadf` VALUES ('40', '2', null, null, null, '1');
INSERT INTO `epqadf` VALUES ('41', '1', '1', null, '0', null);
INSERT INTO `epqadf` VALUES ('41', '2', null, null, null, null);
INSERT INTO `epqadf` VALUES ('42', '1', null, '0', null, null);
INSERT INTO `epqadf` VALUES ('42', '2', null, null, '1', null);
INSERT INTO `epqadf` VALUES ('43', '1', '0', '1', '0', null);
INSERT INTO `epqadf` VALUES ('43', '2', null, null, null, null);
INSERT INTO `epqadf` VALUES ('44', '1', null, null, '0', '0');
INSERT INTO `epqadf` VALUES ('44', '2', null, null, null, '1');
INSERT INTO `epqadf` VALUES ('45', '1', '0', null, null, null);
INSERT INTO `epqadf` VALUES ('45', '2', '1', null, null, '0');
INSERT INTO `epqadf` VALUES ('46', '1', '0', '0', '1', null);
INSERT INTO `epqadf` VALUES ('46', '2', null, null, null, null);
INSERT INTO `epqadf` VALUES ('47', '1', null, '1', '0', null);
INSERT INTO `epqadf` VALUES ('47', '2', null, null, null, null);
INSERT INTO `epqadf` VALUES ('48', '1', null, null, null, '0');
INSERT INTO `epqadf` VALUES ('48', '2', null, null, null, '1');
INSERT INTO `epqadf` VALUES ('49', '1', '1', null, null, null);
INSERT INTO `epqadf` VALUES ('49', '2', '0', null, null, null);
INSERT INTO `epqadf` VALUES ('50', '1', null, '0', '1', null);
INSERT INTO `epqadf` VALUES ('50', '2', null, null, '0', null);
INSERT INTO `epqadf` VALUES ('51', '1', null, '1', '0', null);
INSERT INTO `epqadf` VALUES ('51', '2', null, null, null, null);
INSERT INTO `epqadf` VALUES ('52', '1', null, null, null, '0');
INSERT INTO `epqadf` VALUES ('52', '2', null, null, null, '1');
INSERT INTO `epqadf` VALUES ('53', '1', '1', null, '0', null);
INSERT INTO `epqadf` VALUES ('53', '2', null, null, null, null);
INSERT INTO `epqadf` VALUES ('54', '1', null, '0', null, null);
INSERT INTO `epqadf` VALUES ('54', '2', null, null, null, '1');
INSERT INTO `epqadf` VALUES ('55', '1', '1', null, '0', null);
INSERT INTO `epqadf` VALUES ('55', '2', null, null, null, '0');
INSERT INTO `epqadf` VALUES ('56', '1', '0', null, null, '0');
INSERT INTO `epqadf` VALUES ('56', '2', null, null, '1', null);
INSERT INTO `epqadf` VALUES ('57', '1', '0', '1', '0', null);
INSERT INTO `epqadf` VALUES ('57', '2', null, null, null, null);
INSERT INTO `epqadf` VALUES ('58', '1', null, '0', '0', '1');
INSERT INTO `epqadf` VALUES ('58', '2', null, null, null, null);
INSERT INTO `epqadf` VALUES ('59', '1', null, '1', '0', null);
INSERT INTO `epqadf` VALUES ('59', '2', null, null, null, null);
INSERT INTO `epqadf` VALUES ('60', '1', '0', null, '0', null);
INSERT INTO `epqadf` VALUES ('60', '2', null, null, null, '1');
INSERT INTO `epqadf` VALUES ('61', '1', '1', null, null, null);
INSERT INTO `epqadf` VALUES ('61', '2', null, null, null, null);
INSERT INTO `epqadf` VALUES ('62', '1', null, '0', '0', null);
INSERT INTO `epqadf` VALUES ('62', '2', null, null, '1', null);
INSERT INTO `epqadf` VALUES ('63', '1', null, '1', null, '0');
INSERT INTO `epqadf` VALUES ('63', '2', null, null, null, null);
INSERT INTO `epqadf` VALUES ('64', '1', '0', null, null, null);
INSERT INTO `epqadf` VALUES ('64', '2', null, null, null, '1');
INSERT INTO `epqadf` VALUES ('65', '1', '1', '0', '0', null);
INSERT INTO `epqadf` VALUES ('65', '2', null, null, null, null);
INSERT INTO `epqadf` VALUES ('66', '1', null, '0', '1', null);
INSERT INTO `epqadf` VALUES ('66', '2', null, null, '0', null);
INSERT INTO `epqadf` VALUES ('67', '1', null, '1', null, null);
INSERT INTO `epqadf` VALUES ('67', '2', null, null, null, '0');
INSERT INTO `epqadf` VALUES ('68', '1', '0', null, '1', '0');
INSERT INTO `epqadf` VALUES ('68', '2', null, null, null, null);
INSERT INTO `epqadf` VALUES ('69', '1', null, '1', '0', null);
INSERT INTO `epqadf` VALUES ('69', '2', null, null, null, null);
INSERT INTO `epqadf` VALUES ('70', '1', null, '0', null, null);
INSERT INTO `epqadf` VALUES ('70', '2', null, null, null, '1');
INSERT INTO `epqadf` VALUES ('71', '1', '1', null, null, null);
INSERT INTO `epqadf` VALUES ('71', '2', null, null, null, '0');
INSERT INTO `epqadf` VALUES ('72', '1', '0', '0', null, null);
INSERT INTO `epqadf` VALUES ('72', '2', null, null, '1', null);
INSERT INTO `epqadf` VALUES ('73', '1', null, '1', '0', null);
INSERT INTO `epqadf` VALUES ('73', '2', null, null, null, '0');
INSERT INTO `epqadf` VALUES ('74', '1', null, '1', null, null);
INSERT INTO `epqadf` VALUES ('74', '2', null, null, null, null);
INSERT INTO `epqadf` VALUES ('75', '1', '0', null, '1', null);
INSERT INTO `epqadf` VALUES ('75', '2', null, null, null, '0');
INSERT INTO `epqadf` VALUES ('76', '1', '0', '0', '1', null);
INSERT INTO `epqadf` VALUES ('76', '2', null, null, null, null);
INSERT INTO `epqadf` VALUES ('77', '1', null, '1', '0', null);
INSERT INTO `epqadf` VALUES ('77', '2', null, null, '0', null);
INSERT INTO `epqadf` VALUES ('78', '1', null, '1', null, '0');
INSERT INTO `epqadf` VALUES ('78', '2', null, null, null, null);
INSERT INTO `epqadf` VALUES ('79', '1', '0', null, null, '0');
INSERT INTO `epqadf` VALUES ('79', '2', null, null, null, '1');
INSERT INTO `epqadf` VALUES ('80', '1', '1', null, null, null);
INSERT INTO `epqadf` VALUES ('80', '2', null, null, '0', '0');
INSERT INTO `epqadf` VALUES ('81', '1', null, '0', '1', '0');
INSERT INTO `epqadf` VALUES ('81', '2', null, null, null, null);
INSERT INTO `epqadf` VALUES ('82', '1', null, '1', null, null);
INSERT INTO `epqadf` VALUES ('82', '2', null, null, null, '0');
INSERT INTO `epqadf` VALUES ('83', '1', '0', null, null, null);
INSERT INTO `epqadf` VALUES ('83', '2', null, null, null, '1');
INSERT INTO `epqadf` VALUES ('84', '1', '1', '0', null, null);
INSERT INTO `epqadf` VALUES ('84', '2', null, null, null, '0');
INSERT INTO `epqadf` VALUES ('85', '1', '0', null, '1', null);
INSERT INTO `epqadf` VALUES ('85', '2', null, null, null, null);
INSERT INTO `epqadf` VALUES ('86', '1', '0', '1', null, null);
INSERT INTO `epqadf` VALUES ('86', '2', null, null, null, null);
INSERT INTO `epqadf` VALUES ('87', '1', null, null, null, '1');
INSERT INTO `epqadf` VALUES ('87', '2', null, null, null, '0');
INSERT INTO `epqadf` VALUES ('88', '1', '0', null, '0', null);
INSERT INTO `epqadf` VALUES ('88', '2', null, null, '1', null);

-- ----------------------------
-- Table structure for `epqadf_memory`
-- ----------------------------
DROP TABLE IF EXISTS `epqadf_memory`;
CREATE TABLE `epqadf_memory` (
  `TH` int(11) NOT NULL,
  `XZ` tinyint(4) NOT NULL,
  `E` tinyint(4) DEFAULT NULL,
  `N` tinyint(4) DEFAULT NULL,
  `P` tinyint(4) DEFAULT NULL,
  `L` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`TH`,`XZ`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of epqadf_memory
-- ----------------------------

-- ----------------------------
-- Table structure for `epqamd`
-- ----------------------------
DROP TABLE IF EXISTS `epqamd`;
CREATE TABLE `epqamd` (
  `DSEX` tinyint(4) NOT NULL,
  `DAGEL` int(11) NOT NULL,
  `DAGEH` int(11) NOT NULL,
  `EM` float(11,2) NOT NULL,
  `ESD` float(11,2) NOT NULL,
  `NM` float(11,2) NOT NULL,
  `NSD` float(11,2) NOT NULL,
  `PM` float(11,2) NOT NULL,
  `PSD` float(11,2) NOT NULL,
  `LM` float(11,2) NOT NULL,
  `LSD` float(11,2) NOT NULL,
  PRIMARY KEY (`DSEX`,`DAGEL`,`DAGEH`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of epqamd
-- ----------------------------
INSERT INTO `epqamd` VALUES ('1', '16', '20', '11.55', '3.99', '12.31', '4.00', '6.65', '4.36', '11.76', '4.18');
INSERT INTO `epqamd` VALUES ('1', '20', '30', '10.63', '4.44', '11.26', '4.26', '5.96', '2.84', '12.17', '3.57');
INSERT INTO `epqamd` VALUES ('1', '30', '40', '9.92', '3.90', '12.02', '4.56', '5.85', '3.32', '12.39', '3.93');
INSERT INTO `epqamd` VALUES ('1', '40', '50', '9.65', '4.77', '10.12', '5.04', '5.67', '2.54', '13.55', '3.56');
INSERT INTO `epqamd` VALUES ('1', '50', '60', '8.63', '3.69', '11.07', '6.31', '6.05', '3.31', '13.93', '3.80');
INSERT INTO `epqamd` VALUES ('1', '60', '150', '9.80', '4.64', '8.92', '4.59', '4.40', '2.33', '15.35', '2.73');
INSERT INTO `epqamd` VALUES ('2', '16', '20', '10.23', '4.09', '12.28', '4.92', '5.06', '2.69', '12.85', '4.08');
INSERT INTO `epqamd` VALUES ('2', '20', '30', '8.65', '4.49', '13.06', '4.42', '4.92', '2.95', '13.35', '3.63');
INSERT INTO `epqamd` VALUES ('2', '30', '40', '8.97', '4.45', '12.02', '5.05', '4.80', '3.33', '14.17', '3.65');
INSERT INTO `epqamd` VALUES ('2', '40', '50', '8.37', '4.35', '12.15', '5.73', '4.03', '2.40', '15.41', '3.22');
INSERT INTO `epqamd` VALUES ('2', '50', '60', '9.22', '4.21', '11.09', '5.21', '4.05', '2.90', '14.09', '4.03');
INSERT INTO `epqamd` VALUES ('2', '60', '150', '9.34', '4.31', '11.36', '5.08', '3.82', '2.41', '15.95', '3.65');

-- ----------------------------
-- Table structure for `epqamd_memory`
-- ----------------------------
DROP TABLE IF EXISTS `epqamd_memory`;
CREATE TABLE `epqamd_memory` (
  `DSEX` tinyint(4) NOT NULL,
  `DAGEL` int(11) NOT NULL,
  `DAGEH` int(11) NOT NULL,
  `EM` float(11,2) NOT NULL,
  `ESD` float(11,2) NOT NULL,
  `NM` float(11,2) NOT NULL,
  `NSD` float(11,2) NOT NULL,
  `PM` float(11,2) NOT NULL,
  `PSD` float(11,2) NOT NULL,
  `LM` float(11,2) NOT NULL,
  `LSD` float(11,2) NOT NULL,
  PRIMARY KEY (`DSEX`,`DAGEL`,`DAGEH`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of epqamd_memory
-- ----------------------------

-- ----------------------------
-- Table structure for `examinee`
-- ----------------------------
DROP TABLE IF EXISTS `examinee`;
CREATE TABLE `examinee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` varchar(45) NOT NULL COMMENT '被试人员编号，等同username',
  `password` varchar(256) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `other` text COMMENT '其他内容，存成json字符串',
  `sex` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 为默认值\r\n0 女性\r\n1 男性',
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
  `state` tinyint(4) DEFAULT '0' COMMENT '测试状态：0，未答题；1，答案存储成功；2，基础得分算完；3，因子得分算完；4，指标得分算完；5，十项报表生成；6，最终报告生成',
  `exam_time` int(11) DEFAULT NULL COMMENT '答题时间记录',
  `init_data` text COMMENT '用户信息的初始值存记',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`number`),
  KEY `index3` (`project_id`),
  CONSTRAINT `fk_examinee_1` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of examinee
-- ----------------------------
INSERT INTO `examinee` VALUES ('1', '15020001', '639656', '王强', '{\"education\":[{\"school\":\"北大\",\"profession\":\"计算机\",\"degree\":\"博士\",\"date\":\"2014.12-\"},{\"school\":\"北航\",\"profession\":\"软件\",\"degree\":\"学士\",\"date\":\"2011.01-2014.01\"}],\"work\":[{\"employer\":\"北航\",\"unit\":\"科技部\",\"duty\":\"副部长\",\"date\":\"2015.02-\"},{\"employer\":\"北航\",\"unit\":\"科技部\",\"duty\":\"科长\",\"date\":\"2014.12-2015.01\"}]}', '0', '北京市', '职高', '无党派', '无职称', '学士', '', '', '', '', '1502', '1967-11-15', '2015-09-19 18:41:30', '4', '42', null);
INSERT INTO `examinee` VALUES ('3', '15020003', '095152', '赵春', '{\"education\":[],\"work\":[]}', '0', '北京市', '职高', '党员', '无职称', '无', '', '', '', '', '1502', '1990-01-30', '2015-09-13 21:57:47', '4', '27', null);

-- ----------------------------
-- Table structure for `factor`
-- ----------------------------
DROP TABLE IF EXISTS `factor`;
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
) ENGINE=InnoDB AUTO_INCREMENT=221 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of factor
-- ----------------------------
INSERT INTO `factor` VALUES ('142', 'A', null, null, '134', '3,26,27,51,52,76,101,126,151,176', '1,1,1,1,1,1,1,1,1,1', 'sum', '$ans=$ans', null, '乐群性');
INSERT INTO `factor` VALUES ('143', 'B', null, null, '134', '28,53,54,77,78,102,103,127,128,152,153,177,178', '1,1,1,1,1,1,1,1,1,1,1,1,1', 'sum', '$ans=$ans', null, '聪慧性');
INSERT INTO `factor` VALUES ('144', 'C', null, null, '134', '4,5,29,30,55,79,80,104,105,129,130,154,179', '1,1,1,1,1,1,1,1,1,1,1,1,1', 'sum', '$ans=$ans', null, '稳定性');
INSERT INTO `factor` VALUES ('145', 'E', null, null, '134', '6,7,31,32,56,57,81,106,131,155,156,180,181', '1,1,1,1,1,1,1,1,1,1,1,1,1', 'sum', '$ans=$ans', null, '恃强性');
INSERT INTO `factor` VALUES ('146', 'F', null, null, '134', '8,33,58,82,83,107,108,132,133,157,158,182,183', '1,1,1,1,1,1,1,1,1,1,1,1,1', 'sum', '$ans=$ans', null, '兴奋性');
INSERT INTO `factor` VALUES ('147', 'G', null, null, '134', '9,34,59,84,109,134,159,160,184,185', '1,1,1,1,1,1,1,1,1,1', 'sum', '$ans=$ans', null, '有恒性');
INSERT INTO `factor` VALUES ('148', 'H', null, null, '134', '10,35,36,60,61,85,86,110,111,135,136,161,186', '1,1,1,1,1,1,1,1,1,1,1,1,1', 'sum', '$ans=$ans', null, '敢为性');
INSERT INTO `factor` VALUES ('149', 'I', null, null, '134', '11,12,37,62,87,112,137,138,162,163', '1,1,1,1,1,1,1,1,1,1', 'sum', '$ans=$ans', null, '敏感性');
INSERT INTO `factor` VALUES ('150', 'L', null, null, '134', '13,38,63,64,88,89,113,114,139,164', '1,1,1,1,1,1,1,1,1,1', 'sum', '$ans=$ans', null, '怀疑性');
INSERT INTO `factor` VALUES ('151', 'M', null, null, '134', '14,15,39,40,65,90,91,115,116,140,141,165,166', '1,1,1,1,1,1,1,1,1,1,1,1,1', 'sum', '$ans=$ans', null, '幻想性');
INSERT INTO `factor` VALUES ('152', 'N', null, null, '134', '16,17,41,42,66,67,92,117,142,167', '1,1,1,1,1,1,1,1,1,1', 'sum', '$ans=$ans', null, '世故性');
INSERT INTO `factor` VALUES ('153', 'O', null, null, '134', '18,19,43,44,68,69,93,94,118,119,143,144,168', '1,1,1,1,1,1,1,1,1,1,1,1,1', 'sum', '$ans=$ans', null, '忧虑性');
INSERT INTO `factor` VALUES ('154', 'Q1', null, null, '134', '20,21,45,46,70,95,120,145,169,170', '1,1,1,1,1,1,1,1,1,1', 'sum', '$ans=$ans', null, '实验性');
INSERT INTO `factor` VALUES ('155', 'Q2', null, null, '134', '22,47,71,72,96,97,121,122,146,171', '1,1,1,1,1,1,1,1,1,1', 'sum', '$ans=$ans', null, '独立性');
INSERT INTO `factor` VALUES ('156', 'Q3', null, null, '134', '23,24,48,73,98,123,147,148,172,173', '1,1,1,1,1,1,1,1,1,1', 'sum', '$ans=$ans', null, '自律性');
INSERT INTO `factor` VALUES ('157', 'Q4', null, null, '134', '25,49,50,74,75,99,100,124,125,149,150,174,175', '1,1,1,1,1,1,1,1,1,1,1,1,1', 'sum', '$ans=10-$ans', null, '紧张性');
INSERT INTO `factor` VALUES ('158', 'X1', null, null, '134', 'L,O,Q4,C,H,Q3', '0,0,0,0,0,0', '(38+2*L+3*O+4*Q4-(2*C+2*H+2*Q3))/10', '$ans=10-$ans', null, '适应与焦虑');
INSERT INTO `factor` VALUES ('159', 'X2', null, null, '134', 'A,E,F,H,Q2', '0,0,0,0,0', '(2*A+3*E+4*F+5*H-(2*Q2+11))/10', '$ans=$ans', null, '内向与外向');
INSERT INTO `factor` VALUES ('160', 'X3', null, null, '134', 'C,E,F,N,A,I,M', '0,0,0,0,0,0,0', '(77+2*C+2*E+2*F+2*N-(4*A+6*I+2*M))/10', '$ans=$ans', null, '感情用事');
INSERT INTO `factor` VALUES ('161', 'X4', null, null, '134', 'E,M,Q1,Q2,A,G', '0,0,0,0,0,0', '(4*E+3*M+4*Q1+4*Q2-(3*A+2*G))/10', '$ans=$ans', null, '怯懦与果断');
INSERT INTO `factor` VALUES ('162', 'Y1', null, null, '134', 'C,F,O,Q4', '0,0,0,0', 'C+F+(11-O)+(11-Q4)', '$ans=$ans/4', null, '心理健康');
INSERT INTO `factor` VALUES ('163', 'Y2', null, null, '134', 'Q3,G,C,E,N,Q1,Q2', '0,0,0,0,0,0,0', '2*Q3+2*G+2*C+E+N+Q1+Q2', '$ans=$ans/7.5', null, '专业成就');
INSERT INTO `factor` VALUES ('164', 'Y3', null, null, '134', 'A,B,E,F,H,I,M,N,Q1,Q2', '0,0,0,0,0,0,0,0,0,0', '2*(11-A)+2*B+E+2*(11-F)+H+2*I+M+(11-N)+Q1+2*Q2', '$ans=$ans', null, '创造力');
INSERT INTO `factor` VALUES ('165', 'Y4', null, null, '134', 'B,G,Q3,F', '0,0,0,0', 'B+G+Q3+(11-F)', '$ans=$ans/4', null, '成长能力');
INSERT INTO `factor` VALUES ('166', 'end', null, null, '136', '153,158,163,168,173,178,182,188,193,198,203,208,213,218,223,61,62,63,64,65,136,137,138,139,140,211,212,213,214,215', '1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1', 'sum-1', '$ans=$ans/2.8', null, '持久需要');
INSERT INTO `factor` VALUES ('167', 'int', null, null, '136', '77,82,87,92,97,102,107,112,117,122,127,132,137,142,147,31,32,33,34,35,106,107,108,109,110,181,182,183,184,185', '1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1', 'sum-1', '$ans=$ans/2.8', null, '省察需要');
INSERT INTO `factor` VALUES ('168', 'ord', null, null, '136', '3,8,13,18,23,28,33,38,43,48,53,58,63,68,73,11,12,13,14,15,86,87,88,89,90,161,162,163,164,165', '1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1', 'sum-1', '$ans=$ans/2.8', null, '秩序需要');
INSERT INTO `factor` VALUES ('169', 'ach', null, null, '136', '1,6,11,16,21,26,31,36,41,46,51,56,61,66,71,1,2,3,4,5,76,77,78,79,80,151,152,153,154,155', '1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1', 'sum-1', '$ans=$ans/2.8', null, '成就需要');
INSERT INTO `factor` VALUES ('170', 'chg', null, null, '136', '152,157,162,167,172,177,182,187,192,197,202,207,212,217,222,56,57,58,59,60,131,132,133,134,135,206,207,208,209,210', '1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1', 'sum-1', '$ans=$ans/2.8', null, '变异需要');
INSERT INTO `factor` VALUES ('171', 'aba', null, null, '136', '80,85,90,95,100,105,110,115,120,125,130,135,140,145,150,46,47,48,49,50,121,122,123,124,125,196,197,198,199,200', '1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1', 'sum-1', '$ans=$ans/2.8', null, '谦卑需要');
INSERT INTO `factor` VALUES ('172', 'dom', null, null, '136', '79,84,89,94,99,104,109,114,119,124,129,134,139,144,149,41,42,43,44,45,116,117,118,119,120,191,192,193,194,195', '1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1', 'sum-1', '$ans=$ans/2.8', null, '支配需要');
INSERT INTO `factor` VALUES ('173', 'aff', null, null, '136', '76,81,86,91,96,101,106,111,116,121,126,131,136,141,146,26,27,28,29,30,101,102,103,104,105,176,177,178,179,180', '1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1', 'sum-1', '$ans=$ans/2.8', null, '亲和需要');
INSERT INTO `factor` VALUES ('174', 'def', null, null, '136', '2,7,12,17,22,27,32,37,42,47,52,57,62,67,72,6,7,8,9,10,81,82,83,84,85,156,157,158,159,160', '1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1', 'sum-1', '$ans=$ans/2.8', null, '顺从需要');
INSERT INTO `factor` VALUES ('175', 'agg', null, null, '136', '155,160,165,170,175,180,185,190,195,200,205,210,215,220,225,71,72,73,74,75,146,147,148,149,150,221,222,223,224,225', '1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1', 'sum-1', '$ans=$ans/2.8', null, '攻击需要');
INSERT INTO `factor` VALUES ('176', 'suc', null, null, '136', '78,83,88,93,98,103,108,113,118,123,128,133,138,143,148,36,37,38,39,40,111,112,113,114,115,186,187,188,189,190', '1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1', 'sum-1', '$ans=$ans/2.8', null, '求助需要');
INSERT INTO `factor` VALUES ('177', 'exh', null, null, '136', '4,9,14,19,24,29,34,39,44,49,54,59,64,69,74,16,17,18,19,20,91,92,93,94,95,166,167,168,169,170', '1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1', 'sum-1', '$ans=$ans/2.8', null, '表现需要');
INSERT INTO `factor` VALUES ('178', 'aut', null, null, '136', '5,10,15,20,25,30,35,40,45,50,55,60,65,70,75,21,22,23,24,25,96,97,98,99,100,171,172,173,174,175', '1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1', 'sum-1', '$ans=$ans/2.8', null, '自主需要');
INSERT INTO `factor` VALUES ('179', 'het', null, null, '136', '154,159,164,169,174,179,184,189,194,199,204,209,214,219,224,66,67,68,69,70,141,142,143,144,145,216,217,218,219,220', '1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1', 'sum-1', '$ans=$ans/2.8', null, '异性恋需要');
INSERT INTO `factor` VALUES ('180', 'nur', null, null, '136', '151,156,161,166,171,176,181,186,191,196,201,206,211,216,221,51,52,53,54,55,126,127,128,129,130,201,202,203,204,205', '1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1', 'sum-1', '$ans=$ans/2.8', null, '慈善需要');
INSERT INTO `factor` VALUES ('181', 'con', null, null, '136', '1,7,13,19,25,26,32,38,44,50,51,57,63,69,75,101,107,113,119,125,151,157,163,169,175,201,207,213,219,225', '1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1', 'sum', 'if ($ans == 1) $ans = 9; else                    if ($ans == 2) $ans = 8; else                      if ($ans == 3) $ans = 7; else                    if ($ans == 4) $ans = 5; else                     if($ans ==6 ) $ans=2; else $ans = 1;', null, '稳定系数');
INSERT INTO `factor` VALUES ('182', 'soma', null, null, '137', '1,4,12,27,40,42,48,49,52,53,56,58', '1,1,1,1,1,1,1,1,1,1,1,1', 'avg', 'if ($ans == 1) $ans = 9; else                    if ($ans < 1.1) $ans = 8; else                      if ($ans < 1.3) $ans = 7; else                    if ($ans < 1.4) $ans = 6; else                     if($ans <1.6 ) $ans=4;else                     if ($ans < 2) $ans = 3; else                      if ($ans < 4) $ans = 2; else $ans = 1;', null, '躯体化');
INSERT INTO `factor` VALUES ('183', 'obse', null, null, '137', '3,9,10,28,38,45,46,51,55,65', '1,1,1,1,1,1,1,1,1,1', 'avg', 'if ($ans == 1) $ans = 9; else                    if ($ans < 1.1) $ans = 8; else                      if ($ans < 1.3) $ans = 7; else                    if ($ans < 1.4) $ans = 6; else                     if($ans <1.6 ) $ans=4;else                     if ($ans < 2) $ans = 3; else                      if ($ans < 4) $ans = 2; else $ans = 1;', null, '强迫症状');
INSERT INTO `factor` VALUES ('184', 'inte', null, null, '137', '6,21,34,36,37,41,61,69,73', '1,1,1,1,1,1,1,1,1', 'avg', 'if ($ans == 1) $ans = 9; else                    if ($ans < 1.1) $ans = 8; else                      if ($ans < 1.3) $ans = 7; else                    if ($ans < 1.4) $ans = 6; else                     if($ans <1.6 ) $ans=4;else                     if ($ans < 2) $ans = 3; else                      if ($ans < 4) $ans = 2; else $ans = 1;', null, '人际关系敏感');
INSERT INTO `factor` VALUES ('185', 'depr', null, null, '137', '5,14,15,20,22,26,29,30,31,32,54,71,79', '1,1,1,1,1,1,1,1,1,1,1,1,1', 'avg', 'if ($ans == 1) $ans = 9; else                    if ($ans < 1.1) $ans = 8; else                      if ($ans < 1.3) $ans = 7; else                    if ($ans < 1.4) $ans = 6; else                     if($ans <1.6 ) $ans=4;else                     if ($ans < 2) $ans = 3; else                      if ($ans < 4) $ans = 2; else $ans = 1;', null, '忧郁');
INSERT INTO `factor` VALUES ('186', 'anxi', null, null, '137', '2,17,23,33,39,57,72,78,80,86', '1,1,1,1,1,1,1,1,1,1', 'avg', 'if ($ans == 1) $ans = 9; else                    if ($ans < 1.1) $ans = 8; else                      if ($ans < 1.3) $ans = 7; else                    if ($ans < 1.4) $ans = 6; else                     if($ans <1.6 ) $ans=4;else                     if ($ans < 2) $ans = 3; else                      if ($ans < 4) $ans = 2; else $ans = 1;', null, '焦虑');
INSERT INTO `factor` VALUES ('187', 'host', null, null, '137', '11,24,63,67,74,81', '1,1,1,1,1,1', 'avg', 'if ($ans == 1) $ans = 9; else                    if ($ans < 1.1) $ans = 8; else                      if ($ans < 1.3) $ans = 7; else                    if ($ans < 1.4) $ans = 6; else                     if($ans <1.6 ) $ans=4;else                     if ($ans < 2) $ans = 3; else                      if ($ans < 4) $ans = 2; else $ans = 1;', null, '敌对');
INSERT INTO `factor` VALUES ('188', 'phob', null, null, '137', '13,25,47,50,70,75,82', '1,1,1,1,1,1,1', 'avg', 'if ($ans == 1) $ans = 9; else                    if ($ans < 1.1) $ans = 8; else                      if ($ans < 1.3) $ans = 7; else                    if ($ans < 1.4) $ans = 6; else                     if($ans <1.6 ) $ans=4;else                     if ($ans < 2) $ans = 3; else                      if ($ans < 4) $ans = 2; else $ans = 1;', null, '恐怖');
INSERT INTO `factor` VALUES ('189', 'parn', null, null, '137', '8,18,43,68,76,83', '1,1,1,1,1,1', 'avg', 'if ($ans == 1) $ans = 9; else                    if ($ans < 1.1) $ans = 8; else                      if ($ans < 1.3) $ans = 7; else                    if ($ans < 1.4) $ans = 6; else                     if($ans <1.6 ) $ans=4;else                     if ($ans < 2) $ans = 3; else                      if ($ans < 4) $ans = 2; else $ans = 1;', null, '偏执');
INSERT INTO `factor` VALUES ('190', 'psyc', null, null, '137', '7,16,35,62,77,84,85,87,88,90', '1,1,1,1,1,1,1,1,1,1', 'avg', 'if ($ans == 1) $ans = 9; else                    if ($ans < 1.1) $ans = 8; else                      if ($ans < 1.3) $ans = 7; else                    if ($ans < 1.4) $ans = 6; else                     if($ans <1.6 ) $ans=4;else                     if ($ans < 2) $ans = 3; else                      if ($ans < 4) $ans = 2; else $ans = 1;', null, '精神病性');
INSERT INTO `factor` VALUES ('191', 'qtfm', null, null, '137', '19,44,59,60,64,66,89', '1,1,1,1,1,1,1', 'avg', 'if ($ans == 1) $ans = 9; else                    if ($ans < 1.1) $ans = 8; else                      if ($ans < 1.3) $ans = 7; else                    if ($ans < 1.4) $ans = 6; else                     if($ans <1.6 ) $ans=4;else                     if ($ans < 2) $ans = 3; else                      if ($ans < 4) $ans = 2; else $ans = 1;', null, '其它');
INSERT INTO `factor` VALUES ('192', 'epqae', null, null, '133', '1,5,10,13,14,17,21,25,29,33,37,41,45,49,53,55,61,65,71,80,84', '1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1', 'sum', '$ans=$ans/10', null, '内外向');
INSERT INTO `factor` VALUES ('193', 'epqan', null, null, '133', '3,7,12,15,19,23,27,31,35,39,43,47,51,57,59,63,67,69,73,74,77,78,82,86', '1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1', 'sum', '$ans=10-$ans/10', null, '神经质');
INSERT INTO `factor` VALUES ('194', 'epqap', null, null, '133', '2,6,9,11,18,22,26,30,34,38,42,46,50,56,62,66,68,72,75,76,81,85,88', '1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1', 'sum', '$ans=10-$ans/10', null, '精神质');
INSERT INTO `factor` VALUES ('195', 'epqal', null, null, '133', '4,8,16,20,24,28,32,36,40,44,48,52,54,58,60,64,70,79,83,87', '1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1', 'sum', '$ans=10-$ans/10', null, '掩饰性');
INSERT INTO `factor` VALUES ('196', 'do', null, null, '135', '26,27,57,83,89,91,130,153,161,170,174,181,193,199,205,109,213,224,227', '1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1', 'sum', '$ans=$ans/10', null, '支配性');
INSERT INTO `factor` VALUES ('197', 'cs', null, null, '135', '8,18,23,36,43,50,79,83,95,99,113,115,139,149', '1,1,1,1,1,1,1,1,1,1,1,1,1,1', 'sum', '$ans=$ans/10', null, '进取性');
INSERT INTO `factor` VALUES ('198', 'sy', null, null, '135', '1,25,38,46,53,54,57,64,72,81,83,120,130,136,146,147', '1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1', 'sum', '$ans=$ans/10', null, '社交性');
INSERT INTO `factor` VALUES ('199', 'sp', null, null, '135', '3,11,23,25,28,34,38,40,46,53,89,99,103,113,116,126,131', '1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1', 'sum', '$ans=$ans/10', null, '自在性');
INSERT INTO `factor` VALUES ('200', 'sa', null, null, '135', '4,16,17,57,89,91,113,130,147,154', '1,1,1,1,1,1,1,1,1,1', 'sum', '$ans=$ans/10', null, '自承性');
INSERT INTO `factor` VALUES ('201', 'wb', null, null, '135', '7,35,48,96,117,134,155,159,166,172,178,180,187,191,202,204,206,214,217,220', '1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1', 'sum', '$ans=$ans/10', null, '幸福感');
INSERT INTO `factor` VALUES ('202', 're', null, null, '135', '21,24,30,37,39,41,58,65,69,82,101,104,106,132,143,150', '1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1', 'sum', '$ans=$ans/10', null, '责任感');
INSERT INTO `factor` VALUES ('203', 'so', null, null, '135', '71,82,84,107,157,169,171,186,195,196,197,201,207,211,216,218,219,221,225,229', '1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1', 'sum', '$ans=$ans/10', null, '社会化');
INSERT INTO `factor` VALUES ('204', 'sc', null, null, '135', '3,14,20,22,26,42,53,59,68,74,85,86,90,92,94,96,116,121,129,135,141,142,152,154,155,156', '1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1', 'sum', '$ans=$ans/10', null, '自制力');
INSERT INTO `factor` VALUES ('205', 'po', null, null, '135', '7,12,33,48,50,74,77,88,92,93,102,110,123,129,134,148,152', '1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1', 'sum', '$ans=$ans/10', null, '宽容性');
INSERT INTO `factor` VALUES ('206', 'gi', null, null, '135', '6,15,20,22,32,35,42,44,49,52,55,73,75,78,85,90,100,116,118,133,141,151', '1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1', 'sum', '$ans=$ans/10', null, '好印象');
INSERT INTO `factor` VALUES ('207', 'cm', null, null, '135', '158,160,162,163,168,173,176,177,182,188,192,215,226', '1,1,1,1,1,1,1,1,1,1,1,1,1', 'sum', '$ans=$ans/10', null, '同众性');
INSERT INTO `factor` VALUES ('208', 'ac', null, null, '135', '14,24,61,72,76,80,86,87,98,107,117,121,125,137,144', '1,1,1,1,1,1,1,1,1,1,1,1,1,1,1', 'sum', '$ans=$ans/10', null, '遵循成就');
INSERT INTO `factor` VALUES ('209', 'ai', null, null, '135', '4,19,29,60,62,66,70,102,111,119,127,128,139,152', '1,1,1,1,1,1,1,1,1,1,1,1,1,1', 'sum', '$ans=$ans/10', null, '独立成就');
INSERT INTO `factor` VALUES ('210', 'ie', null, null, '135', '25,40,57,83,99,130,136,146,179,185,208,210,212,222', '1,1,1,1,1,1,1,1,1,1,1,1,1,1', 'sum', '$ans=$ans/10', null, '精干性');
INSERT INTO `factor` VALUES ('211', 'py', null, null, '135', '5,27,47,51,67,72,94,105,112,114,145', '1,1,1,1,1,1,1,1,1,1,1', 'sum', '$ans=$ans/10', null, '心理性');
INSERT INTO `factor` VALUES ('212', 'fx', null, null, '135', '164,165,167,175,183,184,189,190,194,198,203,223,228,230', '1,1,1,1,1,1,1,1,1,1,1,1,1,1', 'sum', 'if ($ans == 100) $ans = 10; else                    if ($ans > 80) $ans = 9; else                      if ($ans > 65) $ans = 8; else                    if ($ans > 30) $ans = 5; else                     if ($ans > 10) $ans = 2;else $ans = 1;', null, '灵活性');
INSERT INTO `factor` VALUES ('213', 'fe', null, null, '135', '9,13,28,31,42,45,56,65,71,104,107,108,122,124,138,140', '1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1', 'sum', '$ans=$ans/10', null, '女性化');
INSERT INTO `factor` VALUES ('214', 'spma', null, null, '138', '1,2,3,4,5,6,7,8,9,10,11,12', '1,1,1,1,1,1,1,1,1,1,1,1', 'sum', 'if ($ans == 1) $ans = 9; else                    if ($ans == 2) $ans = 7.5; else                      if ($ans == 3) $ans = 6; else                    if ($ans == 4) $ans = 5; else                      if ($ans == 5) $ans = 4; else $ans = 1;', null, 'SPM(A)');
INSERT INTO `factor` VALUES ('215', 'spmb', null, null, '138', '13,14,15,16,17,18,19,20,21,22,23,24', '1,1,1,1,1,1,1,1,1,1,1,1', 'sum', 'if ($ans == 1) $ans = 9; else                    if ($ans == 2) $ans = 7.5; else                      if ($ans == 3) $ans = 6; else                    if ($ans == 4) $ans = 5; else                      if ($ans == 5) $ans = 4; else $ans = 1;', null, 'SPM(B)');
INSERT INTO `factor` VALUES ('216', 'spmc', null, null, '138', '25,26,27,28,29,30,31,32,33,34,35,36', '1,1,1,1,1,1,1,1,1,1,1,1', 'sum', 'if ($ans == 1) $ans = 9; else                    if ($ans == 2) $ans = 7.5; else                      if ($ans == 3) $ans = 6; else                    if ($ans == 4) $ans = 5; else                      if ($ans == 5) $ans = 4; else $ans = 1;', null, 'SPM(C)');
INSERT INTO `factor` VALUES ('217', 'spmd', null, null, '138', '37,38,39,40,41,42,43,44,45,46,47,48', '1,1,1,1,1,1,1,1,1,1,1,1', 'sum', 'if ($ans == 1) $ans = 9; else                    if ($ans == 2) $ans = 7.5; else                      if ($ans == 3) $ans = 6; else                    if ($ans == 4) $ans = 5; else                      if ($ans == 5) $ans = 4; else $ans = 1;', null, 'SPM(D)');
INSERT INTO `factor` VALUES ('218', 'spme', null, null, '138', '49,50,51,52,53,54,55,56,57,58,59,60', '1,1,1,1,1,1,1,1,1,1,1,1', 'sum', 'if ($ans == 1) $ans = 9; else                    if ($ans == 2) $ans = 7.5; else                      if ($ans == 3) $ans = 6; else                    if ($ans == 4) $ans = 5; else                      if ($ans == 5) $ans = 4; else $ans = 1;', null, 'SPM(E)');
INSERT INTO `factor` VALUES ('219', 'spm', null, null, '138', 'spma,spmb,spmc,spmd,spme', '0,0,0,0,0', 'spma+spmb+spmc+spmd+spme', null, null, 'SPM');
INSERT INTO `factor` VALUES ('220', 'spmabc', null, null, '138', 'spma,spmb,spmc', '0,0,0', 'spma+spmb+spmc', null, null, 'SPM(A、B、C)');

-- ----------------------------
-- Table structure for `factor_ans`
-- ----------------------------
DROP TABLE IF EXISTS `factor_ans`;
CREATE TABLE `factor_ans` (
  `score` float(11,2) DEFAULT NULL COMMENT '因子得分',
  `std_score` float(11,2) DEFAULT NULL COMMENT '因子标准分',
  `examinee_id` int(11) NOT NULL COMMENT '被试人员id，并非编号',
  `factor_id` int(11) NOT NULL COMMENT '所属因子id',
  `ans_score` float(11,2) DEFAULT NULL,
  PRIMARY KEY (`examinee_id`,`factor_id`),
  KEY `fk_factor_ans_2_idx` (`factor_id`),
  CONSTRAINT `fk_factor_ans_1` FOREIGN KEY (`examinee_id`) REFERENCES `examinee` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_factor_ans_2` FOREIGN KEY (`factor_id`) REFERENCES `factor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of factor_ans
-- ----------------------------
INSERT INTO `factor_ans` VALUES ('10.00', '5.00', '1', '142', '5.00');
INSERT INTO `factor_ans` VALUES ('2.00', '1.00', '1', '143', '1.00');
INSERT INTO `factor_ans` VALUES ('16.00', '6.00', '1', '144', '6.00');
INSERT INTO `factor_ans` VALUES ('14.00', '7.00', '1', '145', '7.00');
INSERT INTO `factor_ans` VALUES ('12.00', '5.00', '1', '146', '5.00');
INSERT INTO `factor_ans` VALUES ('12.00', '5.00', '1', '147', '5.00');
INSERT INTO `factor_ans` VALUES ('12.00', '6.00', '1', '148', '6.00');
INSERT INTO `factor_ans` VALUES ('8.00', '4.00', '1', '149', '4.00');
INSERT INTO `factor_ans` VALUES ('12.00', '6.00', '1', '150', '6.00');
INSERT INTO `factor_ans` VALUES ('12.00', '5.00', '1', '151', '5.00');
INSERT INTO `factor_ans` VALUES ('10.00', '6.00', '1', '152', '6.00');
INSERT INTO `factor_ans` VALUES ('14.00', '7.00', '1', '153', '7.00');
INSERT INTO `factor_ans` VALUES ('12.00', '6.00', '1', '154', '6.00');
INSERT INTO `factor_ans` VALUES ('10.00', '5.00', '1', '155', '5.00');
INSERT INTO `factor_ans` VALUES ('12.00', '5.00', '1', '156', '5.00');
INSERT INTO `factor_ans` VALUES ('18.00', '8.00', '1', '157', '2.00');
INSERT INTO `factor_ans` VALUES ('6.90', '6.90', '1', '158', '3.10');
INSERT INTO `factor_ans` VALUES ('6.00', '6.00', '1', '159', '6.00');
INSERT INTO `factor_ans` VALUES ('7.10', '7.10', '1', '160', '7.10');
INSERT INTO `factor_ans` VALUES ('6.20', '6.20', '1', '161', '6.20');
INSERT INTO `factor_ans` VALUES ('18.00', '18.00', '1', '162', '4.50');
INSERT INTO `factor_ans` VALUES ('56.00', '56.00', '1', '163', '7.47');
INSERT INTO `factor_ans` VALUES ('73.00', '4.00', '1', '164', '4.00');
INSERT INTO `factor_ans` VALUES ('17.00', '17.00', '1', '165', '4.25');
INSERT INTO `factor_ans` VALUES ('14.00', '14.00', '1', '166', '5.00');
INSERT INTO `factor_ans` VALUES ('14.00', '14.00', '1', '167', '5.00');
INSERT INTO `factor_ans` VALUES ('14.00', '14.00', '1', '168', '5.00');
INSERT INTO `factor_ans` VALUES ('14.00', '14.00', '1', '169', '5.00');
INSERT INTO `factor_ans` VALUES ('14.00', '14.00', '1', '170', '5.00');
INSERT INTO `factor_ans` VALUES ('14.00', '14.00', '1', '171', '5.00');
INSERT INTO `factor_ans` VALUES ('14.00', '14.00', '1', '172', '5.00');
INSERT INTO `factor_ans` VALUES ('14.00', '14.00', '1', '173', '5.00');
INSERT INTO `factor_ans` VALUES ('14.00', '14.00', '1', '174', '5.00');
INSERT INTO `factor_ans` VALUES ('14.00', '14.00', '1', '175', '5.00');
INSERT INTO `factor_ans` VALUES ('14.00', '14.00', '1', '176', '5.00');
INSERT INTO `factor_ans` VALUES ('14.00', '14.00', '1', '177', '5.00');
INSERT INTO `factor_ans` VALUES ('14.00', '14.00', '1', '178', '5.00');
INSERT INTO `factor_ans` VALUES ('14.00', '14.00', '1', '179', '5.00');
INSERT INTO `factor_ans` VALUES ('14.00', '14.00', '1', '180', '5.00');
INSERT INTO `factor_ans` VALUES ('0.00', '0.00', '1', '181', '1.00');
INSERT INTO `factor_ans` VALUES ('1.00', '1.00', '1', '182', '9.00');
INSERT INTO `factor_ans` VALUES ('1.00', '1.00', '1', '183', '9.00');
INSERT INTO `factor_ans` VALUES ('1.00', '1.00', '1', '184', '9.00');
INSERT INTO `factor_ans` VALUES ('1.00', '1.00', '1', '185', '9.00');
INSERT INTO `factor_ans` VALUES ('1.00', '1.00', '1', '186', '9.00');
INSERT INTO `factor_ans` VALUES ('1.00', '1.00', '1', '187', '9.00');
INSERT INTO `factor_ans` VALUES ('1.00', '1.00', '1', '188', '9.00');
INSERT INTO `factor_ans` VALUES ('1.00', '1.00', '1', '189', '9.00');
INSERT INTO `factor_ans` VALUES ('1.00', '1.00', '1', '190', '9.00');
INSERT INTO `factor_ans` VALUES ('1.00', '1.00', '1', '191', '9.00');
INSERT INTO `factor_ans` VALUES ('18.00', '72.14', '1', '192', '7.21');
INSERT INTO `factor_ans` VALUES ('24.00', '70.68', '1', '193', '2.93');
INSERT INTO `factor_ans` VALUES ('12.00', '83.21', '1', '194', '1.68');
INSERT INTO `factor_ans` VALUES ('5.00', '17.67', '1', '195', '8.23');
INSERT INTO `factor_ans` VALUES ('10.00', '54.78', '1', '196', '5.48');
INSERT INTO `factor_ans` VALUES ('6.00', '51.43', '1', '197', '5.14');
INSERT INTO `factor_ans` VALUES ('9.00', '49.56', '1', '198', '4.96');
INSERT INTO `factor_ans` VALUES ('8.00', '48.84', '1', '199', '4.88');
INSERT INTO `factor_ans` VALUES ('2.00', '39.23', '1', '200', '3.92');
INSERT INTO `factor_ans` VALUES ('0.00', '6.41', '1', '201', '0.64');
INSERT INTO `factor_ans` VALUES ('3.00', '17.23', '1', '202', '1.72');
INSERT INTO `factor_ans` VALUES ('5.00', '21.14', '1', '203', '2.11');
INSERT INTO `factor_ans` VALUES ('1.00', '19.54', '1', '204', '1.95');
INSERT INTO `factor_ans` VALUES ('0.00', '18.45', '1', '205', '1.84');
INSERT INTO `factor_ans` VALUES ('1.00', '27.12', '1', '206', '2.71');
INSERT INTO `factor_ans` VALUES ('4.00', '17.38', '1', '207', '1.74');
INSERT INTO `factor_ans` VALUES ('0.00', '13.79', '1', '208', '1.38');
INSERT INTO `factor_ans` VALUES ('0.00', '21.55', '1', '209', '2.16');
INSERT INTO `factor_ans` VALUES ('5.00', '31.14', '1', '210', '3.11');
INSERT INTO `factor_ans` VALUES ('0.00', '20.55', '1', '211', '2.06');
INSERT INTO `factor_ans` VALUES ('1.00', '35.86', '1', '212', '5.00');
INSERT INTO `factor_ans` VALUES ('8.00', '45.36', '1', '213', '4.54');
INSERT INTO `factor_ans` VALUES ('2.00', '2.00', '1', '214', '1.67');
INSERT INTO `factor_ans` VALUES ('2.00', '2.00', '1', '215', '1.67');
INSERT INTO `factor_ans` VALUES ('2.00', '2.00', '1', '216', '1.67');
INSERT INTO `factor_ans` VALUES ('1.00', '1.00', '1', '217', '0.83');
INSERT INTO `factor_ans` VALUES ('2.00', '2.00', '1', '218', '1.67');
INSERT INTO `factor_ans` VALUES ('9.00', '50.00', '1', '219', '4.00');
INSERT INTO `factor_ans` VALUES ('6.00', '6.00', '1', '220', '1.67');
INSERT INTO `factor_ans` VALUES ('10.00', '5.00', '3', '142', '5.00');
INSERT INTO `factor_ans` VALUES ('2.00', '1.00', '3', '143', '1.00');
INSERT INTO `factor_ans` VALUES ('16.00', '6.00', '3', '144', '6.00');
INSERT INTO `factor_ans` VALUES ('14.00', '7.00', '3', '145', '7.00');
INSERT INTO `factor_ans` VALUES ('12.00', '5.00', '3', '146', '5.00');
INSERT INTO `factor_ans` VALUES ('12.00', '5.00', '3', '147', '5.00');
INSERT INTO `factor_ans` VALUES ('12.00', '6.00', '3', '148', '6.00');
INSERT INTO `factor_ans` VALUES ('8.00', '4.00', '3', '149', '4.00');
INSERT INTO `factor_ans` VALUES ('12.00', '6.00', '3', '150', '6.00');
INSERT INTO `factor_ans` VALUES ('12.00', '5.00', '3', '151', '5.00');
INSERT INTO `factor_ans` VALUES ('10.00', '6.00', '3', '152', '6.00');
INSERT INTO `factor_ans` VALUES ('14.00', '7.00', '3', '153', '7.00');
INSERT INTO `factor_ans` VALUES ('12.00', '6.00', '3', '154', '6.00');
INSERT INTO `factor_ans` VALUES ('10.00', '5.00', '3', '155', '5.00');
INSERT INTO `factor_ans` VALUES ('12.00', '5.00', '3', '156', '5.00');
INSERT INTO `factor_ans` VALUES ('18.00', '8.00', '3', '157', '2.00');
INSERT INTO `factor_ans` VALUES ('6.90', '6.90', '3', '158', '3.10');
INSERT INTO `factor_ans` VALUES ('6.00', '6.00', '3', '159', '6.00');
INSERT INTO `factor_ans` VALUES ('7.10', '7.10', '3', '160', '7.10');
INSERT INTO `factor_ans` VALUES ('6.20', '6.20', '3', '161', '6.20');
INSERT INTO `factor_ans` VALUES ('18.00', '18.00', '3', '162', '4.50');
INSERT INTO `factor_ans` VALUES ('56.00', '56.00', '3', '163', '7.47');
INSERT INTO `factor_ans` VALUES ('73.00', '4.00', '3', '164', '4.00');
INSERT INTO `factor_ans` VALUES ('17.00', '17.00', '3', '165', '4.25');
INSERT INTO `factor_ans` VALUES ('14.00', '14.00', '3', '166', '5.00');
INSERT INTO `factor_ans` VALUES ('14.00', '14.00', '3', '167', '5.00');
INSERT INTO `factor_ans` VALUES ('14.00', '14.00', '3', '168', '5.00');
INSERT INTO `factor_ans` VALUES ('14.00', '14.00', '3', '169', '5.00');
INSERT INTO `factor_ans` VALUES ('14.00', '14.00', '3', '170', '5.00');
INSERT INTO `factor_ans` VALUES ('14.00', '14.00', '3', '171', '5.00');
INSERT INTO `factor_ans` VALUES ('14.00', '14.00', '3', '172', '5.00');
INSERT INTO `factor_ans` VALUES ('14.00', '14.00', '3', '173', '5.00');
INSERT INTO `factor_ans` VALUES ('14.00', '14.00', '3', '174', '5.00');
INSERT INTO `factor_ans` VALUES ('14.00', '14.00', '3', '175', '5.00');
INSERT INTO `factor_ans` VALUES ('14.00', '14.00', '3', '176', '5.00');
INSERT INTO `factor_ans` VALUES ('14.00', '14.00', '3', '177', '5.00');
INSERT INTO `factor_ans` VALUES ('14.00', '14.00', '3', '178', '5.00');
INSERT INTO `factor_ans` VALUES ('14.00', '14.00', '3', '179', '5.00');
INSERT INTO `factor_ans` VALUES ('14.00', '14.00', '3', '180', '5.00');
INSERT INTO `factor_ans` VALUES ('0.00', '0.00', '3', '181', '1.00');
INSERT INTO `factor_ans` VALUES ('1.00', '1.00', '3', '182', '9.00');
INSERT INTO `factor_ans` VALUES ('1.00', '1.00', '3', '183', '9.00');
INSERT INTO `factor_ans` VALUES ('1.00', '1.00', '3', '184', '9.00');
INSERT INTO `factor_ans` VALUES ('1.00', '1.00', '3', '185', '9.00');
INSERT INTO `factor_ans` VALUES ('1.00', '1.00', '3', '186', '9.00');
INSERT INTO `factor_ans` VALUES ('1.00', '1.00', '3', '187', '9.00');
INSERT INTO `factor_ans` VALUES ('1.00', '1.00', '3', '188', '9.00');
INSERT INTO `factor_ans` VALUES ('1.00', '1.00', '3', '189', '9.00');
INSERT INTO `factor_ans` VALUES ('1.00', '1.00', '3', '190', '9.00');
INSERT INTO `factor_ans` VALUES ('1.00', '1.00', '3', '191', '9.00');
INSERT INTO `factor_ans` VALUES ('18.00', '70.82', '3', '192', '7.08');
INSERT INTO `factor_ans` VALUES ('24.00', '74.75', '3', '193', '2.53');
INSERT INTO `factor_ans` VALUES ('12.00', '74.00', '3', '194', '2.60');
INSERT INTO `factor_ans` VALUES ('5.00', '27.00', '3', '195', '7.30');
INSERT INTO `factor_ans` VALUES ('10.00', '54.78', '3', '196', '5.48');
INSERT INTO `factor_ans` VALUES ('6.00', '51.43', '3', '197', '5.14');
INSERT INTO `factor_ans` VALUES ('9.00', '49.56', '3', '198', '4.96');
INSERT INTO `factor_ans` VALUES ('8.00', '48.84', '3', '199', '4.88');
INSERT INTO `factor_ans` VALUES ('2.00', '39.23', '3', '200', '3.92');
INSERT INTO `factor_ans` VALUES ('0.00', '6.41', '3', '201', '0.64');
INSERT INTO `factor_ans` VALUES ('3.00', '17.23', '3', '202', '1.72');
INSERT INTO `factor_ans` VALUES ('5.00', '21.14', '3', '203', '2.11');
INSERT INTO `factor_ans` VALUES ('1.00', '19.54', '3', '204', '1.95');
INSERT INTO `factor_ans` VALUES ('0.00', '18.45', '3', '205', '1.84');
INSERT INTO `factor_ans` VALUES ('1.00', '27.12', '3', '206', '2.71');
INSERT INTO `factor_ans` VALUES ('4.00', '17.38', '3', '207', '1.74');
INSERT INTO `factor_ans` VALUES ('0.00', '13.79', '3', '208', '1.38');
INSERT INTO `factor_ans` VALUES ('0.00', '21.55', '3', '209', '2.16');
INSERT INTO `factor_ans` VALUES ('5.00', '31.14', '3', '210', '3.11');
INSERT INTO `factor_ans` VALUES ('0.00', '20.55', '3', '211', '2.06');
INSERT INTO `factor_ans` VALUES ('1.00', '35.86', '3', '212', '5.00');
INSERT INTO `factor_ans` VALUES ('8.00', '45.36', '3', '213', '4.54');
INSERT INTO `factor_ans` VALUES ('2.00', '2.00', '3', '214', '1.67');
INSERT INTO `factor_ans` VALUES ('2.00', '2.00', '3', '215', '1.67');
INSERT INTO `factor_ans` VALUES ('2.00', '2.00', '3', '216', '1.67');
INSERT INTO `factor_ans` VALUES ('1.00', '1.00', '3', '217', '0.83');
INSERT INTO `factor_ans` VALUES ('2.00', '2.00', '3', '218', '1.67');
INSERT INTO `factor_ans` VALUES ('9.00', '50.00', '3', '219', '4.00');
INSERT INTO `factor_ans` VALUES ('6.00', '6.00', '3', '220', '1.67');

-- ----------------------------
-- Table structure for `index`
-- ----------------------------
DROP TABLE IF EXISTS `index`;
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

-- ----------------------------
-- Records of index
-- ----------------------------
INSERT INTO `index` VALUES ('2', 'zb_ldnl', null, null, 'zb_pdyjcnl,zb_zzglnl,zb_cxnl,zb_ybnl,zb_dlgznl', '0,0,0,0,0', '领导能力', null, '(2*(zb_pdyjcnl + zb_zzglnl)+ zb_cxnl + zb_ybnl+ zb_dlgznl)/7');
INSERT INTO `index` VALUES ('3', 'zb_pdyjcnl', null, null, 'X4,H,chg,Y3,ord,end,aut,X3', '1,1,1,1,1,1,1,1', '判断与决策能力', null, '(1.5*(X4 + H)+chg +Y3 + ord+end +aut +X3)/8');
INSERT INTO `index` VALUES ('4', 'zb_zzglnl', null, null, 'dom,ord,H,X4,Y2,ach,end,aut,re,do', '1,1,1,1,1,1,1,1,1,1', '组织管理能力', null, '(1.5*(dom + ord) + H + X4 + Y2 + ach + end + aut + re + do)/11');
INSERT INTO `index` VALUES ('5', 'zb_fxx', null, null, 'H,chg,M,Q2,I,sp,sa,A', '1,1,1,1,1,1,1,1', '风险性', null, '(1.5*(H + chg) + M + Q2 + I + sp + sa + A)/9');
INSERT INTO `index` VALUES ('6', 'zb_dlgznl', null, null, 'aut,Q2,dom,ai,ach,exh,def,Q1,H,E,ie', '1,1,1,1,1,1,1,1,1,1,1', '独立工作能力', null, '(1.5*(aut + Q2) + dom + ai + ach + exh + def + Q1 + H + E + ie)/12');
INSERT INTO `index` VALUES ('7', 'zb_cxnl', null, null, 'Y3,H,chg,M,I,F,Q1,L,A,fx,py,end,Y4', '1,1,1,1,1,1,1,1,1,1,1,1,1', '创新能力', null, '(1.5*(Y3 + H + chg) + M + I + F + Q1 + L + A + fx + py + end + Y4)/14.5');
INSERT INTO `index` VALUES ('8', 'zb_ybnl', null, null, 'X1,Y4,Y3,chg,ach,Q1,I,B,Q3', '1,1,1,1,1,1,1,1,1', '应变能力', null, '(1.5*(X1 + Y4) + Y3 + chg + ach + Q1 + I + B + Q3)/10');
INSERT INTO `index` VALUES ('9', 'zb_jlx', null, null, 'Q3,sc,sa,po,G,fx,so,int', '1,1,1,1,1,1,1,1', '纪律性', null, '(1.5*(Q3 + sc) + sa + po + G + fx + so + int)/9');
INSERT INTO `index` VALUES ('10', 'zb_fxnl', null, null, 'spmd,Y3,int,B,Y4,Y2,end,Q2,ord,E,L', '1,1,1,1,1,1,1,1,1,1,1', '分析能力', null, '(1.5*(spmd + Y3 + int) + B + Y4 + Y2 + end + Q2 + ord + E + L)/12.5');
INSERT INTO `index` VALUES ('11', 'zb_gnnl', null, null, 'spme,spmd,Y2,ai,ac,chg,aut,dom,Q2,N,fx,ie', '1,1,1,1,1,1,1,1,1,1,1,1', '归纳能力', null, '(1.5*(spme + spmd + Y2) + ai + ac + chg + aut + dom + Q2 + N + fx + ie)/13.5');
INSERT INTO `index` VALUES ('12', 'zb_zrx', null, null, 're,G,C,Q2,ach,end,ac,ai,def,aut,ord,dom', '1,1,1,1,1,1,1,1,1,1,1,1', '责任心', null, '(2*(re + G + C + Q2) + ach + end + ac + ai + def + aut + ord + dom)/16');
INSERT INTO `index` VALUES ('13', 'zb_cxd', null, null, 'con,epqal,gi,wb,Q3,re,cm', '1,1,1,1,1,1,1', '诚信度', null, '(1.5*(con + epqal) + gi + wb + Q3 + re + cm)/8');
INSERT INTO `index` VALUES ('14', 'zb_grjzqx', null, null, 'ach,Y2,cs,exh,dom,nur,aff,aba,def,gi,wb,Q3,sc,po', '1,1,1,1,1,1,1,1,1,1,1,1,1,1', '个人价值取向', null, '(2*(ach + Y2 + cs) + exh + dom + nur + aff + aba + def + gi + wb + Q3 + sc +po)/17');
INSERT INTO `index` VALUES ('15', 'zb_tdjs', null, null, 'ac,A,Y2,aff,def,ach,ord,end,aut,cs,ai', '1,1,1,1,1,1,1,1,1,1,1', '团队精神', null, '(1.5*(ac + A + Y2) + aff + def + ach + ord + end + aut + cs +ai)/12.5');
INSERT INTO `index` VALUES ('16', 'zb_gztd', null, null, 're,Q2,G,ord,end,sc,Y4', '1,1,1,1,1,1,1', '工作态度', null, '(1.5*(re + Q2) + G + ord + end + sc + Y4)/8');
INSERT INTO `index` VALUES ('17', 'zb_gzzf', null, null, 'X4,zb_rjgxtjsp,chg,Y3,Q3,spmabc,aff', '1,0,1,1,1,1,1', '工作作风', null, '(1.5*(X4 + zb_rjgxtjsp) + chg + Y3 + Q3 + spmabc + aff)/8');
INSERT INTO `index` VALUES ('18', 'zb_rnx', null, null, 'po,nur,aff,ac,aba,def,X1,A,L,E', '1,1,1,1,1,1,1,1,1,1', '容纳性', null, '(1.5*(po + nur + aff) + ac + aba + def + X1 + A + L + E)/11.5');
INSERT INTO `index` VALUES ('19', 'zb_bxx', null, null, 'exh,gi,cm,wb,sy,aut,dom,agg,Q2', '1,1,1,1,1,1,1,1,1', '表现性', null, '(1.5*(exh + gi + cm) + wb + sy + aut + dom + agg + Q2)/10.5');
INSERT INTO `index` VALUES ('20', 'zb_rjgxtjsp', null, null, 'po,aff,nur,def,E,X3,N,inte,I,aba,suc,fx', '1,1,1,1,1,1,1,1,1,1,1,1', '人际关系调节水平', null, '(1.5*(po + aff + nur) + def + E + X3 + N + inte + I + aba + suc +fx)/13.5');
INSERT INTO `index` VALUES ('21', 'zb_tzjl', null, null, 'soma,obse,epqap,epqan,F,M,G,I', '1,1,1,1,1,1,1,1', '体质精力', null, '(1.5*(soma + obse) + epqap + epqan + F + M + G + I)/9');
INSERT INTO `index` VALUES ('22', 'zb_xg', null, null, 'X2,epqae,A,sy,sa,sp,F,exh,spmabc,I', '1,1,1,1,1,1,1,1,1,1', '性格', null, '(1.5*(X2 + epqae + A) + sy + sa + sp + F + exh + spmabc + I)/11.5');
INSERT INTO `index` VALUES ('23', 'zb_qxkzsp', null, null, 'Y1,sc,C,G,Q3,F,I,po,N,epqan', '1,1,1,1,1,1,1,1,1,1', '情绪控制水平', null, '(1.5*(Y1 + sc + C) + G + Q3 + F + I + po + N + epqan)/11.5');
INSERT INTO `index` VALUES ('24', 'zb_syhjsp', null, null, 'Y4,fx,sp,O,sc,po,Q4,X1', '1,1,1,1,1,1,1,1', '适应环境水平', null, '(1.5*(Y4 + fx) + sp + O + sc + po + Q4 + X1)/9');
INSERT INTO `index` VALUES ('25', 'zb_zz', null, null, 'ai,end,E,G,aut,def,agg,Q2,H,L,parn', '1,1,1,1,1,1,1,1,1,1,1', '执着', null, '(1.5*(ai + end + E) + G + aut + def + agg + Q2 + H + L + parn)/12.5');
INSERT INTO `index` VALUES ('26', 'zb_xljksp', null, null, 'Y1,C,sc,X1,sa,Q3,py,O,Q4,A', '1,1,1,1,1,1,1,1,1,1', '心理健康水平', null, '(1.5*(Y1 + C + sc + X1) + sa + Q3 + py + O + Q4+ A)/12');
INSERT INTO `index` VALUES ('27', 'zb_sjnl', null, null, 'sy,aff,def,end,agg,I,F,epqae,A,L,E,sp', '1,1,1,1,1,1,1,1,1,1,1,1', '社交水平', null, '(1.5*(sy + aff + def + end) + agg + I + F + epqae + A + L + E +sp)/14');
INSERT INTO `index` VALUES ('28', 'zb_chd', null, null, 'B,spm,Y4,Y2,Y3,chg,ai,ac,ie,N', '1,1,1,1,1,1,1,1,1,1', '聪慧度', null, '(1.5*(B + spm + Y4) + Y2 + Y3 + chg + ai + ac + ie + N)/11.5');
INSERT INTO `index` VALUES ('29', 'zb_jmng', null, null, 'ie,N,fx,sc,po,sa,Y4', '1,1,1,1,1,1,1', '精明能干', null, '(1.5*(ie + N) + fx + sc + po + sa + Y4)/8');

-- ----------------------------
-- Table structure for `index_ans`
-- ----------------------------
DROP TABLE IF EXISTS `index_ans`;
CREATE TABLE `index_ans` (
  `score` float(11,2) NOT NULL COMMENT '指标最终得分\n',
  `index_id` int(11) NOT NULL COMMENT '指标id',
  `examinee_id` int(11) NOT NULL COMMENT '被试人员id，并非编号',
  PRIMARY KEY (`index_id`,`examinee_id`),
  KEY `fk_index_ans_1_idx` (`examinee_id`),
  KEY `fk_index_ans_2_idx` (`index_id`),
  CONSTRAINT `fk_index_ans_1` FOREIGN KEY (`examinee_id`) REFERENCES `examinee` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_index_ans_2` FOREIGN KEY (`index_id`) REFERENCES `index` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of index_ans
-- ----------------------------
INSERT INTO `index_ans` VALUES ('5.22', '2', '1');
INSERT INTO `index_ans` VALUES ('5.22', '2', '3');
INSERT INTO `index_ans` VALUES ('6.17', '3', '1');
INSERT INTO `index_ans` VALUES ('6.17', '3', '3');
INSERT INTO `index_ans` VALUES ('5.17', '4', '1');
INSERT INTO `index_ans` VALUES ('5.17', '4', '3');
INSERT INTO `index_ans` VALUES ('4.92', '5', '1');
INSERT INTO `index_ans` VALUES ('4.92', '5', '3');
INSERT INTO `index_ans` VALUES ('4.94', '6', '1');
INSERT INTO `index_ans` VALUES ('4.94', '6', '3');
INSERT INTO `index_ans` VALUES ('4.81', '7', '1');
INSERT INTO `index_ans` VALUES ('4.81', '7', '3');
INSERT INTO `index_ans` VALUES ('4.10', '8', '1');
INSERT INTO `index_ans` VALUES ('4.10', '8', '3');
INSERT INTO `index_ans` VALUES ('3.70', '9', '1');
INSERT INTO `index_ans` VALUES ('3.70', '9', '3');
INSERT INTO `index_ans` VALUES ('4.44', '10', '1');
INSERT INTO `index_ans` VALUES ('4.44', '10', '3');
INSERT INTO `index_ans` VALUES ('3.90', '11', '1');
INSERT INTO `index_ans` VALUES ('3.90', '11', '3');
INSERT INTO `index_ans` VALUES ('4.31', '12', '1');
INSERT INTO `index_ans` VALUES ('4.31', '12', '3');
INSERT INTO `index_ans` VALUES ('3.21', '13', '1');
INSERT INTO `index_ans` VALUES ('3.03', '13', '3');
INSERT INTO `index_ans` VALUES ('4.55', '14', '1');
INSERT INTO `index_ans` VALUES ('4.55', '14', '3');
INSERT INTO `index_ans` VALUES ('4.65', '15', '1');
INSERT INTO `index_ans` VALUES ('4.65', '15', '3');
INSERT INTO `index_ans` VALUES ('3.91', '16', '1');
INSERT INTO `index_ans` VALUES ('3.91', '16', '3');
INSERT INTO `index_ans` VALUES ('4.73', '17', '1');
INSERT INTO `index_ans` VALUES ('4.73', '17', '3');
INSERT INTO `index_ans` VALUES ('4.37', '18', '1');
INSERT INTO `index_ans` VALUES ('4.37', '18', '3');
INSERT INTO `index_ans` VALUES ('3.79', '19', '1');
INSERT INTO `index_ans` VALUES ('3.79', '19', '3');
INSERT INTO `index_ans` VALUES ('5.25', '20', '1');
INSERT INTO `index_ans` VALUES ('5.25', '20', '3');
INSERT INTO `index_ans` VALUES ('5.62', '21', '1');
INSERT INTO `index_ans` VALUES ('5.68', '21', '3');
INSERT INTO `index_ans` VALUES ('4.93', '22', '1');
INSERT INTO `index_ans` VALUES ('4.92', '22', '3');
INSERT INTO `index_ans` VALUES ('4.21', '23', '1');
INSERT INTO `index_ans` VALUES ('4.18', '23', '3');
INSERT INTO `index_ans` VALUES ('3.85', '24', '1');
INSERT INTO `index_ans` VALUES ('3.85', '24', '3');
INSERT INTO `index_ans` VALUES ('5.38', '25', '1');
INSERT INTO `index_ans` VALUES ('5.38', '25', '3');
INSERT INTO `index_ans` VALUES ('4.03', '26', '1');
INSERT INTO `index_ans` VALUES ('4.03', '26', '3');
INSERT INTO `index_ans` VALUES ('5.29', '27', '1');
INSERT INTO `index_ans` VALUES ('5.28', '27', '3');
INSERT INTO `index_ans` VALUES ('3.74', '28', '1');
INSERT INTO `index_ans` VALUES ('3.74', '28', '3');
INSERT INTO `index_ans` VALUES ('3.83', '29', '1');
INSERT INTO `index_ans` VALUES ('3.83', '29', '3');

-- ----------------------------
-- Table structure for `inquery_ans`
-- ----------------------------
DROP TABLE IF EXISTS `inquery_ans`;
CREATE TABLE `inquery_ans` (
  `project_id` int(11) NOT NULL,
  `examinee_id` int(11) NOT NULL,
  `option` text,
  PRIMARY KEY (`project_id`,`examinee_id`),
  KEY `fk_inquery_ans_2_idx` (`examinee_id`),
  KEY `fk_inquery_ans_1_idx` (`project_id`) USING BTREE,
  CONSTRAINT `fk_inquery_ans_1` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_inquery_ans_2` FOREIGN KEY (`examinee_id`) REFERENCES `examinee` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of inquery_ans
-- ----------------------------
INSERT INTO `inquery_ans` VALUES ('1502', '1', 'a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a');
INSERT INTO `inquery_ans` VALUES ('1502', '3', 'a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a');

-- ----------------------------
-- Table structure for `inquery_question`
-- ----------------------------
DROP TABLE IF EXISTS `inquery_question`;
CREATE TABLE `inquery_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `topic` text COMMENT '题目描述',
  `options` text,
  `is_radio` tinyint(1) DEFAULT NULL,
  `project_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`project_id`),
  KEY `fk_project_id` (`project_id`),
  CONSTRAINT `fk_project_id` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of inquery_question
-- ----------------------------
INSERT INTO `inquery_question` VALUES ('1', '您的职务', '下属单位正职|下属单位副职|机关单位正职|机关单位副职|机关单位科员', '1', '1502');
INSERT INTO `inquery_question` VALUES ('2', '性别', '男|女', '1', '1502');
INSERT INTO `inquery_question` VALUES ('3', '您的年龄', '30岁及以下|31-35岁|36-40岁|41-45岁|46-50岁|50-55岁|56岁以上', '1', '1502');
INSERT INTO `inquery_question` VALUES ('4', '您最初参加工作时的学历', '中专|高职|大专|本科|硕士|博士|其它', '1', '1502');
INSERT INTO `inquery_question` VALUES ('5', '您的最后学历', '函授业余自考大专|函授业余自考本科|全日制大专|在职大专|全日制本科|在职本科|全日制硕士|在职硕士|博士|其它', '1', '1502');
INSERT INTO `inquery_question` VALUES ('6', '您的教育专业背景', '管理类|经济类|社科类|理工类|法律类|其他', '1', '1502');
INSERT INTO `inquery_question` VALUES ('7', '您的技术职称', '无职称|初级|中级|副高职|正高职', '1', '1502');
INSERT INTO `inquery_question` VALUES ('8', '您在本单位工作年限', '5年以下|5-10年|11-15年|16-20年|21-25年|26年以上', '1', '1502');
INSERT INTO `inquery_question` VALUES ('9', '您担任当前职务的工作年限', '1年及以下|1-3年|3-5年|5-10年|10年以上', '1', '1502');
INSERT INTO `inquery_question` VALUES ('10', '您的自我职业定位是什么', '管理者|执行者|开拓者|技术专家', '1', '1502');
INSERT INTO `inquery_question` VALUES ('11', '您在日常的工作中，更多是处于以下哪种工作状态', '非常胜任|比较胜任|胜任|基本胜任|有所不足', '1', '1502');
INSERT INTO `inquery_question` VALUES ('12', '您是否希望接受难度更大、责任更大、压力更大的工作挑战', '不希望|无所谓|希望但没信心|希望又有信心', '1', '1502');
INSERT INTO `inquery_question` VALUES ('13', '您认为自己胜任现岗位的优势是（最多选三项）', '工作经验|团队领导能力|决策能力|责任心|创新能力|应变能力|自控能力|学习能力|敬业精神|坚持不懈|战略规划能力|其他', '0', '1502');
INSERT INTO `inquery_question` VALUES ('14', '您认为在目前的岗位上，您的能力能够发挥出多少', '充分发挥100|发挥80|发挥50|发挥30|发挥20以下', '1', '1502');
INSERT INTO `inquery_question` VALUES ('15', '您认为中青年干部应继续提升哪些方面的职业能力（最多选三项）', '战略规划能力|团队领导能力|决策能力|独立工作能力|创新能力|应变能力|自控能力|学习能力|影响力|执行力|组织管理能力|社交能力', '0', '1502');
INSERT INTO `inquery_question` VALUES ('16', '您认为中青年干部应继续提升哪些方面的职业素质（最多选三项）', '责任心|诚信正直|团队精神|工作态度|坚持不懈|善于自律|宽容大度|价值观|人际关系协调', '0', '1502');
INSERT INTO `inquery_question` VALUES ('17', '您目前最需要的是（最多选三项）', '接受培训|增加收入|改善福利和社会保障|提升职务|晋升职称|调整岗位|调换单位|改善人际关系|改善身体状况|职业生涯设计', '0', '1502');
INSERT INTO `inquery_question` VALUES ('18', '您目前最希望学习的内容（最多选三项）', '管理|外语|沟通技巧|获得更高学位|专业知识|计算机|财务|战略', '0', '1502');
INSERT INTO `inquery_question` VALUES ('19', '您计划在接下一年里继续提升哪些方面的能力（最多选三项）', '坚持不懈|团队领导能力|决策能力|责任心|创新能力|应变能力|自控能力|学习能力|敬业精神', '0', '1502');
INSERT INTO `inquery_question` VALUES ('20', '您认为自己胜任现岗位的优势是（最多选三项）', '工作经验|团队领导能力|决策能力|责任心|创新能力|应变能力|自控能力|学习能力|敬业精神|坚持不懈|战略规划能力|其他', '0', '1502');
INSERT INTO `inquery_question` VALUES ('21', '您认为最应该在如下哪个方面加以增强，以留住优秀职工：', '改变传统用人观念|创造良好的工作环境|提供自我管理的弹性组织|提供弹性的工作安排|提供挑战性高的工作|提供有针对性的技能培训', '1', '1502');
INSERT INTO `inquery_question` VALUES ('22', '您期望通过参加本次培训获得什么（最多选三项）', '提升工作能力|拓宽眼界思路|增强党性修养|相互借鉴交流|补充更新知识|统一思想认识', '0', '1502');
INSERT INTO `inquery_question` VALUES ('23', '您认为本单位哪一个环节亟待提升：', '发展愿景使命及价值观|机关文化建设|发展战略制定|管理体制和机制|制定配套的管理制度和模式|实施有效管理|运营流程管理|人力资源管理|团队建设|职工培训和发展|培养职业化的审计队伍|制定工作标准和工作规范', '1', '1502');
INSERT INTO `inquery_question` VALUES ('24', '您个人认为您的哪一项能力最需提升:', '目标管理能力|执行能力|沟通与写作能力|组织管理能力|应变与适应能力|创新能力|学习能力|开发指导能力|职业化能力', '1', '1502');
INSERT INTO `inquery_question` VALUES ('25', '您认为中青年干部国际化素质提升最需要哪种培训方式？ （最多选三项）', '举办专题研讨班|进入国际知名企业学习交流|外籍专家进行经验分享|在重大海外项目锻炼|进入境外高端培训机构学习|其他', '0', '1502');

-- ----------------------------
-- Table structure for `interview`
-- ----------------------------
DROP TABLE IF EXISTS `interview`;
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

-- ----------------------------
-- Records of interview
-- ----------------------------

-- ----------------------------
-- Table structure for `ksdf`
-- ----------------------------
DROP TABLE IF EXISTS `ksdf`;
CREATE TABLE `ksdf` (
  `TH` int(11) NOT NULL,
  `A` tinyint(4) NOT NULL,
  `B` tinyint(4) NOT NULL,
  `C` tinyint(4) NOT NULL,
  PRIMARY KEY (`TH`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ksdf
-- ----------------------------
INSERT INTO `ksdf` VALUES ('1', '0', '0', '0');
INSERT INTO `ksdf` VALUES ('2', '0', '0', '0');
INSERT INTO `ksdf` VALUES ('3', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('4', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('5', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('6', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('7', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('8', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('9', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('10', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('11', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('12', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('13', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('14', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('15', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('16', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('17', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('18', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('19', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('20', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('21', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('22', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('23', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('24', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('25', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('26', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('27', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('28', '0', '1', '0');
INSERT INTO `ksdf` VALUES ('29', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('30', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('31', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('32', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('33', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('34', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('35', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('36', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('37', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('38', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('39', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('40', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('41', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('42', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('43', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('44', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('45', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('46', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('47', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('48', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('49', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('50', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('51', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('52', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('53', '0', '1', '0');
INSERT INTO `ksdf` VALUES ('54', '0', '1', '0');
INSERT INTO `ksdf` VALUES ('55', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('56', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('57', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('58', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('59', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('60', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('61', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('62', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('63', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('64', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('65', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('66', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('67', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('68', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('69', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('70', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('71', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('72', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('73', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('74', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('75', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('76', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('77', '0', '0', '1');
INSERT INTO `ksdf` VALUES ('78', '0', '1', '0');
INSERT INTO `ksdf` VALUES ('79', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('80', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('81', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('82', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('83', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('84', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('85', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('86', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('87', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('88', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('89', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('90', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('91', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('92', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('93', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('94', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('95', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('96', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('97', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('98', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('99', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('100', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('101', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('102', '0', '0', '1');
INSERT INTO `ksdf` VALUES ('103', '0', '1', '0');
INSERT INTO `ksdf` VALUES ('104', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('105', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('106', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('107', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('108', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('109', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('110', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('111', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('112', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('113', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('114', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('115', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('116', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('117', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('118', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('119', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('120', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('121', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('122', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('123', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('124', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('125', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('126', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('127', '0', '0', '1');
INSERT INTO `ksdf` VALUES ('128', '0', '1', '0');
INSERT INTO `ksdf` VALUES ('129', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('130', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('131', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('132', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('133', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('134', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('135', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('136', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('137', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('138', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('139', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('140', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('141', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('142', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('143', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('144', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('145', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('146', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('147', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('148', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('149', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('150', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('151', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('152', '0', '1', '0');
INSERT INTO `ksdf` VALUES ('153', '0', '0', '1');
INSERT INTO `ksdf` VALUES ('154', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('155', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('156', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('157', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('158', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('159', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('160', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('161', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('162', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('163', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('164', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('165', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('166', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('167', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('168', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('169', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('170', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('171', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('172', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('173', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('174', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('175', '0', '1', '2');
INSERT INTO `ksdf` VALUES ('176', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('177', '1', '0', '0');
INSERT INTO `ksdf` VALUES ('178', '1', '0', '0');
INSERT INTO `ksdf` VALUES ('179', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('180', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('181', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('182', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('183', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('184', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('185', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('186', '2', '1', '0');
INSERT INTO `ksdf` VALUES ('187', '0', '0', '0');

-- ----------------------------
-- Table structure for `ksdf_memory`
-- ----------------------------
DROP TABLE IF EXISTS `ksdf_memory`;
CREATE TABLE `ksdf_memory` (
  `TH` int(11) NOT NULL,
  `A` tinyint(4) NOT NULL,
  `B` tinyint(4) NOT NULL,
  `C` tinyint(4) NOT NULL,
  PRIMARY KEY (`TH`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ksdf_memory
-- ----------------------------

-- ----------------------------
-- Table structure for `ksmd`
-- ----------------------------
DROP TABLE IF EXISTS `ksmd`;
CREATE TABLE `ksmd` (
  `DM` int(11) NOT NULL DEFAULT '0',
  `YZ` char(2) CHARACTER SET latin1 NOT NULL,
  `QSF` int(11) NOT NULL,
  `ZZF` int(11) NOT NULL,
  `BZF` int(11) NOT NULL,
  PRIMARY KEY (`YZ`,`DM`,`QSF`,`ZZF`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ksmd
-- ----------------------------
INSERT INTO `ksmd` VALUES ('8', 'A', '0', '2', '1');
INSERT INTO `ksmd` VALUES ('8', 'A', '3', '3', '2');
INSERT INTO `ksmd` VALUES ('8', 'A', '4', '5', '3');
INSERT INTO `ksmd` VALUES ('8', 'A', '6', '7', '4');
INSERT INTO `ksmd` VALUES ('8', 'A', '8', '10', '5');
INSERT INTO `ksmd` VALUES ('8', 'A', '11', '12', '6');
INSERT INTO `ksmd` VALUES ('8', 'A', '13', '13', '7');
INSERT INTO `ksmd` VALUES ('8', 'A', '14', '15', '8');
INSERT INTO `ksmd` VALUES ('8', 'A', '16', '17', '9');
INSERT INTO `ksmd` VALUES ('8', 'A', '18', '999', '10');
INSERT INTO `ksmd` VALUES ('9', 'A', '0', '3', '1');
INSERT INTO `ksmd` VALUES ('9', 'A', '4', '5', '2');
INSERT INTO `ksmd` VALUES ('9', 'A', '6', '7', '3');
INSERT INTO `ksmd` VALUES ('9', 'A', '8', '8', '4');
INSERT INTO `ksmd` VALUES ('9', 'A', '9', '10', '5');
INSERT INTO `ksmd` VALUES ('9', 'A', '11', '12', '6');
INSERT INTO `ksmd` VALUES ('9', 'A', '13', '14', '7');
INSERT INTO `ksmd` VALUES ('9', 'A', '15', '16', '8');
INSERT INTO `ksmd` VALUES ('9', 'A', '17', '17', '9');
INSERT INTO `ksmd` VALUES ('9', 'A', '18', '999', '10');
INSERT INTO `ksmd` VALUES ('8', 'B', '0', '3', '1');
INSERT INTO `ksmd` VALUES ('8', 'B', '4', '4', '2');
INSERT INTO `ksmd` VALUES ('8', 'B', '5', '6', '3');
INSERT INTO `ksmd` VALUES ('8', 'B', '7', '7', '4');
INSERT INTO `ksmd` VALUES ('8', 'B', '8', '8', '5');
INSERT INTO `ksmd` VALUES ('8', 'B', '9', '9', '6');
INSERT INTO `ksmd` VALUES ('8', 'B', '10', '10', '7');
INSERT INTO `ksmd` VALUES ('8', 'B', '11', '11', '8');
INSERT INTO `ksmd` VALUES ('8', 'B', '12', '12', '9');
INSERT INTO `ksmd` VALUES ('8', 'B', '13', '999', '10');
INSERT INTO `ksmd` VALUES ('9', 'B', '0', '3', '1');
INSERT INTO `ksmd` VALUES ('9', 'B', '4', '5', '2');
INSERT INTO `ksmd` VALUES ('9', 'B', '6', '6', '3');
INSERT INTO `ksmd` VALUES ('9', 'B', '7', '7', '4');
INSERT INTO `ksmd` VALUES ('9', 'B', '8', '8', '5');
INSERT INTO `ksmd` VALUES ('9', 'B', '9', '9', '6');
INSERT INTO `ksmd` VALUES ('9', 'B', '10', '10', '7');
INSERT INTO `ksmd` VALUES ('9', 'B', '11', '11', '8');
INSERT INTO `ksmd` VALUES ('9', 'B', '12', '12', '9');
INSERT INTO `ksmd` VALUES ('9', 'B', '13', '999', '10');
INSERT INTO `ksmd` VALUES ('8', 'C', '0', '6', '1');
INSERT INTO `ksmd` VALUES ('8', 'C', '7', '8', '2');
INSERT INTO `ksmd` VALUES ('8', 'C', '9', '10', '3');
INSERT INTO `ksmd` VALUES ('8', 'C', '11', '12', '4');
INSERT INTO `ksmd` VALUES ('8', 'C', '13', '15', '5');
INSERT INTO `ksmd` VALUES ('8', 'C', '16', '17', '6');
INSERT INTO `ksmd` VALUES ('8', 'C', '18', '19', '7');
INSERT INTO `ksmd` VALUES ('8', 'C', '20', '21', '8');
INSERT INTO `ksmd` VALUES ('8', 'C', '22', '23', '9');
INSERT INTO `ksmd` VALUES ('8', 'C', '24', '999', '10');
INSERT INTO `ksmd` VALUES ('9', 'C', '0', '5', '1');
INSERT INTO `ksmd` VALUES ('9', 'C', '6', '7', '2');
INSERT INTO `ksmd` VALUES ('9', 'C', '8', '9', '3');
INSERT INTO `ksmd` VALUES ('9', 'C', '10', '11', '4');
INSERT INTO `ksmd` VALUES ('9', 'C', '12', '13', '5');
INSERT INTO `ksmd` VALUES ('9', 'C', '14', '16', '6');
INSERT INTO `ksmd` VALUES ('9', 'C', '17', '18', '7');
INSERT INTO `ksmd` VALUES ('9', 'C', '19', '20', '8');
INSERT INTO `ksmd` VALUES ('9', 'C', '21', '22', '9');
INSERT INTO `ksmd` VALUES ('9', 'C', '23', '999', '10');
INSERT INTO `ksmd` VALUES ('8', 'E', '0', '5', '1');
INSERT INTO `ksmd` VALUES ('8', 'E', '6', '6', '2');
INSERT INTO `ksmd` VALUES ('8', 'E', '7', '8', '3');
INSERT INTO `ksmd` VALUES ('8', 'E', '9', '10', '4');
INSERT INTO `ksmd` VALUES ('8', 'E', '11', '12', '5');
INSERT INTO `ksmd` VALUES ('8', 'E', '13', '14', '6');
INSERT INTO `ksmd` VALUES ('8', 'E', '15', '16', '7');
INSERT INTO `ksmd` VALUES ('8', 'E', '17', '18', '8');
INSERT INTO `ksmd` VALUES ('8', 'E', '19', '20', '9');
INSERT INTO `ksmd` VALUES ('8', 'E', '21', '999', '10');
INSERT INTO `ksmd` VALUES ('9', 'E', '0', '3', '1');
INSERT INTO `ksmd` VALUES ('9', 'E', '4', '5', '2');
INSERT INTO `ksmd` VALUES ('9', 'E', '6', '7', '3');
INSERT INTO `ksmd` VALUES ('9', 'E', '8', '9', '4');
INSERT INTO `ksmd` VALUES ('9', 'E', '10', '11', '5');
INSERT INTO `ksmd` VALUES ('9', 'E', '12', '13', '6');
INSERT INTO `ksmd` VALUES ('9', 'E', '14', '15', '7');
INSERT INTO `ksmd` VALUES ('9', 'E', '16', '17', '8');
INSERT INTO `ksmd` VALUES ('9', 'E', '18', '19', '9');
INSERT INTO `ksmd` VALUES ('9', 'E', '20', '999', '10');
INSERT INTO `ksmd` VALUES ('8', 'F', '0', '3', '1');
INSERT INTO `ksmd` VALUES ('8', 'F', '4', '5', '2');
INSERT INTO `ksmd` VALUES ('8', 'F', '6', '7', '3');
INSERT INTO `ksmd` VALUES ('8', 'F', '8', '9', '4');
INSERT INTO `ksmd` VALUES ('8', 'F', '10', '12', '5');
INSERT INTO `ksmd` VALUES ('8', 'F', '13', '14', '6');
INSERT INTO `ksmd` VALUES ('8', 'F', '15', '17', '7');
INSERT INTO `ksmd` VALUES ('8', 'F', '18', '19', '8');
INSERT INTO `ksmd` VALUES ('8', 'F', '20', '21', '9');
INSERT INTO `ksmd` VALUES ('8', 'F', '22', '999', '10');
INSERT INTO `ksmd` VALUES ('9', 'F', '0', '2', '1');
INSERT INTO `ksmd` VALUES ('9', 'F', '3', '5', '2');
INSERT INTO `ksmd` VALUES ('9', 'F', '6', '7', '3');
INSERT INTO `ksmd` VALUES ('9', 'F', '8', '9', '4');
INSERT INTO `ksmd` VALUES ('9', 'F', '10', '12', '5');
INSERT INTO `ksmd` VALUES ('9', 'F', '13', '15', '6');
INSERT INTO `ksmd` VALUES ('9', 'F', '16', '17', '7');
INSERT INTO `ksmd` VALUES ('9', 'F', '18', '19', '8');
INSERT INTO `ksmd` VALUES ('9', 'F', '20', '22', '9');
INSERT INTO `ksmd` VALUES ('9', 'F', '23', '999', '10');
INSERT INTO `ksmd` VALUES ('8', 'G', '0', '5', '1');
INSERT INTO `ksmd` VALUES ('8', 'G', '6', '6', '2');
INSERT INTO `ksmd` VALUES ('8', 'G', '7', '8', '3');
INSERT INTO `ksmd` VALUES ('8', 'G', '9', '10', '4');
INSERT INTO `ksmd` VALUES ('8', 'G', '11', '12', '5');
INSERT INTO `ksmd` VALUES ('8', 'G', '13', '14', '6');
INSERT INTO `ksmd` VALUES ('8', 'G', '15', '16', '7');
INSERT INTO `ksmd` VALUES ('8', 'G', '17', '17', '8');
INSERT INTO `ksmd` VALUES ('8', 'G', '18', '19', '9');
INSERT INTO `ksmd` VALUES ('8', 'G', '20', '999', '10');
INSERT INTO `ksmd` VALUES ('9', 'G', '0', '5', '1');
INSERT INTO `ksmd` VALUES ('9', 'G', '6', '7', '2');
INSERT INTO `ksmd` VALUES ('9', 'G', '8', '8', '3');
INSERT INTO `ksmd` VALUES ('9', 'G', '9', '10', '4');
INSERT INTO `ksmd` VALUES ('9', 'G', '11', '12', '5');
INSERT INTO `ksmd` VALUES ('9', 'G', '13', '14', '6');
INSERT INTO `ksmd` VALUES ('9', 'G', '15', '16', '7');
INSERT INTO `ksmd` VALUES ('9', 'G', '17', '17', '8');
INSERT INTO `ksmd` VALUES ('9', 'G', '18', '19', '9');
INSERT INTO `ksmd` VALUES ('9', 'G', '20', '999', '10');
INSERT INTO `ksmd` VALUES ('8', 'H', '0', '1', '1');
INSERT INTO `ksmd` VALUES ('8', 'H', '2', '3', '2');
INSERT INTO `ksmd` VALUES ('8', 'H', '4', '6', '3');
INSERT INTO `ksmd` VALUES ('8', 'H', '7', '8', '4');
INSERT INTO `ksmd` VALUES ('8', 'H', '9', '10', '5');
INSERT INTO `ksmd` VALUES ('8', 'H', '11', '13', '6');
INSERT INTO `ksmd` VALUES ('8', 'H', '14', '15', '7');
INSERT INTO `ksmd` VALUES ('8', 'H', '16', '18', '8');
INSERT INTO `ksmd` VALUES ('8', 'H', '19', '20', '9');
INSERT INTO `ksmd` VALUES ('8', 'H', '21', '999', '10');
INSERT INTO `ksmd` VALUES ('9', 'H', '0', '1', '1');
INSERT INTO `ksmd` VALUES ('9', 'H', '2', '3', '2');
INSERT INTO `ksmd` VALUES ('9', 'H', '4', '5', '3');
INSERT INTO `ksmd` VALUES ('9', 'H', '6', '7', '4');
INSERT INTO `ksmd` VALUES ('9', 'H', '8', '10', '5');
INSERT INTO `ksmd` VALUES ('9', 'H', '11', '13', '6');
INSERT INTO `ksmd` VALUES ('9', 'H', '14', '15', '7');
INSERT INTO `ksmd` VALUES ('9', 'H', '16', '17', '8');
INSERT INTO `ksmd` VALUES ('9', 'H', '18', '20', '9');
INSERT INTO `ksmd` VALUES ('9', 'H', '21', '999', '10');
INSERT INTO `ksmd` VALUES ('8', 'I', '0', '3', '1');
INSERT INTO `ksmd` VALUES ('8', 'I', '4', '5', '2');
INSERT INTO `ksmd` VALUES ('8', 'I', '6', '6', '3');
INSERT INTO `ksmd` VALUES ('8', 'I', '7', '7', '4');
INSERT INTO `ksmd` VALUES ('8', 'I', '8', '9', '5');
INSERT INTO `ksmd` VALUES ('8', 'I', '10', '11', '6');
INSERT INTO `ksmd` VALUES ('8', 'I', '12', '12', '7');
INSERT INTO `ksmd` VALUES ('8', 'I', '13', '14', '8');
INSERT INTO `ksmd` VALUES ('8', 'I', '15', '15', '9');
INSERT INTO `ksmd` VALUES ('8', 'I', '16', '999', '10');
INSERT INTO `ksmd` VALUES ('9', 'I', '0', '4', '1');
INSERT INTO `ksmd` VALUES ('9', 'I', '5', '5', '2');
INSERT INTO `ksmd` VALUES ('9', 'I', '6', '7', '3');
INSERT INTO `ksmd` VALUES ('9', 'I', '8', '8', '4');
INSERT INTO `ksmd` VALUES ('9', 'I', '9', '10', '5');
INSERT INTO `ksmd` VALUES ('9', 'I', '11', '12', '6');
INSERT INTO `ksmd` VALUES ('9', 'I', '13', '13', '7');
INSERT INTO `ksmd` VALUES ('9', 'I', '14', '15', '8');
INSERT INTO `ksmd` VALUES ('9', 'I', '16', '17', '9');
INSERT INTO `ksmd` VALUES ('9', 'I', '18', '999', '10');
INSERT INTO `ksmd` VALUES ('8', 'L', '0', '4', '1');
INSERT INTO `ksmd` VALUES ('8', 'L', '5', '5', '2');
INSERT INTO `ksmd` VALUES ('8', 'L', '6', '7', '3');
INSERT INTO `ksmd` VALUES ('8', 'L', '8', '9', '4');
INSERT INTO `ksmd` VALUES ('8', 'L', '10', '11', '5');
INSERT INTO `ksmd` VALUES ('8', 'L', '12', '12', '6');
INSERT INTO `ksmd` VALUES ('8', 'L', '13', '14', '7');
INSERT INTO `ksmd` VALUES ('8', 'L', '15', '15', '8');
INSERT INTO `ksmd` VALUES ('8', 'L', '16', '17', '9');
INSERT INTO `ksmd` VALUES ('8', 'L', '18', '999', '10');
INSERT INTO `ksmd` VALUES ('9', 'L', '0', '3', '1');
INSERT INTO `ksmd` VALUES ('9', 'L', '4', '4', '2');
INSERT INTO `ksmd` VALUES ('9', 'L', '5', '6', '3');
INSERT INTO `ksmd` VALUES ('9', 'L', '7', '8', '4');
INSERT INTO `ksmd` VALUES ('9', 'L', '9', '10', '5');
INSERT INTO `ksmd` VALUES ('9', 'L', '11', '12', '6');
INSERT INTO `ksmd` VALUES ('9', 'L', '13', '13', '7');
INSERT INTO `ksmd` VALUES ('9', 'L', '14', '15', '8');
INSERT INTO `ksmd` VALUES ('9', 'L', '16', '17', '9');
INSERT INTO `ksmd` VALUES ('9', 'L', '18', '999', '10');
INSERT INTO `ksmd` VALUES ('8', 'M', '0', '3', '1');
INSERT INTO `ksmd` VALUES ('8', 'M', '4', '4', '2');
INSERT INTO `ksmd` VALUES ('8', 'M', '5', '6', '3');
INSERT INTO `ksmd` VALUES ('8', 'M', '7', '8', '4');
INSERT INTO `ksmd` VALUES ('8', 'M', '9', '10', '5');
INSERT INTO `ksmd` VALUES ('8', 'M', '11', '13', '6');
INSERT INTO `ksmd` VALUES ('8', 'M', '14', '14', '7');
INSERT INTO `ksmd` VALUES ('8', 'M', '15', '16', '8');
INSERT INTO `ksmd` VALUES ('8', 'M', '17', '18', '9');
INSERT INTO `ksmd` VALUES ('8', 'M', '19', '999', '10');
INSERT INTO `ksmd` VALUES ('9', 'M', '0', '5', '1');
INSERT INTO `ksmd` VALUES ('9', 'M', '6', '6', '2');
INSERT INTO `ksmd` VALUES ('9', 'M', '7', '8', '3');
INSERT INTO `ksmd` VALUES ('9', 'M', '9', '10', '4');
INSERT INTO `ksmd` VALUES ('9', 'M', '11', '12', '5');
INSERT INTO `ksmd` VALUES ('9', 'M', '13', '14', '6');
INSERT INTO `ksmd` VALUES ('9', 'M', '15', '16', '7');
INSERT INTO `ksmd` VALUES ('9', 'M', '17', '17', '8');
INSERT INTO `ksmd` VALUES ('9', 'M', '18', '19', '9');
INSERT INTO `ksmd` VALUES ('9', 'M', '20', '999', '10');
INSERT INTO `ksmd` VALUES ('8', 'N', '0', '3', '1');
INSERT INTO `ksmd` VALUES ('8', 'N', '4', '4', '2');
INSERT INTO `ksmd` VALUES ('8', 'N', '5', '6', '3');
INSERT INTO `ksmd` VALUES ('8', 'N', '7', '7', '4');
INSERT INTO `ksmd` VALUES ('8', 'N', '8', '9', '5');
INSERT INTO `ksmd` VALUES ('8', 'N', '10', '11', '6');
INSERT INTO `ksmd` VALUES ('8', 'N', '12', '12', '7');
INSERT INTO `ksmd` VALUES ('8', 'N', '13', '14', '8');
INSERT INTO `ksmd` VALUES ('8', 'N', '15', '15', '9');
INSERT INTO `ksmd` VALUES ('8', 'N', '16', '999', '10');
INSERT INTO `ksmd` VALUES ('9', 'N', '0', '3', '1');
INSERT INTO `ksmd` VALUES ('9', 'N', '4', '5', '2');
INSERT INTO `ksmd` VALUES ('9', 'N', '6', '6', '3');
INSERT INTO `ksmd` VALUES ('9', 'N', '7', '7', '4');
INSERT INTO `ksmd` VALUES ('9', 'N', '8', '9', '5');
INSERT INTO `ksmd` VALUES ('9', 'N', '10', '11', '6');
INSERT INTO `ksmd` VALUES ('9', 'N', '12', '13', '7');
INSERT INTO `ksmd` VALUES ('9', 'N', '14', '14', '8');
INSERT INTO `ksmd` VALUES ('9', 'N', '15', '16', '9');
INSERT INTO `ksmd` VALUES ('9', 'N', '17', '999', '10');
INSERT INTO `ksmd` VALUES ('8', 'O', '0', '1', '1');
INSERT INTO `ksmd` VALUES ('8', 'O', '2', '2', '2');
INSERT INTO `ksmd` VALUES ('8', 'O', '3', '4', '3');
INSERT INTO `ksmd` VALUES ('8', 'O', '5', '6', '4');
INSERT INTO `ksmd` VALUES ('8', 'O', '7', '8', '5');
INSERT INTO `ksmd` VALUES ('8', 'O', '9', '10', '6');
INSERT INTO `ksmd` VALUES ('8', 'O', '11', '12', '7');
INSERT INTO `ksmd` VALUES ('8', 'O', '13', '14', '8');
INSERT INTO `ksmd` VALUES ('8', 'O', '15', '16', '9');
INSERT INTO `ksmd` VALUES ('8', 'O', '17', '999', '10');
INSERT INTO `ksmd` VALUES ('9', 'O', '0', '1', '1');
INSERT INTO `ksmd` VALUES ('9', 'O', '2', '3', '2');
INSERT INTO `ksmd` VALUES ('9', 'O', '4', '5', '3');
INSERT INTO `ksmd` VALUES ('9', 'O', '6', '8', '4');
INSERT INTO `ksmd` VALUES ('9', 'O', '9', '9', '5');
INSERT INTO `ksmd` VALUES ('9', 'O', '10', '12', '6');
INSERT INTO `ksmd` VALUES ('9', 'O', '13', '14', '7');
INSERT INTO `ksmd` VALUES ('9', 'O', '15', '16', '8');
INSERT INTO `ksmd` VALUES ('9', 'O', '17', '18', '9');
INSERT INTO `ksmd` VALUES ('9', 'O', '19', '999', '10');
INSERT INTO `ksmd` VALUES ('8', 'Q1', '0', '4', '1');
INSERT INTO `ksmd` VALUES ('8', 'Q1', '5', '6', '2');
INSERT INTO `ksmd` VALUES ('8', 'Q1', '7', '7', '3');
INSERT INTO `ksmd` VALUES ('8', 'Q1', '8', '9', '4');
INSERT INTO `ksmd` VALUES ('8', 'Q1', '10', '11', '5');
INSERT INTO `ksmd` VALUES ('8', 'Q1', '12', '13', '6');
INSERT INTO `ksmd` VALUES ('8', 'Q1', '14', '14', '7');
INSERT INTO `ksmd` VALUES ('8', 'Q1', '15', '16', '8');
INSERT INTO `ksmd` VALUES ('8', 'Q1', '17', '17', '9');
INSERT INTO `ksmd` VALUES ('8', 'Q1', '18', '999', '10');
INSERT INTO `ksmd` VALUES ('9', 'Q1', '0', '4', '1');
INSERT INTO `ksmd` VALUES ('9', 'Q1', '5', '5', '2');
INSERT INTO `ksmd` VALUES ('9', 'Q1', '6', '7', '3');
INSERT INTO `ksmd` VALUES ('9', 'Q1', '8', '9', '4');
INSERT INTO `ksmd` VALUES ('9', 'Q1', '10', '11', '5');
INSERT INTO `ksmd` VALUES ('9', 'Q1', '12', '13', '6');
INSERT INTO `ksmd` VALUES ('9', 'Q1', '14', '14', '7');
INSERT INTO `ksmd` VALUES ('9', 'Q1', '15', '15', '8');
INSERT INTO `ksmd` VALUES ('9', 'Q1', '16', '17', '9');
INSERT INTO `ksmd` VALUES ('9', 'Q1', '18', '999', '10');
INSERT INTO `ksmd` VALUES ('8', 'Q2', '0', '5', '1');
INSERT INTO `ksmd` VALUES ('8', 'Q2', '6', '7', '2');
INSERT INTO `ksmd` VALUES ('8', 'Q2', '8', '9', '3');
INSERT INTO `ksmd` VALUES ('8', 'Q2', '10', '10', '4');
INSERT INTO `ksmd` VALUES ('8', 'Q2', '11', '12', '5');
INSERT INTO `ksmd` VALUES ('8', 'Q2', '13', '15', '6');
INSERT INTO `ksmd` VALUES ('8', 'Q2', '16', '16', '7');
INSERT INTO `ksmd` VALUES ('8', 'Q2', '17', '18', '8');
INSERT INTO `ksmd` VALUES ('8', 'Q2', '19', '19', '9');
INSERT INTO `ksmd` VALUES ('8', 'Q2', '20', '999', '10');
INSERT INTO `ksmd` VALUES ('9', 'Q2', '0', '3', '1');
INSERT INTO `ksmd` VALUES ('9', 'Q2', '4', '5', '2');
INSERT INTO `ksmd` VALUES ('9', 'Q2', '6', '7', '3');
INSERT INTO `ksmd` VALUES ('9', 'Q2', '8', '9', '4');
INSERT INTO `ksmd` VALUES ('9', 'Q2', '10', '11', '5');
INSERT INTO `ksmd` VALUES ('9', 'Q2', '12', '13', '6');
INSERT INTO `ksmd` VALUES ('9', 'Q2', '14', '15', '7');
INSERT INTO `ksmd` VALUES ('9', 'Q2', '16', '17', '8');
INSERT INTO `ksmd` VALUES ('9', 'Q2', '18', '18', '9');
INSERT INTO `ksmd` VALUES ('9', 'Q2', '19', '999', '10');
INSERT INTO `ksmd` VALUES ('8', 'Q3', '0', '4', '1');
INSERT INTO `ksmd` VALUES ('8', 'Q3', '5', '6', '2');
INSERT INTO `ksmd` VALUES ('8', 'Q3', '7', '8', '3');
INSERT INTO `ksmd` VALUES ('8', 'Q3', '9', '10', '4');
INSERT INTO `ksmd` VALUES ('8', 'Q3', '11', '12', '5');
INSERT INTO `ksmd` VALUES ('8', 'Q3', '13', '14', '6');
INSERT INTO `ksmd` VALUES ('8', 'Q3', '15', '16', '7');
INSERT INTO `ksmd` VALUES ('8', 'Q3', '17', '17', '8');
INSERT INTO `ksmd` VALUES ('8', 'Q3', '18', '19', '9');
INSERT INTO `ksmd` VALUES ('8', 'Q3', '20', '999', '10');
INSERT INTO `ksmd` VALUES ('9', 'Q3', '0', '3', '1');
INSERT INTO `ksmd` VALUES ('9', 'Q3', '4', '5', '2');
INSERT INTO `ksmd` VALUES ('9', 'Q3', '6', '7', '3');
INSERT INTO `ksmd` VALUES ('9', 'Q3', '8', '9', '4');
INSERT INTO `ksmd` VALUES ('9', 'Q3', '10', '12', '5');
INSERT INTO `ksmd` VALUES ('9', 'Q3', '13', '14', '6');
INSERT INTO `ksmd` VALUES ('9', 'Q3', '15', '16', '7');
INSERT INTO `ksmd` VALUES ('9', 'Q3', '17', '18', '8');
INSERT INTO `ksmd` VALUES ('9', 'Q3', '19', '19', '9');
INSERT INTO `ksmd` VALUES ('9', 'Q3', '20', '999', '10');
INSERT INTO `ksmd` VALUES ('8', 'Q4', '0', '2', '1');
INSERT INTO `ksmd` VALUES ('8', 'Q4', '3', '4', '2');
INSERT INTO `ksmd` VALUES ('8', 'Q4', '5', '6', '3');
INSERT INTO `ksmd` VALUES ('8', 'Q4', '7', '8', '4');
INSERT INTO `ksmd` VALUES ('8', 'Q4', '9', '10', '5');
INSERT INTO `ksmd` VALUES ('8', 'Q4', '11', '13', '6');
INSERT INTO `ksmd` VALUES ('8', 'Q4', '14', '15', '7');
INSERT INTO `ksmd` VALUES ('8', 'Q4', '16', '17', '8');
INSERT INTO `ksmd` VALUES ('8', 'Q4', '18', '19', '9');
INSERT INTO `ksmd` VALUES ('8', 'Q4', '20', '999', '10');
INSERT INTO `ksmd` VALUES ('9', 'Q4', '0', '2', '1');
INSERT INTO `ksmd` VALUES ('9', 'Q4', '3', '4', '2');
INSERT INTO `ksmd` VALUES ('9', 'Q4', '5', '6', '3');
INSERT INTO `ksmd` VALUES ('9', 'Q4', '7', '8', '4');
INSERT INTO `ksmd` VALUES ('9', 'Q4', '9', '11', '5');
INSERT INTO `ksmd` VALUES ('9', 'Q4', '12', '14', '6');
INSERT INTO `ksmd` VALUES ('9', 'Q4', '15', '16', '7');
INSERT INTO `ksmd` VALUES ('9', 'Q4', '17', '18', '8');
INSERT INTO `ksmd` VALUES ('9', 'Q4', '19', '20', '9');
INSERT INTO `ksmd` VALUES ('9', 'Q4', '21', '999', '10');
INSERT INTO `ksmd` VALUES ('0', 'Y3', '0', '62', '1');
INSERT INTO `ksmd` VALUES ('0', 'Y3', '63', '67', '2');
INSERT INTO `ksmd` VALUES ('0', 'Y3', '68', '72', '3');
INSERT INTO `ksmd` VALUES ('0', 'Y3', '73', '77', '4');
INSERT INTO `ksmd` VALUES ('0', 'Y3', '78', '82', '5');
INSERT INTO `ksmd` VALUES ('0', 'Y3', '83', '87', '6');
INSERT INTO `ksmd` VALUES ('0', 'Y3', '88', '92', '7');
INSERT INTO `ksmd` VALUES ('0', 'Y3', '93', '97', '8');
INSERT INTO `ksmd` VALUES ('0', 'Y3', '98', '102', '9');
INSERT INTO `ksmd` VALUES ('0', 'Y3', '103', '999', '10');

-- ----------------------------
-- Table structure for `ksmd_memory`
-- ----------------------------
DROP TABLE IF EXISTS `ksmd_memory`;
CREATE TABLE `ksmd_memory` (
  `DM` int(11) NOT NULL DEFAULT '0',
  `YZ` char(2) CHARACTER SET latin1 NOT NULL,
  `QSF` int(11) NOT NULL,
  `ZZF` int(11) NOT NULL,
  `BZF` int(11) NOT NULL,
  PRIMARY KEY (`YZ`,`DM`,`QSF`,`ZZF`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ksmd_memory
-- ----------------------------

-- ----------------------------
-- Table structure for `manager`
-- ----------------------------
DROP TABLE IF EXISTS `manager`;
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
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of manager
-- ----------------------------
INSERT INTO `manager` VALUES ('1', 'sa', '123456', 'M', null, 'gly', '2015-09-19 18:35:38');
INSERT INTO `manager` VALUES ('74', '13211105', 'wangyaohui', 'P', '1502', '王耀辉', '2015-09-19 19:53:09');
INSERT INTO `manager` VALUES ('75', 'haha', 'haha', 'P', '1503', '刘衡', null);

-- ----------------------------
-- Table structure for `module`
-- ----------------------------
DROP TABLE IF EXISTS `module`;
CREATE TABLE `module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL COMMENT '模块名',
  `belong_module` varchar(45) DEFAULT NULL,
  `chs_name` varchar(45) DEFAULT NULL,
  `children` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of module
-- ----------------------------
INSERT INTO `module` VALUES ('9', 'ldl', '胜任力', null, 'ldnl,pdyjcnl,zzglnl');
INSERT INTO `module` VALUES ('14', '胜任力', '素质测评模块', null, null);
INSERT INTO `module` VALUES ('15', '素质测评模块', '素质测评模块', null, null);
INSERT INTO `module` VALUES ('16', 'mk_ldl', '胜任力', '领导力', 'zb_ldnl,zb_pdyjcnl,zb_zzglnl,zb_fxx');
INSERT INTO `module` VALUES ('17', 'mk_zysz', '胜任力', '职业素质', 'zb_dlgznl,zb_cxnl,zb_tdjs,zb_gztd,zb_gzzf');
INSERT INTO `module` VALUES ('18', 'mk_swnl', '胜任力', '思维能力', 'zb_jlx,zb_fxnl,zb_gnnl');
INSERT INTO `module` VALUES ('19', 'mk_tdpz', '胜任力', '态度品质', 'zb_zrx,zb_cxd,zb_grjzqx,zb_rnx');
INSERT INTO `module` VALUES ('20', 'mk_zynl', '胜任力', '专业能力', 'zb_bxx,zb_ybnl,zb_jmng,zb_rjgxtjsp,zb_chd');
INSERT INTO `module` VALUES ('21', 'mk_grtz', '胜任力', '个人特质', 'zb_tzjl,zb_xg,zb_qxkzsp,zb_syhjsp,zb_sjnl,zb_zz,zb_xljksp');
INSERT INTO `module` VALUES ('22', 'mk_xljk', '素质测评模块', '心理健康', 'zb_xljksp,zb_qxkzsp,zb_syhjsp,zb_rjgxtjsp,zb_xg,zb_zz,zb_fxx');
INSERT INTO `module` VALUES ('23', 'mk_szjg', '素质测评模块', '素质结构', 'zb_zrx,zb_cxd,zb_grjzqx,zb_tdjs,zb_gztd,zb_gzzf,zb_bxx,zb_rnx');
INSERT INTO `module` VALUES ('24', 'mk_ztjg', '素质测评模块', '智体结构', 'zb_chd,zb_jmng,zb_jlx,zb_tzjl,zb_fxnl,zb_gnnl');
INSERT INTO `module` VALUES ('25', 'mk_nljg', '素质测评模块', '能力结构', 'zb_dlgznl,zb_cxnl,zb_ybnl,zb_pdyjcnl,zb_zzglnl,zb_sjnl,zb_ldnl');

-- ----------------------------
-- Table structure for `paper`
-- ----------------------------
DROP TABLE IF EXISTS `paper`;
CREATE TABLE `paper` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(2000) DEFAULT NULL COMMENT '指导语',
  `name` varchar(200) DEFAULT NULL COMMENT '试卷名',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=139 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of paper
-- ----------------------------
INSERT INTO `paper` VALUES ('133', '请你仔细阅读每一道试题，按自己的情况选择“是”与“否”。请就第一感觉回答，不要在每道题目上花费很长的时间。这里没有对你不利的题目，答案也无所谓正确与错误。每题都要回答。', 'EPQA');
INSERT INTO `paper` VALUES ('134', '如下每道题都包含一个情境，请仔细阅读每一个道题目所描述的情境，凭自己第一感觉从三个选项中选出最符合自己想法或行为的一项，不要去考虑情境的考察目的是什么，选项没有对错之分，每题都要回答。', '16PF');
INSERT INTO `paper` VALUES ('135', '下面是一些有关个人观点、看法的陈述。请你仔细阅读每一个陈述，根据你的真实想法，选择最符合自己的一项。答案没有对、错之分。不要花太多的时间去考虑每个条目，只要如实回答就可以了。', 'CPI');
INSERT INTO `paper` VALUES ('136', '本测验包括许多成对的语句，任何选择都无所谓对错，对它们所描述的特征，你可能喜欢，也可能不喜欢，其方式你可能曾感觉到，也可能没有感觉到，请你从中选出最能表现或接近你当前特征或感觉的那一个。如果两句话都没有正确描述你的情况，那你应当选择你认为能比较正确反映你的情况的那一个。总之，对于每道题的A、B两种选择你必须而且只能选择其一。', 'EPPS');
INSERT INTO `paper` VALUES ('137', '仔细阅读每一条，根据自己最近一星期内的感觉，选择与自己相近的选项。必须逐条填写不可遗漏，每一项只能选择一个，不能选择两个或更多。', 'SCL');
INSERT INTO `paper` VALUES ('138', '以下每个题目都有一定的主题，但是每张大的主题图中都缺少一部分，主题图以下有6—8张小图片，若填补在主题图的缺失部分，可以使整个图案合理与完整，请从每题下面所给出的小图片中找出适合大图案的一张。', 'SPM');

-- ----------------------------
-- Table structure for `project`
-- ----------------------------
DROP TABLE IF EXISTS `project`;
CREATE TABLE `project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `begintime` datetime DEFAULT NULL COMMENT '开始时间',
  `endtime` datetime DEFAULT NULL COMMENT '结束时间',
  `name` varchar(200) NOT NULL COMMENT '项目名',
  `description` text COMMENT '项目备注，详细描述',
  `manager_id` int(11) DEFAULT NULL COMMENT '项目经理id，为空是因为添加时需要先空出manager_id,之后再更新',
  `last_examinee_id` int(11) DEFAULT '1',
  `state` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0:表示项目创建，1:表示配置需求量表，2:表示配置题目',
  PRIMARY KEY (`id`),
  KEY `fk_project_1_idx` (`manager_id`),
  CONSTRAINT `fk_project_1` FOREIGN KEY (`manager_id`) REFERENCES `manager` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1504 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of project
-- ----------------------------
INSERT INTO `project` VALUES ('1502', '2015-09-01 00:00:00', '2015-09-30 00:00:00', '测试2', '', '74', null, '0');
INSERT INTO `project` VALUES ('1503', '2015-09-01 00:00:00', '2015-09-01 00:10:00', '测试3', '', '75', null, '0');

-- ----------------------------
-- Table structure for `project_detail`
-- ----------------------------
DROP TABLE IF EXISTS `project_detail`;
CREATE TABLE `project_detail` (
  `project_id` int(11) NOT NULL COMMENT '项目编号',
  `module_names` text COMMENT '模块序列',
  `index_names` text COMMENT '指标序列',
  `factor_names` text COMMENT '因子序列',
  `exam_json` text COMMENT 'json格式的{试卷名:题号}',
  PRIMARY KEY (`project_id`),
  CONSTRAINT `fk_project_detail_1` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of project_detail
-- ----------------------------
INSERT INTO `project_detail` VALUES ('1502', 'mk_ldl,mk_zysz,mk_swnl,mk_tdpz,mk_zynl,mk_grtz,mk_xljk,mk_szjg,mk_nljg,mk_ztjg', 'zb_ldnl,zb_pdyjcnl,zb_zzglnl,zb_fxx,zb_dlgznl,zb_cxnl,zb_ybnl,zb_jlx,zb_fxnl,zb_gnnl,zb_zrx,zb_cxd,zb_grjzqx,zb_tdjs,zb_gztd,zb_gzzf,zb_rnx,zb_bxx,zb_rjgxtjsp,zb_tzjl,zb_xg,zb_qxkzsp,zb_syhjsp,zb_zz,zb_xljksp,zb_sjnl,zb_chd,zb_jmng', '{\"16PF\":{\"142\":\"A\",\"143\":\"B\",\"144\":\"C\",\"145\":\"E\",\"146\":\"F\",\"147\":\"G\",\"148\":\"H\",\"149\":\"I\",\"150\":\"L\",\"151\":\"M\",\"152\":\"N\",\"153\":\"O\",\"154\":\"Q1\",\"155\":\"Q2\",\"156\":\"Q3\",\"157\":\"Q4\",\"158\":\"X1\",\"159\":\"X2\",\"160\":\"X3\",\"161\":\"X4\",\"162\":\"Y1\",\"163\":\"Y2\",\"164\":\"Y3\",\"165\":\"Y4\"},\"EPPS\":{\"166\":\"end\",\"167\":\"int\",\"168\":\"ord\",\"169\":\"ach\",\"170\":\"chg\",\"171\":\"aba\",\"172\":\"dom\",\"173\":\"aff\",\"174\":\"def\",\"175\":\"agg\",\"176\":\"suc\",\"177\":\"exh\",\"178\":\"aut\",\"179\":\"het\",\"180\":\"nur\",\"181\":\"con\"},\"SCL\":{\"182\":\"soma\",\"183\":\"obse\",\"184\":\"inte\",\"185\":\"depr\",\"186\":\"anxi\",\"187\":\"host\",\"188\":\"phob\",\"189\":\"parn\",\"190\":\"psyc\",\"191\":\"qtfm\"},\"EPQA\":{\"192\":\"epqae\",\"193\":\"epqan\",\"194\":\"epqap\",\"195\":\"epqal\"},\"CPI\":{\"196\":\"do\",\"197\":\"cs\",\"198\":\"sy\",\"199\":\"sp\",\"200\":\"sa\",\"201\":\"wb\",\"202\":\"re\",\"203\":\"so\",\"204\":\"sc\",\"205\":\"po\",\"206\":\"gi\",\"207\":\"cm\",\"208\":\"ac\",\"209\":\"ai\",\"210\":\"ie\",\"211\":\"py\",\"212\":\"fx\",\"213\":\"fe\"},\"SPM\":{\"214\":\"spma\",\"215\":\"spmb\",\"216\":\"spmc\",\"217\":\"spmd\",\"218\":\"spme\",\"219\":\"spm\",\"220\":\"spmabc\"}}', '{\"SPM\":[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"7\",\"8\",\"9\",\"10\",\"11\",\"12\",\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\",\"20\",\"21\",\"22\",\"23\",\"24\",\"25\",\"26\",\"27\",\"28\",\"29\",\"30\",\"31\",\"32\",\"33\",\"34\",\"35\",\"36\",\"37\",\"38\",\"39\",\"40\",\"41\",\"42\",\"43\",\"44\",\"45\",\"46\",\"47\",\"48\",\"49\",\"50\",\"51\",\"52\",\"53\",\"54\",\"55\",\"56\",\"57\",\"58\",\"59\",\"60\"],\"SCL\":[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"7\",\"8\",\"9\",\"10\",\"11\",\"12\",\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\",\"20\",\"21\",\"22\",\"23\",\"24\",\"25\",\"26\",\"27\",\"28\",\"29\",\"30\",\"31\",\"32\",\"33\",\"34\",\"35\",\"36\",\"37\",\"38\",\"39\",\"40\",\"41\",\"42\",\"43\",\"44\",\"45\",\"46\",\"47\",\"48\",\"49\",\"50\",\"51\",\"52\",\"53\",\"54\",\"55\",\"56\",\"57\",\"58\",\"59\",\"60\",\"61\",\"62\",\"63\",\"64\",\"65\",\"66\",\"67\",\"68\",\"69\",\"70\",\"71\",\"72\",\"73\",\"74\",\"75\",\"76\",\"77\",\"78\",\"79\",\"80\",\"81\",\"82\",\"83\",\"84\",\"85\",\"86\",\"87\",\"88\",\"89\",\"90\"],\"EPPS\":[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"7\",\"8\",\"9\",\"10\",\"11\",\"12\",\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\",\"20\",\"21\",\"22\",\"23\",\"24\",\"25\",\"26\",\"27\",\"28\",\"29\",\"30\",\"31\",\"32\",\"33\",\"34\",\"35\",\"36\",\"37\",\"38\",\"39\",\"40\",\"41\",\"42\",\"43\",\"44\",\"45\",\"46\",\"47\",\"48\",\"49\",\"50\",\"51\",\"52\",\"53\",\"54\",\"55\",\"56\",\"57\",\"58\",\"59\",\"60\",\"61\",\"62\",\"63\",\"64\",\"65\",\"66\",\"67\",\"68\",\"69\",\"70\",\"71\",\"72\",\"73\",\"74\",\"75\",\"76\",\"77\",\"78\",\"79\",\"80\",\"81\",\"82\",\"83\",\"84\",\"85\",\"86\",\"87\",\"88\",\"89\",\"90\",\"91\",\"92\",\"93\",\"94\",\"95\",\"96\",\"97\",\"98\",\"99\",\"100\",\"101\",\"102\",\"103\",\"104\",\"105\",\"106\",\"107\",\"108\",\"109\",\"110\",\"111\",\"112\",\"113\",\"114\",\"115\",\"116\",\"117\",\"118\",\"119\",\"120\",\"121\",\"122\",\"123\",\"124\",\"125\",\"126\",\"127\",\"128\",\"129\",\"130\",\"131\",\"132\",\"133\",\"134\",\"135\",\"136\",\"137\",\"138\",\"139\",\"140\",\"141\",\"142\",\"143\",\"144\",\"145\",\"146\",\"147\",\"148\",\"149\",\"150\",\"151\",\"152\",\"153\",\"154\",\"155\",\"156\",\"157\",\"158\",\"159\",\"160\",\"161\",\"162\",\"163\",\"164\",\"165\",\"166\",\"167\",\"168\",\"169\",\"170\",\"171\",\"172\",\"173\",\"174\",\"175\",\"176\",\"177\",\"178\",\"179\",\"180\",\"181\",\"182\",\"183\",\"184\",\"185\",\"186\",\"187\",\"188\",\"189\",\"190\",\"191\",\"192\",\"193\",\"194\",\"195\",\"196\",\"197\",\"198\",\"199\",\"200\",\"201\",\"202\",\"203\",\"204\",\"205\",\"206\",\"207\",\"208\",\"209\",\"210\",\"211\",\"212\",\"213\",\"214\",\"215\",\"216\",\"217\",\"218\",\"219\",\"220\",\"221\",\"222\",\"223\",\"224\",\"225\"],\"CPI\":[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"7\",\"8\",\"9\",\"10\",\"11\",\"12\",\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\",\"20\",\"21\",\"22\",\"23\",\"24\",\"25\",\"26\",\"27\",\"28\",\"29\",\"30\",\"31\",\"32\",\"33\",\"34\",\"35\",\"36\",\"37\",\"38\",\"39\",\"40\",\"41\",\"42\",\"43\",\"44\",\"45\",\"46\",\"47\",\"48\",\"49\",\"50\",\"51\",\"52\",\"53\",\"54\",\"55\",\"56\",\"57\",\"58\",\"59\",\"60\",\"61\",\"62\",\"63\",\"64\",\"65\",\"66\",\"67\",\"68\",\"69\",\"70\",\"71\",\"72\",\"73\",\"74\",\"75\",\"76\",\"77\",\"78\",\"79\",\"80\",\"81\",\"82\",\"83\",\"84\",\"85\",\"86\",\"87\",\"88\",\"89\",\"90\",\"91\",\"92\",\"93\",\"94\",\"95\",\"96\",\"97\",\"98\",\"99\",\"100\",\"101\",\"102\",\"103\",\"104\",\"105\",\"106\",\"107\",\"108\",\"109\",\"110\",\"111\",\"112\",\"113\",\"114\",\"115\",\"116\",\"117\",\"118\",\"119\",\"120\",\"121\",\"122\",\"123\",\"124\",\"125\",\"126\",\"127\",\"128\",\"129\",\"130\",\"131\",\"132\",\"133\",\"134\",\"135\",\"136\",\"137\",\"138\",\"139\",\"140\",\"141\",\"142\",\"143\",\"144\",\"145\",\"146\",\"147\",\"148\",\"149\",\"150\",\"151\",\"152\",\"153\",\"154\",\"155\",\"156\",\"157\",\"158\",\"159\",\"160\",\"161\",\"162\",\"163\",\"164\",\"165\",\"166\",\"167\",\"168\",\"169\",\"170\",\"171\",\"172\",\"173\",\"174\",\"175\",\"176\",\"177\",\"178\",\"179\",\"180\",\"181\",\"182\",\"183\",\"184\",\"185\",\"186\",\"187\",\"188\",\"189\",\"190\",\"191\",\"192\",\"193\",\"194\",\"195\",\"196\",\"197\",\"198\",\"199\",\"200\",\"201\",\"202\",\"203\",\"204\",\"205\",\"206\",\"207\",\"208\",\"209\",\"210\",\"211\",\"212\",\"213\",\"214\",\"215\",\"216\",\"217\",\"218\",\"219\",\"220\",\"221\",\"222\",\"223\",\"224\",\"225\",\"226\",\"227\",\"228\",\"229\",\"230\"],\"EPQA\":[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"7\",\"8\",\"9\",\"10\",\"11\",\"12\",\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\",\"20\",\"21\",\"22\",\"23\",\"24\",\"25\",\"26\",\"27\",\"28\",\"29\",\"30\",\"31\",\"32\",\"33\",\"34\",\"35\",\"36\",\"37\",\"38\",\"39\",\"40\",\"41\",\"42\",\"43\",\"44\",\"45\",\"46\",\"47\",\"48\",\"49\",\"50\",\"51\",\"52\",\"53\",\"54\",\"55\",\"56\",\"57\",\"58\",\"59\",\"60\",\"61\",\"62\",\"63\",\"64\",\"65\",\"66\",\"67\",\"68\",\"69\",\"70\",\"71\",\"72\",\"73\",\"74\",\"75\",\"76\",\"77\",\"78\",\"79\",\"80\",\"81\",\"82\",\"83\",\"84\",\"85\",\"86\",\"87\",\"88\"],\"16PF\":[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"7\",\"8\",\"9\",\"10\",\"11\",\"12\",\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\",\"20\",\"21\",\"22\",\"23\",\"24\",\"25\",\"26\",\"27\",\"28\",\"29\",\"30\",\"31\",\"32\",\"33\",\"34\",\"35\",\"36\",\"37\",\"38\",\"39\",\"40\",\"41\",\"42\",\"43\",\"44\",\"45\",\"46\",\"47\",\"48\",\"49\",\"50\",\"51\",\"52\",\"53\",\"54\",\"55\",\"56\",\"57\",\"58\",\"59\",\"60\",\"61\",\"62\",\"63\",\"64\",\"65\",\"66\",\"67\",\"68\",\"69\",\"70\",\"71\",\"72\",\"73\",\"74\",\"75\",\"76\",\"77\",\"78\",\"79\",\"80\",\"81\",\"82\",\"83\",\"84\",\"85\",\"86\",\"87\",\"88\",\"89\",\"90\",\"91\",\"92\",\"93\",\"94\",\"95\",\"96\",\"97\",\"98\",\"99\",\"100\",\"101\",\"102\",\"103\",\"104\",\"105\",\"106\",\"107\",\"108\",\"109\",\"110\",\"111\",\"112\",\"113\",\"114\",\"115\",\"116\",\"117\",\"118\",\"119\",\"120\",\"121\",\"122\",\"123\",\"124\",\"125\",\"126\",\"127\",\"128\",\"129\",\"130\",\"131\",\"132\",\"133\",\"134\",\"135\",\"136\",\"137\",\"138\",\"139\",\"140\",\"141\",\"142\",\"143\",\"144\",\"145\",\"146\",\"147\",\"148\",\"149\",\"150\",\"151\",\"152\",\"153\",\"154\",\"155\",\"156\",\"157\",\"158\",\"159\",\"160\",\"161\",\"162\",\"163\",\"164\",\"165\",\"166\",\"167\",\"168\",\"169\",\"170\",\"171\",\"172\",\"173\",\"174\",\"175\",\"176\",\"177\",\"178\",\"179\",\"180\",\"181\",\"182\",\"183\",\"184\",\"185\",\"186\",\"187\"]}');

-- ----------------------------
-- Table structure for `question`
-- ----------------------------
DROP TABLE IF EXISTS `question`;
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
) ENGINE=InnoDB AUTO_INCREMENT=3726 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of question
-- ----------------------------
INSERT INTO `question` VALUES ('821', 'A1M', 'A1A1|A1A2|A1A3|A1A4|A1A5|A1A6', null, '1', '138');
INSERT INTO `question` VALUES ('822', 'A2M', 'A2A1|A2A2|A2A3|A2A4|A2A5|A2A6', null, '2', '138');
INSERT INTO `question` VALUES ('823', 'A3M', 'A3A1|A3A2|A3A3|A3A4|A3A5|A3A6', null, '3', '138');
INSERT INTO `question` VALUES ('824', 'A4M', 'A4A1|A4A2|A4A3|A4A4|A4A5|A4A6', null, '4', '138');
INSERT INTO `question` VALUES ('825', 'A5M', 'A5A1|A5A2|A5A3|A5A4|A5A5|A5A6', null, '5', '138');
INSERT INTO `question` VALUES ('826', 'A6M', 'A6A1|A6A2|A6A3|A6A4|A6A5|A6A6', null, '6', '138');
INSERT INTO `question` VALUES ('827', 'A7M', 'A7A1|A7A2|A7A3|A7A4|A7A5|A7A6', null, '7', '138');
INSERT INTO `question` VALUES ('828', 'A8M', 'A8A1|A8A2|A8A3|A8A4|A8A5|A8A6', null, '8', '138');
INSERT INTO `question` VALUES ('829', 'A9M', 'A9A1|A9A2|A9A3|A9A4|A9A5|A9A6', null, '9', '138');
INSERT INTO `question` VALUES ('830', 'A10M', 'A10A1|A10A2|A10A3|A10A4|A10A5|A10A6', null, '10', '138');
INSERT INTO `question` VALUES ('831', 'A11M', 'A11A1|A11A2|A11A3|A11A4|A11A5|A11A6', null, '11', '138');
INSERT INTO `question` VALUES ('832', 'A12M', 'A12A1|A12A2|A12A3|A12A4|A12A5|A12A6', null, '12', '138');
INSERT INTO `question` VALUES ('833', 'B1M', 'B1A1|B1A2|B1A3|B1A4|B1A5|B1A6', null, '13', '138');
INSERT INTO `question` VALUES ('834', 'B2M', 'B2A1|B2A2|B2A3|B2A4|B2A5|B2A6', null, '14', '138');
INSERT INTO `question` VALUES ('835', 'B3M', 'B3A1|B3A2|B3A3|B3A4|B3A5|B3A6', null, '15', '138');
INSERT INTO `question` VALUES ('836', 'B4M', 'B4A1|B4A2|B4A3|B4A4|B4A5|B4A6', null, '16', '138');
INSERT INTO `question` VALUES ('837', 'B5M', 'B5A1|B5A2|B5A3|B5A4|B5A5|B5A6', null, '17', '138');
INSERT INTO `question` VALUES ('838', 'B6M', 'B6A1|B6A2|B6A3|B6A4|B6A5|B6A6', null, '18', '138');
INSERT INTO `question` VALUES ('839', 'B7M', 'B7A1|B7A2|B7A3|B7A4|B7A5|B7A6', null, '19', '138');
INSERT INTO `question` VALUES ('840', 'B8M', 'B8A1|B8A2|B8A3|B8A4|B8A5|B8A6', null, '20', '138');
INSERT INTO `question` VALUES ('841', 'B9M', 'B9A1|B9A2|B9A3|B9A4|B9A5|B9A6', null, '21', '138');
INSERT INTO `question` VALUES ('842', 'B10M', 'B10A1|B10A2|B10A3|B10A4|B10A5|B10A6', null, '22', '138');
INSERT INTO `question` VALUES ('843', 'B11M', 'B11A1|B11A2|B11A3|B11A4|B11A5|B11A6', null, '23', '138');
INSERT INTO `question` VALUES ('844', 'B12M', 'B12A1|B12A2|B12A3|B12A4|B12A5|B12A6', null, '24', '138');
INSERT INTO `question` VALUES ('845', 'C1M', 'C1A1|C1A2|C1A3|C1A4|C1A5|C1A6|C1A7|C1A8', null, '25', '138');
INSERT INTO `question` VALUES ('846', 'C2M', 'C2A1|C2A2|C2A3|C2A4|C2A5|C2A6|C2A7|C2A8', null, '26', '138');
INSERT INTO `question` VALUES ('847', 'C3M', 'C3A1|C3A2|C3A3|C3A4|C3A5|C3A6|C3A7|C3A8', null, '27', '138');
INSERT INTO `question` VALUES ('848', 'C4M', 'C4A1|C4A2|C4A3|C4A4|C4A5|C4A6|C4A7|C4A8', null, '28', '138');
INSERT INTO `question` VALUES ('849', 'C5M', 'C5A1|C5A2|C5A3|C5A4|C5A5|C5A6|C5A7|C5A8', null, '29', '138');
INSERT INTO `question` VALUES ('850', 'C6M', 'C6A1|C6A2|C6A3|C6A4|C6A5|C6A6|C6A7|C6A8', null, '30', '138');
INSERT INTO `question` VALUES ('851', 'C7M', 'C7A1|C7A2|C7A3|C7A4|C7A5|C7A6|C7A7|C7A8', null, '31', '138');
INSERT INTO `question` VALUES ('852', 'C8M', 'C8A1|C8A2|C8A3|C8A4|C8A5|C8A6|C8A7|C8A8', null, '32', '138');
INSERT INTO `question` VALUES ('853', 'C9M', 'C9A1|C9A2|C9A3|C9A4|C9A5|C9A6|C9A7|C9A8', null, '33', '138');
INSERT INTO `question` VALUES ('854', 'C10M', 'C10A1|C10A2|C10A3|C10A4|C10A5|C10A6|C10A7|C10A8', null, '34', '138');
INSERT INTO `question` VALUES ('855', 'C11M', 'C11A1|C11A2|C11A3|C11A4|C11A5|C11A6|C11A7|C11A8', null, '35', '138');
INSERT INTO `question` VALUES ('856', 'C12M', 'C12A1|C12A2|C12A3|C12A4|C12A5|C12A6|C12A7|C12A8', null, '36', '138');
INSERT INTO `question` VALUES ('857', 'D1M', 'D1A1|D1A2|D1A3|D1A4|D1A5|D1A6|D1A7|D1A8', null, '37', '138');
INSERT INTO `question` VALUES ('858', 'D2M', 'D2A1|D2A2|D2A3|D2A4|D2A5|D2A6|D2A7|D2A8', null, '38', '138');
INSERT INTO `question` VALUES ('859', 'D3M', 'D3A1|D3A2|D3A3|D3A4|D3A5|D3A6|D3A7|D3A8', null, '39', '138');
INSERT INTO `question` VALUES ('860', 'D4M', 'D4A1|D4A2|D4A3|D4A4|D4A5|D4A6|D4A7|D4A8', null, '40', '138');
INSERT INTO `question` VALUES ('861', 'D5M', 'D5A1|D5A2|D5A3|D5A4|D5A5|D5A6|D5A7|D5A8', null, '41', '138');
INSERT INTO `question` VALUES ('862', 'D6M', 'D6A1|D6A2|D6A3|D6A4|D6A5|D6A6|D6A7|D6A8', null, '42', '138');
INSERT INTO `question` VALUES ('863', 'D7M', 'D7A1|D7A2|D7A3|D7A4|D7A5|D7A6|D7A7|D7A8', null, '43', '138');
INSERT INTO `question` VALUES ('864', 'D8M', 'D8A1|D8A2|D8A3|D8A4|D8A5|D8A6|D8A7|D8A8', null, '44', '138');
INSERT INTO `question` VALUES ('865', 'D9M', 'D9A1|D9A2|D9A3|D9A4|D9A5|D9A6|D9A7|D9A8', null, '45', '138');
INSERT INTO `question` VALUES ('866', 'D10M', 'D10A1|D10A2|D10A3|D10A4|D10A5|D10A6|D10A7|D10A8', null, '46', '138');
INSERT INTO `question` VALUES ('867', 'D11M', 'D11A1|D11A2|D11A3|D11A4|D11A5|D11A6|D11A7|D11A8', null, '47', '138');
INSERT INTO `question` VALUES ('868', 'D12M', 'D12A1|D12A2|D12A3|D12A4|D12A5|D12A6|D12A7|D12A8', null, '48', '138');
INSERT INTO `question` VALUES ('869', 'E1M', 'E1A1|E1A2|E1A3|E1A4|E1A5|E1A6|E1A7|E1A8', null, '49', '138');
INSERT INTO `question` VALUES ('870', 'E2M', 'E2A1|E2A2|E2A3|E2A4|E2A5|E2A6|E2A7|E2A8', null, '50', '138');
INSERT INTO `question` VALUES ('871', 'E3M', 'E3A1|E3A2|E3A3|E3A4|E3A5|E3A6|E3A7|E3A8', null, '51', '138');
INSERT INTO `question` VALUES ('872', 'E4M', 'E4A1|E4A2|E4A3|E4A4|E4A5|E4A6|E4A7|E4A8', null, '52', '138');
INSERT INTO `question` VALUES ('873', 'E5M', 'E5A1|E5A2|E5A3|E5A4|E5A5|E5A6|E5A7|E5A8', null, '53', '138');
INSERT INTO `question` VALUES ('874', 'E6M', 'E6A1|E6A2|E6A3|E6A4|E6A5|E6A6|E6A7|E6A8', null, '54', '138');
INSERT INTO `question` VALUES ('875', 'E7M', 'E7A1|E7A2|E7A3|E7A4|E7A5|E7A6|E7A7|E7A8', null, '55', '138');
INSERT INTO `question` VALUES ('876', 'E8M', 'E8A1|E8A2|E8A3|E8A4|E8A5|E8A6|E8A7|E8A8', null, '56', '138');
INSERT INTO `question` VALUES ('877', 'E9M', 'E9A1|E9A2|E9A3|E9A4|E9A5|E9A6|E9A7|E9A8', null, '57', '138');
INSERT INTO `question` VALUES ('878', 'E10M', 'E10A1|E10A2|E10A3|E10A4|E10A5|E10A6|E10A7|E10A8', null, '58', '138');
INSERT INTO `question` VALUES ('879', 'E11M', 'E11A1|E11A2|E11A3|E11A4|E11A5|E11A6|E11A7|E11A8', null, '59', '138');
INSERT INTO `question` VALUES ('880', 'E12M', 'E12A1|E12A2|E12A3|E12A4|E12A5|E12A6|E12A7|E12A8', null, '60', '138');
INSERT INTO `question` VALUES ('1629', '头痛。', '没有|很轻|中等|偏重|严重', null, '1', '137');
INSERT INTO `question` VALUES ('1630', '神经过敏,心中不踏实。', '没有|很轻|中等|偏重|严重', null, '2', '137');
INSERT INTO `question` VALUES ('1631', '头脑中有不必要的想法或字句盘旋。', '没有|很轻|中等|偏重|严重', null, '3', '137');
INSERT INTO `question` VALUES ('1632', '头昏或昏倒。', '没有|很轻|中等|偏重|严重', null, '4', '137');
INSERT INTO `question` VALUES ('1633', '对异性的兴趣减退。', '没有|很轻|中等|偏重|严重', null, '5', '137');
INSERT INTO `question` VALUES ('1634', '对旁人责备求全。', '没有|很轻|中等|偏重|严重', null, '6', '137');
INSERT INTO `question` VALUES ('1635', '感到别人能控制您的思想。', '没有|很轻|中等|偏重|严重', null, '7', '137');
INSERT INTO `question` VALUES ('1636', '责怪别人制造麻烦。', '没有|很轻|中等|偏重|严重', null, '8', '137');
INSERT INTO `question` VALUES ('1637', '忘记性大。', '没有|很轻|中等|偏重|严重', null, '9', '137');
INSERT INTO `question` VALUES ('1638', '担心自己的衣饰整齐及仪态的端正。', '没有|很轻|中等|偏重|严重', null, '10', '137');
INSERT INTO `question` VALUES ('1639', '容易烦恼和激动。', '没有|很轻|中等|偏重|严重', null, '11', '137');
INSERT INTO `question` VALUES ('1640', '胸痛。', '没有|很轻|中等|偏重|严重', null, '12', '137');
INSERT INTO `question` VALUES ('1641', '害怕空旷的场所或街道。', '没有|很轻|中等|偏重|严重', null, '13', '137');
INSERT INTO `question` VALUES ('1642', '感到自己的精力下降,活动减慢。', '没有|很轻|中等|偏重|严重', null, '14', '137');
INSERT INTO `question` VALUES ('1643', '想结束自己的生命。', '没有|很轻|中等|偏重|严重', null, '15', '137');
INSERT INTO `question` VALUES ('1644', '听到旁人听不到的声音。', '没有|很轻|中等|偏重|严重', null, '16', '137');
INSERT INTO `question` VALUES ('1645', '发抖。', '没有|很轻|中等|偏重|严重', null, '17', '137');
INSERT INTO `question` VALUES ('1646', '感到大多数人都不可信任。', '没有|很轻|中等|偏重|严重', null, '18', '137');
INSERT INTO `question` VALUES ('1647', '胃口不好。', '没有|很轻|中等|偏重|严重', null, '19', '137');
INSERT INTO `question` VALUES ('1648', '容易哭泣。', '没有|很轻|中等|偏重|严重', null, '20', '137');
INSERT INTO `question` VALUES ('1649', '同异性相处时感到害羞不自在。', '没有|很轻|中等|偏重|严重', null, '21', '137');
INSERT INTO `question` VALUES ('1650', '感到受骗,中了圈套或有人想抓住您。', '没有|很轻|中等|偏重|严重', null, '22', '137');
INSERT INTO `question` VALUES ('1651', '无缘无故地突然感到害怕。', '没有|很轻|中等|偏重|严重', null, '23', '137');
INSERT INTO `question` VALUES ('1652', '自己不能控制地大发脾气。', '没有|很轻|中等|偏重|严重', null, '24', '137');
INSERT INTO `question` VALUES ('1653', '怕单独出门。', '没有|很轻|中等|偏重|严重', null, '25', '137');
INSERT INTO `question` VALUES ('1654', '经常责怪自己。', '没有|很轻|中等|偏重|严重', null, '26', '137');
INSERT INTO `question` VALUES ('1655', '腰痛。', '没有|很轻|中等|偏重|严重', null, '27', '137');
INSERT INTO `question` VALUES ('1656', '感到难以完成任务。', '没有|很轻|中等|偏重|严重', null, '28', '137');
INSERT INTO `question` VALUES ('1657', '感到孤独。', '没有|很轻|中等|偏重|严重', null, '29', '137');
INSERT INTO `question` VALUES ('1658', '感到苦闷。', '没有|很轻|中等|偏重|严重', null, '30', '137');
INSERT INTO `question` VALUES ('1659', '过分担忧。', '没有|很轻|中等|偏重|严重', null, '31', '137');
INSERT INTO `question` VALUES ('1660', '对事物不感兴趣。', '没有|很轻|中等|偏重|严重', null, '32', '137');
INSERT INTO `question` VALUES ('1661', '感到害怕。', '没有|很轻|中等|偏重|严重', null, '33', '137');
INSERT INTO `question` VALUES ('1662', '您的感情容易受到伤害。', '没有|很轻|中等|偏重|严重', null, '34', '137');
INSERT INTO `question` VALUES ('1663', '旁人能知道您的私下想法。', '没有|很轻|中等|偏重|严重', null, '35', '137');
INSERT INTO `question` VALUES ('1664', '感到别人不理解您、不同情您。', '没有|很轻|中等|偏重|严重', null, '36', '137');
INSERT INTO `question` VALUES ('1665', '感到人们对您不友好,不喜欢您。', '没有|很轻|中等|偏重|严重', null, '37', '137');
INSERT INTO `question` VALUES ('1666', '做事必须做得很慢以保证做得正确。', '没有|很轻|中等|偏重|严重', null, '38', '137');
INSERT INTO `question` VALUES ('1667', '心跳得很厉害。', '没有|很轻|中等|偏重|严重', null, '39', '137');
INSERT INTO `question` VALUES ('1668', '恶心或胃部不舒服。', '没有|很轻|中等|偏重|严重', null, '40', '137');
INSERT INTO `question` VALUES ('1669', '感到比不上他人。', '没有|很轻|中等|偏重|严重', null, '41', '137');
INSERT INTO `question` VALUES ('1670', '肌肉酸痛。', '没有|很轻|中等|偏重|严重', null, '42', '137');
INSERT INTO `question` VALUES ('1671', '感到有人在监视您、谈论您。', '没有|很轻|中等|偏重|严重', null, '43', '137');
INSERT INTO `question` VALUES ('1672', '难以入睡。', '没有|很轻|中等|偏重|严重', null, '44', '137');
INSERT INTO `question` VALUES ('1673', '做事必须反复检查。', '没有|很轻|中等|偏重|严重', null, '45', '137');
INSERT INTO `question` VALUES ('1674', '难以做出决定。', '没有|很轻|中等|偏重|严重', null, '46', '137');
INSERT INTO `question` VALUES ('1675', '怕乘电车、公共汽车、地铁或火车。', '没有|很轻|中等|偏重|严重', null, '47', '137');
INSERT INTO `question` VALUES ('1676', '呼吸有困难。', '没有|很轻|中等|偏重|严重', null, '48', '137');
INSERT INTO `question` VALUES ('1677', '一阵阵发冷或发热。', '没有|很轻|中等|偏重|严重', null, '49', '137');
INSERT INTO `question` VALUES ('1678', '因为感到害怕而避开某些东西、场合或活动。', '没有|很轻|中等|偏重|严重', null, '50', '137');
INSERT INTO `question` VALUES ('1679', '脑子变空了。', '没有|很轻|中等|偏重|严重', null, '51', '137');
INSERT INTO `question` VALUES ('1680', '身体发麻或刺痛。', '没有|很轻|中等|偏重|严重', null, '52', '137');
INSERT INTO `question` VALUES ('1681', '喉咙有梗塞感。', '没有|很轻|中等|偏重|严重', null, '53', '137');
INSERT INTO `question` VALUES ('1682', '感到前途没有希望。', '没有|很轻|中等|偏重|严重', null, '54', '137');
INSERT INTO `question` VALUES ('1683', '不能集中注意。', '没有|很轻|中等|偏重|严重', null, '55', '137');
INSERT INTO `question` VALUES ('1684', '感到身体的某一部分软弱无力。', '没有|很轻|中等|偏重|严重', null, '56', '137');
INSERT INTO `question` VALUES ('1685', '感到紧张或容易紧张。', '没有|很轻|中等|偏重|严重', null, '57', '137');
INSERT INTO `question` VALUES ('1686', '感到手或脚发重。', '没有|很轻|中等|偏重|严重', null, '58', '137');
INSERT INTO `question` VALUES ('1687', '想到死亡的事。', '没有|很轻|中等|偏重|严重', null, '59', '137');
INSERT INTO `question` VALUES ('1688', '吃得太多。', '没有|很轻|中等|偏重|严重', null, '60', '137');
INSERT INTO `question` VALUES ('1689', '当别人看着您或谈论您时感到不自在。', '没有|很轻|中等|偏重|严重', null, '61', '137');
INSERT INTO `question` VALUES ('1690', '有一些不属于您自己的想法。', '没有|很轻|中等|偏重|严重', null, '62', '137');
INSERT INTO `question` VALUES ('1691', '有想打人或伤害他人的冲动。', '没有|很轻|中等|偏重|严重', null, '63', '137');
INSERT INTO `question` VALUES ('1692', '醒得太早。', '没有|很轻|中等|偏重|严重', null, '64', '137');
INSERT INTO `question` VALUES ('1693', '必须反复洗手、点数目或触摸某些东西。', '没有|很轻|中等|偏重|严重', null, '65', '137');
INSERT INTO `question` VALUES ('1694', '睡得不稳不深。', '没有|很轻|中等|偏重|严重', null, '66', '137');
INSERT INTO `question` VALUES ('1695', '有想摔坏或破坏东西的冲动。', '没有|很轻|中等|偏重|严重', null, '67', '137');
INSERT INTO `question` VALUES ('1696', '有一些别人没有的想法或念头。', '没有|很轻|中等|偏重|严重', null, '68', '137');
INSERT INTO `question` VALUES ('1697', '感到对别人神经过敏。', '没有|很轻|中等|偏重|严重', null, '69', '137');
INSERT INTO `question` VALUES ('1698', '在商店或电影院等人多的地方感到不自在。', '没有|很轻|中等|偏重|严重', null, '70', '137');
INSERT INTO `question` VALUES ('1699', '感到任何事情都很困难。', '没有|很轻|中等|偏重|严重', null, '71', '137');
INSERT INTO `question` VALUES ('1700', '一阵阵恐惧或惊恐。', '没有|很轻|中等|偏重|严重', null, '72', '137');
INSERT INTO `question` VALUES ('1701', '感到在公共场合吃东西很不舒服。', '没有|很轻|中等|偏重|严重', null, '73', '137');
INSERT INTO `question` VALUES ('1702', '经常与人争论。', '没有|很轻|中等|偏重|严重', null, '74', '137');
INSERT INTO `question` VALUES ('1703', '单独一个人时神经很紧张。', '没有|很轻|中等|偏重|严重', null, '75', '137');
INSERT INTO `question` VALUES ('1704', '别人对您的成绩没有做出恰当的评价。', '没有|很轻|中等|偏重|严重', null, '76', '137');
INSERT INTO `question` VALUES ('1705', '即使和别人在一起也感到孤单。', '没有|很轻|中等|偏重|严重', null, '77', '137');
INSERT INTO `question` VALUES ('1706', '感到坐立不安心神不定。', '没有|很轻|中等|偏重|严重', null, '78', '137');
INSERT INTO `question` VALUES ('1707', '感到自己没有什么价值。', '没有|很轻|中等|偏重|严重', null, '79', '137');
INSERT INTO `question` VALUES ('1708', '感到熟悉的东西变成陌生或不像是真的。', '没有|很轻|中等|偏重|严重', null, '80', '137');
INSERT INTO `question` VALUES ('1709', '大叫或摔东西。', '没有|很轻|中等|偏重|严重', null, '81', '137');
INSERT INTO `question` VALUES ('1710', '害怕会在公共场合昏倒。', '没有|很轻|中等|偏重|严重', null, '82', '137');
INSERT INTO `question` VALUES ('1711', '感到别人想占您的便宜。', '没有|很轻|中等|偏重|严重', null, '83', '137');
INSERT INTO `question` VALUES ('1712', '为一些有关性的想法而很苦恼。', '没有|很轻|中等|偏重|严重', null, '84', '137');
INSERT INTO `question` VALUES ('1713', '您认为应该因为自己的过错而受到惩罚。', '没有|很轻|中等|偏重|严重', null, '85', '137');
INSERT INTO `question` VALUES ('1714', '感到要很快把事情做完。', '没有|很轻|中等|偏重|严重', null, '86', '137');
INSERT INTO `question` VALUES ('1715', '感到自己的身体有严重问题。', '没有|很轻|中等|偏重|严重', null, '87', '137');
INSERT INTO `question` VALUES ('1716', '从未感到和其他人很亲近。', '没有|很轻|中等|偏重|严重', null, '88', '137');
INSERT INTO `question` VALUES ('1717', '感到自己有罪。', '没有|很轻|中等|偏重|严重', null, '89', '137');
INSERT INTO `question` VALUES ('1718', '感到自己的脑子有毛病。', '没有|很轻|中等|偏重|严重', null, '90', '137');
INSERT INTO `question` VALUES ('1725', null, '当我的朋友有麻烦时,我喜欢帮助他们。|对我所承担的一切事情,我都喜欢尽我最大的努力去做。', null, '1', '136');
INSERT INTO `question` VALUES ('1726', null, '我喜欢探求伟人对我所感兴趣的各种问题有什么看法。|我喜欢完成具有重大意义的事情。', null, '2', '136');
INSERT INTO `question` VALUES ('1727', null, '我喜欢我写的所有的东西都很精确、清楚、有条有理。|我喜欢在某些职工、专业或专门项目上自己是公认的权威。', null, '3', '136');
INSERT INTO `question` VALUES ('1728', null, '我喜欢在宴会上讲些趣事与笑话。|我喜欢写本伟大的小说或剧本。', null, '4', '136');
INSERT INTO `question` VALUES ('1729', null, '我喜欢能随我的意志来去自如。|我喜欢能够自豪地说我将一件难题成功处理了。', null, '5', '136');
INSERT INTO `question` VALUES ('1730', null, '我喜欢解答其他人觉得困难的谜语与问题。|我喜欢遵从指示去做人家期待我做的事。', null, '6', '136');
INSERT INTO `question` VALUES ('1731', null, '我喜欢在日常生活中经验到新奇与改变。|当我认为我的上级做得对时,我喜欢对他们表示我的看法。', null, '7', '136');
INSERT INTO `question` VALUES ('1732', null, '对我所承担的任何工作,我喜欢对其细节做计划与组织。|我喜欢遵从指示做我所该做的事。', null, '8', '136');
INSERT INTO `question` VALUES ('1733', null, '在公共场合中,我喜欢人们注意和评价我的外表。|我喜欢读伟人的故事。', null, '9', '136');
INSERT INTO `question` VALUES ('1734', null, '我喜欢回避要我按照例行方法办事的场合。|我喜欢读伟人的故事。', null, '10', '136');
INSERT INTO `question` VALUES ('1735', null, '我喜欢在某些职业、专业或专门项目上自己是个公认的权威。|我喜欢在工作开始之前做好组织和计划。', null, '11', '136');
INSERT INTO `question` VALUES ('1736', null, '我喜欢探求伟人们对各种我所感兴趣的问题的看法。|假如我必须旅行时,我喜欢把事情先安排好。', null, '12', '136');
INSERT INTO `question` VALUES ('1737', null, '我喜欢将我开了头的工作或任务完成。|我喜欢保持我的书桌或工作间的清洁与整齐。', null, '13', '136');
INSERT INTO `question` VALUES ('1738', null, '我喜欢告诉别人我所经历的冒险与奇特的事情。|我喜欢饮食有规律,并且有固（在）定时间吃东西。', null, '14', '136');
INSERT INTO `question` VALUES ('1739', null, '我喜欢独立决定我所要做的事。|我喜欢保持书桌或工作间的清洁与整齐。', null, '15', '136');
INSERT INTO `question` VALUES ('1740', null, '我喜欢比其他人做得更好。|我喜欢在宴会上讲些趣闻与笑话。', null, '16', '136');
INSERT INTO `question` VALUES ('1741', null, '我喜欢遵从习俗,并避免做我所尊敬的人认为不合常规的事。|我喜欢谈我的成就。', null, '17', '136');
INSERT INTO `question` VALUES ('1742', null, '我喜欢我的生活安排得好,过得顺利,而不用对我的计划作太多的改变。|我喜欢告诉别人我所经历的冒险与奇特的事情。', null, '18', '136');
INSERT INTO `question` VALUES ('1743', null, '我喜欢阅读以性为主体的书与剧本。|我喜欢在团体中成为众目所瞩的对象。', null, '19', '136');
INSERT INTO `question` VALUES ('1744', null, '我喜欢批评权威人士。|我喜欢用些别人不懂其意的字眼。', null, '20', '136');
INSERT INTO `question` VALUES ('1745', null, '我喜欢完成其他人认为需要技巧和努力的工作。|我喜欢能随我的意志来去自如。', null, '21', '136');
INSERT INTO `question` VALUES ('1746', null, '我喜欢称赞我所崇拜的人。|我喜欢很自如地做我所想做的事。', null, '22', '136');
INSERT INTO `question` VALUES ('1747', null, '我喜欢将我的信、账单和其他文件整齐地排列着并以某种系统存档。|我希望独立决定我所要做的事。', null, '23', '136');
INSERT INTO `question` VALUES ('1748', null, '我喜欢提出明知没有人能回答得出来的问题。|我喜欢批评权威人士。', null, '24', '136');
INSERT INTO `question` VALUES ('1749', null, '当我动怒时,我想摔东西。|我喜欢回避责任与义务。', null, '25', '136');
INSERT INTO `question` VALUES ('1750', null, '我喜欢将所有承担的事办成功。|我喜欢结交新朋友。', null, '26', '136');
INSERT INTO `question` VALUES ('1751', null, '我喜欢遵照指示去做我所该做的事。|我喜欢与朋友有深厚的交情。', null, '27', '136');
INSERT INTO `question` VALUES ('1752', null, '我喜欢我写的所有的东西都很精确、清楚、有条有理。|我喜欢广交朋友。', null, '28', '136');
INSERT INTO `question` VALUES ('1753', null, '我喜欢在宴会中说趣闻与笑话。|我喜欢写信给我的朋友。', null, '29', '136');
INSERT INTO `question` VALUES ('1754', null, '我喜欢能随我的意志来去自如。|我喜欢与朋友共享一切。', null, '30', '136');
INSERT INTO `question` VALUES ('1755', null, '我喜欢解答别人认为困难的谜语与问题。|我喜欢就一个人为什么做去判断他,而不是从他实际上做什么去判断他。', null, '31', '136');
INSERT INTO `question` VALUES ('1756', null, '我喜欢接受我所崇拜的人领导。|我喜欢了解我的朋友们对他们所面对的各种问题怎样感觉。', null, '32', '136');
INSERT INTO `question` VALUES ('1757', null, '我喜欢饮食有规律,并且在固定时间吃东西。|我喜欢研究与分析别人的行动。', null, '33', '136');
INSERT INTO `question` VALUES ('1758', null, '我喜欢说些别人认为机智与聪明的事。|我喜欢将自己放在别人的立场上,看自己若处于相同的情境会有什么感觉。', null, '34', '136');
INSERT INTO `question` VALUES ('1759', null, '我喜欢照我的意思做我想做的事。|我喜欢观察其他人在某个场合的感觉。', null, '35', '136');
INSERT INTO `question` VALUES ('1760', null, '我喜欢完成别人认为需要技巧和努力的工作。|我喜欢在我失败的时候朋友们能鼓励我。', null, '36', '136');
INSERT INTO `question` VALUES ('1761', null, '做计划时,我喜欢从其见解为我所敬重的人那里获得些建议。|我喜欢我的朋友对我仁慈。', null, '37', '136');
INSERT INTO `question` VALUES ('1762', null, '我喜欢我的朋友的生活安排得好,过得顺利,而不用对我的计划做太多得改变。|当我生病时,我喜欢我的朋友感到不安。', null, '38', '136');
INSERT INTO `question` VALUES ('1763', null, '我喜欢在团体中成为众目所瞩的对象。|当我受伤或生病时,我喜欢我的朋友小题大做。', null, '39', '136');
INSERT INTO `question` VALUES ('1764', null, '我喜欢回避要我按照例行方法办事的场合。|当我沮丧时,我喜欢我的朋友们同情并使我愉快。', null, '40', '136');
INSERT INTO `question` VALUES ('1765', null, '我想写一本伟大的小说或剧本。|当作为群众团体的一个成员时,我喜欢被指定或被选为领导者。', null, '41', '136');
INSERT INTO `question` VALUES ('1766', null, '在团体中,我喜欢接受别人的领导来决定团体该做什么。|只要可能,我就喜欢监督与指导别人的行动。', null, '42', '136');
INSERT INTO `question` VALUES ('1767', null, '我喜欢将我的信、账单或其他文件整齐地排列着,并依某种系统存档。|我喜欢成为我所属的机构与团体的领导者之一。', null, '43', '136');
INSERT INTO `question` VALUES ('1768', null, '我喜欢问些明知没人回答得出来的问题。|我喜欢告诉别人怎么做他们的工作。', null, '44', '136');
INSERT INTO `question` VALUES ('1769', null, '我喜欢回避责任与义务。|我喜欢被人们叫去做和事佬。', null, '45', '136');
INSERT INTO `question` VALUES ('1770', null, '我喜欢在某种职业、专业或专门的项目上成为公认的权威。|每当我做错了事,我感到有罪恶感。', null, '46', '136');
INSERT INTO `question` VALUES ('1771', null, '我喜欢读伟人的故事。|我觉得我必须承认我所做的一些错事。', null, '47', '136');
INSERT INTO `question` VALUES ('1772', null, '对我所承担的任何工作,我喜欢对其细节作好计划与组织。|当事情不顺时,我感到我比任何人更该受到责备。', null, '48', '136');
INSERT INTO `question` VALUES ('1773', null, '我喜欢用些别人常常不明白其意义的字眼。|我觉得样样不如别人。', null, '49', '136');
INSERT INTO `question` VALUES ('1774', null, '我喜欢批评权威人士。|在认为是我的上司的人面前,我感到胆怯。', null, '50', '136');
INSERT INTO `question` VALUES ('1775', null, '对我所承担的一切事情,我喜欢尽力而为。|我喜欢帮助比我不幸的人。', null, '51', '136');
INSERT INTO `question` VALUES ('1776', null, '我喜欢探求伟人们对我所感兴趣的各种问题有什么看法。|我喜欢对我的朋友们慷慨。', null, '52', '136');
INSERT INTO `question` VALUES ('1777', null, '在处理难题时,我喜欢在开始之前做计划。|我喜欢为我的朋友做点小事。', null, '53', '136');
INSERT INTO `question` VALUES ('1778', null, '我喜欢对别人谈我所经历的冒险与奇特的事。|我喜欢我的朋友信任我,并对我倾诉他们的麻烦。', null, '54', '136');
INSERT INTO `question` VALUES ('1779', null, '我喜欢发表我对事情的看法。|我喜欢原谅有时可能伤害了我的朋友。', null, '55', '136');
INSERT INTO `question` VALUES ('1780', null, '我喜欢自己能比别人做得更好。|我喜欢在新奇的餐厅里饮食。', null, '56', '136');
INSERT INTO `question` VALUES ('1781', null, '我喜欢遵从习俗避免做我所尊敬的人认为不合常规的事情。|我喜欢追求。', null, '57', '136');
INSERT INTO `question` VALUES ('1782', null, '在开始工作之前,我喜欢对它做好组织和计划。|我喜欢旅行和到处观光。', null, '58', '136');
INSERT INTO `question` VALUES ('1783', null, '在公共场合,我喜欢人们注意和评价我的外表。|我喜欢搬家,住到不同的地方。', null, '59', '136');
INSERT INTO `question` VALUES ('1784', null, '我喜欢独立决定我所要做的事。|我喜欢做些新鲜且有变化的事。', null, '60', '136');
INSERT INTO `question` VALUES ('1785', null, '我喜欢我能自豪地说我解决了一个难题。|对我所承担的事,我喜欢认真去做。', null, '61', '136');
INSERT INTO `question` VALUES ('1786', null, '当我认为我的上司做得对时,我喜欢对他们表示我的看法。|我喜欢在接受其他事之前完成手头的事。', null, '62', '136');
INSERT INTO `question` VALUES ('1787', null, '假如我必须旅行时,我喜欢事先计划好。|我喜欢继续解我的难题或问题,直到解决为止。', null, '63', '136');
INSERT INTO `question` VALUES ('1788', null, '我有时喜欢做些事情,只是为了想看看别人对此事的反应。|我喜欢固定于某一职业或问题上,甚至看来它（它看来）好像没有什么希望。', null, '64', '136');
INSERT INTO `question` VALUES ('1789', null, '我喜欢做别人认为不合常规的事。|我喜欢不受干扰地长时间工作。', null, '65', '136');
INSERT INTO `question` VALUES ('1790', null, '我喜欢完成具有重大意义的事。|我不在乎与迷人的异性表示亲切。', null, '66', '136');
INSERT INTO `question` VALUES ('1791', null, '我喜欢称赞我所崇拜的人。|我喜欢被异性认为身材吸引人。', null, '67', '136');
INSERT INTO `question` VALUES ('1792', null, '我喜欢保持我的书桌与工作间的清洁与整齐。|我喜欢与异性谈情说爱。', null, '68', '136');
INSERT INTO `question` VALUES ('1793', null, '我喜欢谈我的成就。|我喜欢听或说以性为主的笑话。', null, '69', '136');
INSERT INTO `question` VALUES ('1794', null, '我喜欢依我的方式做事而不在乎别人的看法。|我喜欢看以性为主的书或剧本。', null, '70', '136');
INSERT INTO `question` VALUES ('1795', null, '我喜欢写本伟大的小说或剧本。|我喜欢考虑与我看法相反的观点。', null, '71', '136');
INSERT INTO `question` VALUES ('1796', null, '在团体中我喜欢接受别人的领导来决定团体该做什么。|假如某人罪有应得的话我想公开地进行批评。', null, '72', '136');
INSERT INTO `question` VALUES ('1797', null, '我喜欢我的生活安排得好,过得顺利而不用对我的计划做太多的改变。|当我动怒时,我想摔东西。', null, '73', '136');
INSERT INTO `question` VALUES ('1798', null, '我喜欢问些没有人能回答的问题。|我喜欢对别人说我对他们的看法。', null, '74', '136');
INSERT INTO `question` VALUES ('1799', null, '我喜欢回避责任与义务。|我想取笑那些我认为他们行为愚蠢的人。', null, '75', '136');
INSERT INTO `question` VALUES ('1800', null, '我喜欢对我的朋友忠实。|对所有我承担的事,我喜欢尽力做好。', null, '76', '136');
INSERT INTO `question` VALUES ('1801', null, '我喜欢观察别人在某些情况下的感觉。|我喜欢我能自豪地说我成功地解决了一件难题。', null, '77', '136');
INSERT INTO `question` VALUES ('1802', null, '当我失败时,我喜欢我的朋友鼓励我。|我喜欢将所承担的事做得很成功。', null, '78', '136');
INSERT INTO `question` VALUES ('1803', null, '我喜欢成为所属机构与团体的领导之一。|我喜欢能比别人做得更好。', null, '79', '136');
INSERT INTO `question` VALUES ('1804', null, '当发生差错时,我觉得比别人更该受到责备。|我喜欢解答别人认为困难的谜语与问题。', null, '80', '136');
INSERT INTO `question` VALUES ('1805', null, '我喜欢为我的朋友做事。|做计划时,我喜欢从其见解为我所尊敬的人那里得到些建议。', null, '81', '136');
INSERT INTO `question` VALUES ('1806', null, '我喜欢将自己放在别人的处境上,去想象同样情况下也会有什么感觉。|当我认为我的上司做得对时,我喜欢对他们表示我的看法。', null, '82', '136');
INSERT INTO `question` VALUES ('1807', null, '当我有问题时,我喜欢被我的朋友同情与了解。|我喜欢接受我所尊敬的人领导。', null, '83', '136');
INSERT INTO `question` VALUES ('1808', null, '在群众团体中,我喜欢被指定或选为领导者。|在团体中,我喜欢接受别人的领导来决定团体该怎么做。', null, '84', '136');
INSERT INTO `question` VALUES ('1809', null, '假如我做错了事,我觉得应该受到处罚。|我喜欢遵从习俗,并避免做我所尊敬的人认为不合常规的事。', null, '85', '136');
INSERT INTO `question` VALUES ('1810', null, '我喜欢与朋友共享一切。|在开始做困难的事情之前,我喜欢先做计划。', null, '86', '136');
INSERT INTO `question` VALUES ('1811', null, '我喜欢了解我的朋友在面临各种问题时的感觉。|假如我必须旅行,我喜欢先将事情安排好。', null, '87', '136');
INSERT INTO `question` VALUES ('1812', null, '我喜欢我的朋友对我仁慈。|在开始之前,我喜欢将工作组织计划好。', null, '88', '136');
INSERT INTO `question` VALUES ('1813', null, '我喜欢被别人看作领导。|我喜欢将我的信、账单或其他文件整齐地排列着, 并依某种系统存档。', null, '89', '136');
INSERT INTO `question` VALUES ('1814', null, '我感到我所受的痛苦与折磨对我而言是好处多于坏处。|我喜欢我的生活安排的好,过得顺利,而不用对我的计划做太多的改变。', null, '90', '136');
INSERT INTO `question` VALUES ('1815', null, '我喜欢与我的朋友有深厚的交情。|我喜欢说些别人认为机智与聪明的事。', null, '91', '136');
INSERT INTO `question` VALUES ('1816', null, '我喜欢探求朋友们的性格并尝试找出他们成为这样的原因。|我有时喜欢做些事情,只是为了想看看别人对它的反应。', null, '92', '136');
INSERT INTO `question` VALUES ('1817', null, '当我受伤或生病时,我喜欢我的朋友小题大做。|我喜欢谈我的成就。', null, '93', '136');
INSERT INTO `question` VALUES ('1818', null, '我喜欢告诉别人该怎么做他们的工作。|我喜欢成为团体中众目所瞩的对象。', null, '94', '136');
INSERT INTO `question` VALUES ('1819', null, '在所认定的强者面前我感到胆怯。|我喜欢用些别人不懂其意的字眼。', null, '95', '136');
INSERT INTO `question` VALUES ('1820', null, '我比较喜欢与朋友共事而不喜欢独自工作。|我不表达我对事情的看法。', null, '96', '136');
INSERT INTO `question` VALUES ('1821', null, '我喜欢研究与分析他人的行动。|我喜欢作别人认为不合常规的事。', null, '97', '136');
INSERT INTO `question` VALUES ('1822', null, '当我生病时,我喜欢朋友们为我感伤。|我喜欢避免需要依常规做事的场合。', null, '98', '136');
INSERT INTO `question` VALUES ('1823', null, '只要可能,我喜欢监督与指导别人的行为。|我喜欢依我的方式办事不管别人的想法。', null, '99', '136');
INSERT INTO `question` VALUES ('1824', null, '我觉得处处不如人。|我喜欢回避责任与义务。', null, '100', '136');
INSERT INTO `question` VALUES ('1825', null, '我喜欢将我所承担的事办成功。|我喜欢结交新朋友。', null, '101', '136');
INSERT INTO `question` VALUES ('1826', null, '我喜欢分析我自己的动机与情感。|我喜欢广交朋友。', null, '102', '136');
INSERT INTO `question` VALUES ('1827', null, '当我遇困难时,我喜欢我的朋友帮助我。|我喜欢为我的朋友做事。', null, '103', '136');
INSERT INTO `question` VALUES ('1828', null, '当我的观点被冲击时,我喜欢为之辩护。|我喜欢写信给我的朋友。', null, '104', '136');
INSERT INTO `question` VALUES ('1829', null, '每当我做错事时,我感到内疚。|我喜欢与朋友有深交。', null, '105', '136');
INSERT INTO `question` VALUES ('1830', null, '我喜欢与朋友共享一切。|我喜欢分析我自己的动机与感情。', null, '106', '136');
INSERT INTO `question` VALUES ('1831', null, '我喜欢接受我所尊敬的人的领导。|我喜欢了解我的朋友在面临各种问题时的感觉。', null, '107', '136');
INSERT INTO `question` VALUES ('1832', null, '我喜欢我的朋友们高兴地为我办点小事。|我喜欢从人们为什么那样做而不从他实际做什么来判断人。', null, '108', '136');
INSERT INTO `question` VALUES ('1833', null, '大家在一起时,我喜欢决定人们该做什么。|我喜欢预测我的朋友们在各种情况下的反应。', null, '109', '136');
INSERT INTO `question` VALUES ('1834', null, '当我退让或避免了冲突时,我觉得比争取达到目标还好些。|我喜欢分析他人的感情与动机。', null, '110', '136');
INSERT INTO `question` VALUES ('1835', null, '我喜欢结交新朋友。|当我有麻烦时,我喜欢我的朋友帮助我。', null, '111', '136');
INSERT INTO `question` VALUES ('1836', null, '我喜欢从人们为什么那样做而不从他实际做什么来判断人。|我喜欢我的朋友们对我有深情。', null, '112', '136');
INSERT INTO `question` VALUES ('1837', null, '我喜欢将我的生活安排好,过得顺利,而不用对我的计划做太大的改变。|当我生病时,我喜欢我的朋友们为我感伤。', null, '113', '136');
INSERT INTO `question` VALUES ('1838', null, '我喜欢被人们叫去做和事佬。|我喜欢我的朋友们高兴地为我办点小事。', null, '114', '136');
INSERT INTO `question` VALUES ('1839', null, '我觉得我必须承认自己做错了的事。|当我沮丧时,我喜欢我的朋友们同情我,并使我愉快。', null, '115', '136');
INSERT INTO `question` VALUES ('1840', null, '我喜欢与朋友们共事而不喜欢独自进行工作。|当我的观点被攻击时,我喜欢为之辩护。', null, '116', '136');
INSERT INTO `question` VALUES ('1841', null, '我喜欢观察我的朋友们的性格,试着找出究竟是什么缘故使他们成为现在这样。|我喜欢能说服与影响其他人去做我想做的事。', null, '117', '136');
INSERT INTO `question` VALUES ('1842', null, '当我沮丧时我喜欢我的朋友同情我,并使我愉快。|在团体中,我喜欢决定我们该做什么。', null, '118', '136');
INSERT INTO `question` VALUES ('1843', null, '我喜欢问我明知没有人回答得出来的问题。|我喜欢告诉别人怎么做他们的工作。', null, '119', '136');
INSERT INTO `question` VALUES ('1844', null, '在我所认定的强者面前,我感到胆怯。|只要我能够的话,我喜欢监督与指导别人的行动。', null, '120', '136');
INSERT INTO `question` VALUES ('1845', null, '我喜欢加入一个成员之间彼此温暖与友善的团体。|我知道自己做错了事时会感到内疚。', null, '121', '136');
INSERT INTO `question` VALUES ('1846', null, '我喜欢分析别人的感情与动机。|由于自己无能处理各种情况使我感到沮丧。', null, '122', '136');
INSERT INTO `question` VALUES ('1847', null, '当我生病时,我喜欢我的朋友们为我感伤。|当我退让与避免争执时,我感到比争取达到目的还好些。', null, '123', '136');
INSERT INTO `question` VALUES ('1848', null, '我喜欢我能够说服与影响他人做我想做的事。|由于自己无能处理各种情况使我感到沮丧。', null, '124', '136');
INSERT INTO `question` VALUES ('1849', null, '我喜欢批评权威人士。|在我认为是自己的人面前,我感到胆怯。', null, '125', '136');
INSERT INTO `question` VALUES ('1850', null, '我喜欢加入在成员之间彼此具有温暖与友善感情的团体。|当我的朋友们有麻烦时,我喜欢帮助他们。', null, '126', '136');
INSERT INTO `question` VALUES ('1851', null, '我喜欢分析我的动机与情感。|当我的朋友们受伤时,我喜欢同情他们。', null, '127', '136');
INSERT INTO `question` VALUES ('1852', null, '当我有麻烦时,我喜欢我的朋友帮助我。|我喜欢待人仁慈与同情。', null, '128', '136');
INSERT INTO `question` VALUES ('1853', null, '我喜欢成为我所属机构与团体的领导之一。|当我朋友受伤或生病时,我喜欢同情他们。', null, '129', '136');
INSERT INTO `question` VALUES ('1854', null, '我觉得我所受的痛苦与不幸是好处多于坏处。|我喜欢对我的朋友表示自己的深情。', null, '130', '136');
INSERT INTO `question` VALUES ('1855', null, '我喜欢与朋友共事而不喜欢独立工作。|我喜欢试验与尝试新东西。', null, '131', '136');
INSERT INTO `question` VALUES ('1856', null, '我喜欢思索我的朋友们的性格,探讨为什么他们像现在这样。|我喜欢尝试新的职业,而不喜欢一直做同样的老事情。', null, '132', '136');
INSERT INTO `question` VALUES ('1857', null, '当我有问题时,我喜欢我的朋友们能同情与了解。|我喜欢那些原来不熟悉的人。', null, '133', '136');
INSERT INTO `question` VALUES ('1858', null, '当我的观点被攻击时,我喜欢为之辩护。|我喜欢在日常生活中经历新鲜与变迁。', null, '134', '136');
INSERT INTO `question` VALUES ('1859', null, '当我退让避免了争执时,我感到比照自己的方式做还好些。|我喜欢搬家住到不同的地方。', null, '135', '136');
INSERT INTO `question` VALUES ('1860', null, '我喜欢为我的朋友办事。|当我有功课要做时,我喜欢及时做并一直工作至完成为止。', null, '136', '136');
INSERT INTO `question` VALUES ('1861', null, '我喜欢分析别人的感情与动机。|当我工作时,我喜欢避开干扰。', null, '137', '136');
INSERT INTO `question` VALUES ('1862', null, '我喜欢我的朋友们高兴地为我办点小事。|我喜欢熬夜将工作完成。', null, '138', '136');
INSERT INTO `question` VALUES ('1863', null, '我喜欢被别人当作领导。|我喜欢长时间地工作而不受别人干扰。', null, '139', '136');
INSERT INTO `question` VALUES ('1864', null, '假如我做错了事的话,我觉得我应受责备。|我喜欢坚持我的职业与方向,甚至看来好像没什么进展时,我也不在乎。', null, '140', '136');
INSERT INTO `question` VALUES ('1865', null, '我喜欢对我的朋友忠实。|我喜欢与迷人的异性约会。', null, '141', '136');
INSERT INTO `question` VALUES ('1866', null, '我喜欢预测我的朋友在各种情况下的行动。|我喜欢参与有关性与性行为的讨论。', null, '142', '136');
INSERT INTO `question` VALUES ('1867', null, '我喜欢我的朋友们对我有深情。|我喜欢变得性兴奋。', null, '143', '136');
INSERT INTO `question` VALUES ('1868', null, '在一群人中,我喜欢由我决定该做什么。|我喜欢参与有性的社交场合。', null, '144', '136');
INSERT INTO `question` VALUES ('1869', null, '我为自己无力处理各种情况感到沮丧。|我喜欢看以性为主题的书与剧本。', null, '145', '136');
INSERT INTO `question` VALUES ('1870', null, '我喜欢写信给我的朋友。|我喜欢看报纸上有关谋杀与其他暴力方面的新闻。', null, '146', '136');
INSERT INTO `question` VALUES ('1871', null, '我喜欢预测我的朋友们在各种情况下将怎样做。|我喜欢攻击与我观点相反的看法。', null, '147', '136');
INSERT INTO `question` VALUES ('1872', null, '当我受伤或生病时,我喜欢我的朋友们为我小题大做。|当事情不顺时,我想责怪别人。', null, '148', '136');
INSERT INTO `question` VALUES ('1873', null, '我喜欢告诉别人如何做他们的工作。|当有人侮辱我时,我想报复。', null, '149', '136');
INSERT INTO `question` VALUES ('1874', null, '我感到我处处不如人。|当我不赞同他们的看法时,我喜欢说服他们。', null, '150', '136');
INSERT INTO `question` VALUES ('1875', null, '当我的朋友们有麻烦时,我喜欢帮助他们。|对我所承担的事,我喜欢尽力而为。', null, '151', '136');
INSERT INTO `question` VALUES ('1876', null, '对我所承担的一切事情,我喜欢认真去做。|我喜欢完成某些具有重大意义的事。', null, '152', '136');
INSERT INTO `question` VALUES ('1877', null, '对我所承担的一切事情,我喜欢认真去做。|我喜欢完成某些具有重大意义的事。', null, '153', '136');
INSERT INTO `question` VALUES ('1878', null, '我喜欢与迷人的异性约会。|对我所承担的事我希望能够做成功。', null, '154', '136');
INSERT INTO `question` VALUES ('1879', null, '我喜欢看报上有关谋杀与其他形式的暴力新闻。|我想写本伟大的小说或剧本。', null, '155', '136');
INSERT INTO `question` VALUES ('1880', null, '我喜欢为我的朋友们做点小事。|做计划时,我喜欢我所敬重的人给我提出些建议。', null, '156', '136');
INSERT INTO `question` VALUES ('1881', null, '我喜欢在日常生活中经历新奇与变异。|当我认为我的上司做的对时,我喜欢对他们表示我的看法。', null, '157', '136');
INSERT INTO `question` VALUES ('1882', null, '我喜欢熬夜将工作完成。|我喜欢称赞我所仰慕的人。', null, '158', '136');
INSERT INTO `question` VALUES ('1883', null, '我喜欢变得性兴奋。|我喜欢接受我所仰慕的人领导。', null, '159', '136');
INSERT INTO `question` VALUES ('1884', null, '当有人侮辱我时,我想报复。|在团体中,我喜欢接受别人的领导来决定团体该做什么。', null, '160', '136');
INSERT INTO `question` VALUES ('1885', null, '我喜欢对我的朋友们慷慨。|在做困难的事之前,我喜欢做个计划。', null, '161', '136');
INSERT INTO `question` VALUES ('1886', null, '我喜欢交新朋友。|我希望我的一切作品都是严密、整齐而有条理的。', null, '162', '136');
INSERT INTO `question` VALUES ('1887', null, '我喜欢将我开了头的事情或工作完成。|我喜欢使我的书桌与工作间保持清洁与整齐。', null, '163', '136');
INSERT INTO `question` VALUES ('1888', null, '我喜欢被别人认为身材迷人。|对我所承担的任何事,我喜欢巨细无遗地进行计划与组织。', null, '164', '136');
INSERT INTO `question` VALUES ('1889', null, '我喜欢告诉别人我对他们的看法。|我喜欢饮食有规律,并在固定的时间吃东西。', null, '165', '136');
INSERT INTO `question` VALUES ('1890', null, '我喜欢对我的朋友表示深情。|我喜欢说些别人认为机智与聪明的事。', null, '166', '136');
INSERT INTO `question` VALUES ('1891', null, '我喜欢尝试新的工作而不喜欢一直做同样的老事情。|我有时想做一些事情的目的只为了想看别人对它的反应。', null, '167', '136');
INSERT INTO `question` VALUES ('1892', null, '我喜欢坚持自己的工作与方向,即使看来好像已进入了无底深渊,我也不在乎。|在公共场合中我喜欢人注意我和评价我的外表。', null, '168', '136');
INSERT INTO `question` VALUES ('1893', null, '我喜欢看以性为主题的书与剧本。|在团体中,我喜欢成为众人所瞩目的对象。', null, '169', '136');
INSERT INTO `question` VALUES ('1894', null, '当事情不顺时,我想责怪别人。|我喜欢问些明知没人能回答的问题。', null, '170', '136');
INSERT INTO `question` VALUES ('1895', null, '当我的朋友们受伤或生病时,我喜欢对他们表示同情。|我喜欢说我对事情的看法。', null, '171', '136');
INSERT INTO `question` VALUES ('1896', null, '我喜欢在新奇的餐厅吃饭。|我喜欢做些别人认为不合常规的事。', null, '172', '136');
INSERT INTO `question` VALUES ('1897', null, '在承担其他事之前,我喜欢每次只做一件事并将它完成。|我喜欢能自如地做我想做的事。', null, '173', '136');
INSERT INTO `question` VALUES ('1898', null, '我喜欢参与有关性与性行为的讨论。|我喜欢照我自己的方式来做而不管别人有什么看法。', null, '174', '136');
INSERT INTO `question` VALUES ('1899', null, '当我动怒时,我想摔东西。|我喜欢回避责任与义务。', null, '175', '136');
INSERT INTO `question` VALUES ('1900', null, '当我的朋友们有困难时,我喜欢帮助他们。|我喜欢对我的朋友们忠实。', null, '176', '136');
INSERT INTO `question` VALUES ('1901', null, '我喜欢做些新鲜的事。|我喜欢交新朋友。', null, '177', '136');
INSERT INTO `question` VALUES ('1902', null, '当我有功课要做时,我喜欢即时开始并持续到工作完成为止。|我喜欢参与那些成员之间具有温暖与友善情感的团体。', null, '178', '136');
INSERT INTO `question` VALUES ('1903', null, '我喜欢与迷人的异性约会。|我喜欢广交朋友。', null, '179', '136');
INSERT INTO `question` VALUES ('1904', null, '我喜欢攻击与我观点相反的看法。|我喜欢给朋友写信。', null, '180', '136');
INSERT INTO `question` VALUES ('1905', null, '我喜欢对我的朋友们慷慨。|我喜欢观察别人在某一情况下的感觉。', null, '181', '136');
INSERT INTO `question` VALUES ('1906', null, '我喜欢在新奇的餐厅吃饭。|我喜欢将自己放在别人的立场来想象在同样的情况下我会有什么感觉。', null, '182', '136');
INSERT INTO `question` VALUES ('1907', null, '我喜欢熬夜将工作完成。|我喜欢预测我的朋友们在各种情况下会怎么做。', null, '183', '136');
INSERT INTO `question` VALUES ('1908', null, '我喜欢变得性兴奋。|我喜欢研究分析别人的行为。', null, '184', '136');
INSERT INTO `question` VALUES ('1909', null, '我喜欢取笑那些我觉得是做了蠢事的人。|我喜欢预测我的朋友们在各种情况下会怎么做。', null, '185', '136');
INSERT INTO `question` VALUES ('1910', null, '对有时伤害我的朋友,我喜欢原谅他们。|当我失败时,我喜欢我的朋友们鼓励我。', null, '186', '136');
INSERT INTO `question` VALUES ('1911', null, '我喜欢试验与尝试新的事情。|当我有问题时,我喜欢我的朋友们能同情与了解。', null, '187', '136');
INSERT INTO `question` VALUES ('1912', null, '我喜欢持续地了解谜语与问题,直到解决为止。|我喜欢我的朋友对我仁慈。', null, '188', '136');
INSERT INTO `question` VALUES ('1913', null, '我喜欢被异性认为身材迷人。|我喜欢我的朋友们对我有深情。', null, '189', '136');
INSERT INTO `question` VALUES ('1914', null, '假如某人是罪有应得,我会公开批评他。|当我受伤或生病时,我喜欢我的朋友们小题大做。', null, '190', '136');
INSERT INTO `question` VALUES ('1915', null, '我喜欢对我的朋友们有深情。|我喜欢被人当作领导。', null, '191', '136');
INSERT INTO `question` VALUES ('1916', null, '我喜欢尝试新的工作而不愿一直做同样的老事情。|在群众团体中,我喜欢被指定或被选为领导。', null, '192', '136');
INSERT INTO `question` VALUES ('1917', null, '对我起了头的一切事情,我都喜欢将它完成。|我喜欢我能够说服与影响别人做我所要做的事。', null, '193', '136');
INSERT INTO `question` VALUES ('1918', null, '我喜欢参与有关性行为的讨论。|我愿意被人们叫去做和事佬。', null, '194', '136');
INSERT INTO `question` VALUES ('1919', null, '当我动怒时,我想摔东西。|我喜欢告诉别人怎么去做他的工作。', null, '195', '136');
INSERT INTO `question` VALUES ('1920', null, '我喜欢对我的朋友们表示深情。|当事情有差错时,我觉得我比任何人都更该受到责备。', null, '196', '136');
INSERT INTO `question` VALUES ('1921', null, '我喜欢搬家,住在不同的地方。|当我做错事时,我觉得我该受到处罚。', null, '197', '136');
INSERT INTO `question` VALUES ('1922', null, '我喜欢坚持自己的工作或方向,甚至当它们看来好像已使我陷入无底深渊时,我也不在乎。|我觉得我所受的痛苦与不幸是好处多于坏处。', null, '198', '136');
INSERT INTO `question` VALUES ('1923', null, '我喜欢看以性为主题的书与剧本。|我觉得我必须承认有些事我做错了。', null, '199', '136');
INSERT INTO `question` VALUES ('1924', null, '当事情不顺时,我想责怪别人。|我觉得我处处不如人。', null, '200', '136');
INSERT INTO `question` VALUES ('1925', null, '对我所承担的一切事情,我喜欢尽力而为。|我喜欢帮助比我不幸的人。', null, '201', '136');
INSERT INTO `question` VALUES ('1926', null, '我喜欢做新的和各不相同的事。|我喜欢待人仁慈和同情。', null, '202', '136');
INSERT INTO `question` VALUES ('1927', null, '当我有功课做时,我喜欢及时开始并一直做到完成为止。|我喜欢帮助比我不幸的人。', null, '203', '136');
INSERT INTO `question` VALUES ('1928', null, '我喜欢参与有异性的社交场合。|我喜欢原谅有时可能伤害了我的朋友。', null, '204', '136');
INSERT INTO `question` VALUES ('1929', null, '我喜欢攻击与我观点相反的看法。|我喜欢我的朋友们信任我并告诉我他们的问题。', null, '205', '136');
INSERT INTO `question` VALUES ('1930', null, '我喜欢待人仁慈和同情。|我喜欢旅行到各处看看。', null, '206', '136');
INSERT INTO `question` VALUES ('1931', null, '我喜欢遵照习俗,避免做人家认为不合常规的事。|我喜欢追求新潮流与时髦。', null, '207', '136');
INSERT INTO `question` VALUES ('1932', null, '对我所承担的一切事情,  我喜欢认真去做。|我喜欢在日常生活中经历新奇与变异。', null, '208', '136');
INSERT INTO `question` VALUES ('1933', null, '我不在乎与迷人的异性表示亲近。|我喜欢试验与尝试新的事情。', null, '209', '136');
INSERT INTO `question` VALUES ('1934', null, '当我不赞同他人的意见时,我想指责别人。|我喜欢追求新潮流与时髦。', null, '210', '136');
INSERT INTO `question` VALUES ('1935', null, '我喜欢帮助比我不幸的人。|我喜欢将我开了头的任何事情或工作完成。', null, '211', '136');
INSERT INTO `question` VALUES ('1936', null, '我喜欢搬家,住在不同的地方。|我喜欢长时间地工作而不受干扰。', null, '212', '136');
INSERT INTO `question` VALUES ('1937', null, '假如我必须旅行的话,我喜欢先将事情安排好。|我喜欢持续地解难题直到解出为止。', null, '213', '136');
INSERT INTO `question` VALUES ('1938', null, '我喜欢与异性谈恋爱。|在承担别的事之前,我喜欢将现在的工作或任务完成。', null, '214', '136');
INSERT INTO `question` VALUES ('1939', null, '我喜欢对别人说我对他们的看法。|当我工作时,我喜欢避免干扰。', null, '215', '136');
INSERT INTO `question` VALUES ('1940', null, '我喜欢为我的朋友们办点小事。|我喜欢参与有异性的社交场合。', null, '216', '136');
INSERT INTO `question` VALUES ('1941', null, '我喜欢见到不熟识的人。|我不在乎与迷人的异性表示亲近。', null, '217', '136');
INSERT INTO `question` VALUES ('1942', null, '我喜欢持续解难题直到解出为止。|我喜欢与异性谈恋爱。', null, '218', '136');
INSERT INTO `question` VALUES ('1943', null, '我喜欢谈论我的成就。|我喜欢听或说以性为主的笑话。', null, '219', '136');
INSERT INTO `question` VALUES ('1944', null, '我想取笑那些我认为是做了蠢事的人。|我喜欢听或说以性为主的笑话。', null, '220', '136');
INSERT INTO `question` VALUES ('1945', null, '我喜欢我的朋友们信任我,并告诉我他们的麻烦。|我喜欢报纸上有关谋杀与其它形式暴力的新闻。', null, '221', '136');
INSERT INTO `question` VALUES ('1946', null, '我喜欢追求新潮流与时髦。|假如某人罪有应得,我会公开批评他。', null, '222', '136');
INSERT INTO `question` VALUES ('1947', null, '当我工作时,我喜欢避免干扰。|当我不赞同别人的看法,我想责怪他们。', null, '223', '136');
INSERT INTO `question` VALUES ('1948', null, '我喜欢听或说以性为主的笑话。|当有人侮辱我时,我想报复。', null, '224', '136');
INSERT INTO `question` VALUES ('1949', null, '我喜欢回避责任与义务。|当有人做了我认为很愚蠢的事情时,我想取笑他们。', null, '225', '136');
INSERT INTO `question` VALUES ('2220', '我喜欢参加公众集会,目的是为了同别人在一起。', '是|否', null, '1', '135');
INSERT INTO `question` VALUES ('2221', '我觉得我父亲是个理想的人。', '是|否', null, '2', '135');
INSERT INTO `question` VALUES ('2222', '一个人需要不时地\"显示\"一下自己。', '是|否', null, '3', '135');
INSERT INTO `question` VALUES ('2223', null, '是|否', null, '4', '135');
INSERT INTO `question` VALUES ('2224', '我常常觉得在专业选择上自己犯了个错误。', '是|否', null, '5', '135');
INSERT INTO `question` VALUES ('2225', '我一贯遵守这样一条原则：先工作,后娱乐。', '是|否', null, '6', '135');
INSERT INTO `question` VALUES ('2226', '我有时会感到好像就要发生什么可怕的事情,这种感觉一周内有好几次。', '是|否', null, '7', '135');
INSERT INTO `question` VALUES ('2227', '我希望当一名记者。', '是|否', null, '8', '135');
INSERT INTO `question` VALUES ('2228', '我觉得自己愿意干建筑承包工作。', '是|否', null, '9', '135');
INSERT INTO `question` VALUES ('2229', '我曾有过非常独特、奇异的体验。', '是|否', null, '10', '135');
INSERT INTO `question` VALUES ('2230', '总的来看,穷人比富人境况好。', '是|否', null, '11', '135');
INSERT INTO `question` VALUES ('2231', '我一听到自己熟悉的人获得成功,就像自己失败了一样。', '是|否', null, '12', '135');
INSERT INTO `question` VALUES ('2232', '我希望当服装设计师。', '是|否', null, '13', '135');
INSERT INTO `question` VALUES ('2233', '别人常常说我莽撞。', '是|否', null, '14', '135');
INSERT INTO `question` VALUES ('2234', '有时我也讲点闲话。', '是|否', null, '15', '135');
INSERT INTO `question` VALUES ('2235', '我怀疑自己能否会做好领导工作。', '是|否', null, '16', '135');
INSERT INTO `question` VALUES ('2236', '我感到很难开口同陌生人交谈。', '是|否', null, '17', '135');
INSERT INTO `question` VALUES ('2237', '一觉得有人注视我,我就会变得紧张。', '是|否', null, '18', '135');
INSERT INTO `question` VALUES ('2238', '如果人们能够掌握所有实际情况,对大多数问题来说,只有一个正确的答案。', '是|否', null, '19', '135');
INSERT INTO `question` VALUES ('2239', '有时我装作比我实际懂得多的样子。', '是|否', null, '20', '135');
INSERT INTO `question` VALUES ('2240', '为公共事务操心,一点用处也没有,反正自己的所作所为对公共事务毫无影响。', '是|否', null, '21', '135');
INSERT INTO `question` VALUES ('2241', '有时我真想摔瓶摔碗,发泄一下。', '是|否', null, '22', '135');
INSERT INTO `question` VALUES ('2242', '不应该让妇女单独在酒馆里喝酒。', '是|否', null, '23', '135');
INSERT INTO `question` VALUES ('2243', '如果某人冤枉了我,我觉得只要有可能就该批评他,这样做的目的是为了维护原则。', '是|否', null, '24', '135');
INSERT INTO `question` VALUES ('2244', '我好像和周围的大多数人一样聪明能干。', '是|否', null, '25', '135');
INSERT INTO `question` VALUES ('2245', '我希望拥有支配他人的权力。', '是|否', null, '26', '135');
INSERT INTO `question` VALUES ('2246', '我感到很难集中精力去完成一项工作。', '是|否', null, '27', '135');
INSERT INTO `question` VALUES ('2247', '一想到别人不赞同我,我就变得非常紧张、焦虑。', '是|否', null, '28', '135');
INSERT INTO `question` VALUES ('2248', '许多人的困难在于他们办事不够认真严肃。', '是|否', null, '29', '135');
INSERT INTO `question` VALUES ('2249', '我过去喜欢上学。', '是|否', null, '30', '135');
INSERT INTO `question` VALUES ('2250', '我害怕雷暴雨。', '是|否', null, '31', '135');
INSERT INTO `question` VALUES ('2251', '有时我真想骂街。', '是|否', null, '32', '135');
INSERT INTO `question` VALUES ('2252', '我肯定,世界上纯粹、真正的宗教只有一种。', '是|否', null, '33', '135');
INSERT INTO `question` VALUES ('2253', '听到下流的故事时,我感到窘迫。', '是|否', null, '34', '135');
INSERT INTO `question` VALUES ('2254', '我有时为避开和某人相遇而穿过马路。', '是|否', null, '35', '135');
INSERT INTO `question` VALUES ('2255', '我过去常写日记。', '是|否', null, '36', '135');
INSERT INTO `question` VALUES ('2256', '应该和少数民族搞好团结,但这件事与我无关。', '是|否', null, '37', '135');
INSERT INTO `question` VALUES ('2257', '我感到很难向任何人谈及自己的情况。', '是|否', null, '38', '135');
INSERT INTO `question` VALUES ('2258', '我们应该为自己的国家担忧,让世界上其他国家自己管理自己。', '是|否', null, '39', '135');
INSERT INTO `question` VALUES ('2259', '我经常感到好像整个世界对我毫不在意,在飘然而去。', '是|否', null, '40', '135');
INSERT INTO `question` VALUES ('2260', '我感到厌烦的时候,喜欢挑起刺激性的事端。', '是|否', null, '41', '135');
INSERT INTO `question` VALUES ('2261', '我喜欢不时地夸耀一下自己取得的成绩。', '是|否', null, '42', '135');
INSERT INTO `question` VALUES ('2262', '我害怕深水。', '是|否', null, '43', '135');
INSERT INTO `question` VALUES ('2263', '必须承认,我常常想方设法按自己的方式行事,丝毫不考虑别人可能要做什么。', '是|否', null, '44', '135');
INSERT INTO `question` VALUES ('2264', '我觉得自己希望当汽车修理工。', '是|否', null, '45', '135');
INSERT INTO `question` VALUES ('2265', '在正式的舞会或集会上,我总感到紧张和不舒适。', '是|否', null, '46', '135');
INSERT INTO `question` VALUES ('2266', '我不愿意看到人们穿戴邋邋遢遢,过于随便。', '是|否', null, '47', '135');
INSERT INTO `question` VALUES ('2267', '我每周会有一次或多次觉得突然浑身发烧,却没有明显的原因。', '是|否', null, '48', '135');
INSERT INTO `question` VALUES ('2268', '有时我觉得一切都糟糕得不愿张口提及。', '是|否', null, '49', '135');
INSERT INTO `question` VALUES ('2269', '如果一切照现在这个样子继续下去,人们很难期望会发生什么了不起的事。', '是|否', null, '50', '135');
INSERT INTO `question` VALUES ('2270', '我无法使自己的思想集中到某一件事上。', '是|否', null, '51', '135');
INSERT INTO `question` VALUES ('2271', '必须承认,我经常对工作能少干就少干。', '是|否', null, '52', '135');
INSERT INTO `question` VALUES ('2272', '我喜欢成为人们注意的中心。', '是|否', null, '53', '135');
INSERT INTO `question` VALUES ('2273', '单独走进别人正在聚集聊天的房间,我并不感到害怕。', '是|否', null, '54', '135');
INSERT INTO `question` VALUES ('2274', '有时我非常泄气。', '是|否', null, '55', '135');
INSERT INTO `question` VALUES ('2275', '想到自己会遭受车祸,我很害怕。', '是|否', null, '56', '135');
INSERT INTO `question` VALUES ('2276', '和大家在一起的时候,我总想不出恰当的话来说。', '是|否', null, '57', '135');
INSERT INTO `question` VALUES ('2277', '中学教师总抱怨他们的收入少,但我认为他们也就该挣这么多钱。', '是|否', null, '58', '135');
INSERT INTO `question` VALUES ('2278', '有时我真想与某人动手打一架。', '是|否', null, '59', '135');
INSERT INTO `question` VALUES ('2279', '听那种没有自己主见的人讲课很令人讨厌。', '是|否', null, '60', '135');
INSERT INTO `question` VALUES ('2280', '一个人倘若事先把一切活动都安排好,他很可能会把生活中的乐趣全部剥夺掉。', '是|否', null, '61', '135');
INSERT INTO `question` VALUES ('2281', '过去念书时,我接受知识很慢。', '是|否', null, '62', '135');
INSERT INTO `question` VALUES ('2282', '我喜欢诗歌。', '是|否', null, '63', '135');
INSERT INTO `question` VALUES ('2283', '我不喜欢与别人说话,除非他们先开口。', '是|否', null, '64', '135');
INSERT INTO `question` VALUES ('2284', '我觉得自己希望骑一辆赛车。', '是|否', null, '65', '135');
INSERT INTO `question` VALUES ('2285', '有时没有任何原因,甚至当一切很糟糕的时候,我反而又激动又高兴,感到万事如意。', '是|否', null, '66', '135');
INSERT INTO `question` VALUES ('2286', '我一生的目的之一,就是完成某件我母亲可以引为自豪的工作。', '是|否', null, '67', '135');
INSERT INTO `question` VALUES ('2287', '我很容易恋爱,也很容易失恋。', '是|否', null, '68', '135');
INSERT INTO `question` VALUES ('2288', '只要不犯法,回避法律条款也没什么不好。', '是|否', null, '69', '135');
INSERT INTO `question` VALUES ('2289', '现在做父母的对子女管教太松。', '是|否', null, '70', '135');
INSERT INTO `question` VALUES ('2290', '我很怕黑暗。', '是|否', null, '71', '135');
INSERT INTO `question` VALUES ('2291', '碰到困难的问题,我往往容易打退堂鼓。', '是|否', null, '72', '135');
INSERT INTO `question` VALUES ('2292', '别人的批评和训斥,使我很不舒服。', '是|否', null, '73', '135');
INSERT INTO `question` VALUES ('2293', '我有一些奇特、少有的念头。', '是|否', null, '74', '135');
INSERT INTO `question` VALUES ('2294', '身体不舒服的时候,我容易生气发火。', '是|否', null, '75', '135');
INSERT INTO `question` VALUES ('2295', null, '是|否', null, '76', '135');
INSERT INTO `question` VALUES ('2296', '我常常发现,在试图做某件事的时候,我的手在发抖。', '是|否', null, '77', '135');
INSERT INTO `question` VALUES ('2297', '假如迫不得已,非要见很多人的话,我感到很紧张。', '是|否', null, '78', '135');
INSERT INTO `question` VALUES ('2298', '我希望听到著名歌手在歌剧中演唱。', '是|否', null, '79', '135');
INSERT INTO `question` VALUES ('2299', '有时没有任何充分的理由,我就生气、发脾气。', '是|否', null, '80', '135');
INSERT INTO `question` VALUES ('2300', '我喜欢参加社交聚会和联欢会。', '是|否', null, '81', '135');
INSERT INTO `question` VALUES ('2301', '我父母常常对我的朋友表示反感。', '是|否', null, '82', '135');
INSERT INTO `question` VALUES ('2302', '我希望同时是好几个俱乐部或社团的成员。', '是|否', null, '83', '135');
INSERT INTO `question` VALUES ('2303', '过去我的家庭生活一直很幸福。', '是|否', null, '84', '135');
INSERT INTO `question` VALUES ('2304', '我往往凭一时冲动,鲁莽行事,而没有停下来思考一下。', '是|否', null, '85', '135');
INSERT INTO `question` VALUES ('2305', '我做事的方法常易被人误解。', '是|否', null, '86', '135');
INSERT INTO `question` VALUES ('2306', '有时,我突然感到一阵晕眩,所干的事情被打断,周围发生的一切都不知道。', '是|否', null, '87', '135');
INSERT INTO `question` VALUES ('2307', '某人为我做了一件好事,我常常自问其背后隐藏的动机是什么。', '是|否', null, '88', '135');
INSERT INTO `question` VALUES ('2308', '我确实缺乏自信心。', '是|否', null, '89', '135');
INSERT INTO `question` VALUES ('2309', '当某人招致不幸时,其他人大都暗自高兴。', '是|否', null, '90', '135');
INSERT INTO `question` VALUES ('2310', '假如在某个群众团体工作,我喜欢担任领导职务。', '是|否', null, '91', '135');
INSERT INTO `question` VALUES ('2311', '有时我觉得好像非要伤害自己或伤害他人。', '是|否', null, '92', '135');
INSERT INTO `question` VALUES ('2312', '我有不少分外的事要操心。', '是|否', null, '93', '135');
INSERT INTO `question` VALUES ('2313', '我常常只图一时快乐,即使这样做有损于长远目标也在所不惜。', '是|否', null, '94', '135');
INSERT INTO `question` VALUES ('2314', '除非与我熟知的人在一起,我一般不爱多说话。', '是|否', null, '95', '135');
INSERT INTO `question` VALUES ('2315', '我记得自己曾经为了摆脱某件事而假装生病。', '是|否', null, '96', '135');
INSERT INTO `question` VALUES ('2316', '碰到一位陌生人,我常常感到他比我强。', '是|否', null, '97', '135');
INSERT INTO `question` VALUES ('2317', '我喜欢让别人去猜测我下一步将干什么。', '是|否', null, '98', '135');
INSERT INTO `question` VALUES ('2318', '和众人在一起时,假如让我主持一个讨论或就我熟知的事情发表意见,我不会觉得难为情。', '是|否', null, '99', '135');
INSERT INTO `question` VALUES ('2319', '事情出了差错,我有时责怪他人。', '是|否', null, '100', '135');
INSERT INTO `question` VALUES ('2320', '我更喜欢自己下了赌注的比赛或游戏。', '是|否', null, '101', '135');
INSERT INTO `question` VALUES ('2321', '我常常发现,别人嫉妒我的好主意,就是因为他们没有先想到这些主意。', '是|否', null, '102', '135');
INSERT INTO `question` VALUES ('2322', '我喜欢参加社交集会和其他热热闹闹的活动。', '是|否', null, '103', '135');
INSERT INTO `question` VALUES ('2323', '我爱打猎。', '是|否', null, '104', '135');
INSERT INTO `question` VALUES ('2324', '当独自一个人的时候,我发现自己常常在琢磨一些抽象的问题,比如：自由意志、邪恶等等。', '是|否', null, '105', '135');
INSERT INTO `question` VALUES ('2325', '听到有人被非法地阻止参加选举,我非常气愤。', '是|否', null, '106', '135');
INSERT INTO `question` VALUES ('2326', '我从前上学时,有时因为惹老师生气被送去见班主任。', '是|否', null, '107', '135');
INSERT INTO `question` VALUES ('2327', '我希望当一名图书管理员。', '是|否', null, '108', '135');
INSERT INTO `question` VALUES ('2328', '我很喜欢参加舞会。', '是|否', null, '109', '135');
INSERT INTO `question` VALUES ('2329', '多数人从内心里并不愿意花力气帮助他人。', '是|否', null, '110', '135');
INSERT INTO `question` VALUES ('2330', '人们装出他们互相很关心,而实际上并非如此。', '是|否', null, '111', '135');
INSERT INTO `question` VALUES ('2331', '多数人在性的问题上忧虑过多。', '是|否', null, '112', '135');
INSERT INTO `question` VALUES ('2332', '遇到不熟悉的人我很难想出什么话题来说。', '是|否', null, '113', '135');
INSERT INTO `question` VALUES ('2333', '我很喜欢对称的东西,而不喜欢不对称的东西。', '是|否', null, '114', '135');
INSERT INTO `question` VALUES ('2334', '我宁愿做一名踏踏实实、可以信赖的人,而不愿做一名才华横溢而见异思迁的人。', '是|否', null, '115', '135');
INSERT INTO `question` VALUES ('2335', '一有机会,我总爱以某种方式显露一下自己。', '是|否', null, '116', '135');
INSERT INTO `question` VALUES ('2336', '对某些问题,我太容易动肝火,所以无法谈论它们。', '是|否', null, '117', '135');
INSERT INTO `question` VALUES ('2337', '有时候,我好像简直无力开展工作。', '是|否', null, '118', '135');
INSERT INTO `question` VALUES ('2338', '若有人没有把贵重物品妥善保管,使其成为诱饵,一旦该物被偷了的话,则放物的人和小偷应受到同样的谴责。', '是|否', null, '119', '135');
INSERT INTO `question` VALUES ('2339', '我同什么样的人都合得来。', '是|否', null, '120', '135');
INSERT INTO `question` VALUES ('2340', '我常常被不断涌现又毫无意义的思想所烦忧。', '是|否', null, '121', '135');
INSERT INTO `question` VALUES ('2341', '假如我是记者,我很希望报道有关剧院的新闻。', '是|否', null, '122', '135');
INSERT INTO `question` VALUES ('2342', '男人与女人在一起的时候,总想取得女人的好感。', '是|否', null, '123', '135');
INSERT INTO `question` VALUES ('2343', '我喜欢看指导人们亲自动手做事情的杂志。', '是|否', null, '124', '135');
INSERT INTO `question` VALUES ('2344', '必须承认,我感到很难在严格的规章制度下工作。', '是|否', null, '125', '135');
INSERT INTO `question` VALUES ('2345', '我喜欢盛大喧闹的聚会。', '是|否', null, '126', '135');
INSERT INTO `question` VALUES ('2346', '我有时觉得自己是别人的负担。', '是|否', null, '127', '135');
INSERT INTO `question` VALUES ('2347', '只有傻子才试图改变我们中国人的生活方式。', '是|否', null, '128', '135');
INSERT INTO `question` VALUES ('2348', '我常常感到好像做了什么错误的或邪恶的事。', '是|否', null, '129', '135');
INSERT INTO `question` VALUES ('2349', '以前上学时,我感到很难在全班同学面前讲话。', '是|否', null, '130', '135');
INSERT INTO `question` VALUES ('2350', '我通常感到人生很有价值。', '是|否', null, '131', '135');
INSERT INTO `question` VALUES ('2351', '我们应该离开非洲国家,以便澄清他们的问题,我们没有任何理由去帮助他们。', '是|否', null, '132', '135');
INSERT INTO `question` VALUES ('2352', '有几次,我对某个人很刻薄。', '是|否', null, '133', '135');
INSERT INTO `question` VALUES ('2353', null, '是|否', null, '134', '135');
INSERT INTO `question` VALUES ('2354', '我爱自己讲话,而不爱听别人讲话。', '是|否', null, '135', '135');
INSERT INTO `question` VALUES ('2355', '我喜欢科学。', '是|否', null, '136', '135');
INSERT INTO `question` VALUES ('2356', '我常常发脾气。', '是|否', null, '137', '135');
INSERT INTO `question` VALUES ('2357', '必须承认,搬到一个陌生的地方去我会有些害怕。', '是|否', null, '138', '135');
INSERT INTO `question` VALUES ('2358', '在公共场所,比如在公共汽车上或在商店里,我对盯着我瞧的人感到很烦恼。', '是|否', null, '139', '135');
INSERT INTO `question` VALUES ('2359', '我自信知道应怎样解决我们今天所面临的国际问题。', '是|否', null, '140', '135');
INSERT INTO `question` VALUES ('2360', '有时我爱做那些不应该做的、违反制度的事。', '是|否', null, '141', '135');
INSERT INTO `question` VALUES ('2361', '我很少和家里人吵架。', '是|否', null, '142', '135');
INSERT INTO `question` VALUES ('2362', '买东西时,如果多找给了我钱,我总是把钱送回去。', '是|否', null, '143', '135');
INSERT INTO `question` VALUES ('2363', '我常常厌恶自己。', '是|否', null, '144', '135');
INSERT INTO `question` VALUES ('2364', '相当多的人都会由于不正当的性行为而感到内疚。', '是|否', null, '145', '135');
INSERT INTO `question` VALUES ('2365', '我喜欢阅读科学方面的书籍。', '是|否', null, '146', '135');
INSERT INTO `question` VALUES ('2366', '和大家在一起时,我很难表现得自然。', '是|否', null, '147', '135');
INSERT INTO `question` VALUES ('2367', '有些游戏,我根本不参加,因为我不擅长。', '是|否', null, '148', '135');
INSERT INTO `question` VALUES ('2368', '我希望加入某个合唱团。', '是|否', null, '149', '135');
INSERT INTO `question` VALUES ('2369', '小时候,我常因表现不好受到严厉的惩罚。', '是|否', null, '150', '135');
INSERT INTO `question` VALUES ('2370', '有时,我在实际上无足轻重的事上绞尽了脑汁。', '是|否', null, '151', '135');
INSERT INTO `question` VALUES ('2371', '我觉得自己常常无缘无故地受到惩罚。', '是|否', null, '152', '135');
INSERT INTO `question` VALUES ('2372', '我希望当电影或戏剧演员。', '是|否', null, '153', '135');
INSERT INTO `question` VALUES ('2373', '我情愿自己出钱为他人雪冤,尽管我与此案没有牵连。', '是|否', null, '154', '135');
INSERT INTO `question` VALUES ('2374', '有时候,我真想做件有害的或惊人的事。', '是|否', null, '155', '135');
INSERT INTO `question` VALUES ('2375', '我常常感到身体的某些部分有虫爬、火烧、刺痛和即将麻木的感觉。', '是|否', null, '156', '135');
INSERT INTO `question` VALUES ('2376', '我常常违背父母的意愿。', '是|否', null, '157', '135');
INSERT INTO `question` VALUES ('2377', '假如是我驾驶汽车,我会尽量不让别人超过我。', '是|否', null, '158', '135');
INSERT INTO `question` VALUES ('2378', '对明明知道不会伤害自己的事物和人,我也曾感到很害怕。', '是|否', null, '159', '135');
INSERT INTO `question` VALUES ('2379', '当年,我父母很希望我出类拔萃。', '是|否', null, '160', '135');
INSERT INTO `question` VALUES ('2380', '我愿意把自己说成是一个性格坚强的人。', '是|否', null, '161', '135');
INSERT INTO `question` VALUES ('2381', '我几乎从来没有睡着过。', '是|否', null, '162', '135');
INSERT INTO `question` VALUES ('2382', '投票选举完全是件令人烦恼、毫无意义的事。', '是|否', null, '163', '135');
INSERT INTO `question` VALUES ('2383', '我觉得生活上井井有条、按时作息很适合我的脾性。', '是|否', null, '164', '135');
INSERT INTO `question` VALUES ('2384', '我很难同情那种对事物总持怀疑态度、缺乏信心的人。', '是|否', null, '165', '135');
INSERT INTO `question` VALUES ('2385', '我吃什么东西都是一个味。', '是|否', null, '166', '135');
INSERT INTO `question` VALUES ('2386', '我做事情常常有始无终,虎头蛇尾。', '是|否', null, '167', '135');
INSERT INTO `question` VALUES ('2387', '假如一个朋友也没有,我也会很愉快。', '是|否', null, '168', '135');
INSERT INTO `question` VALUES ('2388', '当我出于无奈去向某人讨个职业时,会感到很紧张。', '是|否', null, '169', '135');
INSERT INTO `question` VALUES ('2389', '我有时做事胆子很小。', '是|否', null, '170', '135');
INSERT INTO `question` VALUES ('2390', '我常常希望离开家庭。', '是|否', null, '171', '135');
INSERT INTO `question` VALUES ('2391', '我的整个脑袋每天好像要疼好长时间。', '是|否', null, '172', '135');
INSERT INTO `question` VALUES ('2392', '过去在学校里,多数老师对我都很公正和诚恳。', '是|否', null, '173', '135');
INSERT INTO `question` VALUES ('2393', '必须承认,我讲话很公正。', '是|否', null, '174', '135');
INSERT INTO `question` VALUES ('2394', '在弄清事实之前,我从不对任何人下结论。', '是|否', null, '175', '135');
INSERT INTO `question` VALUES ('2395', '假如某人很聪明,从别人身上骗取了一大笔钱,应该允许他拥有这笔钱。', '是|否', null, '176', '135');
INSERT INTO `question` VALUES ('2396', '如果没有报酬,就不要指望有谁会对社会服务。', '是|否', null, '177', '135');
INSERT INTO `question` VALUES ('2397', '我家里有好几个人的习惯,既给我添麻烦又添烦恼。', '是|否', null, '178', '135');
INSERT INTO `question` VALUES ('2398', '必须承认,对于学习新东西,我并没有很强的欲望。', '是|否', null, '179', '135');
INSERT INTO `question` VALUES ('2399', '好像没有人能理解我。', '是|否', null, '180', '135');
INSERT INTO `question` VALUES ('2400', '我常常自认为是周围人的领导。', '是|否', null, '181', '135');
INSERT INTO `question` VALUES ('2401', '老实人要在世界上获得成功,是根本不可能的。', '是|否', null, '182', '135');
INSERT INTO `question` VALUES ('2402', '我喜欢把一切安排得整整齐齐,井然有序。', '是|否', null, '183', '135');
INSERT INTO `question` VALUES ('2403', '我很讨厌自己的日常生活和工作被意外的事情打扰。', '是|否', null, '184', '135');
INSERT INTO `question` VALUES ('2404', '我觉得未来似乎毫无希望。', '是|否', null, '185', '135');
INSERT INTO `question` VALUES ('2405', '我过去的家庭生活总是很愉快。', '是|否', null, '186', '135');
INSERT INTO `question` VALUES ('2406', '我有理由嫉妒家里的某一两个人。', '是|否', null, '187', '135');
INSERT INTO `question` VALUES ('2407', '如果要以牺牲个人乐趣为代价,那我决不会有意地去帮助别人。', '是|否', null, '188', '135');
INSERT INTO `question` VALUES ('2408', '我参与的辩论或争吵多数是原则问题。', '是|否', null, '189', '135');
INSERT INTO `question` VALUES ('2409', null, '是|否', null, '190', '135');
INSERT INTO `question` VALUES ('2410', '一天到晚,我几乎总是口干舌燥。', '是|否', null, '191', '135');
INSERT INTO `question` VALUES ('2411', '假如过去从未上过学,多数人的经济状况要比现在好。', '是|否', null, '192', '135');
INSERT INTO `question` VALUES ('2412', '在辩论中,别人很容易把我驳倒。', '是|否', null, '193', '135');
INSERT INTO `question` VALUES ('2413', '我不喜欢事情总是变化不定、玄不可测。', '是|否', null, '194', '135');
INSERT INTO `question` VALUES ('2414', '我常饮酒过度。', '是|否', null, '195', '135');
INSERT INTO `question` VALUES ('2415', '过去,我想弃家出走。', '是|否', null, '196', '135');
INSERT INTO `question` VALUES ('2416', '生活常常对我很不公平。', '是|否', null, '197', '135');
INSERT INTO `question` VALUES ('2417', '我认为自己在事非问题上比多数人更严肃认真。', '是|否', null, '198', '135');
INSERT INTO `question` VALUES ('2418', null, '是|否', null, '199', '135');
INSERT INTO `question` VALUES ('2419', '我赞成从严加强法制,不论其后果如何。', '是|否', null, '200', '135');
INSERT INTO `question` VALUES ('2420', '人们常常在背后说我的坏话。', '是|否', null, '201', '135');
INSERT INTO `question` VALUES ('2421', '我有几种坏习气很根深蒂固,所以要想克服它们,只是白费劲儿。', '是|否', null, '202', '135');
INSERT INTO `question` VALUES ('2422', '我总想把自己的工作计划组织好。', '是|否', null, '203', '135');
INSERT INTO `question` VALUES ('2423', '一周有几次,由于胃酸过多,我感到不舒服。', '是|否', null, '204', '135');
INSERT INTO `question` VALUES ('2424', '我喜欢对别人加以指点,把工作开展起来。', '是|否', null, '205', '135');
INSERT INTO `question` VALUES ('2425', '我对家里几个人所做的那种工作,感到很难为情。', '是|否', null, '206', '135');
INSERT INTO `question` VALUES ('2426', '我觉得别人看上去比我幸福。', '是|否', null, '207', '135');
INSERT INTO `question` VALUES ('2427', '只要工资高,什么工作对我来说都很好。', '是|否', null, '208', '135');
INSERT INTO `question` VALUES ('2428', '我和不熟悉的人在一起感到难为情。', '是|否', null, '209', '135');
INSERT INTO `question` VALUES ('2429', '我的生活常常好像毫无意义。', '是|否', null, '210', '135');
INSERT INTO `question` VALUES ('2430', '年轻时,我有时偷别人的东西。', '是|否', null, '211', '135');
INSERT INTO `question` VALUES ('2431', '事情一旦不顺利,我就想马上打退堂鼓。', '是|否', null, '212', '135');
INSERT INTO `question` VALUES ('2432', '过去和我关系密切,同时是我在儿童时代最崇拜的人,是一位女性（母亲、姐妹、姑姨或其他女性）。', '是|否', null, '213', '135');
INSERT INTO `question` VALUES ('2433', '我常常感到内疚,因为我曾装作对某事后悔莫及,而实际上并非如此。', '是|否', null, '214', '135');
INSERT INTO `question` VALUES ('2434', '有几次,我生气极了。', '是|否', null, '215', '135');
INSERT INTO `question` VALUES ('2435', '小时候,我们家不像大多数人家那样安定、平静。', '是|否', null, '216', '135');
INSERT INTO `question` VALUES ('2436', '家里有些人做的事,使我胆颤心惊。', '是|否', null, '217', '135');
INSERT INTO `question` VALUES ('2437', '小时候上学时,我常给老师添许多麻烦。', '是|否', null, '218', '135');
INSERT INTO `question` VALUES ('2438', '假如工钱合理,我希望和一家马戏团或流动曲艺团一道巡回演出。', '是|否', null, '219', '135');
INSERT INTO `question` VALUES ('2439', '我有突然感到恶心、呕吐的毛病。', '是|否', null, '220', '135');
INSERT INTO `question` VALUES ('2440', '过去,我们一家相互之间总是亲热异常。', '是|否', null, '221', '135');
INSERT INTO `question` VALUES ('2441', '我常常在半夜里受到恐吓而惊醒。', '是|否', null, '222', '135');
INSERT INTO `question` VALUES ('2442', '许多人的毛病在于他们对事物不够认真。', '是|否', null, '223', '135');
INSERT INTO `question` VALUES ('2443', '我不是那种适合当政治领袖的人。', '是|否', null, '224', '135');
INSERT INTO `question` VALUES ('2444', '我父母过去从未真正理解过我。', '是|否', null, '225', '135');
INSERT INTO `question` VALUES ('2445', null, '是|否', null, '226', '135');
INSERT INTO `question` VALUES ('2446', '别人在做出决策之前,都似乎很自然地找我征求意见。', '是|否', null, '227', '135');
INSERT INTO `question` VALUES ('2447', '我对自己要求很高,并且觉得别人也该照着去做。', '是|否', null, '228', '135');
INSERT INTO `question` VALUES ('2448', '一个人假如谁也不信任,生活就会忧郁得多。', '是|否', null, '229', '135');
INSERT INTO `question` VALUES ('2449', '那些对事情缺乏信心、无把握的人,使我感到不舒服。', '是|否', null, '230', '135');
INSERT INTO `question` VALUES ('2740', '你是否有许多不同的业余爱好？', '是|不是', null, '1', '133');
INSERT INTO `question` VALUES ('2741', '你是否在做任何事情以前都要停下来仔细思考？', '是|不是', null, '2', '133');
INSERT INTO `question` VALUES ('2742', '你的心境是否常有起伏？', '是|不是', null, '3', '133');
INSERT INTO `question` VALUES ('2743', '你曾有过明知是别人的功劳而你去接受奖励的事吗？', '是|不是', null, '4', '133');
INSERT INTO `question` VALUES ('2744', '你是否健谈？', '是|不是', null, '5', '133');
INSERT INTO `question` VALUES ('2745', '欠债会使你不安吗？', '是|不是', null, '6', '133');
INSERT INTO `question` VALUES ('2746', '你曾无缘无故觉得\"真是难受\"吗？', '是|不是', null, '7', '133');
INSERT INTO `question` VALUES ('2747', '你曾贪图过分外之物吗？', '是|不是', null, '8', '133');
INSERT INTO `question` VALUES ('2748', '你是否在晚上小心翼翼地关好门窗？', '是|不是', null, '9', '133');
INSERT INTO `question` VALUES ('2749', '你是否比较活跃？', '是|不是', null, '10', '133');
INSERT INTO `question` VALUES ('2750', '你在见到小孩或动物受折磨时是否会感到非常难过？', '是|不是', null, '11', '133');
INSERT INTO `question` VALUES ('2751', '你是否常常为自己不该做而做了的事,不该说而说了的话而紧张吗？', '是|不是', null, '12', '133');
INSERT INTO `question` VALUES ('2752', '你喜欢跳降落伞吗？', '是|不是', null, '13', '133');
INSERT INTO `question` VALUES ('2753', '通常你能在热闹联欢会中尽情地玩吗？', '是|不是', null, '14', '133');
INSERT INTO `question` VALUES ('2754', '你容易激动吗？', '是|不是', null, '15', '133');
INSERT INTO `question` VALUES ('2755', '你曾经将自己的过错推给别人吗？', '是|不是', null, '16', '133');
INSERT INTO `question` VALUES ('2756', '你喜欢会见陌生人吗？', '是|不是', null, '17', '133');
INSERT INTO `question` VALUES ('2757', '你是否相信保险制度是一种好办法？', '是|不是', null, '18', '133');
INSERT INTO `question` VALUES ('2758', '你是一个容易伤感情的人吗？', '是|不是', null, '19', '133');
INSERT INTO `question` VALUES ('2759', '你所有的习惯都是好的吗？', '是|不是', null, '20', '133');
INSERT INTO `question` VALUES ('2760', '在社交场合你是否总不愿露头角？', '是|不是', null, '21', '133');
INSERT INTO `question` VALUES ('2761', '你会服用奇异或危险作用的药物吗？', '是|不是', null, '22', '133');
INSERT INTO `question` VALUES ('2762', '你常有\"厌倦\"之感吗？', '是|不是', null, '23', '133');
INSERT INTO `question` VALUES ('2763', '你曾拿过别人的东西吗（哪怕一针一线）？', '是|不是', null, '24', '133');
INSERT INTO `question` VALUES ('2764', '你是否常爱外出？', '是|不是', null, '25', '133');
INSERT INTO `question` VALUES ('2765', '你是否从伤害你所宠爱的人中而感到乐趣？', '是|不是', null, '26', '133');
INSERT INTO `question` VALUES ('2766', '你常为有罪恶之感所苦恼吗？', '是|不是', null, '27', '133');
INSERT INTO `question` VALUES ('2767', '你在谈论中是否有时不懂装懂？', '是|不是', null, '28', '133');
INSERT INTO `question` VALUES ('2768', '你是否宁愿去看书而不愿去多见人？', '是|不是', null, '29', '133');
INSERT INTO `question` VALUES ('2769', '你有要伤害你的仇人吗？', '是|不是', null, '30', '133');
INSERT INTO `question` VALUES ('2770', '你觉得自己是一个神经过敏的人吗？', '是|不是', null, '31', '133');
INSERT INTO `question` VALUES ('2771', '对人有所失礼时你是否经常要表示歉意？', '是|不是', null, '32', '133');
INSERT INTO `question` VALUES ('2772', '你有许多朋友吗？', '是|不是', null, '33', '133');
INSERT INTO `question` VALUES ('2773', '你是否喜爱讲些有时确能伤害人的笑话？', '是|不是', null, '34', '133');
INSERT INTO `question` VALUES ('2774', '你是一个多忧多虑的人吗？', '是|不是', null, '35', '133');
INSERT INTO `question` VALUES ('2775', '你在童年是否按照吩咐要做什么便做什么,毫无怨言？', '是|不是', null, '36', '133');
INSERT INTO `question` VALUES ('2776', '你认为你是一个乐天派吗？', '是|不是', null, '37', '133');
INSERT INTO `question` VALUES ('2777', '你很讲究礼貌和整洁吗？', '是|不是', null, '38', '133');
INSERT INTO `question` VALUES ('2778', '你是否总在担心会发生可怕的事情？', '是|不是', null, '39', '133');
INSERT INTO `question` VALUES ('2779', '你曾损坏或遗失过别人的东西吗？', '是|不是', null, '40', '133');
INSERT INTO `question` VALUES ('2780', '交新朋友时一般是你采取主动吗？', '是|不是', null, '41', '133');
INSERT INTO `question` VALUES ('2781', '当别人向你诉苦时,你是否容易理解他们的苦衷？', '是|不是', null, '42', '133');
INSERT INTO `question` VALUES ('2782', '你认为自己很紧张,如同\"拉紧的弦\"一样吗？', '是|不是', null, '43', '133');
INSERT INTO `question` VALUES ('2783', '在没有废纸篓时,你是否将废纸扔在地板上？', '是|不是', null, '44', '133');
INSERT INTO `question` VALUES ('2784', '当你与别人在一起时,你是否言语很少？', '是|不是', null, '45', '133');
INSERT INTO `question` VALUES ('2785', '你是否认为结婚制度是过时了,应该废止？', '是|不是', null, '46', '133');
INSERT INTO `question` VALUES ('2786', '你是否有时感到自己可怜？', '是|不是', null, '47', '133');
INSERT INTO `question` VALUES ('2787', '你是否有时有点自夸？', '是|不是', null, '48', '133');
INSERT INTO `question` VALUES ('2788', '你是否很容易将一个沉寂的集会搞得活跃起来？', '是|不是', null, '49', '133');
INSERT INTO `question` VALUES ('2789', '你是否讨厌那种小心翼翼地开车的人？', '是|不是', null, '50', '133');
INSERT INTO `question` VALUES ('2790', '你为你的健康担忧吗？', '是|不是', null, '51', '133');
INSERT INTO `question` VALUES ('2791', '你曾讲过什么人的坏话吗？', '是|不是', null, '52', '133');
INSERT INTO `question` VALUES ('2792', '你是否喜欢对朋友讲笑话和有趣的故事？', '是|不是', null, '53', '133');
INSERT INTO `question` VALUES ('2793', '你小时候曾对父母粗暴无礼吗？', '是|不是', null, '54', '133');
INSERT INTO `question` VALUES ('2794', '你是否喜欢与人混在一起？', '是|不是', null, '55', '133');
INSERT INTO `question` VALUES ('2795', '你若知道自己工作有错误,这会使你感到难过吗？', '是|不是', null, '56', '133');
INSERT INTO `question` VALUES ('2796', '你患失眠吗？', '是|不是', null, '57', '133');
INSERT INTO `question` VALUES ('2797', '你吃饭前必定洗手吗？', '是|不是', null, '58', '133');
INSERT INTO `question` VALUES ('2798', '你常无缘无故感到无精打采和倦怠吗？', '是|不是', null, '59', '133');
INSERT INTO `question` VALUES ('2799', '和别人玩游戏时,你有过欺骗行为吗？', '是|不是', null, '60', '133');
INSERT INTO `question` VALUES ('2800', '你是否喜欢从事一些动作迅速的工作？', '是|不是', null, '61', '133');
INSERT INTO `question` VALUES ('2801', '你的母亲是一位善良的妇人吗？', '是|不是', null, '62', '133');
INSERT INTO `question` VALUES ('2802', '你是否常常觉得人生非常无味？', '是|不是', null, '63', '133');
INSERT INTO `question` VALUES ('2803', '你曾利用过某人为自己取得好处吗？', '是|不是', null, '64', '133');
INSERT INTO `question` VALUES ('2804', '你是否常常参加许多活动,超过你的时间所允许？', '是|不是', null, '65', '133');
INSERT INTO `question` VALUES ('2805', '是否有几个人总在躲避你？', '是|不是', null, '66', '133');
INSERT INTO `question` VALUES ('2806', '你是否为你的容貌而非常烦恼？', '是|不是', null, '67', '133');
INSERT INTO `question` VALUES ('2807', '你是否觉得人们为了未来有保障而办理储蓄和保险所花的时间太多？', '是|不是', null, '68', '133');
INSERT INTO `question` VALUES ('2808', '你曾有过不如死了为好的愿望吗？', '是|不是', null, '69', '133');
INSERT INTO `question` VALUES ('2809', '如果有把握永远不会被别人发现,你会逃税吗？', '是|不是', null, '70', '133');
INSERT INTO `question` VALUES ('2810', '你能使一个集会顺利进行吗？', '是|不是', null, '71', '133');
INSERT INTO `question` VALUES ('2811', '你能克制自己不对人无礼吗？', '是|不是', null, '72', '133');
INSERT INTO `question` VALUES ('2812', '遇到一次难堪的经历后,你是否在一段很长的时间内还感到难受？', '是|不是', null, '73', '133');
INSERT INTO `question` VALUES ('2813', '你患有\"神经过敏\"吗？', '是|不是', null, '74', '133');
INSERT INTO `question` VALUES ('2814', '你曾经故意说些什么来伤害别人的感情吗？', '是|不是', null, '75', '133');
INSERT INTO `question` VALUES ('2815', '你与别人的友谊是否容易破裂,虽然不是你的过错？', '是|不是', null, '76', '133');
INSERT INTO `question` VALUES ('2816', '你常感到孤单吗？', '是|不是', null, '77', '133');
INSERT INTO `question` VALUES ('2817', '当人家寻你的差错,找你工作中的缺点时,你是否容易在精神上受挫伤？', '是|不是', null, '78', '133');
INSERT INTO `question` VALUES ('2818', '你赴约会或上班曾迟到过吗？', '是|不是', null, '79', '133');
INSERT INTO `question` VALUES ('2819', '你喜欢忙忙碌碌地过日子吗？', '是|不是', null, '80', '133');
INSERT INTO `question` VALUES ('2820', '你愿意别人怕你吗？', '是|不是', null, '81', '133');
INSERT INTO `question` VALUES ('2821', '你是否觉得有时浑身是劲,而有时又是懒洋洋的吗？', '是|不是', null, '82', '133');
INSERT INTO `question` VALUES ('2822', '你有时把今天应做的事拖到明天去做吗？', '是|不是', null, '83', '133');
INSERT INTO `question` VALUES ('2823', '别人认为你是生气勃勃吗？', '是|不是', null, '84', '133');
INSERT INTO `question` VALUES ('2824', '别人是否对你说了许多谎话？', '是|不是', null, '85', '133');
INSERT INTO `question` VALUES ('2825', '你是否容易对某些事物容易冒火？', '是|不是', null, '86', '133');
INSERT INTO `question` VALUES ('2826', '当你犯了错误时,你是否常常愿意承认它？', '是|不是', null, '87', '133');
INSERT INTO `question` VALUES ('2827', '你会为一动物落入圈套被捉拿而感到很难过吗？', '是|不是', null, '88', '133');
INSERT INTO `question` VALUES ('3539', '我很明了本测验的说明:', 'A.是的|B.不一定|C.不是的', null, '1', '134');
INSERT INTO `question` VALUES ('3540', '我对本测验每个问题都会按自己的真实情况作答:', 'A.是的|B.不一定|C.不同意', null, '2', '134');
INSERT INTO `question` VALUES ('3541', '有度假机会时,我宁愿:', 'A.去一个繁华的都市|B.介乎A与C之间|C.闲居清静而偏僻的郊区', null, '3', '134');
INSERT INTO `question` VALUES ('3542', '我有足够的能力应付困难:', 'A.是的|B.不确定|C.不是的', null, '4', '134');
INSERT INTO `question` VALUES ('3543', '即使是关在铁笼内的猛兽,我见了也会惴惴不安:', 'A.是的|B.不一定|C.不是的', null, '5', '134');
INSERT INTO `question` VALUES ('3544', '我总避免批评别人的言行:', 'A.是的|B.有时如此|C.不是的', null, '6', '134');
INSERT INTO `question` VALUES ('3545', '我的思想似乎:', 'A.走在了时代前面|B.不一定|C.正符合时代', null, '7', '134');
INSERT INTO `question` VALUES ('3546', '我不擅长说笑话讲趣事:', 'A.是的|B.介乎A与C之间|C.不是的', null, '8', '134');
INSERT INTO `question` VALUES ('3547', '当我看到亲友邻居争执时,我总是:', 'A.任其自己解决|B.置之不理|C.予以劝解', null, '9', '134');
INSERT INTO `question` VALUES ('3548', '在社交场合中,我:', 'A.谈吐自然|B.介乎A与C之间|C.退避三舍,保持沉默', null, '10', '134');
INSERT INTO `question` VALUES ('3549', '我愿做一名:', 'A.建筑工程师|B.不确定|C.社会科学的教员', null, '11', '134');
INSERT INTO `question` VALUES ('3550', '阅读时,我宁愿选读:', 'A.著名的宗教教义|B.不确定|C.国家政治组织的理论', null, '12', '134');
INSERT INTO `question` VALUES ('3551', '我相信许多人都有些心理不正常，但他们都不愿意这样承认:', 'A.是的|B.介乎A与C之间|C.不是的', null, '13', '134');
INSERT INTO `question` VALUES ('3552', '我所希望的结婚对象应擅长交际而无须有文艺才能:', 'A.是的|B.不一定|C.不是的', null, '14', '134');
INSERT INTO `question` VALUES ('3553', '对于头脑简单和不讲理的人,我仍然能待之以礼:', 'A.是的|B.介乎A与C之间|C.不是的', null, '15', '134');
INSERT INTO `question` VALUES ('3554', '受人侍奉时我常感到不安:', 'A.是的|B.介乎A与C之间|C.不是的', null, '16', '134');
INSERT INTO `question` VALUES ('3555', '从事体力或脑力劳动后，我比平常人需要更多的休息才能恢复工作效率:', 'A.是的|B.介乎A与C之间|C.不是的', null, '17', '134');
INSERT INTO `question` VALUES ('3556', '半夜醒来,我会为种种忧虑而不能再入眠:', 'A.常常如此|B.有时如此|C.极少如此', null, '18', '134');
INSERT INTO `question` VALUES ('3557', '事情进行不顺利时,我常会急得掉眼泪:', 'A.从不如此|B.有时如此|C.常常如此', null, '19', '134');
INSERT INTO `question` VALUES ('3558', '我认为只要双方同意就可以离婚，不应当受传统礼教的束缚:', 'A.是的|B.介乎A与C之间|C.不是的', null, '20', '134');
INSERT INTO `question` VALUES ('3559', '我对于人或物的兴趣都很容易改变:', 'A.是的|B.介乎A与C之间|C.不是的', null, '21', '134');
INSERT INTO `question` VALUES ('3560', '筹划事务时,我宁愿:', 'A.和别人合作|B.不确定|C.自己单独进行', null, '22', '134');
INSERT INTO `question` VALUES ('3561', '我常会无端地自言自语:', 'A.常常如此|B.偶然如此|C.从不如此', null, '23', '134');
INSERT INTO `question` VALUES ('3562', '无论工作、饮食或出游,我总:', 'A.很匆忙,不能尽兴|B.介乎A与C之间|C.很从容不迫', null, '24', '134');
INSERT INTO `question` VALUES ('3563', '有时我会怀疑别人是否对我的言谈真正有兴趣:', 'A.是的|B.介乎A与C之间|C.不是的', null, '25', '134');
INSERT INTO `question` VALUES ('3564', '在工厂中,我宁愿负责:', 'A.机械组|B.介乎A与C之间|C.人事组', null, '26', '134');
INSERT INTO `question` VALUES ('3565', '在阅读时,我宁愿选读:', 'A.太空旅行|B.不确定|C.家庭教育', null, '27', '134');
INSERT INTO `question` VALUES ('3566', '下列三个字中哪个字与其它两个字属于不同类别:', 'A.狗|B.石|C.牛', null, '28', '134');
INSERT INTO `question` VALUES ('3567', '如果我能重新做人,我要:', 'A.把生活安排得和以前不同|B.不确定|C.生活得和以前相仿', null, '29', '134');
INSERT INTO `question` VALUES ('3568', '在我的一生中,我总能达到我所预期的目标:', 'A.是的|B.不确定|C.不是的', null, '30', '134');
INSERT INTO `question` VALUES ('3569', '当我说谎时,我总觉得内心不安,不敢正视对方:', 'A.是的|B.不一定|C.不是的', null, '31', '134');
INSERT INTO `question` VALUES ('3570', '假使我手持一支装有子弹的手枪，我必须取出子弹后才能心安:', 'A.是的|B.介乎A与C之间|C.不是的', null, '32', '134');
INSERT INTO `question` VALUES ('3571', '朋友们大都认为我是一个说话有风趣的人:', 'A.是的|B.不一定|C.不是的', null, '33', '134');
INSERT INTO `question` VALUES ('3572', '如果人们知道我的内心世界,他们都会感到惊讶:', 'A.是的|B.不一定|C.不是的', null, '34', '134');
INSERT INTO `question` VALUES ('3573', '在社交场合中,如果我突然成为众所注意的中心,我会感到局促不安:', 'A.是的|B.介乎A与C之间|C.不是的', null, '35', '134');
INSERT INTO `question` VALUES ('3574', '我总喜欢参加规模庞大的聚会、舞会或公共集会:', 'A.是的|B.介乎A与C之间|C.不是的', null, '36', '134');
INSERT INTO `question` VALUES ('3575', '在下列工作中,我喜欢的是:', 'A.音乐|B.不确定|C.手工', null, '37', '134');
INSERT INTO `question` VALUES ('3576', '我常常怀疑那些过于友善的人动机是否如此:', 'A.是的|B.介乎A与C之间|C.不是的', null, '38', '134');
INSERT INTO `question` VALUES ('3577', '我宁愿自己的生活像:', 'A.一个艺人或博物学家|B.不确定|C.会计师或保险公司的经纪人', null, '39', '134');
INSERT INTO `question` VALUES ('3578', '目前世界所需要的是:', 'A.多产生一些富有改善世界计划的理想家|B.不确定|C.脚踏实地的可靠公民', null, '40', '134');
INSERT INTO `question` VALUES ('3579', '有时候我觉得我需要做剧烈的体力活动:', 'A.是的|B.介乎A与C之间|C.不是的', null, '41', '134');
INSERT INTO `question` VALUES ('3580', '我愿意与有礼貌有教养的人来往，而不愿和粗鲁野蛮的人为伍:', 'A.是的|B.介乎A与C之间|C.不是的', null, '42', '134');
INSERT INTO `question` VALUES ('3581', '在处理一些必须凭借智慧的事务中,我的父母的确:', 'A.较一般人差|B.普通|C.超人一等', null, '43', '134');
INSERT INTO `question` VALUES ('3582', '当上司(或教师)召见我时,我:', 'A.总觉得可以趁机会提出建议|B.介乎A与C之间|C.总怀疑自己做错了什么事', null, '44', '134');
INSERT INTO `question` VALUES ('3583', '假使薪俸优厚,我愿意专任照料精神病人的职务:', 'A.是的|B.介乎A与C之间|C.不是的', null, '45', '134');
INSERT INTO `question` VALUES ('3584', '看报时,我喜欢读:', 'A.当前世界基本社会问题的辩论|B.介乎A与C之间|C.地方新闻的报道', null, '46', '134');
INSERT INTO `question` VALUES ('3585', '我曾担任过:', 'A.一般职务|B.多种职务|C.非常多的职务', null, '47', '134');
INSERT INTO `question` VALUES ('3586', '逛街时,我宁愿观看一个画家写生,而不愿听人家的辩论:', 'A.是的|B.不一定|C.不是的', null, '48', '134');
INSERT INTO `question` VALUES ('3587', '我的神经脆弱,稍有刺激的声音就会使我害怕:', 'A.时常如此|B.有时如此|C.从未如此', null, '49', '134');
INSERT INTO `question` VALUES ('3588', '我在清晨起身时,就常常感到疲乏不堪:', 'A.是的|B.介乎A与C之间|C.不是的', null, '50', '134');
INSERT INTO `question` VALUES ('3589', '我宁愿是一个:', 'A.管森林的工作人员|B.不确定|C.中小学教员', null, '51', '134');
INSERT INTO `question` VALUES ('3590', '每逢年节或亲友生日,我:', 'A.喜欢互相赠送礼物|B.不太确定|C.觉得交换礼物是麻烦多事', null, '52', '134');
INSERT INTO `question` VALUES ('3591', '下列数字中,哪个数字与其他两个数字属于不同类别:', 'A.  5|B.  2|C.  7', null, '53', '134');
INSERT INTO `question` VALUES ('3592', '[猫]与[鱼]就如同[牛]与:', 'A.牛乳|B.牧草|C.盐', null, '54', '134');
INSERT INTO `question` VALUES ('3593', '在做人处事的各个方面,我的父母很值得敬佩:', 'A.是的|B.不一定|C.不是的', null, '55', '134');
INSERT INTO `question` VALUES ('3594', '我觉得我有一些别人所不及的优良品质:', 'A.是的|B.不一定|C.不是的', null, '56', '134');
INSERT INTO `question` VALUES ('3595', '只要有利于大家,尽管别人认为卑贱的工作,我也乐而为之,不以为耻:', 'A.是的|B.不确定|C.不是的', null, '57', '134');
INSERT INTO `question` VALUES ('3596', '我喜欢看电影或参加其他娱乐活动:', 'A.每周一次以上(比一般人多)|B.每周一次(与通常人相似)|C.偶然一次(比通常人少)', null, '58', '134');
INSERT INTO `question` VALUES ('3597', '我喜欢从事需要精确技术的工作:', 'A.是的|B.介乎A与C之间|C.不是的', null, '59', '134');
INSERT INTO `question` VALUES ('3598', '在有思想,有地位的长者面前,我总较为缄默:', 'A.是的|B.介乎A与C之间|C.不是的', null, '60', '134');
INSERT INTO `question` VALUES ('3599', '就我来说,在大众前演讲或表演是一件不容易的事:', 'A.是的|B.介乎A与C之间|C.不是的', null, '61', '134');
INSERT INTO `question` VALUES ('3600', '我宁愿:', 'A.指挥几个人工作|B.不确定|C.和团体共同工作', null, '62', '134');
INSERT INTO `question` VALUES ('3601', '纵使我做了一桩贻笑大方的事，我也仍然能够将它淡然忘却:', 'A.是的|B.介乎A与C之间|C.不是的', null, '63', '134');
INSERT INTO `question` VALUES ('3602', '没有人会幸灾乐祸地希望我遭遇困难:', 'A.是的|B.不确定|C.不是的', null, '64', '134');
INSERT INTO `question` VALUES ('3603', '堂堂男子汉应该:', 'A.考虑人生的意义|B.不确定|C.谋家庭的温饱', null, '65', '134');
INSERT INTO `question` VALUES ('3604', '我喜欢解决别人已弄得一塌糊涂的问题:', 'A.是的|B.介乎A与C之间|C.不是的', null, '66', '134');
INSERT INTO `question` VALUES ('3605', '我十分高兴的时候总有[好景不常]之感:', 'A.是的|B.介乎A与C之间|C.不是的', null, '67', '134');
INSERT INTO `question` VALUES ('3606', '在一般困难处境下,我总能保持乐观:', 'A.是的|B.不一定|C.不是的', null, '68', '134');
INSERT INTO `question` VALUES ('3607', '迁居是一桩极不愉快的事:', 'A.是的|B.介乎A与C之间|C.不是的', null, '69', '134');
INSERT INTO `question` VALUES ('3608', '在我年轻的时候,如果我和父母的意见不同,我经常:', 'A.坚持自己的意见|B.介乎A与C之间|C.接受他们的意见', null, '70', '134');
INSERT INTO `question` VALUES ('3609', '我希望我的爱人能够使家庭:', 'A.有其本身的欢乐与活动|B.介乎A与C之间|C.成为邻里社交活动的一部分', null, '71', '134');
INSERT INTO `question` VALUES ('3610', '我解决问题多数依靠:', 'A.个人独立思考|B.介乎A与C之间|C.与人互相讨论', null, '72', '134');
INSERT INTO `question` VALUES ('3611', '需要[当机立断]时,我总:', 'A.镇静地运用理智|B.介乎A与C之间|C.常常紧张兴奋,不能冷静思考', null, '73', '134');
INSERT INTO `question` VALUES ('3612', '最近,在一两桩事情上,我觉得自己是无辜受累:', 'A.是的|B.介乎A与C之间|C.不是的', null, '74', '134');
INSERT INTO `question` VALUES ('3613', '我善于控制我的表情:', 'A.是的|B.介乎A与C之间|C.不是的', null, '75', '134');
INSERT INTO `question` VALUES ('3614', '如果薪俸相等,我宁愿做:', 'A.一个化学研究师|B.不确定|C.旅行社经理', null, '76', '134');
INSERT INTO `question` VALUES ('3615', '[惊讶]与[新奇]犹如[惧怕]与:', 'A.勇敢|B.焦虑|C.恐怖', null, '77', '134');
INSERT INTO `question` VALUES ('3616', '下列三个分数中,哪一个与其他两个属不同类别:', 'A.  3/7|B.  3/9|C.  3/11', null, '78', '134');
INSERT INTO `question` VALUES ('3617', '不知什么缘故,有些人故意回避或冷淡我:', 'A.是的|B.不一定|C.不是的', null, '79', '134');
INSERT INTO `question` VALUES ('3618', '我虽善意待人,却得不到好报:', 'A.是的|B.不一定|C.不是的', null, '80', '134');
INSERT INTO `question` VALUES ('3619', '我不喜欢那些夜郎自大,目空一切的人:', 'A.是的|B.介乎A与C之间|C.不是的', null, '81', '134');
INSERT INTO `question` VALUES ('3620', '和一般人相比,我的朋友的确太少:', 'A.是的|B.介乎A与C之间|C.不是的', null, '82', '134');
INSERT INTO `question` VALUES ('3621', '出于万不得已时,我才参加社交集会,否则我总设法回避:', 'A.是的|B.不一定|C.不是的', null, '83', '134');
INSERT INTO `question` VALUES ('3622', '在服务机关中,对上级的逢迎得当,比工作上的表现更为重要:', 'A.是的|B.介乎A与C之间|C.不是的', null, '84', '134');
INSERT INTO `question` VALUES ('3623', '参加竞赛时,我看重的是竞赛活动,而不计较其成败:', 'A.总是如此|B.一般如此|C.偶然如此', null, '85', '134');
INSERT INTO `question` VALUES ('3624', '我宁愿我所就的职业有:', 'A.固定可靠的薪水|B.介乎A与C之间|C.薪资高低能随我工作的表现而随时调整', null, '86', '134');
INSERT INTO `question` VALUES ('3625', '我宁愿阅读:', 'A.军事与政治的事实记载|B.不一定|C.一部富有情感与幻想的作品', null, '87', '134');
INSERT INTO `question` VALUES ('3626', '有许多人不敢欺骗或犯罪,主要原因是怕受到惩罚:', 'A.是的|B.介乎A与C之间|C.不是的', null, '88', '134');
INSERT INTO `question` VALUES ('3627', '我的父母(或保护人)从未很严格地要我事事顺从:', 'A.是的|B.不一定|C.不是的', null, '89', '134');
INSERT INTO `question` VALUES ('3628', '[百折不挠][再接再厉]的精神似乎完全被现代人忽视了:', 'A.是的|B.不一定|C.不是的', null, '90', '134');
INSERT INTO `question` VALUES ('3629', '如果有人对我发怒,我总:', 'A.设法使他镇静下来|B.不太确定|C.也会恼怒起来', null, '91', '134');
INSERT INTO `question` VALUES ('3630', '我希望大家都提倡:', 'A.多吃水果以避免杀生|B.不一定|C.发展农业捕灭对农产品有害的动物', null, '92', '134');
INSERT INTO `question` VALUES ('3631', '无论在极高的屋顶上或极深的隧道中，我很少觉得胆怯不安:', 'A.是的|B.介乎A与C之间|C.不是的', null, '93', '134');
INSERT INTO `question` VALUES ('3632', '我只要没有过错,不管人家怎样归咎于我,我总能心安理得:', 'A.是的|B.不一定|C.不是的', null, '94', '134');
INSERT INTO `question` VALUES ('3633', '凡是无法运用理智来解决的问题，有时就不得不靠权力来处理:', 'A.是的|B.介乎A与C之间|C.不是的', null, '95', '134');
INSERT INTO `question` VALUES ('3634', '我十六、七岁时与异性朋友的交游:', 'A.极多|B.介乎A与C之间|C.不很多', null, '96', '134');
INSERT INTO `question` VALUES ('3635', '我在交际场所参加的组织中是一个活跃分子:', 'A.是的|B.介乎A与C之间|C.不是的', null, '97', '134');
INSERT INTO `question` VALUES ('3636', '在人声嘈杂中,我仍能不受妨碍,专心工作:', 'A.是的|B.介乎A与C之间|C.不是的', null, '98', '134');
INSERT INTO `question` VALUES ('3637', '在某环境下,我常因困惑引起幻想而将工作搁置下来:', 'A.是的|B.介乎A与C之间|C.不是的', null, '99', '134');
INSERT INTO `question` VALUES ('3638', '我很少用难堪的话去中伤别人的感情:', 'A.是的|B.不太确定|C.不是的', null, '100', '134');
INSERT INTO `question` VALUES ('3639', '我更愿意做一名:', 'A.商店经理|B.不确定|C.建筑师', null, '101', '134');
INSERT INTO `question` VALUES ('3640', '[理不胜辞]的意思是:', 'A.理不如辞|B.理多而辞寡|C.辞藻丰富而理由不足', null, '102', '134');
INSERT INTO `question` VALUES ('3641', '[锄头]与[挖掘]犹如[刀子]与:', 'A.雕刻|B.切剖|C.铲除', null, '103', '134');
INSERT INTO `question` VALUES ('3642', '我常横过街道,以回避我不愿招乎的人:', 'A.很少如此|B.偶然如此|C.有时如此', null, '104', '134');
INSERT INTO `question` VALUES ('3643', '在我倾听音乐时,如果人家高谈阔论:', 'A.我仍然能够专心听,不受影响|B.介乎A与C之间|C.我会不能专心欣赏而感到恼恐', null, '105', '134');
INSERT INTO `question` VALUES ('3644', '在课堂上,如果我的意见与教师不同,我常:', 'A.保持缄默|B.不一定|C.当场表明立场', null, '106', '134');
INSERT INTO `question` VALUES ('3645', '我和异性友伴交谈时, 竭力避免涉及有关 [性] 的话题:', 'A.是的|B.介乎A与C之间|C.不是的', null, '107', '134');
INSERT INTO `question` VALUES ('3646', '我待人接物的确不太成功:', 'A.是的|B.不尽然|C.不是的', null, '108', '134');
INSERT INTO `question` VALUES ('3647', '每当考虑困难问题时,我总是:', 'A.一切都未雨绸缪|B.介乎A与C之间|C.相信到时候会自然解决', null, '109', '134');
INSERT INTO `question` VALUES ('3648', '我所结交的朋友中,男女各占一半:', 'A.是的|B.介乎A与C之间|C.不是的', null, '110', '134');
INSERT INTO `question` VALUES ('3649', '我宁可:', 'A.结识很多的人|B.不一定|C.维持几个深交的朋友', null, '111', '134');
INSERT INTO `question` VALUES ('3650', '我宁为哲学家,而不做机械工程师:', 'A.是的|B.不确定|C.不是的', null, '112', '134');
INSERT INTO `question` VALUES ('3651', '如果我发现某人自私不义，我总不计一切指摘他的弱点:', 'A.是的|B.介乎A与C之间|C.不是的', null, '113', '134');
INSERT INTO `question` VALUES ('3652', '我善用心机去影响同伴,使他们能协助我实现目标:', 'A.是的|B.介乎A与C之间|C.不是的', null, '114', '134');
INSERT INTO `question` VALUES ('3653', '我喜欢做戏剧、音乐、歌剧等新闻采访工作:', 'A.是的|B.不一定|C.不是的', null, '115', '134');
INSERT INTO `question` VALUES ('3654', '当人们颂扬我时,我总觉得不好意思:', 'A.是的|B.介乎A与C之间|C.不是的', null, '116', '134');
INSERT INTO `question` VALUES ('3655', '我以为现代最需要解决的问题是:', 'A.政治纠纷|B.不太确定|C.道德标准的有无', null, '117', '134');
INSERT INTO `question` VALUES ('3656', '我有时会无故地产生一种面临横祸的恐惧:', 'A.是的|B.有时如此|C.不是的', null, '118', '134');
INSERT INTO `question` VALUES ('3657', '我在童年时,害怕黑暗的次数:', 'A.极多|B.不太多|C.没有', null, '119', '134');
INSERT INTO `question` VALUES ('3658', '黄昏闲暇,我喜欢:', 'A.看一部历史探险影片|B.不一定|C.念一本科学幻想小说', null, '120', '134');
INSERT INTO `question` VALUES ('3659', '当人们批评我古怪时,我觉得:', 'A.非常气恼|B.有些动气|C.无所谓', null, '121', '134');
INSERT INTO `question` VALUES ('3660', '在一个陌生的城市找住址时,我经常:', 'A.就人问路|B.介乎A与C之间|C.参考市区地图', null, '122', '134');
INSERT INTO `question` VALUES ('3661', '朋友们申言要在家休息时,我仍设法怂恿他们外出:', 'A.是的|B.不一定|C.不是的', null, '123', '134');
INSERT INTO `question` VALUES ('3662', '在就寝时,我:', 'A.不易入睡|B.介乎A与C之间|C.极容易入睡', null, '124', '134');
INSERT INTO `question` VALUES ('3663', '有人烦扰我时,我:', 'A.能不露生色|B.介乎A与C之间|C.要说给别人听,以泄气愤', null, '125', '134');
INSERT INTO `question` VALUES ('3664', '如果薪俸相等,我宁愿做一个:', 'A.律师|B.不确定|C.飞行员或航海员', null, '126', '134');
INSERT INTO `question` VALUES ('3665', '时间永恒是比喻:', 'A.时间过得很慢|B.忘了时间|C.光阴一去不复返', null, '127', '134');
INSERT INTO `question` VALUES ('3666', '下列三项记号中,哪一项应紧接:*OOOO**OOO***', 'A.  *O*|B.  OO*|C.  O**', null, '128', '134');
INSERT INTO `question` VALUES ('3667', '在陌生的地方,我仍能清楚地辩别东西南北的方向:', 'A.是的|B.介乎A与C之间|C.不是的', null, '129', '134');
INSERT INTO `question` VALUES ('3668', '我的确比一般人幸运,因为我能从事自己所乐的工作:', 'A.是的|B.不一定|C.不是的', null, '130', '134');
INSERT INTO `question` VALUES ('3669', '如果我急于想借用别人的东西而物主恰又不在，我认为不告而取亦无大碍:', 'A.是的|B.介乎A与C之间|C.不是的', null, '131', '134');
INSERT INTO `question` VALUES ('3670', '我喜欢向友人追述一些已往有趣的社交经验:', 'A.是的|B.介乎A与C之间|C.不是的', null, '132', '134');
INSERT INTO `question` VALUES ('3671', '我更愿意做一名:', 'A.演员|B.不确定|C.建筑师', null, '133', '134');
INSERT INTO `question` VALUES ('3672', '工作学习之余,我总要安排计划,不使时间浪费:', 'A.是的|B.介乎A与C之间|C.不是的', null, '134', '134');
INSERT INTO `question` VALUES ('3673', '与人交际时,我常会无端地产生一种自卑感:', 'A.是的|B.介乎A与C之间|C.不是的', null, '135', '134');
INSERT INTO `question` VALUES ('3674', '主动与陌生人交谈:', 'A.是一桩难事|B.介乎A与C之间|C.毫无困难', null, '136', '134');
INSERT INTO `question` VALUES ('3675', '我喜欢的音乐,多数是:', 'A.轻快活泼|B.介乎A与C之间|C.富于情感', null, '137', '134');
INSERT INTO `question` VALUES ('3676', '我爱做[白日梦]即[完全沉浸于幻想之中]:', 'A.是的|B.不一定|C.不是的', null, '138', '134');
INSERT INTO `question` VALUES ('3677', '未来二十年的世界局势定将好:', 'A.是的|B.不一定|C.不是的', null, '139', '134');
INSERT INTO `question` VALUES ('3678', '童年时,我喜欢阅读:', 'A.战争故事|B.不确定|C.神仙幻想故事', null, '140', '134');
INSERT INTO `question` VALUES ('3679', '我素来对机械、汽车、飞机等有兴趣:', 'A.是的|B.介乎A与C之间|C.不是的', null, '141', '134');
INSERT INTO `question` VALUES ('3680', '我愿意做一个缓刑释放罪犯的管理监视人:', 'A.是的|B.介乎A与C之间|C.不是的', null, '142', '134');
INSERT INTO `question` VALUES ('3681', '人们认为我只不过是一个能苦干,稍有成就的人而已:', 'A.是的|B.介乎A与C之间|C.不是的', null, '143', '134');
INSERT INTO `question` VALUES ('3682', '在逆境中,我总能保持精神振奋:', 'A.是的|B.不太确定|C.不是的', null, '144', '134');
INSERT INTO `question` VALUES ('3683', '我以为人工节育是解决世界经济与和平问题的要诀:', 'A.是的|B.不确定|C.不是的', null, '145', '134');
INSERT INTO `question` VALUES ('3684', '我喜欢独自筹划，避免人家的干涉和猜疑:', 'A.是的|B.介乎A与C之间|C.不是的', null, '146', '134');
INSERT INTO `question` VALUES ('3685', '我相信[上司不可能没有过错,但他仍有权做当权者]:', 'A.是的|B.不一定|C.不是的', null, '147', '134');
INSERT INTO `question` VALUES ('3686', '我总设法使自己不粗心大意,忽略细节:', 'A.是的|B.介乎A与C之间|C.不是的', null, '148', '134');
INSERT INTO `question` VALUES ('3687', '与人争辩或险遭事故后，我常发抖，精疲力竭，不能安心工作:', 'A.是的|B.介乎A与C之间|C.不是的', null, '149', '134');
INSERT INTO `question` VALUES ('3688', '没有医生处方,我从不乱用药:', 'A.是的|B.介乎A与C之间|C.不是的', null, '150', '134');
INSERT INTO `question` VALUES ('3689', '为了培养个人的兴趣,我愿意参加:', 'A.摄影组|B.不确定|C.辩论会', null, '151', '134');
INSERT INTO `question` VALUES ('3690', '星火燎原对等于姑息:', 'A.同情|B.养奸|C.纵容', null, '152', '134');
INSERT INTO `question` VALUES ('3691', '[钟表]与[时间]犹如[裁缝]与:', 'A.西装|B.剪刀|C.布料', null, '153', '134');
INSERT INTO `question` VALUES ('3692', '生动的梦境常常滋扰我的睡眠:', 'A.时常如此|B.偶然如此|C.从未如此', null, '154', '134');
INSERT INTO `question` VALUES ('3693', '我过去曾撕毁一些禁止人们自由的布告:', 'A.是的|B.介乎A与C之间|C.不是的', null, '155', '134');
INSERT INTO `question` VALUES ('3694', '在一个陌生的城市中,我会:', 'A.到处闲游|B.不确定|C.避免去不安全的地方', null, '156', '134');
INSERT INTO `question` VALUES ('3695', '我宁愿服饰素洁大方,而不愿争奇斗艳惹人注目:', 'A.是的|B.不确定|C.不是的', null, '157', '134');
INSERT INTO `question` VALUES ('3696', '黄昏时,安静的娱乐远胜过热闹的宴会:', 'A.是的|B.不确定|C.不是的', null, '158', '134');
INSERT INTO `question` VALUES ('3697', '我常常明知故犯,不愿意接受好心的建议:', 'A.偶然如此|B.罕有如此|C.从不如此', null, '159', '134');
INSERT INTO `question` VALUES ('3698', '我总把[是非][善恶]作为判断或取舍的原则:', 'A.是的|B.介乎A与C之间|C.不是的', null, '160', '134');
INSERT INTO `question` VALUES ('3699', '我工作时不喜欢有许多人在旁参观:', 'A.是的|B.介乎A与C之间|C.不是的', null, '161', '134');
INSERT INTO `question` VALUES ('3700', '故意去为难一般有教养的人, 如医生、教师等人的尊严, 是一件有趣的事:', 'A.是的|B.介乎A与C之间|C.不是的', null, '162', '134');
INSERT INTO `question` VALUES ('3701', '在各种课程中,我较喜欢:', 'A.语文|B.不确定|C.数学', null, '163', '134');
INSERT INTO `question` VALUES ('3702', '那些自以为是、道貌岸然的人最使我生气:', 'A.是的|B.介乎A与C之间|C.不是的', null, '164', '134');
INSERT INTO `question` VALUES ('3703', '与平常循规蹈矩的人交谈:', 'A.颇有兴趣,亦有所得|B.介乎A与C之间|C.他们思想的肤浅使我厌烦', null, '165', '134');
INSERT INTO `question` VALUES ('3704', '我喜欢:', 'A.有几个有时对我很苛求而富有感情的朋友|B.介乎A与C之间|C.不受别人的牵涉', null, '166', '134');
INSERT INTO `question` VALUES ('3705', '如果做民意投票时,我宁愿投票赞同:', 'A.切实根绝有生理缺陷者的生育|B.不确定|C.对杀人犯判处死刑', null, '167', '134');
INSERT INTO `question` VALUES ('3706', '我有时会无端地感到沮丧痛苦:', 'A.是的|B.介乎A与C之间|C.不是的', null, '168', '134');
INSERT INTO `question` VALUES ('3707', '当我与立场相反的人辩论时,我主张:', 'A.尽量找出基本观点的差异|B.不一定|C.彼此让步以解决矛盾', null, '169', '134');
INSERT INTO `question` VALUES ('3708', '我一向重感情而不重理智,因此我的观点常动摇不定:', 'A.是的|B.不确定|C.不是的', null, '170', '134');
INSERT INTO `question` VALUES ('3709', '我的学习效率多有赖于:', 'A.阅读好书|B.介乎A与C之间|C.参加团体讨论', null, '171', '134');
INSERT INTO `question` VALUES ('3710', '我宁选一个薪俸高的工作,不在乎有无保障;也不愿意从事薪俸低的固定工作:', 'A.是的|B.不确定|C.不是的', null, '172', '134');
INSERT INTO `question` VALUES ('3711', '在参加辩论以前,我总先把握住自己的立场:', 'A.经常如此|B.一般如此|C.必要时才如此', null, '173', '134');
INSERT INTO `question` VALUES ('3712', '我常被一些无所谓的琐事所烦扰:', 'A.是的|B.介乎A与C之间|C.不是的', null, '174', '134');
INSERT INTO `question` VALUES ('3713', '我宁愿住在嘈杂的城市,而不愿住在安静的乡村:', 'A.是的|B.不确定|C.不是的', null, '175', '134');
INSERT INTO `question` VALUES ('3714', '我宁愿:', 'A.负责领导儿童游戏|B.不确定|C.协助钟表修理', null, '176', '134');
INSERT INTO `question` VALUES ('3715', '一人__事,众人受累:', 'A.愤|B.偾|C.喷', null, '177', '134');
INSERT INTO `question` VALUES ('3716', '望子成龙的家长往往__苗助长:', 'A.揠|B.堰|C.偃', null, '178', '134');
INSERT INTO `question` VALUES ('3717', '气候的转变并不影响我的情绪:', 'A.是的|B.介乎A与C之间|C.不是的', null, '179', '134');
INSERT INTO `question` VALUES ('3718', '因为我对于一切问题都有些见解，大家都公认我富于思想:', 'A.是的|B.介乎A与C之间|C.不是的', null, '180', '134');
INSERT INTO `question` VALUES ('3719', '我讲话的声音:', 'A.宏亮|B.介乎A与C之间|C.低沉', null, '181', '134');
INSERT INTO `question` VALUES ('3720', '人们公认我是一个活跃热情的人:', 'A.是的|B.介乎A与C之间|C.不是的', null, '182', '134');
INSERT INTO `question` VALUES ('3721', '我喜欢有旅行和变动机会的工作，而不计较工作本身之是否有保障:', 'A.是的|B.介乎A与C之间|C.不是的', null, '183', '134');
INSERT INTO `question` VALUES ('3722', '我治事严格,凡事都务求正确尽善:', 'A.是的|B.介乎A与C之间|C.不是的', null, '184', '134');
INSERT INTO `question` VALUES ('3723', '在取回或归还东西时，我总仔细检查是否东西还保持原状:', 'A.是的|B.介乎A与C之间|C.不是的', null, '185', '134');
INSERT INTO `question` VALUES ('3724', '我通常精力充沛,忙碌多事:', 'A.是的|B.不一定|C.不是的', null, '186', '134');
INSERT INTO `question` VALUES ('3725', '我确信我没有遗漏或不经心回答上面任何问题:', 'A.是的|B.不确定|C.不是的', null, '187', '134');

-- ----------------------------
-- Table structure for `question_ans`
-- ----------------------------
DROP TABLE IF EXISTS `question_ans`;
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

-- ----------------------------
-- Records of question_ans
-- ----------------------------
INSERT INTO `question_ans` VALUES ('133', '1', 'a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a', 'epqae||epqan||epqae||epqan|||epqae||epqan|epqae|epqae|epqan||epqae||epqan|epqal||epqap|epqan||epqae|epqap|epqan|||epqap|epqan|epqal|epqae|epqap|epqan|epqal|epqae||epqan||epqae||epqan|||epqap|epqan||epqae|epqap|epqan||epqae||epqae||epqan|epqal|epqan||epqae||epqan||epqae|epqap|epqan|epqap|epqan||epqae||epqan|epqan|epqap|epqap|epqan|epqan||epqae|epqap|epqan||epqae|epqap|epqan|epqal|', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36|37|38|39|40|41|42|43|44|45|46|47|48|49|50|51|52|53|54|55|56|57|58|59|60|61|62|63|64|65|66|67|68|69|70|71|72|73|74|75|76|77|78|79|80|81|82|83|84|85|86|87|88');
INSERT INTO `question_ans` VALUES ('133', '3', 'a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a', 'epqae||epqan||epqae||epqan|||epqae||epqan|epqae|epqae|epqan||epqae||epqan|epqal||epqap|epqan||epqae|epqap|epqan|||epqap|epqan|epqal|epqae|epqap|epqan|epqal|epqae||epqan||epqae||epqan|||epqap|epqan||epqae|epqap|epqan||epqae||epqae||epqan|epqal|epqan||epqae||epqan||epqae|epqap|epqan|epqap|epqan||epqae||epqan|epqan|epqap|epqap|epqan|epqan||epqae|epqap|epqan||epqae|epqap|epqan|epqal|', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36|37|38|39|40|41|42|43|44|45|46|47|48|49|50|51|52|53|54|55|56|57|58|59|60|61|62|63|64|65|66|67|68|69|70|71|72|73|74|75|76|77|78|79|80|81|82|83|84|85|86|87|88');
INSERT INTO `question_ans` VALUES ('134', '1', 'a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a', '0|0|2|2|0|0|2|0|0|2|0|0|2|0|0|0|2|2|0|2|2|0|0|0|2|0|0|0|0|2|0|0|2|0|0|2|2|2|2|2|0|2|2|0|0|2|2|2|2|2|0|2|0|0|2|2|0|2|2|0|0|0|0|0|2|0|0|0|2|2|2|2|2|2|0|0|0|0|0|0|0|0|0|0|0|0|0|2|0|0|2|0|0|0|0|0|0|2|2|0|2|0|0|2|2|0|0|0|2|2|2|2|2|2|2|0|2|2|2|0|0|0|0|2|0|2|0|0|2|2|2|2|2|2|0|2|0|2|0|2|0|2|2|0|2|2|2|2|2|2|0|0|0|0|2|2|0|0|0|2|0|0|2|2|0|0|2|2|2|0|2|0|2|2|0|2|1|1|2|2|2|2|2|2|2|2|0', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36|37|38|39|40|41|42|43|44|45|46|47|48|49|50|51|52|53|54|55|56|57|58|59|60|61|62|63|64|65|66|67|68|69|70|71|72|73|74|75|76|77|78|79|80|81|82|83|84|85|86|87|88|89|90|91|92|93|94|95|96|97|98|99|100|101|102|103|104|105|106|107|108|109|110|111|112|113|114|115|116|117|118|119|120|121|122|123|124|125|126|127|128|129|130|131|132|133|134|135|136|137|138|139|140|141|142|143|144|145|146|147|148|149|150|151|152|153|154|155|156|157|158|159|160|161|162|163|164|165|166|167|168|169|170|171|172|173|174|175|176|177|178|179|180|181|182|183|184|185|186|187');
INSERT INTO `question_ans` VALUES ('134', '3', 'a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a', '0|0|2|2|0|0|2|0|0|2|0|0|2|0|0|0|2|2|0|2|2|0|0|0|2|0|0|0|0|2|0|0|2|0|0|2|2|2|2|2|0|2|2|0|0|2|2|2|2|2|0|2|0|0|2|2|0|2|2|0|0|0|0|0|2|0|0|0|2|2|2|2|2|2|0|0|0|0|0|0|0|0|0|0|0|0|0|2|0|0|2|0|0|0|0|0|0|2|2|0|2|0|0|2|2|0|0|0|2|2|2|2|2|2|2|0|2|2|2|0|0|0|0|2|0|2|0|0|2|2|2|2|2|2|0|2|0|2|0|2|0|2|2|0|2|2|2|2|2|2|0|0|0|0|2|2|0|0|0|2|0|0|2|2|0|0|2|2|2|0|2|0|2|2|0|2|1|1|2|2|2|2|2|2|2|2|0', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36|37|38|39|40|41|42|43|44|45|46|47|48|49|50|51|52|53|54|55|56|57|58|59|60|61|62|63|64|65|66|67|68|69|70|71|72|73|74|75|76|77|78|79|80|81|82|83|84|85|86|87|88|89|90|91|92|93|94|95|96|97|98|99|100|101|102|103|104|105|106|107|108|109|110|111|112|113|114|115|116|117|118|119|120|121|122|123|124|125|126|127|128|129|130|131|132|133|134|135|136|137|138|139|140|141|142|143|144|145|146|147|148|149|150|151|152|153|154|155|156|157|158|159|160|161|162|163|164|165|166|167|168|169|170|171|172|173|174|175|176|177|178|179|180|181|182|183|184|185|186|187');
INSERT INTO `question_ans` VALUES ('135', '1', 'a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a', 'sy||sp|||gi||cs|||||fe||||||||||||sy-sp-ie|do||fe||re|fe|||||cs|||||||||||||||||sy-sp|sy||fe|||||||||||||||so-fe||||||||cs||sy||do-cs-sy-ie|so|||||||do-sa||||||||cs-sp-ie||||sp|||re||fe||||||||sp||||sy||fe||||sp|||||sp|||||sy-ie||fe||||sc|re|||sy-ie|||cs||||do|sa||||||cm|do||||||fx||so||||cm|do|||||||do|||||so|||||||||||||do||||||do||||||||||cm||||||so|||||cm|do|||', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36|37|38|39|40|41|42|43|44|45|46|47|48|49|50|51|52|53|54|55|56|57|58|59|60|61|62|63|64|65|66|67|68|69|70|71|72|73|74|75|76|77|78|79|80|81|82|83|84|85|86|87|88|89|90|91|92|93|94|95|96|97|98|99|100|101|102|103|104|105|106|107|108|109|110|111|112|113|114|115|116|117|118|119|120|121|122|123|124|125|126|127|128|129|130|131|132|133|134|135|136|137|138|139|140|141|142|143|144|145|146|147|148|149|150|151|152|153|154|155|156|157|158|159|160|161|162|163|164|165|166|167|168|169|170|171|172|173|174|175|176|177|178|179|180|181|182|183|184|185|186|187|188|189|190|191|192|193|194|195|196|197|198|199|200|201|202|203|204|205|206|207|208|209|210|211|212|213|214|215|216|217|218|219|220|221|222|223|224|225|226|227|228|229|230');
INSERT INTO `question_ans` VALUES ('135', '3', 'a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a', 'sy||sp|||gi||cs|||||fe||||||||||||sy-sp-ie|do||fe||re|fe|||||cs|||||||||||||||||sy-sp|sy||fe|||||||||||||||so-fe||||||||cs||sy||do-cs-sy-ie|so|||||||do-sa||||||||cs-sp-ie||||sp|||re||fe||||||||sp||||sy||fe||||sp|||||sp|||||sy-ie||fe||||sc|re|||sy-ie|||cs||||do|sa||||||cm|do||||||fx||so||||cm|do|||||||do|||||so|||||||||||||do||||||do||||||||||cm||||||so|||||cm|do|||', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36|37|38|39|40|41|42|43|44|45|46|47|48|49|50|51|52|53|54|55|56|57|58|59|60|61|62|63|64|65|66|67|68|69|70|71|72|73|74|75|76|77|78|79|80|81|82|83|84|85|86|87|88|89|90|91|92|93|94|95|96|97|98|99|100|101|102|103|104|105|106|107|108|109|110|111|112|113|114|115|116|117|118|119|120|121|122|123|124|125|126|127|128|129|130|131|132|133|134|135|136|137|138|139|140|141|142|143|144|145|146|147|148|149|150|151|152|153|154|155|156|157|158|159|160|161|162|163|164|165|166|167|168|169|170|171|172|173|174|175|176|177|178|179|180|181|182|183|184|185|186|187|188|189|190|191|192|193|194|195|196|197|198|199|200|201|202|203|204|205|206|207|208|209|210|211|212|213|214|215|216|217|218|219|220|221|222|223|224|225|226|227|228|229|230');
INSERT INTO `question_ans` VALUES ('136', '1', 'a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a', 'ach|def|ord|exh|aut|ach|def|ord|exh|aut|ach|def|ord|exh|aut|ach|def|ord|exh|aut|ach|def|ord|exh|aut|ach|def|ord|exh|aut|ach|def|ord|exh|aut|ach|def|ord|exh|aut|ach|def|ord|exh|aut|ach|def|ord|exh|aut|ach|def|ord|exh|aut|ach|def|ord|exh|aut|ach|def|ord|exh|aut|ach|def|ord|exh|aut|ach|def|ord|exh|aut|aff|int|suc|dom|aba|aff|int|suc|dom|aba|aff|int|suc|dom|aba|aff|int|suc|dom|aba|aff|int|suc|dom|aba|aff|int|suc|dom|aba|aff|int|suc|dom|aba|aff|int|suc|dom|aba|aff|int|suc|dom|aba|aff|int|suc|dom|aba|aff|int|suc|dom|aba|aff|int|suc|dom|aba|aff|int|suc|dom|aba|aff|int|suc|dom|aba|aff|int|suc|dom|aba|nur|chg|end|het|agg|nur|chg|end|het|agg|nur|chg|end|het|agg|nur|chg|end|het|agg|nur|chg|end|het|agg|nur|chg|end|het|agg|nur|chg|end|het|agg|nur|chg|end|het|agg|nur|chg|end|het|agg|nur|chg|end|het|agg|nur|chg|end|het|agg|nur|chg|end|het|agg|nur|chg|end|het|agg|nur|chg|end|het|agg|nur|chg|end|het|agg', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36|37|38|39|40|41|42|43|44|45|46|47|48|49|50|51|52|53|54|55|56|57|58|59|60|61|62|63|64|65|66|67|68|69|70|71|72|73|74|75|76|77|78|79|80|81|82|83|84|85|86|87|88|89|90|91|92|93|94|95|96|97|98|99|100|101|102|103|104|105|106|107|108|109|110|111|112|113|114|115|116|117|118|119|120|121|122|123|124|125|126|127|128|129|130|131|132|133|134|135|136|137|138|139|140|141|142|143|144|145|146|147|148|149|150|151|152|153|154|155|156|157|158|159|160|161|162|163|164|165|166|167|168|169|170|171|172|173|174|175|176|177|178|179|180|181|182|183|184|185|186|187|188|189|190|191|192|193|194|195|196|197|198|199|200|201|202|203|204|205|206|207|208|209|210|211|212|213|214|215|216|217|218|219|220|221|222|223|224|225');
INSERT INTO `question_ans` VALUES ('136', '3', 'a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a', 'ach|def|ord|exh|aut|ach|def|ord|exh|aut|ach|def|ord|exh|aut|ach|def|ord|exh|aut|ach|def|ord|exh|aut|ach|def|ord|exh|aut|ach|def|ord|exh|aut|ach|def|ord|exh|aut|ach|def|ord|exh|aut|ach|def|ord|exh|aut|ach|def|ord|exh|aut|ach|def|ord|exh|aut|ach|def|ord|exh|aut|ach|def|ord|exh|aut|ach|def|ord|exh|aut|aff|int|suc|dom|aba|aff|int|suc|dom|aba|aff|int|suc|dom|aba|aff|int|suc|dom|aba|aff|int|suc|dom|aba|aff|int|suc|dom|aba|aff|int|suc|dom|aba|aff|int|suc|dom|aba|aff|int|suc|dom|aba|aff|int|suc|dom|aba|aff|int|suc|dom|aba|aff|int|suc|dom|aba|aff|int|suc|dom|aba|aff|int|suc|dom|aba|aff|int|suc|dom|aba|nur|chg|end|het|agg|nur|chg|end|het|agg|nur|chg|end|het|agg|nur|chg|end|het|agg|nur|chg|end|het|agg|nur|chg|end|het|agg|nur|chg|end|het|agg|nur|chg|end|het|agg|nur|chg|end|het|agg|nur|chg|end|het|agg|nur|chg|end|het|agg|nur|chg|end|het|agg|nur|chg|end|het|agg|nur|chg|end|het|agg|nur|chg|end|het|agg', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36|37|38|39|40|41|42|43|44|45|46|47|48|49|50|51|52|53|54|55|56|57|58|59|60|61|62|63|64|65|66|67|68|69|70|71|72|73|74|75|76|77|78|79|80|81|82|83|84|85|86|87|88|89|90|91|92|93|94|95|96|97|98|99|100|101|102|103|104|105|106|107|108|109|110|111|112|113|114|115|116|117|118|119|120|121|122|123|124|125|126|127|128|129|130|131|132|133|134|135|136|137|138|139|140|141|142|143|144|145|146|147|148|149|150|151|152|153|154|155|156|157|158|159|160|161|162|163|164|165|166|167|168|169|170|171|172|173|174|175|176|177|178|179|180|181|182|183|184|185|186|187|188|189|190|191|192|193|194|195|196|197|198|199|200|201|202|203|204|205|206|207|208|209|210|211|212|213|214|215|216|217|218|219|220|221|222|223|224|225');
INSERT INTO `question_ans` VALUES ('137', '1', 'a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a', '1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36|37|38|39|40|41|42|43|44|45|46|47|48|49|50|51|52|53|54|55|56|57|58|59|60|61|62|63|64|65|66|67|68|69|70|71|72|73|74|75|76|77|78|79|80|81|82|83|84|85|86|87|88|89|90');
INSERT INTO `question_ans` VALUES ('137', '3', 'a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a', '1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36|37|38|39|40|41|42|43|44|45|46|47|48|49|50|51|52|53|54|55|56|57|58|59|60|61|62|63|64|65|66|67|68|69|70|71|72|73|74|75|76|77|78|79|80|81|82|83|84|85|86|87|88|89|90');
INSERT INTO `question_ans` VALUES ('138', '1', 'a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a', '0|0|1|0|0|0|0|0|1|0|0|0|0|0|1|0|1|0|0|0|0|0|0|0|0|0|0|0|0|0|0|1|0|0|1|0|0|0|0|0|0|0|0|0|1|0|0|0|0|0|0|0|1|0|1|0|0|0|0|0', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36|37|38|39|40|41|42|43|44|45|46|47|48|49|50|51|52|53|54|55|56|57|58|59|60');
INSERT INTO `question_ans` VALUES ('138', '3', 'a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a|a', '0|0|1|0|0|0|0|0|1|0|0|0|0|0|1|0|1|0|0|0|0|0|0|0|0|0|0|0|0|0|0|1|0|0|1|0|0|0|0|0|0|0|0|0|1|0|0|0|0|0|0|0|1|0|1|0|0|0|0|0', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36|37|38|39|40|41|42|43|44|45|46|47|48|49|50|51|52|53|54|55|56|57|58|59|60');

-- ----------------------------
-- Table structure for `spmdf`
-- ----------------------------
DROP TABLE IF EXISTS `spmdf`;
CREATE TABLE `spmdf` (
  `BZ` tinyint(4) NOT NULL,
  `XH` int(11) NOT NULL,
  PRIMARY KEY (`XH`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of spmdf
-- ----------------------------
INSERT INTO `spmdf` VALUES ('4', '1');
INSERT INTO `spmdf` VALUES ('5', '2');
INSERT INTO `spmdf` VALUES ('1', '3');
INSERT INTO `spmdf` VALUES ('2', '4');
INSERT INTO `spmdf` VALUES ('6', '5');
INSERT INTO `spmdf` VALUES ('3', '6');
INSERT INTO `spmdf` VALUES ('6', '7');
INSERT INTO `spmdf` VALUES ('2', '8');
INSERT INTO `spmdf` VALUES ('1', '9');
INSERT INTO `spmdf` VALUES ('3', '10');
INSERT INTO `spmdf` VALUES ('4', '11');
INSERT INTO `spmdf` VALUES ('5', '12');
INSERT INTO `spmdf` VALUES ('2', '13');
INSERT INTO `spmdf` VALUES ('6', '14');
INSERT INTO `spmdf` VALUES ('1', '15');
INSERT INTO `spmdf` VALUES ('2', '16');
INSERT INTO `spmdf` VALUES ('1', '17');
INSERT INTO `spmdf` VALUES ('3', '18');
INSERT INTO `spmdf` VALUES ('5', '19');
INSERT INTO `spmdf` VALUES ('6', '20');
INSERT INTO `spmdf` VALUES ('4', '21');
INSERT INTO `spmdf` VALUES ('3', '22');
INSERT INTO `spmdf` VALUES ('4', '23');
INSERT INTO `spmdf` VALUES ('5', '24');
INSERT INTO `spmdf` VALUES ('8', '25');
INSERT INTO `spmdf` VALUES ('2', '26');
INSERT INTO `spmdf` VALUES ('3', '27');
INSERT INTO `spmdf` VALUES ('8', '28');
INSERT INTO `spmdf` VALUES ('7', '29');
INSERT INTO `spmdf` VALUES ('4', '30');
INSERT INTO `spmdf` VALUES ('5', '31');
INSERT INTO `spmdf` VALUES ('1', '32');
INSERT INTO `spmdf` VALUES ('7', '33');
INSERT INTO `spmdf` VALUES ('6', '34');
INSERT INTO `spmdf` VALUES ('1', '35');
INSERT INTO `spmdf` VALUES ('2', '36');
INSERT INTO `spmdf` VALUES ('3', '37');
INSERT INTO `spmdf` VALUES ('4', '38');
INSERT INTO `spmdf` VALUES ('3', '39');
INSERT INTO `spmdf` VALUES ('7', '40');
INSERT INTO `spmdf` VALUES ('8', '41');
INSERT INTO `spmdf` VALUES ('6', '42');
INSERT INTO `spmdf` VALUES ('5', '43');
INSERT INTO `spmdf` VALUES ('4', '44');
INSERT INTO `spmdf` VALUES ('1', '45');
INSERT INTO `spmdf` VALUES ('2', '46');
INSERT INTO `spmdf` VALUES ('5', '47');
INSERT INTO `spmdf` VALUES ('6', '48');
INSERT INTO `spmdf` VALUES ('7', '49');
INSERT INTO `spmdf` VALUES ('6', '50');
INSERT INTO `spmdf` VALUES ('8', '51');
INSERT INTO `spmdf` VALUES ('2', '52');
INSERT INTO `spmdf` VALUES ('1', '53');
INSERT INTO `spmdf` VALUES ('5', '54');
INSERT INTO `spmdf` VALUES ('1', '55');
INSERT INTO `spmdf` VALUES ('6', '56');
INSERT INTO `spmdf` VALUES ('3', '57');
INSERT INTO `spmdf` VALUES ('2', '58');
INSERT INTO `spmdf` VALUES ('4', '59');
INSERT INTO `spmdf` VALUES ('5', '60');

-- ----------------------------
-- Table structure for `spmdf_memory`
-- ----------------------------
DROP TABLE IF EXISTS `spmdf_memory`;
CREATE TABLE `spmdf_memory` (
  `BZ` tinyint(4) NOT NULL,
  `XH` int(11) NOT NULL,
  PRIMARY KEY (`XH`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of spmdf_memory
-- ----------------------------

-- ----------------------------
-- Table structure for `spmmd`
-- ----------------------------
DROP TABLE IF EXISTS `spmmd`;
CREATE TABLE `spmmd` (
  `NLL` float(11,2) NOT NULL,
  `NLH` float(11,2) NOT NULL,
  `B95` int(11) NOT NULL,
  `B90` int(11) NOT NULL,
  `B75` int(11) NOT NULL,
  `B50` int(11) NOT NULL,
  `B25` int(11) NOT NULL,
  `B10` int(11) NOT NULL,
  `B5` int(11) NOT NULL,
  PRIMARY KEY (`NLL`,`NLH`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of spmmd
-- ----------------------------
INSERT INTO `spmmd` VALUES ('5.25', '5.75', '34', '29', '25', '16', '13', '12', '9');
INSERT INTO `spmmd` VALUES ('5.75', '6.25', '36', '31', '25', '17', '13', '12', '9');
INSERT INTO `spmmd` VALUES ('6.25', '6.75', '37', '31', '25', '18', '13', '12', '10');
INSERT INTO `spmmd` VALUES ('6.75', '7.25', '43', '36', '25', '19', '13', '12', '10');
INSERT INTO `spmmd` VALUES ('7.25', '7.75', '44', '38', '31', '21', '13', '12', '10');
INSERT INTO `spmmd` VALUES ('7.75', '8.25', '44', '39', '31', '23', '15', '13', '10');
INSERT INTO `spmmd` VALUES ('8.25', '8.75', '45', '40', '33', '29', '20', '14', '12');
INSERT INTO `spmmd` VALUES ('8.75', '9.25', '47', '43', '37', '33', '25', '14', '12');
INSERT INTO `spmmd` VALUES ('9.25', '9.75', '50', '47', '39', '35', '27', '17', '13');
INSERT INTO `spmmd` VALUES ('9.75', '10.25', '50', '48', '42', '35', '27', '17', '13');
INSERT INTO `spmmd` VALUES ('10.25', '10.75', '50', '49', '42', '39', '32', '25', '18');
INSERT INTO `spmmd` VALUES ('10.75', '11.25', '52', '50', '43', '39', '33', '25', '19');
INSERT INTO `spmmd` VALUES ('11.25', '11.75', '53', '50', '45', '42', '35', '25', '19');
INSERT INTO `spmmd` VALUES ('11.75', '12.25', '53', '50', '46', '42', '37', '27', '21');
INSERT INTO `spmmd` VALUES ('12.25', '12.75', '53', '52', '50', '45', '40', '33', '28');
INSERT INTO `spmmd` VALUES ('12.75', '13.25', '53', '52', '50', '45', '40', '35', '30');
INSERT INTO `spmmd` VALUES ('13.25', '13.75', '54', '52', '50', '46', '42', '35', '32');
INSERT INTO `spmmd` VALUES ('13.75', '14.25', '55', '52', '50', '48', '43', '36', '34');
INSERT INTO `spmmd` VALUES ('14.25', '14.75', '55', '53', '51', '48', '43', '36', '34');
INSERT INTO `spmmd` VALUES ('14.75', '15.25', '57', '54', '51', '48', '43', '36', '34');
INSERT INTO `spmmd` VALUES ('15.25', '15.75', '57', '55', '52', '49', '43', '41', '34');
INSERT INTO `spmmd` VALUES ('15.75', '16.25', '57', '56', '53', '49', '44', '41', '36');
INSERT INTO `spmmd` VALUES ('16.25', '16.75', '57', '56', '53', '49', '45', '41', '37');
INSERT INTO `spmmd` VALUES ('16.75', '20.00', '58', '57', '55', '52', '47', '40', '37');
INSERT INTO `spmmd` VALUES ('20.00', '30.00', '57', '56', '54', '50', '44', '38', '33');
INSERT INTO `spmmd` VALUES ('30.00', '40.00', '57', '55', '52', '48', '43', '37', '28');
INSERT INTO `spmmd` VALUES ('40.00', '50.00', '57', '54', '50', '47', '41', '31', '28');
INSERT INTO `spmmd` VALUES ('50.00', '60.00', '54', '52', '48', '42', '34', '24', '21');
INSERT INTO `spmmd` VALUES ('60.00', '70.00', '54', '52', '46', '37', '30', '22', '19');
INSERT INTO `spmmd` VALUES ('70.00', '110.00', '52', '49', '44', '33', '26', '18', '17');

-- ----------------------------
-- Table structure for `spmmd_memory`
-- ----------------------------
DROP TABLE IF EXISTS `spmmd_memory`;
CREATE TABLE `spmmd_memory` (
  `NLL` float(11,2) NOT NULL,
  `NLH` float(11,2) NOT NULL,
  `B95` int(11) NOT NULL,
  `B90` int(11) NOT NULL,
  `B75` int(11) NOT NULL,
  `B50` int(11) NOT NULL,
  `B25` int(11) NOT NULL,
  `B10` int(11) NOT NULL,
  `B5` int(11) NOT NULL,
  PRIMARY KEY (`NLL`,`NLH`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of spmmd_memory
-- ----------------------------

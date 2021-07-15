/*
Navicat MySQL Data Transfer

Source Server         : ScarZ
Source Server Version : 50626
Source Host           : localhost:3306
Source Database       : hrd

Target Server Type    : MYSQL
Target Server Version : 50626
File Encoding         : 65001

Date: 2016-06-23 11:34:15
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for department_group
-- ----------------------------
DROP TABLE IF EXISTS `department_group`;
CREATE TABLE `department_group` (
  `main_dep` int(2) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `dep_name` varchar(50) NOT NULL,
  PRIMARY KEY (`main_dep`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of department_group
-- ----------------------------
INSERT INTO `department_group` VALUES ('01', 'ฝ่ายบริหารทั่วไป');
INSERT INTO `department_group` VALUES ('02', 'ฝ่ายการเงินและบัญชี');
INSERT INTO `department_group` VALUES ('03', 'ฝ่ายการพยาบาล');
INSERT INTO `department_group` VALUES ('04', 'ฝ่ายจิตวิทยา');
INSERT INTO `department_group` VALUES ('05', 'ฝ่ายจิตเวชชุมชน');
INSERT INTO `department_group` VALUES ('06', 'ฝ่ายพยาธิวิทยา');
INSERT INTO `department_group` VALUES ('07', 'ฝ่ายพัสดุ');
INSERT INTO `department_group` VALUES ('08', 'ฝ่ายเภสัชกรรม');
INSERT INTO `department_group` VALUES ('09', 'ฝ่ายสังคมสงเคราะห์');
INSERT INTO `department_group` VALUES ('10', 'ฝ่ายสุขภาพจิตสารเสพติด');
INSERT INTO `department_group` VALUES ('11', 'สำนักคุณภาพ');
INSERT INTO `department_group` VALUES ('19', 'ฝ่ายนโยบายและแผนงาน');
INSERT INTO `department_group` VALUES ('13', 'สำนักเลขานุการ');
INSERT INTO `department_group` VALUES ('14', 'ฝ่ายการแพทย์');
INSERT INTO `department_group` VALUES ('18', 'ฝ่ายทรัพยากรบุคคล');

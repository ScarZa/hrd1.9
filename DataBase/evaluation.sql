/*
 Navicat Premium Data Transfer

 Source Server         : ScarZ
 Source Server Type    : MySQL
 Source Server Version : 100113
 Source Host           : localhost:3306
 Source Schema         : hrd

 Target Server Type    : MySQL
 Target Server Version : 100113
 File Encoding         : 65001

 Date: 05/06/2018 15:44:40
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for evaluation
-- ----------------------------
DROP TABLE IF EXISTS `evaluation`;
CREATE TABLE `evaluation`  (
  `eval_id` int(4) NOT NULL AUTO_INCREMENT,
  `eval_group` int(1) NOT NULL,
  `eval_subgroup` int(1) NOT NULL DEFAULT 0,
  `eval_value` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`eval_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of evaluation
-- ----------------------------
INSERT INTO `evaluation` VALUES (1, 1, 0, 'พอใช้');
INSERT INTO `evaluation` VALUES (2, 1, 0, 'ดี');
INSERT INTO `evaluation` VALUES (3, 1, 0, 'ดีมาก');
INSERT INTO `evaluation` VALUES (4, 1, 1, 'ดีมาก1');
INSERT INTO `evaluation` VALUES (5, 1, 1, 'ดีมาก2');
INSERT INTO `evaluation` VALUES (6, 1, 0, 'ดีเด่น');
INSERT INTO `evaluation` VALUES (7, 2, 0, 'ครึ่งขั้น');
INSERT INTO `evaluation` VALUES (8, 2, 0, '1 ขั้น');
INSERT INTO `evaluation` VALUES (9, 2, 0, 'ขั้นพิเศษ');

-- ----------------------------
-- Table structure for resulteval
-- ----------------------------
DROP TABLE IF EXISTS `resulteval`;
CREATE TABLE `resulteval`  (
  `reseval_id` int(7) NOT NULL AUTO_INCREMENT,
  `empno` int(7) NOT NULL,
  `numdoc` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `app_date` date DEFAULT NULL,
  `year` varchar(4) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `episode` int(1) NOT NULL,
  `salary` decimal(10, 2) NOT NULL,
  `base_salary` decimal(10, 2) NOT NULL,
  `salary_up` decimal(7, 2) NOT NULL,
  `percent` decimal(6, 3) NOT NULL,
  `eval_id` int(7) NOT NULL,
  `rec_date` datetime(0) NOT NULL,
  `recorder` int(7) NOT NULL,
  PRIMARY KEY (`reseval_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of resulteval
-- ----------------------------
INSERT INTO `resulteval` VALUES (1, 30, '123/61', '2018-02-01', '2558', 1, 15690.00, 17980.00, 0.00, 0.000, 6, '2018-06-05 10:23:50', 30);

SET FOREIGN_KEY_CHECKS = 1;

/*
 Navicat Premium Data Transfer

 Source Server         : 10.0.0.11
 Source Server Type    : MySQL
 Source Server Version : 50565
 Source Host           : 10.0.0.11:3306
 Source Schema         : hrd

 Target Server Type    : MySQL
 Target Server Version : 50565
 File Encoding         : 65001

 Date: 20/10/2021 11:31:38
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for dictation
-- ----------------------------
DROP TABLE IF EXISTS `dictation`;
CREATE TABLE `dictation`  (
  `dictation_id` int(2) NOT NULL AUTO_INCREMENT,
  `dictation_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`dictation_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of dictation
-- ----------------------------
INSERT INTO `dictation` VALUES (1, 'คำสั่งแต่งตั้ง');
INSERT INTO `dictation` VALUES (2, 'โยกย้ายตำแหน่ง/ฝ่าย/งาน');
INSERT INTO `dictation` VALUES (3, 'คำสั่งต่อสัญญา');
INSERT INTO `dictation` VALUES (4, 'คำสั่งอื่นๆ');

SET FOREIGN_KEY_CHECKS = 1;

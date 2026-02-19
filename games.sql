/*
 Navicat Premium Data Transfer

 Source Server         : local
 Source Server Type    : MySQL
 Source Server Version : 100432 (10.4.32-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : games

 Target Server Type    : MySQL
 Target Server Version : 100432 (10.4.32-MariaDB)
 File Encoding         : 65001

 Date: 19/02/2026 11:06:37
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for articles
-- ----------------------------
DROP TABLE IF EXISTS `articles`;
CREATE TABLE `articles`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `sef` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `img` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `source_url` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `source_name` char(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `publish_datetime` datetime NOT NULL,
  `gallery_id` int UNSIGNED NULL DEFAULT NULL,
  `show_on_main_page` enum('0','1') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `is_highlighted` enum('0','1') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `ordering` int UNSIGNED NOT NULL,
  `add_by` int UNSIGNED NOT NULL,
  `add_datetime` datetime NOT NULL,
  `mod_by` int UNSIGNED NULL DEFAULT NULL,
  `mod_datetime` datetime NULL DEFAULT NULL,
  `is_published` enum('1','0') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '1',
  `is_deleted` enum('0','1') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `gallery_id`(`gallery_id`) USING BTREE,
  INDEX `ordering`(`ordering`) USING BTREE,
  INDEX `sef`(`sef`) USING BTREE,
  INDEX `add_by`(`add_by`) USING BTREE,
  INDEX `mod_by`(`mod_by`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 32 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '\'keywords\', \'descr\', \'title\', \'short\', \'full\'' ROW_FORMAT = FIXED;

-- ----------------------------
-- Table structure for articles_cats_rel
-- ----------------------------
DROP TABLE IF EXISTS `articles_cats_rel`;
CREATE TABLE `articles_cats_rel`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `article_id` int UNSIGNED NOT NULL,
  `category_id` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `article_id`(`article_id`, `category_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 14 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = FIXED;

-- ----------------------------
-- Table structure for menu
-- ----------------------------
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` int UNSIGNED NULL DEFAULT NULL,
  `type` enum('category','article','spec','url') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `ref_table` char(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `ref_id` int UNSIGNED NULL DEFAULT NULL,
  `url` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sef` char(80) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `ordering` int UNSIGNED NOT NULL,
  `add_by` int UNSIGNED NOT NULL,
  `add_datetime` datetime NOT NULL,
  `mod_by` int UNSIGNED NULL DEFAULT NULL,
  `mod_datetime` datetime NULL DEFAULT NULL,
  `is_section` enum('0','1') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `is_published` enum('1','0') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '1',
  `is_deleted` enum('0','1') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `sef`(`sef`) USING BTREE,
  INDEX `parent_id`(`parent_id`) USING BTREE,
  INDEX `ref_table`(`ref_table`, `ref_id`) USING BTREE,
  INDEX `add_by`(`add_by`) USING BTREE,
  INDEX `mod_by`(`mod_by`) USING BTREE,
  INDEX `ordering`(`ordering`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 51 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '\'name\'' ROW_FORMAT = FIXED;

-- ----------------------------
-- Table structure for translates
-- ----------------------------
DROP TABLE IF EXISTS `translates`;
CREATE TABLE `translates`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `ref_table` char(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `ref_id` int UNSIGNED NOT NULL,
  `lang` char(2) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `fieldname` char(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `text` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `ref_table_2`(`ref_table`, `ref_id`, `lang`, `fieldname`) USING BTREE,
  INDEX `ref_table`(`ref_table`, `ref_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 622 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

SET FOREIGN_KEY_CHECKS = 1;

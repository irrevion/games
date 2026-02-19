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

 Date: 20/02/2026 01:36:45
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
-- Table structure for comments
-- ----------------------------
DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `answered_comment_id` int UNSIGNED NULL DEFAULT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `ref_table` char(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `ref_id` int UNSIGNED NOT NULL,
  `text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `add_datetime` datetime NOT NULL,
  `is_published` enum('1','0') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '1',
  `is_inspected` enum('0','1') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `is_deleted` enum('0','1') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE,
  INDEX `ref_table`(`ref_table`, `ref_id`) USING BTREE,
  INDEX `answered_comment_id`(`answered_comment_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for complaints
-- ----------------------------
DROP TABLE IF EXISTS `complaints`;
CREATE TABLE `complaints`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int UNSIGNED NOT NULL,
  `admin_id` int UNSIGNED NULL DEFAULT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tmp_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `filename` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `date` datetime NOT NULL,
  `is_read` enum('0','1') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE,
  INDEX `admin_id`(`admin_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for content_registry
-- ----------------------------
DROP TABLE IF EXISTS `content_registry`;
CREATE TABLE `content_registry`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `ref_table` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `list_link` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `item_link` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `item_page` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `title_column` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `text_column` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `ref_table`(`ref_table`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for counters
-- ----------------------------
DROP TABLE IF EXISTS `counters`;
CREATE TABLE `counters`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `ref_table` char(64) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `ref_id` int UNSIGNED NOT NULL,
  `type` char(32) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `counter` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `ref_table`(`ref_table` ASC, `ref_id` ASC, `type` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 85 CHARACTER SET = ascii COLLATE = ascii_bin ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for galleries
-- ----------------------------
DROP TABLE IF EXISTS `galleries`;
CREATE TABLE `galleries`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `add_by` int UNSIGNED NOT NULL,
  `add_datetime` datetime NOT NULL,
  `mod_by` int UNSIGNED NULL DEFAULT NULL,
  `mod_datetime` datetime NULL DEFAULT NULL,
  `is_published` enum('1','0') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '1',
  `is_deleted` enum('0','1') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `add_by`(`add_by`) USING BTREE,
  INDEX `mod_by`(`mod_by`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 13 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'name' ROW_FORMAT = FIXED;

-- ----------------------------
-- Table structure for gallery_photos
-- ----------------------------
DROP TABLE IF EXISTS `gallery_photos`;
CREATE TABLE `gallery_photos`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `gallery_id` int UNSIGNED NOT NULL,
  `image` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `ordering` int UNSIGNED NOT NULL,
  `status` enum('1','0') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '1',
  `add_by` int UNSIGNED NOT NULL,
  `add_datetime` datetime NOT NULL,
  `mod_by` int UNSIGNED NULL DEFAULT NULL,
  `mod_datetime` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `gallery_id`(`gallery_id`) USING BTREE,
  INDEX `mod_by`(`mod_by`) USING BTREE,
  INDEX `add_by`(`add_by`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 41 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = FIXED;

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
-- Table structure for menu_navpos_rel
-- ----------------------------
DROP TABLE IF EXISTS `menu_navpos_rel`;
CREATE TABLE `menu_navpos_rel`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `item_id` int UNSIGNED NOT NULL,
  `navpos_id` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `item_id`(`item_id`, `navpos_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 46 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = FIXED;

-- ----------------------------
-- Table structure for nav_positions
-- ----------------------------
DROP TABLE IF EXISTS `nav_positions`;
CREATE TABLE `nav_positions`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `position` char(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `name_az` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `name_ru` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = FIXED;

-- ----------------------------
-- Table structure for site_languages
-- ----------------------------
DROP TABLE IF EXISTS `site_languages`;
CREATE TABLE `site_languages`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `language_dir` char(2) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `language_name` char(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `is_published` enum('0','1') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `is_default` enum('0','1') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `is_rtl` enum('0','1') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `is_deleted` enum('0','1') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `language_dir`(`language_dir`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 10 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = FIXED;

-- ----------------------------
-- Table structure for site_settings
-- ----------------------------
DROP TABLE IF EXISTS `site_settings`;
CREATE TABLE `site_settings`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `option` char(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `value` char(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `option`(`option`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 10 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = FIXED;

-- ----------------------------
-- Table structure for site_users
-- ----------------------------
DROP TABLE IF EXISTS `site_users`;
CREATE TABLE `site_users`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `uid` char(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `provider` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `identity` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `profile` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `email` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `password_hash` varchar(96) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `verified_email` tinyint NOT NULL,
  `first_name` char(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` char(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `nickname` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `birth_date` date NULL DEFAULT NULL,
  `gender` enum('male','female') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `registration_datetime` datetime NOT NULL,
  `last_login_datetime` datetime NULL DEFAULT NULL,
  `is_blocked` enum('0','1') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `uid`(`uid`, `provider`) USING BTREE,
  UNIQUE INDEX `email`(`email`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for site_users_events
-- ----------------------------
DROP TABLE IF EXISTS `site_users_events`;
CREATE TABLE `site_users_events`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int UNSIGNED NOT NULL,
  `ref_table` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `ref_id` int UNSIGNED NOT NULL,
  `event_type` enum('like','vote') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `event` enum('like','dislike','up_vote','down_vote','neutral_vote') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `user_id_2`(`user_id`, `ref_table`, `ref_id`, `event_type`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE,
  INDEX `ref_table`(`ref_table`, `ref_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

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

-- ----------------------------
-- Database `articlesite`
-- ----------------------------
DROP DATABASE IF EXISTS `articlesite`;
CREATE DATABASE `articlesite` CHARACTER SET utf8 COLLATE utf8_czech_ci;

-- ----------------------------
-- Table structure for `article`
-- ----------------------------
DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
    `article_id`  int(11) NOT NULL                   AUTO_INCREMENT,
    `title`       varchar(255) COLLATE utf8_czech_ci DEFAULT NULL,
    `content`     text COLLATE utf8_czech_ci,
    `date`        varchar(10) COLLATE utf8_czech_ci DEFAULT NULL,
    PRIMARY KEY (`article_id`)
) ENGINE = InnoDB AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8 COLLATE = utf8_czech_ci;

-- ----------------------------
-- Table structure for `category`
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
    `category_id` int(11) NOT NULL                   AUTO_INCREMENT,
    `title`       varchar(255) COLLATE utf8_czech_ci DEFAULT NULL,
    PRIMARY KEY (`category_id`),
    UNIQUE (`title`)
) ENGINE = InnoDB AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8 COLLATE = utf8_czech_ci;

-- ----------------------------
-- Table structure for `articlecategory`
-- ----------------------------
DROP TABLE IF EXISTS `articlecategory`;
CREATE TABLE `articlecategory` (
    `articlecategory_id` int(11) NOT NULL                   AUTO_INCREMENT,
    `article_id`         int(11) NOT NULL,
    `category_id`        int(11) NOT NULL,
    PRIMARY KEY (`articlecategory_id`),
    FOREIGN KEY (article_id) REFERENCES `article`(`article_id`),
    FOREIGN KEY (category_id) REFERENCES `category`(`category_id`)
) ENGINE = InnoDB AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8 COLLATE = utf8_czech_ci;

-- ----------------------------
-- Records of `article`
-- ----------------------------
INSERT INTO `article` VALUES ('1', 'Èlánek první', 'obsah 1', '30.01.2021');
INSERT INTO `article` VALUES ('2', 'Èlánek druhý', 'obsah 2', '30.01.2021');
INSERT INTO `article` VALUES ('3', 'Èlánek tøetí', 'obsah 3', '30.01.2021');
INSERT INTO `article` VALUES ('4', 'Èlánek ètvrtý', 'obsah 4', '30.01.2021');

-- ----------------------------
-- Records of `category`
-- ----------------------------
INSERT INTO `category` VALUES ('1', 'První');
INSERT INTO `category` VALUES ('2', 'Druhá');
INSERT INTO `category` VALUES ('3', 'Tøetí');

-- ----------------------------
-- Records of `articlecategory`
-- ----------------------------
INSERT INTO `articlecategory` VALUES ('1', '1', '1');
INSERT INTO `articlecategory` VALUES ('2', '1', '2');
INSERT INTO `articlecategory` VALUES ('3', '2', '2');
INSERT INTO `articlecategory` VALUES ('4', '2', '3');
INSERT INTO `articlecategory` VALUES ('5', '3', '1');
INSERT INTO `articlecategory` VALUES ('6', '3', '2');
INSERT INTO `articlecategory` VALUES ('7', '3', '3');
INSERT INTO `articlecategory` VALUES ('8', '4', '1');
INSERT INTO `articlecategory` VALUES ('9', '4', '2');


/*
Navicat MySQL Data Transfer

Source Server         : intensdb_vps
Source Server Version : 50726
Source Host           : 117.53.46.5:3306
Source Database       : db_mintohardjo

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2019-06-28 15:09:49
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for jenis_lab
-- ----------------------------
DROP TABLE IF EXISTS `jenis_lab`;
CREATE TABLE `jenis_lab` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_jenis` varchar(150) DEFAULT NULL,
  `kode_jenis` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of jenis_lab
-- ----------------------------
INSERT INTO `jenis_lab` VALUES ('1', 'HEMATOLOGI', 'HA');
INSERT INTO `jenis_lab` VALUES ('8', 'HEMOSTASIS', 'HL');
INSERT INTO `jenis_lab` VALUES ('9', 'ANALISA CAIRAN TUBUH', 'HM');
INSERT INTO `jenis_lab` VALUES ('10', 'KIMIA', 'HN');
INSERT INTO `jenis_lab` VALUES ('11', 'IMUNO SEROLOGI', 'HO');
INSERT INTO `jenis_lab` VALUES ('12', 'PETANDA TUMOR', 'HP');
INSERT INTO `jenis_lab` VALUES ('13', 'LAIN-LAIN', 'HQ');
INSERT INTO `jenis_lab` VALUES ('14', 'MIKROBIOLOGI', 'HR');
INSERT INTO `jenis_lab` VALUES ('15', 'URINALISA', 'HS');
INSERT INTO `jenis_lab` VALUES ('16', 'ANALISA TINJA', 'HT');

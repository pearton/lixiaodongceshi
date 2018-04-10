/*
Navicat MySQL Data Transfer

Source Server         : maridb
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : gdsp

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-03-28 17:57:53
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for gdsp_admin
-- ----------------------------
DROP TABLE IF EXISTS `gdsp_admin`;
CREATE TABLE `gdsp_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '昵称',
  `tel` varchar(32) CHARACTER SET sjis NOT NULL COMMENT '电话号码',
  `pass` text NOT NULL COMMENT '密码',
  `updatetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '修改时间',
  `power` int(3) NOT NULL DEFAULT 1 COMMENT '权限',
  `createtime` int(11) NOT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='管理员表';

-- ----------------------------
-- Records of gdsp_admin
-- ----------------------------
INSERT INTO `gdsp_admin` VALUES ('1', '管理员', '15730711336', 'eyJpdiI6Ik5FVG1vaVBYeEV5d3RRMjlpRnVtSWc9PSIsInZhbHVlIjoiT3N1YkowUGN3XC9PUXR2NlFVUHZXZEE9PSIsIm1hYyI6IjczMWY2ODFhYTQwM2VmNGJjNDU5YjAwYWMyNTgwYTdlYThjZmU4ZDExMzkyMzY3M2FmZjk4NjBmMmRkMWIyNzUifQ==', '2018-03-08 15:12:08', '1', '0');
INSERT INTO `gdsp_admin` VALUES ('2', '管理员', '15310110930', 'eyJpdiI6IkhHQk9WaTZWcTBUOEpFREhCSWRJWWc9PSIsInZhbHVlIjoiSWNHeDFGRHA3ZVpcL1J1eWU5K2ZyOGc9PSIsIm1hYyI6IjBjZDNhYjVhMGMwNTU1NDY4MWU4YjQ0NDNhODMwNmZhNWQwOWFhNGIyYTA1NDA3M2Y4YzlkM2NlOGQ1ZTQyMjgifQ==', '2018-03-27 10:18:56', '1', '0');

-- ----------------------------
-- Table structure for gdsp_item
-- ----------------------------
DROP TABLE IF EXISTS `gdsp_item`;
CREATE TABLE `gdsp_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `styel` int(11) NOT NULL COMMENT '分类型/文件夹ID',
  `lv` int(11) NOT NULL COMMENT '分级ID',
  `name` varchar(255) NOT NULL COMMENT '文件名/在哪个文件夹下的真实名字',
  `title` varchar(255) NOT NULL COMMENT '标题',
  `url` text DEFAULT NULL COMMENT '封面图片地址',
  `status` int(1) NOT NULL DEFAULT 1 COMMENT '1-前台显示，2-不显示',
  `discr` text NOT NULL COMMENT '描述',
  `type` int(11) NOT NULL DEFAULT 1 COMMENT '1 视频 2 ppt 3 word',
  `updatetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '最后修改时间',
  `createtime` int(11) NOT NULL COMMENT '创建时间（时间戳）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COMMENT='数据列表';

-- ----------------------------
-- Records of gdsp_item
-- ----------------------------
INSERT INTO `gdsp_item` VALUES ('15', '7', '2', 'cat.mp4', 'cat.mp4', '空', '1', 'cat.mp4', '1', '2018-03-27 10:59:29', '1522119569');
INSERT INTO `gdsp_item` VALUES ('16', '7', '2', 'cat1.mp4', 'cat1.mp4', '空', '1', 'cat1.mp4', '1', '2018-03-27 10:59:29', '1522119569');
INSERT INTO `gdsp_item` VALUES ('21', '7', '17', 'cat.mp4', 'cat.mp4', '空', '1', 'cat.mp4', '1', '2018-03-28 12:00:55', '1522209655');
INSERT INTO `gdsp_item` VALUES ('22', '7', '17', 'cat1.mp4', 'cat1.mp4', '空', '1', 'cat1.mp4', '1', '2018-03-28 12:00:55', '1522209655');

-- ----------------------------
-- Table structure for gdsp_lv
-- ----------------------------
DROP TABLE IF EXISTS `gdsp_lv`;
CREATE TABLE `gdsp_lv` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '类型分级ID',
  `styel` int(11) NOT NULL COMMENT '分类文件夹id',
  `name` varchar(255) NOT NULL COMMENT '分级名',
  `dir_name` varchar(255) NOT NULL COMMENT '分级文件夹名',
  `discr` text DEFAULT NULL COMMENT '描述',
  `show` int(1) NOT NULL DEFAULT 1 COMMENT '1显示 2关闭',
  `updatetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '修改时间',
  `createtime` int(11) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='分级文件夹列表';

-- ----------------------------
-- Records of gdsp_lv
-- ----------------------------
INSERT INTO `gdsp_lv` VALUES ('2', '7', '二级', '7-2', '<p>慕课二级</p>', '1', '2018-03-09 13:02:53', '0');
INSERT INTO `gdsp_lv` VALUES ('3', '7', '三级', '7-3', '<p>阿斯顿</p>', '1', '2018-03-09 16:03:34', '1520566959');
INSERT INTO `gdsp_lv` VALUES ('4', '6', '一级', '6-1', '<p>锁定</p>', '1', '2018-03-09 11:46:44', '1520567204');
INSERT INTO `gdsp_lv` VALUES ('5', '12', 'asd', 'sad', '<p>sad</p>', '1', '2018-03-11 19:36:32', '1520768192');
INSERT INTO `gdsp_lv` VALUES ('6', '4', '一级', '4-1', null, '1', '2018-03-12 14:17:51', '1520768928');
INSERT INTO `gdsp_lv` VALUES ('8', '7', '四级', '7-4', '<p>四级</p>', '1', '2018-03-11 21:40:44', '1520775644');
INSERT INTO `gdsp_lv` VALUES ('9', '4', '测试', '4-3', '<p>测试分级<br/></p>', '1', '2018-03-27 10:37:35', '1522118255');
INSERT INTO `gdsp_lv` VALUES ('10', '6', '测试', '测试23', '<p>vessels<br/></p>', '1', '2018-03-27 10:38:28', '1522118308');
INSERT INTO `gdsp_lv` VALUES ('12', '13', '888', '888', '<p>888<br/></p>', '1', '2018-03-27 14:05:23', '1522130723');
INSERT INTO `gdsp_lv` VALUES ('17', '7', '一级', '7-1', '<p>顶顶顶</p>', '1', '2018-03-28 12:00:42', '1522209642');

-- ----------------------------
-- Table structure for gdsp_styel
-- ----------------------------
DROP TABLE IF EXISTS `gdsp_styel`;
CREATE TABLE `gdsp_styel` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键 编号',
  `name` varchar(33) NOT NULL COMMENT '分类名',
  `dir_name` varchar(255) NOT NULL COMMENT '文件夹名',
  `discr` text DEFAULT NULL COMMENT '描述',
  `show` int(1) NOT NULL DEFAULT 2 COMMENT '是否前台显示 1显示 2关闭',
  `type` int(1) NOT NULL DEFAULT 1 COMMENT '类型 1 文件夹 2 网站链接',
  `url` text DEFAULT NULL COMMENT '图片',
  `updatetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '最后修改时间',
  `createtime` int(11) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COMMENT='文件夹列表';

-- ----------------------------
-- Records of gdsp_styel
-- ----------------------------
INSERT INTO `gdsp_styel` VALUES ('3', '2D动画', '2D动画', '<p>2d动画：视频定制开发，从剧本-拍摄-后期一站式服务。从事多年有丰富的经验，曾多次获得重庆市大赛奖项</p>', '1', '1', 'uploads/styel/R1ZGuVMxsb.jpg', '2018-03-28 14:14:03', '1520495291');
INSERT INTO `gdsp_styel` VALUES ('4', '3d动画', '13D动画', '<p>3D动画：视频定制开发，从剧本-拍摄-后期一站式服务。从事多年有丰富的经验，曾多次获得重庆市大赛奖项</p>', '1', '1', 'uploads/styel/hXrkc0FgXi.jpg', '2018-03-27 11:28:34', '1520495298');
INSERT INTO `gdsp_styel` VALUES ('5', 'PPT', 'ppt', '<p>ppt：视频定制开发，从剧本-拍摄-后期一站式服务。从事多年有丰富的经验，曾多次获得重庆市大赛奖项</p>', '1', '1', 'uploads/styel/qSSbGIJs4w.jpg', '2018-03-15 11:01:22', '1520560640');
INSERT INTO `gdsp_styel` VALUES ('6', '微课', '微课', '<p>微课程：视频定制开发，从剧本-拍摄-后期一站式服务。从事多年有丰富的经验，曾多次获得重庆市大赛奖项</p>', '1', '1', 'uploads/styel/3iT889X4Uh.jpg', '2018-03-27 18:02:00', '1520560750');
INSERT INTO `gdsp_styel` VALUES ('7', '慕课', '慕课c', '<p>慕课http://test.lara.com/uploads/styel/wpUaIN3XG4.jpg</p>', '1', '1', 'uploads/styel/rNInNnVAnE.jpg', '2018-03-27 18:01:38', '1521002722');
INSERT INTO `gdsp_styel` VALUES ('8', '平台', '平台', '网站平台', '1', '2', 'uploads/styel/ntzWDW4ZQi.jpg', '2018-03-15 11:01:51', '1520563081');
INSERT INTO `gdsp_styel` VALUES ('9', '测试', '测试文件夹', '<p>测试文件<br/></p>', '2', '1', 'uploads/styel/45Pc3Xjvvx.jpg', '2018-03-27 18:02:34', '1522114741');
INSERT INTO `gdsp_styel` VALUES ('11', 'lililililil2', 'lilililili', '<p>lililililili11<br/></p>', '2', '1', 'uploads/styel/gHWiNZo9nG.jpg', '2018-03-28 10:09:57', '1522121790');

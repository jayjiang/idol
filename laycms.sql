/*
 Navicat Premium Data Transfer

 Source Server         : 本地数据库
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : localhost:3306
 Source Schema         : laycms

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 07/05/2020 23:18:27
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for sys_admin
-- ----------------------------
DROP TABLE IF EXISTS `sys_admin`;
CREATE TABLE `sys_admin`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '管理员ID',
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `headimg` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '管理员用户名',
  `fullname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '真实姓名',
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '邮箱',
  `password` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '管理员密码',
  `login_number` int(11) NULL DEFAULT NULL COMMENT '登录次数',
  `last_login_ip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '上次登陆ip',
  `last_login_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '上次登陆时间',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `update_time` int(10) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1可用0禁用',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sys_admin
-- ----------------------------
INSERT INTO `sys_admin` VALUES (1, 0, 'http://cdn.news.group.08510920.com\\picture/20200418\\50278318ad2a2ac4ba805c7ec46438fc.jpg', 'admin', '二人四季', '416716328@qq.com', 'MDAwMDAwMDAwMIGIgK20fYlk', 1, '', 0, 0, 1587178875, 1);
INSERT INTO `sys_admin` VALUES (4, 0, 'http://cdn.news.group.08510920.com\\picture/20200418\\225c9114b5b329fcefa6fbf6b8bec8b7.jpg', 'test', 'test', '79310286@qq.com', 'MDAwMDAwMDAwMIGIgK20fYlk', 1, '', 0, 1586342541, 1587178828, 1);
INSERT INTO `sys_admin` VALUES (5, 0, 'http://cdn.news.group.08510920.com\\picture/20200418\\3b8292daef6eae25a43aa4ef8c8284d7.jpg', 'user', 'user', '416716328@qq.com', 'MDAwMDAwMDAwMIGIgK20fYlk', 1, '', 0, 1587182941, 1587182974, 1);

-- ----------------------------
-- Table structure for sys_auth_group
-- ----------------------------
DROP TABLE IF EXISTS `sys_auth_group`;
CREATE TABLE `sys_auth_group`  (
  `update_time` int(11) NULL DEFAULT NULL,
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` char(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `create_time` int(11) NULL DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `rules` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sys_auth_group
-- ----------------------------
INSERT INTO `sys_auth_group` VALUES (1586238130, 10, '超级管理员', 1586238130, 1, '7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,34,35,36,31,30,32,33,37,38,39,40');
INSERT INTO `sys_auth_group` VALUES (1586342969, 11, '测试组', 1586342969, 1, '7,8,9,10,11,12,13,14,15,31,30,32,33');

-- ----------------------------
-- Table structure for sys_auth_group_access
-- ----------------------------
DROP TABLE IF EXISTS `sys_auth_group_access`;
CREATE TABLE `sys_auth_group_access`  (
  `uid` mediumint(8) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL,
  UNIQUE INDEX `uid_group_id`(`uid`, `group_id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `group_id`(`group_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sys_auth_group_access
-- ----------------------------
INSERT INTO `sys_auth_group_access` VALUES (1, 10);
INSERT INTO `sys_auth_group_access` VALUES (2, 10);
INSERT INTO `sys_auth_group_access` VALUES (3, 10);
INSERT INTO `sys_auth_group_access` VALUES (4, 11);
INSERT INTO `sys_auth_group_access` VALUES (5, 10);

-- ----------------------------
-- Table structure for sys_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `sys_auth_rule`;
CREATE TABLE `sys_auth_rule`  (
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '图标',
  `is_verify` int(10) NULL DEFAULT 1 COMMENT '是否验证权限',
  `params` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '参数',
  `name` char(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `title` char(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `type` tinyint(1) NOT NULL DEFAULT 1,
  `create_time` int(11) NULL DEFAULT NULL,
  `update_time` int(11) NULL DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `pid` int(11) NULL DEFAULT NULL,
  `is_menu` int(10) NULL DEFAULT NULL COMMENT '是否菜单',
  `condition` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `name`(`name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 41 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sys_auth_rule
-- ----------------------------
INSERT INTO `sys_auth_rule` VALUES (7, 'iconxitongguanli', 1, '', 'Index/index', '系统管理', 1, 1586225101, 1586225101, 1, 0, 1, NULL);
INSERT INTO `sys_auth_rule` VALUES (8, '', 1, '', 'Rule/lists', '菜单规则', 1, 1586225180, 1586225180, 1, 7, 1, NULL);
INSERT INTO `sys_auth_rule` VALUES (9, '', 1, '', 'Rule/created', '创建菜单规则', 1, 1586225293, 1586225293, 1, 8, 0, NULL);
INSERT INTO `sys_auth_rule` VALUES (10, '', 1, '', 'Rule/modify', '编辑菜单规则', 1, 1586225316, 1586225316, 1, 8, 0, NULL);
INSERT INTO `sys_auth_rule` VALUES (11, '', 1, '', 'Rule/deleted', '删除菜单规则', 1, 1586225347, 1586225347, 1, 8, 0, NULL);
INSERT INTO `sys_auth_rule` VALUES (12, 'fa fa-home', 0, '', 'System/config', '系统配置', 1, 1586225639, 1586225639, 1, 7, 1, NULL);
INSERT INTO `sys_auth_rule` VALUES (13, 'main', 1, '', 'Index/welcome', '系统欢迎页', 1, 1586313785, 1586313785, 1, 7, 0, NULL);
INSERT INTO `sys_auth_rule` VALUES (14, '', 1, '', 'User/lists', '用户管理', 1, 1586313828, 1586313828, 1, 7, 1, NULL);
INSERT INTO `sys_auth_rule` VALUES (15, '', 1, '', 'User/created', '创建用户', 1, 1586313856, 1586313856, 1, 14, 0, NULL);
INSERT INTO `sys_auth_rule` VALUES (16, '', 1, '', 'User/deleted', '删除用户', 1, 1586313874, 1586313874, 1, 14, 0, NULL);
INSERT INTO `sys_auth_rule` VALUES (17, '', 1, '', 'User/modify', '修改用户', 1, 1586313910, 1586313910, 1, 14, 0, NULL);
INSERT INTO `sys_auth_rule` VALUES (18, '', 1, '', 'Group/lists', '分组管理', 1, 1586313950, 1586313950, 1, 7, 1, NULL);
INSERT INTO `sys_auth_rule` VALUES (19, '', 1, '', 'Group/created', '创建权限组', 1, 1586313986, 1586313986, 1, 18, 0, NULL);
INSERT INTO `sys_auth_rule` VALUES (20, '', 1, '', 'Group/modify', '更新权限组', 1, 1586314012, 1586314012, 1, 18, 0, NULL);
INSERT INTO `sys_auth_rule` VALUES (21, '', 1, '', 'Group/deleted', '删除权限组', 1, 1586314028, 1586314028, 1, 18, 0, NULL);
INSERT INTO `sys_auth_rule` VALUES (22, '', 1, '', 'Group/rules', '权限组规则', 1, 1586314051, 1586314051, 1, 18, 0, NULL);
INSERT INTO `sys_auth_rule` VALUES (23, '', 1, '', 'Group/modifyRules', '更新权限组规则', 1, 1586314091, 1586314091, 1, 18, 0, NULL);
INSERT INTO `sys_auth_rule` VALUES (24, 'iconshangpinguanli', 1, '', 'Goods/Index', '商品管理', 1, 1586403924, 1586403924, 1, 0, 1, NULL);
INSERT INTO `sys_auth_rule` VALUES (25, 'fa fa-home', 1, '', 'Goods/lists', '商品列表', 1, 1586403967, 1586403967, 1, 24, 1, NULL);
INSERT INTO `sys_auth_rule` VALUES (26, 'fa fa-home', 1, '', 'Category/lists', '分类管理', 1, 1586404125, 1586404125, 1, 24, 1, NULL);
INSERT INTO `sys_auth_rule` VALUES (30, 'fa fa-home', 1, '', 'Picture/lists', '图片管理器', 1, 1587136691, 1587136691, 1, 31, 0, NULL);
INSERT INTO `sys_auth_rule` VALUES (31, '', 1, '', 'Picture/index', '图片管理器', 1, 1587136737, 1587136737, 1, 0, 0, NULL);
INSERT INTO `sys_auth_rule` VALUES (32, '', 1, '', 'Uploads/start', '文件上传', 1, 1587136897, 1587136897, 1, 31, 0, NULL);
INSERT INTO `sys_auth_rule` VALUES (33, 'fa fa-home', 1, '', 'Picture/deleted', '删除图片', 1, 1587177422, 1587177422, 1, 31, 0, NULL);
INSERT INTO `sys_auth_rule` VALUES (34, 'fa fa-home', 1, '', 'Goods/created', '添加商品', 1, 1587188173, 1587188173, 1, 24, 0, NULL);
INSERT INTO `sys_auth_rule` VALUES (35, 'fa fa-home', 1, '', 'Goods/addSpec', '新增规则组', 1, 1587259942, 1587259942, 1, 24, 0, NULL);
INSERT INTO `sys_auth_rule` VALUES (36, 'fa fa-home', 1, '', 'Goods/addSpecValue', '添加规则元素事件', 1, 1587259976, 1587259976, 1, 24, 0, NULL);
INSERT INTO `sys_auth_rule` VALUES (37, 'iconkefuchajian', 1, '', '', '插件管理', 1, 1588736607, 1588736607, 1, 0, 1, NULL);
INSERT INTO `sys_auth_rule` VALUES (38, 'fa fa-home', 1, '', 'Plugs/lists', '插件列表', 1, 1588736631, 1588736631, 1, 37, 1, NULL);
INSERT INTO `sys_auth_rule` VALUES (39, 'fa fa-home', 1, '', 'Plugs/conf', '插件配置', 1, 1588736648, 1588736648, 1, 37, 1, NULL);
INSERT INTO `sys_auth_rule` VALUES (40, 'fa fa-home', 1, '', 'Plugs/dev', '插件开发', 1, 1588738441, 1588738441, 1, 37, 1, NULL);

-- ----------------------------
-- Table structure for sys_goods
-- ----------------------------
DROP TABLE IF EXISTS `sys_goods`;
CREATE TABLE `sys_goods`  (
  `goods_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '商品id',
  `goods_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '商品名称',
  `category_id` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '商品分类id',
  `spec_type` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '商品规格(10单规格 20多规格)',
  `deduct_stock_type` tinyint(3) UNSIGNED NOT NULL DEFAULT 20 COMMENT '库存计算方式(10下单减库存 20付款减库存)',
  `content` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '商品详情',
  `sales_initial` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '初始销量',
  `sales_actual` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '实际销量',
  `goods_sort` int(11) UNSIGNED NOT NULL DEFAULT 100 COMMENT '商品排序(数字越小越靠前)',
  `delivery_id` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '配送模板id',
  `goods_status` tinyint(3) UNSIGNED NOT NULL DEFAULT 10 COMMENT '商品状态(10上架 20下架)',
  `is_delete` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否删除',
  `wxapp_id` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '小程序id',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`goods_id`) USING BTREE,
  INDEX `category_id`(`category_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for sys_goods_spec
-- ----------------------------
DROP TABLE IF EXISTS `sys_goods_spec`;
CREATE TABLE `sys_goods_spec`  (
  `goods_spec_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '商品规格id',
  `goods_id` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '商品id',
  `goods_no` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '商品编码',
  `goods_price` decimal(10, 2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '商品价格',
  `line_price` decimal(10, 2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '商品划线价',
  `stock_num` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '当前库存数量',
  `goods_sales` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '商品销量',
  `goods_weight` double unsigned NOT NULL COMMENT '商品重量(Kg)',
  `wxapp_id` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '小程序id',
  `spec_sku_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '商品spu标识',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`goods_spec_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for sys_goods_spec_rel
-- ----------------------------
DROP TABLE IF EXISTS `sys_goods_spec_rel`;
CREATE TABLE `sys_goods_spec_rel`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `goods_id` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '商品id',
  `spec_id` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '规格组id',
  `spec_value_id` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '规格值id',
  `wxapp_id` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '小程序id',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for sys_picture
-- ----------------------------
DROP TABLE IF EXISTS `sys_picture`;
CREATE TABLE `sys_picture`  (
  `pic_id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL COMMENT '存储的路径',
  `action` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT '' COMMENT 'local  public aliyun qiniu qcloud',
  `create_time` int(11) NULL DEFAULT NULL COMMENT '上传时间',
  `orig_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL COMMENT '原文件路径',
  `user_id` int(11) NULL DEFAULT NULL COMMENT '操作人',
  PRIMARY KEY (`pic_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 27 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sys_picture
-- ----------------------------
INSERT INTO `sys_picture` VALUES (21, 'http://cdn.news.group.08510920.com\\picture/20200418\\5e20a840a90002349ce6ed3af9a42372.jpg', 'public', 1587181896, 'http://cdn.news.group.08510920.com\\picture/20200418\\5e20a840a90002349ce6ed3af9a42372.jpg', 4);
INSERT INTO `sys_picture` VALUES (22, 'http://cdn.news.group.08510920.com\\picture/20200418\\3b8292daef6eae25a43aa4ef8c8284d7.jpg', 'public', 1587181931, 'http://cdn.news.group.08510920.com\\picture/20200418\\3b8292daef6eae25a43aa4ef8c8284d7.jpg', 4);
INSERT INTO `sys_picture` VALUES (23, 'http://cdn.news.group.08510920.com\\picture/20200418\\2927a49b231acbbd7b09c250b05409fe.jpg', 'public', 1587181942, 'http://cdn.news.group.08510920.com\\picture/20200418\\2927a49b231acbbd7b09c250b05409fe.jpg', 4);
INSERT INTO `sys_picture` VALUES (24, 'http://cdn.news.group.08510920.com\\picture/20200418\\95a06f21e02018d33d42078592afbaa5.jpg', 'public', 1587189832, 'http://cdn.news.group.08510920.com\\picture/20200418\\95a06f21e02018d33d42078592afbaa5.jpg', 1);
INSERT INTO `sys_picture` VALUES (25, 'http://cdn.news.group.08510920.com\\picture/20200418\\a8ee2a93af1d8e28ca70c4f786c36796.jpg', 'public', 1587189863, 'http://cdn.news.group.08510920.com\\picture/20200418\\a8ee2a93af1d8e28ca70c4f786c36796.jpg', 1);
INSERT INTO `sys_picture` VALUES (26, 'http://cdn.news.group.08510920.com\\picture/20200418\\f460387ac0848cba4933900a8084d126.jpg', 'public', 1587189900, 'http://cdn.news.group.08510920.com\\picture/20200418\\f460387ac0848cba4933900a8084d126.jpg', 1);
INSERT INTO `sys_picture` VALUES (20, 'http://cdn.news.group.08510920.com\\picture/20200418\\55f3d338f1381b65f33f7059b3f41932.jpg', 'public', 1587181884, 'http://cdn.news.group.08510920.com\\picture/20200418\\55f3d338f1381b65f33f7059b3f41932.jpg', 4);

-- ----------------------------
-- Table structure for sys_spec
-- ----------------------------
DROP TABLE IF EXISTS `sys_spec`;
CREATE TABLE `sys_spec`  (
  `spec_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '规格组id',
  `spec_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '规格组名称',
  `wxapp_id` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '小程序id',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`spec_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for sys_spec_value
-- ----------------------------
DROP TABLE IF EXISTS `sys_spec_value`;
CREATE TABLE `sys_spec_value`  (
  `spec_value_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '规格值id',
  `spec_value` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '规格值',
  `spec_id` int(11) NOT NULL COMMENT '规格组id',
  `wxapp_id` int(11) NULL DEFAULT NULL COMMENT '小程序id',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`spec_value_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;

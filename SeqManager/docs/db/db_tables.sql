

DROP TABLE IF EXISTS `wjl_auth`;
CREATE TABLE `wjl_auth` (
`auth_id` smallint(6) UNSIGNED NULL AUTO_INCREMENT,
`auth_name` varchar(30) NOT NULL,
`auth_pid` smallint(6) NULL,
`auth_c` varchar(32) NULL,
`auth_a` varchar(32) NULL,
`auth_path` varchar(32) NULL,
`auth_level` tinyint(4) NULL,
PRIMARY KEY (`auth_id`),
UNIQUE KEY `auth_name` (`auth_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

alter table wjl_auth add `auth_time` int(10) default 1473822830;#  after `auth_level`;
alter table wjl_auth add `auth_mod_time` int(10) default 1473822831;



CREATE TABLE `wjl_role` (
`role_id` smallint(6) NULL AUTO_INCREMENT,
`role_name` varchar(30) NOT NULL,
`role_auth_ids` text NULL,
`role_auth_ac` text NOT NULL,
PRIMARY KEY (`role_id`),
UNIQUE KEY `role_name` (`role_name`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

alter table wjl_role add `auth_time` int(10) default 1473822930;#  after `auth_level`;
alter table wjl_role add `auth_mod_time` int(10) default 1473822931;


CREATE TABLE `wjl_manager` (
`mg_id` int(11) NOT NULL AUTO_INCREMENT,
`mg_name` varchar(30) NOT NULL,
`mg_pwd` varchar(32) NULL,
`mg_role_id` tinyint(3) NULL,
`mg_time` int(10) NULL,
`mg_mod_time` int(10) NULL,
PRIMARY KEY (`mg_id`),
UNIQUE KEY `mg_name` (`mg_name`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

alter table wjl_auth add `auth_uid` smallint(6) default 1;
alter table wjl_role add `role_uid` smallint(6) default 1;
alter table wjl_manager add `mg_uid` smallint(6) default 1;

alter table wjl_auth add `condition` smallint(1) NOT NULL DEFAULT '1';# 正常为1，进回收站为0，回收站内可删除或恢复
alter table wjl_role add `condition` smallint(1) NOT NULL DEFAULT '1';# 正常为1，进回收站为0，回收站内可删除或恢复
alter table wjl_manager add `condition` smallint(1) NOT NULL DEFAULT '1';# 正常为1，进回收站为0，回收站内可删除或恢复


-- 前三个表示已经添加过的，后几个表是刚新添加的。

DROP TABLE IF EXISTS `wjl_fridge`;
CREATE TABLE `wjl_fridge` (
`fr_id` smallint(6) NOT NULL AUTO_INCREMENT,
`fr_name` varchar(100) NOT NULL,
`fr_place` text NULL,
`fr_note` text NULL,
`fr_uid` smallint(6) NULL,
`condition` smallint(1) NOT NULL DEFAULT '1',# 正常为1，进回收站为0，回收站内可删除或恢复
`fr_time` int(10) NULL,
`fr_mod_time` int(10) NULL,
PRIMARY KEY (`fr_id`),
CONSTRAINT un_code UNIQUE (`fr_name`,`fr_uid`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- unique key : http://www.w3school.com.cn/sql/sql_unique.asp



DROP TABLE IF EXISTS `wjl_box`;
CREATE TABLE `wjl_box` (
`box_id` smallint(6) UNSIGNED NULL AUTO_INCREMENT,
`box_name` varchar(100) NOT NULL,
`box_place` text NULL,
`box_note` text NULL,
`condition` smallint(1) NOT NULL DEFAULT '1',# 正常为1，进回收站为0，回收站内可删除或恢复
`box_fr_id` smallint(6) NULL,
`box_uid` smallint(6) NULL,
`box_time` int(10) NULL,
`box_mod_time` int(10) NULL,
PRIMARY KEY (`box_id`),
CONSTRAINT un_code UNIQUE (`box_name`,`box_uid`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;




DROP TABLE IF EXISTS `wjl_cate`;
CREATE TABLE `wjl_cate` (
`cate_id` smallint(6) NULL AUTO_INCREMENT,
`cate_name` varchar(100) NOT NULL,
`cate_uid` smallint(6) NULL,
`condition` smallint(1) NOT NULL DEFAULT '1',# 正常为1，进回收站为0，回收站内可删除或恢复
`cate_time` int(10) NULL,
`cate_mod_time` int(10) NULL,
PRIMARY KEY (`cate_id`) 
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE wjl_cate
ADD CONSTRAINT uc_code UNIQUE (`cate_name`,`cate_uid`);



DROP TABLE IF EXISTS `wjl_tag`;
CREATE TABLE `wjl_tag` (
`tag_id` smallint(6) NULL AUTO_INCREMENT,
`tag_name` varchar(100) NOT NULL,
`tag_uid` smallint(6) NULL,
`condition` smallint(1) NOT NULL DEFAULT '1',# 正常为1，进回收站为0，回收站内可删除或恢复
`tag_time` int(10) NULL,
`tag_mod_time` int(10) NULL,
PRIMARY KEY (`tag_id`) 
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE wjl_tag
ADD CONSTRAINT uc_code UNIQUE (`tag_name`,`tag_uid`);




DROP TABLE IF EXISTS `wjl_seq`;
CREATE TABLE `wjl_seq` (
`seq_id` smallint(6) NULL AUTO_INCREMENT,
`seq_name` varchar(100) NOT NULL,
`seq_order_no` varchar(20) NULL,
`seq_sequence` text NULL,
`seq_en_site` varchar(20) NULL,
`seq_note` text NULL,
`file_ids` varchar(20) NULL,
`seq_time` int(10) NULL,
`seq_mod_time` int(10) NULL,
`cate_id` int(10) NULL,
`tag_ids` varchar(100) NULL,
`box_id` smallint(6) NULL,
`place` varchar(20) NULL,
`condition` smallint(1) NOT NULL DEFAULT '1',# 正常为1，进回收站为0，回收站内可删除或恢复
`seq_oligo_ids` varchar(20) NULL,
`seq_uid` smallint(6) NULL,
PRIMARY KEY (`seq_id`) 
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

alter table wjl_seq add `seq_sequence_only` text default '' after `seq_sequence`;



DROP TABLE IF EXISTS `wjl_oligo`;
CREATE TABLE `wjl_oligo` (
`oligo_id` smallint(6) NULL AUTO_INCREMENT,
`oligo_name` varchar(100) NOT NULL,
`oligo_order_no` varchar(20) NULL,
`oligo_sequence` text NULL,
`oligo_en_site` varchar(20) NULL,
`oligo_note` text NULL,
`file_ids` varchar(20) NULL,
`oligo_time` int(10) NULL,
`oligo_mod_time` int(10) NULL,
`cate_id` int(10) NULL,
`tag_ids` varchar(100) NULL,
`box_id` smallint(6) NULL,
`place` varchar(20) NULL,
`condition` smallint(1) NOT NULL DEFAULT '1',# 正常为1，进回收站为0，回收站内可删除或恢复
`oligo_uid` smallint(6) NULL,
PRIMARY KEY (`oligo_id`) 
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

alter table wjl_seq add `oligo_sequence_only` text default '' after `oligo_sequence`;




DROP TABLE IF EXISTS `wjl_file`;
CREATE TABLE `wjl_file` (
`file_id` smallint(6) NOT NULL AUTO_INCREMENT,
`file_name` varchar(100) NOT NULL,
`file_note` text NULL,
`file_path` varchar(50) NULL,

`size` int(50) NULL,
`type` varchar(20) NULL,
`ext` varchar(20) NULL,

`file_time` int(10) NULL,
`file_mod_time` int(10) NULL,
`cate_id` int(10) NULL,
`tag_ids` varchar(100) NULL,
`file_uid` smallint(6) NULL,
`condition` smallint(1) NOT NULL DEFAULT '1',# 正常为1，进回收站为0，回收站内可删除或恢复
PRIMARY KEY (`file_id`),
UNIQUE KEY `file_path` (`file_path`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- 为独立上传的文件加一个数据库标示符号 isAttach(0是独立文件，1是附件(默认))

alter table wjl_file add `isAttach` int(1) default 1 after `condition`;


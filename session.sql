#存储session的数据表示列结构,可作为参考
#创建数据库(可选)
CREATE DATABASE session;
#使用创建的数据库(可选)
USE session;
#创建存储session的数据表(必须)
CREATE TABLE `session` (
  `session_id` varchar(255) NOT NULL,
  `session_data` blob,
  `session_time` int(11) NOT NULL,
  UNIQUE KEY `session_id` (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
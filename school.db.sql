/*
MySQL Backup
Source Server Version: 5.5.27
Source Database: sch007
Date: 6/24/2016 08:55:54
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
--  Table structure for `academic_years`
-- ----------------------------
DROP TABLE IF EXISTS `academic_years`;
CREATE TABLE `academic_years` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `reg_date` datetime DEFAULT NULL,
  `reg_user` int(11) DEFAULT NULL,
  `inactive` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `ci_sessions`
-- ----------------------------
DROP TABLE IF EXISTS `ci_sessions`;
CREATE TABLE `ci_sessions` (
  `id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` longtext NOT NULL,
  PRIMARY KEY (`id`),
  KEY `last_activity_idx` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `courses`
-- ----------------------------
DROP TABLE IF EXISTS `courses`;
CREATE TABLE `courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) DEFAULT NULL,
  `name` varchar(150) DEFAULT NULL,
  `description` varchar(250) DEFAULT NULL,
  `reg_date` datetime DEFAULT NULL,
  `reg_user` int(11) DEFAULT NULL,
  `inactive` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `course_batches`
-- ----------------------------
DROP TABLE IF EXISTS `course_batches`;
CREATE TABLE `course_batches` (
  `id` int(11) NOT NULL,
  `code` varchar(50) DEFAULT NULL,
  `name` varchar(150) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `reg_date` datetime DEFAULT NULL,
  `reg_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `course_subjects`
-- ----------------------------
DROP TABLE IF EXISTS `course_subjects`;
CREATE TABLE `course_subjects` (
  `id` varchar(255) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `images`
-- ----------------------------
DROP TABLE IF EXISTS `images`;
CREATE TABLE `images` (
  `img_id` int(11) NOT NULL AUTO_INCREMENT,
  `img_file_name` longtext,
  `img_path` longtext,
  `img_ref_id` int(11) DEFAULT NULL,
  `img_tbl` varchar(50) DEFAULT NULL,
  `img_blob` longblob,
  `datetime` datetime DEFAULT NULL,
  `disabled` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`img_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `references`
-- ----------------------------
DROP TABLE IF EXISTS `references`;
CREATE TABLE `references` (
  `id` int(11) NOT NULL,
  `title` varchar(200) DEFAULT NULL,
  `next_ref` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `settings`
-- ----------------------------
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `code` varchar(150) NOT NULL,
  `category` varchar(150) DEFAULT NULL,
  `value` longtext,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `students`
-- ----------------------------
DROP TABLE IF EXISTS `students`;
CREATE TABLE `students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(150) DEFAULT NULL,
  `fname` varchar(150) DEFAULT NULL,
  `mname` varchar(150) DEFAULT NULL,
  `lname` varchar(150) DEFAULT NULL,
  `suffix` varchar(150) DEFAULT NULL,
  `sex` varchar(25) DEFAULT NULL,
  `blood_type` varchar(15) DEFAULT NULL,
  `bday` date DEFAULT NULL,
  `bday_place` varchar(150) DEFAULT NULL,
  `nationality` varchar(150) DEFAULT NULL,
  `language` varchar(150) DEFAULT NULL,
  `religion` varchar(150) DEFAULT NULL,
  `pres_address` varchar(250) DEFAULT NULL,
  `perm_address` varchar(250) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `mobile` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `inactive` tinyint(1) DEFAULT '0',
  `reg_date` datetime DEFAULT NULL,
  `reg_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `student_details`
-- ----------------------------
DROP TABLE IF EXISTS `student_details`;
CREATE TABLE `student_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) DEFAULT NULL,
  `fathers_name` varchar(150) DEFAULT NULL,
  `fathers_contact_no` varchar(150) DEFAULT NULL,
  `fathers_job` varchar(150) DEFAULT NULL,
  `mothers_name` varchar(150) DEFAULT NULL,
  `mothers_contact_no` varchar(150) DEFAULT NULL,
  `mothers_job` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `student_guardians`
-- ----------------------------
DROP TABLE IF EXISTS `student_guardians`;
CREATE TABLE `student_guardians` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) DEFAULT NULL,
  `name` varchar(150) DEFAULT NULL,
  `relation` varchar(150) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `mobile` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `reg_date` datetime DEFAULT NULL,
  `reg_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `subjects`
-- ----------------------------
DROP TABLE IF EXISTS `subjects`;
CREATE TABLE `subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) DEFAULT NULL,
  `name` varchar(150) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `reg_date` datetime DEFAULT NULL,
  `reg_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fname` varchar(55) DEFAULT NULL,
  `mname` varchar(55) DEFAULT NULL,
  `lname` varchar(55) DEFAULT NULL,
  `suffix` varchar(55) DEFAULT NULL,
  `role` int(11) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `contact_no` varchar(50) DEFAULT NULL,
  `reg_date` datetime DEFAULT NULL,
  `inactive` int(11) DEFAULT '0',
  PRIMARY KEY (`id`,`username`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `user_roles`
-- ----------------------------
DROP TABLE IF EXISTS `user_roles`;
CREATE TABLE `user_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role` varchar(50) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `access` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records 
-- ----------------------------
INSERT INTO `academic_years` VALUES ('1','School Year 2016 - 2017','2016-06-06','2017-03-31','2016-06-23 08:31:03','1','0'), ('2','School Year 2015 - 2016','2015-06-08','2016-03-31','2016-06-23 15:51:41','1','0');
INSERT INTO `ci_sessions` VALUES ('32ad99345dbafdca88ba248765dc9deac7b4564f','::1','','1455238860','__ci_last_regenerate|i:1455237556;user|a:11:{s:2:\"id\";s:1:\"1\";s:8:\"username\";s:5:\"admin\";s:5:\"fname\";s:3:\"Rey\";s:5:\"lname\";s:6:\"Tejada\";s:5:\"mname\";s:6:\"Coloma\";s:6:\"suffix\";s:3:\"Jr.\";s:9:\"full_name\";s:21:\"Rey Coloma Tejada Jr.\";s:7:\"role_id\";s:1:\"1\";s:4:\"role\";s:14:\"Administrator \";s:6:\"access\";s:3:\"all\";s:3:\"img\";s:45:\"http://localhost/AdminRTJ/dist/img/avatar.png\";}'), ('6163eb807b76aa1e5fab339a600d0a5bfa71efe2','::1','','1455242320','__ci_last_regenerate|i:1455239045;user|a:11:{s:2:\"id\";s:1:\"1\";s:8:\"username\";s:5:\"admin\";s:5:\"fname\";s:3:\"Rey\";s:5:\"lname\";s:6:\"Tejada\";s:5:\"mname\";s:6:\"Coloma\";s:6:\"suffix\";s:3:\"Jr.\";s:9:\"full_name\";s:21:\"Rey Coloma Tejada Jr.\";s:7:\"role_id\";s:1:\"1\";s:4:\"role\";s:14:\"Administrator \";s:6:\"access\";s:3:\"all\";s:3:\"img\";s:45:\"http://localhost/AdminRTJ/dist/img/avatar.png\";}'), ('7609d4f1ee54cf0c092b86180c1e902d1e730410','::1','','1454543304','__ci_last_regenerate|i:1454542937;user|a:11:{s:2:\"id\";s:1:\"1\";s:8:\"username\";s:5:\"admin\";s:5:\"fname\";s:3:\"Rey\";s:5:\"lname\";s:6:\"Tejada\";s:5:\"mname\";s:6:\"Coloma\";s:6:\"suffix\";s:3:\"Jr.\";s:9:\"full_name\";s:21:\"Rey Coloma Tejada Jr.\";s:7:\"role_id\";s:1:\"1\";s:4:\"role\";s:14:\"Administrator \";s:6:\"access\";s:3:\"all\";s:3:\"img\";s:45:\"http://localhost/AdminRTJ/dist/img/avatar.png\";}'), ('9f59087e9df86e85db0978def4ac275ef10833b8','::1','','1454461670','__ci_last_regenerate|i:1454461631;user|a:11:{s:2:\"id\";s:1:\"1\";s:8:\"username\";s:5:\"admin\";s:5:\"fname\";s:3:\"Rey\";s:5:\"lname\";s:6:\"Tejada\";s:5:\"mname\";s:6:\"Coloma\";s:6:\"suffix\";s:3:\"Jr.\";s:9:\"full_name\";s:21:\"Rey Coloma Tejada Jr.\";s:7:\"role_id\";s:1:\"1\";s:4:\"role\";s:14:\"Administrator \";s:6:\"access\";s:3:\"all\";s:3:\"img\";s:45:\"http://localhost/AdminRTJ/dist/img/avatar.png\";}'), ('a07909244f2d5abc5e49cd524c78bc77c9704738','::1','','1455243002','__ci_last_regenerate|i:1455242466;user|a:11:{s:2:\"id\";s:1:\"1\";s:8:\"username\";s:5:\"admin\";s:5:\"fname\";s:3:\"Rey\";s:5:\"lname\";s:6:\"Tejada\";s:5:\"mname\";s:6:\"Coloma\";s:6:\"suffix\";s:3:\"Jr.\";s:9:\"full_name\";s:21:\"Rey Coloma Tejada Jr.\";s:7:\"role_id\";s:1:\"1\";s:4:\"role\";s:14:\"Administrator \";s:6:\"access\";s:3:\"all\";s:3:\"img\";s:45:\"http://localhost/AdminRTJ/dist/img/avatar.png\";}'), ('aed622ed5a5bda37e82a758ed1d43de31474bc5f','::1','','1455250337','__ci_last_regenerate|i:1455243310;user|a:11:{s:2:\"id\";s:1:\"1\";s:8:\"username\";s:5:\"admin\";s:5:\"fname\";s:3:\"Rey\";s:5:\"lname\";s:6:\"Tejada\";s:5:\"mname\";s:6:\"Coloma\";s:6:\"suffix\";s:3:\"Jr.\";s:9:\"full_name\";s:21:\"Rey Coloma Tejada Jr.\";s:7:\"role_id\";s:1:\"1\";s:4:\"role\";s:14:\"Administrator \";s:6:\"access\";s:3:\"all\";s:3:\"img\";s:45:\"http://localhost/AdminRTJ/dist/img/avatar.png\";}'), ('dd130bb1740f6e6c435d5e43a314e5012962ae26','::1','','1454397478','__ci_last_regenerate|i:1454380694;user|a:11:{s:2:\"id\";s:1:\"1\";s:8:\"username\";s:5:\"admin\";s:5:\"fname\";s:3:\"Rey\";s:5:\"lname\";s:6:\"Tejada\";s:5:\"mname\";s:6:\"Coloma\";s:6:\"suffix\";s:3:\"Jr.\";s:9:\"full_name\";s:21:\"Rey Coloma Tejada Jr.\";s:7:\"role_id\";s:1:\"1\";s:4:\"role\";s:14:\"Administrator \";s:6:\"access\";s:3:\"all\";s:3:\"img\";s:45:\"http://localhost/AdminRTJ/dist/img/avatar.png\";}'), ('e0a1ba2901556fac1645c82e51fb137bdc09fc45','::1','','1454546361','__ci_last_regenerate|i:1454544132;user|a:11:{s:2:\"id\";s:1:\"1\";s:8:\"username\";s:5:\"admin\";s:5:\"fname\";s:3:\"Rey\";s:5:\"lname\";s:6:\"Tejada\";s:5:\"mname\";s:6:\"Coloma\";s:6:\"suffix\";s:3:\"Jr.\";s:9:\"full_name\";s:21:\"Rey Coloma Tejada Jr.\";s:7:\"role_id\";s:1:\"1\";s:4:\"role\";s:14:\"Administrator \";s:6:\"access\";s:3:\"all\";s:3:\"img\";s:45:\"http://localhost/AdminRTJ/dist/img/avatar.png\";}');
INSERT INTO `courses` VALUES ('1','CRSE001','Kindergarten','Kids in garten','2016-06-23 08:18:42','1','0');
INSERT INTO `course_batches` VALUES ('1','CRSB001','Kindergarten 2016 - 2017','1','2016-06-06','2017-03-31','2016-06-23 08:23:30','1');
INSERT INTO `course_subjects` VALUES ('1','1','1');
INSERT INTO `images` VALUES ('1','2.png','uploads/users/2.png','2','users',NULL,'2016-02-12 08:23:10','0'), ('5','1.png','uploads/users/1.png','1','users',NULL,'2016-02-12 08:30:45','0'), ('6','3.png','uploads/users/3.png','3','users',NULL,'2016-02-12 08:33:04','0'), ('7','5.png','uploads/users/5.png','5','users',NULL,'2016-02-12 08:37:36','0'), ('8','6.png','uploads/users/6.png','6','users',NULL,'2016-02-12 08:37:41','0'), ('9','7.png','uploads/users/7.png','7','users',NULL,'2016-02-12 08:37:41','0'), ('11','9.png','uploads/users/9.png','9','users',NULL,'2016-02-12 08:40:22','0'), ('12','8.png','uploads/users/8.png','8','users',NULL,'2016-02-12 08:45:13','0'), ('13','4.png','uploads/users/4.png','4','users',NULL,'2016-02-12 08:50:13','0'), ('14','10.png','uploads/users/10.png','10','users',NULL,'2016-02-12 09:43:46','0'), ('15','1.jpg','uploads/students/1.jpg','1','students',NULL,'2016-06-24 07:58:36','0');
INSERT INTO `references` VALUES ('1','Student Code','STD0002');
INSERT INTO `settings` VALUES ('comp_address','company',NULL), ('comp_contact_no','company',NULL), ('comp_email','company',NULL), ('comp_logo','company',NULL), ('comp_name','company','Sch007'), ('comp_tin','company',NULL);
INSERT INTO `students` VALUES ('1','STD0001','Kaya','Haber','Tejada','','female','0+','2013-01-17','Pasig City','Filipino','Filipino','Christian','1013 Kamagong Street Napico Pasig City','1013 Kamagong Street Napico Pasig City','02 893 8371','0917 555 0682','rey.tejada01@gmail.com','0','2016-06-24 07:15:44','1');
INSERT INTO `student_details` VALUES ('1','1','Reynaldo C. Tejada Jr','0917 555 06 82','Programmer','Karlene Haber','0917 222 888','Teacher');
INSERT INTO `student_guardians` VALUES ('1','1','Rey Tejada','Father','1013 Kamagong Street Napico Pasig City','02 898 3813','0987 737 1737','rey.tejada01@gmail.com','2016-06-24 07:34:16','1');
INSERT INTO `subjects` VALUES ('1','ENG0001','English Kinder','Teach English','2016-06-24 07:38:01','1'), ('2','ENG0002','English Nursery','Teach English ','2016-06-24 08:10:49','1');
INSERT INTO `users` VALUES ('1','admin','5f4dcc3b5aa765d61d8327deb882cf99','Rey','','Reynalds','','1','rey.tejada01@gmail.com','0917-555-06-82','2014-06-16 14:41:31','0'), ('2','karlene','5f4dcc3b5aa765d61d8327deb882cf99','Karlene','','Haber','','2','email@email.com','1234567','2016-02-12 08:32:05','0'), ('3','joe','5f4dcc3b5aa765d61d8327deb882cf99','John','','Doe','','2','','','2016-02-12 08:33:04','0'), ('4','kaneki','5f4dcc3b5aa765d61d8327deb882cf99','Kaneki','','Ken','','1','','','2016-02-12 08:33:35','0'), ('8','asd','7815696ecbf1c96e6894b779456d330e','Orlando','','Bloom','','2','','','2016-02-12 08:39:04','0'), ('9','madona','a8f5f167f44f4964e6c998dee827110c','Mad','','Dona','','2','','','2016-02-12 08:40:22','0'), ('10','junji','5f4dcc3b5aa765d61d8327deb882cf99','Jun Ji','','Hyun','','2','','','2016-02-12 09:43:45','0');
INSERT INTO `user_roles` VALUES ('1','Administrator ','System Administrator','all'), ('2','Teacher','Teacher','control,users'), ('3','Principal','Principal','control,users,roles');

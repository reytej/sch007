/*
MySQL Backup
Source Server Version: 5.5.25
Source Database: sch007
Date: 7/24/2016 20:09:10
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
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` longtext NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) DEFAULT NULL,
  `name` varchar(150) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `reg_date` datetime DEFAULT NULL,
  `reg_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `course_batch_schedules`
-- ----------------------------
DROP TABLE IF EXISTS `course_batch_schedules`;
CREATE TABLE `course_batch_schedules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) DEFAULT NULL,
  `batch_id` int(11) DEFAULT NULL,
  `section_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `day` varchar(50) DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `course_batch_sections`
-- ----------------------------
DROP TABLE IF EXISTS `course_batch_sections`;
CREATE TABLE `course_batch_sections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `batch_id` int(11) DEFAULT NULL,
  `section_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `course_items`
-- ----------------------------
DROP TABLE IF EXISTS `course_items`;
CREATE TABLE `course_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `course_subjects`
-- ----------------------------
DROP TABLE IF EXISTS `course_subjects`;
CREATE TABLE `course_subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `enrolls`
-- ----------------------------
DROP TABLE IF EXISTS `enrolls`;
CREATE TABLE `enrolls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trans_ref` varchar(50) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `batch_id` int(11) DEFAULT NULL,
  `section_id` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `pay_term_id` int(11) DEFAULT NULL,
  `no_months` int(11) DEFAULT NULL,
  `day_of_month` int(11) DEFAULT NULL,
  `total_amount` double DEFAULT '0',
  `trans_date` date DEFAULT NULL,
  `reg_date` datetime DEFAULT NULL,
  `reg_user` int(11) DEFAULT NULL,
  `inactive` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `enroll_items`
-- ----------------------------
DROP TABLE IF EXISTS `enroll_items`;
CREATE TABLE `enroll_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `enroll_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `uom` varchar(25) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `discount` double DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `enroll_payments`
-- ----------------------------
DROP TABLE IF EXISTS `enroll_payments`;
CREATE TABLE `enroll_payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `enroll_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `pay` double DEFAULT '0',
  `pay_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `enroll_subjects`
-- ----------------------------
DROP TABLE IF EXISTS `enroll_subjects`;
CREATE TABLE `enroll_subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `enroll_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `items`
-- ----------------------------
DROP TABLE IF EXISTS `items`;
CREATE TABLE `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) DEFAULT NULL,
  `name` varchar(150) DEFAULT NULL,
  `description` varchar(250) DEFAULT NULL,
  `uom` varchar(20) DEFAULT NULL,
  `price` double DEFAULT '0',
  `cat_id` int(11) DEFAULT NULL,
  `type` varchar(150) DEFAULT NULL,
  `tax_type_id` int(11) DEFAULT NULL,
  `inactive` tinyint(1) DEFAULT '0',
  `reg_date` datetime DEFAULT NULL,
  `reg_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `item_categories`
-- ----------------------------
DROP TABLE IF EXISTS `item_categories`;
CREATE TABLE `item_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) DEFAULT NULL,
  `uom` varchar(20) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `tax_type_id` int(11) DEFAULT NULL,
  `inactive` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `payments`
-- ----------------------------
DROP TABLE IF EXISTS `payments`;
CREATE TABLE `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trans_ref` varchar(50) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `trans_date` date DEFAULT NULL,
  `total_amount` double DEFAULT '0',
  `remarks` longtext,
  `reg_date` datetime DEFAULT NULL,
  `reg_user` int(11) DEFAULT NULL,
  `inactive` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `payment_details`
-- ----------------------------
DROP TABLE IF EXISTS `payment_details`;
CREATE TABLE `payment_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pay_id` int(11) DEFAULT NULL,
  `type` varchar(25) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `bank` varchar(150) DEFAULT NULL,
  `branch` varchar(150) DEFAULT NULL,
  `ref_no` varchar(150) DEFAULT NULL,
  `approval_code` varchar(150) DEFAULT NULL,
  `check_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `payment_for`
-- ----------------------------
DROP TABLE IF EXISTS `payment_for`;
CREATE TABLE `payment_for` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pay_id` int(11) DEFAULT NULL,
  `src_type` int(11) DEFAULT NULL,
  `src_id` int(11) DEFAULT NULL,
  `src_det_id` int(11) DEFAULT NULL,
  `amount` double DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `payment_terms`
-- ----------------------------
DROP TABLE IF EXISTS `payment_terms`;
CREATE TABLE `payment_terms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) DEFAULT NULL,
  `reserve` double DEFAULT NULL,
  `reserve_` tinyint(1) DEFAULT '0',
  `dp` double DEFAULT NULL,
  `dp_` tinyint(1) DEFAULT '0',
  `dp_1` tinyint(1) DEFAULT '0',
  `divide` int(11) DEFAULT NULL,
  `day` int(11) DEFAULT NULL,
  `inactive` tinyint(1) DEFAULT '0',
  `reg_date` datetime DEFAULT NULL,
  `reg_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

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
--  Table structure for `sections`
-- ----------------------------
DROP TABLE IF EXISTS `sections`;
CREATE TABLE `sections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(25) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `reg_date` datetime DEFAULT NULL,
  `reg_user` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

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
  `enroll_id` int(11) DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `student_activities`
-- ----------------------------
DROP TABLE IF EXISTS `student_activities`;
CREATE TABLE `student_activities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `batch_id` int(11) DEFAULT NULL,
  `section_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `trans_date` date DEFAULT NULL,
  `title` varchar(150) DEFAULT NULL,
  `description` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `student_attendance`
-- ----------------------------
DROP TABLE IF EXISTS `student_attendance`;
CREATE TABLE `student_attendance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) DEFAULT NULL,
  `batch_id` int(11) DEFAULT NULL,
  `section_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `trans_date` date DEFAULT NULL,
  `status` varchar(25) DEFAULT NULL,
  `late_time_in` time DEFAULT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `reg_date` datetime DEFAULT NULL,
  `reg_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `tax_types`
-- ----------------------------
DROP TABLE IF EXISTS `tax_types`;
CREATE TABLE `tax_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `percent` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `trans_refs`
-- ----------------------------
DROP TABLE IF EXISTS `trans_refs`;
CREATE TABLE `trans_refs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) DEFAULT NULL,
  `trans_ref` varchar(55) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `inactive` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `trans_types`
-- ----------------------------
DROP TABLE IF EXISTS `trans_types`;
CREATE TABLE `trans_types` (
  `type_id` int(11) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  `next_ref` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `uom`
-- ----------------------------
DROP TABLE IF EXISTS `uom`;
CREATE TABLE `uom` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `abbrev` varchar(25) DEFAULT NULL,
  `name` varchar(150) DEFAULT NULL,
  `inactive` tinyint(1) DEFAULT '0',
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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `voids`
-- ----------------------------
DROP TABLE IF EXISTS `voids`;
CREATE TABLE `voids` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trans_ref` varchar(255) DEFAULT NULL,
  `src_type` int(11) DEFAULT NULL,
  `src_id` int(11) DEFAULT NULL,
  `reason` varchar(250) DEFAULT NULL,
  `reg_date` datetime DEFAULT NULL,
  `reg_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records 
-- ----------------------------
INSERT INTO `academic_years` VALUES ('1','School Year 2016 - 2017','2016-06-06','2017-03-31','2016-06-23 08:31:03','1','0');
INSERT INTO `ci_sessions` VALUES ('30c689d22acdb4d1bb9d312e50e1e310','::1','Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.103 Safari/537.36','1469361841','a:3:{s:9:\"user_data\";s:0:\"\";s:4:\"user\";a:11:{s:2:\"id\";s:1:\"1\";s:8:\"username\";s:5:\"admin\";s:5:\"fname\";s:3:\"Rey\";s:5:\"lname\";s:8:\"Reynalds\";s:5:\"mname\";s:0:\"\";s:6:\"suffix\";s:0:\"\";s:9:\"full_name\";s:14:\"Rey  Reynalds \";s:7:\"role_id\";s:1:\"1\";s:4:\"role\";s:14:\"Administrator \";s:6:\"access\";s:3:\"all\";s:3:\"img\";s:43:\"http://localhost/sch007/uploads/users/1.png\";}s:7:\"company\";a:6:{s:12:\"comp_address\";s:50:\"1013 Emerald Bldg. Barangay San Antonio Pasig City\";s:15:\"comp_contact_no\";s:13:\"(02) 887 9643\";s:10:\"comp_email\";s:15:\"email@email.com\";s:9:\"comp_logo\";s:24:\"uploads/company/logo.png\";s:9:\"comp_name\";s:18:\"Kidscoco Preschool\";s:8:\"comp_tin\";s:15:\"000-888-888-888\";}}');
INSERT INTO `courses` VALUES ('1','COURSE0001','Nursery','Nursery','2016-07-24 19:41:21','1','0');
INSERT INTO `course_batches` VALUES ('1','NURBAT0001','Nursery 2016 - 2017','1','2016-06-06','2017-04-30','2016-07-24 19:43:54','1');
INSERT INTO `course_batch_schedules` VALUES ('5','1','1','1','2','6','Mon','11:00:00','12:00:00'), ('6','1','1','1','2','4','Mon','10:00:00','11:00:00'), ('7','1','1','1','2','1','Mon','14:00:00','15:00:00'), ('8','1','1','1','2','2','Mon','13:00:00','14:00:00'), ('9','1','1','1','2','5','Tue','10:00:00','11:00:00'), ('10','1','1','1','2','1','Tue','11:00:00','12:00:00'), ('11','1','1','1','2','3','Tue','13:00:00','14:00:00'), ('12','1','1','1','2','4','Tue','14:00:00','15:00:00'), ('13','1','1','1','2','6','Wed','11:00:00','12:00:00'), ('14','1','1','1','2','4','Wed','10:00:00','11:00:00'), ('15','1','1','1','2','1','Wed','14:00:00','15:00:00'), ('16','1','1','1','2','2','Wed','13:00:00','14:00:00'), ('17','1','1','1','2','5','Thu','10:00:00','11:00:00'), ('18','1','1','1','2','1','Thu','11:00:00','12:00:00'), ('19','1','1','1','2','3','Thu','13:00:00','14:00:00'), ('20','1','1','1','2','4','Thu','14:00:00','15:00:00'), ('21','1','1','1','2','6','Fri','11:00:00','12:00:00'), ('22','1','1','1','2','4','Fri','10:00:00','11:00:00'), ('23','1','1','1','2','1','Fri','14:00:00','15:00:00'), ('24','1','1','1','2','2','Fri','13:00:00','14:00:00');
INSERT INTO `course_batch_sections` VALUES ('1','1','1','2');
INSERT INTO `course_items` VALUES ('1','1','1','1'), ('2','1','2','1');
INSERT INTO `course_subjects` VALUES ('1','1','1'), ('2','1','2'), ('3','1','3'), ('4','1','4'), ('5','1','5'), ('6','1','6');
INSERT INTO `enrolls` VALUES ('1','ENR0001','1','1','1','1','2016-06-06','2017-05-06','3','11','5','181500','2016-07-24','2016-07-24 19:59:59','1','0');
INSERT INTO `enroll_items` VALUES ('1','1','1','1','unit','15000','0'), ('2','1','2','1','unit','1500','0');
INSERT INTO `enroll_payments` VALUES ('1','1','1','dp','16500','2016-06-05','16500','2016-07-24'), ('2','1','1','month','16500','2016-07-05','0',NULL), ('3','1','1','month','16500','2016-08-05','0',NULL), ('4','1','1','month','16500','2016-09-05','0',NULL), ('5','1','1','month','16500','2016-10-05','0',NULL), ('6','1','1','month','16500','2016-11-05','0',NULL), ('7','1','1','month','16500','2016-12-05','0',NULL), ('8','1','1','month','16500','2017-01-05','0',NULL), ('9','1','1','month','16500','2017-02-05','0',NULL), ('10','1','1','month','16500','2017-03-05','0',NULL), ('11','1','1','month','16500','2017-04-05','0',NULL);
INSERT INTO `enroll_subjects` VALUES ('1','1','1'), ('2','1','2'), ('3','1','3'), ('4','1','4'), ('5','1','5'), ('6','1','6');
INSERT INTO `images` VALUES ('1','2.png','uploads/users/2.png','2','users',NULL,'2016-02-12 08:23:10','0'), ('5','1.png','uploads/users/1.png','1','users',NULL,'2016-02-12 08:30:45','0'), ('25','1.png','uploads/students/1.png','1','students',NULL,'2016-07-24 19:54:00','0'), ('26','2.png','uploads/students/2.png','2','students',NULL,'2016-07-24 19:55:17','0'), ('27','3.png','uploads/students/3.png','3','students',NULL,'2016-07-24 19:56:31','0'), ('28','4.png','uploads/students/4.png','4','students',NULL,'2016-07-24 19:58:27','0');
INSERT INTO `items` VALUES ('1','ITEM0001','Nursery Tuition Fee','Nursery Tuition Fee','unit','15000','1','service','1','0','2016-07-24 19:40:00','1'), ('2','ITEM0002','Lunch Fee','Lunch Fee','unit','1500','1','service','1','0','2016-07-24 19:40:26','1');
INSERT INTO `item_categories` VALUES ('1','Fees','unit','service','1','0'), ('2','Books','pc','inventory','1','0');
INSERT INTO `payments` VALUES ('1','PAY0001','1','2016-07-24','16500','Test','2016-07-24 20:01:05','1','0');
INSERT INTO `payment_details` VALUES ('1','1','cash','13000','','','','',NULL), ('2','2','cash','13000','','','','',NULL), ('3','3','cash','13000','','','','',NULL), ('4','1','cash','16500','','','','',NULL);
INSERT INTO `payment_for` VALUES ('1','1','10','1','1','13000'), ('2','2','10','2','5','13000'), ('3','3','10','3','8','13000'), ('4','1','10','1','1','16500');
INSERT INTO `payment_terms` VALUES ('1','Whole Payment','25000','0','5','1','0','1','5','0','2016-07-01 16:55:39','1'), ('2','Quarterly Payment','25000','0','5','1','0','4','5','0','2016-07-01 16:57:13','1'), ('3','Monthly Payment','0','0','0','0','1','0','5','0','2016-07-01 16:57:38','1');
INSERT INTO `sections` VALUES ('1','SECTION01','Nursery','2016-07-24 19:43:02','1');
INSERT INTO `settings` VALUES ('comp_address','company','1013 Emerald Bldg. Barangay San Antonio Pasig City'), ('comp_contact_no','company','(02) 887 9643'), ('comp_email','company','email@email.com'), ('comp_logo','company','uploads/company/logo.png'), ('comp_name','company','Kidscoco Preschool'), ('comp_tin','company','000-888-888-888');
INSERT INTO `students` VALUES ('1','1','STD0001','Yung Do','','Choi','','male','','2011-01-14',NULL,'Korean','Korean, English','','','','','','','0','2016-07-24 19:53:47','1'), ('2',NULL,'STD0002','Eun Sang','','Cha','','female','','2011-05-06',NULL,'Korean','Korean, English','','','','','','','0','2016-07-24 19:55:11','1'), ('3',NULL,'STD0003','Ji Yun','','Han','','male','','2011-06-01',NULL,'Korean','Korean, English','','','','','','','0','2016-07-24 19:56:28','1'), ('4',NULL,'STD0004','Eva','','Kim','','female','','2011-08-03',NULL,'Filipino Korean','Korean, English','','','','','','','0','2016-07-24 19:58:00','1');
INSERT INTO `subjects` VALUES ('1','SUBJNUR0001','Nursery Phonnics','Nursery Phonnics','2016-07-24 19:36:01','1'), ('2','SUBJNUR0002','Nursery Math','Math for Nursery','2016-07-24 19:36:18','1'), ('3','SUBJNUR0003','Nursery Science','Science for Nursery','2016-07-24 19:36:42','1'), ('4','SUBJNUR0004','Nursery Writing','Writing for Nursery','2016-07-24 19:36:56','1'), ('5','SUBJNUR0005','Nursery KidsBrown','KidsBrown for Nursery','2016-07-24 19:37:33','1'), ('6','SUBJNUR0006','Nursery P.E.','P.E. for Nursery','2016-07-24 19:37:56','1');
INSERT INTO `tax_types` VALUES ('1','VAT','12'), ('2','NON-VAT','0');
INSERT INTO `trans_refs` VALUES ('1','1','STD0001','1',NULL), ('2','1','STD0002','1',NULL), ('3','1','STD0003','1',NULL), ('4','1','STD0004','1',NULL), ('5','10','ENR0001','1',NULL), ('6','20','PAY0001','1',NULL);
INSERT INTO `trans_types` VALUES ('1','Student Code','STD0005'), ('10','Enrollment','ENR0002'), ('20','Payment','PAY0002'), ('99','Void','VOD0001');
INSERT INTO `uom` VALUES ('1','pc','Piece','0'), ('2','unit','Unit','0');
INSERT INTO `users` VALUES ('1','admin','5f4dcc3b5aa765d61d8327deb882cf99','Rey','','Reynalds','','1','rey.tejada01@gmail.com','0917-555-06-82','2014-06-16 14:41:31','0'), ('2','karlene','5f4dcc3b5aa765d61d8327deb882cf99','Karlene','','Haber','','10','email@email.com','1234567','2016-02-12 08:32:05','0');
INSERT INTO `user_roles` VALUES ('1','Administrator ','System Administrator','all'), ('10','Teacher','Teacher','dashboard,class_record,cr_attendance,cr_activities'), ('20','Principal','Principal','control,users,roles');
INSERT INTO `voids` VALUES ('1','VOD0001','10','2','Yes','2016-07-08 13:55:22','1'), ('2','VOD0001','10','1','test','2016-07-08 20:22:06','1');

/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 5.7.14 : Database - sir
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `app_statuses` */

DROP TABLE IF EXISTS `app_statuses`;

CREATE TABLE `app_statuses` (
  `status_id` int(11) NOT NULL AUTO_INCREMENT,
  `status_` varchar(50) NOT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `app_statuses` */

insert  into `app_statuses`(`status_id`,`status_`) values (1,'Active'),(2,'Not Active');

/*Table structure for table `ci_sessions` */

DROP TABLE IF EXISTS `ci_sessions`;

CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `ci_sessions` */

insert  into `ci_sessions`(`id`,`ip_address`,`timestamp`,`data`) values ('p3hjj267uluqnjhajcdpgspj5m1u33qg','::1',1521209727,'__ci_last_regenerate|i:1521209461;user_id|s:1:\"1\";first_name|s:6:\"Jerome\";middle_name|s:0:\"\";last_name|s:6:\"Bailey\";email_address|s:23:\"bailey.jerome@gmail.com\";gender_id|s:1:\"1\";department_id|s:1:\"0\";dob|s:19:\"0000-00-00 00:00:00\";status_id|s:1:\"1\";user_password|s:60:\"$2y$12$UL6BVrMbPmAhK9fbWg.xyORLIydIeMJno4A7V9.A7zkKN5he4Blu2\";encrypted_user_id|s:88:\"eB0S0XgTYBTJG7P3FvWuYEcGn+5L3+ABQZtBuki67air2nzTKmVhvjUyBgepPhLKnNCJOWyD2l+aTPxNY6gWfQ==\";'),('430u3gthc5rjvfl5gbiqbqfa8ih01t3o','::1',1521209862,'__ci_last_regenerate|i:1521209862;user_id|s:1:\"1\";first_name|s:6:\"Jerome\";middle_name|s:0:\"\";last_name|s:6:\"Bailey\";email_address|s:23:\"bailey.jerome@gmail.com\";gender_id|s:1:\"1\";department_id|s:1:\"0\";dob|s:19:\"0000-00-00 00:00:00\";status_id|s:1:\"1\";user_password|s:60:\"$2y$12$UL6BVrMbPmAhK9fbWg.xyORLIydIeMJno4A7V9.A7zkKN5he4Blu2\";encrypted_user_id|s:88:\"eB0S0XgTYBTJG7P3FvWuYEcGn+5L3+ABQZtBuki67air2nzTKmVhvjUyBgepPhLKnNCJOWyD2l+aTPxNY6gWfQ==\";'),('kkecodk9onnb3jseqjqpg5d024q15n6j','::1',1521210011,'__ci_last_regenerate|i:1521210011;'),('t1kq6qkj9u8ii8rmhulaiublicjpms3j','::1',1521214896,'__ci_last_regenerate|i:1521214846;'),('llmkp16f19hri9cetcttrpnt7frrjkhk','::1',1521225625,'__ci_last_regenerate|i:1521225624;'),('dco3m35u590i77sladnj0p959uvjfo8e','::1',1521226264,'__ci_last_regenerate|i:1521226127;'),('5u3ocuhvrc1m9i7g396fgi605g5ff1u1','::1',1521226586,'__ci_last_regenerate|i:1521226572;user_id|s:1:\"1\";first_name|s:6:\"Jerome\";middle_name|s:0:\"\";last_name|s:6:\"Bailey\";email_address|s:23:\"bailey.jerome@gmail.com\";gender_id|s:1:\"1\";department_id|s:1:\"0\";dob|s:19:\"0000-00-00 00:00:00\";status_id|s:1:\"1\";user_password|s:60:\"$2y$12$UL6BVrMbPmAhK9fbWg.xyORLIydIeMJno4A7V9.A7zkKN5he4Blu2\";encrypted_user_id|s:88:\"bLihaEu8wubaBDG0KV4DbCBemhFZxZLxOFtxa+cUOROGxtFDEXJGqMdA7+jzg+53w6gvxJhkPcuFXxJIG6DQzw==\";'),('tjaa5le5t4h1vfkhv104igquhfo22913','::1',1521229089,'__ci_last_regenerate|i:1521229089;user_id|s:1:\"1\";first_name|s:6:\"Jerome\";middle_name|s:0:\"\";last_name|s:6:\"Bailey\";email_address|s:23:\"bailey.jerome@gmail.com\";gender_id|s:1:\"1\";department_id|s:1:\"0\";dob|s:19:\"0000-00-00 00:00:00\";status_id|s:1:\"1\";user_password|s:60:\"$2y$12$UL6BVrMbPmAhK9fbWg.xyORLIydIeMJno4A7V9.A7zkKN5he4Blu2\";encrypted_user_id|s:88:\"bLihaEu8wubaBDG0KV4DbCBemhFZxZLxOFtxa+cUOROGxtFDEXJGqMdA7+jzg+53w6gvxJhkPcuFXxJIG6DQzw==\";'),('c3g8mm58f8gf1urku3fj0va5uma6l8pi','::1',1521229627,'__ci_last_regenerate|i:1521229432;user_id|s:1:\"1\";first_name|s:6:\"Jerome\";middle_name|s:0:\"\";last_name|s:6:\"Bailey\";email_address|s:23:\"bailey.jerome@gmail.com\";gender_id|s:1:\"1\";department_id|s:1:\"0\";dob|s:19:\"0000-00-00 00:00:00\";status_id|s:1:\"1\";user_password|s:60:\"$2y$12$UL6BVrMbPmAhK9fbWg.xyORLIydIeMJno4A7V9.A7zkKN5he4Blu2\";encrypted_user_id|s:88:\"bLihaEu8wubaBDG0KV4DbCBemhFZxZLxOFtxa+cUOROGxtFDEXJGqMdA7+jzg+53w6gvxJhkPcuFXxJIG6DQzw==\";'),('ubj46ebnbk18c60t5ts23lm746tkpaem','::1',1521229770,'__ci_last_regenerate|i:1521229770;user_id|s:1:\"1\";first_name|s:6:\"Jerome\";middle_name|s:0:\"\";last_name|s:6:\"Bailey\";email_address|s:23:\"bailey.jerome@gmail.com\";gender_id|s:1:\"1\";department_id|s:1:\"0\";dob|s:19:\"0000-00-00 00:00:00\";status_id|s:1:\"1\";user_password|s:60:\"$2y$12$UL6BVrMbPmAhK9fbWg.xyORLIydIeMJno4A7V9.A7zkKN5he4Blu2\";encrypted_user_id|s:88:\"bLihaEu8wubaBDG0KV4DbCBemhFZxZLxOFtxa+cUOROGxtFDEXJGqMdA7+jzg+53w6gvxJhkPcuFXxJIG6DQzw==\";'),('h1uqun99fs9iat29epeb0e58relj01ge','::1',1521242264,'__ci_last_regenerate|i:1521242154;'),('09rvmacp9q5khldoh5kqhc73e2il6l2c','::1',1521312943,'__ci_last_regenerate|i:1521312679;'),('ednh91hoj69t29fnbdr7r3gms05mj5lr','::1',1521313511,'__ci_last_regenerate|i:1521313283;status_message|s:27:\"User was successfully added\";status_code|s:7:\"success\";'),('fvhsc00sqrqdbpuv5mvb98qstlrog562','::1',1521313885,'__ci_last_regenerate|i:1521313587;status_message|s:27:\"User was successfully added\";status_code|s:7:\"success\";'),('o971gjsvp0nmpfv76pi7c4avaih04cv5','::1',1521314217,'__ci_last_regenerate|i:1521313944;status_message|s:27:\"User was successfully added\";status_code|s:7:\"success\";'),('mptb0ldet42hg5cl6l91b3a9eutfq931','::1',1521314534,'__ci_last_regenerate|i:1521314262;status_message|s:27:\"User was successfully added\";status_code|s:7:\"success\";'),('fef0sf986c90i723qdl6209gvsdhd0gi','::1',1521314848,'__ci_last_regenerate|i:1521314574;status_message|s:27:\"User was successfully added\";status_code|s:7:\"success\";'),('4vr1kntu309u1pr2u0plakcv3tsrj842','::1',1521315072,'__ci_last_regenerate|i:1521314887;'),('el194bnej97bm7dpac5s79ur41h44q7b','::1',1521315589,'__ci_last_regenerate|i:1521315315;'),('bt6da9eeqk6cqo5c08t3ihco1h29d03q','::1',1521319200,'__ci_last_regenerate|i:1521319200;'),('8ri86ep6s29v3ftkh0vkq24aq9vnspu1','::1',1521319717,'__ci_last_regenerate|i:1521319623;'),('euo3fov7c1qq3bck255otc8f6hhmv86c','127.0.0.1',1521405032,'__ci_last_regenerate|i:1521405031;'),('rvkci8djepol00qv2rougu3paua635ed','::1',1521415459,'__ci_last_regenerate|i:1521415184;'),('bes6efbmj736aedlojf8uc27760vqug0','::1',1521415558,'__ci_last_regenerate|i:1521415518;user_id|s:4:\"5292\";first_name|s:6:\"Jerome\";last_name|s:6:\"Bailey\";email_address|s:23:\"bailey.jerome@gmail.com\";gender_id|s:1:\"1\";department_id|s:1:\"0\";job_title_id|s:1:\"0\";dob|s:19:\"1980-01-01 00:00:00\";status_id|s:1:\"1\";user_password|s:60:\"$2y$12$UL6BVrMbPmAhK9fbWg.xyORLIydIeMJno4A7V9.A7zkKN5he4Blu2\";encrypted_user_id|s:88:\"4tddyHSyLsHAiN0+K/HFn74v2msuwyTJBYwHkyx67Fax9m6edi5obn8kidRN/VwrGh09rK8c7sXPuyu9uLdkXw==\";'),('lr7cpt61jeqld3f1t6e8esnnadiij6t4','::1',1521417335,'__ci_last_regenerate|i:1521417110;user_id|s:4:\"5292\";first_name|s:6:\"Jerome\";last_name|s:6:\"Bailey\";email_address|s:23:\"bailey.jerome@gmail.com\";gender_id|s:1:\"1\";department_id|s:1:\"0\";job_title_id|s:1:\"0\";dob|s:19:\"1980-01-01 00:00:00\";status_id|s:1:\"1\";user_password|s:60:\"$2y$12$UL6BVrMbPmAhK9fbWg.xyORLIydIeMJno4A7V9.A7zkKN5he4Blu2\";encrypted_user_id|s:88:\"pXGkshRo4Q9H/OtwBxPuOwurJX8AZkKKt0j88CdoNczNUJk4mlqToiuN04VG6vr0l4ZjJ8b5iZdsgbFIm5VY5w==\";logged_in|i:1;'),('br5okl8ad153no9j653dbijcb4qbr1s7','::1',1521417679,'__ci_last_regenerate|i:1521417679;user_id|s:4:\"5292\";first_name|s:6:\"Jerome\";last_name|s:6:\"Bailey\";email_address|s:23:\"bailey.jerome@gmail.com\";gender_id|s:1:\"1\";department_id|s:1:\"0\";job_title_id|s:1:\"0\";dob|s:19:\"1980-01-01 00:00:00\";status_id|s:1:\"1\";user_password|s:60:\"$2y$12$UL6BVrMbPmAhK9fbWg.xyORLIydIeMJno4A7V9.A7zkKN5he4Blu2\";encrypted_user_id|s:88:\"pXGkshRo4Q9H/OtwBxPuOwurJX8AZkKKt0j88CdoNczNUJk4mlqToiuN04VG6vr0l4ZjJ8b5iZdsgbFIm5VY5w==\";logged_in|i:1;'),('ilp9md101t3uls2jg6v75tro9te5fm7p','::1',1521418649,'__ci_last_regenerate|i:1521418637;user_id|s:4:\"5292\";first_name|s:6:\"Jerome\";last_name|s:6:\"Bailey\";email_address|s:23:\"bailey.jerome@gmail.com\";gender_id|s:1:\"1\";department_id|s:1:\"0\";job_title_id|s:1:\"0\";dob|s:19:\"1980-01-01 00:00:00\";status_id|s:1:\"1\";user_password|s:60:\"$2y$12$UL6BVrMbPmAhK9fbWg.xyORLIydIeMJno4A7V9.A7zkKN5he4Blu2\";logged_in|i:1;encrypted_user_id|s:88:\"xuTnxrRAheMJjelwGCQLMxDRI+SMFtdjqLNPB9dBWUFxKh3ijUVGXoqyXc51LXFEUEPK/nvMriQ0z+GVxogsEw==\";'),('v4k2a0pqs6jqje7v7srd5phbmlsdkreh','::1',1521419051,'__ci_last_regenerate|i:1521419051;');

/*Table structure for table `contact_info_types` */

DROP TABLE IF EXISTS `contact_info_types`;

CREATE TABLE `contact_info_types` (
  `contact_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`contact_type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `contact_info_types` */

/*Table structure for table `departments` */

DROP TABLE IF EXISTS `departments`;

CREATE TABLE `departments` (
  `department_id` int(11) NOT NULL AUTO_INCREMENT,
  `department_name` varchar(300) NOT NULL,
  PRIMARY KEY (`department_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `departments` */

insert  into `departments`(`department_id`,`department_name`) values (1,'Operation'),(2,'Production'),(3,'Sanitation/Operations'),(4,'Administration'),(5,'Quality'),(6,'Stores');

/*Table structure for table `emails` */

DROP TABLE IF EXISTS `emails`;

CREATE TABLE `emails` (
  `email_id` int(11) NOT NULL AUTO_INCREMENT,
  `email_subject` varchar(400) DEFAULT NULL,
  `email_body` text,
  PRIMARY KEY (`email_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `emails` */

insert  into `emails`(`email_id`,`email_subject`,`email_body`) values (1,'Verify your email address','<p>\r\n	<strong>Hi {firstname},</strong></p>\r\n<p>\r\n	To complete your signup for ELIRA Ticketing, you must click on the link below to verify your email account.</p>\r\n<p>\r\n	{VerificationLink}</p>\r\n<p>\r\n	You can also copy and paste the link in your browser to complete the signup process.</p>\r\n<p>\r\n	You have 24hrs in which to verify your account. If you fail to do so within this timeframe, you will have to re-create your account.</p>\r\n\r\n\r\n<p>\r\n	Thanks,<br />\r\n	The ELIRA Ticketing Team<br />\r\n	www.elira-ticketing.com</p>\r\n\r\n\r\n\r\n\r\n'),(2,'Welcome to ELIRA Ticketing','<p>\r\n	<strong>Hi {FirstName},</strong></p>\r\n<p>\r\n	Thanks for signing up with MyDealsJa, Jamaica&#39;s premium bargain website!</p>\r\n<p>\r\n	{VerificationLink}</p>\r\n<p>\r\n	To complete the sign-up process please click on the hyperlink listed above.You can also copy and paste the link in your browser.</p>\r\n<p>\r\n	You have 24hrs in which to verify your account. If you fail to do so within this timeframe, you will have to re-create your account.</p>\r\n<p>\r\n	Each day, check your email, Facebook or Twitter feeds for details on deals from some of Jamaica&#39;s finest businesses and brands.</p>\r\n<p>\r\n	With one easy click, purchase your deal. Print your voucher, and take it to the retailer within the specified time frame, and enjoy your deal!</p>\r\n<p>\r\n	We look forward to providing you with more of the best deals in Jamaica.</p>\r\n<p>\r\n	Thank you,</p>\r\n<p>\r\n	The MyDealsJa Team</p>\r\n'),(4,'Reset my password','<p>\r\n	<strong>Hi {first_name},</strong></p>\r\n<p>\r\n	You have indicated that you want to reset your password. If you did not make this request, please ignore this email.</p>\r\n<p>\r\n	Please click on the link below to reset your password:<br />\r\n	<a href = \"{reset_password_link}\" target = \"_blank\">{reset_password_link}</a></p>\r\n<p>\r\n	Thanks,<br />\r\n	BEVERA<br />\r\n	<a href = \"bevera.jbwebstudios.com\" target = \"_blank\">bevera.jbwebstudios.com</a></p>\r\n'),(5,'Ticket for Event','<p>\r\n	<strong>Hi {first_name},</strong></p>\r\n<p>\r\n	Thank you for purchasing a ticket to <strong>{event_name}</strong>.</p>\r\n\r\n<p>Please find your ticket attached.</p>\r\n\r\n<p>\r\n	If there are any errors on your ticket, please click on the link below to correct it or ask the person who purchased it for you to make the correction:<br />\r\n	<a href = \"{ewe_login_link}\" target = \"_blank\">{ewe_login_link}</a></p>\r\n<p>&nbsp;</p>\r\n<p>\r\n	Regards,<br />\r\n	ELIRA Ticketing Team<br />\r\n	<a href = \"http://www.elira-ticketing.com\" target = \"_blank\">www.elira-ticketing.com</a></p>\r\n'),(6,'Your Event has been published','<p>\r\n	<strong>Hi {first_name},</strong></p>\r\n<p>\r\n	Thank you for choosing ELIRA!</p>\r\n<p>Your event <strong>{event_name}</strong> has been published and is now available in the mobile app or by clicking the link below.</p>\r\n\r\n<p>{link_to_event}</p>\r\n\r\n<p>&nbsp;</p>\r\n<p>\r\n	Regards,<br />\r\n	ELIRA Team<br />\r\n	<a href = \"elira.jbwebstudios.com\" target = \"_blank\">elira.jbwebstudios.com</a></p>\r\n');

/*Table structure for table `exceptions` */

DROP TABLE IF EXISTS `exceptions`;

CREATE TABLE `exceptions` (
  `_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `exception` text NOT NULL,
  `date_occured` datetime NOT NULL,
  PRIMARY KEY (`_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `exceptions` */

/*Table structure for table `genders` */

DROP TABLE IF EXISTS `genders`;

CREATE TABLE `genders` (
  `gender_id` int(11) NOT NULL AUTO_INCREMENT,
  `gender` varchar(10) NOT NULL,
  PRIMARY KEY (`gender_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `genders` */

insert  into `genders`(`gender_id`,`gender`) values (1,'Male'),(2,'Female');

/*Table structure for table `job_titles` */

DROP TABLE IF EXISTS `job_titles`;

CREATE TABLE `job_titles` (
  `job_title_id` int(11) NOT NULL AUTO_INCREMENT,
  `job_title` varchar(300) NOT NULL,
  PRIMARY KEY (`job_title_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

/*Data for the table `job_titles` */

insert  into `job_titles`(`job_title_id`,`job_title`) values (1,'Driver/Loader'),(2,'Sous Chef'),(3,'Cook'),(4,'Janitor'),(5,'Operations Supervisor'),(6,'Operations Admin. Assistant'),(7,'Administration Assisistant'),(8,'Head Chef'),(9,'General Manager'),(10,'Billing Clerk'),(11,'Purchasing Officer'),(12,'Store Keeper'),(13,'Pastry Cook'),(14,'Quality Officer');

/*Table structure for table `login_log` */

DROP TABLE IF EXISTS `login_log`;

CREATE TABLE `login_log` (
  `_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `login_date` datetime DEFAULT NULL,
  PRIMARY KEY (`_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `login_log` */

insert  into `login_log`(`_id`,`user_id`,`login_date`) values (1,5292,'2018-03-19 12:13:46'),(2,5292,'2018-03-18 07:17:29');

/*Table structure for table `measurement_units` */

DROP TABLE IF EXISTS `measurement_units`;

CREATE TABLE `measurement_units` (
  `unit_id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_name` varchar(100) NOT NULL,
  `unit_abbreviation` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`unit_id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

/*Data for the table `measurement_units` */

insert  into `measurement_units`(`unit_id`,`unit_name`,`unit_abbreviation`) values (1,'Kilogram ','Kg'),(2,'Gram','g'),(3,'Milligram','mg'),(4,'Quintal','qt'),(5,'Tonne','t'),(6,'Liter','l'),(7,'Milliliter','ml'),(8,'Barrel','bbl'),(9,'Gallon','gl'),(10,'Teaspoon','ts'),(11,'Box','bx'),(12,'Bag','bg'),(13,'Case','cs'),(14,'Pound','lb'),(15,'Jar','jr'),(16,'Grain','gn'),(17,'Dozen','dz'),(18,'Carton','ct'),(19,'Can','cn'),(20,'Bottle','bt'),(21,'Pack','pk'),(22,'Package','pa'),(23,'Unit','ut');

/*Table structure for table `minimum_product_stock_levels` */

DROP TABLE IF EXISTS `minimum_product_stock_levels`;

CREATE TABLE `minimum_product_stock_levels` (
  `product_id` int(11) NOT NULL,
  `minimum_stock_level` double NOT NULL,
  `unit_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `minimum_product_stock_levels` */

/*Table structure for table `permission_groups` */

DROP TABLE IF EXISTS `permission_groups`;

CREATE TABLE `permission_groups` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(300) NOT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `permission_groups` */

insert  into `permission_groups`(`group_id`,`group_name`) values (1,'SuperAdministrator'),(2,'Administrator');

/*Table structure for table `permissions` */

DROP TABLE IF EXISTS `permissions`;

CREATE TABLE `permissions` (
  `permission_id` int(11) NOT NULL AUTO_INCREMENT,
  `permission` varchar(500) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`permission_id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=latin1;

/*Data for the table `permissions` */

insert  into `permissions`(`permission_id`,`permission`,`description`) values (1,'view_requests',NULL),(2,'submit_request','Submit requests via form'),(3,'view_logs',NULL),(4,'assign_employee_to_stage','Assigns an employee to the procurement stage'),(5,'view_job_titles',NULL),(6,'add_job_title',NULL),(7,'edit_job_title',NULL),(8,'delete_job_title',NULL),(9,'view_procurement_stages',NULL),(10,'add_procurement_stage',NULL),(11,'edit_procurement_stage',NULL),(12,'delete_procurement_stage',NULL),(13,'view_courts',NULL),(14,'add_court',NULL),(15,'edit_court',NULL),(16,'delete_court',NULL),(17,'view_reports',NULL),(18,'add_report',NULL),(19,'edit_report',NULL),(20,'delete_report',NULL),(21,'view_users',NULL),(22,'add_user',NULL),(23,'edit_user',NULL),(24,'delete_user',NULL),(25,'view_procurement_item_types',NULL),(26,'add_procurement_item_type',NULL),(27,'edit_procurement_item_type',NULL),(28,'delete_procurement_item_type',NULL),(29,'view_authorizing_officers',NULL),(30,'add_authorizing_officer',NULL),(31,'edit_authorizing_officer',NULL),(32,'delete_authorizing_officer',NULL),(33,'view_user_permissions',NULL),(34,'add_user_permission',NULL),(35,'edit_user_permission',NULL),(36,'delete_user_permission',NULL),(37,'view_user_rating_groups',NULL),(38,'add_user_rating_group',NULL),(39,'edit_user_rating_group',NULL),(40,'delete_user_rating_group',NULL),(41,'dispatch_to_tax_office_for_zero_rating',NULL),(42,'dispatch_to_finance_and_accounts_for_commitment',NULL),(43,'cheque_availability_information',NULL),(44,'return_to_finance_and_accounts_for_payment_information',NULL),(45,'insert_commitment_information',NULL),(46,'cheques_dispatchment',NULL),(47,'authorize_approve_request',NULL),(48,'add_notes',NULL),(49,'view_notes',NULL),(50,'add_attachments',NULL),(51,'view_attachments',NULL),(52,'assign_user_permissions',NULL),(53,'view_administrators',NULL),(54,'approve_request',NULL),(55,'add_reference_checque_no',NULL),(56,'view_departments',NULL),(57,'add_department',NULL),(58,'edit_department',NULL),(59,'delete_department',NULL),(60,'view_rejected_requests',NULL),(61,'view_stopped_requests',NULL),(62,'rollback_request',NULL),(63,'place_stop_order_on_request',NULL),(64,'view_requests_with_goods_in_stock',NULL),(65,'reject_request','reject_request'),(66,'make_request_invalid','Request is Invalid!');

/*Table structure for table `product_categories` */

DROP TABLE IF EXISTS `product_categories`;

CREATE TABLE `product_categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(200) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `product_categories` */

/*Table structure for table `product_product_categories` */

DROP TABLE IF EXISTS `product_product_categories`;

CREATE TABLE `product_product_categories` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `product_product_categories` */

/*Table structure for table `product_stock_levels` */

DROP TABLE IF EXISTS `product_stock_levels`;

CREATE TABLE `product_stock_levels` (
  `product_id` int(11) NOT NULL,
  `current_stock_level` double NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `product_stock_levels` */

/*Table structure for table `products` */

DROP TABLE IF EXISTS `products`;

CREATE TABLE `products` (
  `product_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `barcode` text,
  `product_category_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `products` */

insert  into `products`(`product_id`,`product_name`,`description`,`barcode`,`product_category_id`) values (1,'Product A','Product A',NULL,0),(2,'Product B','Product B',NULL,0),(3,'Product C','Product C',NULL,0),(4,'Product D','Product D',NULL,0),(5,'Product E','Product E',NULL,0);

/*Table structure for table `sir_log` */

DROP TABLE IF EXISTS `sir_log`;

CREATE TABLE `sir_log` (
  `log_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `log_action_id` int(11) NOT NULL,
  `action_taken_by_employee_id` int(11) NOT NULL,
  `old_data` text,
  `new_data` text,
  `action_taken_on` datetime NOT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `sir_log` */

/*Table structure for table `sir_settings` */

DROP TABLE IF EXISTS `sir_settings`;

CREATE TABLE `sir_settings` (
  `settings_id` int(11) NOT NULL AUTO_INCREMENT,
  `settings_name` varchar(500) NOT NULL,
  `settings_value` varchar(500) NOT NULL,
  PRIMARY KEY (`settings_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `sir_settings` */

/*Table structure for table `sir_users` */

DROP TABLE IF EXISTS `sir_users`;

CREATE TABLE `sir_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(200) NOT NULL,
  `last_name` varchar(200) NOT NULL,
  `email_address` varchar(100) DEFAULT NULL,
  `gender_id` int(11) DEFAULT NULL,
  `department_id` int(11) NOT NULL,
  `job_title_id` int(11) NOT NULL,
  `dob` datetime DEFAULT NULL,
  `status_id` int(10) unsigned DEFAULT NULL,
  `user_password` varchar(500) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5293 DEFAULT CHARSET=latin1;

/*Data for the table `sir_users` */

insert  into `sir_users`(`user_id`,`first_name`,`last_name`,`email_address`,`gender_id`,`department_id`,`job_title_id`,`dob`,`status_id`,`user_password`) values (5292,'Jerome','Bailey','bailey.jerome@gmail.com',1,0,0,'1980-01-01 00:00:00',1,'$2y$12$UL6BVrMbPmAhK9fbWg.xyORLIydIeMJno4A7V9.A7zkKN5he4Blu2'),(8,'Sherman','Davis','',1,1,1,'0000-00-00 00:00:00',1,'$2y$12$vUbrDabsK1S4ene8DSJwAe8uV9RvJmH60UViL8PRJSQD3Dgu2oame'),(18,'Carlton','Moncrieffe','Carlton.moncrieffe@gcggroup.com',1,2,2,'0000-00-00 00:00:00',1,'$2y$12$S1/Ex6eObcsLMH7DWDFclOtjue04BRgLZ662fhf9m9tI7QTHH09fy'),(7,'Alenne','Bush','',2,2,3,'0000-00-00 00:00:00',1,'$2y$12$1zlNjmW4gvw73xj8w2S6eOyYEhpjzJLsMINSillrrS4ib7pfHHA3K'),(1,'Roger','Aleria','',1,1,1,'0000-00-00 00:00:00',1,'$2y$12$xI8DPRGiM0u5BX9fQ5cIQe5i8j4TIdb9Mt4Rmjiyi.48lfBZ.sHYS'),(10,'Carmen','Evans','',2,3,4,'0000-00-00 00:00:00',1,'$2y$12$F2APJFnYYVK3mg0o2OVkwOvTjVjKGTsErtSQ6oyPHw2HhSIMgA4hy'),(9,'Phillip','DeMercado','philip.demercado@gcggroup.com',1,1,5,'0000-00-00 00:00:00',1,'$2y$12$RZTjP7UB1DZSA4wC4cYGhOJ.VVBT5h5RTzISOLwp0ZRRyw3SNfiCG'),(16,'Sally','Lopez-Richards','',2,3,4,'0000-00-00 00:00:00',1,'$2y$12$lNS905Ru/XKJIA04LcsicuktE0Q45tgWfCXCvCNrDORwhE/MoRpuO'),(14,'Marcia','Leon','marcia.leon@gcggroup.com',1,1,6,'0000-00-00 00:00:00',1,'$2y$12$x4rZ32cl1.k.QvPenqrJheJ/w2Gm9vk7rG1bFWQGlX2cKlAmvyWQG'),(13,'Diane','Knowles','diane.knowles-stewart@gcggroup.com',2,4,7,'0000-00-00 00:00:00',1,'$2y$12$QFJO3SbJEWy2nxYLD4JtNeWj3KfvsUU1sev5ucfD/Z8qEv/V9oFOq'),(39,'Oscar ','Kirkconnell','',1,1,1,'0000-00-00 00:00:00',1,'$2y$12$Wk6vK9mkF6qtrppQ1ZbF1OZqzJrOgDRrrvh83njumAKajONyidqIK'),(40,'Rudi','Miller','rudi.miller@gcggroup.com',2,2,8,'0000-00-00 00:00:00',1,'$2y$12$PUFdUycRT0WVDrh5bQWZxO3PYgUvVfg2xDczX90Xys4srj.B24/de'),(23,'Anthony','Franklin','anthony.franklin@gcggroup.com',1,4,9,'0000-00-00 00:00:00',1,'$2y$12$XXqRfFuJZfeXbdBMzkf6VeTDRbUnGnSS01eKKJSz3pbYrkzjogmEG'),(15,'Pierre','Small','pierre.small@gcggroup.com',1,5,14,'0000-00-00 00:00:00',1,'$2y$12$/ixgkmbtcFaEV3g1yfdLbe.oyT.Ajj0q36ZWTbqv4N0sHefkh7wZK'),(6,'Christine','Beckford','christine.beckford@gcggroup.com',2,4,10,'0000-00-00 00:00:00',1,'$2y$12$8Ri3Pm8.JSfyk2YeAJYxA.U8ahe98dZcjbO05MYg7xABqUJhqp7ru'),(20,'Sashana','McField','',2,2,3,'0000-00-00 00:00:00',1,'$2y$12$qEcusociYh0uhkkgOVRaSOj8uoEkSJWvPwapD8n.Sb3QmOopH9r8W'),(19,'Rose','McPherson','',2,2,3,'0000-00-00 00:00:00',1,'$2y$12$6Wt2yCC3nG/q.joeIWwLd.XBHLxwCiHdtzNS6y214rZz2REBProIy'),(3,'Nadine','Bailey Rankine','',2,3,4,'0000-00-00 00:00:00',1,'$2y$12$AgAmIZH9EeuZW019BmYtY.UrPCbx5JVDzvwHRHtVnfRRToVdPhi5a'),(17,'Rodrick','Powell','',1,3,4,'0000-00-00 00:00:00',1,'$2y$12$z56y9xExgYn5EOWgGp2KqOVD3PKRmi207DHtV1OXqI.KYKC0r8LTu'),(25,'Gregory','Bell','gregory.bell@gcggroup.com',1,6,11,'0000-00-00 00:00:00',1,'$2y$12$rptMPWLZ/fgX8fBa9lycS.JdMSCIm5YF18nfe1zHKQ.SjsjZuPApq'),(31,'Roselyn','Seymour','',2,2,3,'0000-00-00 00:00:00',1,'$2y$12$8ceovXSvuD0ueoOicwyQReAf3GEwM/TKCuBNg59qTy8a42h299/rO'),(33,'Shelly-Ann','Hill','',2,6,12,'0000-00-00 00:00:00',1,'$2y$12$nhpIXsql4IAuFXmDetgH4ueDDa6PKv7fq2q3MeZPEnA78q7h9ED6a'),(42,'John','McField','',1,6,12,'0000-00-00 00:00:00',1,'$2y$12$AzW6Hq/jMjrzmFqjeraQSuB9CjZGxuLuuIdMl6ANOQF3dEC8z5mBS'),(37,'Troy','Brown','',1,1,1,'0000-00-00 00:00:00',1,'$2y$12$n56vkbb3clkZbg6zzYpXB.ubGEGo8ZtyUgBHcpEH3pYwVrKw3N382'),(38,'Clive','Carneiro','',1,2,3,'0000-00-00 00:00:00',1,'$2y$12$tnyXk/gmd0b4EyHbWIOJ9eNtA5nPMDLCo/vp8pVI.9J6LlQtMi3Cq'),(43,'Kennedy','Gomes','',1,2,13,'0000-00-00 00:00:00',1,'$2y$12$Kd/3usYtR82/B1cgbxZTEuPi/h9wnbdGB6urCAz9DfKDewCEGLjkO');

/*Table structure for table `supplier_contact_info` */

DROP TABLE IF EXISTS `supplier_contact_info`;

CREATE TABLE `supplier_contact_info` (
  `contact_info_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `supplier_id` int(11) NOT NULL,
  `contact_type_id` int(11) NOT NULL,
  `contact_type_value` varchar(100) NOT NULL,
  PRIMARY KEY (`contact_info_id`,`supplier_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `supplier_contact_info` */

/*Table structure for table `suppliers` */

DROP TABLE IF EXISTS `suppliers`;

CREATE TABLE `suppliers` (
  `supplier_id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_name` varchar(500) NOT NULL,
  `address_line_1` varchar(500) DEFAULT NULL,
  `address_line_2` varchar(500) DEFAULT NULL,
  `city` varchar(300) DEFAULT NULL,
  `state` varchar(300) DEFAULT NULL,
  `zip` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`supplier_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `suppliers` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

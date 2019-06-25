CREATE DATABASE
IF NOT EXISTS `testdatabase` DEFAULT CHARACTER
SET utf8
COLLATE utf8_general_ci;
USE `testdatabase`;

DROP TABLE IF EXISTS `user_data`;
CREATE TABLE `user_data` (
  `id` int(2) NOT NULL AUTOINCREMENT PRIMARY_KEY,
  `name` VARCHAR(80),
  `title` VARCHAR(80),
  `login` VARCHAR(8) NOT NULL,
  'modified_time' TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
);
ALTER TABLE `user_data` ADD UNIQUE(`login`);

INSERT INTO `user_data` VALUES (01, 'Nancy','Developer','devA'),(02,'Fred','Lead developer','devB'),(03,'Mort','SrDev','User'),(04,'Cathy','Office Manager','cathyr'),(05,'Ralph','IT director','ralphf');

DROP TABLE IF EXISTS `admin_users`;
CREATE TABLE `admin_users` (
  `id` int(2) NOT NULL AUTO_INCREMENT PRIMARY_KEY,
  `login` varchar(8) NOT NULL
);

INSERT INTO `admin_users` VALUES (01,'devA'),(02,'devB'),(03, 'User');

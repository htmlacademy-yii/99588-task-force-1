CREATE DATABASE taskforce CHARACTER SET utf8 COLLATE utf8_general_ci;

USE taskforce;

CREATE TABLE `profile` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `address` CHAR(128),
    `bd` DATE,
    `about` CHAR(255),
    `phone` CHAR(64),
    `skype` CHAR(64)
);

CREATE TABLE `city` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `city` CHAR(64),
    `lat` DOUBLE,
    `long` DOUBLE
);

CREATE TABLE `user` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `email` CHAR(64),
    `name` CHAR(64),
    `password` CHAR(255),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `rate` TINYINT,
    `city_id` INT,
    `profiles_id` INT,
    FOREIGN KEY (city_id)  REFERENCES `city` (id),
    FOREIGN KEY (profiles_id)  REFERENCES `profile` (id)
);

CREATE TABLE `category` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` CHAR(64),
    `icon` CHAR(64)
);

CREATE TABLE `task` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `category_id` INT,
    `description` CHAR(255),
    `expire` DATE,
    `name` CHAR(64),
    `address` CHAR(128),
    `budget` INT,
    `lat` DOUBLE,
    `long` DOUBLE,
    `status`  CHAR(64),
    `employer_id` INT,
    `executor_id` INT,
    `city_id` INT,
    FOREIGN KEY (category_id)  REFERENCES `category` (id),
    FOREIGN KEY (employer_id)  REFERENCES `user` (id),
    FOREIGN KEY (executor_id)  REFERENCES `user` (id),
    FOREIGN KEY (city_id)  REFERENCES `city` (id)
);

CREATE TABLE `response` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `created_at` DATETIME,
    `rate` TINYINT,
    `description` CHAR(255),
    `budget` INT,
    `user_id` INT,
    `task_id` INT,
    FOREIGN KEY (user_id)  REFERENCES `user` (id),
    FOREIGN KEY (task_id)  REFERENCES `task` (id)
);

CREATE TABLE `feedback` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `created_at` DATETIME,
    `rate` TINYINT,
    `description` CHAR(255),
    `user_id` INT,
    `task_id` INT,
    FOREIGN KEY (user_id)  REFERENCES `user` (id),
    FOREIGN KEY (task_id)  REFERENCES `task` (id)
);

CREATE TABLE `file` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` CHAR(128),
    `user_id` INT,
    `task_id` INT,
    FOREIGN KEY (user_id)  REFERENCES `user` (id),
    FOREIGN KEY (task_id)  REFERENCES `task` (id)
);

CREATE TABLE `available_notification_type` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT,
    `notification_type` CHAR(64),
    FOREIGN KEY (user_id)  REFERENCES `user` (id)
);

CREATE TABLE `notification` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `text` CHAR(255),
    `notification_type` CHAR(64),
    `user_id` INT,
    FOREIGN KEY (user_id)  REFERENCES `user` (id)
);

CREATE TABLE `massage` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `text` CHAR(255),
    `sender_id` INT,
    `recipient_id` INT,
    FOREIGN KEY (sender_id)  REFERENCES `user` (id),
    FOREIGN KEY (recipient_id)  REFERENCES `user` (id)
);

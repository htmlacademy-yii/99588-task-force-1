CREATE DATABASE taskforce CHARACTER SET utf8 COLLATE utf8_general_ci;

USE taskforce;

CREATE TABLE `user` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `email` CHAR(64),
    `name` CHAR(64),
    `password` CHAR(255),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `rate` TINYINT,
    `city_id` INT,
    `profiles_id` INT
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
    `city_id` INT
);

CREATE TABLE `response` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `created_at` DATETIME,
    `rate` TINYINT,
    `description` CHAR(255),
    `budget` INT,
    `user_id` INT,
    `task_id` INT
);

CREATE TABLE `profile` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `address` CHAR(128),
    `bd` DATE,
    `about` CHAR(255),
    `phone` CHAR(64),
    `skype` CHAR(64)
);

CREATE TABLE `feedback` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `created_at` DATETIME,
    `rate` TINYINT,
    `description` CHAR(255),
    `user_id` INT,
    `task_id` INT
);

CREATE TABLE `city` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `city` CHAR(64),
    `lat` DOUBLE,
    `long` DOUBLE
);

CREATE TABLE `category` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` CHAR(64),
    `icon` CHAR(64)
);

CREATE TABLE `file` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` CHAR(128),
    `user_id` INT,
    `task_id` INT
);

CREATE TABLE `available_notification_type` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT,
    `notification_type` CHAR(64)
);

CREATE TABLE `notification` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `text` CHAR(255),
    `notification_type` CHAR(64)
);

CREATE TABLE `massage` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `text` CHAR(255),
    `sender_id` INT,
    `recipient_id` INT
);
